<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserVip;
use App\Models\TransferLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * 优惠活动服务类
 */
class DiscountService
{
    /**
     * 发放VIP升级奖金
     * 
     * @param int $userId 用户ID
     * @param int $vipId VIP等级ID
     * @param float $bonusAmount 奖金金额
     * @return array
     */
    public function grantVipBonus($userId, $vipId, $bonusAmount)
    {
        DB::beginTransaction();
        try {
            // 1. 获取用户信息并加锁
            $user = User::where('id', $userId)->lockForUpdate()->first();
            if (!$user) {
                DB::rollBack();
                return [
                    'code' => 400,
                    'message' => '用户不存在',
                ];
            }

            // 2. 获取VIP信息
            $vip = UserVip::find($vipId);
            if (!$vip) {
                DB::rollBack();
                return [
                    'code' => 400,
                    'message' => 'VIP等级不存在',
                ];
            }

            // 3. 获取用户当前余额（更新前）
            $beforeBalance = (float)$user->balance;

            // 4. 累加奖金到用户余额
            $user->increment('balance', $bonusAmount);
            $afterBalance = (float)$user->balance;

            // 5. 写入TransferLog表（transfer_type=7表示VIP升级奖金）
            $orderNo = date('YmdHis') . '_' . $userId . '_' . mt_rand(1000, 9999);
            TransferLog::create([
                'order_no' => $orderNo,
                'api_type' => 0,
                'user_id' => $userId,
                'transfer_type' => 7, // VIP升级奖金
                'money' => $bonusAmount,
                'cash_fee' => 0,
                'real_money' => $bonusAmount,
                'before_money' => $beforeBalance,
                'after_money' => $afterBalance,
                'state' => 1, // 已发放
                'remark' => "VIP升级奖金：{$vip->vipname}，奖金金额：{$bonusAmount}",
            ]);

            DB::commit();

            Log::info('VIP升级奖金发放成功', [
                'user_id' => $userId,
                'vip_id' => $vipId,
                'vip_name' => $vip->vipname,
                'bonus_amount' => $bonusAmount,
                'before_balance' => $beforeBalance,
                'after_balance' => $afterBalance,
            ]);

            return [
                'code' => 200,
                'message' => 'VIP升级奖金发放成功',
                'data' => [
                    'bonus_amount' => $bonusAmount,
                    'before_balance' => $beforeBalance,
                    'after_balance' => $afterBalance,
                ],
            ];

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('VIP升级奖金发放异常', [
                'user_id' => $userId,
                'vip_id' => $vipId,
                'bonus_amount' => $bonusAmount,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'code' => 500,
                'message' => 'VIP升级奖金发放异常：' . $e->getMessage(),
            ];
        }
    }
}
