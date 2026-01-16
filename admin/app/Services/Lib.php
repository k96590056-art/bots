<?php
namespace App\Services;

use App\Models\GameList;

class Lib
{
    /**
     * 根据 game_lists.with_api 解析 TransferLog 应写入的 api_type（即 with_api）。
     * - $platformName: game_lists.platform_name / 实际场馆code（如 ag、pg、dbzhenren、dianzi 等）
     * - $gameCode: 可选，若传入则更精确匹配
     * 兜底：查不到则返回 strtolower($platformName)
     */
    public static function resolveWithApiByPlatform(?string $platformName, ?string $gameCode = null): string
    {
        static $cache = [];

        $platformName = strtolower(trim((string) $platformName));
        $gameCode = $gameCode !== null ? trim((string) $gameCode) : null;

        if ($platformName === '') {
            return '';
        }

        $cacheKey = $platformName . '|' . ($gameCode ?? '');
        if (isset($cache[$cacheKey])) {
            return $cache[$cacheKey];
        }

        try {
            $query = GameList::where('platform_name', $platformName);
            if (!empty($gameCode)) {
                $query->where('game_code', $gameCode);
            }
            $withApi = $query->value('with_api');
            $withApi = strtolower(trim((string) $withApi));

            if ($withApi === '') {
                $withApi = $platformName;
            }
        } catch (\Throwable $e) {
            $withApi = $platformName;
        }

        $cache[$cacheKey] = $withApi;
        return $withApi;
    }

    /**
     * TransferLog.platform_type 统一写小写平台名
     */
    public static function normalizePlatformType(?string $platformName): string
    {
        return strtolower(trim((string) $platformName));
    }

    /**
     * 获取ip地址
     */
    public static function getIpAddress($ip)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, sprintf('https://67ip.cn/check?ip=%s&token=%s', $ip, '53319c68fdda40a8b905d032bac04f45'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3); // 设置3秒超时
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2); // 设置2秒连接超时
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}