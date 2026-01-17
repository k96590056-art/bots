<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * DbkaiyuanService 开元棋牌对接服务
 * 参考：kaiyuan.md
 *
 * 关键点：
 * - 登录/余额/上下分/查单：GET https://<server>/channelHandle?agent=...&timestamp=...&param=...&key=...
 * - 拉单：GET https://<server>/getRecordHandle?agent=...&timestamp=...&param=...&key=...
 * - param：AES-128-ECB 加密后再 urlencode
 * - key：MD5(agent + timestamp + MD5Key)
 */
class DbkaiyuanService
{
    // 配置全部写死（按你的要求）
    protected $server = "https://wc3-api.uaphl791.com";//'https://api.qjkjk017.com';
    protected $record_server = "https://wc3-record.uaphl791.com";//'https://record.qjkjk017.com';
    protected $agent = '800552';
    protected $md5Key = 'D72654370C381F9D';
    protected $aesKey = '95A045D5E02EE6EE'; // 16字节密钥（AES-128-ECB）
    protected $lineCode = 'site01';
    protected $lang = 'zh-CN';
    protected $err = ["所属产品"=>"DB开元棋牌"];

    /**
     * 登录接口同时具备“自动创建账号”的能力，故 register 也走 s=0，money=0。
     */
    public function register($api_code, $username, $password = '123456')
    {
        $return = ['code' => 200, 'message' => '成功'];
        $orderId = $this->buildOrderId($username);
        $ip = request()->ip() ?? '127.0.0.1';

        $param = http_build_query([
            's' => 0,
            'account' => $username,
            'money' => 0,
            'orderid' => $orderId,
            'ip' => $ip,
            'lineCode' => $this->lineCode,
            'KindID' => 0,
        ]);

        $res = $this->callChannelHandle($param);
        
        Log::error('Db开元棋牌 注册返回信息）', $res);
        if ($this->isOk($res)) {
            return $return;
        }
        return $this->failFromRes('注册失败', $res);
    }

    /**
     * 登录获取游戏URL
     * 参考 IndexController 调用方式：login($username,$api_code,$game_type,$is_mobile,$game_code)
     */
    public function login($username, $api_code = '', $game_type = '1', $is_mobile = 1, $game_code = '')
    {
        $return = ['code' => 200, 'message' => '成功'];

        $orderId = $this->buildOrderId($username);
        $ip = request()->ip() ?? '127.0.0.1';
        $kindId = is_numeric($game_code) ? (int)$game_code : 0;

        $param = http_build_query([
            's' => 0,
            'account' => $username,
            'money' => 0,
            'orderid' => $orderId,
            'ip' => $ip,
            'lineCode' => $this->lineCode,
            'KindID' => $kindId,
        ]);
        $res = $this->callChannelHandle($param);
        
        
        Log::error('Db开元棋牌 登录返回信息）', ["param"=>$param,"res"=>$res]);
        if ($this->isOk($res)) {
            $url = $res['d']['url'] ?? '';
            if ($url !== '') {
                $return['data'] = $url;
                return $return;
            }
            return $this->failFromRes('登录失败：未返回URL', $res);
        }

        return $this->failFromRes('登录失败', $res);
    }

    /**
     * 查询可下分余额（3.2.2 s=1）
     * 参考调用方式：balance($api_code,$username)
     */
    public function balance($api_code, $username, $password = '123456')
    {
        $return = ['code' => 200, 'message' => '成功'];

        $param = http_build_query([
            's' => 1,
            'account' => $username,
        ]);

        $res = $this->callChannelHandle($param);
        if ($this->isOk($res)) {
            $money = $res['d']['money'] ?? 0;
            $return['data'] = (float)$money;
            return $return;
        }
        return $this->failFromRes('查询余额失败', $res) + ['data' => 0];
    }

