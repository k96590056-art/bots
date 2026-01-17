<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DbkaiyuanService;
use App\Models\User;
use App\Models\User_Api;
use App\Models\GameList;
use App\Models\GameRecord;
use Illuminate\Support\Facades\Log;

class Dbkaiyuan extends Command
{
    protected $signature = 'dbkaiyuan {param?}';
    protected $description = 'Kaiyuan(开元) 游戏数据同步命令';

    public function handle()
    {
        // 与现有命令保持一致：强制使用东八区（如需改 UTC 再统一调整）
        date_default_timezone_set('Asia/Shanghai');

        $param = $this->argument('param');
        if (empty($param)) {
            $this->error('请提供参数：数字（同步游戏记录的时间，单位：分钟）或字符串（方法名）');
            $this->info('示例：');
            $this->info('  php artisan dbkaiyuan 1                 # 同步1分钟内的游戏记录');
            $this->info('  php artisan dbkaiyuan balance           # 同步用户余额');
            $this->info('  php artisan dbkaiyuan syncBalance       # 同步用户余额（兼容写法）');
            return;
        }

        if (is_numeric($param)) {
            $minutes = (int)$param;
            $this->syncGameRecords($minutes);
            return;
        }

        $param = trim((string)$param);
        $param = preg_replace('/^sync/i', '', $param);
        $param = $param ?: 'Balance';
        $method = 'sync' . ucfirst($param);

        if (method_exists($this, $method)) {
            $this->$method();
            return;
        }

        $this->error("方法 {$method} 不存在");
        $this->info('可用的方法：');
        $this->info('  syncBalance - 同步用户余额');
    }

    private function syncGameRecords($minutes)
    {
        $this->info("开始同步 {$minutes} 分钟内的游戏记录...");
        $service = new DbkaiyuanService();

        // 注意：按 kaiyuan.md 建议，拉取“当前时间1分钟之前数据”，这里先按分钟窗口拉取
        $endTs = time() - 60;
        $startTs = $endTs - ((int)$minutes * 60);
        $end_time = date('Y-m-d H:i:s', $endTs);
        $start_time = date('Y-m-d H:i:s', $startTs);
        $this->info("时间范围：{$start_time} 至 {$end_time}");

        $result = $service->getGameReport($start_time, $end_time);
        Log::error('Dbkaiyuan同步游戏记录失败', ['row' => $result]);
        if (($result['code'] ?? 201) != 200 && ($result['code'] ?? 201) != 16) {
            $this->error("拉取游戏记录失败：{$result['message']}");
            return;
        }

        $records = $result['data'] ?? [];
        if (empty($records) || $result["code"] == 16) {
            $this->info('没有需要同步的游戏记录');
            return;
        }

        $success = 0;
        $fail = 0;
        $skip = 0;

        foreach ($records as $row) {
            try {
                $player = $row['Accounts'] ?? '';
                if ($player === '') {
                    $fail++;
                    continue;
                }

                // 移除 ChannelID_ 前缀
                $channelId = $row['ChannelID'] ?? '';
                if ($channelId !== '' && strpos($player, $channelId . '_') === 0) {
                    $player = substr($player, strlen($channelId . '_'));
                }

                $user = User::where('username', $player)->first();
                if (!$user) {
                    $this->warn("用户不存在：{$player}");
                    $fail++;
                    continue;
                }

                $betId = $row['GameID'] ?? '';
                if ($betId === '') {
                    $skip++;
                    continue;
                }

                $existing = GameRecord::where('bet_id', $betId)->where('platform_type', 'dbkaiyuan')->first();

                [
                    'username' => $user->username,
                    'bet_id' => (string)$betId,
                    'transfer_no' => $transferNo,
                    'bet_point_name' => isset($this->betPoints[$betPointId]) ? $this->betPoints[$betPointId] : '',
                    'game_type_id' => $gameTypeId,
                    'game_type_name' => isset($this->gameTypes[$gameTypeId]) ? $this->gameTypes[$gameTypeId] : '',
                    'game_code' => (string)$gameTypeId, // 添加game_code字段
                    'platform_type' => $this->db_code,
                    'game_type' => 'realbet', // 根据实际情况调整
                    'bet_time' => $betTimeDatetime,
                    'bet_amount' => $betAmount,
                    'valid_amount' => $betAmount,
                    'win_loss' => 0,
                    'status' => 2, // 0=未结算
                    'is_back' => 0,
                    'before_amount' => $currentBalance,
                ]
                $recordData = [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'bet_id' => $betId,
                    'bet_time' => $row['GameEndTime'] ?? $row['GameStartTime'] ?? now()->toDateTimeString(),
                    'platform_type' => 'dbkaiyuan',
                    'game_type' => (string)($row['KindID'] ?? ''),
                    'game_code' => (string)($row['TableID'] ?? ''),
                    'bet_amount' => (float)($row['AllBet'] ?? 0),
                    'valid_amount' => (float)($row['CellScore'] ?? 0),
                    'win_loss' => (float)($row['Profit'] ?? 0),
                    'status' => 1,
                    'is_back' => 0,
                ];

                // 防重：存在且 status==2 才覆盖更新，否则跳过
                if ($existing) {
                    if ((int)$existing->status === 2) {
                        $existing->update($recordData);
                        $success++;
                        continue;
                    }
                    $skip++;
                    continue;
                }

                GameRecord::create($recordData);

                $success++;
            } catch (\Throwable $e) {
                $fail++;
                Log::error('Dbkaiyuan同步游戏记录失败', ['row' => $row, 'error' => $e->getMessage()]);
            }
        }

        $this->info("同步完成：成功 {$success} 条，失败 {$fail} 条，跳过 {$skip} 条");
    }

    private function syncBalance()
    {
        $this->info('开始同步用户余额...');
        $service = new DbkaiyuanService();

        $platformNames = GameList::where('with_api', 'dbkaiyuan')
            ->select('platform_name')
            ->distinct()
            ->pluck('platform_name')
            ->map(function ($v) { return strtolower(trim((string)$v)); })
            ->filter()
            ->values()
            ->toArray();

        if (empty($platformNames)) {
            $this->warn('game_lists 未配置 with_api=dbkaiyuan，无法定位平台列表');
            return;
        }

        $userApis = User_Api::whereIn('api_code', $platformNames)->get();
        if ($userApis->isEmpty()) {
            $this->info('没有需要同步余额的用户');
            return;
        }

        $success = 0;
        $fail = 0;

        foreach ($userApis as $userApi) {
            try {
                $user = User::find($userApi->user_id);
                if (!$user) {
                    $fail++;
                    continue;
                }

                $result = $service->balance($userApi->api_code, $user->username);
                if (($result['code'] ?? 201) != 200) {
                    $this->warn("查询用户 {$user->username} 余额失败：{$result['message']}");
                    $fail++;
                    continue;
                }

                $userApi->api_money = $result['data'] ?? 0;
                $userApi->save();
                $success++;
            } catch (\Throwable $e) {
                $fail++;
                Log::error('Dbkaiyuan同步余额失败', ['user_api' => $userApi, 'error' => $e->getMessage()]);
            }
        }

        $this->info("同步完成：成功 {$success} 个，失败 {$fail} 个");
    }
}

