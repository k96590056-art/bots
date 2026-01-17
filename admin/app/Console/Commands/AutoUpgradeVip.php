<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Users;
use App\Models\UserVip;
use App\Models\GameRecord;
use App\Models\UserVipLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AutoUpgradeVip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '会员等级自动升级降级：根据两个月内的有效投注金额自动调整会员VIP等级';

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
        // 强制使用东八区时间
        date_default_timezone_set('Asia/Shanghai');

        $this->info('开始执行会员等级自动升级降级...');
        
        // 计算两个月前的时间
        $twoMonthsAgo = date('Y-m-d H:i:s', strtotime('-2 month'));
        $now = date('Y-m-d H:i:s');
        
        $this->info("统计时间范围：{$twoMonthsAgo} 至 {$now}");

        // 获取所有有效的VIP等级，按 flow 升序排列（从低到高）
        $vipLevels = UserVip::where('status', 1)
            ->orderBy('flow', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        if ($vipLevels->isEmpty()) {
            $this->error('未找到有效的VIP等级配置');
            return;
        }

        $this->info("找到 " . $vipLevels->count() . " 个VIP等级");

        // 获取最低等级（flow 最小或 id 最小）
        $lowestVip = UserVip::where('status', 1)
            ->orderBy('flow', 'asc')
            ->orderBy('id', 'asc')
            ->first();

        // 获取所有有效用户（排除已删除和黑名单）
        $users = Users::where('isdel', 0)
            ->where('isblack', 0)
            ->where('status', 1)
            ->get();

        $this->info("需要处理的用户数：" . $users->count());

        $upgradedCount = 0;
        $downgradedCount = 0;
        $unchangedCount = 0;
        $errorCount = 0;
        $firstTimeUpgradeCount = 0; // 首次升级到该等级的数量
        $repeatUpgradeCount = 0; // 重复升级到该等级的数量（不享受奖金）

        foreach ($users as $user) {
            try {
                // 计算该用户两个月内的累计有效投注金额
                $totalValidAmount = GameRecord::where('user_id', $user->id)
                    ->where('status', 1) // 只统计已结算的
                    ->where('bet_time', '>=', $twoMonthsAgo)
                    ->where('bet_time', '<=', $now)
                    ->sum('valid_amount');

                $totalValidAmount = (float)$totalValidAmount;

                // 如果累计金额 <= 0，设置为最低等级
                if ($totalValidAmount <= 0) {
                    $targetVipId = $lowestVip->id;
                } else {
                    // 从低到高遍历VIP等级，找到第一个满足条件的
                    $targetVipId = null;
                    $prevFlow = 0; // 第一个等级的前一个 flow 为 0
                    $maxUnlimitedVip = null; // 记录 flow=0 且 recharge 最大的等级

                    foreach ($vipLevels as $index => $vip) {
                        $currentFlow = (float)($vip->flow ?? 0);
                        $currentRecharge = (float)($vip->recharge ?? 0);

                        // un_flow 是上一个（更低的）等级的 flow
                        $unFlow = $prevFlow;

                        // 判断是否满足当前等级条件
                        // 条件：valid_amount > un_flow 且 valid_amount <= flow
                        // 如果 flow 为 0，表示没有上限，只要 > un_flow 即可
                        if ($currentFlow > 0) {
                            // 有上限的情况：valid_amount > un_flow 且 valid_amount <= flow
                            if ($totalValidAmount > $unFlow && $totalValidAmount <= $currentFlow) {
                                $targetVipId = $vip->id;
                                break;
                            }
                        } else {
                            // flow 为 0 表示没有上限，只要 > un_flow 即可
                            if ($totalValidAmount > $unFlow) {
                                // 如果有多个 flow=0 的等级，选择 recharge 最大的
                                if ($maxUnlimitedVip === null || $currentRecharge > (float)($maxUnlimitedVip->recharge ?? 0)) {
                                    $maxUnlimitedVip = $vip;
                                }
                            }
                        }

                        // 更新 prevFlow 为当前等级的 flow，用于下一个等级判断
                        $prevFlow = $currentFlow;
                    }

                    // 如果找到了 flow=0 的等级，使用它
                    if ($targetVipId === null && $maxUnlimitedVip !== null) {
                        $targetVipId = $maxUnlimitedVip->id;
                    }

                    // 如果遍历完都没有找到合适的等级，设置为最低等级
                    if ($targetVipId === null) {
                        $targetVipId = $lowestVip->id;
                    }
                }

                // 更新用户VIP等级
                $oldVipId = $user->vip;
                
                if ($targetVipId != $oldVipId) {
                    $targetVip = UserVip::find($targetVipId);
                    $oldVip = UserVip::find($oldVipId);
                    
                    $oldVipName = $oldVip ? $oldVip->vipname : '未知';
                    $targetVipName = $targetVip ? $targetVip->vipname : '未知';

                    if ($targetVipId > $oldVipId) {
                        // 升级逻辑
                        $upgradedCount++;
                        
                        // 检查用户是否已经升级到过该等级
                        $hasUpgradedBefore = UserVipLog::hasUpgradedToLevel($user->id, $targetVipId);
                        
                        if ($hasUpgradedBefore) {
                            // 已经升级过该等级，不享受当前等级的奖金
                            $repeatUpgradeCount++;
                            $bonusStatus = '不享受奖金（已升级过该等级）';
                            $this->info("用户 {$user->username} (ID: {$user->id}) 升级：{$oldVipName} -> {$targetVipName} (有效投注: {$totalValidAmount}) - {$bonusStatus}");
                        } else {
                            // 首次升级到该等级，享受奖金
                            $firstTimeUpgradeCount++;
                            $bonusStatus = '享受奖金（首次升级）';
                            $this->info("用户 {$user->username} (ID: {$user->id}) 升级：{$oldVipName} -> {$targetVipName} (有效投注: {$totalValidAmount}) - {$bonusStatus}");
                        }
                        
                        // 更新用户VIP等级
                        $user->vip = $targetVipId;
                        $user->save();
                        
                        // 写入 user_vip_log 表
                        UserVipLog::create([
                            'user_id' => $user->id,
                            'vip_id' => $targetVipId,
                            'un_vip_id' => null,
                            'created_at' => now(),
                            'updated_at' => now(),
                            'un_at' => null,
                        ]);
                        
                        Log::info("VIP自动升级", [
                            'user_id' => $user->id,
                            'username' => $user->username,
                            'old_vip_id' => $oldVipId,
                            'new_vip_id' => $targetVipId,
                            'old_vip_name' => $oldVipName,
                            'new_vip_name' => $targetVipName,
                            'total_valid_amount' => $totalValidAmount,
                            'is_first_time' => !$hasUpgradedBefore,
                            'bonus_status' => $bonusStatus,
                        ]);
                    } else {
                        // 降级逻辑
                        $downgradedCount++;
                        
                        // 先判断 user_vip_log 是否有满足当前用户当前会员等级的升级日志
                        $currentLevelLog = UserVipLog::getCurrentLevelLog($user->id, $oldVipId);
                        
                        if ($currentLevelLog) {
                            // 如果有升级日志，更新降级信息
                            $currentLevelLog->un_vip_id = $targetVipId;
                            $currentLevelLog->un_at = now();
                            $currentLevelLog->updated_at = now();
                            $currentLevelLog->save();
                            
                            $this->warn("用户 {$user->username} (ID: {$user->id}) 降级：{$oldVipName} -> {$targetVipName} (有效投注: {$totalValidAmount}) - 已更新降级日志");
                        } else {
                            // 如果没有找到升级日志，仍然记录降级，但不更新日志
                            $this->warn("用户 {$user->username} (ID: {$user->id}) 降级：{$oldVipName} -> {$targetVipName} (有效投注: {$totalValidAmount}) - 未找到升级日志");
                        }
                        
                        // 更新用户VIP等级
                        $user->vip = $targetVipId;
                        $user->save();
                        
                        Log::info("VIP自动降级", [
                            'user_id' => $user->id,
                            'username' => $user->username,
                            'old_vip_id' => $oldVipId,
                            'new_vip_id' => $targetVipId,
                            'old_vip_name' => $oldVipName,
                            'new_vip_name' => $targetVipName,
                            'total_valid_amount' => $totalValidAmount,
                            'log_updated' => $currentLevelLog ? true : false,
                        ]);
                    }
                } else {
                    $unchangedCount++;
                }

            } catch (\Exception $e) {
                $errorCount++;
                $this->error("处理用户 {$user->username} (ID: {$user->id}) 时出错：" . $e->getMessage());
                Log::error("VIP自动升级降级处理用户失败", [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        // 输出统计信息
        $this->info("\n处理完成！");
        $this->info("升级用户数：{$upgradedCount}");
        $this->info("  - 首次升级（享受奖金）：{$firstTimeUpgradeCount}");
        $this->info("  - 重复升级（不享受奖金）：{$repeatUpgradeCount}");
        $this->info("降级用户数：{$downgradedCount}");
        $this->info("未变更用户数：{$unchangedCount}");
        $this->info("处理失败用户数：{$errorCount}");

        Log::info("VIP自动升级降级执行完成", [
            'upgraded_count' => $upgradedCount,
            'first_time_upgrade_count' => $firstTimeUpgradeCount,
            'repeat_upgrade_count' => $repeatUpgradeCount,
            'downgraded_count' => $downgradedCount,
            'unchanged_count' => $unchangedCount,
            'error_count' => $errorCount,
            'total_users' => $users->count(),
        ]);

        return 0;
    }
}
