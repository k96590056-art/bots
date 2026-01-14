<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Dbzhenren 游戏接口类
 * 根据 zhenren API 文档实现
 */
class Dbzhenren
{
    // API 配置参数（固定值）
    protected $game_api_url = 'https://api.zhenren.com';  // 游戏接口地址（gmag_api_url），用于玩家操作、支付等
    protected $gmag_game_data_url = 'https://data-api.zhenren.com';  // 游戏数据接口地址（gmag_game_data_url），用于拉取游戏数据、历史记录等
    protected $brand_id = 1001;  // 代理标识
    protected $secret_key = 'secretKey';  // 密钥，需要根据实际配置修改
    protected $currency = 'CNY';  // 默认币种
    protected $country = 'CN';  // 默认国家编码
    protected $language = 'ZH-CN';  // 默认语言编码

    public function __construct()
    {
        // 如果需要从系统配置读取，可以在这里初始化
        // $this->game_api_url = SystemConfig::getValue('zhenren_game_api_url') ?? $this->game_api_url;
        // $this->gmag_game_data_url = SystemConfig::getValue('zhenren_game_data_url') ?? $this->gmag_game_data_url;
        // $this->brand_id = SystemConfig::getValue('zhenren_brand_id') ?? $this->brand_id;
        // $this->secret_key = SystemConfig::getValue('zhenren_secret_key') ?? $this->secret_key;
    }

