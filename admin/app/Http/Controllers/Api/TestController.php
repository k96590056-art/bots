<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameList;
use App\Models\Users;
use App\Models\User_Api;
use App\Services\DbgmagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
                // 对于 gmag 类型，从 DbgmagService 返回的 data 是游戏数组
                // 但最终返回给用户时，格式是 { data: { games: [...] } }
                if ($type === 'gmag') {
                    // DbgmagService 返回：result['data'] 是游戏数组
                    $games = $result['data'] ?? [];
                    
                    if (!empty($games)) {
                        return $this->processGmagGamesWithStream($games, $result);
                    }
                } else {
                    // oneapi 和其他类型，直接使用 data
                    $games = $result['data'] ?? [];
                    
                    // 如果是 oneapi 类型，下载游戏图片并保存到数据库（使用流式响应）
                    if ($type === 'oneapi' && !empty($games)) {
                        return $this->processOneapiGamesWithStream($games, $provider_code, $result);
                    }
                }
                
                return $this->returnMsg(200, [
                    'total' => $result['total'] ?? 0,
                    'pages' => $result['pages'] ?? 0,
                    'size' => $result['size'] ?? $size,
                    'current' => $result['current'] ?? $page,
                    'games' => $games
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

    /**
     * 下载游戏图片（OneAPI专用）
     * 将每个游戏的第四项（索引3）图片下载到 uploads/YYYY-MM-DD/ 目录
     * 
     * @param array $games 游戏列表数组
     * @param callable|null $progressCallback 进度回调函数
     * @return array 返回游戏代码和图片相对路径的映射数组 ['game_code' => '/2025-01-20/image.png']
     */
    private function downloadGameImages($games, $progressCallback = null)
    {
        try {
            // 创建今日日期目录（格式：YYYY-MM-DD）
            $dateDir = date('Y-m-d');
            $basePath = public_path('uploads');
            $targetDir = $basePath . '/' . $dateDir;
            
            // 如果目录不存在，创建目录
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            
            $successCount = 0;
            $failCount = 0;
            $skipCount = 0;
            
            $imagePaths = []; // 存储游戏代码和图片相对路径的映射
            $total = count($games);
            $current = 0;
            
            foreach ($games as $game) {
                $current++;
                // 检查游戏项是否为数组且包含至少4个元素
                if (!is_array($game) || count($game) < 4) {
                    $skipCount++;
                    continue;
                }
                
                // 获取游戏代码（第一个参数，索引0）
                $gameCode = $game[0] ?? '';
                if (empty($gameCode)) {
                    $skipCount++;
                    continue;
                }
                
                // 获取第四项（索引3）的图片URL
                $imageUrl = $game[3] ?? '';
                
                if (empty($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                    $skipCount++;
                    continue;
                }
                
                // 从URL中提取文件名
                $urlParts = parse_url($imageUrl);
                $pathInfo = pathinfo($urlParts['path'] ?? '');
                $fileName = $pathInfo['basename'] ?? '';
                
                // 如果无法从URL提取文件名，使用游戏代码作为文件名
                if (empty($fileName)) {
                    $extension = $pathInfo['extension'] ?? 'png';
                    $fileName = $gameCode . '.' . $extension;
                }
                
                // 目标文件路径
                $targetPath = $targetDir . '/' . $fileName;
                
                // 图片相对路径（用于数据库存储，格式：/2025-01-01/file.png）
                $relativePath = '/' . $dateDir . '/' . $fileName;
                
                // 如果文件已存在，跳过下载，但仍记录路径
                if (file_exists($targetPath)) {
                    $imagePaths[$gameCode] = $relativePath;
                    $skipCount++;
                    
                    // 调用进度回调
                    if ($progressCallback && is_callable($progressCallback)) {
                        $progressCallback($current, $total, $gameCode);
                    }
                    continue;
                }
                
                // 下载图片
                try {
                    $imageContent = @file_get_contents($imageUrl);
                    
                    if ($imageContent === false) {
                        Log::warning('OneAPI图片下载失败', [
                            'url' => $imageUrl,
                            'error' => '无法获取图片内容'
                        ]);
                        $failCount++;
                        continue;
                    }
                    
                    // 保存文件
                    $saved = @file_put_contents($targetPath, $imageContent);
                    
                    if ($saved === false) {
                        Log::error('OneAPI图片保存失败', [
                            'url' => $imageUrl,
                            'target_path' => $targetPath,
                            'error' => '无法写入文件'
                        ]);
                        $failCount++;
                    } else {
                        $successCount++;
                        $imagePaths[$gameCode] = $relativePath; // 记录成功下载的图片路径
                        
                        // 调用进度回调
                        if ($progressCallback && is_callable($progressCallback)) {
                            $progressCallback($current, $total, $gameCode);
                        }
                        
                        Log::info('OneAPI图片下载成功', [
                            'url' => $imageUrl,
                            'saved_path' => $relativePath,
                            'file_size' => $saved
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('OneAPI图片下载异常', [
                        'url' => $imageUrl,
                        'error' => $e->getMessage()
                    ]);
                    $failCount++;
                }
            }
            
            Log::info('OneAPI图片下载完成', [
                'total' => count($games),
                'success' => $successCount,
                'failed' => $failCount,
                'skipped' => $skipCount,
                'target_dir' => $dateDir
            ]);
            
            return $imagePaths;
            
        } catch (\Exception $e) {
            Log::error('OneAPI图片下载处理异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }

    /**
     * 处理 OneAPI 游戏数据（使用流式响应实时输出进度）
     * 
     * @param array $games 游戏列表数组
     * @param string $provider_code 供应商编码
     * @param array $result API返回结果
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    private function processOneapiGamesWithStream($games, $provider_code, $result)
    {
        // 设置无限执行时间（避免超时）
        set_time_limit(0);
        
        // 禁用输出缓冲
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        return response()->stream(function() use ($games, $provider_code, $result) {
            // 输出初始信息
            $this->outputProgress([
                'type' => 'start',
                'message' => '开始处理游戏数据',
                'total' => count($games)
            ]);
            
            // 步骤1：下载图片
            $this->outputProgress([
                'type' => 'step',
                'message' => '开始下载游戏图片...',
                'step' => 1,
                'total_steps' => 2
            ]);
            
            $imagePaths = $this->downloadGameImages($games, function($current, $total, $gameCode) {
                $this->outputProgress([
                    'type' => 'progress',
                    'message' => "下载图片: {$gameCode}",
                    'current' => $current,
                    'total' => $total,
                    'percentage' => round(($current / $total) * 100, 2)
                ]);
            });
            
            $this->outputProgress([
                'type' => 'step_complete',
                'message' => '图片下载完成',
                'step' => 1
            ]);
            
            // 步骤2：保存到数据库
            $this->outputProgress([
                'type' => 'step',
                'message' => '开始保存游戏数据到数据库...',
                'step' => 2,
                'total_steps' => 2
            ]);
            
            $saveResult = $this->saveGamesToDatabase($games, $provider_code, $imagePaths, function($current, $total, $gameCode, $status) {
                $this->outputProgress([
                    'type' => 'progress',
                    'message' => "处理游戏: {$gameCode} ({$status})",
                    'current' => $current,
                    'total' => $total,
                    'percentage' => round(($current / $total) * 100, 2),
                    'status' => $status // inserted, skipped, failed
                ]);
            });
            
            $this->outputProgress([
                'type' => 'step_complete',
                'message' => '数据库保存完成',
                'step' => 2
            ]);
            
            // 输出最终结果
            $this->outputProgress([
                'type' => 'complete',
                'message' => '处理完成',
                'result' => [
                    'total' => $result['total'] ?? 0,
                    'pages' => $result['pages'] ?? 0,
                    'size' => $result['size'] ?? 0,
                    'current' => $result['current'] ?? 1,
                    'database' => $saveResult
                ]
            ]);
            
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no'
        ]);
    }

    /**
     * 输出进度信息（Server-Sent Events 格式）
     * 
     * @param array $data 进度数据
     * @return void
     */
    private function outputProgress($data)
    {
        echo "data: " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n\n";
        if (ob_get_level() > 0) {
            ob_flush();
        }
        flush();
    }

    /**
     * 将游戏数据保存到 game_lists 表（OneAPI专用）
     * 
     * @param array $games 游戏列表数组
     * @param string $provider_code 供应商编码（venue_code）
     * @param array $imagePaths 游戏代码和图片相对路径的映射数组
     * @param callable|null $progressCallback 进度回调函数
     * @return array 返回入库统计信息
     */
    private function saveGamesToDatabase($games, $provider_code, $imagePaths, $progressCallback = null)
    {
        $inserted = []; // 成功入库的游戏
        $skipped = [];  // 跳过的游戏（已存在）
        $failed = [];   // 失败的游戏
        
        try {
            $total = count($games);
            $current = 0;
            
            foreach ($games as $game) {
                $current++;
                
                // 检查游戏项是否为数组且包含至少4个元素
                if (!is_array($game) || count($game) < 4) {
                    continue;
                }
                
                // 获取游戏数据
                $gameCode = $game[0] ?? '';        // 第一个参数：game_code
                $gameName = $game[1] ?? '';        // 第二个参数：name
                $categoryType = $game[2] ?? '';    // 第三个参数：category_id（需要转小写）
                
                if (empty($gameCode) || empty($gameName)) {
                    $failed[] = [
                        'game_code' => $gameCode ?: 'unknown',
                        'reason' => '缺少必要字段'
                    ];
                    
                    // 调用进度回调
                    if ($progressCallback && is_callable($progressCallback)) {
                        $progressCallback($current, $total, $gameCode ?: 'unknown', 'failed');
                    }
                    continue;
                }
                
                // 检查是否已存在（根据 platform_name 和 game_code）
                $exists = GameList::where('platform_name', 'ONEAPI')
                    ->where('game_code', $gameCode)
                    ->exists();
                
                if ($exists) {
                    $skipped[] = [
                        'game_code' => $gameCode,
                        'name' => $gameName
                    ];
                    
                    // 调用进度回调
                    if ($progressCallback && is_callable($progressCallback)) {
                        $progressCallback($current, $total, $gameCode, 'skipped');
                    }
                    continue;
                }
                
                // 准备插入数据
                $data = [
                    'platform_name' => 'ONEAPI',
                    'with_api' => 'dboneapi',
                    'game_code' => $gameCode,
                    'name' => $gameName,
                    'venue_code' => $provider_code ?: '',
                    'category_id' => strtolower($categoryType),
                    'child_id' => 14,
                    'mobile_img' => $imagePaths[$gameCode] ?? '',
                    'transferstatus' => 0
                ];
                
                // 插入数据库
                try {
                    GameList::create($data);
                    $inserted[] = [
                        'game_code' => $gameCode,
                        'name' => $gameName
                    ];
                    
                    // 调用进度回调
                    if ($progressCallback && is_callable($progressCallback)) {
                        $progressCallback($current, $total, $gameCode, 'inserted');
                    }
                    
                    Log::info('OneAPI游戏入库成功', [
                        'game_code' => $gameCode,
                        'name' => $gameName
                    ]);
                } catch (\Exception $e) {
                    $failed[] = [
                        'game_code' => $gameCode,
                        'name' => $gameName,
                        'reason' => $e->getMessage()
                    ];
                    
                    // 调用进度回调
                    if ($progressCallback && is_callable($progressCallback)) {
                        $progressCallback($current, $total, $gameCode, 'failed');
                    }
                    
                    Log::error('OneAPI游戏入库失败', [
                        'game_code' => $gameCode,
                        'name' => $gameName,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            Log::info('OneAPI游戏数据入库完成', [
                'total' => count($games),
                'inserted' => count($inserted),
                'skipped' => count($skipped),
                'failed' => count($failed)
            ]);
            
        } catch (\Exception $e) {
            Log::error('OneAPI游戏数据入库处理异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
        
        return [
            'inserted_count' => count($inserted),
            'skipped_count' => count($skipped),
            'failed_count' => count($failed),
            'inserted' => $inserted,
            'skipped' => $skipped,
            'failed' => $failed
        ];
    }

    /**
     * 处理 GMAG 游戏数据（使用流式响应实时输出进度）
     * 
     * @param array $games 游戏列表数组（从 result['data'] 中获取）
     * @param array $result API返回结果
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    private function processGmagGamesWithStream($games, $result)
    {
        // 设置无限执行时间（避免超时）
        set_time_limit(0);
        
        // 禁用输出缓冲
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        return response()->stream(function() use ($games, $result) {
            // 输出初始信息
            $this->outputProgress([
                'type' => 'start',
                'message' => '开始处理GMAG游戏数据',
                'total' => count($games)
            ]);
            
            // 步骤1：下载图片
            $this->outputProgress([
                'type' => 'step',
                'message' => '开始下载游戏图片...',
                'step' => 1,
                'total_steps' => 2
            ]);
            
            $imagePaths = $this->downloadGmagGameImages($games, function($current, $total, $gameCode) {
                $this->outputProgress([
                    'type' => 'progress',
                    'message' => "下载图片: {$gameCode}",
                    'current' => $current,
                    'total' => $total,
                    'percentage' => round(($current / $total) * 100, 2)
                ]);
            });
            
            $this->outputProgress([
                'type' => 'step_complete',
                'message' => '图片下载完成',
                'step' => 1
            ]);
            
            // 步骤2：保存到数据库
            $this->outputProgress([
                'type' => 'step',
                'message' => '开始保存游戏数据到数据库...',
                'step' => 2,
                'total_steps' => 2
            ]);
            
            $saveResult = $this->saveGmagGamesToDatabase($games, $imagePaths, function($current, $total, $gameCode, $status) {
                $this->outputProgress([
                    'type' => 'progress',
                    'message' => "处理游戏: {$gameCode} ({$status})",
                    'current' => $current,
                    'total' => $total,
                    'percentage' => round(($current / $total) * 100, 2),
                    'status' => $status // inserted, skipped, failed
                ]);
            });
            
            $this->outputProgress([
                'type' => 'step_complete',
                'message' => '数据库保存完成',
                'step' => 2
            ]);
            
            // 输出最终结果
            $this->outputProgress([
                'type' => 'complete',
                'message' => '处理完成',
                'result' => [
                    'total' => $result['total'] ?? 0,
                    'pages' => $result['pages'] ?? 0,
                    'size' => $result['size'] ?? 0,
                    'current' => $result['current'] ?? 1,
                    'database' => $saveResult
                ]
            ]);
            
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no'
        ]);
    }

    /**
     * 下载GMAG游戏图片
     * 从 resourceLink 字段下载图片到 uploads/YYYY-MM-DD/ 目录
     * 
     * @param array $games 游戏列表数组
     * @param callable|null $progressCallback 进度回调函数
     * @return array 返回游戏代码和图片相对路径的映射数组 ['game_code' => '/2025-01-20/image.png']
     */
    private function downloadGmagGameImages($games, $progressCallback = null)
    {
        try {
            // 创建今日日期目录（格式：YYYY-MM-DD）
            $dateDir = date('Y-m-d');
            $basePath = public_path('uploads');
            $targetDir = $basePath . '/' . $dateDir;
            
            // 如果目录不存在，创建目录
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            
            $successCount = 0;
            $failCount = 0;
            $skipCount = 0;
            
            $imagePaths = []; // 存储游戏代码和图片相对路径的映射
            $total = count($games);
            $current = 0;
            
            foreach ($games as $game) {
                $current++;
                
                // 检查游戏项是否为对象或数组
                if (!is_array($game) && !is_object($game)) {
                    $skipCount++;
                    continue;
                }
                
                // 转换为数组（如果是对象）
                $gameArray = is_array($game) ? $game : (array)$game;
                
                // 获取游戏代码
                $gameCode = $gameArray['gameCode'] ?? '';
                if (empty($gameCode)) {
                    $skipCount++;
                    continue;
                }
                
                // 获取 resourceLink（图片URL）
                $imageUrl = $gameArray['resourceLink'] ?? '';
                
                // 如果没有 resourceLink，跳过下载，但仍记录（mobile_img 为空）
                if (empty($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                    $imagePaths[$gameCode] = ''; // 没有图片
                    $skipCount++;
                    continue;
                }
                
                // 从URL中提取文件名
                $urlParts = parse_url($imageUrl);
                $pathInfo = pathinfo($urlParts['path'] ?? '');
                $fileName = $pathInfo['basename'] ?? '';
                
                // 如果无法从URL提取文件名，使用游戏代码作为文件名
                if (empty($fileName)) {
                    $extension = $pathInfo['extension'] ?? 'png';
                    $fileName = $gameCode . '.' . $extension;
                }
                
                // 目标文件路径
                $targetPath = $targetDir . '/' . $fileName;
                
                // 图片相对路径（用于数据库存储，格式：/2025-01-01/file.png）
                $relativePath = '/' . $dateDir . '/' . $fileName;
                
                // 如果文件已存在，跳过下载，但仍记录路径
                if (file_exists($targetPath)) {
                    $imagePaths[$gameCode] = $relativePath;
                    $skipCount++;
                    
                    // 调用进度回调
                    if ($progressCallback && is_callable($progressCallback)) {
                        $progressCallback($current, $total, $gameCode);
                    }
                    continue;
                }
                
                // 下载图片
                try {
                    $imageContent = @file_get_contents($imageUrl);
                    
                    if ($imageContent === false) {
                        Log::warning('GMAG图片下载失败', [
                            'url' => $imageUrl,
                            'game_code' => $gameCode,
                            'error' => '无法获取图片内容'
                        ]);
                        $imagePaths[$gameCode] = ''; // 下载失败，设置为空
                        $failCount++;
                        continue;
                    }
                    
                    // 保存文件
                    $saved = @file_put_contents($targetPath, $imageContent);
                    
                    if ($saved === false) {
                        Log::error('GMAG图片保存失败', [
                            'url' => $imageUrl,
                            'game_code' => $gameCode,
                            'target_path' => $targetPath,
                            'error' => '无法写入文件'
                        ]);
                        $imagePaths[$gameCode] = ''; // 保存失败，设置为空
                        $failCount++;
                    } else {
                        $successCount++;
                        $imagePaths[$gameCode] = $relativePath; // 记录成功下载的图片路径
                        
                        // 调用进度回调
                        if ($progressCallback && is_callable($progressCallback)) {
                            $progressCallback($current, $total, $gameCode);
                        }
                        
                        Log::info('GMAG图片下载成功', [
                            'url' => $imageUrl,
                            'game_code' => $gameCode,
                            'saved_path' => $relativePath,
                            'file_size' => $saved
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('GMAG图片下载异常', [
                        'url' => $imageUrl,
                        'game_code' => $gameCode,
                        'error' => $e->getMessage()
                    ]);
                    $imagePaths[$gameCode] = ''; // 异常，设置为空
                    $failCount++;
                }
            }
            
            Log::info('GMAG图片下载完成', [
                'total' => count($games),
                'success' => $successCount,
                'failed' => $failCount,
                'skipped' => $skipCount,
                'target_dir' => $dateDir
            ]);
            
            return $imagePaths;
            
        } catch (\Exception $e) {
            Log::error('GMAG图片下载处理异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }

    /**
     * 将GMAG游戏数据保存到 game_lists 表
     * 
     * @param array $games 游戏列表数组
     * @param array $imagePaths 游戏代码和图片相对路径的映射数组
     * @param callable|null $progressCallback 进度回调函数
     * @return array 返回入库统计信息
     */
    private function saveGmagGamesToDatabase($games, $imagePaths, $progressCallback = null)
    {
        $inserted = []; // 成功入库的游戏
        $skipped = [];  // 跳过的游戏（已存在）
        $failed = [];   // 失败的游戏
        
        try {
            $total = count($games);
            $current = 0;
            
            foreach ($games as $game) {
                $current++;
                
                // 检查游戏项是否为对象或数组
                if (!is_array($game) && !is_object($game)) {
                    continue;
                }
                
                // 转换为数组（如果是对象）
                $gameArray = is_array($game) ? $game : (array)$game;
                
                // 获取游戏数据
                $gameCode = $gameArray['gameCode'] ?? '';
                $cnName = $gameArray['cnName'] ?? '';
                $enName = $gameArray['enName'] ?? '';
                $gameType = $gameArray['gameType'] ?? '';
                
                if (empty($gameCode)) {
                    $failed[] = [
                        'game_code' => 'unknown',
                        'reason' => '缺少 gameCode 字段'
                    ];
                    
                    // 调用进度回调
                    if ($progressCallback && is_callable($progressCallback)) {
                        $progressCallback($current, $total, 'unknown', 'failed');
                    }
                    continue;
                }
                
                // 检查是否已存在（根据 platform_name 和 game_code）
                $exists = GameList::where('platform_name', 'GMAG')
                    ->where('game_code', $gameCode)
                    ->exists();
                
                if ($exists) {
                    $skipped[] = [
                        'game_code' => $gameCode,
                        'name' => $cnName
                    ];
                    
                    // 调用进度回调
                    if ($progressCallback && is_callable($progressCallback)) {
                        $progressCallback($current, $total, $gameCode, 'skipped');
                    }
                    continue;
                }
                
                // 准备插入数据
                $data = [
                    'platform_name' => 'GMAG',
                    'with_api' => 'dbgmag',
                    'game_code' => $gameCode,
                    'name' => $cnName,
                    'name_en' => $enName,
                    'category_id' => $gameType,
                    'child_id' => 18,
                    'mobile_img' => $imagePaths[$gameCode] ?? '',
                    'transferstatus' => 0
                ];
                
                // 插入数据库
                try {
                    GameList::create($data);
                    $inserted[] = [
                        'game_code' => $gameCode,
                        'name' => $cnName
                    ];
                    
                    // 调用进度回调
                    if ($progressCallback && is_callable($progressCallback)) {
                        $progressCallback($current, $total, $gameCode, 'inserted');
                    }
                    
                    Log::info('GMAG游戏入库成功', [
                        'game_code' => $gameCode,
                        'name' => $cnName
                    ]);
                } catch (\Exception $e) {
                    $failed[] = [
                        'game_code' => $gameCode,
                        'name' => $cnName,
                        'reason' => $e->getMessage()
                    ];
                    
                    // 调用进度回调
                    if ($progressCallback && is_callable($progressCallback)) {
                        $progressCallback($current, $total, $gameCode, 'failed');
                    }
                    
                    Log::error('GMAG游戏入库失败', [
                        'game_code' => $gameCode,
                        'name' => $cnName,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            Log::info('GMAG游戏数据入库完成', [
                'total' => count($games),
                'inserted' => count($inserted),
                'skipped' => count($skipped),
                'failed' => count($failed)
            ]);
            
        } catch (\Exception $e) {
            Log::error('GMAG游戏数据入库处理异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
        
        return [
            'inserted_count' => count($inserted),
            'skipped_count' => count($skipped),
            'failed_count' => count($failed),
            'inserted' => $inserted,
            'skipped' => $skipped,
            'failed' => $failed
        ];
    }
}
