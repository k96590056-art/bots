<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * RX支付接口服务类
 * 参考文档：https://www.yuque.com/itiger/vup6my/xcmekq
 */
class RxPayService
{
    protected $appid;
    protected $api_key;
    protected $base_url;

    public function __construct()
    {
        $this->appid = '95';
        $this->api_key = '9071ccae97ec20a7774f2868bb163ff9';
        // 统一去掉末尾斜杠，避免后续拼接出现双斜杠
        $this->base_url = rtrim('https://pay.168mayipay.com', '/');
    }

    /**
     * MD5签名生成
     * 除sign参数的所有键、值非空参数，按照字典升序排列
     * 拼接为key=value&形式，最后添加key=xxx进行MD5加密并转成小写
     * 
     * @param array $params 参数数组
     * @param string $api_key API密钥
     * @return string MD5签名（小写）
     */
    public function generateSign($params, $api_key = null)
    {
        $api_key = $api_key ?? $this->api_key;
        
        // 移除sign参数
        unset($params['sign']);
        
        // 过滤空值参数
        $params = array_filter($params, function($value) {
            return $value !== null && $value !== '';
        });
        
        // 按照字典升序排列
        ksort($params);
        
        // 拼接为key=value&形式
        $signStr = '';
        foreach ($params as $key => $value) {
            $signStr .= $key . '=' . $value . '&';
        }
        
        // 添加key=xxx
        $signStr .= 'key=' . $api_key;
        
        // MD5加密并转成小写
        return strtolower(md5($signStr));
    }

    /**
     * 验证签名
     * 
     * @param array $params 参数数组（包含sign）
     * @param string $api_key API密钥
     * @return bool 验证结果
     */
    public function verifySign($params, $api_key = null)
    {
        $sign = $params['sign'] ?? '';
        $calculatedSign = $this->generateSign($params, $api_key);
        return strtolower($sign) === $calculatedSign;
    }

    /**
     * 创建代付订单
     * 
     * @param string $order_no 商户订单号
     * @param float $amount 金额(单位：元 两位小数)
     * @param string $name 收款人名称
     * @param string $body 收款人账号
     * @param string $bank_name 银行名称
     * @param string $notify_url 异步回调地址
     * @return array 返回结果
     */
    public function createWithdrawOrder($order_no, $amount, $name, $body, $bank_name, $notify_url)
    {
        $params = [
            'appid' => $this->appid,
            'amount' => number_format($amount, 2, '.', ''), // 格式化为两位小数
            'name' => $name,
            'body' => $body,
            'bank_name' => $bank_name,
            'order_no' => $order_no,
            'notify_url' => $notify_url,
        ];

        // 生成签名
        $params['sign'] = $this->generateSign($params);

        // 发送请求（代付网关：{base_url}/ekofapy）
        $url = $this->base_url . '/ekofapy';
        $result = $this->curl_request($url, $params);

        Log::info('RX支付-创建代付订单', [
            'order_no' => $order_no,
            'params' => $params,
            'result' => $result
        ]);

        return $this->parseResponse($result);
    }

    /**
     * 查询代付订单
     * 
     * @param string $order_no 商户订单号
     * @return array 返回结果
     */
    public function queryWithdrawOrder($order_no)
    {
        $params = [
            'appid' => $this->appid,
            'order_no' => $order_no,
        ];

        // 生成签名
        $params['sign'] = $this->generateSign($params);

        // 发送请求（代付查询网关：{base_url}/ekofapy/query）
        $url = $this->base_url . '/ekofapy/query';
        $result = $this->curl_request($url, $params);

        Log::info('RX支付-查询代付订单', [
            'order_no' => $order_no,
            'result' => $result
        ]);

        return $this->parseResponse($result);
    }

    /**
     * 验证代付订单回调签名
     * 
     * @param array $params 回调参数
     * @return bool 验证结果
     */
    public function verifyWithdrawCallback($params)
    {
        return $this->verifySign($params);
    }

    /**
     * 创建支付订单
     * 
     * @param string $order_no 商户订单号
     * @param float $amount 金额(单位：元 两位小数)
     * @param string $pay_code 接口支付标识
     * @param string $notify_url 异步回调地址
     * @param string $return_url 同步回调地址
     * @return array 返回结果
     */
    public function createPayOrder($order_no, $amount, $pay_code, $notify_url, $return_url)
    {
        $params = [
            'appid' => $this->appid,
            'order_no' => $order_no,
            'amount' => number_format($amount, 2, '.', ''), // 格式化为两位小数
            'pay_code' => $pay_code,
            'notify_url' => $notify_url,
            'return_url' => $return_url,
        ];

        // 生成签名
        $params['sign'] = $this->generateSign($params);

        // 发送请求（参考 demo/pay.php：支付网关就是 base_url 本身）
        $url = $this->base_url;
        $result = $this->curl_request($url, $params);

        Log::info('RX支付-创建支付订单', [
            'params' => $params,
            'order_no' => $order_no,
            'pay_code' => $pay_code,
            'result' => $result
        ]);

        return $this->parseResponse($result);
    }