    /**
     * 上分（3.2.3 s=2）
     * 参考 PayController 调用方式：deposit($username,$amount,$orderNo,$api_code/platform)
     */
    public function deposit($username, $amount, $ext_trans_id, $api_code = '')
    {
        $return = ['code' => 200, 'message' => '成功'];

        $amount = round((float)$amount, 2);
        if ($amount <= 0) {
            return ['code' => 201, 'message' => '上分金额必须大于0'];
        }

        // 生成流水号：代理编号 + yyyyMMddHHmmssSSS + account，长度不超过100
        $orderid = $this->buildDepositOrderId($username);

        $param = http_build_query([
            's' => 2,
            'account' => $username,
            'money' => $amount,
            'orderid' => $orderid,
        ]);

        $res = $this->callChannelHandle($param);
        if ($this->isOk($res)) {
            // money 字段：上分后可下分金额（可能存在）
            $return['data'] = ['money' => $res['d']['money'] ?? null];
            return $return;
        }
        return $this->failFromRes('上分失败', $res);
    }

    /**
     * 下分（3.2.4 s=3）
     */
    public function withdrawal($username, $amount, $ext_trans_id, $api_code = '')
    {
        $return = ['code' => 200, 'message' => '成功'];

        $amount = round((float)$amount, 2);
        if ($amount <= 0) {
            return ['code' => 201, 'message' => '下分金额必须大于0'];
        }

        $param = http_build_query([
            's' => 3,
            'account' => $username,
            'money' => $amount,
            'orderid' => (string)$ext_trans_id,
        ]);

        $res = $this->callChannelHandle($param);
        if ($this->isOk($res)) {
            $return['data'] = ['money' => $res['d']['money'] ?? null];
            return $return;
        }
        return $this->failFromRes('下分失败', $res);
    }

    /**
     * 查询订单（3.2.5 s=4）
     */
    public function checkTrans($ext_trans_id)
    {
        $return = ['code' => 200, 'message' => '成功'];

        $param = http_build_query([
            's' => 4,
            'orderid' => (string)$ext_trans_id,
        ]);

        $res = $this->callChannelHandle($param);
        if ($this->isOk($res)) {
            $status = (int)($res['d']['status'] ?? -1);
            $return['data'] = [
                'orderid' => (string)$ext_trans_id,
                'status' => $status, // -1 不存在；0 成功；2 失败；3 处理中
                'money' => $res['d']['money'] ?? null,
            ];
            return $return;
        }

        return $this->failFromRes('查单失败', $res);
    }

    /**
     * 拉取牌局记录（3.3.1 s=6）
     * 输入：Y-m-d H:i:00（按命令传入的系统时间字符串）
     */
    public function getGameReport($start_time, $end_time, $player_id = '', $currency = '', $game_code = '')
    {
        $return = ['code' => 200, 'message' => '成功', 'data' => []];

        $startMs = $this->toMs($start_time);
        $endMs = $this->toMs($end_time);
        if ($startMs <= 0 || $endMs <= 0 || $endMs < $startMs) {
            return ['code' => 201, 'message' => '时间参数错误', 'data' => []];
        }

        $param = http_build_query([
            's' => 6,
            'startTime' => $startMs,
            'endTime' => $endMs,
        ]);

        $res = $this->callGetRecordHandle($param);
        if (!$this->isOk($res)) {
            return $this->failFromRes('拉单失败', $res) + ['data' => []];
        }

        $list = $res['d']['list'] ?? null;
        if (!is_array($list)) {
            return $return;
        }

        $records = $this->explodeColumnarList($list);
        // 可选过滤 player_id
        if ($player_id !== '') {
            $records = array_values(array_filter($records, function ($row) use ($player_id) {
                return strtolower((string)($row['Accounts'] ?? '')) === strtolower((string)$player_id);
            }));
        }

        $return['data'] = $records;
        return $return;
    }

    /**
     * 简化：getGameHistory 直接复用 getGameReport
     */
    public function getGameHistory($start_time, $end_time, $player_id = '', $game_code = '', $page = 1, $limit = 100)
    {
        $result = $this->getGameReport($start_time, $end_time, $player_id, '', $game_code);
        if (($result['code'] ?? 201) != 200) {
            return $result;
        }

        $all = $result['data'] ?? [];
        $total = count($all);
        $offset = max(0, ((int)$page - 1) * (int)$limit);
        $paged = array_slice($all, $offset, (int)$limit);

        return [
            'code' => 200,
            'message' => '成功',
            'data' => $paged,
            'total' => $total,
            'page' => (int)$page,
            'limit' => (int)$limit,
        ];
    }

