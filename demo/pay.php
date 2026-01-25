<?php
        $pay_memberid = 1;   //商户后台API管理获取
        $pay_orderid = time();    //订单号
        $pay_amount = 100;    //交易金额
        $pay_notifyurl = 'http://www.baidu.com/notify.php';   //服务端返回地址
        $pay_callbackurl = 'http://www.baidu.com/';  //页面跳转返回地址
        $Md5key = '1f0be62dffaf8270655e3c1bc95ad1c1';   //商户后台API管理获取
        $native = array(
            "appid" => $pay_memberid,
            "order_no" => $pay_orderid,
            "amount" => $pay_amount,
            "pay_code" => 'Zmh',
            "notify_url" => $pay_notifyurl,
            "return_url" => $pay_callbackurl,
        );
        ksort($native);
        $md5str = "";
        foreach ($native as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        $sign = md5($md5str . "key=" . $Md5key);
        $native["sign"] = $sign;
   		$postData = http_build_query($native);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://pay.1688epay.com');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // stop verifying certificate
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($data,true);
        //var_dump('<pre>',$json);die;
 		$url = $json['pay_url'];
 		header('location:'.$url);die;