<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DbService;
use App\Models\User;
use App\Models\User_Api;
use App\Models\GameList;
use App\Models\GameRecord;
use Illuminate\Support\Facades\Log;

class Db extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db {param?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DB游戏数据同步命令';

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
            $this->info('  php artisan db 1    # 同步1分钟内的游戏记录');
            $this->info('  php artisan db balance         # 同步用户余额');
            $this->info('  php artisan db syncBalance     # 同步用户余额（兼容写法）');
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

        $service = new DbService();
        
        // 获取所有需要同步的场馆编码
        $platformNames = GameList::where('with_api', 'db')
            ->select('platform_name', 'venue_code')
            ->distinct()
            ->get();

        if ($platformNames->isEmpty()) {
            $this->warn('game_lists 未配置 with_api=db，无法定位场馆列表');
            return;
        }

        // 获取所有唯一的 venue_code
        $venueCodes = $platformNames->pluck('venue_code')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        if (empty($venueCodes)) {
            $this->warn('未找到有效的场馆编码（venue_code）');
            return;
        }

        $this->info("找到 " . count($venueCodes) . " 个场馆需要同步");

        // 计算时间范围（系统时间/东八区）
        // 注意：
        // - 查询时间需要延迟2分钟（以syncAt为排序依据）
        // - 时间范围最多10分钟（600秒）
        // - 不能跨天
        $nowTs = time();
        $maxWindow = 600; // 10分钟
        $delaySeconds = 120; // 延迟2分钟
        $endTs = $nowTs - $delaySeconds;
        $windowSeconds = min(((int)$minutes * 60), $maxWindow);
        $startTs = $endTs - $windowSeconds;
        
        // 确保不跨天
        $startDate = date('Y-m-d', $startTs);
        $endDate = date('Y-m-d', $endTs);
        if ($startDate !== $endDate) {
            // 如果跨天，调整到当天开始
            $startTs = strtotime($endDate . ' 00:00:00');
            $endTs = min($endTs, $startTs + $maxWindow);
        }
        
        $end_time = date('Y-m-d H:i:s', $endTs);
        $start_time = date('Y-m-d H:i:s', $startTs);

        $this->info("时间范围：{$start_time} 至 {$end_time}");

        $total_success = 0;
        $total_fail = 0;
        $total_skip = 0;