    // ---------------- internal ----------------

    /**
     * 生成 13 位时间戳（对齐 admin/public/c.php）
     *
     * c.php:
     * - getMillisecond(): return $sec . ceil($usec * 1000)
     * - 再 str_pad(..., 13, 0)（默认 STR_PAD_RIGHT）
     *
     * 注意：这里不要用 microtime(true)*1000，否则当毫秒位数不足 3 时，
     * 与 c.php 的拼接/补 0 规则会产生差异，导致 key=md5(agent+timestamp+md5Key) 不一致。
     */
    private function nowMs13(): string
    {
        list($usec, $sec) = explode(' ', microtime());
        $msPart = (string)ceil(((float)$usec) * 1000);
        $ts = (string)$sec . $msPart;
        // 第 3 个参数在 c.php 里传的是 0，这里明确用字符串 '0'
        return str_pad($ts, 13, '0');
    }

    private function toMs($time): int
    {
        $ts = strtotime((string)$time);
        return $ts ? ($ts * 1000) : 0;
    }

    private function buildOrderId(string $username): string
    {
        /**
         * 对齐 admin/public/c.php 的 getOrderId($agent)：
         * - list($usec,$sec)=explode(" ", microtime());
         * - $msec=round($usec*1000);
         * - return $agent.date("YmdHis").$msec;
         *
         * 这里额外拼接账号，保证不同用户不冲突；并限制最大长度 <=100（兼容原实现）。
         */
        list($usec, $sec) = explode(' ', microtime());
        $msec = (string)round(((float)$usec) * 1000);
        $raw = $this->agent . date('YmdHis') . $msec . $username;
        return substr($raw, 0, 100);
    }

    /**
     * 生成 deposit 方法的 orderid
     * 格式：代理编号 + yyyyMMddHHmmssSSS + account，长度不超过100
     */
    private function buildDepositOrderId(string $account): string
    {
        // 获取毫秒时间戳（13位）
        list($usec, $sec) = explode(' ', microtime());
        $msec = (string)round(((float)$usec) * 1000);
        // 确保毫秒是3位数字
        $msec = str_pad($msec, 3, '0', STR_PAD_LEFT);
        
        // 格式：代理编号 + yyyyMMddHHmmssSSS + account
        // yyyyMMddHHmmss = 14位，SSS = 3位毫秒，共17位
        $datetime = date('YmdHis') . $msec;
        $orderid = $this->agent . $datetime . $account;
        
        // 长度不超过100
        return substr($orderid, 0, 100);
    }

    private function md5KeyFor(string $timestamp): string
    {
        return md5($this->agent . $timestamp . $this->md5Key);
    }

