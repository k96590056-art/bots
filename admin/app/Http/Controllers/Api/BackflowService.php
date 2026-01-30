<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserVip;
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
        'live' => 'realperson',    // 真人
        'fishing' => 'fish',           // 捕鱼
        'concise' => 'electron',       // 电子
        'lottery' => 'lottery',        // 彩票
        'sport' => 'sport',            // 体育
        'joker' => 'joker',            // 棋牌
        'gaming' => 'e_sport',         // 电竞
    ];

    /**
     * game_type 数字到分类代码的映射
     * 根据 conf.php 中的 game_type 配置：1 => '真人', 2 => '老虎机', 3 => '彩票', 4 => '体育', 5 => '电竞', 6 => '捕鱼', 7 => '棋牌'
     */
    protected $gameTypeToCategoryMap = [
        '1' => 'realbet',      // 真人
        '2' => 'concise',      // 老虎机/电子
        '3' => 'lottery',      // 彩票
        '4' => 'sport',        // 体育
        '5' => 'gaming',        // 电竞
        '6' => 'fishing',      // 捕鱼
        '7' => 'joker',        // 棋牌
    ];

    /**
     * 返水入账
     * 
     * @param int $userId 用户ID
     * @param string $platformName 平台编码（game_lists表的platform_name字段）
     * @param float $amount 具体金额（投注金额）
     * @param string|null $gameType 游戏类型（game_records表的game_type字段，转小写后用于获取分类）
     * @param string|null $betId 注单ID（game_records表的bet_id字段，用于判断是否已存在返水记录）
     * @param string|null $gameCode 游戏编码（已废弃，保留用于兼容）
     * @param string|null $venueCode 场馆编码（已废弃，保留用于兼容）
     * @param int|null $gameRecordId 游戏记录ID（可选，用于追踪）
     * @return array
     */
    public function backflowIn($userId, $platformName, $amount, $gameType = null, $betId = null, $gameCode = null, $venueCode = null, $gameRecordId = null)
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

            // 4. 通过 game_type 获取分类
            // 直接使用 game_records 的 game_type 字段（转小写）来获取对应的分类
            if (empty($gameType)) {
                return [
                    'code' => 400,
                    'message' => '游戏类型不能为空',
                ];
            }

            // 将 game_type 转小写
            $gameTypeLower = strtolower(trim((string)$gameType));
            
            // 如果 game_type 是数字（如 "1", "2"），先映射到分类代码
            $categoryId = $this->gameTypeToCategoryMap[$gameTypeLower] ?? $gameTypeLower;
            
            // 如果映射后仍不在 categoryToVipFieldMap 中，尝试直接使用
            if (!isset($this->categoryToVipFieldMap[$categoryId])) {
                // 尝试直接使用 game_type 作为分类
                $categoryId = $gameTypeLower;
            }

            // 5. 映射分类到user_vip字段名
            $vipField = $this->categoryToVipFieldMap[$categoryId] ?? null;
            if (!$vipField) {
                return [
                    'code' => 200,
                    'message' => '该游戏分类不支持返水',
                    'data' => ['backflow_amount' => 0],
                ];
            }

            // 6. 检查返水开关
            $switchField = $vipField . '_switch';
            $switchValue = $userVip->{$switchField} ?? 0;
            if ((int)$switchValue !== 1) {
                return [
                    'code' => 200,
                    'message' => '该游戏类型的返水开关已关闭'.$vipId.'-'.$switchField,
                    'data' => ['backflow_amount' => 0],
                ];
            }

            // 7. 获取返水比例（根据该分类去 user_vip 获取该会员在这个分类的返水比例）
            $backflowRatio = (float)($userVip->{$vipField} ?? 0);
            if ($backflowRatio <= 0) {
                return [
                    'code' => 200,
                    'message' => '该游戏类型的返水比例为0',
                    'data' => ['backflow_amount' => 0],
                ];
            }

            // 8. 计算返水金额（比例是百分比，需要除以100）
            $backflowAmount = round($backflowRatio * $amount / 100, 2);
            if ($backflowAmount <= 0) {
                return [
                    'code' => 200,
                    'message' => '返水金额为0，不记录',
                    'data' => ['backflow_amount' => 0],
                ];
            }

            // 9. 写入返水日志到transfer_logs表
            $orderNo = date('YmdHis') . '_' . $userId . '_' . mt_rand(1000, 9999);
            
            // 构建备注信息
            $remark = "游戏返水：{$categoryId}，投注金额：{$amount}，返水比例：{$backflowRatio}%";
            if (!empty($gameRecordId)) {
                $remark .= "，游戏记录ID：{$gameRecordId}";
            }
            if (!empty($gameType)) {
                $remark .= "，游戏类型：{$gameType}";
            }
            
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
                'bet_id' => $betId, // 注单ID，用于判断是否已存在返水记录
                'remark' => $remark,
            ]);

            Log::info('返水入账成功', [
                'user_id' => $userId,
                'platform_name' => $platformName,
                'game_type' => $gameType,
                'bet_id' => $betId,
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
                'game_type' => $gameType,
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

    /**
     * 下级返水入账
     * 基于下级用户的投注记录，给上级用户生成下级返水记录
     * 固定按有效流水乘以3%计算，不根据VIP等级
     * 
     * @param int $parentUserId 上级用户ID（当前用户）
     * @param int $subordinateUserId 下级用户ID
     * @param string $platformName 平台编码（game_lists表的platform_name字段）
     * @param float $amount 具体金额（投注金额/有效流水）
     * @param string|null $gameType 游戏类型（game_records表的game_type字段，可选）
     * @param string|null $betId 注单ID（game_records表的bet_id字段，用于判断是否已存在返水记录）
     * @param string|null $gameCode 游戏编码（已废弃，保留用于兼容）
     * @param string|null $venueCode 场馆编码（已废弃，保留用于兼容）
     * @param int|null $gameRecordId 游戏记录ID（可选，用于追踪）
     * @return array
     */
    public function subordinateBackflowIn($parentUserId, $subordinateUserId, $platformName, $amount, $gameType = null, $betId = null, $gameCode = null, $venueCode = null, $gameRecordId = null)
    {
        try {
            // 1. 获取上级用户信息
            $parentUser = User::find($parentUserId);
            if (!$parentUser) {
                return [
                    'code' => 400,
                    'message' => '上级用户不存在',
                ];
            }

            // 2. 获取下级用户信息
            $subordinateUser = User::find($subordinateUserId);
            if (!$subordinateUser) {
                return [
                    'code' => 400,
                    'message' => '下级用户不存在',
                ];
            }

            // 3. 验证下级用户的pid是否为上级用户的id
            if ((int)$subordinateUser->pid !== (int)$parentUserId) {
                return [
                    'code' => 400,
                    'message' => '该用户不是您的下级',
                ];
            }

            // 4. 直接按有效流水乘以3%计算返水（不根据VIP等级）
            $backflowRatio = 3.0; // 固定3%返水比例
            
            // 5. 计算返水金额（比例是百分比，需要除以100）
            $backflowAmount = round($backflowRatio * $amount / 100, 2);
            if ($backflowAmount <= 0) {
                return [
                    'code' => 200,
                    'message' => '下级返水金额为0，不记录',
                    'data' => ['backflow_amount' => 0],
                ];
            }

            // 6. 写入下级返水日志到transfer_logs表（transfer_type=99）
            $orderNo = date('YmdHis') . '_' . $parentUserId . '_' . $subordinateUserId . '_' . mt_rand(1000, 9999);
            
            // 构建备注信息
            $remark = "下级返水：下级用户ID {$subordinateUserId}，投注金额：{$amount}，返水比例：{$backflowRatio}%";
            if (!empty($gameRecordId)) {
                $remark .= "，游戏记录ID：{$gameRecordId}";
            }
            if (!empty($gameType)) {
                $remark .= "，游戏类型：{$gameType}";
            }
            if (!empty($platformName)) {
                $remark .= "，平台：{$platformName}";
            }
            
            $transferLog = TransferLog::create([
                'order_no' => $orderNo,
                'api_type' => 0, // 返水记录，api_type设为0
                'user_id' => $parentUserId, // 上级用户ID
                'transfer_type' => 99, // 下级返水记录
                'money' => $backflowAmount,
                'cash_fee' => 0,
                'real_money' => $backflowAmount,
                'before_money' => 0,
                'after_money' => 0,
                'state' => 0, // 未发放
                'platform_type' => $platformName, // 平台编码
                'bet_id' => $betId, // 注单ID，用于判断是否已存在返水记录
                'remark' => $remark,
            ]);

            // 7. 查询当前用户所有未发放的下级返水总额（transfer_type=99, state=0）
            $totalUnclaimedAmount = TransferLog::where('user_id', $parentUserId)
                ->where('transfer_type', 99)
                ->where('state', 0)
                ->sum('money');
            
            // 确保返回数字类型（sum 可能返回字符串）
            $totalUnclaimedAmount = (float)($totalUnclaimedAmount ?? 0);

            Log::info('下级返水入账成功', [
                'parent_user_id' => $parentUserId,
                'subordinate_user_id' => $subordinateUserId,
                'platform_name' => $platformName,
                'game_type' => $gameType,
                'bet_id' => $betId,
                'amount' => $amount,
                'backflow_ratio' => $backflowRatio,
                'backflow_amount' => $backflowAmount,
                'transfer_log_id' => $transferLog->id,
                'total_unclaimed_amount' => $totalUnclaimedAmount,
            ]);

            return [
                'code' => 200,
                'message' => '下级返水记录创建成功',
                'data' => [
                    'backflow_amount' => $backflowAmount,
                    'transfer_log_id' => $transferLog->id,
                    'order_no' => $orderNo,
                    'total_unclaimed_amount' => $totalUnclaimedAmount, // 当前用户所有未发放的下级返水总额
                ],
            ];

        } catch (\Throwable $e) {
            Log::error('下级返水入账异常', [
                'parent_user_id' => $parentUserId,
                'subordinate_user_id' => $subordinateUserId,
                'platform_name' => $platformName,
                'game_type' => $gameType,
                'amount' => $amount,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'code' => 500,
                'message' => '下级返水入账异常：' . $e->getMessage(),
            ];
        }
    }

    /**
     * 下级返水出账（发放下级返水）
     * 将该用户所有state=0的下级返水记录改为state=1，并将返水金额累加到用户余额
     * 
     * @param int $userId 用户ID
     * @return array
     */
    public function subordinateBackflowOut($userId)
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

            // 2. 查询该用户所有未发放的下级返水记录（state=0, transfer_type=99）
            $backflowLogs = TransferLog::where('user_id', $userId)
                ->where('transfer_type', 99)
                ->where('state', 0)
                ->lockForUpdate()
                ->get();

            if ($backflowLogs->isEmpty()) {
                DB::commit();
                return [
                    'code' => 200,
                    'message' => '没有待发放的下级返水记录',
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
                    'message' => '下级返水金额为0',
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

            Log::info('下级返水出账成功', [
                'user_id' => $userId,
                'total_amount' => $totalAmount,
                'count' => count($logIds),
                'log_ids' => $logIds,
                'new_balance' => $user->balance,
            ]);

            return [
                'code' => 200,
                'message' => '下级返水发放成功',
                'data' => [
                    'total_amount' => $totalAmount,
                    'count' => count($logIds),
                    'new_balance' => $user->balance,
                ],
            ];

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('下级返水出账异常', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'code' => 500,
                'message' => '下级返水出账异常：' . $e->getMessage(),
            ];
        }
    }
}
