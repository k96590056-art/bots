<?php
   $ret = $_REQUEST;
   $returnArray = array( // 返回字段
        "appid" => $ret["appid"], // 商户ID
        "amount" =>  $ret["amount"], // 订单号
        "order_no" =>  $ret["order_no"], // 交易金额
        "time" =>  $ret["time"], // 交易时间
        "status" =>  $ret["status"], // 支付流水号
    );
    $md5key = 'xxxxx';//商户密钥
    ksort($returnArray);
    reset($returnArray);
    $md5str = "";
    foreach ($returnArray as $key => $val) {
        $md5str = $md5str . $key . "=" . $val . "&";
    }
    $sign = md5($md5str . "key=" . $md5key);
    if ($sign == $ret["sign"]) {
        if ($ret["status"] == "1") {
              	//回调逻辑
              	
	            die("success");
        }
    }else {
        die('签名错误');
    }