    /**
     * Kaiyuan param 加密：AES-128-ECB + PKCS5Padding + base64 + urlencode
     * 参考根目录 Encrypt.php 的实现（mcrypt + pkcs5 + base64 + urlencode）。
     */
    private function encryptParam(string $paramPlain): string
    {
        $padded = $this->pkcs5Pad($paramPlain, 16);
        // 手动 padding 后，使用 ZERO_PADDING，确保与 Encrypt.php 行为一致
        $cipher = openssl_encrypt($padded, 'AES-128-ECB', $this->aesKey, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
        if ($cipher === false) {
            return '';
        }
        // 对齐 c.php：encrypt() 返回 base64，再由外层 urlencode
        return urlencode(base64_encode($cipher));
    }

    /**
     * 解密 param（用于调试/排错）：urldecode -> base64_decode -> AES-128-ECB -> PKCS5 unpad
     */
    private function decryptParam(string $paramEncrypted): string
    {
        $b64 = urldecode($paramEncrypted);
        $cipher = base64_decode($b64, true);
        if ($cipher === false) {
            return '';
        }
        $plain = openssl_decrypt($cipher, 'AES-128-ECB', $this->aesKey, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
        if ($plain === false) {
            return '';
        }
        $unpad = $this->pkcs5Unpad($plain);
        return $unpad === false ? '' : $unpad;
    }

    private function pkcs5Pad(string $text, int $blockSize): string
    {
        $pad = $blockSize - (strlen($text) % $blockSize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * @return string|false
     */
    private function pkcs5Unpad(string $text)
    {
        $len = strlen($text);
        if ($len === 0) return false;
        $pad = ord($text[$len - 1]);
        if ($pad < 1 || $pad > 16) return false;
        if ($pad > $len) return false;
        // 校验 padding 字节
        $padStr = substr($text, -$pad);
        if ($padStr !== str_repeat(chr($pad), $pad)) return false;
        return substr($text, 0, $len - $pad);
    }

    private function buildUrl(string $path, string $timestamp, string $paramEncrypted, $baseServer = null): string
    {
        $key = $this->md5KeyFor($timestamp);
        $base = $baseServer ?: $this->server;
        $base = rtrim((string)$base, '/');
        $url = $base . $path
        . '?agent=' . urlencode($this->agent)
        . '&timestamp=' . urlencode($timestamp)
        . '&param=' . $paramEncrypted
        . '&key=' . urlencode($key);
        return $url;
    }

    private function callChannelHandle(string $paramPlain): array
    {
        $timestamp = $this->nowMs13();
        $paramEncrypted = $this->encryptParam($paramPlain);
        $url = $this->buildUrl('/channelHandle', $timestamp, $paramEncrypted, $this->server);
        return $this->httpGetJson($url);
    }

    private function callGetRecordHandle(string $paramPlain): array
    {
        $timestamp = $this->nowMs13();
        $paramEncrypted = $this->encryptParam($paramPlain);
        // 拉单走 record_server；未配置则回退 server
        $base = property_exists($this, 'record_server') && !empty($this->record_server) ? $this->record_server : $this->server;
        $url = $this->buildUrl('/getRecordHandle', $timestamp, $paramEncrypted, $base);
        return $this->httpGetJson($url);
    }

    private function httpGetJson(string $url): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $resp = curl_exec($ch);
        $err = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($err) {
            Log::error('Kaiyuan请求失败', ['url' => $url, 'error' => $err, 'http_code' => $httpCode]);
            return ['_error' => $err, '_http' => $httpCode];
        }

        $json = json_decode((string)$resp, true);
        if (!is_array($json)) {
            Log::error('Kaiyuan返回非JSON', ['url' => $url, 'http_code' => $httpCode, 'resp' => substr((string)$resp, 0, 500)]);
            return ['_error' => 'invalid_json', '_http' => $httpCode, '_raw' => $resp];
        }
        return $json;
    }

    private function isOk(array $res): bool
    {
        return isset($res['d']) && is_array($res['d']) && (int)($res['d']['code'] ?? -999) === 0;
    }

    private function failFromRes(string $defaultMsg, array $res): array
    {
        $code = (int)($res['d']['code'] ?? ($res['_http'] ?? 201));
        $msg = $defaultMsg . '（code=' . $code . '）';
        return ['code' => 201, 'message' => $msg, 'data' => $res];
    }

    /**
     * Kaiyuan 拉单返回 list 是列式数组：{Field: [v1,v2,...]}
     * 这里转换为行式数组：[{Field:v1,...},{Field:v2,...}]
     */
    private function explodeColumnarList(array $list): array
    {
        $keys = array_keys($list);
        if (empty($keys)) return [];

        $len = 0;
        foreach ($keys as $k) {
            if (is_array($list[$k])) {
                $len = max($len, count($list[$k]));
            }
        }

        $rows = [];
        for ($i = 0; $i < $len; $i++) {
            $row = [];
            foreach ($keys as $k) {
                $v = $list[$k] ?? null;
                $row[$k] = is_array($v) ? ($v[$i] ?? null) : $v;
            }
            $rows[] = $row;
        }
        return $rows;
    }
}

