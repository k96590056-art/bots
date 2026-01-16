<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\User_Api;
use App\Models\User;
use App\Models\GameRecord;
use Illuminate\Http\Request;

/**
 * DbevoService Evolution Gaming 游戏接口处理类
 * 参考文档：evo.md
 * 
 * 注意：此类包含两部分功能：
 * 1. 主动调用API（用户认证、进入游戏、查询数据等）
 * 2. 处理 Evolution 平台发起的回调请求（One Wallet API）
 */
class DbevoService
{
    // API 配置参数（写死）
    /**
     * 只保留 3 个“请求地址”基地址：
     * - hostname：用户认证/玩家相关 & eCashier（参考 evo.md：/ua/v1、/api/ecashier 等）
     * - game_url：玩家最终跳转的游戏地址（用来拼接 entry / entryEmbedded）
     * - game_history_url：游戏历史 API 基地址（参考 evo.md：/api/gamehistory/v1）
     */
    protected $hostname;  // User Authentication / eCashier 基地址
    protected $game_url;  // 游戏启动基地址（拼接 entry / entryEmbedded）
    protected $casino_key;  // Casino key for User Authentication
    protected $api_token;  // API token for User Authentication
    protected $game_history_url;  // Game History API base URL（/api/gamehistory/v1）
    protected $game_history_password;  // Game History API password (api.token)
    protected $currency = 'CNY';  // 默认币种
    protected $country = 'CN';  // 默认国家编码
    protected $language = 'zh';  // 默认语言编码（ISO 639-1, 2 letter code）

    public function __construct()
    {
        // 配置参数（写死，不再从数据库读取）
        $this->hostname = 'https://staging-api.asia-live.com';  // 参考 evo.md 的 {hostname}
        $this->game_url = 'https://site-stag-api.nimstad99.com/api/lobby/v1';  // 默认与 hostname 相同（如实际环境不同可拆分）
        $this->casino_key = '53qaoodxfmgluzvs';  // Casino key
        $this->api_token = '9f0e65ca50d76072cfceb460742caba2';  // API token
        $this->game_history_url = 'https://stage-admin.asia-live.com/api/gamehistory/v1';  // Game History API base
        $this->game_history_password = '9f0e65ca50d76072cfceb460742caba2';  // Game History API token
    }

    /**
     * 拼接 URL：base + path + query（统一处理 rtrim/ltrim）
     */
    private function buildUrl($base, $path = '', $query = [])
    {
        $base = rtrim((string)$base, '/');
        $path = (string)$path;
        $path = $path === '' ? '' : '/' . ltrim($path, '/');
        $url = $base . $path;

        if (is_array($query) && !empty($query)) {
            // 过滤空值，避免生成无意义参数
            $query = array_filter($query, function ($v) {
                return $v !== null && $v !== '';
            });
            if (!empty($query)) {
                $url .= '?' . http_build_query($query);
            }
        }

        return $url;
    }

    /**
     * 用于 entry / entryEmbedded（entry 自带 query，不做 urlencode）
     */
    private function joinBase($base, $suffix)
    {
        return rtrim((string)$base, '/') . '/' . ltrim((string)$suffix, '/');
    }

    /**
     * 发送 HTTP POST 请求（JSON格式）
     *
     * @param string $url 请求地址
     * @param array $post_data 请求参数
     * @param array $headers 额外的请求头
     * @return array
     */
    private function sendRequest($url, $post_data = [], $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        
        $requestHeaders = array_merge([
            'Content-Type: application/json',
            'Accept: application/json'
        ], $headers);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        $contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Log::error('Evo接口请求失败', [
                'url' => $url,
                'error' => $error,
                'http_code' => $httpCode
            ]);
            return [
                'code' => 201,
                'message' => 'Server Error: ' . $error
            ];
        }

        $result = json_decode($contents, TRUE);
        
        if (!$result || !is_array($result)) {
            Log::error('Evo接口返回数据解析失败', [
                'url' => $url,
                'http_code' => $httpCode,
                'response' => $contents
            ]);
            return [
                'code' => 201,
                'message' => '返回数据解析失败'
            ];
        }

