<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\SystemConfig;
use App\Models\Api;

/**
 * DbmzService（原 DpService，名称更新）
 */
class DbmzService
{
    protected $api_account;
    protected $sign_key;
    protected $api_url;

    public function __construct()
    {
        $this->api_url = SystemConfig::getValue('dp_api_url') ?? env('DP_API_URL');
        $this->api_account = SystemConfig::getValue('dp_api_account') ?? env('DP_API_ACCOUNT');
        $this->sign_key = SystemConfig::getValue('dp_api_secret') ?? env('DP_API_SECRET');
    }

    private function generateCode(array $params)
    {
        ksort($params);
        $sb = '';
        foreach ($params as $key => $value) {
            if ($value !== null && $value !== '') {
                $sb .= $key . '=' . $value . '&';
            }
        }
        if (strlen($sb) > 0) {
            $sb = rtrim($sb, '&');
        }
        $sb .= $this->sign_key;
        return strtoupper(md5($sb));
    }

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

        $result = json_decode($contents, true);
        if (!$result || !is_array($result)) {
            Log::error('DP接口请求失败', [
                'url' => $url,
                'http_code' => $httpCode,
                'response' => $contents,
            ]);
            return [
                'Code' => -1,
                'Message' => '返回数据解析失败',
                'Data' => null,
            ];
        }