    /**
     * 查询支付订单
     * 
     * @param string $order_no 商户订单号
     * @return array 返回结果
     */
    public function queryPayOrder($order_no)
    {
        $params = [
            'appid' => $this->appid,
            'order_no' => $order_no,
        ];

        // 生成签名
        $params['sign'] = $this->generateSign($params);

        // 发送请求
        $url = $this->base_url . '/order/query';
        $result = $this->curl_request($url, $params);

        Log::info('RX支付-查询支付订单', [
            'order_no' => $order_no,
            'result' => $result
        ]);

        return $this->parseResponse($result);
    }

    /**
     * 验证支付订单回调签名
     * 
     * @param array $params 回调参数
     * @return bool 验证结果
     */
    public function verifyPayCallback($params)
    {
        // 参考 demo/notify.php：验签只取固定字段，避免回调附加字段导致验签失败
        $sign = strtolower((string)($params['sign'] ?? ''));
        $returnArray = [
            'appid' => (string)($params['appid'] ?? ''),
            'amount' => (string)($params['amount'] ?? ''),
            'order_no' => (string)($params['order_no'] ?? ''),
            'time' => (string)($params['time'] ?? ''),
            'status' => (string)($params['status'] ?? ''),
        ];

        ksort($returnArray);
        $md5str = '';
        foreach ($returnArray as $key => $val) {
            $md5str .= $key . '=' . $val . '&';
        }
        $calculated = strtolower(md5($md5str . 'key=' . $this->api_key));

        return $sign !== '' && $sign === $calculated;
    }

    /**
     * 查询单条通道成功率
     * 
     * @param string $api_style 接口支付标识
     * @param string $upaccount_id 通道编号（可选）
     * @return array 返回结果
     */
    public function queryGatewaySuccessRate($api_style, $upaccount_id = '')
    {
        $params = [
            'api_style' => $api_style,
        ];

        // 如果提供了通道编号，添加到参数中
        if (!empty($upaccount_id)) {
            $params['upaccount_id'] = $upaccount_id;
        }

        // 生成签名（注意：这个接口可能不需要签名，但为了统一性，如果有api_key就生成）
        if (!empty($this->api_key)) {
            $params['sign'] = $this->generateSign($params);
        }

        // 发送请求
        $url = $this->base_url . '/order/query_gateway';
        $result = $this->curl_request($url, $params);

        Log::info('RX支付-查询通道成功率', [
            'api_style' => $api_style,
            'upaccount_id' => $upaccount_id,
            'result' => $result
        ]);

        return $this->parseResponse($result);
    }

    /**
     * 发送HTTP请求
     * Content-Type: application/x-www-form-urlencoded
     * 
     * @param string $url 请求URL
     * @param array $data 请求数据
     * @param string $method 请求方法
     * @param bool $https 是否HTTPS
     * @param int $timeout 超时时间（秒）
     * @return string 返回结果
     */
    public function curl_request($url, $data = null, $method = 'POST', $https = true, $timeout = 30)
    {
        $method = strtoupper($method);
        $ch = curl_init(); // 初始化
        curl_setopt($ch, CURLOPT_URL, $url); // 访问的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 只获取页面内容，但不输出
        
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // https请求 不验证证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // https请求 不验证HOST
        }
        
        if ($method != "GET") {
            if ($method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, true); // 请求方式为post请求
            }
            if ($method == 'PUT' || strtoupper($method) == 'DELETE') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); // 设置请求方式
            }
            // 使用 application/x-www-form-urlencoded 格式
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        // 参考 demo/pay.php：允许跟随跳转（部分网关会 302 到实际支付页）
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
        ]);
        
        $result = curl_exec($ch); // 执行请求
        
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            Log::error('RX支付-CURL请求失败', [
                'url' => $url,
                'error' => $error
            ]);
            return json_encode([
                'code' => 0,
                'msg' => '请求失败：' . $error
            ]);
        }
        
        curl_close($ch); // 关闭curl，释放资源
        return $result;
    }

    /**
     * 解析响应结果
     * 
     * @param string $response 响应字符串
     * @return array 解析后的数组
     */
    private function parseResponse($response)
    {
        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('RX支付-响应解析失败', [
                'response' => $response,
                'error' => json_last_error_msg()
            ]);
            return [
                'code' => 0,
                'msg' => '响应解析失败：' . json_last_error_msg()
            ];
        }
        
        return $result ?? [];
    }
}
