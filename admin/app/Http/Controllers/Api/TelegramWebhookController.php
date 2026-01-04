<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_Api;
use App\Models\GameList;
use App\Models\GameCategory;
use App\Models\Api;
use App\Models\Usersmoney;
use App\Models\SystemConfig;
use App\Models\GameRecord;
use App\Models\Recharge;
use App\Models\Withdraw;
use Illuminate\Support\Facades\DB;
use App\Services\TelegramBotService;
use App\Services\TronUsdtService;
use App\Services\DpService;
use App\Services\TgService;
use App\Services\PussyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TelegramWebhookController extends Controller
{
    protected $telegramBot;
    protected $dpService;
    protected $tgService;
    protected $pussyService;

    public function __construct()
    {
        $this->telegramBot = new TelegramBotService();
        $this->dpService = new DpService();
        $this->tgService = new TgService();
        $this->pussyService = new PussyService();
    }
    
    /**
     * 初始化Bot命令菜单（设置/start命令在输入框左侧常驻显示）
     * 使用缓存确保只设置一次，避免重复调用API
     */
    protected function initializeBotCommands()
    {
        $cacheKey = 'telegram_bot_commands_initialized_v2';

        // 检查是否已经设置过（缓存24小时）
        if (!Cache::has($cacheKey)) {
            // 设置命令列表
            $commands = [
                ['command' => 'start', 'description' => '开始使用 🏠'],
                ['command' => 'help', 'description' => '寻求帮助 🏃'],
            ];
            $result = $this->telegramBot->setMyCommands($commands);

            // 设置 Menu Button 为命令模式（显示命令列表）
            $menuResult = $this->telegramBot->setChatMenuButton('commands');

            if ($result['code'] == 200 && $menuResult['code'] == 200) {
                // 设置成功后缓存24小时
                Cache::put($cacheKey, true, now()->addHours(24));
                Log::info('Bot命令菜单和Menu Button设置成功');
            } else {
                Log::warning('Bot设置失败', ['commands_result' => $result, 'menu_result' => $menuResult]);
            }
        }
    }

    /**
     * 处理Telegram Webhook
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function webhook(Request $request)
    {
        // 使用文件直接写入日志，确保即使Log facade失败也能记录
        $logFile = storage_path('logs/telegram_webhook.log');
        $logEntry = date('Y-m-d H:i:s') . ' === Telegram Webhook 开始处理 ===' . PHP_EOL;
        $logEntry .= 'Method: ' . $request->method() . PHP_EOL;
        $logEntry .= 'IP: ' . $request->ip() . PHP_EOL;
        $logEntry .= 'User-Agent: ' . ($request->userAgent() ?? 'N/A') . PHP_EOL;
        $logEntry .= 'Content-Length: ' . ($request->header('Content-Length') ?? 'N/A') . PHP_EOL;
        $logEntry .= 'Raw Input: ' . $request->getContent() . PHP_EOL;
        $logEntry .= 'All Input: ' . json_encode($request->all(), JSON_UNESCAPED_UNICODE) . PHP_EOL;
        $logEntry .= '---' . PHP_EOL;
        @file_put_contents($logFile, $logEntry, FILE_APPEND);
        
        // 立即记录请求，确保即使后续出错也能看到日志
        try {
            Log::info('=== Telegram Webhook 开始处理 ===', [
                'timestamp' => date('Y-m-d H:i:s'),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'content_length' => $request->header('Content-Length'),
                'has_input' => $request->hasAny(['message', 'callback_query', 'update']),
                'raw_content' => substr($request->getContent(), 0, 500), // 限制长度避免日志过大
            ]);
        } catch (\Exception $logError) {
            // 如果Log facade失败，至少文件日志已经写入
            @file_put_contents($logFile, 'Log facade error: ' . $logError->getMessage() . PHP_EOL, FILE_APPEND);
        }
        
        try {
            // 初始化Bot命令菜单（只在第一次或缓存过期时执行）
            try {
                $this->initializeBotCommands();
            } catch (\Throwable $initError) {
                // 初始化失败不应该阻止webhook处理
                $logFile = storage_path('logs/telegram_webhook.log');
                @file_put_contents($logFile, date('Y-m-d H:i:s') . ' === Bot命令初始化失败 ===' . PHP_EOL . 'Error: ' . $initError->getMessage() . PHP_EOL . '---' . PHP_EOL, FILE_APPEND);
            }
            
            $update = $request->all();
            Log::info('Telegram Webhook接收', [
                'request_all' => $update,
                'request_method' => $request->method(),
                'request_ip' => $request->ip(),
                'has_message' => isset($update['message']),
                'has_callback_query' => isset($update['callback_query']),
            ]);

            // 处理回调查询（按钮点击）
            if (isset($update['callback_query'])) {
                Log::info('处理回调查询', ['callback_query' => $update['callback_query']]);
                return $this->handleCallbackQuery($update['callback_query']);
            }

            // 处理消息
            if (isset($update['message'])) {
                Log::info('处理消息', ['message' => $update['message']]);
                $result = $this->handleMessage($update['message']);
                Log::info('消息处理完成', ['result' => $result]);
                return $result;
            }

            Log::warning('Telegram Webhook未找到消息或回调', ['update' => $update]);
            // 写入文件日志
            $logFile = storage_path('logs/telegram_webhook.log');
            @file_put_contents($logFile, date('Y-m-d H:i:s') . ' === 未找到消息或回调 ===' . PHP_EOL . 'Update: ' . json_encode($update, JSON_UNESCAPED_UNICODE) . PHP_EOL . '---' . PHP_EOL, FILE_APPEND);
            return response()->json(['ok' => true, 'message' => 'No message or callback found']);
        } catch (\Throwable $e) {
            // 同时写入文件日志和Laravel日志（使用Throwable捕获所有错误，包括Fatal Error）
            $logFile = storage_path('logs/telegram_webhook.log');
            $errorLog = date('Y-m-d H:i:s') . ' === Telegram Webhook 异常 ===' . PHP_EOL;
            $errorLog .= 'Error: ' . $e->getMessage() . PHP_EOL;
            $errorLog .= 'File: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
            $errorLog .= 'Trace: ' . $e->getTraceAsString() . PHP_EOL;
            $errorLog .= 'Request: ' . json_encode($request->all(), JSON_UNESCAPED_UNICODE) . PHP_EOL;
            $errorLog .= '---' . PHP_EOL;
            @file_put_contents($logFile, $errorLog, FILE_APPEND);
            
            try {
                Log::error('Telegram Webhook处理异常', [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                    'request_data' => $request->all()
                ]);
            } catch (\Throwable $logError) {
                // 忽略日志错误，至少文件日志已经写入
                @file_put_contents($logFile, 'Log facade error: ' . $logError->getMessage() . PHP_EOL, FILE_APPEND);
            }
            
            // 确保返回有效的JSON响应（Telegram要求返回200 OK）
            try {
                return response()->json(['ok' => false, 'error' => 'Internal server error'], 200);
            } catch (\Throwable $responseError) {
                // 如果连响应都无法返回，至少记录错误
                @file_put_contents($logFile, 'Response error: ' . $responseError->getMessage() . PHP_EOL, FILE_APPEND);
                // 返回最简单的响应
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode(['ok' => false, 'error' => 'Internal server error']);
                exit;
            }
        }
    }

    /**
     * 处理消息
     *
     * @param array $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleMessage($message)
    {
        try {
            $chatId = $message['chat']['id'] ?? null;
            $telegramId = $message['from']['id'] ?? null;
            $text = $message['text'] ?? '';
            $username = $message['from']['username'] ?? '';
            $firstName = $message['from']['first_name'] ?? '';

            if (!$chatId || !$telegramId) {
                Log::error('Telegram消息缺少必要字段', ['message' => $message]);
                return response()->json(['ok' => false, 'error' => '缺少必要字段'], 400);
            }

            Log::info('处理Telegram消息', [
                'chat_id' => $chatId,
                'telegram_id' => $telegramId,
                'text' => $text,
                'username' => $username
            ]);

            // 检查用户是否存在，如果不存在则自动注册
            $user = User::where('telegram_id', $telegramId)->first();
            $isNewUser = false;

            if (!$user) {
                // 自动注册用户
                $user = $this->registerUserFromTelegram($telegramId, $username, $firstName);
                if (!$user) {
                    Log::error('用户注册失败', [
                        'telegram_id' => $telegramId,
                        'username' => $username
                    ]);
                    $sendResult = $this->telegramBot->sendMessage($chatId, '注册失败，请联系客服');
                    if ($sendResult['code'] != 200) {
                        Log::error('发送注册失败消息也失败', ['result' => $sendResult]);
                    }
                    return response()->json(['ok' => true]);
                }
                $isNewUser = true;
                Log::info('用户自动注册成功', [
                    'telegram_id' => $telegramId,
                    'user_id' => $user->id,
                    'username' => $user->username
                ]);
            }

        // 检查用户是否在输入状态（充值/提现金额或地址）
        $userState = $this->getUserState($telegramId);
        if ($userState && !empty($text)) {
            switch ($userState['action']) {
                case self::STATE_WAITING_RECHARGE_AMOUNT:
                    return $this->processRechargeAmountInput($chatId, $user, $telegramId, $text, $userState);
                case self::STATE_WAITING_WITHDRAW_AMOUNT:
                    return $this->processWithdrawAmountInput($chatId, $user, $telegramId, $text, $userState);
                case self::STATE_WAITING_WITHDRAW_ADDRESS:
                    return $this->processWithdrawAddressInput($chatId, $user, $telegramId, $text, $userState);
            }
        }

        // 处理/start命令或首次进入
        if ($text === '/start' || empty($text)) {
            Log::info('触发显示主菜单', [
                'chat_id' => $chatId,
                'user_id' => $user->id,
                'text' => $text,
                'is_new_user' => $isNewUser
            ]);
            // showMainMenu会自动检查first_password并显示密码（如果是新用户）
            // 传递 Telegram 用户信息以获取最新的名称、用户名和ID
            $telegramUserInfo = [
                'first_name' => $firstName,
                'username' => $username
            ];
            $result = $this->showMainMenu($chatId, $user, null, $telegramUserInfo);
            Log::info('showMainMenu返回结果', ['result' => $result]);
            return $result;
        }
        
        // 处理/help命令
        if ($text === '/help') {
            return $this->showHelpMessage($chatId, $user);
        }
        
        // 如果是新注册用户且发送了其他指令，显示用户名和密码信息
        if ($isNewUser && !empty($user->first_password)) {
            // 使用first_password字段，这是明文密码（不是加密后的password字段）
            $firstPassword = $user->first_password;
            $welcomeText = "🔴⚠️ <b>欢迎注册！请牢记以下信息，后续将不再显示！</b> ⚠️🔴\n";
            $welcomeText .= "━━━━━━━━━━━━━━━━━━━━\n\n";
            $welcomeText .= "👤 <b>用户名：</b><code>{$user->username}</code>\n";
            $welcomeText .= "🔑 <b>密码：</b><code>{$firstPassword}</code>\n\n";
            $welcomeText .= "━━━━━━━━━━━━━━━━━━━━\n\n";
            $welcomeText .= "您已成功注册，可以使用机器人功能了！\n\n";
            $welcomeText .= "请发送 /start 开始使用机器人。";
            
            $this->telegramBot->sendMessage($chatId, $welcomeText);
            
            // 清空first_password，确保后续不再显示
            $user->first_password = null;
            $user->save();
            
            Log::info('新注册用户显示密码信息', [
                'user_id' => $user->id,
                'username' => $user->username
            ]);
        }

        // 处理常驻键盘菜单按钮点击
        switch ($text) {
            case '🎮 游戏入口':
                // 发送带 Inline Keyboard 的消息，用户点击后可自动登录
                $telegramUserInfo = [
                    'first_name' => $message['from']['first_name'] ?? null,
                    'username' => $message['from']['username'] ?? null
                ];
                return $this->sendGameEntryMessage($chatId, $user, $telegramUserInfo);

            case '💰 账户余额':
                // 显示账户余额信息
                // 从 message 中获取 Telegram 用户信息
                $telegramUserInfo = [
                    'first_name' => $message['from']['first_name'] ?? null,
                    'username' => $message['from']['username'] ?? null
                ];
                return $this->showMainMenu($chatId, $user, null, $telegramUserInfo);
                
            case '🏅 官方频道':
            case '🏅 官方入口':
                // 显示官方频道
                $officialUrl = SystemConfig::getValue('telegram_bot_official_url') ?: (SystemConfig::getValue('h5_url') ?: '');
                if ($officialUrl) {
                    // 通过带URL的内联键盘发送，客户端可直接打开
                    $inlineKeyboard = [[
                        [
                            'text' => '🏅 打开官方入口',
                            'url' => $officialUrl
                        ]
                    ]];
                    $this->telegramBot->sendMessageWithInlineKeyboard($chatId, '请选择：', $inlineKeyboard);
                } else {
                    $this->telegramBot->sendMessage($chatId, '未配置官方地址');
                }
                // 设置键盘，确保键盘始终显示
                $this->setPersistentKeyboard($chatId);
                return response()->json(['ok' => true]);
                
            case '🤷 在线客服':
                // 显示在线客服（功能开发中）
                // 注意：键盘按钮无法使用弹窗提示，因为它们是文本消息而非回调查询
                // 设置键盘，确保键盘始终显示
                $this->setPersistentKeyboard($chatId);
                return response()->json(['ok' => true]);
                
            case '🤝 招商代理':
                // 显示招商代理信息（功能开发中）
                // 注意：键盘按钮无法使用弹窗提示，因为它们是文本消息而非回调查询
                // 设置键盘，确保键盘始终显示
                $this->setPersistentKeyboard($chatId);
                return response()->json(['ok' => true]);
                
            default:
                // 其他消息，忽略或显示提示
                Log::info('收到未知消息', ['text' => $text, 'user_id' => $user->id]);
                // 设置键盘，确保键盘始终显示
                $this->setPersistentKeyboard($chatId);
                return response()->json(['ok' => true]);
        }
        } catch (\Exception $e) {
            Log::error('处理Telegram消息异常', [
                'message' => $message ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * 处理回调查询（按钮点击）
     *
     * @param array $callbackQuery
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleCallbackQuery($callbackQuery)
    {
        try {
            $chatId = $callbackQuery['message']['chat']['id'];
            $messageId = $callbackQuery['message']['message_id'];
            $data = $callbackQuery['data'];
            $telegramId = $callbackQuery['from']['id'];

        // 解析回调数据：action:data
        $parts = explode(':', $data, 2);
        $action = $parts[0];
        $param = $parts[1] ?? '';

        $user = User::where('telegram_id', $telegramId)->first();
        $isNewUser = false;
        
        if (!$user) {
            // 自动注册用户（从callbackQuery中获取用户信息）
            $telegramUsername = $callbackQuery['from']['username'] ?? '';
            $telegramFirstName = $callbackQuery['from']['first_name'] ?? '';
            $user = $this->registerUserFromTelegram($telegramId, $telegramUsername, $telegramFirstName);
            if (!$user) {
                Log::error('回调查询时用户注册失败', [
                    'telegram_id' => $telegramId,
                    'username' => $telegramUsername
                ]);
                $this->telegramBot->sendMessage($chatId, '注册失败，请联系客服');
                return response()->json(['ok' => true]);
            }
            $isNewUser = true;
            Log::info('回调查询时用户自动注册成功', [
                'telegram_id' => $telegramId,
                'user_id' => $user->id,
                'username' => $user->username
            ]);
            
            // 如果是新注册用户，显示用户名和密码信息
            if (!empty($user->first_password)) {
                // 使用first_password字段，这是明文密码（不是加密后的password字段）
                $firstPassword = $user->first_password;
                $welcomeText = "🔴⚠️ <b>欢迎注册！请牢记以下账号信息，后续将不再显示密码！</b> ⚠️🔴\n";
                $welcomeText .= "━━━━━━━━━━━━━━━━━━━━\n\n";
                $welcomeText .= "👤 <b>用户名：</b><code>{$user->username}</code>\n";
                $welcomeText .= "🔑 <b>密码：</b><code>{$firstPassword}</code>\n\n";
                $welcomeText .= "━━━━━━━━━━━━━━━━━━━━\n\n";
                $welcomeText .= "您已成功注册，可以使用机器人功能了！";
                
                $this->telegramBot->sendMessage($chatId, $welcomeText);
                
                // 清空first_password，确保后续不再显示
                $user->first_password = null;
                $user->save();
                
                Log::info('回调查询时新注册用户显示密码信息', [
                    'user_id' => $user->id,
                    'username' => $user->username
                ]);
            }
        }

        // 记录回调ID，在操作完成后显示状态提示
        $callbackQueryId = $callbackQuery['id'];

        switch ($action) {
            case 'game_category':
                // 点击游戏分类，显示该分类下的游戏列表
                // 不调用answerCallbackQuery以避免显示绿色图标
                $result = $this->showGameList($chatId, $messageId, $user, $param);
                return $result;

            case 'game_select':
                // 点击具体游戏，显示游戏账户信息和操作菜单
                // 不调用answerCallbackQuery以避免显示绿色图标
                $telegramUserInfo = [
                    'first_name' => $callbackQuery['from']['first_name'] ?? null,
                    'username' => $callbackQuery['from']['username'] ?? null
                ];
                $result = $this->showGameInfo($chatId, $messageId, $user, $param, $telegramUserInfo);
                return $result;

            case 'transfer_in':
                // 转入游戏
                $telegramUserInfo = [
                    'first_name' => $callbackQuery['from']['first_name'] ?? null,
                    'username' => $callbackQuery['from']['username'] ?? null
                ];
                return $this->transferToGame($chatId, $messageId, $user, $param, $callbackQueryId, $telegramUserInfo);

            case 'transfer_out':
                // 转回钱包
                $telegramUserInfo = [
                    'first_name' => $callbackQuery['from']['first_name'] ?? null,
                    'username' => $callbackQuery['from']['username'] ?? null
                ];
                return $this->transferToWallet($chatId, $messageId, $user, $param, $callbackQueryId, $telegramUserInfo);

            case 'refresh':
                // 刷新账户信息
                $telegramUserInfo = [
                    'first_name' => $callbackQuery['from']['first_name'] ?? null,
                    'username' => $callbackQuery['from']['username'] ?? null
                ];
                return $this->refreshGameInfo($chatId, $messageId, $user, $param, $callbackQueryId, $telegramUserInfo);

            case 'start_game':
                // 开始游戏
                return $this->startGame($chatId, $messageId, $user, $param, $callbackQueryId);

            case 'back_main':
                // 返回主菜单
                // 不调用answerCallbackQuery以避免显示绿色图标
                $telegramUserInfo = [
                    'first_name' => $callbackQuery['from']['first_name'] ?? null,
                    'username' => $callbackQuery['from']['username'] ?? null
                ];
                $result = $this->showMainMenu($chatId, $user, $messageId, $telegramUserInfo);
                return $result;

            case 'back_game_list':
                // 返回游戏列表
                // 不调用answerCallbackQuery以避免显示绿色图标
                $result = $this->backToGameList($chatId, $messageId, $user, $param);
                return $result;

            case 'official_games':
                // 官方游戏入口（已改为web_app类型，此case理论上不会触发，但保留作为后备）
                return response()->json(['ok' => true]);

            case 'reclaim_balance':
                // 回收余额（待实现）
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false); // 只消除加载状态
                $telegramUserInfo = [
                    'first_name' => $callbackQuery['from']['first_name'] ?? null,
                    'username' => $callbackQuery['from']['username'] ?? null
                ];
                return $this->showMainMenu($chatId, $user, $messageId, $telegramUserInfo, '该功能正在开发中...');

            case 'deposit_withdraw':
                // 充值提现二级菜单
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false);
                $this->clearUserState($telegramId);
                return $this->showDepositWithdrawMenu($chatId, $messageId, $user);

            case 'recharge':
                // 充值 - 显示网络选择
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false);
                $this->clearUserState($telegramId);
                return $this->showRechargeNetworkMenu($chatId, $messageId, $user);

            case 'withdraw':
                // 提现 - 显示网络选择
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false);
                $this->clearUserState($telegramId);
                return $this->showWithdrawNetworkMenu($chatId, $messageId, $user);

            case 'recharge_trc20':
                // TRC20 充值
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false);
                return $this->handleRechargeTrc20($chatId, $messageId, $user, $telegramId);

            case 'recharge_erc20':
                // ERC20 充值 - 暂不支持
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false);
                return $this->showRechargeNetworkMenu($chatId, $messageId, $user, '⚠️ ERC20暂不支持，请选择TRC20');

            case 'withdraw_trc20':
                // TRC20 提现
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false);
                return $this->handleWithdrawTrc20($chatId, $messageId, $user, $telegramId);

            case 'withdraw_erc20':
                // ERC20 提现 - 暂不支持
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false);
                return $this->showWithdrawNetworkMenu($chatId, $messageId, $user, '⚠️ ERC20暂不支持，请选择TRC20');

            case 'cancel_recharge_order':
                // 取消充值订单
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false);
                return $this->cancelRechargeOrder($chatId, $messageId, $user, $param, $telegramId);

            case 'cancel_input':
                // 取消输入操作
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false);
                $this->clearUserState($telegramId);
                return $this->showDepositWithdrawMenu($chatId, $messageId, $user);

            case 'back_to_deposit_withdraw':
                // 返回充值提现菜单
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false);
                $this->clearUserState($telegramId);
                return $this->showDepositWithdrawMenu($chatId, $messageId, $user);

            case 'invite_friends':
                // 邀请好友（待实现）
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false); // 只消除加载状态
                $telegramUserInfo = [
                    'first_name' => $callbackQuery['from']['first_name'] ?? null,
                    'username' => $callbackQuery['from']['username'] ?? null
                ];
                return $this->showMainMenu($chatId, $user, $messageId, $telegramUserInfo, '该功能正在开发中...');

            case 'transaction_details':
                // 流水明细
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false); // 只消除加载状态
                $telegramUserInfo = [
                    'first_name' => $callbackQuery['from']['first_name'] ?? null,
                    'username' => $callbackQuery['from']['username'] ?? null
                ];
                $flowDetail = $this->getUserFlowDetail($user);
                return $this->showMainMenu($chatId, $user, $messageId, $telegramUserInfo, null, $flowDetail);

            case 'send_redpacket':
                // 发红包（待实现）
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false); // 只消除加载状态
                $telegramUserInfo = [
                    'first_name' => $callbackQuery['from']['first_name'] ?? null,
                    'username' => $callbackQuery['from']['username'] ?? null
                ];
                return $this->showMainMenu($chatId, $user, $messageId, $telegramUserInfo, '该功能正在开发中...');

            case 'welfare_activities':
                // 福利活动（待实现）
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false); // 只消除加载状态
                $telegramUserInfo = [
                    'first_name' => $callbackQuery['from']['first_name'] ?? null,
                    'username' => $callbackQuery['from']['username'] ?? null
                ];
                return $this->showMainMenu($chatId, $user, $messageId, $telegramUserInfo, '该功能正在开发中...');

            case 'language':
                // 语言切换（待实现）
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false); // 只消除加载状态
                $telegramUserInfo = [
                    'first_name' => $callbackQuery['from']['first_name'] ?? null,
                    'username' => $callbackQuery['from']['username'] ?? null
                ];
                return $this->showMainMenu($chatId, $user, $messageId, $telegramUserInfo, '该功能正在开发中...');

            case 'official_channel':
                // 官方频道（待实现）
                $this->telegramBot->answerCallbackQuery($callbackQueryId, false); // 只消除加载状态
                $telegramUserInfo = [
                    'first_name' => $callbackQuery['from']['first_name'] ?? null,
                    'username' => $callbackQuery['from']['username'] ?? null
                ];
                return $this->showMainMenu($chatId, $user, $messageId, $telegramUserInfo, '该功能正在开发中...');

            default:
                // 未知操作
                return response()->json(['ok' => true]);
        }
        } catch (\Throwable $e) {
            // 记录异常日志
            $logFile = storage_path('logs/telegram_webhook.log');
            $errorLog = date('Y-m-d H:i:s') . ' === handleCallbackQuery 异常 ===' . PHP_EOL;
            $errorLog .= 'Error: ' . $e->getMessage() . PHP_EOL;
            $errorLog .= 'File: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
            $errorLog .= 'Trace: ' . $e->getTraceAsString() . PHP_EOL;
            $errorLog .= 'CallbackQuery: ' . json_encode($callbackQuery ?? [], JSON_UNESCAPED_UNICODE) . PHP_EOL;
            $errorLog .= '---' . PHP_EOL;
            @file_put_contents($logFile, $errorLog, FILE_APPEND);
            
            try {
                Log::error('处理Telegram回调查询异常', [
                    'callback_query' => $callbackQuery ?? null,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
            } catch (\Throwable $logError) {
                // 忽略日志错误，至少文件日志已经写入
                @file_put_contents($logFile, 'Log facade error: ' . $logError->getMessage() . PHP_EOL, FILE_APPEND);
            }
            
            // 不调用answerCallbackQuery以避免显示绿色图标
            
            return response()->json(['ok' => false, 'error' => 'Internal server error'], 200);
        }
    }

    /**
     * 从Telegram注册用户
     *
     * @param int $telegramId
     * @param string $username
     * @param string $firstName
     * @return User|null
     */
    protected function registerUserFromTelegram($telegramId, $username = '', $firstName = '')
    {
        try {
            // 生成用户名：游戏编码的前2位 + telegram的用户id
            // 默认使用"dp"作为游戏编码前缀（可以后续从配置中读取）
            $defaultGameCode = 'dp'; // 默认游戏编码
            $gameCodePrefix = substr($defaultGameCode, 0, 2); // 取前2位
            
            // 生成用户名：游戏编码前2位 + telegram_id
            $systemUsername = $gameCodePrefix . $telegramId;
            
            // 检查用户名是否已存在，如果存在则添加后缀
            $counter = 1;
            $originalUsername = $systemUsername;
            while (User::where('username', $systemUsername)->exists()) {
                $systemUsername = $originalUsername . $counter;
                $counter++;
                
                // 防止无限循环（理论上不太可能，但安全起见）
                if ($counter > 1000) {
                    Log::error('生成唯一用户名失败，冲突过多', [
                        'telegram_id' => $telegramId,
                        'attempts' => $counter
                    ]);
                    // 使用时间戳作为后备方案
                    $systemUsername = $gameCodePrefix . $telegramId . substr(str_replace('.', '', microtime(true)), -6);
                    break;
                }
            }

            // 生成随机密码明文
            $plainPassword = Str::random(32);
            
            // 创建用户
            $user = User::create([
                'username' => $systemUsername,
                'password' => Hash::make($plainPassword), // 哈希后的密码
                'first_password' => $plainPassword, // 保存明文密码
                'realname' => $firstName ?: $systemUsername,
                'telegram_id' => $telegramId,
                'status' => 1,
                'vip' => 1,
                'balance' => 0,
                'api_token' => Str::random(60),
            ]);

            Log::info('Telegram用户自动注册成功', [
                'telegram_id' => $telegramId,
                'username' => $systemUsername,
                'user_id' => $user->id
            ]);

            return $user;
        } catch (\Exception $e) {
            Log::error('Telegram用户注册失败', [
                'telegram_id' => $telegramId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * 获取 Telegram 显示名称（Telegram用户名 + 系统用户名）
     * 
     * @param User $user
     * @param string|null $telegramUsername Telegram 的 username（可选，用于实时获取）
     * @return string 返回格式：@username (系统用户名) 或 系统用户名
     */
    protected function getTelegramDisplayName($user, $telegramUsername = null)
    {
        // 优先使用传入的 Telegram username（最新的）
        $telegramUser = $telegramUsername;
        
        // 如果没有传入username，尝试从user表中获取（如果有存储的话）
        // 注意：这里可能需要根据实际情况调整，如果数据库中有存储telegram_username字段
        
        // 对Telegram用户名进行 HTML 转义，防止特殊字符导致解析错误
        // 特别处理 < > & 这些字符，避免被 Telegram 的 HTML 解析器误解析
        if (!empty($telegramUser)) {
            $telegramUser = htmlspecialchars($telegramUser, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            // 如果username不包含@符号，添加@前缀
            if (strpos($telegramUser, '@') !== 0) {
                $telegramUser = '@' . $telegramUser;
            }
        }
        
        // 对系统用户名也进行转义（虽然用户名通常是数字，但为安全起见也转义）
        $safeUsername = htmlspecialchars($user->username, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // 如果找到了 Telegram 用户名，显示为：@username (系统用户名)
        if (!empty($telegramUser) && $telegramUser != $user->username) {
            return "{$telegramUser} ({$safeUsername})";
        }
        
        // 否则只显示系统用户名
        return $safeUsername;
    }

    /**
     * 获取主菜单图片URL（用于所有需要显示图片消息的地方）
     *
     * @return string
     */
    protected function getMainMenuImageUrl()
    {
        $mainImagePath = SystemConfig::getValue('telegram_bot_main_image');
        if ($mainImagePath) {
            return env('APP_URL') . '/uploads/' . $mainImagePath;
        }

        // 如果没有配置Telegram Bot主图，使用系统logo作为默认图片
        $appLogo = SystemConfig::getValue('app_logo');
        if ($appLogo) {
            return env('APP_URL') . '/uploads/' . $appLogo;
        }

        // 如果系统logo也没有，尝试使用默认路径（向后兼容）
        return env('APP_URL') . '/images/telegram/main_banner.jpg';
    }

    /**
     * 显示主菜单（图一效果）
     *
     * @param int $chatId
     * @param User $user
     * @param int|null $messageId 如果提供则编辑消息，否则发送新消息
     * @param array|null $telegramUserInfo Telegram 用户信息（可选，包含 first_name、username 等）
     * @param string|null $noticeMessage 可选的提示信息，会在文字区顶部显示
     * @param string|null $flowDetail 可选的流水明细内容，会在文字区显示
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showMainMenu($chatId, $user, $messageId = null, $telegramUserInfo = null, $noticeMessage = null, $flowDetail = null)
    {
        try {
            // 刷新用户对象，确保获取最新的 first_password 字段
            $user->refresh();
            
            // 获取用户余额
            $walletBalance = number_format($user->balance, 2);
            $gameBalance = number_format(Usersmoney::getTotalAppUserBalance($user->id), 4);
            
            // 检查是否是首次进入（判断 first_password 是否存在）
            $isFirstLogin = !empty($user->first_password);
            
            // 文字区 - 显示用户账户信息（作为图片的caption）
            $text = '';
            
            // 如果有流水明细，优先显示流水明细
            if (!empty($flowDetail)) {
                $text = $flowDetail;
            } else {
                // 如果有提示信息，在顶部显示
                if (!empty($noticeMessage)) {
                    $text .= "⏳ {$noticeMessage}\n\n";
                }
                
                // 如果是首次进入，显示用户名和密码信息
                if ($isFirstLogin) {
                // 使用first_password字段，这是明文密码（不是加密后的password字段）
                $firstPassword = $user->first_password;
                // 使用HTML格式，用加粗和代码格式突出显示，并用警告符号引起注意
                // Telegram HTML模式不支持color样式，但可以用特殊符号和格式来强调
                $text .= "🔴⚠️ <b>重要提示：请牢记以下账号信息，后续将不再显示密码！</b> ⚠️🔴\n";
                $text .= "━━━━━━━━━━━━━━━━━━━━\n\n";
                $text .= "👤 <b>用户名：</b><code>{$user->username}</code>\n";
                $text .= "🔑 <b>密码：</b><code>{$firstPassword}</code>\n\n";
                $text .= "━━━━━━━━━━━━━━━━━━━━\n\n";
                
                // 显示完密码后，清空 first_password 字段，确保后续不再显示
                $user->first_password = null;
                $user->save();
                
                Log::info('首次登录显示密码信息', [
                    'user_id' => $user->id,
                    'username' => $user->username
                ]);
            } else {
                // 非首次登录，显示 Telegram 名称、用户名和ID
                $telegramFirstName = null;
                $telegramUsername = null;
                if ($telegramUserInfo) {
                    $telegramFirstName = $telegramUserInfo['first_name'] ?? null;
                    $telegramUsername = $telegramUserInfo['username'] ?? null;
                }
                
                // 显示Telegram名称（如果有）
                if (!empty($telegramFirstName)) {
                    $safeFirstName = htmlspecialchars($telegramFirstName, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $text .= "👤 <b>名称：</b>{$safeFirstName}\n";
                }
                
                // 显示Telegram用户名（如果有）
                if (!empty($telegramUsername)) {
                    $safeUsername = htmlspecialchars($telegramUsername, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $usernameDisplay = (strpos($safeUsername, '@') === 0) ? $safeUsername : '@' . $safeUsername;
                    $text .= "📱 <b>用户名：</b>{$usernameDisplay}\n";
                }
            }
            
            // 显示Telegram ID
            $text .= "🆔 <b>ID：</b>{$user->telegram_id}\n";
            $text .= "💰 钱包余额: {$walletBalance} USDT\n";
            $text .= "💵 游戏余额: {$gameBalance} CNY\n";
            
            // 显示钱包地址
            $moneyAddress = $user->money_address ?? '';
            if (!empty($moneyAddress)) {
                $safeAddress = htmlspecialchars($moneyAddress, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $text .= "🔗 <b>钱包地址：</b><code>{$safeAddress}</code>\n";
            }
            
                $text .= "⏰ 当前时间: " . date('Y-m-d H:i:s');
            }

            // 构建菜单按钮
            $inlineKeyboard = [];

            // 从系统配置读取游戏入口地址
            $gameUrl = SystemConfig::getValue('telegram_bot_game_url') ?: (SystemConfig::getValue('h5_url') ?: 'https://epay.266982.xyz/');

            // 调试日志 - showMainMenu inline keyboard
            file_put_contents(storage_path('logs/telegram_webhook.log'),
                date('Y-m-d H:i:s') . " === showMainMenu Inline Keyboard 调试 ===\n" .
                "gameUrl: {$gameUrl}\n" .
                "---\n", FILE_APPEND);

            // 第一行：官方游戏入口（全宽按钮，使用web_app类型直接打开）
            $inlineKeyboard[] = [[
                'text' => '🎮 官方游戏入口',
                'web_app' => [
                    'url' => $gameUrl
                ]
            ]];
            
            // 获取游戏分类按钮
            Log::info('开始获取游戏类目列表');
            $gameCategories = $this->getGameCategories();
            Log::info('获取到游戏类目列表', [
                'count' => count($gameCategories),
                'categories' => $gameCategories
            ]);
            
            // 游戏分类按钮（每行两个）
            $row = [];
            foreach ($gameCategories as $category) {
                $row[] = [
                    'text' => $category['name'],
                    'callback_data' => 'game_category:' . $category['code']
                ];

                if (count($row) == 2) {
                    $inlineKeyboard[] = $row;
                    $row = [];
                }
            }
            if (!empty($row)) {
                $inlineKeyboard[] = $row;
            }
            
            // 其他功能按钮（两列）
            $inlineKeyboard[] = [[
                'text' => '♻️ 回收余额',
                'callback_data' => 'reclaim_balance'
            ], [
                'text' => '💰 充值提现',
                'callback_data' => 'deposit_withdraw'
            ]];
            
            $inlineKeyboard[] = [[
                'text' => '👋 邀请好友',
                'callback_data' => 'invite_friends'
            ], [
                'text' => '📊 流水明细',
                'callback_data' => 'transaction_details'
            ]];
            
            // 根据系统配置决定是否显示发红包按钮
            $redpacketEnabled = SystemConfig::getValue('redpacket') === '1';
            
            // 构建红包和福利活动按钮行
            $redpacketRow = [];
            if ($redpacketEnabled) {
                $redpacketRow[] = [
                    'text' => '🧧 发红包',
                    'callback_data' => 'send_redpacket'
                ];
            }
            $redpacketRow[] = [
                'text' => '🎁 福利活动',
                'callback_data' => 'welfare_activities'
            ];
            
            // 如果红包功能开启，一行两个按钮；如果关闭，只显示福利活动一个按钮
            $inlineKeyboard[] = $redpacketRow;
            
            $inlineKeyboard[] = [[
                'text' => '🌐 Language',
                'callback_data' => 'language'
            ], [
                'text' => '🏛️ 官方频道',
                'callback_data' => 'official_channel'
            ]];

            Log::info('构建完成内联键盘', [
                'keyboard' => $inlineKeyboard,
                'button_count' => count($inlineKeyboard)
            ]);

            // 获取图片URL
            $mainImagePath = SystemConfig::getValue('telegram_bot_main_image');
            if ($mainImagePath) {
                $mainImageUrl = env('APP_URL') . '/uploads/' . $mainImagePath;
            } else {
                // 如果没有配置Telegram Bot主图，使用系统logo作为默认图片
                $appLogo = SystemConfig::getValue('app_logo');
                if ($appLogo) {
                    $mainImageUrl = env('APP_URL') . '/uploads/' . $appLogo;
                } else {
                    // 如果系统logo也没有，尝试使用默认路径（向后兼容）
                    $mainImageUrl = env('APP_URL') . '/images/telegram/main_banner.jpg';
                }
            }

            if ($messageId) {
                // 编辑现有消息 - 先尝试编辑caption（图片消息），如果失败则尝试编辑text（文本消息）
                $result = $this->telegramBot->editMessageCaptionWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
                if ($result['code'] != 200) {
                    // 如果编辑caption失败，尝试编辑text
                    $result = $this->telegramBot->editMessageTextWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
                    if ($result['code'] != 200) {
                        Log::error('编辑主菜单消息失败', ['result' => $result]);
                    }
                }
            } else {
                // 先发送欢迎文字消息
                $welcomeText = "欢迎来到MK体育飞投\n\n";
                $welcomeText .= "🎁MK体育飞投：致力于打造全球玩家心中的顶级线上娱乐平台，凭借卓越品质和创新精神，深受玩家信赖与喜爱。全台厂商直营无私彩，公平公正假一赔十！拒绝盗版游戏享受健康生活！";
                $this->telegramBot->sendMessage($chatId, $welcomeText);
                
                // 发送图片消息，文字作为caption，按钮作为reply_markup
                $photoResult = $this->telegramBot->sendPhotoWithInlineKeyboard($chatId, $mainImageUrl, $text, $inlineKeyboard);
                
                // 如果图片发送失败，降级为文字消息
                if ($photoResult['code'] != 200) {
                    Log::warning('发送主菜单图片失败，降级为文字消息', [
                        'chat_id' => $chatId,
                        'image_url' => $mainImageUrl,
                        'result' => $photoResult
                    ]);
                    // 发送文字消息和按钮
                    $messageResult = $this->telegramBot->sendMessageWithInlineKeyboard($chatId, $text, $inlineKeyboard);
                    if ($messageResult['code'] != 200) {
                        Log::error('发送主菜单文字消息也失败', [
                            'chat_id' => $chatId,
                            'result' => $messageResult
                        ]);
                    }
                }
            }

            // 设置常驻键盘菜单（ReplyKeyboardMarkup）
            $this->setPersistentKeyboard($chatId);

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('显示主菜单异常', [
                'chat_id' => $chatId,
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // 即使出错也尝试发送一条简单的欢迎消息
            try {
                $this->telegramBot->sendMessage($chatId, '欢迎使用Mkgaming智能投注系统！');
            } catch (\Exception $e2) {
                Log::error('发送错误提示消息也失败', ['error' => $e2->getMessage()]);
            }
            
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * 显示游戏列表（图二效果）
     *
     * @param int $chatId
     * @param int $messageId
     * @param User $user
     * @param string $categoryCode 游戏分类代码
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showGameList($chatId, $messageId, $user, $categoryCode)
    {
        // 获取该分类下的游戏列表
        $games = $this->getGamesByCategory($categoryCode);

        $text = "👇 请选择游戏";

        // 构建游戏列表按钮
        $inlineKeyboard = [];
        $row = [];

        foreach ($games as $game) {
            $row[] = [
                'text' => $game['name'],
                'callback_data' => 'game_select:' . $game['platform_name'] . ':' . $game['game_code']
            ];

            if (count($row) == 2) {
                $inlineKeyboard[] = $row;
                $row = [];
            }
        }

        if (!empty($row)) {
            $inlineKeyboard[] = $row;
        }

        // 添加返回按钮
        $inlineKeyboard[] = [[
            'text' => '← 返回',
            'callback_data' => 'back_main:'
        ]];

        // 先尝试编辑caption（图片消息），如果失败则尝试编辑text（文本消息）
        $result = $this->telegramBot->editMessageCaptionWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
        if ($result['code'] != 200) {
            // 如果编辑caption失败，尝试编辑text
            $result = $this->telegramBot->editMessageTextWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
            if ($result['code'] != 200) {
                Log::error('编辑游戏列表消息失败', [
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'result' => $result
                ]);
            }
        }

        return response()->json(['ok' => true]);
    }

    /**
     * 显示游戏信息（图三效果）
     *
     * @param int $chatId
     * @param int $messageId
     * @param User $user
     * @param string $gameData 格式：platform_name:game_code
     * @param array|null $telegramUserInfo Telegram 用户信息（可选）
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showGameInfo($chatId, $messageId, $user, $gameData, $telegramUserInfo = null)
    {
        $parts = explode(':', $gameData);
        $platformName = $parts[0] ?? '';
        $gameCode = $parts[1] ?? '';

        if (empty($platformName)) {
            return response()->json(['ok' => true]);
        }

        // 获取游戏信息
        $game = GameList::where('platform_name', $platformName)
            ->where('game_code', $gameCode)
            ->first();

        if (!$game) {
            $this->telegramBot->sendMessage($chatId, '游戏不存在');
            return response()->json(['ok' => true]);
        }

        // 获取用户在该平台的余额（根据游戏免转状态）
        $gameBalance = $this->getUserGameBalance($user, $platformName, $game);

        // 文字区 - 显示账户信息
        $walletBalance = number_format($user->balance, 2);
        $telegramUsername = null;
        if ($telegramUserInfo && isset($telegramUserInfo['username'])) {
            $telegramUsername = $telegramUserInfo['username'];
        }
        $displayName = $this->getTelegramDisplayName($user, $telegramUsername);
        $text = "账户信息\n\n";
        $text .= "用户: {$displayName}\n";
        $text .= "钱包余额: {$walletBalance} USDT\n";
        $text .= "游戏余额: " . number_format($gameBalance, 4) . " CNY\n";
        
        // 显示钱包地址
        $moneyAddress = $user->money_address ?? '';
        if (!empty($moneyAddress)) {
            $safeAddress = htmlspecialchars($moneyAddress, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $text .= "钱包地址: <code>{$safeAddress}</code>\n";
        }
        
        $text .= "当前游戏: {$game->name}\n";
        $text .= "当前时间: " . date('Y-m-d H:i:s');

        // 获取游戏链接，用于绑定到"开始游戏"按钮
        $gameUrl = $this->getGameUrl($user, $platformName, $gameCode, $game);

        // 构建菜单按钮
        $inlineKeyboard = [];

        // 检查是否为免转游戏（transferstatus == 0表示免转，== 1表示非免转）
        if ($game->transferstatus == 1) {
            // 非免转，显示转入和转出按钮
            $inlineKeyboard[] = [
                [
                    'text' => '转入游戏',
                    'callback_data' => 'transfer_in:' . $platformName . ':' . $gameCode
                ],
                [
                    'text' => '转回钱包',
                    'callback_data' => 'transfer_out:' . $platformName . ':' . $gameCode
                ]
            ];
        }

        // "开始游戏"按钮直接使用web_app类型，绑定游戏链接（放在最前面）
        if ($gameUrl) {
            $inlineKeyboard[] = [[
                'text' => '🎮 开始游戏',
                'web_app' => [
                    'url' => $gameUrl
                ]
            ]];
        } else {
            // 如果获取游戏链接失败，使用callback_data作为后备方案（会再次尝试获取链接）
            $inlineKeyboard[] = [[
                'text' => '🎮 开始游戏',
                'callback_data' => 'start_game:' . $platformName . ':' . $gameCode
            ]];
        }

        // 通用按钮：刷新、返回（放在开始游戏按钮后面）
        $row = [
            [
                'text' => '🔄 刷新',
                'callback_data' => 'refresh:' . $platformName . ':' . $gameCode
            ],
            [
                'text' => '← 返回',
                'callback_data' => 'back_game_list:' . $this->getCategoryCodeByPlatform($platformName)
            ]
        ];

        $inlineKeyboard[] = $row;

        // 先尝试编辑caption（图片消息），如果失败则尝试编辑text（文本消息）
        $result = $this->telegramBot->editMessageCaptionWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
        if ($result['code'] != 200) {
            // 如果编辑caption失败，尝试编辑text
            $result = $this->telegramBot->editMessageTextWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
            if ($result['code'] != 200) {
                Log::error('编辑游戏信息消息失败', [
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'result' => $result
                ]);
            }
        }

        return response()->json(['ok' => true]);
    }

    /**
     * 开始游戏
     *
     * @param int $chatId
     * @param int $messageId 消息ID，用于编辑消息
     * @param User $user
     * @param string $gameData 格式：platform_name:game_code
     * @param string $callbackQueryId 回调查询ID
     * @return \Illuminate\Http\JsonResponse
     */
    protected function startGame($chatId, $messageId, $user, $gameData, $callbackQueryId = '')
    {
        $parts = explode(':', $gameData);
        $platformName = $parts[0] ?? '';
        $gameCode = $parts[1] ?? '';

        Log::info('开始游戏 - 收到请求', [
            'user_id' => $user->id,
            'username' => $user->username,
            'chat_id' => $chatId,
            'platform_name' => $platformName,
            'game_code' => $gameCode,
            'game_data' => $gameData,
            'callback_query_id' => $callbackQueryId
        ]);

        if (empty($platformName)) {
            Log::error('开始游戏失败 - 平台名称为空', [
                'user_id' => $user->id,
                'game_data' => $gameData
            ]);
            return response()->json(['ok' => true]);
        }

        try {
            // 统一使用DP服务进行注册和登录
            Log::info('开始游戏 - 使用DP服务', [
                'user_id' => $user->id,
                'username' => $user->username,
                'platform' => $platformName,
                'game_code' => $gameCode
            ]);

            // 生成注册用的用户名：游戏编码（如果没有特殊字符则直接使用，否则去除特殊字符）+ 用户名
            // 检查游戏编码是否包含特殊字符（非字母数字字符）
            if (preg_match('/[^a-zA-Z0-9]/', $gameCode)) {
                // 包含特殊字符，去除特殊字符
                $cleanGameCode = preg_replace('/[^a-zA-Z0-9]/', '', $gameCode);
            } else {
                // 没有特殊字符，直接使用原游戏编码
                $cleanGameCode = $gameCode;
            }
            $dpUserName = $cleanGameCode . $user->username; // 拼接用户名
            
            // 使用DP服务时，不需要先调用register接口，直接调用login接口
            // DP服务支持自动注册（如果用户不存在，login时会自动创建）
            Log::info('开始游戏 - 使用DP服务，跳过注册步骤，直接登录', [
                'user_id' => $user->id,
                'username' => $user->username,
                'game_code' => $gameCode,
                'clean_game_code' => $cleanGameCode,
                'dp_user_name' => $dpUserName,
                'platform' => $platformName
            ]);

            // 获取游戏信息，用于确定venueCode和gameId
            $game = GameList::where('platform_name', $platformName)
                ->where('game_code', $gameCode)
                ->first();

            if (!$game) {
                Log::error('开始游戏 - 游戏不存在', [
                    'user_id' => $user->id,
                    'platform' => $platformName,
                    'game_code' => $gameCode
                ]);
                $this->telegramBot->sendMessage($chatId, '游戏不存在');
                return response()->json(['ok' => true]);
            }

            // 确定venueCode（场馆编码），使用游戏信息中的venue_code字段
            $venueCode = $game->venue_code ?? $platformName; // 如果venue_code不存在，使用platformName作为后备
            // 确定gameId，如果gameCode是数字则作为gameId，否则为0（从游戏列表接口获取的ID）
            $gameId = is_numeric($gameCode) ? (int)$gameCode : 0;
            // 币种默认USDT
            $currency = 'USDT';
            // 设备类型：2=h5（适合Telegram Mini App）
            $deviceType = 2;
            // 语言默认zh_CN
            $lang = 'zh_CN';

            Log::info('开始游戏 - 调用DP登录接口', [
                'user_id' => $user->id,
                'username' => $user->username,
                'dp_user_name' => $dpUserName,
                'platform' => $platformName,
                'game_code' => $gameCode,
                'venue_code' => $game->venue_code ?? null,
                'venueCode' => $venueCode,
                'gameId' => $gameId,
                'currency' => $currency,
                'deviceType' => $deviceType,
                'lang' => $lang
            ]);
            // 登录时使用用户名（游戏编码+用户名）
            $loginResult = $this->dpService->login($dpUserName, $venueCode, $currency, $gameId, $deviceType, $lang);
            Log::info('开始游戏 - DP登录接口返回', [
                'user_id' => $user->id,
                'username' => $user->username,
                'telegram_id' => $user->telegram_id,
                'dp_user_name' => $dpUserName,
                'platform' => $platformName,
                'game_code' => $gameCode,
                'login_code' => $loginResult['code'] ?? 'unknown',
                'login_message' => $loginResult['message'] ?? 'unknown',
                'has_game_url' => isset($loginResult['data']),
                'game_url_length' => isset($loginResult['data']) ? strlen($loginResult['data']) : 0,
                'login_result' => $loginResult
            ]);

            if ($loginResult['code'] != 200) {
                Log::error('开始游戏 - DP登录失败', [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'telegram_id' => $user->telegram_id,
                    'dp_user_name' => $dpUserName,
                    'platform' => $platformName,
                    'game_code' => $gameCode,
                    'login_result' => $loginResult
                ]);
                $this->telegramBot->sendMessage($chatId, '登录失败：' . $loginResult['message']);
                return response()->json(['ok' => true]);
            }

            $gameUrl = $loginResult['data'];
            Log::info('开始游戏 - DP获取游戏链接成功', [
                'user_id' => $user->id,
                'username' => $user->username,
                'telegram_id' => $user->telegram_id,
                'dp_user_name' => $dpUserName,
                'platform' => $platformName,
                'game_code' => $gameCode,
                'game_url' => $gameUrl,
                'game_url_length' => strlen($gameUrl)
            ]);

            // 注意：不调用answerCallbackQuery以避免显示绿色图标
            // 如果需要打开游戏链接，可以通过web_app类型的按钮直接打开

            // 编辑消息，将"开始游戏"按钮改为web_app类型，方便用户再次点击
            if ($messageId) {
                // 获取游戏信息（如果之前已获取过，可以直接使用；否则重新获取）
                if (!isset($game)) {
                    $game = GameList::where('platform_name', $platformName)
                        ->where('game_code', $gameCode)
                        ->first();
                }
                
                // 获取用户余额等信息，用于构建按钮（根据游戏免转状态）
                $gameBalance = $this->getUserGameBalance($user, $platformName, $game);
                $categoryCode = $this->getCategoryCodeByPlatform($platformName);
                
                // 构建新的按钮：将"开始游戏"按钮改为web_app类型
                $inlineKeyboard = [];
                
                // 检查是否为免转游戏（transferstatus == 0表示免转，== 1表示非免转）
                // 注意：这里的$game变量在之前已经获取过，可以直接使用
                if ($game && $game->transferstatus == 1) {
                    // 非免转，显示转入和转出按钮
                    $inlineKeyboard[] = [
                        [
                            'text' => '转入游戏',
                            'callback_data' => 'transfer_in:' . $platformName . ':' . $gameCode
                        ],
                        [
                            'text' => '转回钱包',
                            'callback_data' => 'transfer_out:' . $platformName . ':' . $gameCode
                        ]
                    ];
                }
                
                // 刷新和返回按钮
                $inlineKeyboard[] = [
                    [
                        'text' => '🔄 刷新',
                        'callback_data' => 'refresh:' . $platformName . ':' . $gameCode
                    ],
                    [
                        'text' => '← 返回',
                        'callback_data' => 'back_game_list:' . $categoryCode
                    ]
                ];
                
                // "开始游戏"按钮改为web_app类型，直接打开游戏
                $inlineKeyboard[] = [[
                    'text' => '🎮 开始游戏',
                    'web_app' => [
                        'url' => $gameUrl
                    ]
                ]];
                
                // 编辑消息的按钮
                $editResult = $this->telegramBot->editMessageReplyMarkup($chatId, $messageId, $inlineKeyboard);
                
                Log::info('开始游戏 - 编辑消息按钮为web_app类型', [
                    'user_id' => $user->id,
                    'chat_id' => $chatId,
                    'message_id' => $messageId,
                    'platform' => $platformName,
                    'game_code' => $gameCode,
                    'game_url' => $gameUrl,
                    'edit_result' => $editResult
                ]);
                
                // 如果编辑失败，降级为发送消息方式
                if ($editResult['code'] != 200) {
                    Log::warning('编辑消息按钮失败，降级为发送消息方式', [
                        'user_id' => $user->id,
                        'edit_result' => $editResult
                    ]);
                    
                    $inlineKeyboard = [[
                        [
                            'text' => '🎮 开始游戏',
                            'web_app' => [
                                'url' => $gameUrl
                            ]
                        ]
                    ]];
                    
                    $sendResult = $this->telegramBot->sendMessageWithInlineKeyboard($chatId, "点击下方按钮开始游戏：", $inlineKeyboard);
                    
                    Log::info('开始游戏 - 降级为发送消息方式', [
                        'user_id' => $user->id,
                        'chat_id' => $chatId,
                        'send_result' => $sendResult
                    ]);
                }
            } else {
                // 如果没有messageId，发送新消息
                $inlineKeyboard = [[
                    [
                        'text' => '🎮 开始游戏',
                        'web_app' => [
                            'url' => $gameUrl
                        ]
                    ]
                ]];
                
                $sendResult = $this->telegramBot->sendMessageWithInlineKeyboard($chatId, "点击下方按钮开始游戏：", $inlineKeyboard);
                
                Log::info('开始游戏 - 发送游戏链接到Telegram', [
                    'user_id' => $user->id,
                    'chat_id' => $chatId,
                    'platform' => $platformName,
                    'game_code' => $gameCode,
                    'game_url' => $gameUrl,
                    'send_result' => $sendResult
                ]);
            }

        } catch (\Exception $e) {
            Log::error('开始游戏失败 - 异常', [
                'user_id' => $user->id,
                'username' => $user->username,
                'chat_id' => $chatId,
                'platform' => $platformName,
                'game_code' => $gameCode,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->telegramBot->sendMessage($chatId, '启动游戏失败，请稍后重试');
        }

        return response()->json(['ok' => true]);
    }

    /**
     * 转入游戏
     *
     * @param int $chatId
     * @param int $messageId
     * @param User $user
     * @param string $gameData
     * @return \Illuminate\Http\JsonResponse
     */
    protected function transferToGame($chatId, $messageId, $user, $gameData, $callbackQueryId = '', $telegramUserInfo = null)
    {
        // TODO: 实现转入游戏逻辑
        if (!empty($callbackQueryId)) {
            $this->telegramBot->answerCallbackQuery($callbackQueryId, false); // 只消除加载状态
        } else {
            // 如果没有callbackQueryId（非按钮触发），则发送消息
            $this->telegramBot->sendMessage($chatId, '⏳ 该功能正在开发中...');
            return response()->json(['ok' => true]);
        }
        return $this->showMainMenu($chatId, $user, $messageId, $telegramUserInfo, '该功能正在开发中...');
    }

    /**
     * 转回钱包
     *
     * @param int $chatId
     * @param int $messageId
     * @param User $user
     * @param string $gameData
     * @param string $callbackQueryId
     * @return \Illuminate\Http\JsonResponse
     */
    protected function transferToWallet($chatId, $messageId, $user, $gameData, $callbackQueryId = '', $telegramUserInfo = null)
    {
        // TODO: 实现转回钱包逻辑
        if (!empty($callbackQueryId)) {
            $this->telegramBot->answerCallbackQuery($callbackQueryId, false); // 只消除加载状态
        } else {
            // 如果没有callbackQueryId（非按钮触发），则发送消息
            $this->telegramBot->sendMessage($chatId, '⏳ 该功能正在开发中...');
            return response()->json(['ok' => true]);
        }
        return $this->showMainMenu($chatId, $user, $messageId, $telegramUserInfo, '该功能正在开发中...');
    }

    /**
     * 刷新游戏信息
     *
     * @param int $chatId
     * @param int $messageId
     * @param User $user
     * @param string $gameData
     * @param string $callbackQueryId
     * @return \Illuminate\Http\JsonResponse
     */
    protected function refreshGameInfo($chatId, $messageId, $user, $gameData, $callbackQueryId = '', $telegramUserInfo = null)
    {
        // 重新显示游戏信息
        $result = $this->showGameInfo($chatId, $messageId, $user, $gameData, $telegramUserInfo);
        return $result;
    }

    /**
     * 返回到游戏列表
     *
     * @param int $chatId
     * @param int $messageId
     * @param User $user
     * @param string $categoryCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function backToGameList($chatId, $messageId, $user, $categoryCode)
    {
        return $this->showGameList($chatId, $messageId, $user, $categoryCode);
    }


    /**
     * 获取游戏分类列表
     * 从game_categories表获取游戏类目，返回类目名称和类目编码
     *
     * @return array
     */
    protected function getGameCategories()
    {
        try {
            // 从数据库获取游戏分类，按排序字段排序
            Log::info('开始从数据库获取游戏类目');
            $categories = GameCategory::orderBy('order')->orderBy('id')->get(['name', 'code']);
            Log::info('数据库查询完成', [
                'count' => $categories->count(),
                'categories' => $categories->toArray()
            ]);
            
            $result = [];
            foreach ($categories as $category) {
                $result[] = [
                    'name' => $category->name,
                    'code' => $category->code
                ];
            }
            
            Log::info('返回游戏类目结果', ['result' => $result]);
            return $result;
        } catch (\Exception $e) {
            Log::error('获取游戏类目失败', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            // 返回空数组，避免程序崩溃
            return [];
        }
    }

    /**
     * 根据分类获取游戏列表
     * 通过game_lists表的category_id字段和类目编码匹配获取游戏列表
     * 返回游戏名称(name)、游戏编码(game_code)、游戏平台名称(platform_name)
     *
     * @param string $categoryCode 类目编码
     * @return array
     */
    protected function getGamesByCategory($categoryCode)
    {
        // 从数据库获取游戏列表，通过category_id字段（存储的是类目编码）匹配
        $games = GameList::where('category_id', $categoryCode)
            ->where('app_state', 1) // 只获取APP状态为正常(1)的游戏
            ->orderBy('order_by', 'asc')
            ->get(['name', 'game_code', 'platform_name'])
            ->toArray();

        return $games;
    }

    /**
     * 获取用户游戏余额
     *
     * @param User $user
     * @param string $platformName
     * @param \App\Models\GameList|null $game 游戏对象，用于判断免转状态
     * @return float
     */
    protected function getUserGameBalance($user, $platformName, $game = null)
    {
        try {
            // 判断是否为免转游戏
            // 如果提供了游戏对象，使用游戏的transferstatus；否则默认使用用户余额（免转）
            $isFreeTransfer = true; // 默认免转
            if ($game && isset($game->transferstatus)) {
                $isFreeTransfer = ($game->transferstatus == 0); // 0=免转，1=非免转
            }
            
            if ($isFreeTransfer) {
                // 免转游戏：使用用户的主钱包余额
                return (float)$user->balance;
            } else {
                // 非免转游戏：从user_api表获取该平台的余额
                $userApi = User_Api::where('user_id', $user->id)
                    ->where('api_code', $platformName)
                    ->first();
                
                if ($userApi) {
                    return (float)$userApi->api_money;
                }
                
                // 如果user_api记录不存在，返回0
                return 0;
            }
        } catch (\Exception $e) {
            Log::error('获取游戏余额失败', [
                'user_id' => $user->id,
                'platform' => $platformName,
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }

    /**
     * 根据平台获取分类代码
     *
     * @param string $platformName
     * @return string
     */
    protected function getCategoryCodeByPlatform($platformName)
    {
        $game = GameList::where('platform_name', $platformName)->first();
        return $game->category_id ?? 'concise';
    }

    /**
     * 获取游戏链接（从DP服务获取）
     *
     * @param User $user
     * @param string $platformName
     * @param string $gameCode
     * @param \App\Models\GameList $game
     * @return string|null 游戏链接，如果获取失败则返回null
     */
    protected function getGameUrl($user, $platformName, $gameCode, $game)
    {
        try {
            // 生成注册用的用户名：从游戏的venue_code字段取前2位字母 + 用户名
            // 如果venue_code不存在，则使用platformName
            $venueCode = $game->venue_code ?? $platformName;
            if (!empty($venueCode)) {
                // 提取前2位字母（忽略数字和其他字符）
                preg_match('/[a-zA-Z]{1,2}/', $venueCode, $matches);
                $cleanGameCode = isset($matches[0]) ? strtoupper($matches[0]) : '';
                // 如果提取不到字母，使用原来的逻辑作为后备
                if (empty($cleanGameCode)) {
                    if (preg_match('/[^a-zA-Z0-9]/', $gameCode)) {
                        $cleanGameCode = preg_replace('/[^a-zA-Z0-9]/', '', $gameCode);
                    } else {
                        $cleanGameCode = $gameCode;
                    }
                }
            } else {
                // 如果venue_code和platformName都不存在，使用原来的逻辑作为后备
                if (preg_match('/[^a-zA-Z0-9]/', $gameCode)) {
                    $cleanGameCode = preg_replace('/[^a-zA-Z0-9]/', '', $gameCode);
                } else {
                    $cleanGameCode = $gameCode;
                }
            }
            $dpUserName = $cleanGameCode . $user->username;

            // 确定venueCode（场馆编码），使用游戏信息中的venue_code字段
            $venueCode = $game->venue_code ?? $platformName;
            // 确定gameId，如果gameCode是数字则作为gameId，否则为0
            $gameId = is_numeric($gameCode) ? (int)$gameCode : 0;
            // 币种默认USDT
            $currency = 'USDT';
            // 设备类型：2=h5（适合Telegram Mini App）
            $deviceType = 2;
            // 语言默认zh_CN
            $lang = 'zh_CN';

            Log::info('获取游戏链接 - 调用DP登录接口', [
                'user_id' => $user->id,
                'username' => $user->username,
                'dp_user_name' => $dpUserName,
                'platform' => $platformName,
                'game_code' => $gameCode,
                'venueCode' => $venueCode,
                'gameId' => $gameId,
                'currency' => $currency,
                'deviceType' => $deviceType,
                'lang' => $lang
            ]);

            // 调用DP服务登录接口获取游戏链接
            $loginResult = $this->dpService->login($dpUserName, $venueCode, $currency, $gameId, $deviceType, $lang);

            if ($loginResult['code'] != 200) {
                Log::error('获取游戏链接 - DP登录失败', [
                    'user_id' => $user->id,
                    'platform' => $platformName,
                    'game_code' => $gameCode,
                    'login_result' => $loginResult
                ]);
                return null;
            }

            $gameUrl = $loginResult['data'] ?? null;
            if ($gameUrl) {
                Log::info('获取游戏链接 - 成功', [
                    'user_id' => $user->id,
                    'platform' => $platformName,
                    'game_code' => $gameCode,
                    'game_url_length' => strlen($gameUrl)
                ]);
            }

            return $gameUrl;
        } catch (\Exception $e) {
            Log::error('获取游戏链接 - 异常', [
                'user_id' => $user->id,
                'platform' => $platformName,
                'game_code' => $gameCode,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * 获取游戏类型代码
     *
     * @param string $platformName
     * @return string
     */
    protected function getGameTypeCode($platformName)
    {
        $game = GameList::where('platform_name', $platformName)->first();
        if (!$game) {
            return '1'; // 默认真人
        }

        $categoryMap = [
            'sport' => '5',
            'concise' => '3',
            'gaming' => '7',
            'joker' => '6',
            'lottery' => '4',
            'fishing' => '2',
            'realbet' => '1',
        ];

        return $categoryMap[$game->category_id] ?? '1';
    }

    /**
     * 测试接口
     * 访问方式：GET/POST /api/telegram/test
     * 
     * 测试DP游戏列表获取：action=list（或默认）
     * 参数：venueCode, currency, pageNum, pageSize
     * 
     * 测试DP游戏登录接口：action=login
     * 参数：userName, venueCode, currency, gameId, deviceType, lang, userClientIp
     * 
     * 测试Pussy用户注册：action=pussy_register
     * 参数：userName, password, agent, name, tel, memo, userType（1=玩家，100=代理）
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function test(Request $request)
    {
        try {
            $action = $request->input('action', 'list'); // 测试类型：list=游戏列表，login=登录接口，pussy_register=Pussy注册

            if ($action === 'pussy_register') {
                // 测试Pussy用户/代理注册接口
                $userId = $request->input('userId', ''); // 用户ID（必填，本系统已注册的用户）
                $password = $request->input('password', '123456'); // 密码（默认123456）
                $agent = $request->input('agent', ''); // 代理账号（可选）
                $name = $request->input('name', 'N/A'); // 用户昵称（可选，默认N/A）
                $tel = $request->input('tel', 'N/A'); // 电话（可选，默认N/A）
                $memo = $request->input('memo', 'N/A'); // 备注（可选，默认N/A）
                $userType = (int)$request->input('userType', 1); // 用户类型（1=正式玩家，100=代理，默认1）

                // 获取User对象
                $user = User::find($userId);
                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'code' => 400,
                        'message' => '用户不存在，请先在本系统注册用户',
                        'test_time' => date('Y-m-d H:i:s'),
                    ], 400);
                }

                Log::info('测试Pussy注册接口', [
                    'userId' => $userId,
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'password' => $password,
                    'agent' => $agent,
                    'name' => $name,
                    'tel' => $tel,
                    'memo' => $memo,
                    'userType' => $userType,
                    'request_ip' => $request->ip()
                ]);

                // 调用Pussy服务注册接口
                // 新方法签名：register($password, $agent, $name, $tel, $memo, $userType, $userNamePrefix, $user, $platformName)
                $result = $this->pussyService->register($password, $agent, $name, $tel, $memo, $userType, 'c111111', $user, 'pussy');

                // 返回测试结果
                return response()->json([
                    'success' => $result['code'] == 200,
                    'code' => $result['code'],
                    'message' => $result['message'],
                    'test_time' => date('Y-m-d H:i:s'),
                    'request_params' => [
                        'userName' => $userName,
                        'password' => $password,
                        'agent' => $agent,
                        'name' => $name,
                        'tel' => $tel,
                        'memo' => $memo,
                        'userType' => $userType,
                        'userType_desc' => $userType == 1 ? '正式玩家' : ($userType == 100 ? '代理' : '未知')
                    ],
                    'result' => $result, // 完整返回结果用于调试
                ], $result['code'] == 200 ? 200 : 500);
            } elseif ($action === 'login') {
                // 测试游戏登录接口
                $userName = $request->input('userName', ''); // 玩家账号（必填）
                $venueCode = $request->input('venueCode', ''); // 场馆编码（必填）
                $currency = $request->input('currency', 'USDT'); // 币种，默认USDT
                $gameId = (int)$request->input('gameId', 0); // 平台统一id，默认0
                $deviceType = (int)$request->input('deviceType', 2); // 设备类型，默认2=h5
                $lang = $request->input('lang', 'zh_CN'); // 站点语言，默认zh_CN
                $userClientIp = $request->input('userClientIp', ''); // 用户客户端IP，选填

                Log::info('测试DP游戏登录接口', [
                    'userName' => $userName,
                    'venueCode' => $venueCode,
                    'currency' => $currency,
                    'gameId' => $gameId,
                    'deviceType' => $deviceType,
                    'lang' => $lang,
                    'userClientIp' => $userClientIp,
                    'request_ip' => $request->ip()
                ]);

                // 调用DP服务登录接口
                $result = $this->dpService->login($userName, $venueCode, $currency, $gameId, $deviceType, $lang, $userClientIp);

                // 返回测试结果
                return response()->json([
                    'success' => $result['code'] == 200,
                    'code' => $result['code'],
                    'message' => $result['message'],
                    'game_url' => $result['data'] ?? null,
                    'traceId' => $result['traceId'] ?? '',
                    'test_time' => date('Y-m-d H:i:s'),
                    'request_params' => [
                        'userName' => $userName,
                        'venueCode' => $venueCode,
                        'currency' => $currency,
                        'gameId' => $gameId,
                        'deviceType' => $deviceType,
                        'lang' => $lang,
                        'userClientIp' => $userClientIp,
                    ],
                    'result' => $result, // 完整返回结果用于调试
                ], $result['code'] == 200 ? 200 : 500);
            } else {
                // 测试游戏列表获取（默认）
                $venueCode = $request->input('venueCode', ''); // 场馆编码（必填）
                $currency = $request->input('currency', 'USDT'); // 币种，默认USDT
                $pageNum = (int)$request->input('pageNum', 0); // 分页页码，默认0
                $pageSize = (int)$request->input('pageSize', 10); // 每页数量，默认10，最大500
                
                Log::info('测试DP游戏列表获取', [
                    'venueCode' => $venueCode,
                    'currency' => $currency,
                    'pageNum' => $pageNum,
                    'pageSize' => $pageSize,
                    'request_ip' => $request->ip()
                ]);

                // 调用DP服务获取游戏列表
                $result = $this->dpService->getGameList($venueCode, $currency, $pageNum, $pageSize);

                // 返回测试结果
                return response()->json([
                    'success' => $result['code'] == 200,
                    'code' => $result['code'],
                    'message' => $result['message'],
                    'data' => $result['data'] ?? [],
                    'traceId' => $result['traceId'] ?? '',
                    'total_record' => isset($result['data']['totalRecord']) ? $result['data']['totalRecord'] : 0,
                    'total_page' => isset($result['data']['totalPage']) ? $result['data']['totalPage'] : 0,
                    'list_count' => isset($result['data']['list']) ? count($result['data']['list']) : 0,
                    'raw_response' => $result['raw_response'] ?? null, // 用于调试
                    'test_time' => date('Y-m-d H:i:s'),
                    'request_params' => [
                        'venueCode' => $venueCode,
                        'currency' => $currency,
                        'pageNum' => $pageNum,
                        'pageSize' => $pageSize,
                    ],
                ], $result['code'] == 200 ? 200 : 500);
            }

        } catch (\Exception $e) {
            Log::error('测试DP接口异常', [
                'action' => $action ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => '测试失败：' . $e->getMessage(),
                'error' => $e->getMessage(),
                'test_time' => date('Y-m-d H:i:s'),
            ], 500);
        }
    }

    /**
     * 获取常驻键盘菜单配置
     * 
     * @return array
     */
    protected function getPersistentKeyboard()
    {
        // 从系统配置读取地址
        $gameUrl = SystemConfig::getValue('telegram_bot_game_url') ?: (SystemConfig::getValue('h5_url') ?: 'https://epay.266982.xyz/');
        $officialUrl = SystemConfig::getValue('telegram_bot_official_url') ?: (SystemConfig::getValue('h5_url') ?: 'https://epay.266982.xyz/');

        // 调试日志
        file_put_contents(storage_path('logs/telegram_webhook.log'),
            date('Y-m-d H:i:s') . " === getPersistentKeyboard 调试 ===\n" .
            "gameUrl: {$gameUrl}\n" .
            "officialUrl: {$officialUrl}\n" .
            "---\n", FILE_APPEND);

        return [
            // 第一行：进入游戏按钮（普通文本按钮，点击后发送带Inline Keyboard的消息）
            [
                ['text' => '🎮 游戏入口']
            ],
            // 第二行：账户余额、官方入口（web_app类型）
            [
                ['text' => '💰 账户余额'],
                [
                    'text' => '🏅 官方入口',
                    'web_app' => [
                        'url' => $officialUrl
                    ]
                ]
            ],
            // 第三行：在线客服、招商代理
            [
                ['text' => '🤷 在线客服'],
                ['text' => '🤝 招商代理']
            ]
        ];
    }

    /**
     * 发送游戏入口消息（带 Inline Keyboard）
     * 用户点击 Inline Keyboard 的 web_app 按钮后可以自动登录
     *
     * @param int $chatId
     * @param User $user
     * @param array|null $telegramUserInfo Telegram 用户信息（可选）
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendGameEntryMessage($chatId, $user, $telegramUserInfo = null)
    {
        // 从系统配置读取游戏入口地址
        $gameUrl = SystemConfig::getValue('telegram_bot_game_url') ?: (SystemConfig::getValue('h5_url') ?: 'https://epay.266982.xyz/');

        // 构建 Inline Keyboard（web_app 类型，点击后会传递 initData）
        $inlineKeyboard = [[
            [
                'text' => '🎮 立即进入游戏',
                'web_app' => [
                    'url' => $gameUrl
                ]
            ]
        ]];

        // 发送消息
        $telegramUsername = null;
        if ($telegramUserInfo && isset($telegramUserInfo['username'])) {
            $telegramUsername = $telegramUserInfo['username'];
        }
        $displayName = $this->getTelegramDisplayName($user, $telegramUsername);
        $result = $this->telegramBot->sendMessageWithInlineKeyboard(
            $chatId,
            "🎮 点击下方按钮进入游戏\n\n欢迎回来，{$displayName}！",
            $inlineKeyboard
        );

        if ($result['code'] != 200) {
            Log::error('发送游戏入口消息失败', [
                'chat_id' => $chatId,
                'result' => $result
            ]);
        }

        return response()->json(['ok' => true]);
    }

    /**
     * 设置常驻键盘菜单
     *
     * @param int $chatId
     * @return void
     */
    protected function setPersistentKeyboard($chatId)
    {
        $replyKeyboard = $this->getPersistentKeyboard();
        
        // 发送一条消息来设置键盘，使用空格作为文本（Telegram 不允许空文本，但可以用空格）
        // 注意：Telegram会自动显示键盘，即使消息被删除，键盘也会保留
        $keyboardResult = $this->telegramBot->sendMessageWithReplyKeyboard(
            $chatId,
            ' ',  // 使用空格，Telegram 不允许空文本但允许空格
            $replyKeyboard,
            true,  // resize_keyboard
            false  // one_time_keyboard (false表示常驻，键盘会一直显示)
        );
        
        if ($keyboardResult['code'] == 200) {
            Log::info('设置常驻键盘菜单成功', [
                'chat_id' => $chatId,
                'message_id' => $keyboardResult['data']['result']['message_id'] ?? null
            ]);
            // 不删除消息，让键盘正常显示（Telegram会自动显示键盘在输入框下方）
        } else {
            Log::warning('设置常驻键盘菜单失败', [
                'chat_id' => $chatId,
                'result' => $keyboardResult
            ]);
        }
    }
    
    /**
     * 调试方法 - 检查Telegram Bot配置和连接
     * 访问方式：GET/POST /api/telegram/debug
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function debug(Request $request)
    {
        try {
            $botToken = \App\Models\SystemConfig::getValue('telegram_bot_token') ?? env('TELEGRAM_BOT_TOKEN');
            
            $debugInfo = [
                'bot_token_configured' => !empty($botToken),
                'bot_token_length' => strlen($botToken ?? ''),
                'bot_token_preview' => !empty($botToken) ? substr($botToken, 0, 10) . '...' : '未配置',
                'api_url' => !empty($botToken) ? 'https://api.telegram.org/bot' . $botToken . '/' : '未配置',
                'webhook_url' => env('APP_URL') . '/api/telegram/webhook',
                'test_time' => date('Y-m-d H:i:s'),
            ];

            // 尝试获取Bot信息
            if (!empty($botToken)) {
                try {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . $botToken . '/getMe');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $botInfo = json_decode($response, true);
                    $debugInfo['bot_info'] = $botInfo;
                    $debugInfo['bot_connected'] = isset($botInfo['ok']) && $botInfo['ok'] === true;
                } catch (\Exception $e) {
                    $debugInfo['bot_connected'] = false;
                    $debugInfo['bot_connection_error'] = $e->getMessage();
                }
            }

            // 检查Webhook状态
            if (!empty($botToken)) {
                try {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . $botToken . '/getWebhookInfo');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $webhookInfo = json_decode($response, true);
                    $debugInfo['webhook_info'] = $webhookInfo;
                } catch (\Exception $e) {
                    $debugInfo['webhook_check_error'] = $e->getMessage();
                }
            }

            return response()->json([
                'success' => true,
                'debug_info' => $debugInfo,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Telegram Web App 自动登录接口
     * 验证 initData 签名，自动注册/登录用户
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function webappAuth(Request $request)
    {
        // 【调试日志】记录请求开始
        Log::info('=== Telegram WebApp 自动登录请求开始 ===', [
            'time' => date('Y-m-d H:i:s'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        try {
            $initData = $request->input('init_data');

            // 【调试日志】记录收到的 init_data
            Log::info('收到 init_data', [
                'init_data_length' => strlen($initData ?? ''),
                'init_data_preview' => substr($initData ?? '', 0, 300),
                'init_data_full' => $initData
            ]);

            if (empty($initData)) {
                Log::warning('init_data 为空，返回 400');
                return response()->json([
                    'code' => 400,
                    'message' => '缺少 init_data 参数'
                ]);
            }

            // 验证 Telegram 签名
            Log::info('开始验证 Telegram 签名...');
            $validationResult = $this->validateTelegramWebAppData($initData);

            // 【调试日志】记录验证结果
            Log::info('签名验证结果', [
                'valid' => $validationResult['valid'],
                'error' => $validationResult['error'],
                'user_data' => $validationResult['user']
            ]);

            if (!$validationResult['valid']) {
                Log::warning('Telegram WebApp 签名验证失败', [
                    'error' => $validationResult['error'],
                    'init_data' => substr($initData, 0, 200)
                ]);
                // 使用 403 而非 401，避免触发前端的"登录过期"弹窗
                return response()->json([
                    'code' => 403,
                    'message' => '签名验证失败：' . $validationResult['error']
                ]);
            }

            $userData = $validationResult['user'];

            // 检查 userData 是否存在
            if (empty($userData) || !is_array($userData)) {
                Log::warning('用户数据为空或格式错误', [
                    'user_data' => $userData
                ]);
                return response()->json([
                    'code' => 400,
                    'message' => '无法获取用户信息：用户数据为空'
                ]);
            }

            $telegramId = $userData['id'] ?? null;

            // 【调试日志】记录用户数据
            Log::info('解析用户数据', [
                'telegram_id' => $telegramId,
                'username' => $userData['username'] ?? 'N/A',
                'first_name' => $userData['first_name'] ?? 'N/A',
                'last_name' => $userData['last_name'] ?? 'N/A'
            ]);

            if (!$telegramId) {
                Log::warning('无法获取 telegram_id，返回 400');
                return response()->json([
                    'code' => 400,
                    'message' => '无法获取用户信息'
                ]);
            }

            // 查找或创建用户
            Log::info('查找用户...', ['telegram_id' => $telegramId]);
            $user = User::where('telegram_id', $telegramId)->first();
            $isNewUser = false;
            $firstPassword = null;

            if (!$user) {
                Log::info('用户不存在，开始注册新用户...');
                // 自动注册用户
                $username = $userData['username'] ?? '';
                $firstName = $userData['first_name'] ?? '';
                $user = $this->registerUserFromTelegram($telegramId, $username, $firstName);

                if (!$user) {
                    Log::error('用户注册失败', [
                        'telegram_id' => $telegramId,
                        'username' => $username,
                        'first_name' => $firstName
                    ]);
                    return response()->json([
                        'code' => 500,
                        'message' => '用户注册失败'
                    ]);
                }

                $isNewUser = true;
                $firstPassword = $user->first_password;

                // 清空 first_password，确保只返回一次
                $user->first_password = null;
                $user->save();

                Log::info('Telegram WebApp 新用户注册成功', [
                    'telegram_id' => $telegramId,
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'has_first_password' => !empty($firstPassword)
                ]);
            } else {
                Log::info('找到已存在用户', [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'telegram_id' => $user->telegram_id
                ]);
            }

            // 确保用户有 api_token
            if (empty($user->api_token)) {
                Log::info('用户没有 api_token，生成新 token');
                $user->api_token = Str::random(60);
                $user->save();
            }

            Log::info('Telegram WebApp 登录成功', [
                'telegram_id' => $telegramId,
                'user_id' => $user->id,
                'username' => $user->username,
                'is_new_user' => $isNewUser,
                'api_token_preview' => substr($user->api_token, 0, 10) . '...'
            ]);

            $responseData = [
                'api_token' => $user->api_token,
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'telegram_id' => $user->telegram_id
                ],
                'is_new_user' => $isNewUser
            ];

            // 仅新用户首次返回密码
            if ($isNewUser && $firstPassword) {
                $responseData['first_password'] = $firstPassword;
            }

            Log::info('=== Telegram WebApp 自动登录请求完成 ===', [
                'code' => 200,
                'is_new_user' => $isNewUser
            ]);

            return response()->json([
                'code' => 200,
                'message' => $isNewUser ? '注册成功' : '登录成功',
                'data' => $responseData
            ]);

        } catch (\Exception $e) {
            Log::error('Telegram WebApp 登录异常', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'code' => 500,
                'message' => '服务器错误：' . $e->getMessage()
            ]);
        }
    }

    /**
     * 验证 Telegram Web App initData 签名
     *
     * @param string $initData
     * @return array ['valid' => bool, 'user' => array|null, 'error' => string|null]
     */
    protected function validateTelegramWebAppData($initData)
    {
        Log::info('--- 开始验证 Telegram WebApp initData ---');

        try {
            // 获取 Bot Token
            $botToken = SystemConfig::getValue('telegram_bot_token') ?? env('TELEGRAM_BOT_TOKEN');

            Log::info('Bot Token 获取状态', [
                'from_db' => !empty(SystemConfig::getValue('telegram_bot_token')),
                'from_env' => !empty(env('TELEGRAM_BOT_TOKEN')),
                'token_length' => strlen($botToken ?? ''),
                'token_preview' => $botToken ? substr($botToken, 0, 10) . '...' : 'NULL'
            ]);

            if (empty($botToken)) {
                Log::error('Bot Token 未配置！');
                return ['valid' => false, 'user' => null, 'error' => 'Bot Token 未配置'];
            }

            // 解析 initData
            parse_str($initData, $data);

            Log::info('解析 initData 结果', [
                'keys' => array_keys($data),
                'has_hash' => isset($data['hash']),
                'has_user' => isset($data['user']),
                'has_auth_date' => isset($data['auth_date']),
                'auth_date' => $data['auth_date'] ?? 'N/A',
                'query_id' => $data['query_id'] ?? 'N/A'
            ]);

            if (!isset($data['hash'])) {
                Log::warning('缺少 hash 参数');
                return ['valid' => false, 'user' => null, 'error' => '缺少 hash 参数'];
            }

            $hash = $data['hash'];
            unset($data['hash']);

            Log::info('提取的 hash 值', [
                'hash' => $hash,
                'hash_length' => strlen($hash)
            ]);

            // 按字母顺序排序
            ksort($data);

            // 构建数据字符串
            $dataCheckString = '';
            foreach ($data as $key => $value) {
                $dataCheckString .= $key . '=' . $value . "\n";
            }
            $dataCheckString = rtrim($dataCheckString, "\n");

            Log::info('构建的数据校验字符串', [
                'data_check_string' => $dataCheckString,
                'string_length' => strlen($dataCheckString)
            ]);

            // 生成密钥：HMAC-SHA256(bot_token, "WebAppData")
            // PHP hash_hmac(algo, data, key): data=bot_token, key="WebAppData"
            // 对应 Python: hmac.new(key=b"WebAppData", msg=token.encode())
            $secretKey = hash_hmac('sha256', $botToken, 'WebAppData', true);

            Log::info('生成密钥', [
                'secret_key_hex' => bin2hex($secretKey)
            ]);

            // 生成签名
            $calculatedHash = bin2hex(hash_hmac('sha256', $dataCheckString, $secretKey, true));

            Log::info('签名对比', [
                'received_hash' => $hash,
                'calculated_hash' => $calculatedHash,
                'match' => hash_equals($calculatedHash, $hash)
            ]);

            // 验证签名
            if (!hash_equals($calculatedHash, $hash)) {
                Log::warning('签名不匹配！', [
                    'expected' => $calculatedHash,
                    'received' => $hash
                ]);
                return ['valid' => false, 'user' => null, 'error' => '签名不匹配'];
            }

            Log::info('签名验证通过！');

            // 验证时效性（24小时内有效）
            if (isset($data['auth_date'])) {
                $authDate = (int)$data['auth_date'];
                $now = time();
                $diff = $now - $authDate;

                Log::info('时效性验证', [
                    'auth_date' => $authDate,
                    'auth_date_formatted' => date('Y-m-d H:i:s', $authDate),
                    'now' => $now,
                    'now_formatted' => date('Y-m-d H:i:s', $now),
                    'diff_seconds' => $diff,
                    'diff_hours' => round($diff / 3600, 2),
                    'is_expired' => $diff > 86400 || $diff < 0
                ]);

                // 检查是否过期（超过24小时）或时间异常（未来时间）
                if ($diff > 86400) {
                    Log::warning('认证已过期', ['diff_hours' => round($diff / 3600, 2)]);
                    return ['valid' => false, 'user' => null, 'error' => '认证已过期'];
                }
                if ($diff < -300) { // 允许5分钟的时间误差
                    Log::warning('auth_date 时间异常（未来时间）', ['diff_seconds' => $diff]);
                    return ['valid' => false, 'user' => null, 'error' => '认证时间异常'];
                }
            }

            // 解析用户信息
            $user = null;
            if (isset($data['user'])) {
                $user = json_decode($data['user'], true);
                Log::info('解析用户信息', [
                    'user_json' => $data['user'],
                    'user_parsed' => $user
                ]);
            } else {
                Log::warning('initData 中没有 user 字段');
            }

            Log::info('--- Telegram WebApp initData 验证完成，结果：通过 ---');

            return ['valid' => true, 'user' => $user, 'error' => null];

        } catch (\Exception $e) {
            Log::error('验证 Telegram WebApp 签名异常', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return ['valid' => false, 'user' => null, 'error' => '验证异常：' . $e->getMessage()];
        }
    }

    /**
     * 获取用户流水明细
     * 
     * @param User $user
     * @return string 流水明细文本
     */
    protected function getUserFlowDetail($user)
    {
        // 从数据库读取游戏分类（按 order 排序）
        $categories = GameCategory::orderBy('order')->orderBy('id')->get(['id', 'name', 'code']);
        
        // 今日开始和结束时间
        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd = date('Y-m-d 23:59:59');
        
        // 昨日开始和结束时间
        $yesterdayStart = date('Y-m-d 00:00:00', strtotime('-1 day'));
        $yesterdayEnd = date('Y-m-d 23:59:59', strtotime('-1 day'));
        
        // 初始化分类流水数组
        $todayFlows = [];
        $yesterdayFlows = [];
        
        // 遍历每个分类，统计流水
        foreach ($categories as $category) {
            $categoryCode = $category->code;
            $categoryName = $category->name;
            
            // 获取该分类下的所有平台名称（通过 game_lists 表的 category_id 字段关联）
            $platformNames = GameList::where('category_id', $categoryCode)
                ->where('app_state', 1)
                ->pluck('platform_name')
                ->toArray();
            
            if (empty($platformNames)) {
                // 如果该分类下没有平台，流水为0
                $todayFlows[$categoryCode] = ['total_valid' => 0, 'name' => $categoryName];
                $yesterdayFlows[$categoryCode] = ['total_valid' => 0, 'name' => $categoryName];
                continue;
            }
            
            // 查询今日流水：通过 platform_type 关联到 game_lists.platform_name，再关联到分类
            $todayFlow = GameRecord::where('user_id', $user->id)
                ->where('status', 1) // 只统计已结算的
                ->whereIn('platform_type', $platformNames)
                ->whereBetween('bet_time', [$todayStart, $todayEnd])
                ->select(DB::raw('SUM(valid_amount) as total_valid'))
                ->first();
            
            $todayFlows[$categoryCode] = [
                'total_valid' => $todayFlow->total_valid ?? 0,
                'name' => $categoryName
            ];
            
            // 查询昨日流水
            $yesterdayFlow = GameRecord::where('user_id', $user->id)
                ->where('status', 1) // 只统计已结算的
                ->whereIn('platform_type', $platformNames)
                ->whereBetween('bet_time', [$yesterdayStart, $yesterdayEnd])
                ->select(DB::raw('SUM(valid_amount) as total_valid'))
                ->first();
            
            $yesterdayFlows[$categoryCode] = [
                'total_valid' => $yesterdayFlow->total_valid ?? 0,
                'name' => $categoryName
            ];
        }
        
        // 今日总流水和输赢（所有分类）
        $todayTotal = GameRecord::where('user_id', $user->id)
            ->where('status', 1)
            ->whereBetween('bet_time', [$todayStart, $todayEnd])
            ->select(
                DB::raw('SUM(valid_amount) as total_flow'),
                DB::raw('SUM(win_loss) as total_winloss')
            )
            ->first();
        
        $todayTotalFlow = $todayTotal->total_flow ?? 0;
        $todayWinLoss = $todayTotal->total_winloss ?? 0;
        
        // 注册时间
        $registerTime = $user->created_at ? date('Y-m-d H:i:s', strtotime($user->created_at)) : '未知';
        
        // 构建显示文本
        $text = '';
        
        // 今日流水（按分类显示）
        $text .= "💎 <b>今日流水</b>\n";
        foreach ($categories as $category) {
            $categoryCode = $category->code;
            $categoryName = $category->name;
            // 移除emoji，只保留中文名称
            $cleanName = preg_replace('/[\x{1F300}-\x{1F9FF}]/u', '', $categoryName);
            $cleanName = trim($cleanName);
            $flowAmount = $todayFlows[$categoryCode]['total_valid'] ?? 0;
            $text .= "🔸 今日{$cleanName}流水: " . number_format($flowAmount, 2) . " USDT\n";
        }
        
        // 昨日流水（按分类显示）
        $text .= "\n💎 <b>昨日流水</b>\n";
        foreach ($categories as $category) {
            $categoryCode = $category->code;
            $categoryName = $category->name;
            // 移除emoji，只保留中文名称
            $cleanName = preg_replace('/[\x{1F300}-\x{1F9FF}]/u', '', $categoryName);
            $cleanName = trim($cleanName);
            $flowAmount = $yesterdayFlows[$categoryCode]['total_valid'] ?? 0;
            $text .= "🔹 昨日{$cleanName}流水: " . number_format($flowAmount, 2) . " USDT\n";
        }
        
        // 提示信息
        $text .= "\n💡 (流水更新大约有十分钟延迟哦~)\n\n";
        
        // 今日流水总计和输赢
        $text .= "🔸 今日流水: " . number_format($todayTotalFlow, 2) . " USDT\n";
        $text .= "🔸 今日输赢: " . number_format($todayWinLoss, 2) . " USDT\n";
        $text .= "🔹 注册时间: {$registerTime}\n\n";
        
        // 预计反水、下级总流水、预计返佣、还需完成流水（暂时设为0，后续可根据实际需求实现）
        $text .= "🔸 预计反水: 0.00 USDT\n";
        $text .= "🔸 下级总流水: 0 USDT\n";
        $text .= "🔸 预计返佣: 0.00 USDT\n";
        $text .= "🔹 还需完成流水: 0.00 USDT";
        
        return $text;
    }

    /**
     * 显示帮助信息（在线客服）
     * 
     * @param int $chatId
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showHelpMessage($chatId, $user)
    {
        try {
            // 获取客服用户名（从系统配置获取，如果没有则使用默认值）
            $serviceUsername = SystemConfig::getValue('kefu_username') ?: 'JZTYKF';
            $currentTime = date('H:i');
            
            // 构建消息文本
            $text = "💻 在线值班 @{$serviceUsername} {$currentTime}";
            
            // 构建内联键盘按钮
            $inlineKeyboard = [
                [
                    [
                        'text' => '🤖 双向客服',
                        'url' => SystemConfig::getValue('kf_url') ?: 'https://www.baidu.com'
                    ]
                ],
                [
                    [
                        'text' => '🏠 返回主菜单',
                        'callback_data' => 'back_main'
                    ]
                ]
            ];
            
            // 发送消息
            $result = $this->telegramBot->sendMessageWithInlineKeyboard($chatId, $text, $inlineKeyboard);
            
            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('显示帮助信息失败', [
                'chat_id' => $chatId,
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }

    // ==================== 用户状态管理 ====================

    // 状态常量
    const STATE_WAITING_RECHARGE_AMOUNT = 'waiting_recharge_amount';
    const STATE_WAITING_WITHDRAW_AMOUNT = 'waiting_withdraw_amount';
    const STATE_WAITING_WITHDRAW_ADDRESS = 'waiting_withdraw_address';

    /**
     * 获取用户状态缓存键
     */
    protected function getUserStateCacheKey($telegramId)
    {
        return 'telegram_user_state:' . $telegramId;
    }

    /**
     * 获取用户状态
     */
    protected function getUserState($telegramId)
    {
        return Cache::get($this->getUserStateCacheKey($telegramId));
    }

    /**
     * 设置用户状态
     */
    protected function setUserState($telegramId, $state)
    {
        // 状态10分钟过期
        Cache::put($this->getUserStateCacheKey($telegramId), $state, now()->addMinutes(10));
    }

    /**
     * 清除用户状态
     */
    protected function clearUserState($telegramId)
    {
        Cache::forget($this->getUserStateCacheKey($telegramId));
    }

    // ==================== 充值提现菜单 ====================

    /**
     * 显示充值提现二级菜单
     */
    protected function showDepositWithdrawMenu($chatId, $messageId, $user, $notice = null)
    {
        try {
            // 获取用户余额
            $walletBalance = number_format($user->balance, 2);

            $text = "💰 <b>充值提现</b>\n\n";
            $text .= "💵 余额：<b>{$walletBalance}</b> 元";
            if ($notice) {
                $text .= "\n\n" . $notice;
            }

            $inlineKeyboard = [
                [
                    ['text' => '💵 充值', 'callback_data' => 'recharge'],
                    ['text' => '💸 提现', 'callback_data' => 'withdraw']
                ],
                [
                    ['text' => '🏠 返回主菜单', 'callback_data' => 'back_main']
                ]
            ];

            // 编辑图片消息的caption和按钮（图片保持不变）
            $result = $this->telegramBot->editMessageCaptionWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
            if ($result['code'] != 200) {
                $result = $this->telegramBot->editMessageTextWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
                if ($result['code'] != 200) {
                    Log::error('显示充值提现菜单失败', ['result' => $result]);
                }
            }
            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('显示充值提现菜单异常', ['error' => $e->getMessage()]);
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * 显示充值网络选择菜单
     */
    protected function showRechargeNetworkMenu($chatId, $messageId, $user, $notice = null)
    {
        try {
            $text = "💵 <b>充值</b>\n\n";
            $text .= "请选择充值网络：";
            if ($notice) {
                $text .= "\n" . $notice;
            }

            $inlineKeyboard = [
                [['text' => '1️⃣ USDT(TRC20)', 'callback_data' => 'recharge_trc20']],
                [['text' => '2️⃣ USDT(ERC20)', 'callback_data' => 'recharge_erc20']],
                [
                    ['text' => '↩️ 返回', 'callback_data' => 'back_to_deposit_withdraw']
                ]
            ];

            // 编辑图片消息的caption和按钮（图片保持不变）
            $result = $this->telegramBot->editMessageCaptionWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
            if ($result['code'] != 200) {
                $result = $this->telegramBot->editMessageTextWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
                if ($result['code'] != 200) {
                    Log::error('显示充值网络菜单失败', ['result' => $result]);
                }
            }
            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('显示充值网络菜单异常', ['error' => $e->getMessage()]);
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * 显示提现网络选择菜单
     */
    protected function showWithdrawNetworkMenu($chatId, $messageId, $user, $notice = null)
    {
        try {
            $text = "💸 <b>提现</b>\n\n";
            $text .= "当前余额：" . number_format($user->balance, 2) . " 元\n\n";
            $text .= "请选择提现网络：";
            if ($notice) {
                $text .= "\n" . $notice;
            }

            $inlineKeyboard = [
                [['text' => '1️⃣ USDT(TRC20)', 'callback_data' => 'withdraw_trc20']],
                [['text' => '2️⃣ USDT(ERC20)', 'callback_data' => 'withdraw_erc20']],
                [
                    ['text' => '↩️ 返回', 'callback_data' => 'back_to_deposit_withdraw']
                ]
            ];

            // 编辑图片消息的caption和按钮（图片保持不变）
            $result = $this->telegramBot->editMessageCaptionWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
            if ($result['code'] != 200) {
                $result = $this->telegramBot->editMessageTextWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
                if ($result['code'] != 200) {
                    Log::error('显示提现网络菜单失败', ['result' => $result]);
                }
            }
            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('显示提现网络菜单异常', ['error' => $e->getMessage()]);
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }

    // ==================== 充值流程 ====================

    /**
     * 处理TRC20充值
     */
    protected function handleRechargeTrc20($chatId, $messageId, $user, $telegramId)
    {
        try {
            // 检查是否有待支付订单
            $pendingOrder = Recharge::where('user_id', $user->id)
                ->where('state', 1)
                ->where('tron_network', 'TRC20')
                ->where('created_at', '>=', now()->subMinutes(10))
                ->first();

            if ($pendingOrder) {
                // 有待支付订单，直接显示
                return $this->showPendingRechargeOrder($chatId, $messageId, $user, $pendingOrder);
            }

            // 获取充值限额
            $minAmount = SystemConfig::getValue('tron_min_amount') ?: 10;
            $maxAmount = SystemConfig::getValue('tron_max_amount') ?: 50000;
            $exchangeRate = SystemConfig::getValue('tron_exchange_rate') ?: 7;

            // 进入输入金额状态
            $this->setUserState($telegramId, [
                'action' => self::STATE_WAITING_RECHARGE_AMOUNT,
                'network' => 'TRC20',
                'message_id' => $messageId,
                'created_at' => now()->toDateTimeString()
            ]);

            $text = "💵 <b>TRC20 USDT 充值</b>\n\n";
            $text .= "当前汇率：1 USDT = {$exchangeRate} 元\n";
            $text .= "充值限额：<code>{$minAmount}</code> - <code>{$maxAmount}</code> USDT\n\n";
            $text .= "📝 请输入充值金额（USDT）：";

            $inlineKeyboard = [
                [['text' => '❌ 取消', 'callback_data' => 'cancel_input']]
            ];

            // 编辑图片消息的caption和按钮（图片保持不变）
            $result = $this->telegramBot->editMessageCaptionWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
            if ($result['code'] != 200) {
                $this->telegramBot->editMessageTextWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
            }
            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('处理TRC20充值异常', ['error' => $e->getMessage()]);
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * 显示待支付充值订单
     */
    protected function showPendingRechargeOrder($chatId, $messageId, $user, $order)
    {
        try {
            // 获取二维码图片URL
            $qrcodeUrl = SystemConfig::getValue('tron_usdt_qrcode');
            if ($qrcodeUrl) {
                $qrcodeUrl = env('APP_URL') . '/uploads/' . $qrcodeUrl;
            }

            $tronAddress = SystemConfig::getValue('tron_usdt_address');
            $exchangeRate = SystemConfig::getValue('tron_exchange_rate') ?: 7;

            $text = "📋 <b>待支付充值订单</b>\n\n";
            $text .= "订单号：<code>{$order->out_trade_no}</code>\n";
            $text .= "充值金额：<b>{$order->amount}</b> 元\n";
            $text .= "需支付：<b>{$order->tron_usdt_amount}</b> USDT\n";
            $text .= "汇率：1 USDT = {$exchangeRate} 元\n\n";
            $text .= "📮 收款地址(TRC20)：\n<code>{$tronAddress}</code>\n\n";
            $text .= "⚠️ 请务必转账准确金额\n";
            $text .= "⏰ 订单将在10分钟后过期";

            $inlineKeyboard = [
                [['text' => '❌ 取消订单', 'callback_data' => 'cancel_recharge_order:' . $order->id]],
                [['text' => '↩️ 返回', 'callback_data' => 'back_to_deposit_withdraw']]
            ];

            // 发送新消息显示订单信息
            if ($qrcodeUrl) {
                $result = $this->telegramBot->sendPhotoWithInlineKeyboard($chatId, $qrcodeUrl, $text, $inlineKeyboard);
                // 如果图片发送失败，降级为纯文字消息
                if ($result['code'] != 200) {
                    Log::warning('待支付订单二维码图片发送失败，降级为纯文字', [
                        'chat_id' => $chatId,
                        'qrcode_url' => $qrcodeUrl,
                        'result' => $result
                    ]);
                    $this->telegramBot->sendMessageWithInlineKeyboard($chatId, $text, $inlineKeyboard);
                }
            } else {
                // 没有二维码时发送纯文字消息
                $this->telegramBot->sendMessageWithInlineKeyboard($chatId, $text, $inlineKeyboard);
            }

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('显示待支付订单异常', ['error' => $e->getMessage()]);
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * 取消充值订单
     */
    protected function cancelRechargeOrder($chatId, $messageId, $user, $orderId, $telegramId)
    {
        try {
            $order = Recharge::where('id', $orderId)
                ->where('user_id', $user->id)
                ->where('state', 1)
                ->first();

            if ($order) {
                // 释放 Redis 金额占用
                if (!empty($order->tron_usdt_amount)) {
                    $tronService = new TronUsdtService();
                    $tronService->releaseAmount((float)$order->tron_usdt_amount);
                }

                $order->state = 4;
                $order->info = '用户取消订单';
                $order->save();
            }

            $this->clearUserState($telegramId);
            
            // 使用 editMessageMedia 替换图片（无消失特效）
            $mainImageUrl = $this->getMainMenuImageUrl();
            $walletBalance = number_format($user->balance, 2);
            $text = "💰 <b>充值提现</b>\n\n";
            $text .= "💵 余额：<b>{$walletBalance}</b> 元\n\n";
            $text .= "✅ 订单已取消";
            
            $inlineKeyboard = [
                [
                    ["text" => "💵 充值", "callback_data" => "recharge"],
                    ["text" => "💸 提现", "callback_data" => "withdraw"]
                ],
                [
                    ["text" => "🏠 返回主菜单", "callback_data" => "back_main"]
                ]
            ];
            
            $this->telegramBot->editMessageMedia($chatId, $messageId, $mainImageUrl, $text, $inlineKeyboard);
            return response()->json(["ok" => true]);
        } catch (\Exception $e) {
            Log::error('取消充值订单异常', ['error' => $e->getMessage()]);
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * 处理充值金额输入
     */
    protected function processRechargeAmountInput($chatId, $user, $telegramId, $amount, $state)
    {
        try {
            // 验证金额格式
            if (!is_numeric($amount) || $amount <= 0) {
                $this->telegramBot->sendMessage($chatId, '❌ 请输入有效的金额数字');
                return response()->json(['ok' => true]);
            }

            $amount = floatval($amount);
            $minAmount = floatval(SystemConfig::getValue('tron_min_amount') ?: 10);
            $maxAmount = floatval(SystemConfig::getValue('tron_max_amount') ?: 50000);

            if ($amount < $minAmount || $amount > $maxAmount) {
                $this->telegramBot->sendMessage($chatId, "❌ 充值金额必须在 {$minAmount} - {$maxAmount} USDT 之间");
                return response()->json(['ok' => true]);
            }

            // 调用 TronUsdtService 生成充值订单
            $tronService = new TronUsdtService();
            $exchangeRate = SystemConfig::getValue('tron_exchange_rate') ?: 7;
            // 将USDT金额转换为人民币金额
            $amountCny = $amount * $exchangeRate;

            $rechargeInfo = $tronService->generateRechargeInfo($amountCny, $user->id);

            if (!$rechargeInfo['success']) {
                $this->telegramBot->sendMessage($chatId, '❌ 生成订单失败：' . ($rechargeInfo['message'] ?? '未知错误'));
                return response()->json(['ok' => true]);
            }

            // 创建充值记录
            $order = Recharge::create([
                'out_trade_no' => $rechargeInfo['data']['out_trade_no'],
                'user_id' => $user->id,
                'pay_way' => 5,  // USDT-TRC20
                'amount' => $amountCny,
                'cash_fee' => 0,
                'real_money' => $amountCny,
                'usdt_rate' => $exchangeRate,
                'state' => 1,
                'tron_network' => 'TRC20',
                'tron_usdt_amount' => $rechargeInfo['data']['usdt_amount'],
                'info' => 'Telegram TRC20充值'
            ]);

            // 清除状态
            $this->clearUserState($telegramId);

            // 显示充值信息
            $qrcodeUrl = SystemConfig::getValue('tron_usdt_qrcode');
            if ($qrcodeUrl) {
                $qrcodeUrl = env('APP_URL') . '/uploads/' . $qrcodeUrl;
            }

            $tronAddress = SystemConfig::getValue('tron_usdt_address');
            $expireTime = now()->addMinutes(10)->format('Y-m-d H:i:s');
            $usdtAmount = $rechargeInfo['data']['usdt_amount'];

            // 构建订单信息文本（紧接图片，无标题）
            $text = "编号：{$order->id}\n";
            $text .= "金额：{$usdtAmount} USDT\n";
            $text .= "过期时间：{$expireTime}\n";
            $text .= "--------------------------------\n";
            $text .= "收款地址（点击复制）👇\n";
            $text .= "<code>{$tronAddress}</code>\n";
            $text .= "--------------------------------\n";
            $text .= "⚠️ 支付金额可能会出现附加小数\n";
            $text .= "⚠️ 尾数金额也必须正确\n";
            $text .= "✅ 充值未到账，请联系客服";

            $inlineKeyboard = [
                [['text' => '❌ 取消订单', 'callback_data' => 'cancel_recharge_order:' . $order->id]]
            ];

            // 发送二维码图片+订单信息+按钮（作为一条消息）
            if ($qrcodeUrl) {
                $result = $this->telegramBot->sendPhotoWithInlineKeyboard($chatId, $qrcodeUrl, $text, $inlineKeyboard);
                if ($result["code"] != 200) {
                    Log::warning("充值订单发送失败", [
                        "chat_id" => $chatId,
                        "qrcode_url" => $qrcodeUrl,
                        "result" => $result
                    ]);
                    // 降级：图片发送失败时只发文字
                    $this->telegramBot->sendMessageWithInlineKeyboard($chatId, $text, $inlineKeyboard);
                }
            } else {
                // 没有二维码时只发文字
                $this->telegramBot->sendMessageWithInlineKeyboard($chatId, $text, $inlineKeyboard);
            }

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('处理充值金额输入异常', ['error' => $e->getMessage()]);
            $this->telegramBot->sendMessage($chatId, '❌ 处理失败：' . $e->getMessage());
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }

    // ==================== 提现流程 ====================

    /**
     * 处理TRC20提现
     */
    protected function handleWithdrawTrc20($chatId, $messageId, $user, $telegramId)
    {
        try {
            // 检查是否有待审核提现订单
            $pendingWithdraw = Withdraw::where('user_id', $user->id)
                ->where('state', 1)
                ->first();

            if ($pendingWithdraw) {
                $text = "⏳ <b>您有待审核的提现订单</b>\n\n";
                $text .= "订单号：<code>{$pendingWithdraw->order_no}</code>\n";
                $text .= "提现金额：<b>{$pendingWithdraw->amount}</b> 元\n";
                $text .= "创建时间：{$pendingWithdraw->created_at}\n\n";
                $text .= "请等待审核完成后再申请新的提现";

                $inlineKeyboard = [
                    [['text' => '↩️ 返回', 'callback_data' => 'back_to_deposit_withdraw']]
                ];

                // 编辑图片消息的caption和按钮（图片保持不变）
                $result = $this->telegramBot->editMessageCaptionWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
                if ($result['code'] != 200) {
                    $this->telegramBot->editMessageTextWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
                }
                return response()->json(['ok' => true]);
            }

            // 验证提现条件
            $validateResult = $this->validateWithdraw($user);
            if (!$validateResult['success']) {
                $text = "❌ <b>无法提现</b>\n\n";
                $text .= $validateResult['message'];

                $inlineKeyboard = [
                    [['text' => '↩️ 返回', 'callback_data' => 'back_to_deposit_withdraw']]
                ];

                // 编辑图片消息的caption和按钮（图片保持不变）
                $result = $this->telegramBot->editMessageCaptionWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
                if ($result['code'] != 200) {
                    $this->telegramBot->editMessageTextWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
                }
                return response()->json(['ok' => true]);
            }

            // 获取提现限额
            $minWithdraw = SystemConfig::getValue('min_withdraw_money') ?: 100;
            $maxWithdraw = SystemConfig::getValue('max_withdraw_money') ?: 50000;
            $exchangeRate = SystemConfig::getValue('tron_exchange_rate') ?: 7;

            // 进入输入金额状态
            $this->setUserState($telegramId, [
                'action' => self::STATE_WAITING_WITHDRAW_AMOUNT,
                'network' => 'TRC20',
                'message_id' => $messageId,
                'created_at' => now()->toDateTimeString()
            ]);

            $text = "💸 <b>TRC20 USDT 提现</b>\n\n";
            $text .= "当前余额：" . number_format($user->balance, 2) . " 元\n";
            $text .= "当前汇率：1 USDT = {$exchangeRate} 元\n";
            $text .= "提现限额：<code>{$minWithdraw}</code> - <code>{$maxWithdraw}</code> 元\n\n";
            $text .= "📝 请输入提现金额（元）：";

            $inlineKeyboard = [
                [['text' => '❌ 取消', 'callback_data' => 'cancel_input']]
            ];

            // 编辑图片消息的caption和按钮（图片保持不变）
            $result = $this->telegramBot->editMessageCaptionWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
            if ($result['code'] != 200) {
                $this->telegramBot->editMessageTextWithInlineKeyboard($chatId, $messageId, $text, $inlineKeyboard);
            }
            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('处理TRC20提现异常', ['error' => $e->getMessage()]);
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * 验证提现条件
     */
    protected function validateWithdraw($user)
    {
        // 1. 每日提现次数限制
        $dailyLimit = intval(SystemConfig::getValue('daily_withdraw_times') ?: 0);
        if ($dailyLimit > 0) {
            $todayCount = Withdraw::where('user_id', $user->id)
                ->whereDate('created_at', today())
                ->count();
            if ($todayCount >= $dailyLimit) {
                return ['success' => false, 'message' => "今日提现次数已达上限({$dailyLimit}次)"];
            }
        }

        // 2. 提现时间限制
        $beginTime = SystemConfig::getValue('withdraw_begin_time');
        $endTime = SystemConfig::getValue('withdraw_end_time');
        if ($beginTime && $endTime) {
            $currentTime = date('H:i');
            if ($currentTime < $beginTime || $currentTime > $endTime) {
                return ['success' => false, 'message' => "提现时间为 {$beginTime} - {$endTime}"];
            }
        }

        // 3. 打码量验证
        $withdrawFee = floatval(SystemConfig::getValue('withdraw_fee') ?: 1);
        if ($withdrawFee > 0) {
            // 获取用户总充值金额
            $totalRecharge = Recharge::where('user_id', $user->id)
                ->where('state', 2)
                ->sum('amount');
            // 计算需要的打码量
            $requiredBet = $totalRecharge * $withdrawFee;
            // 获取用户实际打码量（这里简化处理，实际应该从游戏记录中统计）
            $actualBet = $user->mbalance ?? 0;
            if ($actualBet < $requiredBet) {
                return ['success' => false, 'message' => "打码量不足，需要: {$requiredBet}，当前: {$actualBet}"];
            }
        }

        // 4. 余额验证
        if ($user->balance <= 0) {
            return ['success' => false, 'message' => '账户余额不足'];
        }

        return ['success' => true];
    }

    /**
     * 处理提现金额输入
     */
    protected function processWithdrawAmountInput($chatId, $user, $telegramId, $amount, $state)
    {
        try {
            // 验证金额格式
            if (!is_numeric($amount) || $amount <= 0) {
                $this->telegramBot->sendMessage($chatId, '❌ 请输入有效的金额数字');
                return response()->json(['ok' => true]);
            }

            $amount = floatval($amount);
            $minWithdraw = floatval(SystemConfig::getValue('min_withdraw_money') ?: 100);
            $maxWithdraw = floatval(SystemConfig::getValue('max_withdraw_money') ?: 50000);

            if ($amount < $minWithdraw || $amount > $maxWithdraw) {
                $this->telegramBot->sendMessage($chatId, "❌ 提现金额必须在 {$minWithdraw} - {$maxWithdraw} 元之间");
                return response()->json(['ok' => true]);
            }

            if ($amount > $user->balance) {
                $this->telegramBot->sendMessage($chatId, "❌ 余额不足，当前余额: " . number_format($user->balance, 2) . " 元");
                return response()->json(['ok' => true]);
            }

            // 更新状态，保存金额，等待输入地址
            $this->setUserState($telegramId, [
                'action' => self::STATE_WAITING_WITHDRAW_ADDRESS,
                'network' => 'TRC20',
                'amount' => $amount,
                'message_id' => $state['message_id'],
                'created_at' => now()->toDateTimeString()
            ]);

            $exchangeRate = SystemConfig::getValue('tron_exchange_rate') ?: 7;
            $usdtAmount = round($amount / $exchangeRate, 2);

            $text = "💸 <b>TRC20 USDT 提现</b>\n\n";
            $text .= "提现金额：<b>{$amount}</b> 元\n";
            $text .= "预计到账：<b>{$usdtAmount}</b> USDT\n";
            $text .= "汇率：1 USDT = {$exchangeRate} 元\n\n";
            $text .= "📝 请输入 TRC20 钱包地址：\n";
            $text .= "<i>（T开头，34个字符）</i>";

            $inlineKeyboard = [
                [['text' => '❌ 取消', 'callback_data' => 'cancel_input']]
            ];

            $this->telegramBot->sendMessageWithInlineKeyboard($chatId, $text, $inlineKeyboard);
            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('处理提现金额输入异常', ['error' => $e->getMessage()]);
            $this->telegramBot->sendMessage($chatId, '❌ 处理失败：' . $e->getMessage());
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }

    /**
     * 处理提现地址输入
     */
    protected function processWithdrawAddressInput($chatId, $user, $telegramId, $address, $state)
    {
        try {
            // 验证TRC20地址格式（T开头，34个字符）
            if (!preg_match('/^T[a-zA-Z0-9]{33}$/', $address)) {
                $this->telegramBot->sendMessage($chatId, '❌ 钱包地址格式错误，TRC20地址应以 T 开头，共34个字符');
                return response()->json(['ok' => true]);
            }

            $amount = $state['amount'];

            // 再次验证余额（防止并发问题）
            $user->refresh();
            if ($amount > $user->balance) {
                $this->clearUserState($telegramId);
                $this->telegramBot->sendMessage($chatId, "❌ 余额不足，当前余额: " . number_format($user->balance, 2) . " 元");
                return response()->json(['ok' => true]);
            }

            // 计算手续费
            $cashFee = 0;
            $realMoney = $amount - $cashFee;

            // 创建提现订单
            $orderNo = 'W' . date('YmdHis') . $user->id . mt_rand(1000, 9999);
            $exchangeRate = SystemConfig::getValue('tron_exchange_rate') ?: 7;

            $withdraw = Withdraw::create([
                'order_no' => $orderNo,
                'user_id' => $user->id,
                'type' => 2,  // USDT-TRC20 提现
                'card_id' => 0,
                'amount' => $amount,
                'cash_fee' => $cashFee,
                'real_money' => $realMoney,
                'usdt_rate' => $exchangeRate,
                'state' => 1,
                'usdt_address' => $address,
                'usdt_network' => 'TRC20',
                'info' => 'Telegram TRC20提现'
            ]);

            // 扣减余额
            $user->balance -= $amount;
            $user->save();

            // 清除状态
            $this->clearUserState($telegramId);

            $usdtAmount = round($realMoney / $exchangeRate, 2);

            $text = "✅ <b>提现申请已提交</b>\n\n";
            $text .= "订单号：<code>{$orderNo}</code>\n";
            $text .= "提现金额：<b>{$amount}</b> 元\n";
            $text .= "手续费：<b>{$cashFee}</b> 元\n";
            $text .= "预计到账：<b>{$usdtAmount}</b> USDT\n\n";
            $text .= "📮 收款地址：\n<code>{$address}</code>\n\n";
            $text .= "⏳ 请耐心等待审核";

            $inlineKeyboard = [
                [['text' => '↩️ 返回', 'callback_data' => 'back_to_deposit_withdraw']]
            ];

            $this->telegramBot->sendMessageWithInlineKeyboard($chatId, $text, $inlineKeyboard);
            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('处理提现地址输入异常', ['error' => $e->getMessage()]);
            $this->telegramBot->sendMessage($chatId, '❌ 处理失败：' . $e->getMessage());
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 200);
        }
    }
}
