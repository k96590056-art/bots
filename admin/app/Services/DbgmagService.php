<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Dbgmag 游戏接口类
 * 根据 cmag.md 文档和 Dbgmag API 文档实现
 * 
 * 打开游戏流程（根据 cmag.md）：
 * 1. 玩家登录代理网站，点击某游戏
 * 2. 代理生成启动游戏令牌（token）
 * 3. 代理使用令牌调用 /launcher 或 /launcher/getUrl，请求打开游戏
 * 4. GM-Ag 调用代理的 /auth 接口，验证令牌是否有效
 * 5. 代理验证令牌有效性，返回玩家详细信息
 * 6. GM-Ag 给玩家返回有效内容，玩家进行游戏
 */
class DbgmagService
{
    // API 配置参数（固定值）
    protected $game_api_url = 'https://api-stg.gmgiantgold.com';  // 游戏接口地址（gmag_api_url），用于玩家操作、支付等
    protected $gmag_game_data_url = 'http://gm-stage-data.gmgiantgold.com';  // 游戏数据接口地址（gmag_game_data_url），用于拉取游戏数据、历史记录等
    protected $gmag_game_launch_url = 'https://api-stg.gmgiantgold.com';  // 游戏启动地址（gmag_game_launch_url），用于生成游戏链接
    protected $brand_id = 1373;  // 代理标识
    protected $secret_key = 'G6LsgCjhwfHNRImKOQZW';  // 密钥，需要根据实际配置修改
    protected $currency = 'CNY';  // 默认币种
    protected $country = 'CN';  // 默认国家编码
    protected $language = 'ZH-CN';  // 默认语言编码
    protected $err = ["所属产品"=>"DBGMAG集成"];

    public function __construct()
    {
        // 如果需要从系统配置读取，可以在这里初始化
        // $this->game_api_url = SystemConfig::getValue('Dbgmag_game_api_url') ?? $this->game_api_url;
        // $this->gmag_game_data_url = SystemConfig::getValue('Dbgmag_game_data_url') ?? $this->gmag_game_data_url;
        // $this->gmag_game_launch_url = SystemConfig::getValue('Dbgmag_game_launch_url') ?? $this->gmag_game_launch_url;
        // $this->brand_id = SystemConfig::getValue('Dbgmag_brand_id') ?? $this->brand_id;
        // $this->secret_key = SystemConfig::getValue('Dbgmag_secret_key') ?? $this->secret_key;
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
    private function generateHash($data, $is_log = false)
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
        $str = Str::replaceLast('&', $this->secret_key, $string);
        $md5 = md5($str);
        if($is_log){
            Log::error('Dbgmag hash加密前字符串', [
                'string'=>$string,
                'str'=>$str,
            ]);
            Log::error('Dbgmag hash加密后字符串', [
                'md5'=>$md5,
            ]);
        }
        return $md5;
    }

    /**
     * 生成游戏链接 hash（用于防止玩家手动更改游戏代码）
     * 根据 cmag.md 文档：hash 生成规则 MD5(brandId+playerId+gameCode+SecretKey)
     * 如果 hash 不匹配则返回"禁止切换游戏"错误提示
     *
     * @param string $player_id 玩家ID
     * @param string $game_code 游戏代码
     * @return string MD5 hash值
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
    private function sendRequest($url, $post_data = [], $is_log = false)
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
        if($is_log){
            Log::error('Dbgmag接口请求详情', [
                'url' => $url,
                'post_data' => $post_data,
                'contents' => $contents,
                'http_code' => $httpCode,
                'error' => $error
            ]);
        }
        if ($error) {
            Log::error('Dbgmag接口请求失败', [
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
            Log::error('Dbgmag接口返回数据解析失败', [
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
            Log::error('Dbgmag GET请求失败', [
                'url' => $url,
                'error' => $error,
                'http_code' => $httpCode
            ]);
            return false;
        }

        return $contents;
    }

    /**
     * 获取 GMAG 游戏数据域名的“根地址”
     * - 文档要求 game/list 必须走专用域名 gmag_game_data_url（不带 /history 路径）
     * - 兼容当前配置里可能写成了 .../history 的情况：这里自动裁掉尾部 /history
     */
    private function getGmagGameDataBaseUrl(): string
    {
        $url = rtrim((string) $this->gmag_game_data_url, '/');
        // 兼容：若配置为 http(s)://xxx/history，则返回 http(s)://xxx
        if (preg_match('#/history$#i', $url)) {
            $url = preg_replace('#/history$#i', '', $url);
        }
        return $url;
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
            Log::error('Dbgmag注册失败', [
                'username' => $username,
                'response' => $res
            ]);
            return $return;
        }

