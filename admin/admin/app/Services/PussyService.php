<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\SystemConfig;
use App\Models\User;
use App\Models\User_Api;

/**
 * Pussy888游戏接口类
 * 参考TgService的结构和规范
 */
class PussyService
{
    protected $api_account; // authcode 授权码
    protected $sign_key; // secretKey 密钥
    protected $api_url;
    protected $agent; // 代理账号

    public function __construct()
    {
        // 从系统配置获取Pussy接口相关配置
        $this->api_url = SystemConfig::getValue('pussy_api_url') ?? env('PUSSY_API_URL', 'http://api.pussy888.com/');
        $this->api_account = SystemConfig::getValue('pussy_api_account') ?? env('PUSSY_API_ACCOUNT');
        $this->sign_key = SystemConfig::getValue('pussy_api_secret') ?? env('PUSSY_API_SECRET');
        $this->agent = SystemConfig::getValue('pussy_agent') ?? env('PUSSY_AGENT', 'Demo');
    }

    /**
     * 生成签名
     * sign=md5((authcode +userName+time+secretKey).tolower)
     * 
     * @param string $userName 用户名
     * @param int $time 时间戳（13位毫秒）
     * @return string MD5签名（小写）
     */
    private function generateSign($userName, $time)
    {
        $signStr = $this->api_account . $userName . $time . $this->sign_key;
        return md5(strtolower($signStr));
    }

    /**
     * 生成订单签名（用于查询订单）
     * sign=md5((authcode +orderid+time+secretKey).tolower)
     * 
     * @param string $orderId 订单ID
     * @param int $time 时间戳（13位毫秒）
     * @return string MD5签名（小写）
     */
    private function generateOrderSign($orderId, $time)
    {
        $signStr = $this->api_account . $orderId . $time . $this->sign_key;
        return md5(strtolower($signStr));
    }

    /**
     * 生成获取随机用户名的签名
     * sign=md5((api_account + agent + time + sign_key).tolower).toupper
     * 
     * @param int $time 时间戳（13位毫秒）
     * @param string $agent 代理账号（可选，默认使用配置的代理）
     * @return string MD5签名（大写）
     */
    private function generateRandomUserNameSign($time, $agent = '')
    {
        $agent = $agent ?: $this->agent;
        $signStr = $this->api_account . $agent . $time . $this->sign_key;
        return strtoupper(md5(strtolower($signStr)));
    }

    /**
     * 获取13位时间戳（毫秒）
     * 
     * @return int
     */
    private function getTimeStamp()
    {
        return (int)(microtime(true) * 1000);
    }

    /**
     * 发送HTTP GET请求
     *
     * @param string $url
     * @param array $params
     * @return array
     */
    private function sendRequest($url, $params = [])
    {
        // 构建完整URL
        $queryString = http_build_query($params);
        $fullUrl = $url . '?' . $queryString;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            Log::error('Pussy接口请求CURL错误', [
                'url' => $fullUrl,
                'curl_error' => $curlError
            ]);
            return [
                'success' => false,
                'code' => -1,
                'msg' => '请求失败：' . $curlError
            ];
        }

        $result = json_decode($contents, TRUE);
        
        if (!$result || !is_array($result)) {
            Log::error('Pussy接口请求失败 - JSON解析失败', [
                'url' => $fullUrl,
                'http_code' => $httpCode,
                'response' => $contents
            ]);
            return [
                'success' => false,
                'code' => -1,
                'msg' => '返回数据解析失败'
            ];
        }

