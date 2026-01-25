<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\SystemConfig;
use App\Models\Api;

/**
 * DB游戏接口类
 * 参考TgService的结构和规范
 */
class DbService
{
    protected $api_account;
    protected $sign_key;
    protected $api_url;

    public function __construct()
    {
        // 从系统配置获取DB接口相关配置
        $this->api_url = "https://bgcgw.bguwvz.com/bw-gameapi-client-gateway/bw-gameapi-client-server";
        $this->api_account = "BTM494";
        $this->sign_key = "XC3OQ1sBQEcT13jvBqQ3WuvERPfyCuSaVvDzTMdjMHhGwgJGvAG7BbTLhX0rCeMyG8pk0i7g6XBr3qBPD4JxL6mvwbilYLjpRzCZ";
    }

    /**
     * 生成签名（按照DB接口规范）
     * 参考Java SignatureUtils.generateSignature方法
     * 
     * 算法步骤：
     * 1. 对参数按键名进行排序
     * 2. 拼接参数为 key=value& 格式，排除空值
     * 3. 去掉最后一个 & 字符
     * 4. 拼接密钥
     * 5. MD5加密并转为大写
     *
     * @param array $params 请求参数数组
     * @return string MD5加密后的签名（大写）
     */
    private function generateCode(Array $params)
    {
        // 1. 对参数按键名进行排序（TreeMap排序效果）
        ksort($params);
        
        // 2. 拼接参数为 key=value& 格式，排除空值
        $sb = '';
        foreach ($params as $key => $value) {
            // 排除空值的参数（null和空字符串）
            if ($value !== null && $value !== '') {
                $sb .= $key . '=' . $value . '&';
            }
        }
        
        // 3. 去掉最后一个 & 字符
        if (strlen($sb) > 0) {
            $sb = rtrim($sb, '&');
        }
        
        // 4. 拼接密钥
        $sb .= $this->sign_key;
        
        // 5. MD5加密并转为大写
        return strtoupper(md5($sb));
    }

    /**
     * 发送HTTP请求（表单格式）
     *
     * @param string $url
     * @param array $post_data
     * @return array
     */
    private function sendRequest($url, $post_data = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($contents, TRUE);
        
        if (!$result || !is_array($result)) {
            Log::error('DB接口请求失败', [
                'url' => $url,
                'http_code' => $httpCode,
                'response' => $contents
            ]);
            return [
                'Code' => -1,
                'Message' => '返回数据解析失败',
                'Data' => null
            ];
        }

        return $result;
    }

    /**
     * 发送JSON格式HTTP请求（带签名Headers）
     *
     * @param string $url
     * @param array $body_data 请求体数据
     * @param array $headers 额外的请求头（可选）
     * @return array
     */
    private function sendJsonRequest($url, $body_data = [], $headers = [])
    {
        // 生成timestamp和nonce（确保每次请求都是唯一的）
        // timestamp使用10位秒级时间戳
        $microtime = microtime(true);
        $timestamp = (string)(int)$microtime; // 10位秒级时间戳
        
        // 生成6位唯一的nonce：使用微秒部分的后3位 + 3位随机数，确保唯一性
        // 从microtime中提取微秒部分（小数部分）转换为3位数字
        $microseconds = (int)(($microtime - floor($microtime)) * 1000); // 微秒部分转换为0-999的整数
        $microStr = str_pad((string)($microseconds % 1000), 3, '0', STR_PAD_LEFT); // 确保3位
        $randomStr = str_pad((string)rand(0, 999), 3, '0', STR_PAD_LEFT); // 3位随机数
        $nonce = $microStr . $randomStr; // 组合成6位唯一的nonce
        
        // 如果组合后不是6位，则使用纯随机数（备用方案）
        if (strlen($nonce) != 6) {
            $nonce = str_pad((string)rand(0, 999999), 6, '0', STR_PAD_LEFT);
        }

        // 构建签名参数（签名需要包含body参数、timestamp和nonce）
        // 注意：签名时使用的key是timestamp和nonce，不是ob-timestamp和ob-nonce
        $signParams = array_merge($body_data, [
            'timestamp' => $timestamp,
            'nonce' => $nonce
        ]);

        // 生成签名
        $signature = $this->generateCode($signParams);

        // 设置请求头（请求头中使用ob-timestamp和ob-nonce）
        $requestHeaders = array_merge([
            'Content-Type: application/json',
            'merchantCode: ' . $this->api_account,
            'ob-timestamp: ' . $timestamp,
            'ob-nonce: ' . $nonce,
            'ob-signature: ' . $signature,
        ], $headers);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        $contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            Log::error('DB接口请求CURL错误', [
                'url' => $url,
                'curl_error' => $curlError
            ]);
            return [
                'code' => -1,
                'message' => '请求失败：' . $curlError,
                'data' => null
            ];
        }

