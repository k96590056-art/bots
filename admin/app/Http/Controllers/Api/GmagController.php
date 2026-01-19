<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\User_Api;
use App\Services\DbgmagService;
use Illuminate\Support\Str;

/**
 * CMAG回调控制器
 * 根据 cmag copy.md 文档实现
 * 
 * 处理GM-Ag系统回调代理系统的接口：
 * - /auth: 验证玩家身份
 * - /balance: 获取玩家余额
 * - /transaction: 交易（押注、赢取等）
 * - /payUp: 发放玩家奖金
 */
class GmagController extends Controller
{
    protected $secret_key = 'G6LsgCjhwfHNRImKOQZW'; // 密钥，需要根据实际配置修改（与DbgmagService保持一致）
    protected $brand_id = 1373; // 代理标识（与DbgmagService保持一致）

    /**
     * 统一获取请求参数（支持POST、GET、JSON多种格式）
     * 
     * 支持的数据来源：
     * 1. POST 表单数据 (application/x-www-form-urlencoded)
     * 2. GET 查询参数 (?key=value)
     * 3. JSON 请求体 (application/json)
     * 4. URL 参数中的 hash (?hash=xxx)
     * 
     * @param Request $request
     * @return array 合并后的请求数据
     */
    private function getAllRequestData(Request $request)
    {
        // 获取所有请求数据（自动处理POST、GET、JSON）
        $data = $request->all();
        
        // 如果请求是JSON格式，需要手动解析
        if ($request->isJson()) {
            $json_data = json_decode($request->getContent(), true);
            if (is_array($json_data)) {
                $data = array_merge($data, $json_data);
            }
        }
        
        // hash 可以从 URL 参数中获取（?hash=xxx）
        if ($request->has('hash')) {
            $data['hash'] = $request->query('hash', $data['hash'] ?? '');
        }
        
        return $data;
    }

