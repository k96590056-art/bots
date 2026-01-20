<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * OneAPI 回调控制器
 * 根据 oneapi copy.md 文档实现
 * 
 * 处理 Game Aggregator 回调代理系统的接口：
 * Wallet API:
 * - /wallet/balance: 获取玩家余额
 * - /wallet/bet: 投注（扣款）
 * - /wallet/bet_result: 投注结果（加款/扣款）
 * - /wallet/rollback: 回滚交易
 * - /wallet/adjustment: 调整金额
 * - /wallet/bet_debit: 进入游戏房间扣款
 * - /wallet/bet_credit: 结算并更新余额
 * 
 * Sportsbook API:
 * - /sports/bet: 投注
 * - /sports/update-bet: 更新投注
 * - /sports/refund: 退款
 * - /sports/settled: 结算
 * - /sports/unsettle: 取消结算
 * - /sports/resettle: 重新结算
 * - /sports/adjustment: 调整
 * 
 * Promo API:
 * - /v1/promo/payout: 发放奖金
 */
class OneapiController extends Controller
{
    protected $api_secret = '9ff1662935474b60a66c053b6f1252a2e5204fd5dc4a77f9293b5905dbfc423d';  // API Secret，需要根据实际配置修改

    /**
     * 统一获取请求参数（支持POST、GET、JSON多种格式）
     * 
     * @param Request $request
     * @return array 合并后的请求数据
     */
    private function getAllRequestData(Request $request)
    {
        $data = $request->all();
        
        if ($request->isJson()) {
            $json_data = json_decode($request->getContent(), true);
            if (is_array($json_data)) {
                $data = array_merge($data, $json_data);
            }
        }
        
        return $data;
    }

    /**
     * 验证 X-Signature 签名
     * 使用 HMAC-SHA256 算法验证请求签名
     * 
     * @param Request $request
     * @return bool
     */
    private function verifySignature(Request $request)
    {
        $signature = $request->header('X-Signature');
        if (empty($signature)) {
            Log::warning('OneAPI签名验证失败：缺少X-Signature头');
            return false;
        }

        // 优先从 php://input 获取原始请求体（这是最可靠的方式）
        $request_body = file_get_contents('php://input');
        
        // 如果 php://input 为空，尝试使用 getContent()
        if (empty($request_body)) {
            $request_body = $request->getContent();
        }
        
        // 如果还是为空，可能是请求体已经被读取过了
        // 尝试从请求数据重新构建 JSON（作为最后的后备方案）
        // 注意：这种方式可能因为 JSON 格式差异（字段顺序、空格等）导致签名不匹配
        // 建议检查 Laravel 中间件配置，确保请求体未被提前读取
        if (empty($request_body) && $request->isJson()) {
            $data = $this->getAllRequestData($request);
            // 移除 signature 相关字段，只保留业务数据
            unset($data['signature']);
            // 使用与 DbOneapiService 相同的 JSON 编码选项（JSON_UNESCAPED_SLASHES）
            $request_body = json_encode($data, JSON_UNESCAPED_SLASHES);
            Log::warning('OneAPI签名验证：使用重新构建的JSON（可能不准确）', [
                'reconstructed_body' => $request_body
            ]);
        }
        
        if (empty($request_body)) {
            Log::warning('OneAPI签名验证失败：无法获取请求体', [
                'content_type' => $request->header('Content-Type'),
                'method' => $request->method(),
                'is_json' => $request->isJson(),
                'has_content' => !empty($request->getContent()),
                'php_input' => !empty(file_get_contents('php://input'))
            ]);
            return false;
        }

        // 生成期望的签名
        $expected_signature = hash_hmac('sha256', $request_body, $this->api_secret);

        // 使用时间安全的字符串比较
        if (!hash_equals($signature, $expected_signature)) {
            Log::warning('OneAPI签名验证失败', [
                'request_signature' => $signature,
                'expected_signature' => $expected_signature,
                'request_body_length' => strlen($request_body),
                'request_body_preview' => substr($request_body, 0, 200) . (strlen($request_body) > 200 ? '...' : ''),
                'request_body_full' => $request_body, // 完整请求体用于调试
                'content_type' => $request->header('Content-Type'),
                'api_secret_length' => strlen($this->api_secret)
            ]);
            return false;
        }

        Log::debug('OneAPI签名验证成功', [
            'request_body_length' => strlen($request_body),
            'signature_match' => true,
            '来访参数' => $request
        ]);

        return true;
    }

