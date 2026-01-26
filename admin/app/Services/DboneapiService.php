<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * OneAPI 游戏接口类
 * 根据 oneapi.md 文档实现
 * 
 * Game Aggregator API 服务类
 * 用于调用 Game Aggregator 的游戏相关接口
 */
class DboneapiService
{
    // API 配置参数
    protected $oneapi_site = 'https://stg.gasea168.com';  // OneAPI 站点地址，需要根据实际配置修改
    protected $api_key = '843146a184e40027d98f6ef8543e9a56c202fff3b2f3608f64a1b52e052d8268';  // API Key（64字符的字母数字字符串）
    protected $api_secret = '9ff1662935474b60a66c053b6f1252a2e5204fd5dc4a77f9293b5905dbfc423d';  // API Secret（64字符的字母数字字符串，用于生成签名）
    protected $currency = 'CNY';  // 默认币种
    protected $language = 'zh';  // 默认语言
    protected $platform = 'web';  // 默认平台（web/H5）
    protected $err = ["所属产品" => "ONEAPI集成"];

    public function __construct()
    {
        // 如果需要从系统配置读取，可以在这里初始化
        // $this->oneapi_site = SystemConfig::getValue('Oneapi_site') ?? $this->oneapi_site;
        // $this->api_key = SystemConfig::getValue('Oneapi_api_key') ?? $this->api_key;
        // $this->api_secret = SystemConfig::getValue('Oneapi_api_secret') ?? $this->api_secret;
    }

    /**
     * 生成 HMAC-SHA256 签名
     * 根据 oneapi.md 文档：使用 HMAC-SHA256 算法对请求体进行签名
     *
     * @param string $request_body 请求体（JSON字符串）
     * @return string HMAC-SHA256 签名
     */
    private function generateSignature($request_body)
    {
        return hash_hmac('sha256', $request_body, $this->api_secret);
    }

