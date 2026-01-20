<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DboneapiService;
use App\Models\User;
use App\Models\User_Api;
use App\Models\GameList;
use App\Models\GameRecord;
use Illuminate\Support\Facades\Log;

class Dboneapi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dboneapi {param?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'OneAPI游戏数据同步命令';

    /**
     * API代码，从类名自动获取（用于game_records表的platform_type字段）
     * 
     * @var string
     */
    protected $api_code;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        // 从类名获取 api_code
        $className = class_basename($this);
        // 移除可能的命令后缀（如果有）
        $apiCode = str_replace('Command', '', $className);
        // 转换为大写
        $apiCode = strtoupper($apiCode);
        // 移除前缀 "DB"
        $this->api_code = preg_replace('/^DB/', '', $apiCode);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 强制使用东八区时间，避免 CLI 环境时区不一致导致时间偏移
        date_default_timezone_set('Asia/Shanghai');

        $param = $this->argument('param');
        
        if (empty($param)) {
            $this->error('请提供参数：数字（同步游戏记录的时间，单位：分钟）或字符串（方法名）');
            $this->info('示例：');
            $this->info('  php artisan dboneapi 60                 # 同步60分钟内的游戏记录');
            $this->info('  php artisan dboneapi balance             # 同步用户余额');
            $this->info('  php artisan dboneapi syncBalance         # 同步用户余额（兼容写法）');
            return;
        }

