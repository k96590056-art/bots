<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DbzhenrenService;
use App\Models\User;
use App\Models\User_Api;
use App\Models\GameList;
use App\Models\GameRecord;
use Illuminate\Support\Facades\Log;

class Dbzhenren extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dbzhenren {param?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dbzhenren游戏数据同步命令';

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
        // 强制使用东八区时间，避免 CLI 环境时区不一致导致时间偏移
        date_default_timezone_set('Asia/Shanghai');

        $param = $this->argument('param');
        
        if (empty($param)) {
            $this->error('请提供参数：数字（同步游戏记录的时间，单位：分钟）或字符串（方法名）');
            $this->info('示例：');
            $this->info('  php artisan dbzhenren 1    # 同步1分钟内的游戏记录');
            $this->info('  php artisan dbzhenren balance         # 同步用户余额');
            $this->info('  php artisan dbzhenren syncBalance     # 同步用户余额（兼容写法）');
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
     * 
     * @param int $minutes 同步时间范围（分钟）
     * @return void
     */
    private function syncGameRecords($minutes)
    {
        $this->info("开始同步 {$minutes} 分钟内的游戏记录...");

        $service = new DbzhenrenService();
        
        // 计算时间范围（系统时间/东八区）
        // 注意：
        // - 最新数据有延迟：endTime <= 当前时间-40秒
        // - 时间区间最大 30 分钟（1800秒）
        // - 建议 startTime 再往前补 40 秒覆盖缓冲数据变更
        $nowTs = time();
        $maxWindow = 1800;
        $endTs = $nowTs - 40;
        $windowSeconds = min(((int)$minutes * 60), $maxWindow);
        $startTs = $endTs - $windowSeconds - 40;
        // 若因补偿导致超过 30 分钟，向前收缩 endTs（保证区间<=30分钟）
        if (($endTs - $startTs) > $maxWindow) {
            $endTs = $startTs + $maxWindow;
        }
        $end_time = date('Y-m-d H:i:s', $endTs);
        $start_time = date('Y-m-d H:i:s', $startTs);

        $this->info("时间范围：{$start_time} 至 {$end_time}");

        // 拉取游戏记录
        $result = $service->getGameReport($start_time, $end_time);

        if ($result['code'] != 200) {
            $this->error("拉取游戏记录失败：{$result['message']}");
            return;
        }

        // 接口返回结构（常见）：data = { pageSize, pageIndex, totalRecord, totalPage, record: [...] }
        // 这里必须取 data.record 才是注单数组；同时兼容 data.data.record 或 data 为 JSON 字符串的情况
        $data = $result['data'] ?? [];
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if (is_array($decoded)) {
                $data = $decoded;
            }
        }
        if (is_array($data) && isset($data['record']) && is_array($data['record'])) {
            $records = $data['record'];
        } elseif (is_array($data) && isset($data['data']) && is_array($data['data']) && isset($data['data']['record']) && is_array($data['data']['record'])) {
            $records = $data['data']['record'];
        } else {
            // 兼容：如果上层已经直接返回了列表
            $records = is_array($data) ? $data : [];
        }
        
        if (empty($records)) {
            $totalRecord = null;
            if (is_array($data)) {
                $totalRecord = $data['totalRecord'] ?? ($data['data']['totalRecord'] ?? null);
            }
            if (!empty($totalRecord)) {
                $this->warn("接口返回 totalRecord={$totalRecord} 但 record 为空，已记录日志用于排查结构");
                Log::warning('Dbzhenren syncGameRecords record为空但totalRecord>0', [
                    'result_keys' => is_array($result) ? array_keys($result) : gettype($result),
                    'data_keys' => is_array($data) ? array_keys($data) : gettype($data),
                    'data' => $data,
                ]);
            }
            $this->info('没有需要同步的游戏记录');
            return;
        }

        $this->info("获取到 " . count($records) . " 条游戏记录");

        $success_count = 0;
        $fail_count = 0;
        $skip_count = 0;
        $skip_reasons = [
            'record_not_array' => 0,
            'empty_username_after_strip' => 0,
            'user_not_found' => 0,
            'empty_bet_id' => 0,
            'exists_status_not_2' => 0,
            'exists_status_2_updated' => 0,
        ];

        foreach ($records as $record) {
            try {
                if (!is_array($record)) {
                    $skip_reasons['record_not_array']++;
                    $skip_count++;
                    continue;
                }

                // 1) playerName 去掉 agentCode(转小写) 前缀，得到用户名
                $agentCode = (string)($record['agentCode'] ?? '');
                $playerName = (string)($record['playerName'] ?? '');
                $prefix = strtolower($agentCode);
                $username = $playerName;
                if (!empty($prefix) && stripos($playerName, $prefix) === 0) {
                    $username = substr($playerName, strlen($prefix));
                }

                if (empty($username)) {
                    $skip_reasons['empty_username_after_strip']++;
                    $skip_count++;
                    continue;
                }

                // 2) 查 users 获取 user_id
                $user = User::where('username', $username)->first();
                if (!$user) {
                    $skip_reasons['user_not_found']++;
                    $fail_count++;
                    continue;
                }

                // 3) 取注单ID（bet_id），防重
                $betId = (string)($record['id'] ?? ($record['betId'] ?? ''));
                if (empty($betId)) {
                    $skip_reasons['empty_bet_id']++;
                    $skip_count++;
                    continue;
                }

                $existing = GameRecord::where('bet_id', $betId)
                    ->where('platform_type', 'dbzhenren')
                    ->first();

                // 4) 写入 game_records（参考 DbzhenrenService::betConfirm 字段风格）
                $betPointId = $record['betPointId'] ?? null;
                $gameTypeId = $record['gameTypeId'] ?? null;

                $createdAtMs = (int)($record['createdAt'] ?? 0);
                $betTime = $createdAtMs > 0 ? date('Y-m-d H:i:s', (int)floor($createdAtMs / 1000)) : date('Y-m-d H:i:s');

                $status = 2;
                if (($record['betStatus'] ?? null) == 1) {
                    $status = 1; // 已结算
                } elseif (($record['betStatus'] ?? null) == 2) {
                    $status = 0; // 未结算
                }

                $recordData = [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'bet_id' => $betId,
                    'transfer_no' => isset($record['transferNo']) ? (string)$record['transferNo'] : null,
                    'round_no' => $record['roundNo'] ?? null,
                    'bet_point_id' => $betPointId,
                    'bet_point_name' => $record['betPointName'] ?? '',
                    'game_type_id' => $gameTypeId,
                    'game_type_name' => $record['gameTypeName'] ?? '',
                    'game_code' => isset($gameTypeId) ? (string)$gameTypeId : '',
                    'platform_type' => 'dbzhenren',
                    'game_type' => 'realbet',
                    'platform_id' => $record['platformId'] ?? null,
                    'platform_name' => $record['platformName'] ?? null,
                    'bet_time' => $betTime,
                    'bet_amount' => floatval($record['betAmount'] ?? 0),
                    'valid_amount' => floatval($record['validBetAmount'] ?? ($record['betAmount'] ?? 0)),
                    'win_loss' => floatval($record['netAmount'] ?? 0),
                    'status' => $status,
                    'is_back' => 0,
                    'before_amount' => floatval($record['beforeAmount'] ?? 0),
                    'pay_amount' => floatval($record['payAmount'] ?? 0),
                ];

                // 5) 防重：如果 bet_id 已存在，只有当现有 status==2 才覆盖更新，否则跳过
                if ($existing) {
                    if ((int)$existing->status === 2) {
                        $existing->update($recordData);
                        $skip_reasons['exists_status_2_updated']++;
                        $success_count++;
                        continue;
                    }
                    $skip_reasons['exists_status_not_2']++;
                    $skip_count++;
                    continue;
                }

                GameRecord::create($recordData);

                $success_count++;
            } catch (\Exception $e) {
                $this->error("处理游戏记录失败：" . $e->getMessage());
                Log::error('Dbzhenren同步游戏记录失败', [
                    'record' => $record,
                    'error' => $e->getMessage()
                ]);
                $fail_count++;
            }
        }

        $this->info("同步完成：成功 {$success_count} 条，失败 {$fail_count} 条，跳过 {$skip_count} 条");
        $this->info('跳过/失败原因统计：' . json_encode($skip_reasons, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    /**
     * 同步用户余额
     * 
     * @return void
     */
    private function syncBalance()
    {
        $this->info('开始同步用户余额...');

        $service = new DbzhenrenService();
        
        // 先根据 game_lists.with_api 找到对应的 platform_name，再用 platform_name 匹配 user_api.api_code
        $platformNames = GameList::where('with_api', 'dbzhenren')
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
            $this->warn('game_lists 未配置 with_api=dbzhenren，无法定位平台列表');
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

                // 查询游戏官方余额（不是本地 user_api.api_money）
                // 注意：DbzhenrenService::balance() 走的是回调钱包本地余额；同步官方余额需要走官方查询接口
                $result = method_exists($service, 'balanceOfficial')
                    ? $service->balanceOfficial($user_api->api_code, $user->username)
                    : $service->balance($user_api->api_code, $user->username);

                if ($result['code'] != 200) {
                    $this->warn("查询用户 {$user->username} 余额失败：{$result['message']}");
                    $fail_count++;
                    continue;
                }

                $game_balance = $result['data'] ?? 0;
                
                // 更新用户API余额记录（使用 api_money 字段）
                $user_api->api_money = $game_balance;
                $user_api->save();

                $this->info("用户 {$user->username} 余额：{$game_balance}");
                $success_count++;
            } catch (\Exception $e) {
                $this->error("同步用户 {$user_api->user_id} 余额失败：" . $e->getMessage());
                Log::error('Dbzhenren同步用户余额失败', [
                    'user_api' => $user_api,
                    'error' => $e->getMessage()
                ]);
                $fail_count++;
            }
        }

        $this->info("同步完成：成功 {$success_count} 个，失败 {$fail_count} 个");
    }
}
