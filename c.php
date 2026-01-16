<?php
class Aes_ecb
{
    /**
     * 说明：
     * - 原文件使用 mcrypt（已在 PHP 7.2+ 废弃，PHP 8+ 移除），会导致 Fatal error。
     * - 这里改为 openssl 实现 AES-128-ECB，并保持 Encrypt.php 里的行为：
     *   PKCS5Padding + base64 + urlencode。
     */
    protected $pad_method = null;
    protected $secret_key = '';
    protected $iv = '';
 
    public function set_cipher($cipher)
    {
        // 兼容旧调用：mcrypt 已移除，此方法保留但不再使用
        return;
    }
 
    public function set_mode($mode)
    {
        // 兼容旧调用：mcrypt 已移除，此方法保留但不再使用
        return;
    }
 
    public function set_iv($iv)
    {
        $this->iv = $iv;
    }
 
    public function set_key($key)
    {
        $this->secret_key = $key;
    }
 
    public function require_pkcs5()
    {
        $this->pad_method = 'pkcs5';
    }
 
    protected function pad_or_unpad($str, $ext)
    {
        if ( is_null($this->pad_method) )
        {
            return $str;
        }
        else
        {
            $func_name = __CLASS__ . '::' . $this->pad_method . '_' . $ext . 'pad';
            if ( is_callable($func_name) )
            {
                // AES-128 block size = 16 bytes
                $size = 16;
                return call_user_func($func_name, $str, $size);
            }
        }
        return $str;
    }
 
    protected function pad($str)
    {
        return $this->pad_or_unpad($str, '');
    }
 
    protected function unpad($str)
    {
        return $this->pad_or_unpad($str, 'un');
    }
 
    public function encrypt($str)
    {
        $str = $this->pad($str);
        // ECB 模式不使用 iv；这里手动 padding 后使用 ZERO_PADDING
        $cipherRaw = openssl_encrypt($str, 'AES-128-ECB', $this->secret_key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
        if ($cipherRaw === false) {
            return '';
        }
        return base64_encode($cipherRaw);
    }
 
    public function decrypt($str){
        $cipherRaw = base64_decode($str, true);
        if ($cipherRaw === false) {
            return false;
        }
        $plain = openssl_decrypt($cipherRaw, 'AES-128-ECB', $this->secret_key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
        if ($plain === false) {
            return false;
        }
        return $this->unpad($plain);
    }
 
    public static function hex2bin($hexdata) {
        $bindata = '';
        $length = strlen($hexdata);
        for ($i=0; $i < $length; $i += 2)
        {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }
        return $bindata;
    }
 
    public static function pkcs5_pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
 
    public static function pkcs5_unpad($text)
    {
        // {} 访问字符串下标在新版本 PHP 已废弃，改为 []
        $pad = ord($text[strlen($text) - 1]);
        if ($pad > strlen($text)) return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
        return substr($text, 0, -1 * $pad);
    }
    public function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        return $t2 .  ceil( ($t1 * 1000) );
    }
    function getOrderId($agent){  
        list($usec, $sec) = explode(" ", microtime());  
        $msec=round($usec*1000);  
        return $agent.date("YmdHis").$msec;        
    }  
}
$apiUrl = 'http://demo.ky34.com:89/channelHandle';
$aes = new Aes_ecb();
$agent = '800552';//代理编号
$aesKey = '95A045D5E02EE6EE';//AES密钥
$md5Key = 'D72654370C381F9D';//MD5密钥
$timestamp = str_pad($aes->getMillisecond(),13,0);//时间戳
$orderid = $aes->getOrderId($agent);//订单号
$params = '';//待加密字符串
$aes->set_key($aesKey);
$aes->require_pkcs5();
$param = urlencode($aes->encrypt($params));//参数加密字符串
$key = md5 ($agent.$timestamp.$md5Key);//MD5校验字符串
echo $apiUrl.'?agent='.$agent.'&timestamp='.$timestamp.'&param='.$param.'&key='.$key; 
?>