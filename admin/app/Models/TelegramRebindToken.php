<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TelegramRebindToken extends Model
{
    protected $table = 'telegram_rebind_tokens';

    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'used',
        'new_telegram_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    /**
     * 生成换绑令牌
     */
    public static function generateToken($userId, $expireHours = 24)
    {
        // 使旧的未使用令牌失效
        self::where('user_id', $userId)
            ->where('used', false)
            ->update(['used' => true]);

        // 生成新令牌
        $token = Str::random(32);

        return self::create([
            'user_id' => $userId,
            'token' => $token,
            'expires_at' => now()->addHours($expireHours),
            'used' => false,
        ]);
    }

    /**
     * 验证令牌
     */
    public static function validateToken($token)
    {
        return self::where('token', $token)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();
    }

    /**
     * 标记令牌已使用
     */
    public function markAsUsed($newTelegramId)
    {
        $this->used = true;
        $this->new_telegram_id = $newTelegramId;
        $this->save();
    }

    /**
     * 关联用户
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
