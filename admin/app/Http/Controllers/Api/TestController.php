<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameList;
use App\Models\Users;
use App\Models\User_Api;
use App\Services\DbgmagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /**
     * 测试接口：动态调用服务类获取游戏列表或供应商列表
     * 
     * 访问路径：/api/test
     * 
     * 请求参数（必选）：
     * - type: 服务类型（如：gmag, oneapi），将转换为 DbgmagService, DbOneapiService
     * 
     * 请求参数（可选）：
     * - get_vendor: 如果存在此参数，则调用 getVendors 方法获取供应商列表
     * - providerCode: 游戏供应商编码
     * - gameType: 游戏类型（slots/table/live/arcade/sport/esport/lotto/poker/bingo/other）
     * - gameCode: 游戏唯一编码
     * - page: 页码（默认1）
     * - size: 每页数量（默认100）
     * - displayLanguage: 显示语言（OneAPI 使用）
     * - currency: 币种（OneAPI 使用）
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function test(Request $request)
    {
        try {
            // 获取 type 参数（必选）
            $type = $request->input('type', '');
            
            if (empty($type)) {
                return $this->returnMsg(400, [], '参数错误：type 参数必填');
            }

            // 将 type 转小写，前面拼接 "Db"，后面拼接 "Service"
            $type = strtolower(trim($type));
            $className = 'Db' . $type . 'Service';
            $fullClassName = 'App\\Services\\' . $className;

            // 检查类是否存在
            if (!class_exists($fullClassName)) {
                return $this->returnMsg(404, [], "类不存在：{$fullClassName}");
            }

            // 实例化服务类
            $service = new $fullClassName();

            // 检查是否有 get_vendor 参数，如果存在则调用 getVendors 方法
            if ($request->has('get_vendor')) {
                // 检查是否有 getVendors 方法
                if (!method_exists($service, 'getVendors')) {
                    return $this->returnMsg(404, [], "类 {$fullClassName} 不存在 getVendors 方法");
                }

                // 获取 getVendors 方法的参数
                $display_language = $request->input('displayLanguage', '');
                $currency = $request->input('currency', '');

                // 调用 getVendors 方法
                $result = $service->getVendors($display_language, $currency);

                // 返回结果
                if ($result['code'] == 200) {
                    return $this->returnMsg(200, [
                        'vendors' => $result['data'] ?? []
                    ], '获取供应商列表成功');
                } else {
                    return $this->returnMsg(201, [], $result['message'] ?? '获取供应商列表失败');
                }
            }

            // 获取其他请求参数（统一参数格式）
            $provider_code = $request->input('providerCode', '');
            $game_type = $request->input('gameType', '');
            $game_code = $request->input('gameCode', '');
            $page = (int) $request->input('page', 1);
            $size = (int) $request->input('size', 100);
            $display_language = $request->input('displayLanguage', '');
            $currency = $request->input('currency', '');

            // 检查是否有 getGameList 方法
            if (!method_exists($service, 'getGameList')) {
                return $this->returnMsg(404, [], "类 {$fullClassName} 不存在 getGameList 方法");
            }

            // 统一调用 getGameList 方法（所有服务类使用相同的参数）
            $result = $service->getGameList($provider_code, $game_type, $game_code, $page, $size, $display_language, $currency);

            // 返回结果
            if ($result['code'] == 200) {
                return $this->returnMsg(200, [
                    'total' => $result['total'] ?? 0,
                    'pages' => $result['pages'] ?? 0,
                    'size' => $result['size'] ?? $size,
                    'current' => $result['current'] ?? $page,
                    'games' => $result['data'] ?? []
                ], '获取游戏列表成功');
            } else {
                return $this->returnMsg(201, [], $result['message'] ?? '获取游戏列表失败');
            }

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('TestController test方法异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return $this->returnMsg(500, [], '系统错误: ' . $e->getMessage());
        }
    }
}

