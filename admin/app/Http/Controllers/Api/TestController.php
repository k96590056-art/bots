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
     * 测试接口：调用 DbgmagService::getGameList 拉取游戏列表
     *
     * 访问路径：/api/test
     * 可选参数（query 或 body 均可）：
     * - providerCode
     * - gameType
     * - gameCode
     * - page
     * - size
     */
    public function test(Request $request)
    {
        // 如果传入了 game 参数，执行批量写入 user_api 的逻辑
        $game = (string) $request->input('game', '');
        if ($game !== '') {
            return $this->batchCreateUserApi($game);
        }
        
        // 原有的游戏列表逻辑
        $providerCode = (string) $request->input('providerCode', '');
        $gameType = (string) $request->input('gameType', '');
        $gameCode = (string) $request->input('gameCode', '');
        $page = (int) $request->input('page', 1);
        $size = (int) $request->input('size', 10000);

        $service = new DbgmagService();
        $res = $service->getGameList($providerCode, $gameType, $gameCode, $page, $size);

        if (!isset($res['code']) || (int)$res['code'] !== 200) {
            return response()->json($res);
        }

        $records = $res['data'] ?? [];
        if (!is_array($records)) {
            return response()->json(['code' => 500, 'message' => 'Dbgmag 返回 records 格式错误', 'data' => $res]);
        }

        // 1) 先把 GMAG records 重组成游戏数据
        $mappedRows = [];
        foreach ($records as $r) {
            if (!is_array($r)) continue;
            
            // 映射字段：
            // game_code = gameCode
            // category_id = gameType
            // name = cnName
            // name_en = enName
            $row = [
                'game_code' => (string)($r['gameCode'] ?? ''),
                'category_id' => (string)($r['gameType'] ?? ''),
                'name' => (string)($r['cnName'] ?? ''),
                'name_en' => (string)($r['enName'] ?? ''),
            ];
            
            // 保留原始数据中的其他字段（如果有需要）
            if (isset($r['providerCode'])) {
                $row['provider_code'] = (string)$r['providerCode'];
            }
            
            $mappedRows[] = $row;
        }

        if (empty($mappedRows)) {
            return response("没有采集到游戏列表数据\n", 200, ['Content-Type' => 'text/plain; charset=utf-8']);
        }

        // 2) 检查每个游戏是否已存在，并输出 JSON
        $lines = [];
        $existsCache = [];
        $validCount = 0; // 统计有效游戏数量（有 game_code 的）
        
        foreach ($mappedRows as $row) {
            $gameCodeValue = (string)($row['game_code'] ?? '');
            if ($gameCodeValue === '') {
                // 无 game_code 的数据跳过
                continue;
            }

            $validCount++; // 统计有效游戏

            // 检查 game_code 是否已存在于 game_lists 表
            if (!array_key_exists($gameCodeValue, $existsCache)) {
                $existsCache[$gameCodeValue] = GameList::query()
                    ->where('game_code', $gameCodeValue)
                    ->exists();
            }
            
            // 标记是否存在
            $row['exists'] = $existsCache[$gameCodeValue];
            $row['exists_text'] = $existsCache[$gameCodeValue] ? '已存在' : '不存在';
            
            // 每行输出一个 JSON
            $lines[] = json_encode($row, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        // 在最开始输出游戏总数
        $output = "本次获取到的游戏总数: {$validCount}\n" . implode("\n", $lines) . "\n";
        return response($output, 200, ['Content-Type' => 'text/plain; charset=utf-8']);
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