        // 遍历每个场馆
        foreach ($venueCodes as $venueCode) {
            $this->info("正在同步场馆：{$venueCode}");
            
            try {
                // 拉取游戏记录（支持分页）
                $all_records = [];
                $pageNum = 1;
                $pageSize = 3000; // 每页最多3000条
                $totalRecord = 0;
                $totalPage = 0;
                
                do {
                    $result = $service->betBatchQuery($venueCode, $start_time, $end_time, 'USDT', $pageNum, $pageSize);
                    
                    if ($result['code'] != 200) {
                        $this->error("拉取游戏记录失败（场馆：{$venueCode}，第{$pageNum}页）：{$result['message']}");
                        break;
                    }
                    
                    $data = $result['data'] ?? [];
                    $records = $data['list'] ?? [];
                    $totalRecord = $data['totalRecord'] ?? 0;
                    $totalPage = $data['totalPage'] ?? 0;
                    
                    if (!empty($records)) {
                        $all_records = array_merge($all_records, $records);
                        $this->info("已拉取第 {$pageNum}/{$totalPage} 页，本页 " . count($records) . " 条记录");
                    }
                    
                    $pageNum++;
                } while ($pageNum <= $totalPage && count($all_records) < $totalRecord);
                
                if (empty($all_records)) {
                    $this->info("场馆 {$venueCode} 没有需要同步的游戏记录");
                    continue;
                }

                $this->info("场馆 {$venueCode} 共获取到 " . count($all_records) . " 条游戏记录（总计：{$totalRecord} 条，共 {$totalPage} 页）");

                // 处理并入库
                $result = $this->processAndSaveRecords($all_records, $venueCode);
                $total_success += $result['success'];
                $total_fail += $result['fail'];
                $total_skip += $result['skip'];
                
            } catch (\Exception $e) {
                $this->error("处理场馆 {$venueCode} 失败：" . $e->getMessage());
                Log::error('DB同步游戏记录失败', [
                    'venueCode' => $venueCode,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        $this->info("同步完成：成功 {$total_success} 条，失败 {$total_fail} 条，跳过 {$total_skip} 条");
    }

    /**
     * 处理并保存游戏记录
     * 
     * @param array $records 游戏记录数组
     * @param string $venueCode 场馆编码
     * @return array
     */
    private function processAndSaveRecords($records, $venueCode)
    {
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

        foreach ($records as $record) {
            try {
                if (!is_array($record)) {
                    $skip_reasons['record_not_array']++;
                    $skip_count++;
                    continue;
                }

                // 1) 获取用户名（userName 是注册时传入的用户名）
                $userName = (string)($record['userName'] ?? '');
                if (empty($userName)) {
                    $skip_reasons['empty_username']++;
                    $skip_count++;
                    continue;
                }

                // 2) 查 users 获取 user_id
                $user = User::where('username', $userName)->first();
                if (!$user) {
                    $skip_reasons['user_not_found']++;
                    $fail_count++;
                    Log::warning('DB同步游戏记录 - 用户不存在', [
                        'userName' => $userName,
                        'venueCode' => $venueCode
                    ]);
                    continue;
                }

                // 3) 取注单ID（generatedId 或 id 或 bizId），防重
                $betId = (string)($record['generatedId'] ?? ($record['id'] ?? ($record['bizId'] ?? '')));
                if (empty($betId)) {
                    $skip_reasons['empty_bet_id']++;
                    $skip_count++;
                    continue;
                }

                $existing = GameRecord::where('bet_id', $betId)
                    ->where('platform_type', 'DB')
                    ->first();

                // 4) 处理时间字段
                $betAt = $record['betAt'] ?? '';
                $netAt = $record['netAt'] ?? '';
                $syncAt = $record['syncAt'] ?? '';
                
                // 使用 betAt 作为投注时间，如果没有则使用当前时间
                $betTime = !empty($betAt) ? $betAt : date('Y-m-d H:i:s');
                // 验证时间格式
                if (strtotime($betTime) === false) {
                    $betTime = date('Y-m-d H:i:s');
                }

                // 5) 处理状态（obBetStatus: 0-未结算, 1-已结算, 2-不结算）
                // status: 1=已结算, 2=未结算, 0=无效注单
                $obBetStatus = $record['obBetStatus'] ?? '';
                $status = 1; // 默认已结算
                if ($obBetStatus === '0' || $obBetStatus === 0) {
                    $status = 2; // 未结算
                } elseif ($obBetStatus === '1' || $obBetStatus === 1) {
                    $status = 1; // 已结算
                } elseif ($obBetStatus === '2' || $obBetStatus === 2) {
                    $status = 0; // 不结算（无效注单）
                }

                // 6) 处理金额字段，保留2位小数
                $betAmount = round((float)($record['betAmount'] ?? 0), 2);
                $validBetAmount = round((float)($record['validBetAmount'] ?? $betAmount), 2);
                $netAmount = round((float)($record['netAmount'] ?? 0), 2);

                // 7) 组装写入数据
                $gameTypeId = $record['gameTypeId'] ?? null;
                $recordData = [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'bet_id' => $betId,
                    'round_no' => $record['roundNo'] ?? ($record['roundId'] ?? null),
                    'game_type_id' => $gameTypeId,
                    'game_type_name' => $record['gameTypeName'] ?? '',
                    'game_code' => isset($gameTypeId) ? (string)$gameTypeId : '',
                    'platform_type' => 'DB',
                    'game_type' => $this->getGameTypeFromVenueCode($venueCode),
                    'platform_name' => $record['platformName'] ?? '',
                    'bet_time' => $betTime,
                    'bet_amount' => $betAmount,
                    'valid_amount' => $validBetAmount,
                    'win_loss' => $netAmount,
                    'status' => $status,
                    'is_back' => 0,
                ];

                // 8) 防重：如果 bet_id 已存在，只有当现有 status==2 才覆盖更新，否则跳过
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
                Log::error('DB同步游戏记录失败', [
                    'record' => $record,
                    'venueCode' => $venueCode,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $fail_count++;
            }
        }

        if ($skip_count > 0) {
            $this->info("跳过原因统计：" . json_encode($skip_reasons, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }

        return [
            'success' => $success_count,
            'fail' => $fail_count,
            'skip' => $skip_count
        ];
    }

    /**
     * 根据场馆编码获取游戏类型
     * 
     * @param string $venueCode 场馆编码
     * @return string
     */
    private function getGameTypeFromVenueCode($venueCode)
    {
        // 根据常见的场馆编码映射游戏类型
        $mapping = [
            'ty' => 'sport',
            'dj' => 'poker',
            'zr' => 'live',
            'byqp' => 'table',
            'cp' => 'lotto',
            'dbdz' => 'slots',
            'by' => 'fishing',
            'hash' => 'hash',
        ];
        
        return $mapping[strtolower($venueCode)] ?? 'other';
    }

    /**
     * 同步用户余额
     * 
     * @return void
     */
    private function syncBalance()
    {
        $this->info('开始同步用户余额...');

        $service = new DbService();
        
        // 一次性查询所有满足 with_api='db' 的记录，获取 platform_name 和 venue_code
        // user_api.api_code 应该匹配 game_lists.platform_name，然后获取 game_lists.venue_code
        $gameLists = GameList::where('with_api', 'db')
            ->whereNotNull('venue_code')
            ->where('venue_code', '!=', '')
            ->select('platform_name', 'venue_code')
            ->get();

        if ($gameLists->isEmpty()) {
            $this->warn('game_lists 未配置 with_api=db 或未找到有效的 venue_code');
            return;
        }

        // 组装数据：以 platform_name 为 key，venue_code 为 value
        // 用于匹配：user_api.api_code === game_lists.platform_name
        $platformVenueMap = [];
        
        foreach ($gameLists as $gameList) {
            $platformName = strtolower(trim((string)$gameList->platform_name));
            $venueCode = trim((string)$gameList->venue_code);
            
            if (empty($platformName) || empty($venueCode)) {
                continue;
            }
            
            // 如果同一个 platform_name 有多个 venue_code，取第一个（或可以取任意一个）
            if (!isset($platformVenueMap[$platformName])) {
                $platformVenueMap[$platformName] = $venueCode;
            }
        }
        
        if (empty($platformVenueMap)) {
            $this->warn('未找到有效的 platform_name 和 venue_code 映射关系');
            return;
        }

        // 获取所有属于这些平台的用户
        // user_api.api_code 应该匹配 game_lists.platform_name
        $platformNames = array_keys($platformVenueMap);
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

                // 从组装好的数组中获取对应的 venue_code
                // user_api.api_code 匹配 game_lists.platform_name
                $apiCode = strtolower(trim((string)$user_api->api_code));
                $venueCode = $platformVenueMap[$apiCode] ?? null;

                if (empty($venueCode)) {
                    $this->warn("用户 {$user->username} 的 api_code ({$user_api->api_code}) 未找到对应的 venue_code");
                    $fail_count++;
                    Log::warning('DB同步用户余额 - 未找到venue_code', [
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'api_code' => $user_api->api_code,
                        'available_platforms' => array_keys($platformVenueMap)
                    ]);
                    continue;
                }

                // 查询游戏余额（从接口获取余额，然后更新本地）
                // 使用 user_api.api_user 而不是 user.username，因为 DB 接口注册时使用的是 api_user
                $username = !empty($user_api->api_user) ? $user_api->api_user : $user->username;
                
                // DbService::balance() 参数顺序是 (username, venueCode, currency)
                $result = $service->balance($username, $venueCode, 'USDT');

                if ($result['code'] != 200) {
                    $this->warn("查询用户 {$username} 余额失败：{$result['message']}");
                    $fail_count++;
                    continue;
                }

                // 从接口获取余额，保留2位小数
                $game_balance = round((float)($result['data'] ?? 0), 2);
                $api_money = $user_api->api_money;
                // 更新本地 user_api.api_money（将接口返回的余额更新到本地）
                $user_api->api_money = $game_balance;
                $user_api->save();
                $this->info("用户 {$username} (venueCode: {$venueCode}) 系统余额：{$api_money}，接口余额：{$game_balance}");
                $success_count++;
            } catch (\Exception $e) {
                $this->error("同步用户 {$user_api->user_id} 余额失败：" . $e->getMessage());
                Log::error('DB同步用户余额失败', [
                    'user_api' => $user_api,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $fail_count++;
            }
        }

        $this->info("同步完成：成功 {$success_count} 个，失败 {$fail_count} 个");
    }
}
