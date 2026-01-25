<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserVip;
use App\Models\GameList;
use App\Models\GameCategory;
use App\Models\TransferLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * 返水服务类
 */
class BackflowService
{
    /**
     * 分类ID到user_vip字段的映射
     */
    protected $categoryToVipFieldMap = [
        'realbet' => 'realperson',    // 真人
        'fishing' => 'fish',           // 捕鱼
        'concise' => 'electron',       // 电子
        'lottery' => 'lottery',        // 彩票
        'sport' => 'sport',            // 体育
        'joker' => 'joker',            // 棋牌
        'gaming' => 'e_sport',         // 电竞
    ];

    /**
     * 返水入账
     * 
     * @param int $userId 用户ID
     * @param string $platformName 平台编码（game_lists表的platform_name字段）
     * @param float $amount 具体金额（投注金额）
     * @param string|null $gameCode 游戏编码（可选，game_lists表的game_code字段）
     * @param string|null $venueCode 场馆编码（可选，game_lists表的venue_code字段）
     * @return array
     */
    public function backflowIn($userId, $platformName, $amount, $gameCode = null, $venueCode = null)
    {
        try {
            // 1. 获取用户信息
            $user = User::find($userId);
            if (!$user) {
                return [
                    'code' => 400,
                    'message' => '用户不存在',
                ];
            }

            // 2. 获取用户等级
            $vipId = (int)($user->vip ?? 0);
            if ($vipId <= 0) {
                return [
                    'code' => 200,
                    'message' => '用户未设置VIP等级，不进行返水',
                    'data' => ['backflow_amount' => 0],
                ];
            }

            // 3. 获取VIP信息
            $userVip = UserVip::where('id', $vipId)->where('status', 1)->first();
            if (!$userVip) {
                return [
                    'code' => 400,
                    'message' => 'VIP等级不存在或已禁用',
                ];
            }

            // 4. 根据平台编码获取游戏信息
            $gameQuery = GameList::where('platform_name', $platformName);
            
            // 如果传了game_code，加入查询条件
            if (!empty($gameCode)) {
                $gameQuery->where('game_code', $gameCode);
            }
            
            // 如果传了venue_code，加入查询条件
            if (!empty($venueCode)) {
                $gameQuery->where('venue_code', $venueCode);
            }
            
            $game = $gameQuery->first();
            
            if (!$game) {
                return [
                    'code' => 400,
                    'message' => '游戏不存在',
                ];
            }

            // 5. 获取游戏分类字符
            $categoryId = $game->category_id ?? '';
            if (empty($categoryId)) {
                return [
                    'code' => 400,
                    'message' => '游戏未设置分类',
                ];
            }

            // 6. 映射分类到user_vip字段名
            $vipField = $this->categoryToVipFieldMap[$categoryId] ?? null;
            if (!$vipField) {
                return [
                    'code' => 200,
                    'message' => '该游戏分类不支持返水',
                    'data' => ['backflow_amount' => 0],
                ];
            }

            // 7. 检查返水开关
            $switchField = $vipField . '_switch';
            $switchValue = $userVip->{$switchField} ?? 0;
            if ((int)$switchValue !== 1) {
                return [
                    'code' => 200,
                    'message' => '该游戏类型的返水开关已关闭',
                    'data' => ['backflow_amount' => 0],
                ];
            }

            // 8. 获取返水比例
            $backflowRatio = (float)($userVip->{$vipField} ?? 0);
            if ($backflowRatio <= 0) {
                return [
                    'code' => 200,
                    'message' => '该游戏类型的返水比例为0',
                    'data' => ['backflow_amount' => 0],
                ];
            }

            // 9. 计算返水金额（比例是百分比，需要除以100）
            $backflowAmount = round($backflowRatio * $amount / 100, 2);
            if ($backflowAmount <= 0) {
                return [
                    'code' => 200,
                    'message' => '返水金额为0，不记录',
                    'data' => ['backflow_amount' => 0],
                ];
            }

            // 10. 写入返水日志到transfer_logs表
            $orderNo = date('YmdHis') . '_' . $userId . '_' . mt_rand(1000, 9999);
            $transferLog = TransferLog::create([
                'order_no' => $orderNo,
                'api_type' => 0, // 返水记录，api_type设为0
                'user_id' => $userId,
                'transfer_type' => 6, // 返水记录
                'money' => $backflowAmount,
                'cash_fee' => 0,
                'real_money' => $backflowAmount,
                'before_money' => 0,
                'after_money' => 0,
                'state' => 0, // 未发放
                'platform_type' => $platformName, // 平台编码
                'remark' => "游戏返水：{$game->name}({$categoryId})，投注金额：{$amount}，返水比例：{$backflowRatio}%",
            ]);

            Log::info('返水入账成功', [
                'user_id' => $userId,
                'platform_name' => $platformName,
                'game_code' => $gameCode,
                'venue_code' => $venueCode,
                'game_name' => $game->name,
                'category_id' => $categoryId,
                'amount' => $amount,
                'backflow_ratio' => $backflowRatio,
                'backflow_amount' => $backflowAmount,
                'transfer_log_id' => $transferLog->id,
            ]);

            return [
                'code' => 200,
                'message' => '返水记录创建成功',
                'data' => [
                    'backflow_amount' => $backflowAmount,
                    'transfer_log_id' => $transferLog->id,
                    'order_no' => $orderNo,
                ],
            ];

        } catch (\Throwable $e) {
            Log::error('返水入账异常', [
                'user_id' => $userId,
                'platform_name' => $platformName,
                'game_code' => $gameCode,
                'venue_code' => $venueCode,
                'amount' => $amount,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'code' => 500,
                'message' => '返水入账异常：' . $e->getMessage(),
            ];
        }
    }

    /**
     * 返水出账（发放返水）
     * 将该用户所有state=0的返水记录改为state=1，并将返水金额累加到用户余额
     * 
     * @param int $userId 用户ID
     * @return array
     */
    public function backflowOut($userId)
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

            // 2. 查询该用户所有未发放的返水记录（state=0, transfer_type=6）
            $backflowLogs = TransferLog::where('user_id', $userId)
                ->where('transfer_type', 6)
                ->where('state', 0)
                ->lockForUpdate()
                ->get();

            if ($backflowLogs->isEmpty()) {
                DB::commit();
                return [
                    'code' => 200,
                    'message' => '没有待发放的返水记录',
                    'data' => [
                        'total_amount' => 0,
                        'count' => 0,
                    ],
                ];
            }

            // 3. 计算总返水金额
            $totalAmount = $backflowLogs->sum('money');
            if ($totalAmount <= 0) {
                DB::commit();
                return [
                    'code' => 200,
                    'message' => '返水金额为0',
                    'data' => [
                        'total_amount' => 0,
                        'count' => 0,
                    ],
                ];
            }

            // 4. 获取用户当前余额（更新前）
            $beforeBalance = (float)$user->balance;

            // 5. 累加返水金额到用户余额
            $user->increment('balance', $totalAmount);
            $afterBalance = (float)$user->balance;

            // 6. 更新返水记录状态为已发放（state=1），并记录余额变化
            $logIds = $backflowLogs->pluck('id')->toArray();
            TransferLog::whereIn('id', $logIds)
                ->update([
                    'state' => 1,
                    'before_money' => $beforeBalance,
                    'after_money' => $afterBalance,
                ]);

            DB::commit();

            Log::info('返水出账成功', [
                'user_id' => $userId,
                'total_amount' => $totalAmount,
                'count' => count($logIds),
                'log_ids' => $logIds,
                'new_balance' => $user->balance,
            ]);

            return [
                'code' => 200,
                'message' => '返水发放成功',
                'data' => [
                    'total_amount' => $totalAmount,
                    'count' => count($logIds),
                    'new_balance' => $user->balance,
                ],
            ];

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('返水出账异常', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'code' => 500,
                'message' => '返水出账异常：' . $e->getMessage(),
            ];
        }
    }
}