    /**
     * 统一响应格式
     * 
     * @param string $trace_id 追踪ID
     * @param string $status 状态码（SC_OK表示成功）
     * @param string $message 消息
     * @param array $data 额外数据
     * @return \Illuminate\Http\JsonResponse
     */
    private function response($trace_id, $status = 'SC_OK', $message = 'success', $data = [])
    {
        $response = [
            'traceId' => $trace_id,
            'status' => $status,
            'message' => $message
        ];
        
        if (!empty($data)) {
            $response['data'] = $data;
        }
        
        return response()->json($response);
    }

    /**
     * 获取玩家余额
     * POST https://<operator_site>/wallet/balance
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function balance(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $currency = $data['currency'] ?? 'CNY';
            $token = $data['token'] ?? '';

            Log::info('OneAPI balance请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'currency' => $currency
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($currency) || empty($token)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 验证token（如果需要）
            // TODO: 实现token验证逻辑

            // 获取用户余额
            $user_balance = $user->balance ?? 0;
            Log::error('OneAPI 返回信息', [
                'username' => $username,
                'currency' => $currency,
                'balance' => (float) $user_balance,
                'timestamp' => (int) (now()->timestamp * 1000)  // 毫秒时间戳
            ]);
            // 返回余额信息
            return $this->response($trace_id, 'SC_OK', 'success', [
                'username' => $username,
                'currency' => $currency,
                'balance' => (float) $user_balance,
                'timestamp' => (int) (now()->timestamp * 1000)  // 毫秒时间戳
            ]);

        } catch (\Exception $e) {
            Log::error('OneAPI balance异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * 投注（扣款）
     * POST https://<operator_site>/wallet/bet
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bet(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $bet_id = $data['betId'] ?? '';
            $external_transaction_id = $data['externalTransactionId'] ?? '';
            $amount = (float) ($data['amount'] ?? 0);
            $currency = $data['currency'] ?? 'CNY';
            $token = $data['token'] ?? '';
            $game_code = $data['gameCode'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $timestamp = $data['timestamp'] ?? 0;

            Log::info('OneAPI bet请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'amount' => $amount
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($bet_id) || empty($external_transaction_id) || empty($amount) || 
                empty($currency) || empty($token) || empty($game_code) || empty($round_id)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 检查余额是否充足
                if ($user_balance < $amount) {
                    DB::rollBack();
                    return $this->response($trace_id, 'SC_INSUFFICIENT_FUNDS', 'Insufficient funds', [
                        'username' => $username,
                        'currency' => $currency,
                        'balance' => (float) $user_balance,
                        'timestamp' => (int) (now()->timestamp * 1000)
                    ]);
                }

                // 扣款
                $user_balance -= $amount;
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存交易记录到数据库

                DB::commit();

                Log::info('OneAPI bet处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'amount' => $amount,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI bet异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * 投注结果（加款/扣款）
     * POST https://<operator_site>/wallet/bet_result
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function betResult(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $bet_id = $data['betId'] ?? '';
            $external_transaction_id = $data['externalTransactionId'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $bet_amount = (float) ($data['betAmount'] ?? 0);
            $win_amount = (float) ($data['winAmount'] ?? 0);
            $effective_turnover = (float) ($data['effectiveTurnover'] ?? 0);
            $win_loss = (float) ($data['winLoss'] ?? 0);
            $jackpot_amount = (float) ($data['jackpotAmount'] ?? 0);
            $result_type = $data['resultType'] ?? '';
            $is_freespin = (int) ($data['isFreespin'] ?? 0);
            $is_end_round = (int) ($data['isEndRound'] ?? 0);
            $currency = $data['currency'] ?? 'CNY';
            $token = $data['token'] ?? '';
            $game_code = $data['gameCode'] ?? '';
            $bet_time = $data['betTime'] ?? 0;
            $settled_time = $data['settledTime'] ?? 0;

            Log::info('OneAPI bet_result请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'resultType' => $result_type,
                'betAmount' => $bet_amount,
                'winAmount' => $win_amount
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($bet_id) || empty($external_transaction_id) || empty($round_id) || 
                empty($bet_amount) || empty($result_type) || empty($currency) || 
                empty($token) || empty($game_code) || empty($bet_time)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 根据resultType处理
                switch ($result_type) {
                    case 'WIN':
                        // 玩家赢了，加款
                        $user_balance += $win_amount;
                        break;
                    case 'BET_WIN':
                        // 投注并赢了，先扣款再加款（净加款）
                        $user_balance -= $bet_amount;
                        $user_balance += $win_amount;
                        break;
                    case 'BET_LOSE':
                        // 投注并输了，扣款
                        $user_balance -= $bet_amount;
                        break;
                    case 'LOSE':
                        // 输了，扣款
                        $user_balance -= $bet_amount;
                        break;
                    case 'END':
                        // 回合结束，不需要操作余额
                        break;
                }

                // 添加jackpot金额（如果有）
                if ($jackpot_amount > 0) {
                    $user_balance += $jackpot_amount;
                }

                // 更新余额
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存交易记录到数据库

                DB::commit();

                Log::info('OneAPI bet_result处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'resultType' => $result_type,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI bet_result异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * 回滚交易
     * POST https://<operator_site>/wallet/rollback
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rollback(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $bet_id = $data['betId'] ?? '';
            $external_transaction_id = $data['externalTransactionId'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $game_code = $data['gameCode'] ?? '';
            $username = $data['username'] ?? '';
            $currency = $data['currency'] ?? 'CNY';
            $timestamp = $data['timestamp'] ?? 0;

            Log::info('OneAPI rollback请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'betId' => $bet_id
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($transaction_id) || empty($bet_id) || 
                empty($external_transaction_id) || empty($round_id) || empty($game_code) || 
                empty($username) || empty($currency) || empty($timestamp)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 根据betId找到原交易并回滚
                // TODO: 实现回滚逻辑，根据betId找到原交易并恢复余额

                // 更新余额
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存回滚记录到数据库

                DB::commit();

                Log::info('OneAPI rollback处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI rollback异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * 调整金额
     * POST https://<operator_site>/wallet/adjustment
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function adjustment(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $external_transaction_id = $data['externalTransactionId'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $amount = (float) ($data['amount'] ?? 0);
            $currency = $data['currency'] ?? 'CNY';
            $game_code = $data['gameCode'] ?? '';
            $timestamp = $data['timestamp'] ?? 0;

            Log::info('OneAPI adjustment请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'amount' => $amount
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($external_transaction_id) || empty($round_id) || empty($amount) || 
                empty($currency) || empty($game_code) || empty($timestamp)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 调整金额（amount可以是正数或负数）
                $user_balance += $amount;

                // 更新余额
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存调整记录到数据库

                DB::commit();

                Log::info('OneAPI adjustment处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'amount' => $amount,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI adjustment异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * 进入游戏房间扣款
     * POST https://<operator_site>/wallet/bet_debit
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function betDebit(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $take_all = (int) ($data['takeAll'] ?? 0);
            $amount = (float) ($data['amount'] ?? 0);
            $currency = $data['currency'] ?? 'CNY';
            $game_code = $data['gameCode'] ?? '';
            $timestamp = $data['timestamp'] ?? 0;

            Log::info('OneAPI bet_debit请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'takeAll' => $take_all,
                'amount' => $amount
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($round_id) || empty($currency) || empty($game_code) || empty($timestamp)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 如果takeAll=1，扣除全部余额
                if ($take_all == 1) {
                    $amount = $user_balance;
                }

                // 检查余额是否充足
                if ($user_balance < $amount) {
                    DB::rollBack();
                    return $this->response($trace_id, 'SC_INSUFFICIENT_FUNDS', 'Insufficient funds', [
                        'username' => $username,
                        'currency' => $currency,
                        'balance' => (float) $user_balance,
                        'timestamp' => (int) (now()->timestamp * 1000)
                    ]);
                }

                // 扣款
                $user_balance -= $amount;
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存交易记录到数据库

                DB::commit();

                Log::info('OneAPI bet_debit处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'amount' => $amount,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI bet_debit异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * 结算并更新余额
     * POST https://<operator_site>/wallet/bet_credit
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function betCredit(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $bet_id = $data['betId'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $is_refund = (int) ($data['isRefund'] ?? 0);
            $amount = (float) ($data['amount'] ?? 0);
            $bet_amount = (float) ($data['betAmount'] ?? 0);
            $win_amount = (float) ($data['winAmount'] ?? 0);
            $effective_turnover = (float) ($data['effectiveTurnover'] ?? 0);
            $win_loss = (float) ($data['winLoss'] ?? 0);
            $jackpot_amount = (float) ($data['jackpotAmount'] ?? 0);
            $currency = $data['currency'] ?? 'CNY';
            $token = $data['token'] ?? '';
            $game_code = $data['gameCode'] ?? '';
            $bet_time = $data['betTime'] ?? 0;
            $settled_time = $data['settledTime'] ?? 0;
            $timestamp = $data['timestamp'] ?? 0;

            Log::info('OneAPI bet_credit请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'amount' => $amount,
                'isRefund' => $is_refund
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($bet_id) || empty($round_id) || empty($amount) || 
                empty($bet_amount) || empty($win_amount) || empty($effective_turnover) || 
                empty($win_loss) || empty($currency) || empty($token) || 
                empty($game_code) || empty($bet_time) || empty($timestamp)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 添加剩余余额到玩家钱包
                $user_balance += $amount;

                // 添加jackpot金额（如果有）
                if ($jackpot_amount > 0) {
                    $user_balance += $jackpot_amount;
                }

                // 更新余额
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存交易记录到数据库

                DB::commit();

                Log::info('OneAPI bet_credit处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'amount' => $amount,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI bet_credit异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * 发放奖金
     * POST https://<operator_site>/v1/promo/payout
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function promoPayout(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $campaign_id = $data['campaignId'] ?? '';
            $currency = $data['currency'] ?? 'CNY';
            $amount = (float) ($data['amount'] ?? 0);
            $timestamp = $data['timestamp'] ?? 0;

            Log::info('OneAPI promo_payout请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'campaignId' => $campaign_id,
                'amount' => $amount
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($campaign_id) || empty($currency) || empty($amount) || empty($timestamp)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 增加玩家余额
                $user_balance += $amount;

                // 更新余额
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存奖金记录到数据库

                DB::commit();

                Log::info('OneAPI promo_payout处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'amount' => $amount,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'balance' => (float) $user_balance,
                    'currency' => $currency,
                    'timestamp' => $timestamp
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI promo_payout异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * Sportsbook API - 投注
     * POST https://<operator_site>/sports/bet
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sportsBet(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $external_transaction_id = $data['externalTransactionId'] ?? '';
            $bet_id = $data['betId'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $bet_amount = (float) ($data['betAmount'] ?? 0);
            $game_code = $data['gameCode'] ?? '';
            $currency = $data['currency'] ?? 'CNY';
            $bet_type = (int) ($data['betType'] ?? 1);
            $odds_type = (int) ($data['oddsType'] ?? 0);
            $odds = (float) ($data['odds'] ?? 0);
            $timestamp = (int) ($data['timestamp'] ?? 0);
            $multiple_bet_ids = $data['multipleBetIds'] ?? [];
            if (is_string($multiple_bet_ids)) {
                $multiple_bet_ids = json_decode($multiple_bet_ids, true) ?: [];
            }

            Log::info('OneAPI sports_bet请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'betAmount' => $bet_amount,
                'betType' => $bet_type
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($external_transaction_id) || empty($bet_id) || empty($round_id) || 
                empty($bet_amount) || empty($game_code) || empty($currency) || empty($timestamp)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 计算总投注金额（包括 Parlay Bet 的多个投注）
                $total_bet_amount = $bet_amount;
                if ($bet_type == 2 && !empty($multiple_bet_ids)) {
                    // Parlay Bet：需要处理多个投注
                    foreach ($multiple_bet_ids as $bet_item) {
                        $item_bet_amount = (float) ($bet_item['betAmount'] ?? 0);
                        $total_bet_amount += $item_bet_amount;
                    }
                }

                // 检查余额是否充足
                if ($user_balance < $total_bet_amount) {
                    DB::rollBack();
                    return $this->response($trace_id, 'SC_INSUFFICIENT_FUNDS', 'Insufficient funds', [
                        'username' => $username,
                        'currency' => $currency,
                        'balance' => (float) $user_balance,
                        'timestamp' => (int) (now()->timestamp * 1000)
                    ]);
                }

                // 扣款
                $user_balance -= $total_bet_amount;
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存交易记录到数据库

                DB::commit();

                Log::info('OneAPI sports_bet处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'betAmount' => $total_bet_amount,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI sports_bet异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * Sportsbook API - 更新投注
     * POST https://<operator_site>/sports/update-bet
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sportsUpdateBet(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $external_transaction_id = $data['externalTransactionId'] ?? '';
            $bet_id = $data['betId'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $bet_amount = (float) ($data['betAmount'] ?? 0);
            $new_bet_amount = (float) ($data['newBetAmount'] ?? 0);
            $credit_amount = (float) ($data['creditAmount'] ?? 0);
            $game_code = $data['gameCode'] ?? '';
            $currency = $data['currency'] ?? 'CNY';
            $odds_type = (int) ($data['oddsType'] ?? 0);
            $odds = (float) ($data['odds'] ?? 0);
            $timestamp = (int) ($data['timestamp'] ?? 0);

            Log::info('OneAPI sports_update_bet请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'creditAmount' => $credit_amount
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($external_transaction_id) || empty($bet_id) || empty($round_id) || 
                empty($bet_amount) || empty($new_bet_amount) || empty($credit_amount) || 
                empty($game_code) || empty($currency) || empty($timestamp)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 加款（creditAmount 是 betAmount 和 newBetAmount 的差值）
                $user_balance += $credit_amount;

                // 更新余额
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存交易记录到数据库

                DB::commit();

                Log::info('OneAPI sports_update_bet处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'creditAmount' => $credit_amount,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI sports_update_bet异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * Sportsbook API - 退款
     * POST https://<operator_site>/sports/refund
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sportsRefund(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $external_transaction_id = $data['externalTransactionId'] ?? '';
            $bet_id = $data['betId'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $game_code = $data['gameCode'] ?? '';
            $currency = $data['currency'] ?? 'CNY';
            $timestamp = (int) ($data['timestamp'] ?? 0);

            Log::info('OneAPI sports_refund请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'betId' => $bet_id
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($external_transaction_id) || empty($bet_id) || empty($round_id) || 
                empty($game_code) || empty($currency) || empty($timestamp)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 根据 betId 找到原交易并回滚
                // TODO: 实现退款逻辑，根据 betId 找到原交易并恢复余额

                // 更新余额
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存退款记录到数据库

                DB::commit();

                Log::info('OneAPI sports_refund处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI sports_refund异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * Sportsbook API - 结算
     * POST https://<operator_site>/sports/settled
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sportsSettled(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $external_transaction_id = $data['externalTransactionId'] ?? '';
            $bet_id = $data['betId'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $bet_amount = (float) ($data['betAmount'] ?? 0);
            $win_amount = (float) ($data['winAmount'] ?? 0);
            $effective_turnover = (float) ($data['effectiveTurnover'] ?? 0);
            $win_loss = (float) ($data['winLoss'] ?? 0);
            $game_code = $data['gameCode'] ?? '';
            $currency = $data['currency'] ?? 'CNY';
            $timestamp = (int) ($data['timestamp'] ?? 0);

            Log::info('OneAPI sports_settled请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'winAmount' => $win_amount
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($external_transaction_id) || empty($bet_id) || empty($round_id) || 
                empty($bet_amount) || empty($win_amount) || empty($effective_turnover) || 
                empty($win_loss) || empty($game_code) || empty($currency) || empty($timestamp)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 如果 winAmount > 0，加款
                if ($win_amount > 0) {
                    $user_balance += $win_amount;
                }

                // 更新余额
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存交易记录到数据库

                DB::commit();

                Log::info('OneAPI sports_settled处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'winAmount' => $win_amount,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI sports_settled异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * Sportsbook API - 取消结算
     * POST https://<operator_site>/sports/unsettle
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sportsUnsettle(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $external_transaction_id = $data['externalTransactionId'] ?? '';
            $bet_id = $data['betId'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $game_code = $data['gameCode'] ?? '';
            $currency = $data['currency'] ?? 'CNY';
            $timestamp = (int) ($data['timestamp'] ?? 0);

            Log::info('OneAPI sports_unsettle请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'betId' => $bet_id
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($external_transaction_id) || empty($bet_id) || empty($round_id) || 
                empty($game_code) || empty($currency) || empty($timestamp)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 根据 betId 找到原交易并回滚
                // TODO: 实现取消结算逻辑，根据 betId 找到原交易并恢复余额

                // 更新余额
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存取消结算记录到数据库

                DB::commit();

                Log::info('OneAPI sports_unsettle处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI sports_unsettle异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * Sportsbook API - 重新结算
     * POST https://<operator_site>/sports/resettle
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sportsResettle(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $external_transaction_id = $data['externalTransactionId'] ?? '';
            $bet_id = $data['betId'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $bet_amount = (float) ($data['betAmount'] ?? 0);
            $win_amount = (float) ($data['winAmount'] ?? 0);
            $new_win_amount = (float) ($data['newWinAmount'] ?? 0);
            $win_loss = (float) ($data['winLoss'] ?? 0);
            $debit_amount = (float) ($data['debitAmount'] ?? 0);
            $credit_amount = (float) ($data['creditAmount'] ?? 0);
            $game_code = $data['gameCode'] ?? '';
            $currency = $data['currency'] ?? 'CNY';
            $timestamp = (int) ($data['timestamp'] ?? 0);

            Log::info('OneAPI sports_resettle请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'creditAmount' => $credit_amount,
                'debitAmount' => $debit_amount
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($external_transaction_id) || empty($bet_id) || empty($round_id) || 
                empty($bet_amount) || empty($win_amount) || empty($new_win_amount) || 
                empty($win_loss) || empty($debit_amount) || empty($credit_amount) || 
                empty($game_code) || empty($currency) || empty($timestamp)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 根据 creditAmount 和 debitAmount 调整余额
                if ($debit_amount > 0) {
                    $user_balance -= $debit_amount;
                }
                if ($credit_amount > 0) {
                    $user_balance += $credit_amount;
                }

                // 更新余额
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存交易记录到数据库

                DB::commit();

                Log::info('OneAPI sports_resettle处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI sports_resettle异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }

    /**
     * Sportsbook API - 调整
     * POST https://<operator_site>/sports/adjustment
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sportsAdjustment(Request $request)
    {
        try {
            $data = $this->getAllRequestData($request);
            
            $trace_id = $data['traceId'] ?? '';
            $username = $data['username'] ?? '';
            $transaction_id = $data['transactionId'] ?? '';
            $external_transaction_id = $data['externalTransactionId'] ?? '';
            $round_id = $data['roundId'] ?? '';
            $amount = (float) ($data['amount'] ?? 0);
            $currency = $data['currency'] ?? 'CNY';
            $timestamp = (int) ($data['timestamp'] ?? 0);

            Log::info('OneAPI sports_adjustment请求', [
                'traceId' => $trace_id,
                'username' => $username,
                'transactionId' => $transaction_id,
                'amount' => $amount
            ]);

            // 验证签名
            if (!$this->verifySignature($request)) {
                return $this->response($trace_id, 'SC_INVALID_SIGNATURE', 'Invalid signature');
            }

            // 验证必要参数
            if (empty($trace_id) || empty($username) || empty($transaction_id) || 
                empty($external_transaction_id) || empty($round_id) || empty($amount) || 
                empty($currency) || empty($timestamp)) {
                return $this->response($trace_id, 'SC_INVALID_REQUEST', 'Invalid request. Required parameters are missing.');
            }

            // 查找用户
            $user = User::where('username', $username)->first();
            
            if (!$user) {
                return $this->response($trace_id, 'SC_USER_NOT_EXISTS', 'User does not exists');
            }

            // 检查是否已处理过（幂等性）
            // TODO: 实现交易记录表，检查transactionId是否已处理

            // 开始数据库事务
            DB::beginTransaction();
            
            try {
                $user_balance = $user->balance ?? 0;
                
                // 调整金额（amount可以是正数或负数）
                $user_balance += $amount;

                // 更新余额
                $user->balance = $user_balance;
                $user->save();

                // TODO: 保存调整记录到数据库

                DB::commit();

                Log::info('OneAPI sports_adjustment处理成功', [
                    'traceId' => $trace_id,
                    'username' => $username,
                    'transactionId' => $transaction_id,
                    'amount' => $amount,
                    'newBalance' => $user_balance
                ]);

                // 返回结果
                return $this->response($trace_id, 'SC_OK', 'success', [
                    'username' => $username,
                    'currency' => $currency,
                    'balance' => (float) $user_balance,
                    'timestamp' => (int) (now()->timestamp * 1000)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('OneAPI sports_adjustment异常', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            $trace_id = $request->input('traceId', '');
            return $this->response($trace_id, 'SC_UNKNOWN_ERROR', 'Server Error: ' . $e->getMessage());
        }
    }
}
