<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User as UserModel;
use App\Models\UserVip;
use App\Models\UserVipLog;
use App\Services\DiscountService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Vip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vip:check {user_id? : 用户ID，不传则处理所有用户}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检查并处理用户VIP等级升降级';

    protected $discountService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->discountService = new DiscountService();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        
        if ($userId) {
            // 处理单个用户
            $user = UserModel::find($userId);
            if (!$user) {
                $this->error("用户不存在：{$userId}");
                return 1;
            }
            $this->processUser($user);
        } else {
            // 处理所有有效用户
            $users = UserModel::where('isdel', 0)
                ->where('isblack', 0)
                ->where('status', 1)
                ->get();
            
            $this->info("开始处理 " . $users->count() . " 个用户");
            
            $upgradedCount = 0;
            $downgradedCount = 0;
            $unchangedCount = 0;
            $errorCount = 0;
            
            foreach ($users as $user) {
                try {
                    $result = $this->processUser($user);
                    if ($result === 'upgrade') {
                        $upgradedCount++;
                    } elseif ($result === 'downgrade') {
                        $downgradedCount++;
                    } elseif ($result === 'unchanged') {
                        $unchangedCount++;
                    }
                } catch (\Exception $e) {
                    $errorCount++;
                    $this->error("处理用户 {$user->username} (ID: {$user->id}) 时出错：" . $e->getMessage());
                    Log::error("VIP升降级处理用户失败", [
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }
            
            $this->info("\n处理完成！");
            $this->info("升级用户数：{$upgradedCount}");
            $this->info("降级用户数：{$downgradedCount}");
            $this->info("未变更用户数：{$unchangedCount}");
            $this->info("处理失败用户数：{$errorCount}");
        }
        
        return 0;
    }

    /**
     * 处理单个用户的VIP等级升降级
     * 
     * @param UserModel $user
     * @return string 'upgrade'|'downgrade'|'unchanged'
     */
    protected function processUser($user)
    {
        // 1. 获取用户当前等级信息
        $currentVipId = (int)($user->vip ?? 0);
        if ($currentVipId <= 0) {
            $this->warn("用户 {$user->username} (ID: {$user->id}) 未设置VIP等级");
            return 'unchanged';
        }

        $currentVip = UserVip::where('id', $currentVipId)->where('status', 1)->first();
        if (!$currentVip) {
            $this->warn("用户 {$user->username} (ID: {$user->id}) 的VIP等级不存在或已禁用");
            return 'unchanged';
        }

        // 2. 根据当前等级的升降级或包机信息判断目标等级
        // 这里需要根据业务逻辑判断，假设根据用户的充值累计(paysum)和流水累计(totalgame)来判断
        $targetVipId = $this->calculateTargetVip($user, $currentVip);

        // 3. 判断是否需要升降级
        if ($targetVipId == $currentVipId) {
            // 等级不变
            return 'unchanged';
        }

        $targetVip = UserVip::find($targetVipId);
        if (!$targetVip) {
            $this->error("目标VIP等级不存在：{$targetVipId}");
            return 'unchanged';
        }

        if ($targetVipId > $currentVipId) {
            // 升级
            return $this->handleUpgrade($user, $currentVip, $targetVip);
        } else {
            // 降级
            return $this->handleDowngrade($user, $currentVip, $targetVip);
        }
    }

    /**
     * 计算目标VIP等级
     * 
     * @param UserModel $user
     * @param UserVip $currentVip
     * @return int
     */
    protected function calculateTargetVip($user, $currentVip)
    {
        // 根据用户的充值累计和流水累计判断应该达到的等级
        // 获取所有有效的VIP等级，按条件匹配
        $targetVip = UserVip::where('status', 1)
            ->where('recharge', '<=', $user->paysum ?? 0)
            ->where('flow', '<=', $user->totalgame ?? 0)
            ->orderBy('id', 'desc')
            ->first();

        if ($targetVip) {
            return $targetVip->id;
        }

        // 如果没有匹配的，返回最低等级
        $lowestVip = UserVip::where('status', 1)
            ->orderBy('id', 'asc')
            ->first();

        return $lowestVip ? $lowestVip->id : $currentVip->id;
    }

    /**
     * 处理升级
     * 
     * @param UserModel $user
     * @param UserVip $currentVip
     * @param UserVip $targetVip
     * @return string
     */
    protected function handleUpgrade($user, $currentVip, $targetVip)
    {
        DB::beginTransaction();
        try {
            // 1. 检查用户是否已经升级到过该等级
            $hasUpgradedBefore = UserVipLog::hasUpgradedToLevel($user->id, $targetVip->id);

            // 2. 更新用户VIP等级
            $user->vip = $targetVip->id;
            $user->save();

            // 3. 写入 user_vip_log 表
            UserVipLog::create([
                'user_id' => $user->id,
                'vip_id' => $targetVip->id,
                'un_vip_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'un_at' => null,
            ]);

            // 4. 如果没到过该等级，判断是否有奖金并发放
            if (!$hasUpgradedBefore) {
                // 检查该等级是否有奖金（假设 user_vip 表有 bonus 字段，如果没有则从其他地方获取）
                $bonusAmount = (float)($targetVip->bonus ?? 0);
                
                if ($bonusAmount > 0) {
                    // 发放奖金
                    $result = $this->discountService->grantVipBonus($user->id, $targetVip->id, $bonusAmount);
                    if ($result['code'] == 200) {
                        $this->info("用户 {$user->username} (ID: {$user->id}) 升级：{$currentVip->vipname} -> {$targetVip->vipname}，已发放奖金：{$bonusAmount}");
                    } else {
                        $this->warn("用户 {$user->username} (ID: {$user->id}) 升级：{$currentVip->vipname} -> {$targetVip->vipname}，奖金发放失败：{$result['message']}");
                    }
                } else {
                    $this->info("用户 {$user->username} (ID: {$user->id}) 升级：{$currentVip->vipname} -> {$targetVip->vipname}，该等级无奖金");
                }
            } else {
                $this->info("用户 {$user->username} (ID: {$user->id}) 升级：{$currentVip->vipname} -> {$targetVip->vipname}（已升级过该等级，不享受奖金）");
            }

            Log::info("VIP升级", [
                'user_id' => $user->id,
                'username' => $user->username,
                'old_vip_id' => $currentVip->id,
                'new_vip_id' => $targetVip->id,
                'old_vip_name' => $currentVip->vipname,
                'new_vip_name' => $targetVip->vipname,
                'is_first_time' => !$hasUpgradedBefore,
            ]);

            DB::commit();
            return 'upgrade';

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error("处理用户 {$user->username} (ID: {$user->id}) 升级时出错：" . $e->getMessage());
            Log::error("VIP升级处理失败", [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * 处理降级
     * 
     * @param UserModel $user
     * @param UserVip $currentVip
     * @param UserVip $targetVip
     * @return string
     */
    protected function handleDowngrade($user, $currentVip, $targetVip)
    {
        DB::beginTransaction();
        try {
            // 1. 查找用户当前等级的升级日志
            $currentLevelLog = UserVipLog::getCurrentLevelLog($user->id, $currentVip->id);

            // 2. 更新用户VIP等级
            $user->vip = $targetVip->id;
            $user->save();

            // 3. 如果有升级日志，更新降级信息
            if ($currentLevelLog) {
                $currentLevelLog->un_vip_id = $targetVip->id;
                $currentLevelLog->un_at = now();
                $currentLevelLog->updated_at = now();
                $currentLevelLog->save();
                
                $this->warn("用户 {$user->username} (ID: {$user->id}) 降级：{$currentVip->vipname} -> {$targetVip->vipname}，已更新降级日志");
            } else {
                // 如果没有找到升级日志，仍然记录降级
                UserVipLog::create([
                    'user_id' => $user->id,
                    'vip_id' => $targetVip->id,
                    'un_vip_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'un_at' => null,
                ]);
                
                $this->warn("用户 {$user->username} (ID: {$user->id}) 降级：{$currentVip->vipname} -> {$targetVip->vipname}，未找到升级日志，已创建新记录");
            }

            Log::info("VIP降级", [
                'user_id' => $user->id,
                'username' => $user->username,
                'old_vip_id' => $currentVip->id,
                'new_vip_id' => $targetVip->id,
                'old_vip_name' => $currentVip->vipname,
                'new_vip_name' => $targetVip->vipname,
                'log_updated' => $currentLevelLog ? true : false,
            ]);

            DB::commit();
            return 'downgrade';

        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error("处理用户 {$user->username} (ID: {$user->id}) 降级时出错：" . $e->getMessage());
            Log::error("VIP降级处理失败", [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}
