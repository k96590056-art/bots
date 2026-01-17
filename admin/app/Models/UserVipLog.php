<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVipLog extends Model
{
    protected $table = 'user_vip_log';
    
    // 允许所有字段批量赋值
    protected $guarded = [];
    
    // 时间字段
    public $timestamps = true;
    
    /**
     * 获取用户的VIP升级日志
     */
    public static function getUserVipLogs($userId)
    {
        return self::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * 检查用户是否已经升级到过指定等级
     */
    public static function hasUpgradedToLevel($userId, $vipId)
    {
        return self::where('user_id', $userId)
            ->where('vip_id', $vipId)
            ->exists();
    }
    
    /**
     * 获取用户当前等级的升级日志（用于降级时更新）
     */
    public static function getCurrentLevelLog($userId, $vipId)
    {
        return self::where('user_id', $userId)
            ->where('vip_id', $vipId)
            ->whereNull('un_vip_id') // 还没有降级记录的
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