        return $result;
    }

    private function sendJsonRequest($url, $body_data = [], $headers = [])
    {
        $microtime = microtime(true);
        $timestamp = (string)(int)$microtime;
        $microseconds = (int)(($microtime - floor($microtime)) * 1000);
        $microStr = str_pad((string)($microseconds % 1000), 3, '0', STR_PAD_LEFT);
        $randomStr = str_pad((string)rand(0, 999), 3, '0', STR_PAD_LEFT);
        $nonce = $microStr . $randomStr;
        if (strlen($nonce) != 6) {
            $nonce = str_pad((string)rand(0, 999999), 6, '0', STR_PAD_LEFT);
        }

        $signParams = array_merge($body_data, [
            'timestamp' => $timestamp,
            'nonce' => $nonce,
        ]);

        $signature = $this->generateCode($signParams);

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
            Log::error('DP接口请求CURL错误', [
                'url' => $url,
                'curl_error' => $curlError,
            ]);
            return [
                'code' => -1,
                'message' => '请求失败：' . $curlError,
                'data' => null,
            ];
        }

        $result = json_decode($contents, true);
        if (!$result || !is_array($result)) {
            Log::error('DP接口请求失败 - JSON解析失败', [
                'url' => $url,
                'http_code' => $httpCode,
                'response_raw' => $contents,
                'response_length' => strlen($contents),
                'json_error' => json_last_error_msg(),
                'request_body' => $body_data,
                'headers' => $requestHeaders,
            ]);
            return [
                'code' => -1,
                'message' => '返回数据解析失败：' . json_last_error_msg(),
                'data' => null,
                'raw_response' => substr($contents, 0, 500),
            ];
        }

        return $result;
    }

    public function register($userName, $password = '123456', $currency = 'USDT', $lang = 'zh_CN')
    {
        $return = [
            'code' => 200,
            'message' => '成功',
        ];

        if (empty($this->api_url)) {
            $return['code'] = 400;
            $return['message'] = 'DP API URL未配置';
            Log::error('DP API URL未配置');
            return $return;
        }

        $userName = strtolower($userName);

        $bodyData = [
            'userName' => $userName,
            'password' => $password,
            'currency' => $currency,
            'lang' => $lang,
        ];

        $apiUrl = rtrim($this->api_url, '/') . '/member/register/v1';
        $res = $this->sendJsonRequest($apiUrl, $bodyData);
        if (!isset($res['code']) || $res['code'] != 0) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? ($res['Message'] ?? '注册失败');
            Log::error('DP注册失败', [
                'userName' => $userName,
                'request_data' => $bodyData,
                'response' => $res,
            ]);
            return $return;
        }

        return $return;
    }

    public function login($userName, $venueCode = '', $currency = 'USDT', $gameId = 0, $deviceType = 2, $lang = 'zh_CN', $userClientIp = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功',
        ];

        if (empty($this->api_url)) {
            $return['code'] = 400;
            $return['message'] = 'DP API URL未配置';
            Log::error('DP API URL未配置');
            return $return;
        }

        if (empty($venueCode)) {
            $return['code'] = 400;
            $return['message'] = 'venueCode（场馆编码）不能为空';
            Log::error('DP登录参数错误 - venueCode为空', [
                'userName' => $userName,
            ]);
            return $return;
        }

        $userName = strtolower($userName);

        $bodyData = [
            'userName' => $userName,
            'currency' => $currency,
            'venueCode' => $venueCode,
            'deviceType' => $deviceType,
            'lang' => $lang,
        ];

        if ($gameId > 0) {
            $bodyData['gameId'] = $gameId;
        }

        if (!empty($userClientIp)) {
            $bodyData['userClientIp'] = $userClientIp;
        }

        $apiUrl = rtrim($this->api_url, '/') . '/member/getLaunchURL/v1';
        $res = $this->sendJsonRequest($apiUrl, $bodyData);
        if (!isset($res['code']) || $res['code'] != 0) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? ($res['Message'] ?? '获取游戏链接失败');
            Log::error('DP登录失败', [
                'userName' => $userName,
                'venueCode' => $venueCode,
                'gameId' => $gameId,
                'request_data' => $bodyData,
                'response' => $res,
            ]);
            return $return;
        }

        $gameUrl = $res['data']['content'] ?? '';
        if (empty($gameUrl)) {
            $return['code'] = 201;
            $return['message'] = '获取游戏链接失败：响应中未包含游戏链接';
            Log::error('DP登录 - 获取游戏链接失败', [
                'userName' => $userName,
                'venueCode' => $venueCode,
                'gameId' => $gameId,
                'response_data' => $res['data'] ?? null,
                'full_response' => $res,
            ]);
            return $return;
        }

        $return['data'] = $gameUrl;
        $return['traceId'] = $res['traceId'] ?? '';

        return $return;
    }

    public function balance($username)
    {
        $return = [
            'code' => 200,
            'message' => '成功',
        ];

        $data = [
            'username' => $username,
            'api_account' => $this->api_account,
        ];

        $data['code'] = $this->generateCode($data);
        $res = $this->sendRequest($this->api_url . "/api/balance", $data);
        if (!isset($res['Code']) || $res['Code'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['Message'] ?? '查询余额失败';
            Log::error('DP查询余额失败', [
                'username' => $username,
                'response' => $res,
            ]);
            return $return;
        }

        $return['data'] = $res['Data']['balance'] ?? 0;

        return $return;
    }

    public function deposit($username, $amount, $transferno)
    {
        $amount = floor($amount);
        $return = [
            'code' => 200,
            'message' => '成功',
        ];

        $data = [
            'username' => $username,
            'api_account' => $this->api_account,
            'amount' => $amount,
            'transferno' => $transferno,
        ];

        $data['code'] = $this->generateCode($data);
        $res = $this->sendRequest($this->api_url . "/api/deposit", $data);
        if (!isset($res['Code']) || $res['Code'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['Message'] ?? '充值失败';
            Log::error('DP充值失败', [
                'username' => $username,
                'amount' => $amount,
                'transferno' => $transferno,
                'response' => $res,
            ]);
            return $return;
        }

        return $return;
    }

    public function withdrawal($username, $amount, $transferno)
    {
        $amount = floor($amount);
        $return = [
            'code' => 200,
            'message' => '成功',
            ];

        $data = [
            'username' => $username,
            'api_account' => $this->api_account,
            'amount' => $amount,
            'transferno' => $transferno,
        ];

        $data['code'] = $this->generateCode($data);
        $res = $this->sendRequest($this->api_url . "/api/withdrawal", $data);
        if (!isset($res['Code']) || $res['Code'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['Message'] ?? '提现失败';
            Log::error('DP提现失败', [
                'username' => $username,
                'amount' => $amount,
                'transferno' => $transferno,
                'response' => $res,
            ]);
            return $return;
        }

        return $return;
    }

    public function getGameList($venueCode = '', $currency = 'USDT', $pageNum = 0, $pageSize = 10)
    {
        $return = [
            'code' => 200,
            'message' => '成功',
        ];

        $bodyData = [
            'currency' => $currency,
            'venueCode' => $venueCode,
            'pageNum' => $pageNum,
            'pageSize' => $pageSize,
        ];

        if (empty($venueCode)) {
            $return['code'] = 400;
            $return['message'] = 'venueCode（场馆编码）不能为空';
            Log::error('DP获取游戏列表参数错误', [
                'venueCode' => $venueCode,
                'currency' => $currency,
            ]);
            return $return;
        }

        if ($pageSize > 500) {
            $pageSize = 500;
        }

        if (empty($this->api_url)) {
            $return['code'] = 400;
            $return['message'] = 'DP API URL未配置';
            Log::error('DP API URL未配置');
            return $return;
        }

        $apiUrl = rtrim($this->api_url, '/') . '/member/game/list/v1';
        $res = $this->sendJsonRequest($apiUrl, $bodyData);
        if (!isset($res['code']) || $res['code'] != 0) {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? ($res['Message'] ?? '获取游戏列表失败');
            $return['raw_response'] = $res['raw_response'] ?? null;
            Log::error('DP获取游戏列表失败', [
                'venueCode' => $venueCode,
                'currency' => $currency,
                'request_data' => $bodyData,
                'api_url' => $apiUrl,
                'response' => $res,
                'response_code' => $res['code'] ?? 'unknown',
            ]);
            return $return;
        }

        $return['data'] = $res['data'] ?? [];
        $return['traceId'] = $res['traceId'] ?? '';

        return $return;
    }
}