    /**
     * 验证hash签名
     * 
     * @param array $data 请求数据（已排除 hash 字段）
     * @param string $hash 请求中的 hash 值
     * @return bool
     */
    private function checkHash($data, $hash)
    {
        $string = '';
        ksort($data);
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $v = json_encode($v, JSON_UNESCAPED_SLASHES);
            }
            $string .= $k . '=' . $v . '&';
        }
        // unicode string replace
        $string = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, $string);
        return $hash === md5(Str::replaceLast('&', $this->secret_key, $string));
    }

    /**
     * 统一响应格式
     * 
     * @param string $request_id 请求ID
     * @param string $error 错误码，0表示成功
     * @param string $message 消息
     * @param array $data 额外数据
     * @return \Illuminate\Http\JsonResponse
     */
    private function response($request_id, $error = '0', $message = 'success', $data = [])
    {
        $response = [
            'requestId' => $request_id,
            'error' => $error,
            'message' => $message
        ];
        
        if (!empty($data)) {
            $response = array_merge($response, $data);
        }
        
        return response()->json($response);
    }

    /**
     * 验证玩家身份
     * URI: /xingyun/auth
     * 方式: 支持 POST、GET、JSON
     * 
     * 目的：在游戏启动过程中，GM-Ag 系统需要验证接收到的玩家令牌（token）
     * 
     * 支持的数据格式：
     * - POST 表单数据
     * - GET 查询参数
     * - JSON 请求体
     * - hash 可以从 URL 参数获取 (?hash=xxx)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth(Request $request)
    {
        try {
            // 统一获取请求数据（支持多种格式）
            $data = $this->getAllRequestData($request);
            
            $request_id = $data['requestId'] ?? $request->input('requestId', '');
            $brand_id = $data['brandId'] ?? $request->input('brandId', 0);
            $token = $data['token'] ?? $request->input('token', '');
            $ip = $data['ip'] ?? $request->input('ip', '');
            // hash 可以从 URL 参数或请求体中获取
            $hash = $request->query('hash', $data['hash'] ?? $request->input('hash', ''));

            Log::info('CMAG auth请求', [
                'requestId' => $request_id,
                'brandId' => $brand_id,
                'token' => $token,
                'ip' => $ip
            ]);

            // 验证必要参数
            if (empty($request_id) || empty($brand_id) || empty($token)) {
                return $this->response($request_id, 'P_01', 'Invalid request. Required parameters are missing.');
            }

            // 验证hash（如果提供了hash）
            if (!empty($hash)) {
                $data = $request->except(['hash']);
                if (!$this->checkHash($data, $hash)) {
                    return $this->response($request_id, 'P_02', 'Invalid hash');
                }
            }

            // 根据token查找用户
            // token是从GM-Ag系统获取的，需要从缓存或数据库中查找token对应的用户
            // 方案1：从缓存中查找（token在生成游戏URL时已存储）
            $user_info = Cache::get('cmag_token_' . $token);
            
            if ($user_info && isset($user_info['username'])) {
                $username = $user_info['username'];
                $user = User::where('username', $username)->first();
            } else {
                // 方案2：如果缓存中没有，尝试从token中解析（如果token包含用户信息）
                // 或者从数据库查询token映射表
                // 这里假设token可能包含用户名信息（需要根据实际token格式调整）
                // TODO: 实现token映射表，存储token和用户的对应关系
                
                // 临时方案：尝试从token中提取用户名（如果token格式为 username_timestamp_random）
                $parts = explode('_', $token);
                if (count($parts) > 0) {
                    $username = $parts[0];
                    $user = User::where('username', $username)->first();
                } else {
                    // 如果无法解析，尝试直接使用token作为用户名（仅用于测试）
                    $user = User::where('username', $token)->first();
                }
            }
            
            if (!$user) {
                return $this->response($request_id, 'P_04', 'Player not found');
            }

            // 获取用户余额
            $user_balance = $user->balance ?? 0;
            
            // 生成会话ID
            $player_session_id = 'session_' . $user->id . '_' . time() . '_' . Str::random(10);

            // 返回玩家信息
            return $this->response($request_id, '0', 'success', [
                'playerId' => $user->username,
                'playerName' => $user->username,
                'playerSessionId' => $player_session_id,
                'currency' => 'CNY',
                'balance' => number_format($user_balance, 4, '.', ''),
                'country' => 'CN',
                'testAccount' => false
            ]);

        } catch (\Exception $e) {
            Log::error('CMAG auth异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $request_id = $request->input('requestId', '');
            return $this->response($request_id, 'P_00', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * 获取玩家余额
     * URI: /xingyun/balance
     * 方式: 支持 POST、GET、JSON
     * 
     * 目的：从代理的钱包系统获取玩家的余额
     * 
     * 支持的数据格式：
     * - POST 表单数据
     * - GET 查询参数
     * - JSON 请求体
     * - hash 可以从 URL 参数获取 (?hash=xxx)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function balance(Request $request)
    {
        try {
            // 统一获取请求数据（支持多种格式）
            $data = $this->getAllRequestData($request);
            
            $request_id = $data['requestId'] ?? $request->input('requestId', '');
            $brand_id = $data['brandId'] ?? $request->input('brandId', 0);
            $player_id = $data['playerId'] ?? $request->input('playerId', '');
            $player_session_id = $data['playerSessionId'] ?? $request->input('playerSessionId', '');
            $game_code = $data['gameCode'] ?? $request->input('gameCode', '');
            // hash 可以从 URL 参数或请求体中获取
            $hash = $request->query('hash', $data['hash'] ?? $request->input('hash', ''));

            Log::info('CMAG balance请求', [
                'requestId' => $request_id,
                'playerId' => $player_id,
                'playerSessionId' => $player_session_id,
                'gameCode' => $game_code
            ]);

            // 验证必要参数
            if (empty($request_id) || empty($brand_id) || empty($player_id) || empty($player_session_id)) {
                return $this->response($request_id, 'P_01', 'Invalid request. Required parameters are missing.');
            }

            // 验证hash（如果提供了hash）
            if (!empty($hash)) {
                $hash_data = $data;
                unset($hash_data['hash']); // 排除hash字段
                if (!$this->checkHash($hash_data, $hash)) {
                    return $this->response($request_id, 'P_02', 'Invalid hash');
                }
            }

            // 查找用户
            $user = User::where('username', $player_id)->first();
            
            if (!$user) {
                return $this->response($request_id, 'P_04', 'Player not found');
            }

            // 获取用户余额
            $user_balance = $user->balance ?? 0;
            $bonus_balance = 0; // 奖金余额，需要根据实际业务实现

            // 返回余额信息
            return $this->response($request_id, '0', 'success', [
                "player_id"=>$player_id,
                'currency' => 'CNY',
                'balance' => number_format($user_balance, 4, '.', ''),
                'bonusBalance' => number_format($bonus_balance, 4, '.', ''),
                'timestamp' => now()->format('Y-m-d H:i:s')
            ]);

        } catch (\Exception $e) {
            Log::error('CMAG balance异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $request_id = $request->input('requestId', '');
            return $this->response($request_id, 'P_00', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * 交易
     * URI: /xingyun/transaction
     * 方式: 支持 POST、GET、JSON
     * 
     * 目的：当玩家游戏时，用于改变代理钱包系统中的玩家余额
     * 
     * 支持的数据格式：
     * - POST 表单数据
     * - GET 查询参数
     * - JSON 请求体（推荐，因为包含数组数据）
     * - hash 可以从 URL 参数获取 (?hash=xxx)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transaction(Request $request)
    {
        try {
            // 统一获取请求数据（支持多种格式）
            $data = $this->getAllRequestData($request);
            
            $request_id = $data['requestId'] ?? $request->input('requestId', '');
            $brand_id = $data['brandId'] ?? $request->input('brandId', 0);
            $player_id = $data['playerId'] ?? $request->input('playerId', '');
            $player_session_id = $data['playerSessionId'] ?? $request->input('playerSessionId', '');
            $game_code = $data['gameCode'] ?? $request->input('gameCode', '');
            // trans 是数组，需要特殊处理
            $trans = $data['trans'] ?? $request->input('trans', []);
            // 如果 trans 是 JSON 字符串，需要解析
            if (is_string($trans)) {
                $trans = json_decode($trans, true) ?: [];
            }
            $end_session = $data['endSession'] ?? $request->input('endSession', 0);
            $detail_url = $data['detailUrl'] ?? $request->input('detailUrl', '');
            $bonus_changes = $data['bonusChanges'] ?? $request->input('bonusChanges', []);
            // 如果 bonusChanges 是 JSON 字符串，需要解析
            if (is_string($bonus_changes)) {
                $bonus_changes = json_decode($bonus_changes, true) ?: [];
            }
            $provider_code = $data['providerCode'] ?? $request->input('providerCode', '');
            $game_type = $data['gameType'] ?? $request->input('gameType', '');
            // hash 可以从 URL 参数或请求体中获取
            $hash = $request->query('hash', $data['hash'] ?? $request->input('hash', ''));

            Log::info('CMAG transaction请求', [
                'requestId' => $request_id,
                'playerId' => $player_id,
                'gameCode' => $game_code,
                'transCount' => count($trans)
            ]);

            // 验证必要参数
            if (empty($request_id) || empty($brand_id) || empty($player_id) || 
                empty($player_session_id) || empty($game_code) || empty($trans) || 
                !is_array($trans) || empty($trans)) {
                return $this->response($request_id, 'P_01', 'Invalid request. Required parameters are missing.');
            }

            // 验证hash（如果提供了hash）
            if (!empty($hash)) {
                $hash_data = $data;
                unset($hash_data['hash']); // 排除hash字段
                if (!$this->checkHash($hash_data, $hash)) {
                    return $this->response($request_id, 'P_02', 'Invalid hash');
                }
            }

            // 查找用户
            $user = User::where('username', $player_id)->first();
            
            if (!$user) {
                return $this->response($request_id, 'P_04', 'Player not found');
            }

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                $bonus_balance = 0;
                
                // 处理交易数组
                foreach ($trans as $tran) {
                    $trans_id = $tran['transId'] ?? '';
                    $trans_type = $tran['transType'] ?? '';
                    $amount = floatval($tran['amount'] ?? 0);
                    $round_id = $tran['roundId'] ?? '';
                    
                    // 检查是否已处理过（幂等性）
                    // TODO: 实现交易记录表，检查transId是否已处理
                    
                    // 根据交易类型处理
                    switch ($trans_type) {
                        case 'bet':
                        case 'transIn':
                            // 扣款：从玩家余额扣除
                            if ($user_balance < $amount) {
                                DB::rollBack();
                                return $this->response($request_id, 'T_01', 'Player Insufficient Funds', [
                                    'balance' => number_format($user_balance, 4, '.', ''),
                                    'bonusBalance' => number_format($bonus_balance, 4, '.', '')
                                ]);
                            }
                            $user_balance -= $amount;
                            break;
                            
                        case 'win':
                        case 'transOut':
                            // 加款：增加玩家余额
                            $user_balance += $amount;
                            break;
                            
                        case 'cancel':
                            // 取消：需要根据referenceId找到原交易并回滚
                            // TODO: 实现取消逻辑
                            break;
                            
                        case 'amend':
                            // 调整：金额可能为正数或负数
                            $user_balance += $amount;
                            break;
                    }
                    
                    // TODO: 保存交易记录到数据库
                }
                
                // 更新用户余额
                $user->balance = $user_balance;
                $user->save();
                
                // 提交事务
                DB::commit();
                
                Log::info('CMAG transaction处理成功', [
                    'requestId' => $request_id,
                    'playerId' => $player_id,
                    'newBalance' => $user_balance
                ]);
                
                // 返回结果
                return $this->response($request_id, '0', 'success', [
                    'currency' => 'CNY',
                    'balance' => number_format($user_balance, 4, '.', ''),
                    'bonusBalance' => number_format($bonus_balance, 4, '.', '')
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('CMAG transaction异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $request_id = $request->input('requestId', '');
            return $this->response($request_id, 'P_00', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * 发放玩家奖金
     * URI: /xingyun/payUp
     * 方式: 支持 POST、GET、JSON
     * 
     * 目的：当发放奖金时，改变玩家在代理钱包系统中的余额
     * 
     * 支持的数据格式：
     * - POST 表单数据
     * - GET 查询参数
     * - JSON 请求体
     * - hash 可以从 URL 参数获取 (?hash=xxx)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function payUp(Request $request)
    {
        try {
            // 统一获取请求数据（支持多种格式）
            $data = $this->getAllRequestData($request);
            
            $request_id = $data['requestId'] ?? $request->input('requestId', '');
            $brand_id = $data['brandId'] ?? $request->input('brandId', 0);
            $player_id = $data['playerId'] ?? $request->input('playerId', '');
            $trans_id = $data['transId'] ?? $request->input('transId', '');
            $type = $data['type'] ?? $request->input('type', '');
            $reference_id = $data['referenceId'] ?? $request->input('referenceId', '');
            $reference_name = $data['referenceName'] ?? $request->input('referenceName', '');
            $provider_code = $data['providerCode'] ?? $request->input('providerCode', '');
            $currency = $data['currency'] ?? $request->input('currency', 'CNY');
            $amount = floatval($data['amount'] ?? $request->input('amount', 0));
            $trans_time = $data['transTime'] ?? $request->input('transTime', '');
            $desc = $data['desc'] ?? $request->input('desc', '');
            $additional_data = $data['additionalData'] ?? $request->input('additionalData', []);
            // 如果 additionalData 是 JSON 字符串，需要解析
            if (is_string($additional_data)) {
                $additional_data = json_decode($additional_data, true) ?: [];
            }
            // hash 可以从 URL 参数或请求体中获取
            $hash = $request->query('hash', $data['hash'] ?? $request->input('hash', ''));

            Log::info('CMAG payUp请求', [
                'requestId' => $request_id,
                'playerId' => $player_id,
                'transId' => $trans_id,
                'type' => $type,
                'amount' => $amount
            ]);

            // 验证必要参数
            if (empty($request_id) || empty($brand_id) || empty($player_id) || 
                empty($trans_id) || empty($type) || empty($provider_code) || 
                empty($currency) || $amount <= 0) {
                return $this->response($request_id, 'P_01', 'Invalid request. Required parameters are missing.');
            }

            // 验证hash（如果提供了hash）
            if (!empty($hash)) {
                $hash_data = $data;
                unset($hash_data['hash']); // 排除hash字段
                if (!$this->checkHash($hash_data, $hash)) {
                    return $this->response($request_id, 'P_02', 'Invalid hash');
                }
            }

            // 查找用户
            $user = User::where('username', $player_id)->first();
            
            if (!$user) {
                return $this->response($request_id, 'P_04', 'Player not found');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                $bonus_balance = 0;
                
                // 增加玩家余额
                $user_balance += $amount;
                
                // 更新用户余额
                $user->balance = $user_balance;
                $user->save();
                
                // TODO: 保存奖金记录到数据库
                
                // 提交事务
                DB::commit();
                
                Log::info('CMAG payUp处理成功', [
                    'requestId' => $request_id,
                    'playerId' => $player_id,
                    'transId' => $trans_id,
                    'amount' => $amount,
                    'newBalance' => $user_balance
                ]);
                
                // 返回结果
                return $this->response($request_id, '0', 'success', [
                    'currency' => $currency,
                    'balance' => number_format($user_balance, 4, '.', ''),
                    'bonusBalance' => number_format($bonus_balance, 4, '.', '')
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('CMAG payUp异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $request_id = $request->input('requestId', '');
            return $this->response($request_id, 'P_00', 'Server Error: ' . $e->getMessage());
        }
    }
}