        // 检查是否有错误
        if (isset($result['errors']) && is_array($result['errors']) && !empty($result['errors'])) {
            $errorMsg = $result['errors'][0]['message'] ?? $result['errors'][0]['code'] ?? '请求失败';
            Log::error('Evo接口返回错误', [
                'url' => $url,
                'result'=>$result,
                'errors' => $result['errors']
            ]);
            return [
                'code' => 201,
                'message' => $errorMsg,
                'errors' => $result['errors']
            ];
        }

        return $result;
    }

    /**
     * 发送 HTTP GET 请求
     *
     * @param string $url 请求地址
     * @param array $headers 额外的请求头
     * @return array|string
     */
    private function sendGetRequest($url, $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        $contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Log::error('Evo GET请求失败', [
                'url' => $url,
                'error' => $error,
                'http_code' => $httpCode
            ]);
            return [
                'code' => 201,
                'message' => 'Server Error: ' . $error
            ];
        }

        // 尝试解析为JSON
        $result = json_decode($contents, TRUE);
        if ($result !== null && is_array($result)) {
            return $result;
        }

        // 如果不是JSON，尝试解析为XML（eCashier API）
        if (strpos($contents, '<?xml') === 0 || strpos($contents, '<') === 0) {
            return $this->parseXmlResponse($contents);
        }

        return $contents;
    }

    /**
     * 解析XML响应（用于eCashier API）
     *
     * @param string $xml XML字符串
     * @return array
     */
    private function parseXmlResponse($xml)
    {
        try {
            $xmlObj = simplexml_load_string($xml);
            if ($xmlObj === false) {
                return [
                    'code' => 201,
                    'message' => 'XML解析失败'
                ];
            }

            $result = json_decode(json_encode($xmlObj), true);
            
            // 检查result字段
            if (isset($result['result']) && $result['result'] === 'N') {
                return [
                    'code' => 201,
                    'message' => $result['errormsg'] ?? '操作失败',
                    'data' => $result
                ];
            }

            return [
                'code' => 200,
                'message' => '成功',
                'data' => $result
            ];
        } catch (\Exception $e) {
            Log::error('Evo XML解析失败', [
                'error' => $e->getMessage(),
                'xml' => substr($xml, 0, 500)
            ]);
            return [
                'code' => 201,
                'message' => 'XML解析失败: ' . $e->getMessage()
            ];
        }
    }

    /**
     * 注册玩家
     * 参考 IndexController 中的调用方式：$service->register($api_code, $username)
     * 
     * 使用 User Authentication API 创建玩家（player.update=true）
     * 
     * @param string $api_code 平台代码（第一个参数）
     * @param string $username 玩家用户名（第二个参数）
     * @param string $password 玩家密码（可选，默认123456）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息']
     */
    public function register($api_code, $username, $password = '123456')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 获取用户信息
        $user = User::where('username', $username)->first();
        if (!$user) {
            $return['code'] = 201;
            $return['message'] = '用户不存在';
            return $return;
        }

        // 生成UUID
        $uuid = 'req_' . time() . '_' . rand(1000, 9999);
        
        // 生成session ID
        $session_id = 'session_' . time() . '_' . rand(10000, 99999);

        // 构建User Authentication请求
        $requestData = [
            'uuid' => $uuid,
            'player' => [
                'id' => $username,
                'update' => true,  // 创建或更新玩家
                'firstName' => $user->first_name ?? 'Player',
                'lastName' => $user->last_name ?? 'User',
                'country' => $this->country,
                'nickname' => $user->nickname ?? $username,
                'language' => $this->language,
                'currency' => $this->currency,
                'session' => [
                    'id' => $session_id,
                    'ip' => request()->ip() ?? '127.0.0.1'
                ]
            ],
            'config' => [
                'channel' => [
                    'wrapped' => false,
                    'mobile' => false
                ]
            ]
        ];

        $url = $this->buildUrl($this->hostname, '/ua/v1/' . $this->casino_key . '/' . $this->api_token);
        $res = $this->sendRequest($url, $requestData);

        // User Authentication API 成功时返回 entry 和 entryEmbedded
        if (isset($res['entry']) || isset($res['entryEmbedded'])) {
            Log::info('Evo注册成功', [
                'username' => $username,
                'uuid' => $uuid
            ]);
            return $return;
        }

        // 检查错误
        if (isset($res['errors']) || isset($res['code'])) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? ($res['errors'][0]['message'] ?? '注册失败');
            Log::error('Evo注册失败', [
                'username' => $username,
                'response' => $res
            ]);
            return $return;
        }

        // 如果使用eCashier方式创建用户（备选方案）
        // 通过ECR请求创建用户（createuser=Y）
        $ecrUrl = $this->buildUrl($this->hostname, '/api/ecashier', [
            'cCode' => 'ECR',
            'ecID' => $this->casino_key,
            'euID' => $username,
            'amount' => 0,
            'eTransID' => $uuid,
            'createuser' => 'Y',
            'currency' => $this->currency,
            'output' => 1,
        ]);
        
        $ecrRes = $this->sendGetRequest($ecrUrl);
        
        if (isset($ecrRes['code']) && $ecrRes['code'] == 200) {
            Log::info('Evo注册成功（eCashier方式）', [
                'username' => $username
            ]);
            return $return;
        }

        $return['code'] = 201;
        $return['message'] = '注册失败';
        return $return;
    }

    /**
     * 登录获取游戏URL
     * 参考 IndexController 中的调用方式：$service->login($user->username, $api_code, $leixing, $is_mobile_url, $gameCode)
     * 
     * 使用 User Authentication API 获取游戏URL
     * 
     * @param string $username 玩家用户名（第一个参数）
     * @param string $api_code 平台代码（第二个参数）
     * @param string $game_type 游戏类型（第三个参数，可选）
     * @param int $is_mobile 是否手机端（第四个参数，0=PC，1=手机）
     * @param string $game_code 游戏代码/桌台ID（第五个参数，可选）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息', 'data' => '游戏URL']
     */
    public function login($username, $api_code = '', $is_mobile = 1, $game_code = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 获取用户信息
        $user = User::where('username', $username)->first();
        if (!$user) {
            $return['code'] = 201;
            $return['message'] = '用户不存在';
            return $return;
        }

        // 生成UUID
        $uuid = 'req_' . time() . '_' . rand(1000, 9999);
        
        // 生成session ID
        $session_id = 'session_' . time() . '_' . rand(10000, 99999);

        // 构建User Authentication请求
        $requestData = [
            'uuid' => $uuid,
            'player' => [
                'id' => $username,
                'update' => true,
                'firstName' => $user->first_name ?? 'Player',
                'lastName' => $user->last_name ?? 'User',
                'country' => $this->country,
                'nickname' => $user->nickname ?? $username,
                'language' => $this->language,
                'currency' => $this->currency,
                'session' => [
                    'id' => $session_id,
                    'ip' => request()->ip() ?? '127.0.0.1'
                ]
            ],
            'config' => [
                'channel' => [
                    'wrapped' => false,
                    'mobile' => ($is_mobile == 1)
                ]
            ]
        ];

        // 如果指定了游戏代码/桌台ID，添加直接游戏启动配置
        if (!empty($game_code)) {
            // 根据game_code判断游戏类型
            $gameCategory = $this->getGameCategory($game_code);
            $requestData['config']['game'] = [
                'table' => [
                    'id' => $game_code
                ]
            ];
            
            // 如果指定了游戏类型，可以添加category
            if (!empty($game_type) && $game_type != '1') {
                $requestData['config']['game']['category'] = $gameCategory;
            }
        }

        $url = $this->buildUrl($this->hostname, '/ua/v1/' . $this->casino_key . '/' . $this->api_token);
        $res = $this->sendRequest($url, $requestData);

        // User Authentication API 成功时返回 entry 和 entryEmbedded
        if (isset($res['entry']) || isset($res['entryEmbedded'])) {
            // 构建完整的游戏URL
            $entry = $res['entryEmbedded'] ?? $res['entry'];
            $gameUrl = $entry;
            
            $return['data'] = $gameUrl;
            $return['session_id'] = $session_id;
            
            Log::info('Evo登录成功', [
                'username' => $username,
                'game_code' => $game_code,
                'game_url' => $gameUrl
            ]);
            
            return $return;
        }

        // 检查错误
        if (isset($res['errors']) || isset($res['code'])) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? ($res['errors'][0]['message'] ?? '登录失败');
            Log::error('Evo登录失败', [
                'username' => $username,
                'response' => $res
            ]);
            return $return;
        }

        $return['code'] = 201;
        $return['message'] = '登录失败：未返回游戏URL';
        return $return;
    }

    /**
     * 根据游戏代码获取游戏类别
     *
     * @param string $game_code 游戏代码
     * @return string
     */
    private function getGameCategory($game_code)
    {
        // 根据游戏代码判断游戏类别
        // 这里可以根据实际游戏代码映射关系调整
        $gameCodeMap = [
            'roulette' => 'roulette',
            'blackjack' => 'blackjack',
            'baccarat' => 'baccarat_sicbo',
            'poker' => 'poker',
            'slots' => 'slots',
        ];

        foreach ($gameCodeMap as $key => $category) {
            if (stripos($game_code, $key) !== false) {
                return $category;
            }
        }

        return 'top_games';  // 默认返回top_games
    }

    /**
     * 查询玩家余额
     * 参考调用方式：$service->balance($api_code, $user->username)
     * 
     * 优先使用 One Wallet API，如果未配置则使用 eCashier API
     * 
     * @param string $api_code 平台代码（第一个参数）
     * @param string $username 玩家用户名（第二个参数）
     * @param string $password 玩家密码（可选，默认123456，用于兼容）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息', 'data' => 余额]
     */
    public function balance($api_code, $username, $password = '123456')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 注意：One Wallet 是 EVO 回调到我方，不需要我方主动调用。
        // 这里统一使用 eCashier API 查询余额 (RWA - Retrieve Withdrawal Available)
        if (!empty($this->hostname) && !empty($this->casino_key)) {
            $rwaUrl = $this->buildUrl($this->hostname, '/api/ecashier', [
                'cCode' => 'RWA',
                'ecID' => $this->casino_key,
                'euID' => $username,
                'output' => 1,
            ]);
            
            $res = $this->sendGetRequest($rwaUrl);
            
            if (isset($res['code']) && $res['code'] == 200 && isset($res['data'])) {
                $data = $res['data'];
                $balance = $data['abalance'] ?? $data['tbalance'] ?? 0;
                $return['data'] = round((float)$balance, 2);
                return $return;
            }
        }

        // 如果都失败，从数据库获取
        $userApi = User_Api::where('api_user', $username)
            ->where('api_code', 'evo')
            ->first();

        if ($userApi) {
            $return['data'] = round($userApi->api_money ?? 0, 2);
            return $return;
        }

        $return['code'] = 201;
        $return['message'] = '查询余额失败';
        $return['data'] = 0;
        return $return;
    }

    /**
     * 玩家上分（转入游戏）
     * 参考 PayController 中的 deposit 调用方式：$service->deposit($user->username, $amount, $order_no, $api_code)
     * 
     * 优先使用 One Wallet API，如果未配置则使用 eCashier API
     * 
     * @param string $username 玩家用户名（第一个参数）
     * @param float $amount 上分金额（第二个参数）
     * @param string $ext_trans_id 外部交易号（订单号，第三个参数）
     * @param string $api_code 平台代码（第四个参数）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息']
     */
    public function deposit($username, $amount, $ext_trans_id, $api_code = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 金额格式处理，保留2位小数
        $amount = round((float)$amount, 2);
        
        if ($amount <= 0) {
            $return['code'] = 201;
            $return['message'] = '上分金额必须大于0';
            return $return;
        }

        // 使用 eCashier API (ECR - External Credit Request)
        if (!empty($this->hostname) && !empty($this->casino_key)) {
            $ecrUrl = $this->buildUrl($this->hostname, '/api/ecashier', [
                'cCode' => 'ECR',
                'ecID' => $this->casino_key,
                'euID' => $username,
                'amount' => $amount,
                'eTransID' => $ext_trans_id,
                'currency' => $this->currency,
                'output' => 1,
            ]);
            
            $res = $this->sendGetRequest($ecrUrl);
            
            if (isset($res['code']) && $res['code'] == 200 && isset($res['data'])) {
                $data = $res['data'];
                $balance = $data['balance'] ?? 0;
                $transId = $data['transid'] ?? '';
                
                $return['data'] = [
                    'transId' => $transId,
                    'extTransId' => $ext_trans_id,
                    'status' => 'approved',
                    'balance' => round((float)$balance, 2),
                ];
                
                Log::info('Evo上分成功（eCashier）', [
                    'username' => $username,
                    'amount' => $amount,
                    'ext_trans_id' => $ext_trans_id
                ]);
                
                return $return;
            }
        }

        $return['code'] = 201;
        $return['message'] = '上分失败';
        Log::error('Evo上分失败', [
            'username' => $username,
            'amount' => $amount,
            'ext_trans_id' => $ext_trans_id
        ]);
        
        return $return;
    }

    /**
     * 玩家下分（转出游戏）
     * 参考 PayController 中的 withdrawal 调用方式：$service->withdrawal($user->username, $amount, $order_no, $api_code)
     * 
     * 优先使用 One Wallet API，如果未配置则使用 eCashier API
     * 
     * @param string $username 玩家用户名（第一个参数）
     * @param float $amount 下分金额（第二个参数）
     * @param string $ext_trans_id 外部交易号（订单号，第三个参数）
     * @param string $api_code 平台代码（第四个参数）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息']
     */
    public function withdrawal($username, $amount, $ext_trans_id, $api_code = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 金额格式处理，保留2位小数
        $amount = round((float)$amount, 2);
        
        if ($amount <= 0) {
            $return['code'] = 201;
            $return['message'] = '下分金额必须大于0';
            return $return;
        }

        // 使用 eCashier API (EDB - External Debit Request)
        if (!empty($this->hostname) && !empty($this->casino_key)) {
            $edbUrl = $this->buildUrl($this->hostname, '/api/ecashier', [
                'cCode' => 'EDB',
                'ecID' => $this->casino_key,
                'euID' => $username,
                'amount' => $amount,
                'eTransID' => $ext_trans_id,
                'output' => 1,
            ]);
            
            $res = $this->sendGetRequest($edbUrl);
            
            if (isset($res['code']) && $res['code'] == 200 && isset($res['data'])) {
                $data = $res['data'];
                $balance = $data['balance'] ?? 0;
                $transId = $data['transid'] ?? '';
                
                $return['data'] = [
                    'transId' => $transId,
                    'extTransId' => $ext_trans_id,
                    'status' => 'approved',
                    'balance' => round((float)$balance, 2),
                    'amount' => $amount,
                ];
                
                Log::info('Evo下分成功（eCashier）', [
                    'username' => $username,
                    'amount' => $amount,
                    'ext_trans_id' => $ext_trans_id
                ]);
                
                return $return;
            }
        }

        $return['code'] = 201;
        $return['message'] = '下分失败';
        Log::error('Evo下分失败', [
            'username' => $username,
            'amount' => $amount,
            'ext_trans_id' => $ext_trans_id
        ]);
        
        return $return;
    }

    /**
     * 查询交易信息
     * 
     * @param string $ext_trans_id 外部交易号
     * @return array
     */
    public function checkTrans($ext_trans_id)
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 使用 eCashier API (TRI - Retrieve Transaction info)
        if (!empty($this->hostname) && !empty($this->casino_key)) {
            $triUrl = $this->buildUrl($this->hostname, '/api/ecashier', [
                'cCode' => 'TRI',
                'ecID' => $this->casino_key,
                'eTransID' => $ext_trans_id,
                'output' => 1,
            ]);
            
            $res = $this->sendGetRequest($triUrl);
            
            if (isset($res['code']) && $res['code'] == 200 && isset($res['data'])) {
                $data = $res['data'];
                $return['data'] = [
                    'extTransId' => $ext_trans_id,
                    'transId' => $data['transid'] ?? '',
                    'status' => ($data['result'] ?? 'N') === 'Y' ? 'approved' : 'pending',
                    'amount' => $data['amount'] ?? 0,
                    'balance' => $data['balance'] ?? 0,
                    'cCode' => $data['cCode'] ?? '',
                ];
                return $return;
            }
        }

        $return['code'] = 201;
        $return['message'] = '查询交易失败';
        return $return;
    }

    /**
     * 拉取游戏记录（游戏报表）
     * 使用 Game History API
     * 
     * @param string $start_time 开始时间，格式：YYYY-MM-DD HH:mm:00
     * @param string $end_time 结束时间，格式：YYYY-MM-DD HH:mm:00
     * @param string $player_id 玩家ID（可选）
     * @param string $currency 币种（可选）
     * @param string $game_code 游戏代码（可选）
     * @return array
     */
    public function getGameReport($start_time, $end_time, $player_id = '', $currency = '', $game_code = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => []
        ];

        // 转换时间格式：YYYY-MM-DD HH:mm:00 -> YYYY-MM-DDTHH:mm:ss.SSSZ (UTC)
        $startDate = $this->convertToUtcIso($start_time);
        $endDate = $this->convertToUtcIso($end_time);

        $url = $this->buildUrl($this->game_history_url, '/casino/games', [
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        // 使用HTTP Basic认证
        $auth = base64_encode($this->casino_key . ':' . $this->game_history_password);
        $headers = [
            'Authorization: Basic ' . $auth
        ];

        $res = $this->sendGetRequest($url, $headers);

        if (isset($res['data']) && is_array($res['data'])) {
            $games = [];
            foreach ($res['data'] as $dateData) {
                if (isset($dateData['games']) && is_array($dateData['games'])) {
                    foreach ($dateData['games'] as $game) {
                        // 如果指定了玩家ID，过滤
                        if (!empty($player_id)) {
                            $hasPlayer = false;
                            if (isset($game['participants']) && is_array($game['participants'])) {
                                foreach ($game['participants'] as $participant) {
                                    if (isset($participant['playerId']) && $participant['playerId'] === $player_id) {
                                        $hasPlayer = true;
                                        break;
                                    }
                                }
                            }
                            if (!$hasPlayer) {
                                continue;
                            }
                        }

                        $games[] = $game;
                    }
                }
            }
            
            $return['data'] = $games;
            return $return;
        }

        $return['code'] = 201;
        $return['message'] = '拉取游戏记录失败';
        Log::error('Evo拉取游戏记录失败', [
            'start_time' => $start_time,
            'end_time' => $end_time,
            'response' => $res
        ]);
        
        return $return;
    }

    /**
     * 获取游戏历史记录（单个注单）
     * 使用 Game History API
     * 
     * @param string $start_time 开始时间，格式：YYYY-MM-DD HH:mm:00
     * @param string $end_time 结束时间，格式：YYYY-MM-DD HH:mm:00
     * @param string $player_id 玩家ID（可选）
     * @param string $game_code 游戏代码（可选）
     * @param int $page 页码（可选，默认1）
     * @param int $limit 每页数量（可选，默认100）
     * @return array
     */
    public function getGameHistory($start_time, $end_time, $player_id = '', $game_code = '', $page = 1, $limit = 100)
    {
        // Game History API 不支持分页，需要手动处理
        $result = $this->getGameReport($start_time, $end_time, $player_id, '', $game_code);
        
        if ($result['code'] != 200) {
            return $result;
        }

        $allGames = $result['data'] ?? [];
        
        // 手动分页
        $total = count($allGames);
        $offset = ($page - 1) * $limit;
        $pagedGames = array_slice($allGames, $offset, $limit);

        // 展开participants，每个participant的bet作为一条记录
        $records = [];
        foreach ($pagedGames as $game) {
            if (isset($game['participants']) && is_array($game['participants'])) {
                foreach ($game['participants'] as $participant) {
                    if (!empty($player_id) && ($participant['playerId'] ?? '') !== $player_id) {
                        continue;
                    }

                    if (isset($participant['bets']) && is_array($participant['bets'])) {
                        foreach ($participant['bets'] as $bet) {
                            $records[] = [
                                'gameId' => $game['id'] ?? '',
                                'playerId' => $participant['playerId'] ?? '',
                                'betId' => $bet['transactionId'] ?? '',
                                'betAmount' => $bet['stake'] ?? 0,
                                'winAmount' => $bet['payout'] ?? 0,
                                'winLoss' => ($bet['payout'] ?? 0) - ($bet['stake'] ?? 0),
                                'betTime' => $bet['placedOn'] ?? $game['startedAt'] ?? '',
                                'gameType' => $game['gameType'] ?? '',
                                'tableId' => $game['table']['id'] ?? '',
                                'status' => $game['status'] ?? 'Resolved',
                            ];
                        }
                    }
                }
            }
        }

        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => $records,
            'total' => count($records),
            'page' => $page,
            'limit' => $limit,
        ];

        return $return;
    }

    /**
     * 转换时间格式为UTC ISO格式
     *
     * @param string $time 时间字符串，格式：YYYY-MM-DD HH:mm:00
     * @return string UTC ISO格式：YYYY-MM-DDTHH:mm:ss.SSSZ
     */
    private function convertToUtcIso($time)
    {
        // 将时间字符串转换为UTC时间戳
        $timestamp = strtotime($time . ' UTC');
        if ($timestamp === false) {
            // 如果转换失败，使用当前时间
            $timestamp = time();
        }
        
        // 转换为ISO 8601格式
        return gmdate('Y-m-d\TH:i:s.000\Z', $timestamp);
    }

    /**
     * 处理 One Wallet API 回调
     * 处理 check, balance, debit, credit, cancel 回调
     * 
     * @param string $method 方法名（check, balance, debit, credit, cancel）
     * @param array $requestData 请求数据
     * @return array
     */
    public function handleOneWalletCallback($method, $requestData)
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 验证authToken
        $authToken = request()->input('authToken', '');
        if ($authToken !== $this->api_token) {
            $return['code'] = 201;
            $return['message'] = 'Invalid authToken';
            return $return;
        }

        $userId = $requestData['userId'] ?? '';
        $sid = $requestData['sid'] ?? '';
        $currency = $requestData['currency'] ?? $this->currency;

        // 查找用户
        $userApi = User_Api::where('api_user', $userId)
            ->where('api_code', 'evo')
            ->first();

        if (!$userApi) {
            $return['code'] = 201;
            $return['message'] = 'User not found';
            $return['status'] = 'INVALID_TOKEN_ID';
            return $return;
        }

        switch ($method) {
            case 'check':
                // CheckUserRequest - 验证用户和session
                $return['status'] = 'OK';
                $return['sid'] = $sid;
                $return['uuid'] = $requestData['uuid'] ?? '';
                break;

            case 'balance':
                // BalanceRequest - 查询余额
                $balance = $userApi->api_money ?? 0;
                $return['status'] = 'OK';
                $return['balance'] = round($balance, 2);
                $return['uuid'] = $requestData['uuid'] ?? '';
                break;

            case 'debit':
                // DebitRequest - 下注（扣款）
                $amount = (float)($requestData['transaction']['amount'] ?? 0);
                $transId = $requestData['transaction']['id'] ?? '';
                
                if ($userApi->api_money < $amount) {
                    $return['code'] = 201;
                    $return['status'] = 'INSUFFICIENT_FUNDS';
                    $return['message'] = '余额不足';
                    return $return;
                }

                $userApi->api_money -= $amount;
                $userApi->save();

                $return['status'] = 'OK';
                $return['balance'] = round($userApi->api_money, 2);
                $return['uuid'] = $requestData['uuid'] ?? '';
                
                Log::info('Evo One Wallet Debit成功', [
                    'userId' => $userId,
                    'amount' => $amount,
                    'transId' => $transId
                ]);
                break;

            case 'credit':
                // CreditRequest - 结算（加款）
                $amount = (float)($requestData['transaction']['amount'] ?? 0);
                $transId = $requestData['transaction']['id'] ?? '';
                
                $userApi->api_money += $amount;
                $userApi->save();

                $return['status'] = 'OK';
                $return['balance'] = round($userApi->api_money, 2);
                $return['uuid'] = $requestData['uuid'] ?? '';
                
                Log::info('Evo One Wallet Credit成功', [
                    'userId' => $userId,
                    'amount' => $amount,
                    'transId' => $transId
                ]);
                break;

            case 'cancel':
                // CancelRequest - 取消下注（退款）
                $transId = $requestData['transaction']['id'] ?? '';
                $amount = (float)($requestData['transaction']['amount'] ?? 0);
                
                // 查找对应的debit记录并退款
                // 这里简化处理，直接加回金额
                $userApi->api_money += $amount;
                $userApi->save();

                $return['status'] = 'OK';
                $return['balance'] = round($userApi->api_money, 2);
                $return['uuid'] = $requestData['uuid'] ?? '';
                
                Log::info('Evo One Wallet Cancel成功', [
                    'userId' => $userId,
                    'amount' => $amount,
                    'transId' => $transId
                ]);
                break;

            default:
                $return['code'] = 201;
                $return['status'] = 'UNKNOWN_ERROR';
                $return['message'] = 'Unknown method';
                break;
        }

        return $return;
    }
}