        return $return;
    }

    /**
     * 登录获取游戏令牌并生成游戏URL
     * 根据 cmag.md 文档实现
     * 参考 IndexController 中的调用方式：$service->login($user->username, $api_code, $is_mobile_url, $gameCode)
     * 
     * 流程：
     * 1. 获取游戏令牌（token）
     * 2. 使用令牌调用 /launcher 或 /launcher/getUrl 生成游戏链接
     * 
     * @param string $username 玩家用户名（第一个参数）
     * @param string $api_code 平台代码（第二个参数）
     * @param int $is_mobile 是否手机端（第三个参数，0=PC，1=手机，2=默认mobile）
     * @param string $game_code 游戏代码（第四个参数，可选，默认lobby）
     * @param string $game_type 游戏类型（第五个参数，可选，用于兼容）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息', 'data' => '游戏URL', 'token' => '令牌']
     */
    public function login($username, $api_code = '', $is_mobile = 2, $game_code = '', $game_type = '1')
    {
        $return = [
            'code' => 200,
            'message' => '成功'
        ];

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        // 第一步：获取令牌（token）
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
            Log::error('Dbgmag获取令牌失败', [
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

        // 将token和用户的映射关系存储到缓存中，供auth回调使用
        // 缓存有效期：2小时（游戏会话通常不会超过2小时）
        Cache::put('cmag_token_' . $token, [
            'username' => $username,
            'api_code' => $api_code,
            'created_at' => now()->toDateTimeString()
        ], 7200); // 2小时 = 7200秒

        // 第二步：生成游戏URL
        // 如果没有指定游戏代码，使用 lobby（大厅）
        $game_code = !empty($game_code) ? $game_code : 'lobby';
        
        // 确定平台类型：web, mobile, download
        // $is_mobile: 0=PC(web), 1=手机(mobile), 2=默认mobile
        $platform = ($is_mobile == 0) ? 'web' : 'mobile';
        
        // 构建游戏链接参数（根据 cmag.md 文档）
        $launch_params = [
            'gameCode' => $game_code,
            'token' => $token,
            'platform' => $platform,
            'language' => $this->language,
            'playerId' => $username,
            'brandId' => $this->brand_id,
            'mode' => 1, // 1 = 真钱，0 = 免费试玩，2 = 游客
            'currency' => $this->currency,
        ];

        // 生成 hash（用于防止玩家手动更改游戏代码）
        // hash 生成规则：MD5(brandId+playerId+gameCode+SecretKey)
        $launch_params['hash'] = $this->generateGameHash($username, $game_code);

        // 方式二：使用 POST 方式获取游戏URL（/launcher/getUrl）
        // 该接口返回的是 text/plain，不是 JSON
        $game_url = $this->getGameUrlByPost($launch_params);
        
        if ($game_url !== false) {
            $return['data'] = $game_url;
            $return['token'] = $token;
            return $return;
        }

        // 方式一：如果 POST 失败，尝试使用 GET 方式（/launcher）
        // GET 方式直接返回游戏内容或重定向
        $game_url = $this->getGameUrlByGet($launch_params);
        
        if ($game_url !== false) {
            $return['data'] = $game_url;
            $return['token'] = $token;
            return $return;
        }

        // 两种方式都失败
        $return['code'] = 201;
        $return['message'] = '获取游戏URL失败';
        Log::error('Dbgmag获取游戏URL失败', [
            'username' => $username,
            'game_code' => $game_code,
            'platform' => $platform,
            'token' => $token
        ]);
        return $return;
    }

    /**
     * 方式二：使用 POST 方式获取进入游戏链接
     * URI: https://{{gmag_game_launch_url}}/launcher/getUrl
     * Method: POST
     * Content-Type: application/json
     * Response: text/plain;charset=UTF-8
     * 
     * 参数说明（根据 cmag.md）：
     * - gameCode: 游戏编码（必选）
     * - token: 启动游戏的令牌（必选）
     * - platform: 设备平台 web/mobile/download（必选）
     * - language: 游戏屏幕显示语言（必选）
     * - playerId: 玩家的唯一标识（必选）
     * - brandId: 代理的唯一标识（必选）
     * - mode: 打开方式 0=免费试玩, 1=真钱, 2=游客（可选，默认1）
     * - currency: 在游戏中使用的货币（必选，新增于2023/12/12）
     * - hash: 防止玩家手动更改游戏代码（可选，新增于2025/12/03）
     * - tableAlias: 用于真人游戏，指定游戏打开的桌牌号码（可选）
     * - backUrl: 打开游戏失败时，重定向的大厅链接（可选，需要URL编码）
     * - cashierUrl: 代理网站的玩家存款页面（可选，需要URL编码）
     * 
     * @param array $launch_params 游戏启动参数
     * @return string|false 游戏URL或false
     */
    private function getGameUrlByPost($launch_params)
    {
        $launch_url = $this->gmag_game_launch_url . '/launcher/getUrl';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $launch_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($launch_params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: text/plain;charset=UTF-8'
        ]);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        $game_url = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        $this->err["提交地址"] = $launch_url;
        $this->err["提交参数"] = $launch_params;
        $this->err["返回参数"] = $game_url;
        $this->err["HTTP状态码"] = $httpCode;
        Log::info('Dbgmag POST方式获取游戏URL', $this->err);

        // 检查响应：成功返回游戏URL（以http开头），失败返回错误信息或重定向URL
        if (!$error && is_string($game_url) && !empty($game_url)) {
            $game_url = trim($game_url);
            // 成功：返回的是游戏URL（以http开头）
            if (strpos($game_url, 'http') === 0) {
                return $game_url;
            }
            // 失败：可能包含错误信息，但如果不是URL格式，返回false让GET方式尝试
            if (strpos($game_url, 'error') !== false || strpos($game_url, 'message') !== false) {
                Log::warning('Dbgmag POST方式返回错误', ['response' => $game_url]);
            }
        }

        return false;
    }

    /**
     * 方式一：使用 GET 方式拼装游戏链接（直接进入游戏）
     * URI: https://{{gmag_game_launch_url}}/launcher
     * Method: GET
     * 
     * 目的：代理使用自己系统生成的游戏令牌和参数，生成指定游戏的链接，用于直接在浏览器访问
     * 
     * 注意：
     * - GET方式会直接返回游戏内容或重定向到backUrl（如果失败）
     * - 失败时会在backUrl后附加error和message参数
     * - 这里返回完整的URL供前端直接访问
     * 
     * @param array $launch_params 游戏启动参数（与POST方式相同）
     * @return string|false 游戏URL或false
     */
    private function getGameUrlByGet($launch_params)
    {
        // GET 方式：hash 参数需要包含在URL中
        // 但根据文档，hash 是用于防止玩家手动更改游戏代码的，应该包含在参数中
        $get_params = $launch_params;
        
        // 构建GET请求URL
        $get_url = $this->gmag_game_launch_url . '/launcher?' . http_build_query($get_params);
        
        // GET方式会直接返回游戏内容或重定向，这里返回完整URL供前端直接访问
        // 注意：GET方式可能不会返回URL文本，而是直接返回游戏内容
        // 所以这里返回构建好的URL，让前端直接访问
        Log::info('Dbgmag GET方式构建游戏URL', [
            'url' => $get_url,
            'params' => $get_params
        ]);
        
        return $get_url;
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
            Log::error('Dbgmag查询余额失败', [
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
            Log::error('Dbgmag上分失败', [
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
            Log::error('Dbgmag下分失败', [
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
     * 拉取游戏报表（游戏统计报表）
     * 根据 cmag.md 文档：URI: https://{{gmag_game_data_url}}/history/gameReport
     * 方式：POST
     * 
     * 目的：用于拉取已经结算游戏的统计报表。未完成结算的游戏不会被统计在报表中。
     * 报表一次拉取的时间跨度不能大于31天。在系统中，只有最近6个月内的报表数据可用。
     * 
     * @param string $start_time 开始时间，格式：YYYY-MM-DD HH:mm:00（GMT+0）
     * @param string $end_time 结束时间，格式：YYYY-MM-DD HH:mm:00（GMT+0），endTime - startTime 不能大于1天
     * @param string $player_id 玩家ID（可选）
     * @param string $currency 币种（可选）
     * @param string $game_code 游戏代码（可选）
     * @param string $report_by 汇总方式（可选）：gameCode-按游戏汇总, provider-按供应商汇总, player-按玩家汇总
     * @return array ['code' => 200/201, 'message' => '成功/错误信息', 'data' => []]
     */
    public function getGameReport($start_time, $end_time, $player_id = '', $currency = '', $game_code = '', $report_by = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => []
        ];

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        $data = [
            'requestId' => $request_id,
            'brandId' => (string) $this->brand_id,
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

        if (!empty($report_by)) {
            $data['reportBy'] = $report_by;
        }

        $url = $this->getGmagGameDataBaseUrl() . '/history/gameReport';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '拉取游戏报表失败';
            Log::error('Dbgmag拉取游戏报表失败', [
                'url' => $url,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'response' => $res
            ]);
            return $return;
        }

        $return['data'] = $res['data'] ?? [];
        return $return;
    }

    /**
     * 获取游戏历史记录（已结算的游戏历史数据）
     * 根据 cmag.md 文档：URI: https://{{gmag_game_data_url}}/history/game
     * 方式：POST
     * 
     * 目的：用于根据游戏结算时间获取玩家已经结算了的游戏历史数据，如果玩家某一局游戏未结算，将无法拉取到。
     * 拉取的最长时间段为30分钟。最近30天的游戏记录为可访问记录。
     * 在API的响应中，游戏历史的最大条数为10,000条。
     * 
     * @param string $start_time 开始时间，格式：YYYY-MM-DD HH:mm:00（GMT+0），秒数值固定为00
     * @param string $end_time 结束时间，格式：YYYY-MM-DD HH:mm:00（GMT+0），endTime - startTime 必须小于 30 分钟
     * @param string $player_id 玩家ID（可选）
     * @param string $game_code 游戏代码（可选）
     * @param string $provider_code 游戏供应商编码（可选）
     * @param string $currency 币种（可选）
     * @param string $round_id 回合标识（可选）
     * @param int $page 页码（可选，默认1）
     * @param int $size 每页数量（可选，默认5000，最大10000）
     * @param int $show_all 是否包含子代理（可选，1-包含，0-不包含，默认0）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息', 'data' => [], 'total' => 0, 'pages' => 0, 'size' => 0, 'current' => 0]
     */
    public function getGameHistory($start_time, $end_time, $player_id = '', $game_code = '', $provider_code = '', $currency = '', $round_id = '', $page = 1, $size = 5000, $show_all = 0)
    {
        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => [],
            'total' => 0,
            'pages' => 0,
            'size' => 0,
            'current' => 0
        ];

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        $data = [
            'requestId' => $request_id,
            'brandId' => (string) $this->brand_id,
            'startTime' => $start_time,
            'endTime' => $end_time,
            'page' => (int) ($page ?: 1),
            'size' => (int) ($size ?: 5000),
        ];

        if (!empty($player_id)) {
            $data['playerId'] = $player_id;
        }

        if (!empty($game_code)) {
            $data['gameCode'] = $game_code;
        }

        if (!empty($provider_code)) {
            $data['providerCode'] = $provider_code;
        }

        if (!empty($currency)) {
            $data['currency'] = $currency;
        }

        if (!empty($round_id)) {
            $data['roundId'] = $round_id;
        }

        if ($show_all == 1) {
            $data['showAll'] = 1;
        }

        $url = $this->getGmagGameDataBaseUrl() . '/history/game';
        $res = $this->sendRequest($url, $data);
        
        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '拉取游戏历史记录失败';
            Log::error('Dbgmag拉取游戏历史记录失败', [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'response' => $res
            ]);
            return $return;
        }

        $return['data'] = $res['records'] ?? [];
        $return['total'] = $res['total'] ?? 0;
        $return['pages'] = $res['pages'] ?? 0;
        $return['size'] = $res['size'] ?? ($data['size'] ?? 5000);
        $return['current'] = $res['current'] ?? ($data['page'] ?? 1);
        return $return;
    }

    /**
     * 拉取 GMAG 游戏列表（game/list）
     * 根据 cmag.md 文档：URI: https://{{gmag_game_data_url}}/game/list
     * 方式：POST
     * 
     * 目的：用于搜索GMAG中的游戏列表，查询游戏的详细信息
     * 代理调用gameList 方法来查询游戏信息，可以对 providerCode, gameType, gameCode 等字段进行查询
     * 
     * @param string $providerCode 游戏供应商编码（可选）
     * @param string $gameType 游戏类型（可选，如 slots/table/live/arcade/sport/esport/lotto/poker/bingo/other）
     * @param string $gameCode 游戏唯一编码（可选）
     * @param int $page 页码（默认 1）
     * @param int $size 每页数量（默认 100）
     * @param string $displayLanguage 显示语言（可选，OneAPI 使用，GMAG 不使用）
     * @param string $currency 币种（可选，OneAPI 使用，GMAG 不使用）
     * @return array ['code'=>200/201,'message'=>...,'data'=>records,'total'=>...,'pages'=>...,'size'=>...,'current'=>...]
     */
    public function getGameList($providerCode = '', $gameType = '', $gameCode = '', $page = 1, $size = 100, $displayLanguage = '', $currency = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => [],
        ];

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        $data = [
            'requestId' => $request_id,
            'brandId' => (string) $this->brand_id,
            'page' => (int) ($page ?: 1),
            'size' => (int) ($size ?: 100),
        ];

        if (is_string($providerCode) && trim($providerCode) !== '') {
            $data['providerCode'] = trim($providerCode);
        }
        if (is_string($gameType) && trim($gameType) !== '') {
            $data['gameType'] = trim($gameType);
        }
        if (is_string($gameCode) && trim($gameCode) !== '') {
            $data['gameCode'] = trim($gameCode);
        }

        // 必须使用专用游戏数据域名（gmag_game_data_url）
        $url = $this->getGmagGameDataBaseUrl() . '/game/list';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && (string) $res['error'] !== '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '拉取游戏列表失败';
            Log::error('Dbgmag拉取游戏列表失败', [
                'providerCode' => $providerCode,
                'gameType' => $gameType,
                'gameCode' => $gameCode,
                'page' => $page,
                'size' => $size,
                'response' => $res,
            ]);
            return $return;
        }

        $return['data'] = $res['records'] ?? [];
        $return['total'] = $res['total'] ?? 0;
        $return['pages'] = $res['pages'] ?? 0;
        $return['size'] = $res['size'] ?? ($data['size'] ?? 100);
        $return['current'] = $res['current'] ?? ($data['page'] ?? 1);

        return $return;
    }

    /**
     * 拉取游戏交易信息（gameTrans）
     * 根据 cmag.md 文档：URI: https://{{gmag_game_data_url}}/history/gameTrans
     * 方式：POST
     * 
     * 目的：用于根据交易产生时间获取玩家游戏中发生的交易记录，拉取的最长时间段为15分钟。
     * 代理调用 gameTrans 命令的时长最小单位为分钟。最近15天的游戏交易记录为可访问记录，超过30天的记录不能被拉取到。
     * 在API的响应中，游戏交易的最大条数为10,000条。
     * 
     * @param string $start_time 开始时间，格式：YYYY-MM-DD HH:mm:00（GMT+0），秒数值固定为00
     * @param string $end_time 结束时间，格式：YYYY-MM-DD HH:mm:00（GMT+0），endTime - startTime 必须小于 15 分钟
     * @param string $player_id 玩家ID（可选）
     * @param string $provider_code 游戏供应商编码（可选）
     * @param string $currency 币种（可选）
     * @param int $page 页码（可选，默认1）
     * @param int $size 每页数量（可选，默认5000）
     * @param int $show_all 是否包含子代理（可选，1-包含，0-不包含，默认0）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息', 'data' => [], 'total' => 0, 'pages' => 0, 'size' => 0, 'current' => 0]
     */
    public function getGameTrans($start_time, $end_time, $player_id = '', $provider_code = '', $currency = '', $page = 1, $size = 5000, $show_all = 0)
    {
        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => [],
            'total' => 0,
            'pages' => 0,
            'size' => 0,
            'current' => 0
        ];

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        $data = [
            'requestId' => $request_id,
            'brandId' => (string) $this->brand_id,
            'startTime' => $start_time,
            'endTime' => $end_time,
            'page' => (int) ($page ?: 1),
            'size' => (int) ($size ?: 5000),
        ];

        if (!empty($player_id)) {
            $data['playerId'] = $player_id;
        }

        if (!empty($provider_code)) {
            $data['providerCode'] = $provider_code;
        }

        if (!empty($currency)) {
            $data['currency'] = $currency;
        }

        if ($show_all == 1) {
            $data['showAll'] = 1;
        }

        $url = $this->getGmagGameDataBaseUrl() . '/history/gameTrans';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '拉取游戏交易信息失败';
            Log::error('Dbgmag拉取游戏交易信息失败', [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'response' => $res
            ]);
            return $return;
        }

        $return['data'] = $res['records'] ?? [];
        $return['total'] = $res['total'] ?? 0;
        $return['pages'] = $res['pages'] ?? 0;
        $return['size'] = $res['size'] ?? ($data['size'] ?? 5000);
        $return['current'] = $res['current'] ?? ($data['page'] ?? 1);
        return $return;
    }

    /**
     * 拉取游戏详情链接（roundDetail）
     * 根据 cmag.md 文档：URI: https://{{gmag_game_data_url}}/history/roundDetail
     * 方式：POST
     * 
     * 目的：用于获取某一局对局游戏详情的链接，查询游戏对局详细信息
     * 备注：并非所有游戏供应商都会提供该功能，没有提供会返回"No Data"
     * 
     * @param string $round_id 回合标识（必选）
     * @param string $provider_code 供应商代码（必选）
     * @param string $end_time 结束时间，格式：YYYY-MM-DD HH:mm:ss（GMT+0），对应 GameHistory 中的参数 'endTime'
     * @param string $language 游戏详情需要使用的语言（可选，并非所有供应商都会支持）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息', 'data' => '游戏详情链接']
     */
    public function getRoundDetail($round_id, $provider_code, $end_time, $language = '')
    {
        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => ''
        ];

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        $data = [
            'requestId' => $request_id,
            'brandId' => (string) $this->brand_id,
            'roundId' => $round_id,
            'providerCode' => $provider_code,
            'endTime' => $end_time,
        ];

        if (!empty($language)) {
            $data['language'] = $language;
        }

        $url = $this->getGmagGameDataBaseUrl() . '/history/roundDetail';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '拉取游戏详情链接失败';
            Log::error('Dbgmag拉取游戏详情链接失败', [
                'round_id' => $round_id,
                'provider_code' => $provider_code,
                'response' => $res
            ]);
            return $return;
        }

        $return['data'] = $res['data'] ?? '';
        return $return;
    }

    /**
     * 拉取游戏额外奖励交易信息（extraTrans）
     * 根据 cmag.md 文档：URI: https://{{gmag_game_data_url}}/history/extraTrans
     * 方式：POST
     * 
     * 目的：用于根据交易产生时间获取玩家的交易记录(推广活动/ 锦标赛)
     * 在API的响应中，游戏交易的最大条数为10,000条。
     * 
     * @param string $start_time 开始时间，格式：YYYY-MM-DD HH:mm:00（GMT+0），秒数值固定为00
     * @param string $end_time 结束时间，格式：YYYY-MM-DD HH:mm:00（GMT+0），秒数值固定为00
     * @param string $player_id 玩家ID（可选）
     * @param string $provider_code 游戏供应商编码（可选）
     * @param string $currency 币种（可选）
     * @param int $page 页码（可选，默认1）
     * @param int $size 每页数量（可选，默认5000）
     * @param int $show_all 是否包含子代理（可选，1-包含，0-不包含，默认0）
     * @return array ['code' => 200/201, 'message' => '成功/错误信息', 'data' => [], 'total' => 0, 'pages' => 0, 'size' => 0, 'current' => 0]
     */
    public function getExtraTrans($start_time, $end_time, $player_id = '', $provider_code = '', $currency = '', $page = 1, $size = 5000, $show_all = 0)
    {
        $return = [
            'code' => 200,
            'message' => '成功',
            'data' => [],
            'total' => 0,
            'pages' => 0,
            'size' => 0,
            'current' => 0
        ];

        $request_id = 'req_' . time() . '_' . rand(1000, 9999);

        $data = [
            'requestId' => $request_id,
            'brandId' => (string) $this->brand_id,
            'startTime' => $start_time,
            'endTime' => $end_time,
            'page' => (int) ($page ?: 1),
            'size' => (int) ($size ?: 5000),
        ];

        if (!empty($player_id)) {
            $data['playerId'] = $player_id;
        }

        if (!empty($provider_code)) {
            $data['providerCode'] = $provider_code;
        }

        if (!empty($currency)) {
            $data['currency'] = $currency;
        }

        if ($show_all == 1) {
            $data['showAll'] = 1;
        }

        $url = $this->getGmagGameDataBaseUrl() . '/history/extraTrans';
        $res = $this->sendRequest($url, $data);

        if (isset($res['error']) && $res['error'] != '0') {
            $return['code'] = 201;
            $return['message'] = $res['message'] ?? '拉取游戏额外奖励交易信息失败';
            Log::error('Dbgmag拉取游戏额外奖励交易信息失败', [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'response' => $res
            ]);
            return $return;
        }

        $return['data'] = $res['records'] ?? [];
        $return['total'] = $res['total'] ?? 0;
        $return['pages'] = $res['pages'] ?? 0;
        $return['size'] = $res['size'] ?? ($data['size'] ?? 5000);
        $return['current'] = $res['current'] ?? ($data['page'] ?? 1);
        return $return;
    }
}