        // 判断参数是数字还是字符串
        if (is_numeric($param)) {
            // 数字：同步游戏记录
            $minutes = (int)$param;
            $this->syncGameRecords($minutes);
        } else {
            // 字符串：调用对应的方法
            // 兼容：syncBalance / balance / Balance
            $param = trim((string) $param);
            $param = preg_replace('/^sync/i', '', $param);
            $param = $param ?: 'Balance';
            $method = 'sync' . ucfirst($param);
            if (method_exists($this, $method)) {
                $this->$method();
            } else {
                $this->error("方法 {$method} 不存在");
                $this->info('可用的方法：');
                $this->info('  syncBalance - 同步用户余额');
            }
        }
    }

    /**
     * 同步游戏记录
     * 根据 oneapi.md 文档：/transaction/list 接口返回的数据结构
     * 
     * @param int $minutes 同步时间范围（分钟）
     * @return void
     */
    private function syncGameRecords($minutes)
    {
        $this->info("开始同步 {$minutes} 分钟内的游戏记录...");

        $service = new DboneapiService();
        
        // 计算时间范围（Unix时间戳，毫秒）
        // 注意：API要求时间戳为毫秒
        $to_time = (int) (now()->timestamp * 1000);
        $from_time = (int) ((now()->timestamp - ($minutes * 60)) * 1000);

        $this->info("时间范围：{$from_time} 至 {$to_time} (Unix时间戳，毫秒)");

        // 拉取游戏记录（支持分页）
        $all_transactions = [];
        $page_no = 1;
        $page_size = 2000; // 每页最多2000条，最大5000条
        $total = 0;
        $total_pages = 0;
        
        do {
            $result = $service->getTransactionList($from_time, $to_time, $page_no, $page_size);
            if (isset($result['status']) && $result['status'] !== 'SC_OK') {
                $this->error("拉取游戏记录失败（第{$page_no}页）：" . ($result['message'] ?? '未知错误'));
                break;
            }
            
            $data = $result['data'] ?? [];
            $transactions = $data['transactions'] ?? [];
            $headers = $data['headers'] ?? [];
            $total = $data['totalItems'] ?? 0;
            $total_pages = $data['totalPages'] ?? 0;
            
            if (!empty($transactions)) {
                $all_transactions = array_merge($all_transactions, $transactions);
                $this->info("已拉取第 {$page_no}/{$total_pages} 页，本页 " . count($transactions) . " 条记录");
            }
            
            $page_no++;
        } while ($page_no <= $total_pages && count($all_transactions) < $total);
        
        if (empty($all_transactions)) {
            $this->info('没有需要同步的游戏记录');
            return;
        }

        $this->info("共获取到 " . count($all_transactions) . " 条游戏记录（总计：{$total} 条，共 {$total_pages} 页）");

        $success_count = 0;
        $fail_count = 0;
        $skip_count = 0;
        $skip_reasons = [
            'record_not_array' => 0,
            'empty_username' => 0,
            'user_not_found' => 0,
            'empty_bet_id' => 0,
            'exists_status_not_2' => 0,
            'exists_status_2_updated' => 0,
        ];

        // 解析 headers 映射（用于从数组索引获取字段值）
        $headerMap = [];
        if (!empty($headers)) {
            foreach ($headers as $field => $index) {
                $headerMap[$index] = $field;
            }
        }

        foreach ($all_transactions as $transaction) {
            try {
                if (!is_array($transaction)) {
                    $skip_reasons['record_not_array']++;
                    $skip_count++;
                    continue;
                }

                // 根据 headers 映射解析字段
                // 如果 headers 存在，使用索引访问；否则假设是关联数组
                $betId = '';
                $roundId = '';
                $externalTransactionId = '';
                $username = '';
                $currencyCode = '';
                $gameCode = '';
                $vendorCode = '';
                $gameCategoryCode = '';
                $betAmount = 0;
                $winAmount = 0;
                $winLoss = 0;
                $effectiveTurnover = 0;
                $jackpotAmount = 0;
                $status = 0;
                $vendorBetTime = 0;
                $vendorSettleTime = 0;
                $isFreeSpin = false;
                $vendorBetId = '';

                if (!empty($headerMap)) {
                    // 使用索引数组方式访问
                    $betId = (string)($transaction[$headers['betId'] ?? 0] ?? '');
                    $roundId = (string)($transaction[$headers['roundId'] ?? 1] ?? '');
                    $externalTransactionId = (string)($transaction[$headers['externalTransactionId'] ?? 2] ?? '');
                    $username = (string)($transaction[$headers['username'] ?? 3] ?? '');
                    $currencyCode = (string)($transaction[$headers['currencyCode'] ?? 4] ?? '');
                    $gameCode = (string)($transaction[$headers['gameCode'] ?? 5] ?? '');
                    $vendorCode = (string)($transaction[$headers['vendorCode'] ?? 6] ?? '');
                    $gameCategoryCode = (string)($transaction[$headers['gameCategoryCode'] ?? 7] ?? '');
                    $betAmount = (float)($transaction[$headers['betAmount'] ?? 8] ?? 0);
                    $winAmount = (float)($transaction[$headers['winAmount'] ?? 9] ?? 0);
                    $winLoss = (float)($transaction[$headers['winLoss'] ?? 10] ?? 0);
                    $effectiveTurnover = (float)($transaction[$headers['effectiveTurnover'] ?? 11] ?? 0);
                    $jackpotAmount = (float)($transaction[$headers['jackpotAmount'] ?? 12] ?? 0);
                    $status = (int)($transaction[$headers['status'] ?? 13] ?? 0);
                    $vendorBetTime = (int)($transaction[$headers['vendorBetTime'] ?? 14] ?? 0);
                    $vendorSettleTime = (int)($transaction[$headers['vendorSettleTime'] ?? 15] ?? 0);
                    $isFreeSpin = ($transaction[$headers['isFreeSpin'] ?? 16] ?? 'FALSE') === 'TRUE';
                    $vendorBetId = (string)($transaction[$headers['vendorBetId'] ?? 17] ?? '');
                } else {
                    // 假设是关联数组
                    $betId = (string)($transaction['betId'] ?? '');
                    $roundId = (string)($transaction['roundId'] ?? '');
                    $externalTransactionId = (string)($transaction['externalTransactionId'] ?? '');
                    $username = (string)($transaction['username'] ?? '');
                    $currencyCode = (string)($transaction['currencyCode'] ?? '');
                    $gameCode = (string)($transaction['gameCode'] ?? '');
                    $vendorCode = (string)($transaction['vendorCode'] ?? '');
                    $gameCategoryCode = (string)($transaction['gameCategoryCode'] ?? '');
                    $betAmount = (float)($transaction['betAmount'] ?? 0);
                    $winAmount = (float)($transaction['winAmount'] ?? 0);
                    $winLoss = (float)($transaction['winLoss'] ?? 0);
                    $effectiveTurnover = (float)($transaction['effectiveTurnover'] ?? 0);
                    $jackpotAmount = (float)($transaction['jackpotAmount'] ?? 0);
                    $status = (int)($transaction['status'] ?? 0);
                    $vendorBetTime = (int)($transaction['vendorBetTime'] ?? 0);
                    $vendorSettleTime = (int)($transaction['vendorSettleTime'] ?? 0);
                    $isFreeSpin = ($transaction['isFreeSpin'] ?? false) === true || ($transaction['isFreeSpin'] ?? 'FALSE') === 'TRUE';
                    $vendorBetId = (string)($transaction['vendorBetId'] ?? '');
                }

                // 1) 找用户（根据 username）
                if ($username === '') {
                    $skip_reasons['empty_username']++;
                    $skip_count++;
                    continue;
                }
                
                $user = User::where('username', $username)->first();
                if (!$user) {
                    $skip_reasons['user_not_found']++;
                    $fail_count++;
                    Log::warning('Dboneapi同步游戏记录 - 用户不存在', [
                        'username' => $username,
                        'transaction' => $transaction
                    ]);
                    continue;
                }

                // 2) 使用 betId 作为唯一标识
                if ($betId === '') {
                    // 如果 betId 为空，尝试使用 externalTransactionId 或 vendorBetId
                    $betId = $externalTransactionId ?: $vendorBetId;
                }
                
                if ($betId === '') {
                    $skip_reasons['empty_bet_id']++;
                    $skip_count++;
                    Log::warning('Dboneapi同步游戏记录 - betId为空', ['transaction' => $transaction]);
                    continue;
                }

                // 检查是否已存在（根据 betId 和 platform_type）
                $existing = GameRecord::where('bet_id', $betId)
                    ->where('platform_type', $this->api_code)
                    ->first();

                // 3) 组装写入数据
                // 时间处理：使用 vendorSettleTime（结算时间），如果没有则使用 vendorBetTime（投注时间）
                $settleTime = $vendorSettleTime > 0 ? $vendorSettleTime : $vendorBetTime;
                $betTime = null;
                
                if ($settleTime > 0) {
                    // 时间戳是毫秒，转换为日期时间
                    $betTime = date('Y-m-d H:i:s', (int)floor($settleTime / 1000));
                } else {
                    $betTime = now()->toDateTimeString();
                }

                // 状态处理：根据文档
                // 0 = Unsettled Bet (未结算) -> status = 2
                // 1 = Settled Bet (已结算) -> status = 1
                // 2 = Cancelled Bet (已取消) -> status = 0
                // 3 = Refunded Bet (已退款) -> status = 0
                $recordStatus = 1; // 默认已结算
                if ($status === 0) {
                    $recordStatus = 2; // 未结算
                } elseif ($status === 1) {
                    $recordStatus = 1; // 已结算
                } elseif ($status === 2 || $status === 3) {
                    $recordStatus = 0; // 已取消或已退款
                }

                // 游戏类型：使用 gameCategoryCode（如 SLOTS, LIVE 等）
                $gameType = $gameCategoryCode ?: '';

                $recordData = [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'bet_id' => $betId,
                    'round_no' => $roundId,
                    'platform_type' => $this->api_code, // 使用自动获取的 api_code
                    'game_type' => $gameType,
                    'game_code' => $gameCode,
                    'bet_time' => $betTime,
                    'bet_amount' => $betAmount,
                    'valid_amount' => $effectiveTurnover > 0 ? $effectiveTurnover : $betAmount,
                    'win_loss' => $winLoss,
                    'status' => $recordStatus,
                    'is_back' => 0,
                ];

                // 4) 防重：如果已存在且 status==2（未结算），则覆盖更新；如果 status==1（已结算），则跳过
                if ($existing) {
                    if ((int)$existing->status === 2) {
                        // 未结算的记录可以更新为已结算
                        $existing->update($recordData);
                        $skip_reasons['exists_status_2_updated']++;
                        $success_count++;
                        continue;
                    } else {
                        // 已结算的记录不再更新
                        $skip_reasons['exists_status_not_2']++;
                        $skip_count++;
                        continue;
                    }
                }

                // 创建新记录
                GameRecord::create($recordData);
                $success_count++;
            } catch (\Exception $e) {
                $this->error("处理游戏记录失败：" . $e->getMessage());
                Log::error('Dboneapi同步游戏记录失败', [
                    'transaction' => $transaction,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $fail_count++;
            }
        }

        $this->info("同步完成：成功 {$success_count} 条，失败 {$fail_count} 条，跳过 {$skip_count} 条");
        
        if ($skip_count > 0) {
            $this->info("跳过原因统计：");
            foreach ($skip_reasons as $reason => $count) {
                if ($count > 0) {
                    $this->info("  - {$reason}: {$count} 条");
                }
            }
        }
    }

    /**
     * 同步用户余额
     * 
     * @return void
     */
    private function syncBalance()
    {
        $this->info('开始同步用户余额...');

        $service = new DboneapiService();
        
        // 先根据 game_lists.with_api 找到对应的 platform_name，再用 platform_name 匹配 user_api.api_code
        $platformNames = GameList::where('with_api', 'dboneapi')
            ->select('platform_name')
            ->distinct()
            ->pluck('platform_name')
            ->map(function ($v) {
                return strtolower(trim((string) $v));
            })
            ->filter()
            ->values()
            ->toArray();

        if (empty($platformNames)) {
            $this->warn('game_lists 未配置 with_api=dboneapi，无法定位平台列表');
            return;
        }

        // 获取所有属于这些平台的用户
        $user_apis = User_Api::whereIn('api_code', $platformNames)->get();

        if ($user_apis->isEmpty()) {
            $this->info('没有需要同步余额的用户');
            return;
        }

        $this->info("找到 " . $user_apis->count() . " 个用户需要同步余额");

        $success_count = 0;
        $fail_count = 0;

        foreach ($user_apis as $user_api) {
            try {
                $user = User::find($user_api->user_id);
                
                if (!$user) {
                    $this->warn("用户不存在：ID {$user_api->user_id}");
                    $fail_count++;
                    continue;
                }

                // 注意：DboneapiService 目前没有 balance 方法
                // 如果需要同步余额，需要先实现 balance 方法
                // 这里暂时跳过，或者从其他地方获取余额
                $this->warn("DboneapiService 暂未实现 balance 方法，跳过用户 {$user->username}");
                $fail_count++;
                continue;

            } catch (\Exception $e) {
                $this->error("同步用户 {$user_api->user_id} 余额失败：" . $e->getMessage());
                Log::error('Dboneapi同步用户余额失败', [
                    'user_api' => $user_api,
                    'error' => $e->getMessage()
                ]);
                $fail_count++;
            }
        }

        $this->info("同步完成：成功 {$success_count} 个，失败 {$fail_count} 个");
    }
}
