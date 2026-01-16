<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DbevoService;
use App\Models\User;
use App\Models\User_Api;
use App\Models\GameList;
use App\Models\GameRecord;
use Illuminate\Support\Facades\Log;

class Dbevo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dbevo {param?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Evolution Gaming游戏数据同步命令';

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
        // 强制使用 UTC+0 时区，避免 CLI 环境时区不一致导致时间偏移
        date_default_timezone_set('UTC');

        $param = $this->argument('param');
        
        if (empty($param)) {
            $this->error('请提供参数：数字（同步游戏记录的时间，单位：分钟）或字符串（方法名）');
            $this->info('示例：');
            $this->info('  php artisan dbevo 1                 # 同步1分钟内的游戏记录');
            $this->info('  php artisan dbevo balance           # 同步用户余额');
            $this->info('  php artisan dbevo syncBalance       # 同步用户余额（兼容写法）');
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

        $service = new DbevoService();
        
        // 计算时间范围（系统时间/东八区）
        $end_time = date('Y-m-d H:i:00');
        $start_time = date('Y-m-d H:i:00', time() - ($minutes * 60));

        $this->info("时间范围：{$start_time} 至 {$end_time}");

        // 拉取游戏记录
        $result = $service->getGameReport($start_time, $end_time);

        if ($result['code'] != 200) {
            $this->error("拉取游戏记录失败：{$result['message']}");
            return;
        }

        $records = $result['data'] ?? [];
        
        if (empty($records)) {
            $this->info('没有需要同步的游戏记录');
            return;
        }

        $this->info("获取到 " . count($records) . " 条游戏记录");

        $success_count = 0;
        $fail_count = 0;
        $skip_count = 0;

        // 处理游戏记录
        foreach ($records as $game) {
            try {
                // 处理游戏中的参与者
                if (isset($game['participants']) && is_array($game['participants'])) {
                    foreach ($game['participants'] as $participant) {
                        $player_id = $participant['playerId'] ?? '';
                        
                        if (empty($player_id)) {
                            $skip_count++;
                            continue;
                        }

                        $user = User::where('username', $player_id)->first();
                        
                        if (!$user) {
                            $this->warn("用户不存在：{$player_id}");
                            $fail_count++;
                            continue;
                        }

                        // 处理玩家的投注记录
                        if (isset($participant['bets']) && is_array($participant['bets'])) {
                            foreach ($participant['bets'] as $bet) {
                                $bet_id = $bet['transactionId'] ?? '';
                                
                                if (empty($bet_id)) {
                                    $skip_count++;
                                    continue;
                                }

                                // 检查记录是否已存在
                                $existing_record = GameRecord::where('bet_id', $bet_id)
                                    ->where('platform_type', 'dbevo')
                                    ->first();

                                $recordData = [
                                    'user_id' => $user->id,
                                    'username' => $user->username,
                                    'bet_id' => $bet_id,
                                    // EVO 时间通常为 ISO8601（如 2026-01-15T02:55:21.098Z），需转成 MySQL DATETIME 格式
                                    'bet_time' => $this->normalizeBetTime($bet['placedOn'] ?? ($game['startedAt'] ?? null)),
                                    'platform_type' => 'dbevo',
                                    'game_type' => $game['gameType'] ?? '',
                                    'game_code' => $game['table']['id'] ?? '',
                                    'bet_amount' => $bet['stake'] ?? 0,
                                    'valid_amount' => $bet['stake'] ?? 0,
                                    'win_loss' => ($bet['payout'] ?? 0) - ($bet['stake'] ?? 0),
                                    'status' => ($game['status'] ?? 'Resolved') === 'Resolved' ? 1 : 0,
                                    'is_back' => 0,
                                ];

                                // 防重：存在且 status==2 才覆盖更新，否则跳过
                                if ($existing_record) {
                                    if ((int)$existing_record->status === 2) {
                                        $existing_record->update($recordData);
                                        $success_count++;
                                        continue;
                                    }
                                    $skip_count++;
                                    continue;
                                }

                                GameRecord::create($recordData);

                                $success_count++;
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->error("处理游戏记录失败：" . $e->getMessage());
                Log::error('Evo同步游戏记录失败', [
                    'game' => $game,
                    'error' => $e->getMessage()
                ]);
                $fail_count++;
            }
        }

        $this->info("同步完成：成功 {$success_count} 条，失败 {$fail_count} 条，跳过 {$skip_count} 条");
    }

    /**
     * 将 EVO 返回的时间统一转换为 MySQL DATETIME（Y-m-d H:i:s）
     * 支持：ISO8601 / 秒级时间戳 / 毫秒时间戳
     */
    private function normalizeBetTime($value): string
    {
        if ($value === null || $value === '') {
            return now()->toDateTimeString();
        }

        // 数字时间戳兼容（秒/毫秒）
        if (is_numeric($value)) {
            $ts = (int)$value;
            if ($ts > 1000000000000) { // 毫秒
                $ts = (int)floor($ts / 1000);
            }
            if ($ts > 0) {
                return date('Y-m-d H:i:s', $ts);
            }
        }

        // 字符串（如 2026-01-15T02:55:21.098Z）
        $ts = strtotime((string)$value);
        if ($ts !== false) {
            return date('Y-m-d H:i:s', $ts);
        }

        return now()->toDateTimeString();
    }

    /**
     * 同步用户余额
     * 
     * @return void
     */
    private function syncBalance()
    {
        $this->info('开始同步用户余额...');

        $service = new DbevoService();
        
        // 先根据 game_lists.with_api 找到对应的 platform_name，再用 platform_name 匹配 user_api.api_code
        $platformNames = GameList::where('with_api', 'dbevo')
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
            $this->warn('game_lists 未配置 with_api=dbevo，无法定位平台列表');
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
                Log::error('Evo同步用户余额失败', [
                    'user_api' => $user_api,
                    'error' => $e->getMessage()
                ]);
                $fail_count++;
            }
        }

        $this->info("同步完成：成功 {$success_count} 个，失败 {$fail_count} 个");
    }
}
