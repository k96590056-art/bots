<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Dianzi 游戏接口类
 * 根据 dianzi API 文档实现
 */
class DbdianziService
{
    // API 配置参数（固定值）
    protected $game_api_url = 'https://api-stg.gmgiantgold.com';  // 游戏接口地址（gmag_api_url），用于玩家操作、支付等
    protected $gmag_game_data_url = 'http://gm-stage-data.gmgiantgold.com/history';  // 游戏数据接口地址（gmag_game_data_url），用于拉取游戏数据、历史记录等
    protected $gmag_game_launch_url = 'https://api-stg.gmgiantgold.com';  // 游戏启动地址（gmag_game_launch_url），用于生成游戏链接
    protected $brand_id = 1369;  // 代理标识
    protected $secret_key = 'DjTQo3w3sGCju6WFfOLu';  // 密钥，需要根据实际配置修改
    protected $currency = 'CNY';  // 默认币种
    protected $country = 'CN';  // 默认国家编码
    protected $language = 'ZH-CN';  // 默认语言编码

    public function __construct()
    {
        // 如果需要从系统配置读取，可以在这里初始化
        // $this->game_api_url = SystemConfig::getValue('dianzi_game_api_url') ?? $this->game_api_url;
        // $this->gmag_game_data_url = SystemConfig::getValue('dianzi_game_data_url') ?? $this->gmag_game_data_url;
        // $this->gmag_game_launch_url = SystemConfig::getValue('dianzi_game_launch_url') ?? $this->gmag_game_launch_url;
        // $this->brand_id = SystemConfig::getValue('dianzi_brand_id') ?? $this->brand_id;
        // $this->secret_key = SystemConfig::getValue('dianzi_secret_key') ?? $this->secret_key;
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
     * 生成游戏链接 hash（用于防止玩家手动更改游戏代码）
     * hash 生成规则：MD5(brandId+playerId+gameCode+SecretKey)
     *
     * @param string $player_id 玩家ID
     * @param string $game_code 游戏代码
     * @return string
     */
    private function generateGameHash($player_id, $game_code)
    {
        return md5($this->brand_id . $player_id . $game_code . $this->secret_key);
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
        // hash 放到 URL 后面（不放入 POST 参数）
        $url .= (strpos($url, '?') === false ? '?' : '&') . 'hash=' . urlencode($hash);

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
            Log::error('Dianzi接口请求失败', [
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
            Log::error('Dianzi接口返回数据解析失败', [
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
     * 发送 HTTP GET 请求
     *
     * @param string $url 请求地址
     * @return string|false
     */
    private function sendGetRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        $contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Log::error('Dianzi GET请求失败', [
                'url' => $url,
                'error' => $error,
                'http_code' => $httpCode
            ]);
            return false;
        }

        return $contents;
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
            Log::error('Dianzi注册失败', [
                'username' => $username,
                'response' => $res
            ]);
            return $return;
        }

        return $return;
    }

    /**
     * 登录获取游戏令牌并生成游戏URL
     * 参考 IndexController 中的调用方式：$service->login($user->username, $api_code, $leixing, $is_mobile_url, $gameCode)
     * 
     * @param string $username 玩家用户名（第一个参数）
     * @param string $api_code 平台代码（第二个参数）
     * @param string $game_type 游戏类型（第三个参数，可选）
     * @param int $is_mobile 是否手机端（第四个参数，0=PC，1=手机）
     * @param string $game_code 游戏代码（第五个参数，可选）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息', 'data' => '游戏URL']
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
            Log::error('Dianzi获取令牌失败', [
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

        // 第二步：生成游戏URL
        // 如果没有指定游戏代码，使用 lobby（大厅）
        $game_code = !empty($game_code) ? $game_code : 'lobby';
        
        // 确定平台类型
        $platform = $is_mobile ? 'mobile' : 'web';
        
        // 构建游戏链接参数
        $launch_params = [
            'gameCode' => $game_code,
            'token' => $token,
            'platform' => $platform,
            'language' => $this->language,
            'playerId' => $username,
            'brandId' => $this->brand_id,
            'mode' => 1, // 1 = 真钱
            'currency' => $this->currency,
        ];

        // 生成 hash（用于防止玩家手动更改游戏代码）
        $launch_params['hash'] = $this->generateGameHash($username, $game_code);

        // 第二步：生成游戏URL
        // 使用 POST 方式获取游戏URL（/launcher/getUrl）
        // 注意：该接口返回的是 text/plain，不是 JSON
        $launch_url = $this->gmag_game_launch_url . '/launcher/getUrl';
        
        // 生成签名
        $hash = $this->generateHash($launch_params);
        $launch_params['hash'] = $hash;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $launch_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($launch_params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: text/plain'
        ]);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        $game_url = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // POST 方式返回的是纯文本URL
        if (!$error && is_string($game_url) && !empty($game_url) && strpos(trim($game_url), 'http') === 0) {
            $return['data'] = trim($game_url);
            $return['token'] = $token;
            return $return;
        }

        // 如果 POST 失败或返回的不是有效URL，尝试使用 GET 方式
        $get_params = $launch_params;
        unset($get_params['hash']); // GET 方式不需要 hash
        $get_url = $this->gmag_game_launch_url . '/launcher?' . http_build_query($get_params);
        $game_url_get = $this->sendGetRequest($get_url);
        
        if ($game_url_get !== false && is_string($game_url_get) && !empty($game_url_get) && strpos(trim($game_url_get), 'http') === 0) {
            $return['data'] = trim($game_url_get);
            $return['token'] = $token;
            return $return;
        } else {
            $return['code'] = 201;
            $return['message'] = '获取游戏URL失败';
            Log::error('Dianzi获取游戏URL失败', [
                'username' => $username,
                'game_code' => $game_code,
                'post_response' => $game_url,
                'get_response' => $game_url_get,
                'error' => $error
            ]);
            return $return;
        }

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
            Log::error('Dianzi查询余额失败', [
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
            Log::error('Dianzi上分失败', [
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
            Log::error('Dianzi下分失败', [
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

    /**
     * 拉取游戏记录（游戏报表）
     * 使用游戏数据接口地址
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
            'message' => '成功'
        ];

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        $data = [
            'requestId' => $request_id,
            'brandId' => $this->brand_id,
            'startTime' => $start_time,
            'endTime' => $end_time,
        ];

        if (!empty($player_id)) {
            $data['playerId'] = $player_id;
        }

        if (!empty($currency)) {
            $data['currency'] = $currency;
        }

        if (!empty($game_code)) {
            $data['gameCode'] = $game_code;
        }

        $url = $this->gmag_game_data_url . '/report/game';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '拉取游戏记录失败';
            Log::error('Dianzi拉取游戏记录失败', [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'response' => $res
            ]);
            return $return;
        }

        $return['data'] = $res['reports'] ?? [];
        return $return;
    }

    /**
     * 获取游戏历史记录（单个注单）
     * 使用游戏数据接口地址
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
        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => []
        ];

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        $data = [
            'requestId' => $request_id,
            'brandId' => $this->brand_id,
            'startTime' => $start_time,
            'endTime' => $end_time,
            'page' => $page,
            'limit' => $limit,
        ];

        if (!empty($player_id)) {
            $data['playerId'] = $player_id;
        }

        if (!empty($game_code)) {
            $data['gameCode'] = $game_code;
        }

        $url = $this->gmag_game_data_url . '/history/game';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '拉取游戏历史记录失败';
            Log::error('Dianzi拉取游戏历史记录失败', [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'response' => $res
            ]);
            return $return;
        }

        $return['data'] = $res['data'] ?? [];
        $return['total'] = $res['total'] ?? 0;
        $return['page'] = $res['page'] ?? $page;
        $return['limit'] = $res['limit'] ?? $limit;
        return $return;
    }
}
