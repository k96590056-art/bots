<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Recharge;
use App\Models\SystemConfig;
use App\Services\TronUsdtService;
use App\Services\TelegramBotService;
use App\User;
use Carbon\Carbon;

class CheckTronRecharge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tron:check-recharge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自动检查TRON USDT充值订单状态';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('开始检查TRON USDT充值订单...');
        Log::info('定时任务：开始检查TRON USDT充值订单');

        try {
            // 先处理过期订单
            $this->handleExpiredOrders();

            // 查询所有待支付的TRC20充值订单（10分钟内创建的）
            $pendingOrders = Recharge::where('state', 1)
                ->where('tron_network', 'TRC20')
                ->where('created_at', '>=', Carbon::now()->subMinutes(10))
                ->get();

            if ($pendingOrders->isEmpty()) {
                $this->info('没有待处理的充值订单');
                return;
            }

            $this->info("找到 {$pendingOrders->count()} 个待处理订单");

            $tronService = new TronUsdtService();
            $tronAddress = SystemConfig::getValue('tron_usdt_address');

            if (empty($tronAddress)) {
                $this->error('TRON收款地址未配置');
                Log::error('定时任务：TRON收款地址未配置');
                return;
            }

            // 查询该地址最近的USDT转入记录
            $transfers = $tronService->getRecentUsdtTransfers($tronAddress);

            if (empty($transfers)) {
                $this->info('没有找到最近的USDT转账记录');
                return;
            }

            $this->info("找到 " . count($transfers) . " 条最近的转账记录");

            // 遍历待支付订单，检查是否有匹配的转账
            foreach ($pendingOrders as $order) {
                $this->checkOrderAgainstTransfers($order, $transfers, $tronService);
            }

            $this->info('充值订单检查完成');
            Log::info('定时任务：TRON USDT充值订单检查完成');

        } catch (\Exception $e) {
            $this->error('检查充值订单失败: ' . $e->getMessage());
            Log::error('定时任务：检查TRON充值订单失败', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * 检查订单是否有匹配的转账记录
     */
    private function checkOrderAgainstTransfers($order, $transfers, $tronService)
    {
        $expectedAmount = (float) $order->tron_usdt_amount;
        $orderCreatedAt = Carbon::parse($order->created_at);

        foreach ($transfers as $transfer) {
            // 转账金额（USDT有6位小数，需要除以1000000）
            $transferAmount = (float) $transfer['value'] / 1000000;
            $transferTime = isset($transfer['block_timestamp'])
                ? Carbon::createFromTimestampMs($transfer['block_timestamp'])
                : null;

            // 检查金额是否匹配（允许0.001的误差）
            if (abs($transferAmount - $expectedAmount) > 0.001) {
                continue;
            }

            // 检查转账时间是否在订单创建之后
            if ($transferTime && $transferTime->lt($orderCreatedAt)) {
                continue;
            }

            // 检查该交易哈希是否已被使用
            $txHash = $transfer['transaction_id'] ?? '';
            if (empty($txHash)) {
                continue;
            }

            $existingOrder = Recharge::where('tron_tx_hash', $txHash)->first();
            if ($existingOrder) {
                continue; // 该交易已被其他订单使用
            }

            // 找到匹配的转账，验证交易
            $this->info("订单 {$order->id} 找到匹配转账: {$txHash}, 金额: {$transferAmount} USDT");
            Log::info('定时任务：找到匹配的充值转账', [
                'order_id' => $order->id,
                'tx_hash' => $txHash,
                'amount' => $transferAmount,
                'expected_amount' => $expectedAmount
            ]);

            // 验证交易确认数
            $result = $tronService->verifyTransaction($txHash, $order->out_trade_no);

            if ($result['success']) {
                $this->info("订单 {$order->id} 充值成功!");

                // 发送Telegram通知给用户
                $this->notifyUser($order, $transferAmount, $txHash);
            } else {
                $this->warn("订单 {$order->id} 验证失败: " . ($result['message'] ?? '未知错误'));
            }

            break; // 找到匹配的转账后跳出循环
        }
    }

    /**
     * 处理过期订单（超过10分钟未支付的订单标记为过期，并释放Redis金额占用）
     */
    private function handleExpiredOrders()
    {
        // 查询超过10分钟的待支付TRC20订单
        $expiredOrders = Recharge::where('state', 1)
            ->where('tron_network', 'TRC20')
            ->where('created_at', '<', Carbon::now()->subMinutes(10))
            ->get();

        if ($expiredOrders->isEmpty()) {
            return;
        }

        $this->info("发现 {$expiredOrders->count()} 个过期订单需要处理");
        $tronService = new TronUsdtService();

        foreach ($expiredOrders as $order) {
            try {
                // 释放 Redis 金额占用
                if (!empty($order->tron_usdt_amount)) {
                    $tronService->releaseAmount((float)$order->tron_usdt_amount);
                }

                // 标记订单为过期（state = 4 表示已取消）
                $order->update([
                    'state' => 4,
                    'info' => '订单超时未支付，已自动取消'
                ]);

                $this->info("订单 {$order->id} 已标记为过期");
                Log::info('定时任务：充值订单过期取消', [
                    'order_id' => $order->id,
                    'usdt_amount' => $order->tron_usdt_amount
                ]);

            } catch (\Exception $e) {
                Log::error('处理过期订单失败', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * 发送Telegram通知给用户
     */
    private function notifyUser($order, $amount, $txHash)
    {
        try {
            $user = User::find($order->user_id);
            if (!$user || empty($user->telegram_id)) {
                return;
            }

            $telegramBot = new TelegramBotService();

            $walletBalance = number_format($user->balance, 2);
            $text = "✅ <b>充值成功</b>\n\n";
            $text .= "订单编号：<code>{$order->id}</code>\n";
            $text .= "充值金额：<b>{$amount} USDT</b>\n";
            $text .= "到账金额：<b>{$order->amount}</b> 元\n";
            $text .= "交易哈希：<code>" . substr($txHash, 0, 20) . "...</code>\n";
            $text .= "\n💵 余额：<b>{$walletBalance}</b> 元\n";
            $text .= "\n💰 感谢使用！";

            $inlineKeyboard = [
                [['text' => '🏠 返回主菜单', 'callback_data' => 'back_main']]
            ];

            // 如果有保存消息ID，则编辑原消息；否则发送新消息
            if (!empty($order->telegram_message_id)) {
                // 获取主菜单图片URL
                $mainImageUrl = SystemConfig::getValue('telegram_bot_main_image');
                if ($mainImageUrl) {
                    $mainImageUrl = env('APP_URL') . '/uploads/' . $mainImageUrl;
                } else {
                    $mainImageUrl = env('APP_URL') . '/images/telegram/main_banner.jpg';
                }

                $telegramBot->editMessageMedia($user->telegram_id, $order->telegram_message_id, $mainImageUrl, $text, $inlineKeyboard);
            } else {
                $telegramBot->sendMessageWithInlineKeyboard($user->telegram_id, $text, $inlineKeyboard);
            }

            Log::info('充值成功通知已发送', [
                'user_id' => $user->id,
                'telegram_id' => $user->telegram_id,
                'order_id' => $order->id,
                'edited_message' => !empty($order->telegram_message_id)
            ]);

        } catch (\Exception $e) {
            Log::error('发送充值成功通知失败', [
                'error' => $e->getMessage(),
                'order_id' => $order->id
            ]);
        }
    }
}