        $result = json_decode($contents, TRUE);
        
        if (!$result || !is_array($result)) {
            Log::error('DB接口请求失败 - JSON解析失败', [
                'url' => $url,
                'http_code' => $httpCode,
                'response_raw' => $contents,
                'response_length' => strlen($contents),
                'json_error' => json_last_error_msg(),
                'request_body' => $body_data,
                'headers' => $requestHeaders
            ]);
            return [
                'code' => -1,
                'message' => '返回数据解析失败：' . json_last_error_msg(),
                'data' => null,
                'raw_response' => substr($contents, 0, 500) // 返回前500字符用于调试
            ];
        }

        return $result;
    }

    /**
     * 注册用户到DB游戏平台
     * 参考文档：https://apidoc.gtlboe.com/zh/member/MemberControllerApi.html
     * URL: /member/register/v1
     * Type: POST
     * Content-Type: application/json
     *
     * @param string $userName 玩家账号（唯一，必填，4-11位，至少两个字母加数字组合，字母都是小写）
     * @param string $password 密码（必填，默认123456）
     * @param string $currency 币种（必填，如VND-越南盾,CNY-人民币,THB-泰铢,USDT-泰达币，默认USDT）
     * @param string $lang 站点语言（必填，如zh_CN-中文,en_US-英文，默认zh_CN）
     * @return array
     */
    public function register($userName, $password = '123456', $currency = 'USDT', $lang = 'zh_CN')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 检查API URL是否配置
        if (empty($this->api_url)) {
            $return['code'] = 400;
            $return['message'] = 'DB API URL未配置';
            Log::error('DB API URL未配置');
            return $return;
        }

        // 确保用户名是小写
        $userName = strtolower($userName);

        // 构建请求体参数（JSON格式）
        $bodyData = [
            'userName' => $userName,
            'password' => $password,
            'currency' => $currency,
            'lang' => $lang,
        ];

        // 发送JSON请求到注册接口
        $apiUrl = rtrim($this->api_url, '/') . '/member/register/v1';
        
        $res = $this->sendJsonRequest($apiUrl, $bodyData);
        
        // 检查响应结果（DB接口返回code=0表示成功）
        if (!isset($res['code']) || $res['code'] != 0) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? ($res['Message'] ?? '注册失败');
            Log::error('DB注册失败', [
                'userName' => $userName,
                'request_data' => $bodyData,
                'response' => $res
            ]);
            return $return;
        }

        return $return;
    }

    /**
     * 获取游戏连接（登录获取游戏地址）
     * 参考文档：https://apidoc.gtlboe.com/zh/member/MemberControllerApi.html
     * URL: /member/getLaunchURL/v1
     * Type: POST
     * Content-Type: application/json
     *
     * @param string $userName 玩家账号（必填）
     * @param string $currency 币种（必填，如VND-越南盾,CNY-人民币,THB-泰铢,USDT-泰达币，默认USDT）
     * @param string $venueCode 场馆编码（必填，参考数据字典code）
     * @param int $gameId 平台统一id（选填，从游戏列表接口中获取，默认0）
     * @param int $deviceType 设备类型（选填，1=pc，2=h5，3=ios，4=android，默认2）
     * @param string $lang 站点语言（必填，如zh_CN-中文,en_US-英文，默认zh_CN）
     * @param string $userClientIp 用户客户端IP（选填，用于游戏厂商优化访问线路）
     * @return array
     */
    public function login($userName, $venueCode = '', $currency = 'USDT', $gameId = 0, $deviceType = 2, $lang = 'zh_CN', $userClientIp = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];
        
        Log::error('DB登录参数信息', [
                'userName' => $userName,
                'venueCode' => $venueCode,
                'deviceType' => $deviceType
            ]);
        // 检查API URL是否配置
        if (empty($this->api_url)) {
            $return['code'] = 400;
            $return['message'] = 'DB API URL未配置';
            Log::error('DB API URL未配置');
            return $return;
        }

        // 验证必填参数
        if (empty($venueCode)) {
            $return['code'] = 400;
            $return['message'] = 'venueCode（场馆编码）不能为空';
            Log::error('DB登录参数错误 - venueCode为空', [
                'userName' => $userName
            ]);
            return $return;
        }

        // 确保用户名是小写
        $userName = strtolower($userName);

        // 构建请求体参数（JSON格式）
        $bodyData = [
            'userName' => $userName,
            'currency' => $currency,
            'venueCode' => $venueCode,
            'deviceType' => $deviceType,
            'lang' => $lang,
        ];

        // gameId选填，如果不为0则添加
        if ($gameId > 0) {
            $bodyData['gameId'] = $gameId;
        }

        // userClientIp选填，如果提供则添加
        if (!empty($userClientIp)) {
            $bodyData['userClientIp'] = $userClientIp;
        }

        // 发送JSON请求到获取游戏链接接口
        $apiUrl = rtrim($this->api_url, '/') . '/member/getLaunchURL/v1';
        
        $res = $this->sendJsonRequest($apiUrl, $bodyData);
        
        // 检查响应结果（DB接口返回code=0表示成功）
        if (!isset($res['code']) || $res['code'] != 0) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? ($res['Message'] ?? '获取游戏链接失败');
            Log::error('DB登录失败', [
                'userName' => $userName,
                'venueCode' => $venueCode,
                'gameId' => $gameId,
                'request_data' => $bodyData,
                'response' => $res
            ]);
            return $return;
        }

        // 获取游戏链接（content字段）
        $gameUrl = $res['data']['content'] ?? '';
        
        if (empty($gameUrl)) {
            $return['code'] = 201;
            $return['message'] = '获取游戏链接失败：响应中未包含游戏链接';
            Log::error('DB登录 - 获取游戏链接失败', [
                'userName' => $userName,
                'venueCode' => $venueCode,
                'gameId' => $gameId,
                'response_data' => $res['data'] ?? null,
                'full_response' => $res
            ]);
            return $return;
        }

        $return['data'] = $gameUrl;
        $return['traceId'] = $res['traceId'] ?? '';

        return $return;
    }

    /**
     * 查询用户余额
     * 参考文档：https://apidoc.gtlboe.com/zh/member/MemberControllerApi.html
     * URL: /member/balance/get/v1
     * Type: POST
     * Content-Type: application/json
     *
     * @param string $username 用户名（必填，会自动转为小写）
     * @param string $venueCode 场馆编码（可选，不传返回所有场馆数据）
     * @param string $currency 币种（必填，默认USDT，参考数据字典code）
     * @return array
     */
    public function balance($username, $venueCode = "", $currency = 'USDT')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 检查API URL是否配置
        if (empty($this->api_url)) {
            $return['code'] = 400;
            $return['message'] = 'DB API URL未配置';
            Log::error('DB API URL未配置');
            return $return;
        }

        // 确保用户名是小写
        $userName = strtolower($username);

        // 构建请求体参数（JSON格式）
        $bodyData = [
            'userName' => $userName,
            'currency' => $currency,
        ];

        // venueCode 可选，如果不为空则添加
        if (!empty($venueCode)) {
            $bodyData['venueCode'] = $venueCode;
        }

        // 发送JSON请求到余额查询接口
        $apiUrl = rtrim($this->api_url, '/') . '/member/balance/get/v1';
        
        $res = $this->sendJsonRequest($apiUrl, $bodyData);
        
        // 检查响应结果（DB接口返回code=0表示成功）
        if (!isset($res['code']) || $res['code'] != 0) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '查询余额失败';
            Log::error('DB查询余额失败', [
                'userName' => $userName,
                'venueCode' => $venueCode,
                'currency' => $currency,
                'request_data' => $bodyData,
                'response' => $res
            ]);
            return $return;
        }

        // 处理返回的余额数组
        $balanceData = $res['data'] ?? [];
        
        if (empty($balanceData) || !is_array($balanceData)) {
            $return['code'] = 201;
            $return['message'] = '未找到余额数据';
            $return['data'] = 0;
            Log::warning('DB查询余额 - 返回数据为空', [
                'userName' => $userName,
                'venueCode' => $venueCode,
                'response' => $res
            ]);
            return $return;
        }

        // 如果指定了 venueCode，查找对应场馆的余额
        if (!empty($venueCode)) {
            $found = false;
            foreach ($balanceData as $item) {
                if (isset($item['venueCode']) && $item['venueCode'] === $venueCode) {
                    $return['data'] = (float)($item['balance'] ?? 0);
                    $return['full_data'] = $item; // 保存完整数据用于调试
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                // 如果没找到指定场馆，返回第一个场馆的余额（兼容处理）
                $return['data'] = (float)($balanceData[0]['balance'] ?? 0);
                $return['full_data'] = $balanceData[0] ?? null;
                Log::warning('DB查询余额 - 未找到指定场馆，返回第一个场馆余额', [
                    'userName' => $userName,
                    'venueCode' => $venueCode,
                    'available_venues' => array_column($balanceData, 'venueCode')
                ]);
            }
        } else {
            // 如果没有指定 venueCode，返回所有场馆的余额数组
            // 为了兼容性，也返回第一个场馆的余额作为 data
            $return['data'] = (float)($balanceData[0]['balance'] ?? 0);
            $return['all_balances'] = $balanceData; // 保存所有场馆的余额数据
        }

        return $return;
    }

    /**
     * 充值（转入游戏）
     * 参考文档：https://apidoc.gtlboe.com/zh/member/MemberControllerApi.html
     * URL: /member/balance/recharge/v1
     * Type: POST
     * Content-Type: application/json
     *
     * @param string $username 用户名（必填，会自动转为小写）
     * @param float $amount 金额（必填，范围:1-100万，最多支持2位小数）
     * @param string $serialNo 交易流水号（商户订单号，必填，需确保唯一）
     * @param string $venueCode 场馆编码（必填，参考数据字典code）
     * @param string $currency 币种（必填，默认USDT，参考数据字典code）
     * @return array
     */
    public function deposit($username, $amount, $serialNo, $venueCode = '', $currency = 'USDT')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 检查API URL是否配置
        if (empty($this->api_url)) {
            $return['code'] = 400;
            $return['message'] = 'DB API URL未配置';
            Log::error('DB API URL未配置');
            return $return;
        }

        // 验证必填参数
        if (empty($venueCode)) {
            $return['code'] = 400;
            $return['message'] = 'venueCode（场馆编码）不能为空';
            Log::error('DB充值参数错误 - venueCode为空', [
                'username' => $username
            ]);
            return $return;
        }

        // 确保用户名是小写
        $userName = strtolower($username);
        
        // 金额保留2位小数，范围检查
        $amount = round($amount, 2);
        if ($amount < 1 || $amount > 1000000) {
            $return['code'] = 400;
            $return['message'] = '充值金额范围:1-100万';
            Log::error('DB充值金额超出范围', [
                'username' => $userName,
                'amount' => $amount
            ]);
            return $return;
        }

        // 构建请求体参数（JSON格式）
        $bodyData = [
            'userName' => $userName,
            'currency' => $currency,
            'venueCode' => $venueCode,
            'serialNo' => $serialNo,
            'amount' => $amount,
        ];

        // 发送JSON请求到充值接口
        $apiUrl = rtrim($this->api_url, '/') . '/member/balance/recharge/v1';
        
        $res = $this->sendJsonRequest($apiUrl, $bodyData);
        
        // 检查响应结果（DB接口返回code=0表示成功）
        if (!isset($res['code']) || $res['code'] != 0) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '充值失败';
            Log::error('DB充值失败', [
                'userName' => $userName,
                'amount' => $amount,
                'serialNo' => $serialNo,
                'venueCode' => $venueCode,
                'currency' => $currency,
                'request_data' => $bodyData,
                'response' => $res
            ]);
            return $return;
        }

        // 检查订单状态（0-成功，1-失败，3-处理中）
        $status = $res['data']['status'] ?? -1;
        $desc = $res['data']['desc'] ?? '';
        
        if ($status == 0) {
            // 成功
            $return['data'] = [
                'serialNo' => $res['data']['serialNo'] ?? $serialNo,
                'transferNo' => $res['data']['transferNo'] ?? '',
                'status' => $status,
                'desc' => $desc,
                'traceId' => $res['traceId'] ?? ''
            ];
        } elseif ($status == 3) {
            // 处理中，需要查询订单状态
            $return['code'] = 202;
            $return['message'] = '订单处理中，请稍后查询订单状态';
            $return['data'] = [
                'serialNo' => $res['data']['serialNo'] ?? $serialNo,
                'transferNo' => $res['data']['transferNo'] ?? '',
                'status' => $status,
                'desc' => $desc,
                'traceId' => $res['traceId'] ?? ''
            ];
            Log::warning('DB充值订单处理中', [
                'userName' => $userName,
                'serialNo' => $serialNo,
                'response' => $res
            ]);
        } else {
            // 失败
            $return['code'] = 201;
            $return['message'] = $desc ?: '充值失败';
            $return['data'] = [
                'serialNo' => $res['data']['serialNo'] ?? $serialNo,
                'transferNo' => $res['data']['transferNo'] ?? '',
                'status' => $status,
                'desc' => $desc,
                'traceId' => $res['traceId'] ?? ''
            ];
            Log::error('DB充值失败 - 订单状态为失败', [
                'userName' => $userName,
                'serialNo' => $serialNo,
                'status' => $status,
                'desc' => $desc,
                'response' => $res
            ]);
        }

        return $return;
    }

    /**
     * 提现（转回钱包）
     * 参考文档：https://apidoc.gtlboe.com/zh/member/MemberControllerApi.html
     * URL: /member/balance/withdraw/v1
     * Type: POST
     * Content-Type: application/json
     *
     * @param string $username 用户名（必填，会自动转为小写）
     * @param float $amount 金额（必填，范围:1-100万，最多支持2位小数）
     * @param string $serialNo 交易流水号（商户订单号，必填，需确保唯一）
     * @param string $venueCode 场馆编码（必填，参考数据字典code）
     * @param string $currency 币种（必填，默认USDT，参考数据字典code）
     * @return array
     */
    public function withdrawal($username, $amount, $serialNo, $venueCode = '', $currency = 'USDT')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 检查API URL是否配置
        if (empty($this->api_url)) {
            $return['code'] = 400;
            $return['message'] = 'DB API URL未配置';
            Log::error('DB API URL未配置');
            return $return;
        }

        // 验证必填参数
        if (empty($venueCode)) {
            $return['code'] = 400;
            $return['message'] = 'venueCode（场馆编码）不能为空';
            Log::error('DB提现参数错误 - venueCode为空', [
                'username' => $username
            ]);
            return $return;
        }

        // 确保用户名是小写
        $userName = strtolower($username);
        
        // 金额保留2位小数，范围检查
        $amount = round($amount, 2);
        if ($amount < 1 || $amount > 1000000) {
            $return['code'] = 400;
            $return['message'] = '提现金额范围:1-100万';
            Log::error('DB提现金额超出范围', [
                'username' => $userName,
                'amount' => $amount
            ]);
            return $return;
        }

        // 构建请求体参数（JSON格式）
        $bodyData = [
            'userName' => $userName,
            'currency' => $currency,
            'venueCode' => $venueCode,
            'serialNo' => $serialNo,
            'amount' => $amount,
        ];

        // 发送JSON请求到提现接口
        $apiUrl = rtrim($this->api_url, '/') . '/member/balance/withdraw/v1';
        
        $res = $this->sendJsonRequest($apiUrl, $bodyData);
        
        // 检查响应结果（DB接口返回code=0表示成功）
        if (!isset($res['code']) || $res['code'] != 0) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '提现失败';
            Log::error('DB提现失败', [
                'userName' => $userName,
                'amount' => $amount,
                'serialNo' => $serialNo,
                'venueCode' => $venueCode,
                'currency' => $currency,
                'request_data' => $bodyData,
                'response' => $res
            ]);
            return $return;
        }

        // 检查订单状态（0-成功，1-失败，3-处理中）
        $status = $res['data']['status'] ?? -1;
        $desc = $res['data']['desc'] ?? '';
        
        if ($status == 0) {
            // 成功
            $return['data'] = [
                'serialNo' => $res['data']['serialNo'] ?? $serialNo,
                'transferNo' => $res['data']['transferNo'] ?? '',
                'status' => $status,
                'desc' => $desc,
                'traceId' => $res['traceId'] ?? ''
            ];
        } elseif ($status == 3) {
            // 处理中，需要查询订单状态
            $return['code'] = 202;
            $return['message'] = '订单处理中，请稍后查询订单状态';
            $return['data'] = [
                'serialNo' => $res['data']['serialNo'] ?? $serialNo,
                'transferNo' => $res['data']['transferNo'] ?? '',
                'status' => $status,
                'desc' => $desc,
                'traceId' => $res['traceId'] ?? ''
            ];
            Log::warning('DB提现订单处理中', [
                'userName' => $userName,
                'serialNo' => $serialNo,
                'response' => $res
            ]);
        } else {
            // 失败
            $return['code'] = 201;
            $return['message'] = $desc ?: '提现失败';
            $return['data'] = [
                'serialNo' => $res['data']['serialNo'] ?? $serialNo,
                'transferNo' => $res['data']['transferNo'] ?? '',
                'status' => $status,
                'desc' => $desc,
                'traceId' => $res['traceId'] ?? ''
            ];
            Log::error('DB提现失败 - 订单状态为失败', [
                'userName' => $userName,
                'serialNo' => $serialNo,
                'status' => $status,
                'desc' => $desc,
                'response' => $res
            ]);
        }

        return $return;
    }

    /**
     * 获取游戏列表
     * 参考文档：https://apidoc.gtlboe.com/zh/member/GameListApi.html
     * URL: /member/game/list/v1
     * Type: POST
     * Content-Type: application/json
     *
     * @param string $venueCode 场馆编码（必填，参考数据字典）
     * @param string $currency 币种（必填，参考数据字典，默认USDT）
     * @param int $pageNum 分页参数，默认第一页（0）
     * @param int $pageSize 分页参数，默认每页10条，最大500条
     * @return array
     */
    public function getGameList($venueCode = '', $currency = 'USDT', $pageNum = 0, $pageSize = 10)
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 构建请求体参数
        $bodyData = [
            'currency' => $currency,
            'venueCode' => $venueCode,
            'pageNum' => $pageNum,
            'pageSize' => $pageSize,
        ];

        // 验证必填参数
        if (empty($venueCode)) {
            $return['code'] = 400;
            $return['message'] = 'venueCode（场馆编码）不能为空';
            Log::error('DB获取游戏列表参数错误', [
                'venueCode' => $venueCode,
                'currency' => $currency
            ]);
            return $return;
        }

        // 验证pageSize范围
        if ($pageSize > 500) {
            $pageSize = 500;
        }

        // 检查API URL是否配置
        if (empty($this->api_url)) {
            $return['code'] = 400;
            $return['message'] = 'DB API URL未配置';
            Log::error('DB API URL未配置');
            return $return;
        }

        // 发送JSON请求到游戏列表接口
        $apiUrl = rtrim($this->api_url, '/') . '/member/game/list/v1';

        $res = $this->sendJsonRequest($apiUrl, $bodyData);
        
        // 检查响应结果（DB接口返回code=0表示成功）
        if (!isset($res['code']) || $res['code'] != 0) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? ($res['Message'] ?? '获取游戏列表失败');
            $return['raw_response'] = $res['raw_response'] ?? null; // 包含原始响应用于调试
            Log::error('DB获取游戏列表失败', [
                'venueCode' => $venueCode,
                'currency' => $currency,
                'request_data' => $bodyData,
                'api_url' => $apiUrl,
                'response' => $res,
                'response_code' => $res['code'] ?? 'unknown'
            ]);
            return $return;
        }

        // 返回游戏列表数据
        $return['data'] = $res['data'] ?? [];
        $return['traceId'] = $res['traceId'] ?? '';

        return $return;
    }

    /**
     * 商户批量查询注单接口
     * 参考文档：https://apidoc.gtlboe.com/zh/member/MemberControllerApi.html
     * URL: /member/game/betBatchQuery/v1
     * Type: POST
     * Content-Type: application/json
     * 
     * 注意事项：
     * 1. 仅支持查询最近31天注单数据
     * 2. 查询时间不允许跨天
     * 3. 查询时间范围最多10分钟
     * 4. 查询时间需要延迟2分钟（以syncAt为排序依据）
     * 
     * @param string $venueCode 场馆编码（必填，参考数据字典code）
     * @param string $currency 币种（必填，参考数据字典code，默认USDT）
     * @param string $startTime 开始时间，GMT+8时区（格式：yyyy-MM-dd HH:mm:ss）
     * @param string $endTime 结束时间，GMT+8时区（格式：yyyy-MM-dd HH:mm:ss）
     * @param int $pageNum 分页参数，从第一页开始（默认1）
     * @param int $pageSize 分页参数，默认每页10条，最大3000条（默认10）
     * @return array
     */
    public function betBatchQuery($venueCode, $startTime, $endTime, $currency = 'USDT', $pageNum = 1, $pageSize = 10)
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 检查API URL是否配置
        if (empty($this->api_url)) {
            $return['code'] = 400;
            $return['message'] = 'DB API URL未配置';
            Log::error('DB API URL未配置');
            return $return;
        }

        // 验证必填参数
        if (empty($venueCode)) {
            $return['code'] = 400;
            $return['message'] = 'venueCode（场馆编码）不能为空';
            Log::error('DB查询注单参数错误 - venueCode为空');
            return $return;
        }

        if (empty($startTime) || empty($endTime)) {
            $return['code'] = 400;
            $return['message'] = '开始时间和结束时间不能为空';
            Log::error('DB查询注单参数错误 - 时间参数为空', [
                'startTime' => $startTime,
                'endTime' => $endTime
            ]);
            return $return;
        }

        // 验证时间格式
        $startTimestamp = strtotime($startTime);
        $endTimestamp = strtotime($endTime);
        
        if ($startTimestamp === false || $endTimestamp === false) {
            $return['code'] = 400;
            $return['message'] = '时间格式错误，请使用格式：yyyy-MM-dd HH:mm:ss';
            Log::error('DB查询注单参数错误 - 时间格式错误', [
                'startTime' => $startTime,
                'endTime' => $endTime
            ]);
            return $return;
        }

        // 验证时间范围不超过10分钟（600秒）
        $timeDiff = $endTimestamp - $startTimestamp;
        if ($timeDiff > 600) {
            $return['code'] = 400;
            $return['message'] = '查询时间范围最多10分钟';
            Log::error('DB查询注单参数错误 - 时间范围超过10分钟', [
                'startTime' => $startTime,
                'endTime' => $endTime,
                'timeDiff' => $timeDiff
            ]);
            return $return;
        }

        // 验证不能跨天
        $startDate = date('Y-m-d', $startTimestamp);
        $endDate = date('Y-m-d', $endTimestamp);
        if ($startDate !== $endDate) {
            $return['code'] = 400;
            $return['message'] = '查询时间不允许跨天';
            Log::error('DB查询注单参数错误 - 时间跨天', [
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);
            return $return;
        }

        // 验证不超过31天
        $now = time();
        $daysDiff = ($now - $startTimestamp) / 86400;
        if ($daysDiff > 31) {
            $return['code'] = 400;
            $return['message'] = '仅支持查询最近31天注单数据';
            Log::error('DB查询注单参数错误 - 超过31天', [
                'daysDiff' => $daysDiff
            ]);
            return $return;
        }

        // 验证pageSize范围
        if ($pageSize < 1 || $pageSize > 3000) {
            $return['code'] = 400;
            $return['message'] = 'pageSize范围:1-3000';
            Log::error('DB查询注单参数错误 - pageSize超出范围', [
                'pageSize' => $pageSize
            ]);
            return $return;
        }

        // 验证pageNum
        if ($pageNum < 1) {
            $pageNum = 1;
        }

        // 构建请求体参数（JSON格式）
        $bodyData = [
            'currency' => $currency,
            'venueCode' => $venueCode,
            'pageNum' => $pageNum,
            'pageSize' => $pageSize,
            'startTime' => $startTime,
            'endTime' => $endTime,
        ];

        // 发送JSON请求到批量查询注单接口
        $apiUrl = rtrim($this->api_url, '/') . '/member/game/betBatchQuery/v1';
        
        $res = $this->sendJsonRequest($apiUrl, $bodyData);
        
        // 检查响应结果（DB接口返回code=0表示成功）
        if (!isset($res['code']) || $res['code'] != 0) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '查询注单失败';
            Log::error('DB查询注单失败', [
                'venueCode' => $venueCode,
                'currency' => $currency,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'pageNum' => $pageNum,
                'pageSize' => $pageSize,
                'request_data' => $bodyData,
                'response' => $res
            ]);
            return $return;
        }

        // 返回注单数据
        $return['data'] = $res['data'] ?? [
            'totalRecord' => 0,
            'totalPage' => 0,
            'list' => []
        ];
        $return['traceId'] = $res['traceId'] ?? '';

        return $return;
    }

    /**
     * 商户游戏注单对账接口
     * 参考文档：https://apidoc.gtlboe.com/zh/member/MemberControllerApi.html
     * URL: /member/game/recordCheck/v1
     * Type: POST
     * Content-Type: application/json
     * 
     * 注意事项：
     * 1. 可核对近31天的数据
     * 2. 开始时间和结束时间为同一天
     * 3. 当天时间数据更新频繁，不稳定，建议核对T-1天
     * 
     * @param string $venueCode 场馆编码（必填，参考数据字典code）
     * @param string $currency 币种（必填，参考数据字典code，默认USDT）
     * @param string $startTime 开始时间，GMT+8时区（格式：yyyy-MM-dd HH:mm:ss）
     * @param string $endTime 结束时间，GMT+8时区（格式：yyyy-MM-dd HH:mm:ss）
     * @return array
     */
    public function recordCheck($venueCode, $startTime, $endTime, $currency = 'USDT')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        // 检查API URL是否配置
        if (empty($this->api_url)) {
            $return['code'] = 400;
            $return['message'] = 'DB API URL未配置';
            Log::error('DB API URL未配置');
            return $return;
        }

        // 验证必填参数
        if (empty($venueCode)) {
            $return['code'] = 400;
            $return['message'] = 'venueCode（场馆编码）不能为空';
            Log::error('DB对账参数错误 - venueCode为空');
            return $return;
        }

        if (empty($startTime) || empty($endTime)) {
            $return['code'] = 400;
            $return['message'] = '开始时间和结束时间不能为空';
            Log::error('DB对账参数错误 - 时间参数为空', [
                'startTime' => $startTime,
                'endTime' => $endTime
            ]);
            return $return;
        }

        // 验证时间格式
        $startTimestamp = strtotime($startTime);
        $endTimestamp = strtotime($endTime);
        
        if ($startTimestamp === false || $endTimestamp === false) {
            $return['code'] = 400;
            $return['message'] = '时间格式错误，请使用格式：yyyy-MM-dd HH:mm:ss';
            Log::error('DB对账参数错误 - 时间格式错误', [
                'startTime' => $startTime,
                'endTime' => $endTime
            ]);
            return $return;
        }

        // 验证不能跨天
        $startDate = date('Y-m-d', $startTimestamp);
        $endDate = date('Y-m-d', $endTimestamp);
        if ($startDate !== $endDate) {
            $return['code'] = 400;
            $return['message'] = '开始时间和结束时间必须为同一天';
            Log::error('DB对账参数错误 - 时间跨天', [
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);
            return $return;
        }

        // 验证不超过31天
        $now = time();
        $daysDiff = ($now - $startTimestamp) / 86400;
        if ($daysDiff > 31) {
            $return['code'] = 400;
            $return['message'] = '仅支持核对近31天的数据';
            Log::error('DB对账参数错误 - 超过31天', [
                'daysDiff' => $daysDiff
            ]);
            return $return;
        }

        // 验证开始时间小于等于结束时间
        if ($startTimestamp > $endTimestamp) {
            $return['code'] = 400;
            $return['message'] = '开始时间不能大于结束时间';
            Log::error('DB对账参数错误 - 开始时间大于结束时间', [
                'startTime' => $startTime,
                'endTime' => $endTime
            ]);
            return $return;
        }

        // 构建请求体参数（JSON格式）
        $bodyData = [
            'currency' => $currency,
            'venueCode' => $venueCode,
            'startTime' => $startTime,
            'endTime' => $endTime,
        ];

        // 发送JSON请求到对账接口
        $apiUrl = rtrim($this->api_url, '/') . '/member/game/recordCheck/v1';
        
        $res = $this->sendJsonRequest($apiUrl, $bodyData);
        
        // 检查响应结果（DB接口返回code=0表示成功）
        if (!isset($res['code']) || $res['code'] != 0) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '对账失败';
            Log::error('DB对账失败', [
                'venueCode' => $venueCode,
                'currency' => $currency,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'request_data' => $bodyData,
                'response' => $res
            ]);
            return $return;
        }

        // 返回对账数据
        $return['data'] = $res['data'] ?? [
            'totalBetCount' => 0,
            'totalBetAmount' => 0.0000,
            'totalValidBetAmount' => 0.0000,
            'totalNetAmount' => 0.0000
        ];
        $return['traceId'] = $res['traceId'] ?? '';

        return $return;
    }
}