        return $result;
    }

    /**
     * 获取随机用户名
     * apiURL/ashx/account/account.ashx?action=RandomUserName
     *
     * @param string $userNamePrefix 用户名前缀（可选，默认c111111）
     * @param string $userAreaId 用户区域ID（可选，默认空）
     * @return array
     */
    public function getRandomUserName($userNamePrefix = 'c111111', $userAreaId = '')
    {
        Log::info('Pussy获取随机用户名 - 开始调用', [
            'userNamePrefix' => $userNamePrefix,
            'userAreaId' => $userAreaId,
            'api_url' => $this->api_url,
            'api_account' => $this->api_account
        ]);

        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 检查API URL是否配置
        if (empty($this->api_url) || empty($this->api_account) || empty($this->sign_key)) {
            $return['code'] = 400;
            $return['message'] = 'Pussy API配置不完整';
            Log::error('Pussy API配置不完整', [
                'api_url' => $this->api_url,
                'api_account' => $this->api_account
            ]);
            return $return;
        }

        $time = $this->getTimeStamp();

        // 构建请求参数
        // 注意：获取随机用户名使用单独的签名方式：api_account + agent + time + sign_key
        $params = [
            'action' => 'RandomUserName',
            'userName' => $userNamePrefix,
            'UserAreaId' => $userAreaId,
            'time' => $time,
            'authcode' => $this->api_account,
            'sign' => $this->generateRandomUserNameSign($time)
        ];

        $apiUrl = rtrim($this->api_url, '/') . '/ashx/account/account.ashx';
        Log::info('Pussy获取随机用户名 - 请求参数', [
            'userNamePrefix' => $userNamePrefix,
            'params' => $params,
            'api_url' => $apiUrl
        ]);

        $res = $this->sendRequest($apiUrl, $params);

        Log::info('Pussy获取随机用户名 - 接口返回', [
            'userNamePrefix' => $userNamePrefix,
            'response' => $res
        ]);

        // 检查响应结果
        // 返回格式：{"account":"my869556103","code":0,"msg":"","success":true}
        if (!isset($res['success']) || !$res['success'] || (isset($res['code']) && $res['code'] != 0)) {
            $return['code'] = 201;
            $return['message'] = $res['msg'] ?? '获取随机用户名失败';
            Log::error('Pussy获取随机用户名失败', [
                'userNamePrefix' => $userNamePrefix,
                'response' => $res
            ]);
            return $return;
        }

        // 从返回结果中提取用户名（从account字段获取）
        // 返回格式：{"account":"my869556103","code":0,"msg":"","success":true}
        $randomUserName = '';
        if (isset($res['account']) && !empty($res['account'])) {
            $randomUserName = $res['account'];
        }

        if (empty($randomUserName)) {
            $return['code'] = 201;
            $return['message'] = '未能从接口返回中获取到用户名（account字段为空）';
            Log::error('Pussy获取随机用户名失败 - 返回数据中无account字段或account为空', [
                'userNamePrefix' => $userNamePrefix,
                'response' => $res
            ]);
            return $return;
        }

        Log::info('Pussy获取随机用户名成功', [
            'userNamePrefix' => $userNamePrefix,
            'randomUserName' => $randomUserName,
            'response' => $res
        ]);

        $return['data'] = $randomUserName;
        return $return;
    }

    /**
     * 注册用户到Pussy游戏平台
     * apiURL/ashx/account/account.ashx?action=addUser
     * 
     * 流程说明：
     * 1. 本系统用户已注册完成（User对象已存在）
     * 2. 通过RandomUserName接口生成随机用户名
     * 3. 将生成的随机用户名和明文密码等信息存入user_api表
     * 4. 使用生成的随机用户名调用Pussy注册接口进行注册
     *
     * @param string $password 密码（必填，默认123456）
     * @param string $agent 代理账号（可选，默认使用配置的代理）
     * @param string $name 用户昵称（可选，默认N/A）
     * @param string $tel 电话（可选，默认N/A）
     * @param string $memo 备注（可选，默认N/A）
     * @param int $userType 用户类型（1=正式玩家，100=代理，默认1）
     * @param string $userNamePrefix 获取随机用户名时的前缀（可选，默认c111111）
     * @param User|null $user User对象（必填，本系统已注册的用户）
     * @param string $platformName 游戏平台名称（用于user_api表的api_code字段，默认'pussy'）
     * @return array
     */
    public function register($password = '123456', $agent = '', $name = 'N/A', $tel = 'N/A', $memo = 'N/A', $userType = 1, $userNamePrefix = 'c111111', $user = null, $platformName = 'pussy')
    {
        Log::info('Pussy注册 - 开始调用', [
            'api_url' => $this->api_url,
            'api_account' => $this->api_account
        ]);

        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 检查API URL是否配置
        if (empty($this->api_url) || empty($this->api_account) || empty($this->sign_key)) {
            $return['code'] = 400;
            $return['message'] = 'Pussy API配置不完整';
            Log::error('Pussy API配置不完整', [
                'api_url' => $this->api_url,
                'api_account' => $this->api_account
            ]);
            return $return;
        }

        // 检查User对象是否提供（本系统用户必须已注册）
        if (!$user instanceof User) {
            $return['code'] = 400;
            $return['message'] = 'User对象不能为空，请先在本系统注册用户';
            Log::error('Pussy注册失败 - User对象为空');
            return $return;
        }

        // 步骤1：通过RandomUserName接口生成随机用户名
        Log::info('Pussy注册 - 开始获取随机用户名', [
            'userNamePrefix' => $userNamePrefix,
            'user_id' => $user->id
        ]);
        
        $randomUserNameResult = $this->getRandomUserName($userNamePrefix);
        
        if ($randomUserNameResult['code'] != 200 || empty($randomUserNameResult['data'])) {
            $return['code'] = 201;
            $return['message'] = $randomUserNameResult['message'] ?? '获取随机用户名失败';
            Log::error('Pussy注册 - 获取随机用户名失败', [
                'result' => $randomUserNameResult,
                'user_id' => $user->id
            ]);
            return $return;
        }
        
        $randomUserName = $randomUserNameResult['data'];
        Log::info('Pussy注册 - 成功获取随机用户名', [
            'randomUserName' => $randomUserName,
            'user_id' => $user->id
        ]);

        // 步骤2：将生成的随机用户名和明文密码等信息存入user_api表
        try {
            // 检查是否已存在记录
            $existingUserApi = User_Api::where('user_id', $user->id)
                ->where('api_code', $platformName)
                ->first();
            
            if ($existingUserApi) {
                // 如果已存在，更新记录
                $existingUserApi->api_user = $randomUserName;
                $existingUserApi->api_pass = $password;
                $existingUserApi->api_money = $existingUserApi->api_money ?? 0;
                $existingUserApi->updated_at = now();
                $existingUserApi->save();
                
                Log::info('Pussy注册 - User_Api记录已更新', [
                    'user_id' => $user->id,
                    'api_code' => $platformName,
                    'api_user' => $randomUserName
                ]);
            } else {
                // 创建新记录
                $userApiData = [
                    'user_id' => $user->id,
                    'api_user' => $randomUserName,
                    'api_pass' => $password,
                    'api_code' => $platformName,
                    'api_money' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                User_Api::create($userApiData);
                
                Log::info('Pussy注册 - User_Api记录已创建', [
                    'user_id' => $user->id,
                    'api_code' => $platformName,
                    'api_user' => $randomUserName
                ]);
            }
        } catch (\Exception $e) {
            $return['code'] = 201;
            $return['message'] = '创建User_Api记录失败：' . $e->getMessage();
            Log::error('Pussy注册 - 创建User_Api记录失败', [
                'user_id' => $user->id,
                'api_code' => $platformName,
                'api_user' => $randomUserName,
                'error' => $e->getMessage()
            ]);
            return $return;
        }

        // 步骤3：使用生成的随机用户名调用Pussy注册接口进行注册
        Log::info('Pussy注册 - 使用随机用户名进行Pussy平台注册', [
            'randomUserName' => $randomUserName,
            'user_id' => $user->id
        ]);

        $time = $this->getTimeStamp();
        $agent = $agent ?: $this->agent;

        // 构建请求参数（使用生成的随机用户名）
        $params = [
            'action' => 'addUser',
            'agent' => $agent,
            'PassWd' => $password,
            'pwdtype' => 1, // 1密码明文
            'userName' => $randomUserName,
            'Name' => $name,
            'Tel' => $tel,
            'Memo' => $memo,
            'UserType' => $userType,
            'time' => $time,
            'authcode' => $this->api_account,
            'sign' => $this->generateSign($randomUserName, $time)
        ];

        $apiUrl = rtrim($this->api_url, '/') . '/ashx/account/account.ashx';
        Log::info('Pussy注册 - 请求参数', [
            'randomUserName' => $randomUserName,
            'params' => $params,
            'api_url' => $apiUrl
        ]);

        $res = $this->sendRequest($apiUrl, $params);

        Log::info('Pussy注册 - 接口返回', [
            'randomUserName' => $randomUserName,
            'response' => $res
        ]);

        // 检查响应结果（code=0表示成功）
        if (!isset($res['success']) || !$res['success'] || (isset($res['code']) && $res['code'] != 0)) {
            $return['code'] = 201;
            $return['message'] = $res['msg'] ?? 'Pussy平台注册失败';
            Log::error('Pussy注册失败', [
                'randomUserName' => $randomUserName,
                'response' => $res,
                'user_id' => $user->id
            ]);
            return $return;
        }

        Log::info('Pussy注册成功', [
            'randomUserName' => $randomUserName,
            'response' => $res,
            'user_id' => $user->id
        ]);

        // 返回注册成功的随机用户名
        $return['data'] = $randomUserName;
        return $return;
    }

    /**
     * 登录获取游戏地址
     * 注意：Pussy API文档中没有明确说明登录接口，这里可能需要根据实际接口调整
     * 如果文档中没有登录接口，可能需要通过其他方式获取游戏链接
     * 
     * 登录流程：先根据用户名从users表获取api_user字段，然后使用api_user进行登录
     *
     * @param string $userName 用户名（用于查找users表中的记录）
     * @param string $gameCode 游戏代码（可选）
     * @param int $isMobile 是否手机端（0=PC，1=手机）
     * @return array
     */
    public function login($userName, $gameCode = '', $isMobile = 1)
    {
        Log::info('Pussy登录 - 开始调用', [
            'userName' => $userName,
            'gameCode' => $gameCode,
            'isMobile' => $isMobile
        ]);

        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 根据用户名从users表获取api_user字段
        $user = User::where('username', $userName)->first();
        
        if (!$user) {
            $return['code'] = 404;
            $return['message'] = '用户不存在';
            Log::error('Pussy登录失败 - 用户不存在', [
                'userName' => $userName
            ]);
            return $return;
        }

        // 获取api_user字段
        $apiUserName = $user->api_user;
        
        if (empty($apiUserName)) {
            $return['code'] = 400;
            $return['message'] = '用户未注册Pussy游戏账号，请先注册';
            Log::error('Pussy登录失败 - api_user为空', [
                'userName' => $userName,
                'user_id' => $user->id
            ]);
            return $return;
        }

        Log::info('Pussy登录 - 获取到api_user', [
            'userName' => $userName,
            'api_user' => $apiUserName,
            'user_id' => $user->id
        ]);

        // TODO: Pussy API文档中没有明确说明登录接口
        // 这里使用api_user进行登录，但接口实现需要根据实际API文档补充
        Log::warning('Pussy登录接口未实现', [
            'userName' => $userName,
            'api_user' => $apiUserName,
            'gameCode' => $gameCode,
            'isMobile' => $isMobile
        ]);

        // 暂时返回错误，提示需要补充登录接口信息
        // 实际实现时，应该使用 $apiUserName 调用Pussy登录接口
        return [
            'code' => 201,
            'message' => 'Pussy登录接口文档中未提供，需要补充接口信息',
            'data' => null,
            'api_user' => $apiUserName // 返回api_user供调试使用
        ];
    }

    /**
     * 查询用户余额
     * 通过查询用户信息接口获取余额
     * /ashx/account/account.ashx?action=getUserInfo
     *
     * @param string $userName 用户名
     * @return array
     */
    public function balance($userName)
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        $time = $this->getTimeStamp();

        // 构建请求参数
        $params = [
            'action' => 'getUserInfo',
            'userName' => $userName,
            'time' => $time,
            'authcode' => $this->api_account,
            'sign' => $this->generateSign($userName, $time)
        ];

        $apiUrl = rtrim($this->api_url, '/') . '/ashx/account/account.ashx';
        $res = $this->sendRequest($apiUrl, $params);

        if (!isset($res['success']) || !$res['success'] || (isset($res['code']) && $res['code'] != 0)) {
            $return['code'] = 201;
            $return['message'] = $res['msg'] ?? '查询余额失败';
            Log::error('Pussy查询余额失败', [
                'userName' => $userName,
                'response' => $res
            ]);
            return $return;
        }

        // 从返回结果中提取余额（需要根据实际返回字段调整）
        $balance = 0;
        if (isset($res['money'])) {
            $balance = (float)$res['money'];
        } elseif (isset($res['acc']) && isset($res['money'])) {
            $balance = (float)$res['money'];
        }

        $return['data'] = $balance;

        return $return;
    }

    /**
     * 充值（转入游戏）
     * /ashx/account/setScore.ashx?action=setServerScore
     *
     * @param string $userName 用户名
     * @param float $amount 金额（>0表示加分）
     * @param string $transferno 转账订单号（必须唯一）
     * @param string $actionUser 操作人（可选，默认system）
     * @param string $actionIp 操作IP（可选，默认127.0.0.1）
     * @return array
     */
    public function deposit($userName, $amount, $transferno, $actionUser = 'system', $actionIp = '127.0.0.1')
    {
        $amount = floor($amount);
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        $time = $this->getTimeStamp();

        // 构建请求参数
        $params = [
            'action' => 'setServerScore',
            'orderid' => $transferno,
            'scoreNum' => $amount, // >0 加分
            'userName' => $userName,
            'ActionUser' => $actionUser,
            'ActionIp' => $actionIp,
            'time' => $time,
            'authcode' => $this->api_account,
            'sign' => $this->generateSign($userName, $time)
        ];

        $apiUrl = rtrim($this->api_url, '/') . '/ashx/account/setScore.ashx';
        $res = $this->sendRequest($apiUrl, $params);

        if (!isset($res['success']) || !$res['success'] || (isset($res['code']) && $res['code'] != 0)) {
            $return['code'] = 201;
            $return['message'] = $res['msg'] ?? '充值失败';
            Log::error('Pussy充值失败', [
                'userName' => $userName,
                'amount' => $amount,
                'transferno' => $transferno,
                'response' => $res
            ]);
            return $return;
        }

        Log::info('Pussy充值成功', [
            'userName' => $userName,
            'amount' => $amount,
            'transferno' => $transferno,
            'response' => $res
        ]);

        return $return;
    }

    /**
     * 提现（转回钱包）
     * /ashx/account/setScore.ashx?action=setServerScore
     *
     * @param string $userName 用户名
     * @param float $amount 金额（<0表示扣分）
     * @param string $transferno 转账订单号（必须唯一）
     * @param string $actionUser 操作人（可选，默认system）
     * @param string $actionIp 操作IP（可选，默认127.0.0.1）
     * @return array
     */
    public function withdrawal($userName, $amount, $transferno, $actionUser = 'system', $actionIp = '127.0.0.1')
    {
        $amount = floor($amount);
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        $time = $this->getTimeStamp();

        // 构建请求参数（amount为负数表示扣分）
        $params = [
            'action' => 'setServerScore',
            'orderid' => $transferno,
            'scoreNum' => -abs($amount), // <0 扣分
            'userName' => $userName,
            'ActionUser' => $actionUser,
            'ActionIp' => $actionIp,
            'time' => $time,
            'authcode' => $this->api_account,
            'sign' => $this->generateSign($userName, $time)
        ];

        $apiUrl = rtrim($this->api_url, '/') . '/ashx/account/setScore.ashx';
        $res = $this->sendRequest($apiUrl, $params);

        if (!isset($res['success']) || !$res['success'] || (isset($res['code']) && $res['code'] != 0)) {
            $return['code'] = 201;
            $return['message'] = $res['msg'] ?? '提现失败';
            Log::error('Pussy提现失败', [
                'userName' => $userName,
                'amount' => $amount,
                'transferno' => $transferno,
                'response' => $res
            ]);
            return $return;
        }

        Log::info('Pussy提现成功', [
            'userName' => $userName,
            'amount' => $amount,
            'transferno' => $transferno,
            'response' => $res
        ]);

        return $return;
    }

    /**
     * 查询订单状态
     * api2URL/ashx/getOrder.ashx
     *
     * @param string $orderId 订单ID
     * @return array
     */
    public function getOrder($orderId)
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        $time = $this->getTimeStamp();
        
        // 使用api2URL
        $api2Url = str_replace('api.', 'api2.', $this->api_url);
        if ($api2Url === $this->api_url) {
            // 如果替换失败，尝试直接使用api2
            $api2Url = 'http://api2.pussy888.com/';
        }

        // 构建请求参数
        $params = [
            'orderid' => $orderId,
            'time' => $time,
            'authcode' => $this->api_account,
            'sign' => $this->generateOrderSign($orderId, $time)
        ];

        $apiUrl = rtrim($api2Url, '/') . '/ashx/getOrder.ashx';
        $res = $this->sendRequest($apiUrl, $params);

        if (!isset($res['success']) || !$res['success']) {
            $return['code'] = 201;
            $return['message'] = $res['msg'] ?? '查询订单失败';
            Log::error('Pussy查询订单失败', [
                'orderId' => $orderId,
                'response' => $res
            ]);
            return $return;
        }

        // code: 0表示没有该订单，1表示存在
        $return['data'] = $res;
        $return['exists'] = isset($res['code']) && $res['code'] == 1;

        return $return;
    }
}