    /**
     * 生成 UUID traceId
     *
     * @return string UUID格式的traceId
     */
    private function generateTraceId()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * 发送 HTTP POST 请求
     *
     * @param string $url 请求地址
     * @param array $post_data 请求参数
     * @param bool $is_log 是否记录日志
     * @return array
     */
    private function sendRequest($url, $post_data = [], $is_log = false)
    {
        // 如果没有 traceId，自动生成
        if (empty($post_data['traceId'])) {
            $post_data['traceId'] = $this->generateTraceId();
        }

        // 将请求数据转换为 JSON 字符串
        $request_body = json_encode($post_data, JSON_UNESCAPED_SLASHES);

        // 生成签名
        $signature = $this->generateSignature($request_body);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-API-Key: ' . $this->api_key,
            'X-Signature: ' . $signature
        ]);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        $contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($is_log) {
            Log::info('OneAPI接口请求详情', [
                'url' => $url,
                'post_data' => $post_data,
                'request_body' => $request_body,
                'signature' => $signature,
                'contents' => $contents,
                'http_code' => $httpCode,
                'error' => $error
            ]);
        }

        if ($error) {
            Log::error('OneAPI接口请求失败', [
                'url' => $url,
                'error' => $error,
                'http_code' => $httpCode
            ]);
            return [
                'status' => 'SC_UNKNOWN_ERROR',
                'message' => 'Server Error: ' . $error
            ];
        }

        $result = json_decode($contents, TRUE);

        if (!$result || !is_array($result)) {
            Log::error('OneAPI接口返回数据解析失败', [
                'url' => $url,
                'http_code' => $httpCode,
                'response' => $contents
            ]);
            return [
                'status' => 'SC_UNKNOWN_ERROR',
                'message' => '返回数据解析失败'
            ];
        }

        return $result;
    }

    /**
     * 请求游戏落地URL
     * POST https://<oneapi_site>/game/url
     *
     * @param string $username 用户名
     * @param string $game_code 游戏代码
     * @param string $language 语言（可选，默认zh）
     * @param string $platform 平台（可选，web/H5，默认web）
     * @param string $currency 币种（可选，默认CNY）
     * @param string $lobby_url 大厅URL（必选）
     * @param string $ip_address 用户IP地址（必选）
     * @param string $trace_id 追踪ID（可选，自动生成）
     * @return array ['status' => 'SC_OK', 'data' => ['gameUrl' => '', 'token' => '']]
     */
    /**
     * 获取服务器 IPv4 地址
     * 
     * @return string IPv4 地址
     */
    private function getServerIpv4()
    {
        // 方法1：尝试从 $_SERVER['SERVER_ADDR'] 获取
        if (isset($_SERVER['SERVER_ADDR']) && !empty($_SERVER['SERVER_ADDR'])) {
            $ip = $_SERVER['SERVER_ADDR'];
            // 验证是否为 IPv4 地址
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                return $ip;
            }
        }

        // 方法2：通过主机名获取
        try {
            $hostname = gethostname();
            if ($hostname) {
                $ip = gethostbyname($hostname);
                // 验证是否为有效的 IPv4 地址（不是主机名本身）
                if ($ip !== $hostname && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    return $ip;
                }
            }
        } catch (\Exception $e) {
            // 忽略错误，继续尝试其他方法
        }

        // 方法3：尝试从网络接口获取（Linux/Unix）
        try {
            if (function_exists('exec')) {
                // 尝试获取第一个非回环的 IPv4 地址
                $command = "ip -4 addr show | grep -oP '(?<=inet\s)\d+(\.\d+){3}' | grep -v '127.0.0.1' | head -1";
                $ip = trim(exec($command));
                if (!empty($ip) && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    return $ip;
                }
                
                // 备用方法：使用 ifconfig（如果 ip 命令不可用）
                $command = "ifconfig | grep -oP '(?<=inet\s)\d+(\.\d+){3}' | grep -v '127.0.0.1' | head -1";
                $ip = trim(exec($command));
                if (!empty($ip) && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    return $ip;
                }
            }
        } catch (\Exception $e) {
            // 忽略错误
        }

        // 方法4：从环境变量获取（如果设置了）
        $envIp = env('SERVER_IP', '');
        if (!empty($envIp) && filter_var($envIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return $envIp;
        }

        // 默认返回空字符串（如果所有方法都失败）
        Log::warning('OneAPI - 无法获取服务器 IPv4 地址，将使用空值');
        return '';
    }

    public function getGameUrl($username, $game_code, $language = '', $platform = '', $currency = '', $trace_id = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        $trace_id = $trace_id ?: $this->generateTraceId();
        $language = $language ?: $this->language;
        $platform = $platform ?: $this->platform;
        $currency = $currency ?: $this->currency;

        // 判断是手机还是电脑，从 env 获取对应的 lobby_url
        $isMobile = (strtolower($platform) === 'h5' || strtolower($platform) === 'mobile');
        if ($isMobile) {
            // 手机端：从 env 获取 H5 网址
            $lobby_url = env('WAP_URL');
        } else {
            // 电脑端：从 env 获取 Web 网址
            $lobby_url = env('PC_URL');
        }

        // 自动获取服务器 IPv4 地址
        $ip_address = $this->getServerIpv4();

        $data = [
            'username' => $username,
            'traceId' => $trace_id,
            'gameCode' => $game_code,
            'language' => $language,
            'platform' => $platform,
            'currency' => $currency,
            'lobbyUrl' => $lobby_url,
            'ipAddress' => $ip_address
        ];
        Log::error('OneAPI获取游戏URL', [
                "我是请求游戏的时候传入的参数不要忽略我"=>$data,
            ]);
        $url = $this->oneapi_site . '/game/url';
        $res = $this->sendRequest($url, $data);

        if (isset($res['status']) && $res['status'] === 'SC_OK') {
            $return['data'] = $res['data'] ?? [];
            $return['token'] = $res['data']['token'] ?? '';
        } else {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '获取游戏URL失败';
            Log::error('OneAPI获取游戏URL失败', [
                "请求链接"=>$url,
                "请求参数"=>$data,
                "响应结果"=>$res,
                '请求用户' => $username,
            ]);
        }

        return $return;
    }

    /**
     * 获取支持的供应商列表
     * POST https://<oneapi_site>/game/vendors
     *
     * @param string $display_language 显示语言（可选）
     * @param string $currency 币种（可选）
     * @param string $trace_id 追踪ID（可选，自动生成）
     * @return array ['status' => 'SC_OK', 'data' => []]
     */
    public function getVendors($display_language = '', $currency = '', $trace_id = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => []
        ];

        $trace_id = $trace_id ?: $this->generateTraceId();

        $data = [
            'traceId' => $trace_id
        ];

        if (!empty($display_language)) {
            $data['displayLanguage'] = $display_language;
        }

        if (!empty($currency)) {
            $data['currency'] = $currency;
        }

        $url = $this->oneapi_site . '/game/vendors';
        $res = $this->sendRequest($url, $data);

        if (isset($res['status']) && $res['status'] === 'SC_OK') {
            $return['data'] = $res['data'] ?? [];
        } else {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '获取供应商列表失败';
            Log::error('OneAPI获取供应商列表失败', [
                'response' => $res
            ]);
        }

        return $return;
    }

    /**
     * 获取游戏列表
     * POST https://<oneapi_site>/game/list
     *
     * @param string $providerCode 供应商代码（必选，对应 OneAPI 的 vendorCode）
     * @param string $gameType 游戏类型（可选，OneAPI 不使用）
     * @param string $gameCode 游戏唯一编码（可选，OneAPI 不使用）
     * @param int $page 页码（默认 1）
     * @param int $size 每页数量（默认 100）
     * @param string $displayLanguage 显示语言（可选）
     * @param string $currency 币种（可选）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息', 'data' => []]
     */
    public function getGameList($providerCode = '', $gameType = '', $gameCode = '', $page = 1, $size = 100, $displayLanguage = '', $currency = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => []
        ];

        // 参数转换：将统一参数转换为 OneAPI 接口需要的参数
        // providerCode -> vendorCode (必选)
        $vendor_code = $providerCode;
        if (empty($vendor_code)) {
            $return['code'] = 201;
            $return['message'] = '参数错误：providerCode（vendorCode）必填';
            return $return;
        }

        // page -> pageNo
        $page_no = $page;
        // size -> pageSize
        $page_size = $size;
        // displayLanguage -> displayLanguage
        $display_language = $displayLanguage;
        // currency -> currency
        // gameType 和 gameCode 在 OneAPI 中不使用，忽略

        $trace_id = $this->generateTraceId();

        $data = [
            'traceId' => $trace_id,
            'vendorCode' => $vendor_code,
            'pageNo' => (int) $page_no,
            'pageSize' => (int) ($page_size ?: 100)
        ];

        if (!empty($display_language)) {
            $data['displayLanguage'] = $display_language;
        }

        if (!empty($currency)) {
            $data['currency'] = $currency;
        }

        $url = $this->oneapi_site . '/game/list';
        $res = $this->sendRequest($url, $data);

        if (isset($res['status']) && $res['status'] === 'SC_OK') {
            $responseData = $res['data'] ?? [];
            // 统一返回格式，与 DbgmagService 保持一致
            // OneAPI 返回格式：data.games 是游戏列表数组，data.currentPage, data.totalItems, data.totalPages 是分页信息
            $return['data'] = $responseData['games'] ?? [];
            $return['total'] = $responseData['totalItems'] ?? 0;
            $return['pages'] = $responseData['totalPages'] ?? 0;
            $return['size'] = $page_size; // OneAPI 不返回 pageSize，使用请求参数
            $return['current'] = $responseData['currentPage'] ?? $page_no;
        } else {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '获取游戏列表失败';
            Log::error('OneAPI获取游戏列表失败', [
                'vendor_code' => $vendor_code,
                'response' => $res
            ]);
        }

        return $return;
    }

    /**
     * 终止玩家游戏会话
     * POST https://<oneapi_site>/game/terminate
     *
     * @param string $username 用户名（必选）
     * @param string $trace_id 追踪ID（可选，自动生成）
     * @return array ['status' => 'SC_OK']
     */
    public function terminateGame($username, $trace_id = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        $trace_id = $trace_id ?: $this->generateTraceId();

        $data = [
            'traceId' => $trace_id,
            'username' => $username
        ];

        $url = $this->oneapi_site . '/game/terminate';
        $res = $this->sendRequest($url, $data);

        if (isset($res['status']) && $res['status'] === 'SC_OK') {
            // 成功
        } else {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '终止游戏会话失败';
            Log::error('OneAPI终止游戏会话失败', [
                'username' => $username,
                'response' => $res
            ]);
        }

        return $return;
    }

    /**
     * 获取交易列表
     * POST https://<oneapi_site>/transaction/list
     *
     * @param int $from_time 开始时间戳（毫秒）
     * @param int $to_time 结束时间戳（毫秒）
     * @param int $page_no 页码（必选）
     * @param int $page_size 每页数量（可选，默认2000，最大5000）
     * @param string $trace_id 追踪ID（可选，自动生成）
     * @return array ['status' => 'SC_OK', 'data' => []]
     */
    public function getTransactionList($from_time, $to_time, $page_no = 1, $page_size = 2000, $trace_id = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => []
        ];

        $trace_id = $trace_id ?: $this->generateTraceId();

        $data = [
            'traceId' => $trace_id,
            'fromTime' => (int) $from_time,
            'toTime' => (int) $to_time,
            'pageNo' => (int) $page_no,
            'pageSize' => (int) ($page_size ?: 2000)
        ];

        $url = $this->oneapi_site . '/transaction/list';
        $res = $this->sendRequest($url, $data);

        if (isset($res['status']) && $res['status'] === 'SC_OK') {
            $return['data'] = $res['data'] ?? [];
        } else {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '获取交易列表失败';
            Log::error('OneAPI获取交易列表失败', [
                'from_time' => $from_time,
                'to_time' => $to_time,
                'response' => $res
            ]);
        }

        return $return;
    }

    /**
     * 获取交易详情
     * POST https://<oneapi_site>/v2/transaction/detail
     *
     * @param string $bet_id 投注ID（必选）
     * @param int $from_time 开始时间戳（毫秒，必选）
     * @param int $to_time 结束时间戳（毫秒，必选）
     * @param string $display_language 显示语言（可选）
     * @param string $trace_id 追踪ID（可选，自动生成）
     * @return array ['status' => 'SC_OK', 'data' => []]
     */
    public function getTransactionDetail($bet_id, $from_time, $to_time, $display_language = '', $trace_id = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => []
        ];

        $trace_id = $trace_id ?: $this->generateTraceId();

        $data = [
            'traceId' => $trace_id,
            'betId' => $bet_id,
            'fromTime' => (int) $from_time,
            'toTime' => (int) $to_time
        ];

        if (!empty($display_language)) {
            $data['displayLanguage'] = $display_language;
        }

        $url = $this->oneapi_site . '/v2/transaction/detail';
        $res = $this->sendRequest($url, $data);

        if (isset($res['status']) && $res['status'] === 'SC_OK') {
            $return['data'] = $res['data'] ?? [];
        } else {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '获取交易详情失败';
            Log::error('OneAPI获取交易详情失败', [
                'bet_id' => $bet_id,
                'response' => $res
            ]);
        }

        return $return;
    }
}
