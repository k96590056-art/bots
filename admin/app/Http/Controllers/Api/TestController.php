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
     * 测试接口：排查 TelegramWebhookController 问题
     * 
     * 访问路径：/api/test
     * 
     * 测试步骤：
     * 1. 测试 TelegramBotService 能否正常实例化
     * 2. 测试 TelegramWebhookController 能否正常实例化
     * 3. 测试相关方法是否能正常调用
     */
    public function test(Request $request)
    {
        $result = [
            'timestamp' => date('Y-m-d H:i:s'),
            'tests' => []
        ];

        // 测试 1: 检查 TelegramBotService 文件语法
        try {
            $telegramBotServiceFile = app_path('Services/TelegramBotService.php');
            $syntaxCheck = shell_exec("php -l \"{$telegramBotServiceFile}\" 2>&1");
            $result['tests']['telegram_bot_service_syntax'] = [
                'file' => $telegramBotServiceFile,
                'syntax_check' => trim($syntaxCheck ?? ''),
                'is_valid' => strpos($syntaxCheck ?? '', 'No syntax errors') !== false
            ];
        } catch (\Exception $e) {
            $result['tests']['telegram_bot_service_syntax'] = [
                'error' => $e->getMessage()
            ];
        }

        // 测试 2: 尝试实例化 TelegramBotService
        try {
            $telegramBotService = new \App\Services\TelegramBotService();
            $result['tests']['telegram_bot_service_instantiation'] = [
                'status' => 'success',
                'message' => 'TelegramBotService 实例化成功',
                'class' => get_class($telegramBotService)
            ];
        } catch (\Throwable $e) {
            $result['tests']['telegram_bot_service_instantiation'] = [
                'status' => 'failed',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ];
        }

        // 测试 3: 尝试实例化 TelegramWebhookController
        try {
            $webhookController = new \App\Http\Controllers\Api\TelegramWebhookController();
            $result['tests']['telegram_webhook_controller_instantiation'] = [
                'status' => 'success',
                'message' => 'TelegramWebhookController 实例化成功',
                'class' => get_class($webhookController)
            ];
        } catch (\Throwable $e) {
            $result['tests']['telegram_webhook_controller_instantiation'] = [
                'status' => 'failed',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ];
        }

        // 测试 4: 检查 TelegramBotService.php 第854行内容
        try {
            $telegramBotServiceFile = app_path('Services/TelegramBotService.php');
            if (file_exists($telegramBotServiceFile)) {
                $lines = file($telegramBotServiceFile);
                $line854 = isset($lines[853]) ? trim($lines[853]) : 'N/A';
                $context850 = isset($lines[849]) ? trim($lines[849]) : 'N/A';
                $context851 = isset($lines[850]) ? trim($lines[850]) : 'N/A';
                $context852 = isset($lines[851]) ? trim($lines[851]) : 'N/A';
                $context853 = isset($lines[852]) ? trim($lines[852]) : 'N/A';
                $context855 = isset($lines[854]) ? trim($lines[854]) : 'N/A';
                $context856 = isset($lines[855]) ? trim($lines[855]) : 'N/A';
                $context857 = isset($lines[856]) ? trim($lines[856]) : 'N/A';
                
                $result['tests']['telegram_bot_service_line_854'] = [
                    'file' => $telegramBotServiceFile,
                    'line_850' => $context850,
                    'line_851' => $context851,
                    'line_852' => $context852,
                    'line_853' => $context853,
                    'line_854' => $line854,
                    'line_855' => $context855,
                    'line_856' => $context856,
                    'line_857' => $context857,
                    'line_854_contains_catch' => strpos($line854, 'catch') !== false,
                    'line_854_contains_arrow' => strpos($line854, '=>') !== false,
                    'has_error' => strpos($line854, 'response') !== false && strpos($line854, '=>') !== false,
                ];
                
                // 提供修复建议
                if (strpos($line854, 'response') !== false && strpos($line854, '=>') !== false) {
                    $result['tests']['telegram_bot_service_line_854']['fix_required'] = true;
                    $result['tests']['telegram_bot_service_line_854']['correct_lines'] = [
                        'line_853' => "            return ['code' => 200, 'message' => '成功', 'data' => \$result];",
                        'line_854' => "        } catch (\\Exception \$e) {",
                        'line_855' => "            Log::error('Telegram设置Bot命令菜单异常', [",
                    ];
                } else {
                    $result['tests']['telegram_bot_service_line_854']['fix_required'] = false;
                }
            }
        } catch (\Exception $e) {
            $result['tests']['telegram_bot_service_line_854'] = [
                'error' => $e->getMessage()
            ];
        }

        // 测试 5: 尝试调用 TelegramWebhookController 的 getGameCategories 方法
        try {
            $webhookController = new \App\Http\Controllers\Api\TelegramWebhookController();
            // 使用反射调用 protected 方法
            $reflection = new \ReflectionClass($webhookController);
            $method = $reflection->getMethod('getGameCategories');
            $method->setAccessible(true);
            $categories = $method->invoke($webhookController);
            
            $result['tests']['get_game_categories_method'] = [
                'status' => 'success',
                'message' => 'getGameCategories 方法调用成功',
                'categories_count' => count($categories),
                'categories' => $categories
            ];
        } catch (\Throwable $e) {
            $result['tests']['get_game_categories_method'] = [
                'status' => 'failed',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ];
        }

        return response()->json($result, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * 批量创建 user_api 记录
     * 
     * @param string $game API代码（api_code）
     * @return \Illuminate\Http\Response
     */
    private function batchCreateUserApi($game)
    {
        try {
            // 获取所有用户
            $users = Users::select('id', 'username')->get();
            
            if ($users->isEmpty()) {
                return response()->json([
                    'code' => 404,
                    'message' => '未找到任何用户',
                    'data' => []
                ]);
            }
            
            $successCount = 0;
            $updateCount = 0;
            $errorCount = 0;
            $errors = [];
            
            // 使用事务确保数据一致性
            DB::beginTransaction();
            
            try {
                foreach ($users as $user) {
                    try {
                        // 检查是否已存在相同的 user_id 和 api_code 组合
                        $existing = User_Api::where('user_id', $user->id)
                            ->where('api_code', $game)
                            ->first();
                        
                        if ($existing) {
                            // 如果已存在，更新记录
                            $existing->api_user = $user->username;
                            $existing->api_pass = '123456';
                            $existing->updated_at = now();
                            $existing->save();
                            $updateCount++;
                        } else {
                            // 如果不存在，创建新记录
                            User_Api::create([
                                'user_id' => $user->id,
                                'api_user' => $user->username,
                                'api_pass' => '123456',
                                'api_code' => $game,
                                'api_money' => 0.00,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                            $successCount++;
                        }
                    } catch (\Exception $e) {
                        $errorCount++;
                        $errors[] = [
                            'user_id' => $user->id,
                            'username' => $user->username,
                            'error' => $e->getMessage()
                        ];
                    }
                }
                
                DB::commit();
                
                return response()->json([
                    'code' => 200,
                    'message' => '批量处理完成',
                    'data' => [
                        'game' => $game,
                        'total_users' => $users->count(),
                        'created' => $successCount,
                        'updated' => $updateCount,
                        'errors' => $errorCount,
                        'error_details' => $errors
                    ]
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'code' => 500,
                    'message' => '批量处理失败：' . $e->getMessage(),
                    'data' => []
                ]);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => '处理失败：' . $e->getMessage(),
                'data' => []
            ]);
        }
    }
}