    /**
     * 验证 MD5 签名
     * 参考文档中的 checkMD5 方法
     *
     * @param array $data 请求数据（已排除 hash 字段）
     * @param string $hash 请求中的 hash 值
     * @return bool
     */
    private function checkMD5($data, $hash)
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
     * 生成请求签名
     *
     * @param array $data 请求参数（排除 hash）
     * @return string MD5 签名
     */
    private function generateHash($data)
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
        return md5(Str::replaceLast('&', $this->secret_key, $string));
    }

    /**
     * 发送 HTTP POST 请求
     *
     * @param string $url 请求地址
     * @param array $post_data 请求参数
     * @return array
     */
    private function sendRequest($url, $post_data = [])
    {
        // 生成签名
        $hash = $this->generateHash($post_data);
        $post_data['hash'] = $hash;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        $contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Log::error('Dbzhenren接口请求失败', [
                'url' => $url,
                'error' => $error,
                'http_code' => $httpCode
            ]);
            return [
                'error' => 'P_00',
                'message' => 'Server Error: ' . $error
            ];
        }

        $result = json_decode($contents, TRUE);
        
        if (!$result || !is_array($result)) {
            Log::error('Dbzhenren接口返回数据解析失败', [
                'url' => $url,
                'http_code' => $httpCode,
                'response' => $contents
            ]);
            return [
                'error' => 'P_00',
                'message' => '返回数据解析失败'
            ];
        }

        return $result;
    }

    /**
     * 注册玩家
     * 参考 IndexController 中的调用方式：$service->register($api_code, $user->username)
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

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        $data = [
            'requestId' => $request_id,
            'brandId' => $this->brand_id,
            'playerId' => $username,
            'currency' => $this->currency,
            'country' => $this->country,
            'language' => $this->language,
        ];

        $url = $this->game_api_url . '/player/create';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '注册失败';
            Log::error('Dbzhenren注册失败', [
                'username' => $username,
                'response' => $res
            ]);
            return $return;
        }

        Log::info('Dbzhenren注册成功', [
            'username' => $username,
            'response' => $res
        ]);

        return $return;
    }

    /**
     * 登录获取游戏令牌
     * 参考 IndexController 中的调用方式：$service->login($user->username, $api_code, $leixing, $is_mobile_url, $gameCode)
     * 
     * @param string $username 玩家用户名（第一个参数）
     * @param string $api_code 平台代码（第二个参数）
     * @param string $game_type 游戏类型（第三个参数，可选）
     * @param int $is_mobile 是否手机端（第四个参数，0=PC，1=手机）
     * @param string $game_code 游戏代码（第五个参数，可选）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息', 'data' => '游戏URL或令牌']
     */
    public function login($username, $api_code = '', $game_type = '1', $is_mobile = 1, $game_code = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        // 第一步：获取令牌
        $data = [
            'requestId' => $request_id,
            'brandId' => $this->brand_id,
            'playerId' => $username,
        ];

        $url = $this->game_api_url . '/player/getToken';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '获取令牌失败';
            Log::error('Dbzhenren获取令牌失败', [
                'username' => $username,
                'response' => $res
            ]);
            return $return;
        }

        $token = $res['token'] ?? '';

        if (empty($token)) {
            $return['code'] = 201;
            $return['message'] = '获取令牌失败：令牌为空';
            return $return;
        }

        // 返回令牌，实际使用时可能需要构建游戏URL
        // 根据文档，登录后应该返回游戏URL，这里返回令牌供后续使用
        $return['data'] = $token;
        $return['token'] = $token;

        Log::info('Dbzhenren登录成功', [
            'username' => $username,
            'has_token' => !empty($token)
        ]);

        return $return;
    }

    /**
     * 查询玩家余额
     * 参考调用方式：$tg->balance($api_code, $user->username)
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

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        $data = [
            'requestId' => $request_id,
            'brandId' => $this->brand_id,
            'playerId' => $username,
        ];

        $url = $this->game_api_url . '/player/balance';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '查询余额失败';
            Log::error('Dbzhenren查询余额失败', [
                'username' => $username,
                'response' => $res
            ]);
            return $return;
        }

        $balance = $res['balance'] ?? 0;
        $return['data'] = $balance;

        return $return;
    }

    /**
     * 玩家上分（转入游戏）
     * 参考 PayController 中的 deposit 调用方式：$tg->deposit($user->username, $amount, $order_no, $data['pay_way'])
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

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);
        
        // 金额格式处理，舍弃末尾多余的0
        $amount = rtrim(rtrim(sprintf('%.4f', $amount), '0'), '.');
        
        // 如果金额为0或负数，需要特殊处理
        if ($amount <= 0) {
            $return['code'] = 201;
            $return['message'] = '上分金额必须大于0';
            return $return;
        }

        $data = [
            'requestId' => $request_id,
            'brandId' => $this->brand_id,
            'playerId' => $username,
            'currency' => $this->currency,
            'amount' => $amount,
            'extTransId' => $ext_trans_id,
        ];

        $url = $this->game_api_url . '/payment/player/deposit';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '上分失败';
            Log::error('Dbzhenren上分失败', [
                'username' => $username,
                'amount' => $amount,
                'ext_trans_id' => $ext_trans_id,
                'response' => $res
            ]);
            return $return;
        }

        // 返回交易信息
        $return['data'] = [
            'transId' => $res['transId'] ?? '',
            'extTransId' => $res['extTransId'] ?? $ext_trans_id,
            'status' => $res['status'] ?? 'approved',
            'balance' => $res['balance'] ?? 0,
        ];

        Log::info('Dbzhenren上分成功', [
            'username' => $username,
            'amount' => $amount,
            'ext_trans_id' => $ext_trans_id,
            'trans_id' => $res['transId'] ?? ''
        ]);

        return $return;
    }

    /**
     * 玩家下分（转出游戏）
     * 参考 PayController 中的 withdrawal 调用方式：$tg->withdrawal($user->username, $amount, $order_no, $data['pay_way'])
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

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);
        
        // 金额格式处理，舍弃末尾多余的0
        $amount = rtrim(rtrim(sprintf('%.4f', $amount), '0'), '.');
        
        // 如果金额为0或负数，需要特殊处理
        if ($amount <= 0) {
            $return['code'] = 201;
            $return['message'] = '下分金额必须大于0';
            return $return;
        }

        $data = [
            'requestId' => $request_id,
            'brandId' => $this->brand_id,
            'playerId' => $username,
            'currency' => $this->currency,
            'amount' => $amount,
            'extTransId' => $ext_trans_id,
        ];

        $url = $this->game_api_url . '/payment/player/withdrawal';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '下分失败';
            Log::error('Dbzhenren下分失败', [
                'username' => $username,
                'amount' => $amount,
                'ext_trans_id' => $ext_trans_id,
                'response' => $res
            ]);
            return $return;
        }

        // 返回交易信息
        $return['data'] = [
            'transId' => $res['transId'] ?? '',
            'extTransId' => $res['extTransId'] ?? $ext_trans_id,
            'status' => $res['status'] ?? 'approved',
            'balance' => $res['balance'] ?? 0,
            'amount' => $res['amount'] ?? $amount,  // 实际下分金额
        ];

        Log::info('Dbzhenren下分成功', [
            'username' => $username,
            'amount' => $res['amount'] ?? $amount,
            'ext_trans_id' => $ext_trans_id,
            'trans_id' => $res['transId'] ?? ''
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

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        $data = [
            'requestId' => $request_id,
            'brandId' => $this->brand_id,
            'extTransId' => $ext_trans_id,
        ];

        $url = $this->game_api_url . '/payment/player/checkTrans';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '查询交易失败';
            return $return;
        }

        $return['data'] = $res;
        return $return;
    }
}
