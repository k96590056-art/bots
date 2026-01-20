<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DbgmagService;
use App\Models\User;
use App\Models\User_Api;
use App\Models\GameList;
use App\Models\GameRecord;
use Illuminate\Support\Facades\Log;

class Dbgmag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dbgmag {param?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GMAG游戏数据同步命令';

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
            $this->info('  php artisan dbgmag 1                 # 同步1分钟内的游戏记录');
            $this->info('  php artisan dbgmag balance           # 同步用户余额');
            $this->info('  php artisan dbgmag syncBalance       # 同步用户余额（兼容写法）');
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
     * 根据 cmag.md 文档：/history/game 接口返回的数据结构
     * 
     * @param int $minutes 同步时间范围（分钟）
     * @return void
     */
    private function syncGameRecords($minutes)
    {
        $this->info("开始同步 {$minutes} 分钟内的游戏记录...");

        $service = new DbgmagService();
        
        // 计算时间范围（GMT+0时间，因为API要求GMT+0）
        // 注意：API要求时间格式为 YYYY-MM-DD HH:mm:00，秒数固定为00
        // endTime - startTime 必须小于 30 分钟
        $max_minutes = min($minutes, 30); // 限制最大30分钟
        if ($minutes > 30) {
            $this->warn("时间范围超过30分钟，已自动调整为30分钟");
        }
        
        // 转换为GMT+0时间
        $end_time = gmdate('Y-m-d H:i:00');
        $start_time = gmdate('Y-m-d H:i:00', time() - ($max_minutes * 60));

        $this->info("时间范围（GMT+0）：{$start_time} 至 {$end_time}");

        // 拉取游戏记录（支持分页）
        $all_records = [];
        $page = 1;
        $size = 5000; // 每页最多5000条，最大10000条
        $total = 0;
        $pages = 0;
        
        do {
            $result = $service->getGameHistory($start_time, $end_time, '', '', '', '', '', $page, $size);
            
            if ($result['code'] != 200) {
                $this->error("拉取游戏记录失败（第{$page}页）：{$result['message']}");
                break;
            }
            
            $records = $result['data'] ?? [];
            $total = $result['total'] ?? 0;
            $pages = $result['pages'] ?? 0;
            
            if (!empty($records)) {
                $all_records = array_merge($all_records, $records);
                $this->info("已拉取第 {$page}/{$pages} 页，本页 " . count($records) . " 条记录");
            }
            
            $page++;
        } while ($page <= $pages && count($all_records) < $total);
        
        if (empty($all_records)) {
            $this->info('没有需要同步的游戏记录');
            return;
        }

        $this->info("共获取到 " . count($all_records) . " 条游戏记录（总计：{$total} 条，共 {$pages} 页）");
        
        $records = $all_records;

        $success_count = 0;
        $fail_count = 0;
        $skip_count = 0;
        $skip_reasons = [
            'record_not_array' => 0,
            'empty_player_id' => 0,
            'user_not_found' => 0,
            'empty_round_id' => 0,
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

                // 1) 找用户（根据 playerId）
                $playerId = (string)($record['playerId'] ?? '');
                if ($playerId === '') {
                    $skip_reasons['empty_player_id']++;
                    $skip_count++;
                    continue;
                }
                
                $user = User::where('username', $playerId)->first();
                if (!$user) {
                    $skip_reasons['user_not_found']++;
                    $fail_count++;
                    Log::warning('Dbgmag同步游戏记录 - 用户不存在', [
                        'playerId' => $playerId,
                        'record' => $record
                    ]);
                    continue;
                }

                // 2) 使用 roundId 作为 bet_id（根据文档，roundId 是游戏回合的唯一标识）
                // 如果 roundId 不存在，尝试使用其他字段
                $roundId = (string)($record['roundId'] ?? '');
                if ($roundId === '') {
                    $skip_reasons['empty_round_id']++;
                    $skip_count++;
                    Log::warning('Dbgmag同步游戏记录 - roundId为空', ['record' => $record]);
                    continue;
                }
                
                // 使用 roundId 作为 bet_id（因为每个 roundId 只保留一条数据）
                $betId = $roundId;

                // 检查是否已存在（根据 roundId 和 platform_type）
                $existing = GameRecord::where('bet_id', $betId)
                    ->where('platform_type', $this->api_code)
                    ->first();

                // 3) 组装写入数据（根据 cmag.md 文档的字段映射）
                // 时间处理：endTime 是回合结束时间，使用它作为 bet_time
                $endTime = $record['endTime'] ?? ($record['createdAt'] ?? null);
                $betTime = null;
                
                if (!empty($endTime)) {
                    // 如果是时间戳（毫秒），转换为日期时间
                    if (is_numeric($endTime)) {
                        $betTime = date('Y-m-d H:i:s', (int)floor(((int)$endTime) / 1000));
                    } else {
                        // 如果是字符串格式，直接使用
                        $betTime = (string)$endTime;
                        // 如果格式不正确，尝试解析
                        if (strtotime($betTime) === false) {
                            $betTime = now()->toDateTimeString();
                        }
                    }
                } else {
                    $betTime = now()->toDateTimeString();
                }

                // 状态处理：roundStatus = 'end' 表示已结算，'active' 表示未结算
                // status: 1=已结算, 2=未结算, 0=无效注单
                $roundStatus = (string)($record['roundStatus'] ?? 'end');
                $status = 1; // 默认已结算
                if ($roundStatus === 'active') {
                    $status = 2; // 未结算
                } elseif ($roundStatus === 'end') {
                    $status = 1; // 已结算
                }

                // 金额处理
                $bets = (float)($record['bets'] ?? 0);  // 押注金额
                $wins = (float)($record['wins'] ?? 0);  // 赢取金额
                $cancels = (float)($record['cancels'] ?? 0);  // 取消金额
                
                // 输赢金额 = 赢取金额 - 押注金额
                $winLoss = $wins - $bets;
                
                // 有效投注金额：如果有 validBet 字段则使用，否则使用 bets
                $validAmount = (float)($record['validBet'] ?? $bets);

                // 游戏类型和代码
                $gameType = (string)($record['gameType'] ?? '');
                $gameCode = (string)($record['gameCode'] ?? '');

                $recordData = [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'bet_id' => $betId,
                    'round_no' => $roundId,  // roundId 同时作为 round_no
                    'platform_type' => $this->api_code, // 使用自动获取的 api_code
                    'game_type' => $gameType,
                    'game_code' => $gameCode,
                    'bet_time' => $betTime,
                    'bet_amount' => $bets,
                    'valid_amount' => $validAmount,
                    'win_loss' => $winLoss,
                    'status' => $status,
                    'is_back' => 0,
                ];

                // 4) 防重：根据文档要求，每个 roundId 只保留一条数据
                // 如果已存在且 status==2（未结算），则覆盖更新；如果 status==1（已结算），则跳过
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
                Log::error('Dbgmag同步游戏记录失败', [
                    'record' => $record,
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

        $service = new DbgmagService();
        
        // 先根据 game_lists.with_api 找到对应的 platform_name，再用 platform_name 匹配 user_api.api_code
        $platformNames = GameList::where('with_api', 'dbgmag')
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
            $this->warn('game_lists 未配置 with_api=dbgmag，无法定位平台列表');
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

                // 查询游戏余额
                $result = $service->balance($user_api->api_code, $user->username);

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
                Log::error('Dbgmag同步用户余额失败', [
                    'user_api' => $user_api,
                    'error' => $e->getMessage()
                ]);
                $fail_count++;
            }
        }

        $this->info("同步完成：成功 {$success_count} 个，失败 {$fail_count} 个");
    }
}
