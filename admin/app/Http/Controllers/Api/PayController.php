<?php
//decode by http://www.yunlu99.com/
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\SystemConfig;
use Illuminate\Support\Facades\Auth;
use App\Models\Recharge;
use App\Models\CodePay;
use App\Models\GameRecord;
use App\Models\PaySetting;
use App\Models\TransferLog;
use App\Models\UserCard;
use App\Models\Usersmoney;
use App\Models\Withdraw;
use App\Models\User;
use App\Models\UserVip;
use App\Services\RxPayService;
use App\Services\TgService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Userredpacket;
use App\Models\RedEnvelopes;
use Illuminate\Support\Facades\Log;
use App\Models\User_Api;
use App\Models\GameList;
use App\Services\PayService;
use App\Services\DbevoService;
use App\Services\DbkaiyuanService;
use App\Services\DbgmagService;
use App\Services\Lib;
class PayController extends Controller
{
    protected $messages = [];
    protected $banklist;

    public function __construct()
    {
		$this->PayService = new PayService();

        $this->banklist = ['中国工商银行'=>'Icbc','工商银行'=>'Icbc','中国农业银行'=>'Abc','招商银行'=>'Cmb','中国建设银行'=>'Ccb','中信银行'=>'Cibk','中国银行'=>'Boc','交通银行'=>'Bocom','华夏银行'=>'Hxbc','民生银行'=>'Cmbc','光大银行'=>'Cebc','建设银行'=>'Ccb'];

    }
    /**
     * 系统银行卡信息
     */
    public function systemBankCardInfo()
    {
        $card = PaySetting::where('state', 1)->first();
        return $this->returnMsg(200, $card);
    }
    /**
     * 系统银行卡信息
     */
    public function refreshusermoney(Request $request)
    {
     $token = $request->header('authorization');
     $token = str_replace('Bearer ','',$token) ;
     $user = User::where('api_token',$token)->first();
        if (!$user) {
            return $this->returnMsg(401, [], '用户认证失败');
        }
        $tg = new TgService;
        $result = $tg->allusersbalance($user->username);
        // 兼容：接口异常/返回结构变化时，避免直接下标访问导致报错
        $Balance = [];
        if (is_array($result) && (int)($result['code'] ?? 200) === 200) {
            $maybe = $result['data']['userblance'] ?? [];
            if (is_array($maybe)) {
                $Balance = $maybe;
            }
        } else {
            Log::warning('refreshusermoney: allusersbalance 返回异常', [
                'user_id' => $user->id,
                'username' => $user->username,
                'result_type' => gettype($result),
                'result' => $result,
            ]);
        }
        $str = "";
        $gameblance = 0;
        if (!empty($Balance)) {
            foreach ($Balance as $wo) {
                if (!is_array($wo)) continue;
                $gamecode = $wo['gamecode'] ?? null;
                $blance = $wo['blance'] ?? null;
                if ($gamecode === null || $blance === null) continue;
                Usersmoney::upinfo($user->id, $gamecode, $blance);
                $gameblance += (float)$blance;
            }
        }
        $info = SystemConfig::where('key','usdt_rate')->first();
        $money = TransferLog::where('user_id',$user->id)
            ->where('state', 0)->sum('money');
        $info_withdraw = SystemConfig::where('key','withdraw_usdt_rate')->first();
        $user->fanshui = $money;
        $data['api_token'] = $user->api_token;
        $data['balance'] = $user->balance;
        $data['birthday'] = $user->birthday;
        $data['fanshui'] = $user->fanshui;
        $data['realname'] = $user->realname;
        $data['transferstatus'] = $user->transferstatus;
        $data['username'] = $user->username;
        $data['vip'] = $user->vip;
        $data['level'] = $user->level;
        $data['joinday'] = intval((time()-strtotime($user->created_at))/60/60/24);
        $data['gameblance'] =Usersmoney::getTotalAppUserBalance($user->id);
        $data['avatar'] = ($user->avatar) ? env('APP_URL').$user->avatar : '';
        $data['mobile'] = $user->phone;
        $data['email'] = $user->mail;
        $data['birthday'] = $user->birthday;
        $data['usdtrate'] = $info ? ($info->value ?? '7.2') : '7.2';
        $data['withdrawusdtrate'] = $info_withdraw ? ($info_withdraw->value ?? '7.2') : '7.2';
        $info_withdrawcashfee = SystemConfig::where('key','withdraw_fee_usdt_erc')->first();
        $data['withdrawcashfee'] = $info_withdrawcashfee ? ($info_withdrawcashfee->value ?? '0') : '0';
        $info_withdrawfeeusdttrc = SystemConfig::where('key','withdraw_cash_fee')->first();
        $data['withdrawfeeusdttrc'] = $info_withdrawfeeusdttrc ? ($info_withdrawfeeusdttrc->value ?? '0') : '0';
        $uservip = UserVip::where('id',$user->vip)->first();
        if($uservip){
                $data['vipname'] =  '/static/style/'.strtolower($uservip->vipname).'.png';
            }else{
                $data['vipname'] =  '/static/style/'.strtolower('VIP0').'.png';
         }


        return $this->returnMsg(200, $data,'刷新成功');
    }
    /**
     * 系统银行卡信息
     */
    public function getpayinfo(Request $request)
    {
     $token = $request->header('authorization');
     $token = str_replace('Bearer ','',$token) ;
     $user = User::where('api_token',$token)->first();

        $data = $request->all();
        $info = Recharge::where('user_id',$user->id)->where('out_trade_no',$data['deposit_no'])->first();
        switch ($info['pay_way']) {
            case 1: //提交后台审核
                $cardlist = PaySetting::where('state',1)->get();
                foreach ($cardlist as &$val){
                    if($val->bank_data->bank_name!='USDT' || $val->bank_data->bank_name!='银行类型后台添加'){
                        $val->ico= env('APP_URL').'/uploads/'. $val->bank_data->bank_img;
                    }else{
                        $val->ico='';
                    }
                }
                $info->paytype='银行转账支付';
                $data['info'] = $info;
                $data['cardlist'] = $cardlist;
                return $this->returnMsg($data ? 200 : 500,$data,'bankpay');
                break;
            case 3: //提交后台审核  alipay
                $alipayinfo = CodePay::where('status',1)->where('id',4)->first();
                if(!$alipayinfo){
                    return $this->returnMsg(201, '', '支付宝入款方式未配置');
                }
                $alipayinfo->payimg = $alipayinfo->payimg ? env('APP_URL').'/uploads/'.$alipayinfo->payimg : '';
                $info->paytype='支付宝扫码支付';
                $data['info'] = $info;
                $data['cardlist'] = $alipayinfo;
                return $this->returnMsg($data ? 200 : 500,$data,'alipay');
                break;
            case 4: //提交后台审核  wxpay
                $wxinfo = CodePay::where('status',1)->where('id',3)->first();
                if(!$wxinfo){
                    return $this->returnMsg(201, '', '微信入款方式未配置');
                }
                $wxinfo->payimg = $wxinfo->payimg ? env('APP_URL').'/uploads/'.$wxinfo->payimg : '';
                $info->paytype='微信扫码支付';
                $data['info'] = $info;
                $data['cardlist'] = $wxinfo;
                return $this->returnMsg($data ? 200 : 500,$data,'wxpay');
                break;
           case 5: //提交后台审核  USDT
                $infousd = SystemConfig::where('key','usdt_rate')->first();
                $usdtinfo = CodePay::where('status',1)->where('id',5)->first();
                if(!$usdtinfo){
                    return $this->returnMsg(201, '', 'USDT(TRC20)入款方式未配置');
                }
                $usdtinfo->payimg = $usdtinfo->payimg ? env('APP_URL').'/uploads/'.$usdtinfo->payimg : '';
                $info->paytype='USDT扫码支付';
                $info->usdtrate = $infousd->value;
                $info->real_money = round($info->real_money / $infousd->value,2);
                $data['info'] = $info;
                $data['cardlist'] = $usdtinfo;
                return $this->returnMsg($data ? 200 : 500,$data,'usdtpay');
                break;
           case 6: //提交后台审核  USDT
                $infousd = SystemConfig::where('key','usdt_rate')->first();

                $usdtinfo = CodePay::where('status',1)->where('id',7)->first();
                if(!$usdtinfo){
                    return $this->returnMsg(201, '', 'USDT(ERC20)入款方式未配置');
                }
                $usdtinfo->payimg = $usdtinfo->payimg ? env('APP_URL').'/uploads/'.$usdtinfo->payimg : '';
                $info->paytype='USDT扫码支付';
                $info->usdtrate = $infousd->value;
                $info->real_money = round($info->real_money / $infousd->value,2);
                $data['info'] = $info;
                $data['cardlist'] = $usdtinfo;
                return $this->returnMsg($data ? 200 : 500,$data,'usdtpay');
                break;
            case 7:
                $ebpay = CodePay::where('status',1)->where('id',8)->first();
                if(!$ebpay){
                    return $this->returnMsg(201, '', 'EBPay入款方式未配置');
                }
                $ebpay->payimg = $ebpay->payimg ? env('APP_URL').'/uploads/'.$ebpay->payimg : '';
                $info->paytype='EBpay';
                $data['info'] = $info;
                $data['cardlist'] = $ebpay;
                return $this->returnMsg($data ? 200 : 500,$data,'ebpay');
                break;
            default:
                $cardlist = PaySetting::where('state',1)->get();
                foreach ($cardlist as &$val){
                    if($val->bank_data->bank_name!='USDT' || $val->bank_data->bank_name!='银行类型后台添加'){
                        $val->ico= env('APP_URL').'/uploads/'. $val->bank_data->bank_img;
                    }else{
                        $val->ico='';
                    }
                }
                $data['info'] = $info;
                $data['cardlist'] = $cardlist;
                return $this->returnMsg($data ? 200 : 500,$data,'bankpay');
                break;
        }

    }




    /**
     * 充值
     *
     * @param Request $request
     * @return void
     */
    public function recharge(Request $request)
    {
        $rules = [
            'amount' => 'required',
            'paytype' => 'required',
        ];
        $this->validate($request, $rules, $this->messages);

     $token = $request->header('authorization');
     $token = str_replace('Bearer ','',$token) ;
            $user = User::where('api_token',$token)->first();

        $data = $request->all();
        // 清理非表字段，避免插入时触发 SQL 错误
        if (isset($data['current_user'])) unset($data['current_user']);
        $min_recharge_money = SystemConfig::getValue('min_recharge_money');
        $max_recharge_money = SystemConfig::getValue('max_recharge_money');
        if (isset($min_recharge_money) && !empty($min_recharge_money)) {
            if ($data['amount'] < $min_recharge_money) {
                return $this->returnMsg(500,[],'单次充值最低金额：'.$min_recharge_money);
            }
        }
        if (isset($max_recharge_money) && !empty($max_recharge_money)) {
            if ($data['amount'] > $max_recharge_money) {
                return $this->returnMsg(500,[],'单次充值最高金额：'.$max_recharge_money);
            }
        }
        $out_trade_no = time().$user->id.rand(1000,9999);
        $data['out_trade_no'] = $out_trade_no;
        $data['user_id'] = $user->id;
        $data['pay_way'] = $data['paytype'];
        $catepay = $data['catepay'] ?? '';
        unset($data['catepay']);
        unset($data['paytype']);
        $usdtinfo = CodePay::where('status',1)->where('mch_id',$data['pay_way'])->first();
        switch ($data['pay_way']) {
            case "bank": //提交后台审核
                $data['pay_way'] =1;
                $data['cash_fee'] = 0;
                if(!$usdtinfo){
                     return $this->returnMsg(500,[],'系统维护中...');
                }
                if ($data['amount'] > $usdtinfo['max_price'] || $data['amount'] < $usdtinfo['min_price']) return $this->returnMsg(500,[],'充值金额不在该通道范围中');
                $data['real_money'] = $data['amount'] - $data['cash_fee'];
                $res = Recharge::create($data);
                if (!$res) {
                    return $this->returnMsg(500,[],'创建订单失败');
                }
                $rxPay = new RxPayService();
                $notifyUrl = url('/api/pay/rxpay_notify');
                $returnUrl = url('/');
                $rxResult = $rxPay->createPayOrder($data['out_trade_no'], $data['amount'], $usdtinfo["key"], $notifyUrl, $returnUrl);
                if ((int)($rxResult['code'] ?? 0) !== 1 || empty($rxResult['pay_url'])) {
                    // 下单失败：标记为失败，避免前端一直轮询
                    $res->state = 3;
                    $res->info = 'rxpay_create_failed:' . (string)($rxResult['msg'] ?? '');
                    $res->save();
                    return $this->returnMsg(500, ['rx' => $rxResult], '代收下单失败');
                }
                return $this->returnMsg(200, ['pay_url' => $rxResult['pay_url'], 'out_trade_no' => $data['out_trade_no']], $data['out_trade_no']);
                break;
            case "bankcode": //提交后台审核
                $data['pay_way'] =2;
                $data['cash_fee'] = 0;
                if(!$usdtinfo){
                     return $this->returnMsg(500,[],'系统维护中...');
                }
                if ($data['amount'] > $usdtinfo['max_price'] || $data['amount'] < $usdtinfo['min_price']) return $this->returnMsg(500,[],'充值金额不在该通道范围中');
                $data['real_money'] = $data['amount'] - $data['cash_fee'];
                $res = Recharge::create($data);
                if (!$res) {
                    return $this->returnMsg(500,[],'创建订单失败');
                }
                $rxPay = new RxPayService();
                $notifyUrl = url('/api/pay/rxpay_notify');
                $returnUrl = url('/');
                $rxResult = $rxPay->createPayOrder($data['out_trade_no'], $data['amount'], $usdtinfo["key"], $notifyUrl, $returnUrl);
                if ((int)($rxResult['code'] ?? 0) !== 1 || empty($rxResult['pay_url'])) {
                    // 下单失败：标记为失败，避免前端一直轮询
                    $res->state = 3;
                    $res->info = 'rxpay_create_failed:' . (string)($rxResult['msg'] ?? '');
                    $res->save();
                    return $this->returnMsg(500, ['rx' => $rxResult], '代收下单失败');
                }
                return $this->returnMsg(200, ['pay_url' => $rxResult['pay_url'], 'out_trade_no' => $data['out_trade_no']], $data['out_trade_no']);
                break;
            case "alipay":
                $data['cash_fee'] = 0;
                $data['pay_way'] =3;
                if(!$usdtinfo){
                     return $this->returnMsg(500,[],'系统维护中...');
                }
                if ($data['amount'] > $usdtinfo['max_price'] || $data['amount'] < $usdtinfo['min_price']) return $this->returnMsg(500,[],'充值金额不在该通道范围中');
                $data['real_money'] = $data['amount'] - $data['cash_fee'];
                $res = Recharge::create($data);
                if (!$res) {
                    return $this->returnMsg(500,[],'创建订单失败');
                }
                $rxPay = new RxPayService();
                $notifyUrl = url('/api/pay/rxpay_notify');
                $returnUrl = url('/');
                $rxResult = $rxPay->createPayOrder($data['out_trade_no'], $data['amount'], $usdtinfo["key"], $notifyUrl, $returnUrl);
                if ((int)($rxResult['code'] ?? 0) !== 1 || empty($rxResult['pay_url'])) {
                    // 下单失败：标记为失败，避免前端一直轮询
                    $res->state = 3;
                    $res->info = 'rxpay_create_failed:' . (string)($rxResult['msg'] ?? '');
                    $res->save();
                    return $this->returnMsg(500, ['rx' => $rxResult], '代收下单失败');
                }
                return $this->returnMsg(200, ['pay_url' => $rxResult['pay_url'], 'out_trade_no' => $data['out_trade_no']], $data['out_trade_no']);
                break;
            case "wxpay":
                $data['cash_fee'] = 0;
                $data['pay_way'] =4;
                $data['real_money'] = $data['amount'] - $data['cash_fee'];
                if(!$usdtinfo){
                     return $this->returnMsg(500,[],'系统维护中...');
                }
                if ($data['amount'] > $usdtinfo['max_price'] || $data['amount'] < $usdtinfo['min_price']) return $this->returnMsg(500,[],'充值金额不在该通道范围中');
                $res = Recharge::create($data);
                if (!$res) {
                    return $this->returnMsg(500,[],'创建订单失败');
                }
                $rxPay = new RxPayService();
                $notifyUrl = url('/api/pay/rxpay_notify');
                $returnUrl = url('/');
                $rxResult = $rxPay->createPayOrder($data['out_trade_no'], $data['amount'], $usdtinfo["key"], $notifyUrl, $returnUrl);
                if ((int)($rxResult['code'] ?? 0) !== 1 || empty($rxResult['pay_url'])) {
                    $res->state = 3;
                    $res->info = 'rxpay_create_failed:' . (string)($rxResult['msg'] ?? '');
                    $res->save();
                    return $this->returnMsg(500, ['rx' => $rxResult], '代收下单失败');
                }
                return $this->returnMsg(200, ['pay_url' => $rxResult['pay_url'], 'out_trade_no' => $data['out_trade_no']], $data['out_trade_no']);
                break;
           case "usdt": //提交后台审核  USDT
                $data['cash_fee'] = 0;
                $data['bank'] = $catepay;
                $data['pay_way'] = ($catepay=='TRC20') ? 5 : 6;

                $pay_way = ($catepay=='TRC20') ? 5 : 7;

                $usdtinfo = CodePay::where('status',1)->where('id',$pay_way)->first();
                if(!$usdtinfo){
                     return $this->returnMsg(500,[],'系统维护中...');
                }
                if ($data['amount'] > $usdtinfo['max_price'] || $data['amount'] < $usdtinfo['min_price']) return $this->returnMsg(500,[],'充值金额不在该通道范围中');
                $data['real_money'] = $data['amount'] - $data['cash_fee'];
                $res = Recharge::create($data);
                return $this->returnMsg($res ? 200 : 500,[],$data['out_trade_no']);
                break;
            case 'ebpay':
                $digital_rmb = [
                    ['name' => '数字人民币', 'code' => 661, 'range' => [100, 5000]],
                ];
                $data['bank'] = 'ebpay';
        	    $data['pay_way'] = 7;
                $data['cash_fee'] = 0;
                $data['real_money'] = $data['amount'] - $data['cash_fee'];
                $info = CodePay::where('status',1)->where('id',8)->first();
                if(!$info){
                    return $this->returnMsg(500,[],'系统维护中...');
                }
                if ($data['amount'] > $info['max_price'] || $data['amount'] < $info['min_price']) return $this->returnMsg(500,[],'充值金额不在该通道范围中');
                $res = Recharge::create($data);
                return $this->returnMsg($res ? 200 : 500,[],$data['out_trade_no']);


            default:
                # code...
                break;
        }
    }

    public function getPayRange(Request $request)
    {
        $type = $request->input('type');
        // USDT 走系统配置，不依赖 CodePay 列表
        if ($type === 'usdt-trc20') {
            $min = SystemConfig::getValue('tron_min_amount') ?? 0;
            $max = SystemConfig::getValue('tron_max_amount') ?? 0;
            return $this->returnMsg(200, ['min_price' => (float)$min, 'max_price' => (float)$max]);
        }
        if ($type === 'usdt-erc20') {
            $min = SystemConfig::getValue('erc20_min_amount') ?? 0;
            $max = SystemConfig::getValue('erc20_max_amount') ?? 0;
            return $this->returnMsg(200, ['min_price' => (float)$min, 'max_price' => (float)$max]);
        }
        $data = ['min_price' => 0,'max_price' => 0];
        $type = $type == "wechat" ? "wxpay" : $type;
        if ($type) {
            $range = CodePay::where('mch_id',$type)->select('min_price','max_price')->first();
            if ($range) $data = ['min_price' => $range->min_price,'max_price' => $range->max_price];
        } else {
            $min_price = SystemConfig::getValue('min_price') ?? 0;
            $max_price = SystemConfig::getValue('max_price') ?? 0;
            $data = ['min_price' => $min_price,'max_price' => $max_price];
        }
        return $this->returnMsg(200,$data);
    }

    /**
     * 绑定银行卡
     *
     * @param Request $request
     * @return void
     */
    public function bindCard(Request $request)
    {
        $rules = [
            'bank' => 'required',
            'bank_no' => 'required',
            'bank_owner' => 'nullable',
            'pay_pass' => 'required',
            'bank_address' => 'nullable',
        ];
         $this->validate($request, $rules, $this->messages);
         $data = $request->all();
         $token = $request->header('authorization');
         $token = str_replace('Bearer ','',$token) ;
         $user = User::where('api_token',$token)->first();
        if(!$user->paypwd){
            return $this->returnMsg(251,[],'请先设置支付密码');
        }
        if (!Hash::check($data['pay_pass'], $user->paypwd)) return $this->returnMsg(205,[],'支付密码错误');


        if($data['bank']=='USDT'){
            $count = UserCard::where('user_id', $user->id)->where('bank','USDT')->count();
            $data['bank_address'] = $data['bank_owner'];
          // $usdtinfo = UserCard::where('user_id', $user->id)->where('bank', 'USDT')->first();
           //if($usdtinfo){
             //  $usdtinfo->bank_owner = $data['bank_owner'];
             //  $usdtinfo->bank_no = $data['bank_no'];
             //  $usdtinfo->bank_address = $data['bank_address'];
             //  $usdtinfo->save();
           //}
        } else {
            $count = UserCard::where('user_id', $user->id)->where('bank','<>','USDT')->count();
        }

        unset($data['pay_pass']);
        // 避免将中间件注入的 current_user 写入表，导致 SQL 报错
        if (isset($data['current_user'])) unset($data['current_user']);
        if ($count > 5) return $this->returnMsg(207,[],'最多只能绑定5张银行卡');
        $data['user_id'] = $user->id;
        $res = UserCard::create($data);
        return $this->returnMsg($res ? 200 : 500);
    }
    /**
     * 绑定银行卡
     *
     * @param Request $request
     * @return void
     */
    public function DelbindCard(Request $request)
    {
        $rules = [
            'id' => 'required',
        ];
        $this->validate($request, $rules, $this->messages);
        $data = $request->all();
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();
        $count = UserCard::where('user_id', $user->id)->where('id', $data['id'])->delete();
        return $this->returnMsg($count ? 200 : 500);
    }

    public function getBetAmount(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();
        $withdrawinfo = Withdraw::where('user_id',$user->id)->where('state',2)->orderBy("id","desc")->first();

        if($withdrawinfo){
            $recharge_amount = Recharge::where('user_id',$user->id)->where('state',2)->whereDate('created_at','>=',$withdrawinfo->created_at)->sum('amount');
            $bet_amount = GameRecord::where('user_id',$user->id)->whereDate('created_at','>=',$withdrawinfo->created_at)->sum('valid_amount');
        }else{
            $recharge_amount = Recharge::where('user_id',$user->id)->where('state',2)->where('state',2)->sum('amount');
            $bet_amount = GameRecord::where('user_id',$user->id)->sum('valid_amount');
        }
        return $this->returnMsg(200,compact('bet_amount'));
    }
    /**
     * 提现
     *
     * @param Request $request
     * @return void
     */
    public function withdraw(Request $request)
    {
        $rules = [
            'amount' => 'required',
            'bank' => 'required',
            'password' => 'required',
        ];
        $this->validate($request,$rules,$this->messages);

        $data = $request->all();
        $daily_withdraw_times = SystemConfig::getValue('daily_withdraw_times');
        $min_withdraw_money = SystemConfig::getValue('min_withdraw_money');
        $withdraw_fee = SystemConfig::getValue('withdraw_fee');
        $max_withdraw_money = SystemConfig::getValue('max_withdraw_money');
     $token = $request->header('authorization');
     $token = str_replace('Bearer ','',$token) ;
            $user = User::where('api_token',$token)->first();
        if (isset($daily_withdraw_times) && !empty($daily_withdraw_times)) {
            $count = Withdraw::whereDate('created_at',date('Y-m-d'))->count();
            if ($count >= $daily_withdraw_times) {
                return $this->returnMsg(216);
            }
        }
        //时间限制
        $withdraw_begin_time = SystemConfig::getValue('withdraw_begin_time');
        $date = date('Y-m-d');
        if ($withdraw_begin_time) {
            $begin = $date.' '.$withdraw_begin_time;
            $begin_time = strtotime($begin);
            if (time() < $begin_time) return $this->returnMsg(218);
        }
        $withdraw_end_time = SystemConfig::getValue('withdraw_end_time');
        if ($withdraw_end_time) {
            $end = $date.' '.$withdraw_end_time;
            $end_time = strtotime($end);
            if (time() > $end_time) return $this->returnMsg(219);
        }

        $withdrawinfo = Withdraw::where('user_id',$user->id)->where('state',2)->orderBy("id","desc")->first();

        if($withdrawinfo){
            $recharge_amount = Recharge::where('user_id',$user->id)->where('state',2)->whereDate('created_at','>=',$withdrawinfo->created_at)->sum('amount');
            $bet_amount = GameRecord::where('user_id',$user->id)->whereDate('created_at','>=',$withdrawinfo->created_at)->sum('valid_amount');
        }else{
            $recharge_amount = Recharge::where('user_id',$user->id)->where('state',2)->where('state',2)->sum('amount');
            $bet_amount = GameRecord::where('user_id',$user->id)->sum('valid_amount');
        }

        if($withdraw_fee > 0 && $recharge_amount > 0 && $bet_amount/$recharge_amount<$withdraw_fee){
            return $this->returnMsg(214,[],'打码量达没有达到充值的'.$withdraw_fee.'倍,无法正常提现');
        }
        if (isset($min_withdraw_money) && !empty($min_withdraw_money)) {
            if ($data['amount'] < $min_withdraw_money) {
                return $this->returnMsg(214,[],'单次提款最低金额：'.$min_withdraw_money);
            }
        }
        if (isset($max_withdraw_money) && !empty($max_withdraw_money)) {
            if ($data['amount'] > $max_withdraw_money) {
                return $this->returnMsg(215,[],'单次提款最高金额：'.$max_withdraw_money);
            }
        }

        if (!$data['password']){
            return $this->returnMsg(520,[],'请输入取款密码');
        }else{
            if(empty($user->paypwd)){
                return $this->returnMsg(520,[],'请先设置取款密码');
            }else{
                if (!Hash::check($data['password'],$user->paypwd))  return $this->returnMsg(520,[],'取款密码错误');
            }

        }

        if ($data['amount'] > $user->balance) return $this->returnMsg(208);
        //提现
        $card = UserCard::find($data['bank']);
        // return $this->returnMsg(200,$card);
        $order_no = time().rand(1000,9999);
        if ($card['bank'] == 'ZGPay') {
            $merchant_id = SystemConfig::where('key','merchant_id')->value('value') ?? '';
            $api_secret = SystemConfig::where('key','zgp_secret')->value('value') ?? '';
            $zgpay = new Zgpay($merchant_id,$api_secret);
            $res = $zgpay->withdraw($order_no,$data['amount'],$card['bank_owner'],$card['bank_no']);
            $res = json_decode($res,true);
            if ($res['code'] != 200) return $this->returnMsg(500);
        }
        $user->balance -= $data['amount'];
        $user->save();
         $type = 1;
         $cash_fee = 0;
        // 插入提现记录
        $usdt_rate = SystemConfig::getValue('withdraw_usdt_rate');
        if($card['bank']=='USDT' && ($card['bank_address']=='TRC20' || $card['bank_owner']=='TRC20')){
            $type = 2;
            $cash_fee = SystemConfig::getValue('withdraw_cash_fee') ?? 0;
            $real_money = sprintf('%.2f',$data['amount'] / $usdt_rate);
            $real_money -= $cash_fee;
        }elseif($card['bank']=='USDT' && ($card['bank_address']=='ERC20' || $card['bank_owner']=='ERC20')){
             $type = 3;
             $cash_fee = SystemConfig::getValue('withdraw_fee_usdt_erc') ?? 0;
            $real_money = sprintf('%.2f',$data['amount'] / $usdt_rate);
            $real_money -= $cash_fee;
        } elseif ($card['bank'] == 'ebpay') {
            $type = 4;
            $real_money = $data['amount'];
        }else {
            $real_money = $data['amount'];
        }

        $item = [
            'order_no' => $order_no,
            'type' => $type,
            'card_id' => $data['bank'],
            'user_id' => $user->id,
            'amount' => $data['amount'],
            'cash_fee' => $cash_fee,
            'real_money' => $real_money,
            'usdt_rate' => ($type == 1) ? 0 : $usdt_rate
        ];
        $res = Withdraw::create($item);
        return $this->returnMsg($res ? 200 : 500);
    }

    /**
     * 获取用户银行卡列表
     *
     * @param Request $request
     * @return void
     */
    public function getAllUserCard(Request $request)
    {
        try {
            $token = $request->header('authorization');
            if (!$token) {
                return $this->returnMsg(401, [], '未提供认证令牌');
            }

            $token = str_replace('Bearer ', '', $token);
            $user = User::where('api_token', $token)->first();

            if (!$user) {
                return $this->returnMsg(401, [], '用户认证失败');
            }

            $data = $request->all();
            $type = $data['type'] ?? 1; // 默认类型为1

            $list = collect(); // 初始化为空集合

            if ($type == 1) {
                $list = UserCard::where('user_id', $user->id)
                    ->whereNotIn('bank', ['USDT', 'ebpay', 'antoken'])
                    ->get();
            } elseif ($type == 2) {
                $list = UserCard::where('user_id', $user->id)
                    ->where('bank', 'USDT')
                    ->get();
            } elseif ($type == 3) {
                $list = UserCard::where('user_id', $user->id)
                    ->where('bank', 'ebpay')
                    ->get();
            } elseif ($type == 4) {
                $list = UserCard::where('user_id', $user->id)
                    ->where('bank', 'antoken')
                    ->get();
            }

            // 获取USDT汇率配置
            $info = SystemConfig::where('key', 'usdt_rate')->first();
            $info_withdraw = SystemConfig::where('key', 'withdraw_usdt_rate')->first();

            $usdtRate = $info ? $info->value : '7.2'; // 默认汇率
            $withdrawUsdtRate = $info_withdraw ? $info_withdraw->value : '7.2';

            foreach ($list as &$val) {
                if ($val->bank != 'USDT' && $val->bank != 'ebpay' && $val->bank != 'antoken') {
                    $banklist = Bank::where('bank_name', $val->bank)->first();
                    $val->ico = $banklist ? env('APP_URL') . '/uploads/' . $banklist->bank_img : '';
                } else {
                    $val->ico = '';
                }

                $val->bank_not = substr($val->bank_no, -4);
                $val->usdtrate = $usdtRate;
                $val->withdrawusdtrate = $withdrawUsdtRate;
            }

            return $this->returnMsg(200, $list, '获取成功');

        } catch (\Exception $e) {
            \Log::error('getAllUserCard error: ' . $e->getMessage());
            return $this->returnMsg(500, [], '获取银行卡列表失败：' . $e->getMessage());
        }
    }

    /**
     * 额度转换
     *
     * @param Request $request
     * @return void
     */
    public function transfer(Request $request)
    {
        $rules = [
            'sourcetype' => 'required',
            'targettype'=>'required',
            'amount' => 'required'
        ];
        $this->validate($request,$rules,$this->messages);
        $data = $request->all();
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();
        $tg = new TgService;
        $order_no = date('YmdHis').rand(100000,999999);
        if($data['sourcetype']==$data['targettype']){
             return $this->returnMsg(209,[],'来源和目标是一致，没有必要转了');
        }elseif($data['sourcetype']=="userbalance"){
            $data['type'] = "togame";
            $data['pay_way'] = strtolower($data['targettype']);
        }elseif($data['targettype']=="userbalance"){
            $data['type'] = "toaccount";
            $data['pay_way'] = strtolower($data['sourcetype']);
        }
		if($data['sourcetype'] != 'userbalance' && $data['targettype'] != 'userbalance' ){
			return $this->returnMsg(209,[],'场馆之间禁止互转');
		}
        // platformType=真实场馆，withApi=game_lists.with_api（用于选择 Service）
        $platformType = $this->normalizePlatformTypeCompat($data['pay_way']);
        $withApi = $this->resolveWithApiByPlatformCompat($platformType);

		$User_Api = User_Api::where('api_code',$data['pay_way'])->where('user_id',$user->id)->first();
		if(!$User_Api){
			// 根据接口类型选择服务类
			$serviceClass = '\\App\\Services\\' . ucfirst(strtolower($withApi)) . 'Service';
			if (!class_exists($serviceClass)) {
				// Special handling for DbDianzi/Dbzhenren/DbEvo/Dbkaiyuan
				if (strtolower($withApi) === 'dbdianzi') {
					$serviceClass = '\\App\\Services\\DbdianziService';
				} elseif (strtolower($withApi) === 'dbzhenren') {
					$serviceClass = '\\App\\Services\\DbzhenrenService';
				} elseif (strtolower($withApi) === 'dbevo') {
					$serviceClass = '\\App\\Services\\DbevoService';
				} elseif (strtolower($withApi) === 'dbkaiyuan') {
					$serviceClass = '\\App\\Services\\DbkaiyuanService';
				} else {
					$serviceClass = '\\App\\Services\\TgService';
				}
			}
			$service = new $serviceClass();
			$result = $service->register($data['pay_way'], $user->username);
            if($result['code'] != 200){
				return $this->returnMsg(201, '', $result['message']);
			}
			$arr = [
				'user_id' => $user->id,
				'api_user' => $user->username,
				'api_pass' => 123456,
				'api_code' => strtolower($data['pay_way']),
			];
			$User_Api = User_Api::create($arr);
		}

        if ($data['type'] == "togame") { //转入游戏
            $amount = intval($data['amount']);
            if ($amount > $user->balance) return $this->returnMsg(210,[],'操作金额高于账户余额');
                $arr = [
                    'order_no' => $order_no,
                    // api_type 按 game_lists.with_api 写入
                    'api_type' => $withApi,
                    // platform_type 保存真实场馆 code
                    'platform_type' => $platformType,
                    'user_id' => $user->id,
                    'transfer_type' => 0,
                    'money' => $amount,
                    'cash_fee' => 0,
                    'real_money' => $amount,
                    'before_money' => $user->balance ,
                    'after_money' => $user->balance,
                    'state' => 0
                ];
                TransferLog::create($arr);

				// 根据接口类型选择服务类
				$serviceClass = '\\App\\Services\\' . ucfirst(strtolower($withApi)) . 'Service';
				if (!class_exists($serviceClass)) {
					// Special handling for DbDianzi/Dbzhenren/DbEvo/Dbkaiyuan
					if (strtolower($withApi) === 'dbdianzi') {
						$serviceClass = '\\App\\Services\\DbdianziService';
					} elseif (strtolower($withApi) === 'dbzhenren') {
						$serviceClass = '\\App\\Services\\DbzhenrenService';
					} elseif (strtolower($withApi) === 'dbevo') {
						$serviceClass = '\\App\\Services\\DbevoService';
					} elseif (strtolower($withApi) === 'dbkaiyuan') {
						$serviceClass = '\\App\\Services\\DbkaiyuanService';
					} else {
						$serviceClass = '\\App\\Services\\TgService';
					}
				}
				$service = new $serviceClass();
				$res = $service->deposit($user->username, $amount, $order_no, $platformType);

				if ($res['code'] == 200) {
					$user->balance -= abs($data['amount']);
					$user->save();
					$transferlog = TransferLog::where('order_no', $order_no)->first();
					$transferlog->after_money = $user->balance-$amount;
					$transferlog->state = 1;
					$transferlog->save();
					$User_Api = User_Api::where('api_code',$platformType)->where('user_id',$user->id)->first();
					$User_Api->api_money += $amount;
					$User_Api->save();
					return $this->returnMsg(200,['balance' => $user->balance]);
				} else {
					return $this->returnMsg(209,$res,$res['message']);
				}
        } else {  //回收
                $amount = intval($data['amount']);
                $arr = [
                    'order_no' => $order_no,
                    // api_type 按 game_lists.with_api 写入
                    'api_type' => $withApi,
                    // platform_type 保存真实场馆 code
                    'platform_type' => $platformType,
                    'user_id' => $user->id,
                    'transfer_type' => 1,
                    'money' => $amount,
                    'cash_fee' => 0,
                    'real_money' => $amount,
                    'before_money' => $user->balance,
                    'after_money' => $user->balance,
                    'state' => 0
                ];
                TransferLog::create($arr);
				// 根据接口类型选择服务类
				$serviceClass = '\\App\\Services\\' . ucfirst(strtolower($withApi)) . 'Service';
				if (!class_exists($serviceClass)) {
					// Special handling for DbDianzi/Dbzhenren/DbEvo/Dbkaiyuan
					if (strtolower($withApi) === 'dbdianzi') {
						$serviceClass = '\\App\\Services\\DbdianziService';
					} elseif (strtolower($withApi) === 'dbzhenren') {
						$serviceClass = '\\App\\Services\\DbzhenrenService';
					} elseif (strtolower($withApi) === 'dbevo') {
						$serviceClass = '\\App\\Services\\DbevoService';
					} elseif (strtolower($withApi) === 'dbkaiyuan') {
						$serviceClass = '\\App\\Services\\DbkaiyuanService';
					} else {
						$serviceClass = '\\App\\Services\\TgService';
					}
				}
				$service = new $serviceClass();
				
				// 兼容不同平台 withdrawal 方法签名
				if (strtolower($withApi) === 'db') {
					// DbService::withdrawal($username, $amount, $serialNo, $venueCode, $currency)
					// 先根据 user_api 表的 api_code 去 game_lists 获取 venue_code
					$gameList = GameList::where('with_api', 'db')
						->where('platform_name', $platformType)
						->whereNotNull('venue_code')
						->where('venue_code', '!=', '')
						->first();
					
					if (!$gameList || empty($gameList->venue_code)) {
						$transferlog = TransferLog::where('order_no', $order_no)->first();
						if ($transferlog) {
							$transferlog->delete();
						}
						return $this->returnMsg(400, [], "未找到 api_code ({$platformType}) 对应的 venue_code");
					}
					
					$venueCode = $gameList->venue_code;
					$res = $service->withdrawal($user->username, $amount, $order_no, $venueCode, 'USDT');
				} else {
					// 其他平台：withdrawal($username, $amount, $orderNo, $api_code/platform)
					$res = $service->withdrawal($user->username, $amount, $order_no, $platformType);
				}
				
				if ($res['code'] == 200) {
					$user->balance += $data['amount'];
					$user->save();
					$transferlog = TransferLog::where('order_no', $order_no)->first();
					$transferlog->after_money = $user->balance+$amount;
					$transferlog->state = 1;
					$transferlog->save();
					$User_Api = User_Api::where('api_code',$platformType)->where('user_id',$user->id)->first();
					if($User_Api->api_money <= $amount){
						$User_Api->api_money = 0;
						$User_Api->save();
					}else{
						$User_Api->api_money -= $amount;
						$User_Api->save();
					}
					return $this->returnMsg(200,['balance' => $user->balance]);
				} else {
					return $this->returnMsg(209,$res,$res['message']);
				}
        }
    }


    public function transAll(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();
        
		// 优先从 user_api 表中查找有余额的记录
		$userApi = User_Api::where('user_id', $user->id)
			->where('api_money', '>', 0)
			->orderBy('api_money', 'desc')
			->first();
		
		$platformType = '';
		$withApi = '';
		$amount = 0;
		
		if ($userApi) {
			// 直接从 user_api 表获取余额和场馆信息
			$platformType = $this->normalizePlatformTypeCompat($userApi->api_code);
			$withApi = $this->resolveWithApiByPlatformCompat($platformType);
			$amount = intval($userApi->api_money);
		} else {
			// 如果没有 user_api 余额，尝试从 TransferLog 记录推断
        $transferlog = TransferLog::where('user_id', $user->id)->where('transfer_type', 0)->orderBy('id','desc')->first();
		if(!$transferlog){
			return $this->returnMsg(200,'','没有可回收的金额');
		}
			// api_type 写的是 with_api；platform_type 写的是真实场馆（兼容旧数据）
			$withApiFromLog = strtolower((string)($transferlog->api_type ?? ''));
			$platformType = $transferlog->platform_type ? $this->normalizePlatformTypeCompat($transferlog->platform_type) : '';
			$withApi = $transferlog->platform_type ? $withApiFromLog : '';

			// 兼容旧数据：如果没有 platform_type（无法确定真实场馆），尝试从 user_api.api_money>0 的记录反推一个可回收的场馆
			if ($platformType === '') {
				$ua = User_Api::where('user_id', $user->id)
					->where('api_money', '>', 0)
					->orderBy('api_money', 'desc')
					->first();
				if ($ua) {
					$platformType = $this->normalizePlatformTypeCompat($ua->api_code);
					$withApi = $this->resolveWithApiByPlatformCompat($platformType);
				} else {
					// 再兜底：把 api_type 当成 platform_name（极旧数据）
					$platformType = $this->normalizePlatformTypeCompat($withApiFromLog);
					$withApi = $this->resolveWithApiByPlatformCompat($platformType);
				}
			}
			if ($withApi === '') {
				$withApi = $this->resolveWithApiByPlatformCompat($platformType);
			}

			// 根据接口类型选择服务类
			$serviceClass = '\\App\\Services\\' . ucfirst(strtolower($withApi)) . 'Service';
			if (!class_exists($serviceClass)) {
				// Special handling for Dianzi, Dbzhenren and Evo
				if (strtolower($withApi) === 'dbdianzi') {
					$serviceClass = '\\App\\Services\\DbdianziService';
				} elseif (strtolower($withApi) === 'dbzhenren') {
					$serviceClass = '\\App\\Services\\DbzhenrenService';
				} elseif (strtolower($withApi) === 'dbevo') {
					$serviceClass = '\\App\\Services\\DbevoService';
				} else {
					$serviceClass = '\\App\\Services\\TgService';
				}
			}
			$service = new $serviceClass();
			// 优先用官方余额接口（若服务支持），否则退回 balance()
			if (method_exists($service, 'balanceOfficial')) {
				$result = $service->balanceOfficial($platformType, $user->username);
			} else {
				$result = $service->balance($platformType, $user->username);
			}
		if($result['code'] != 200){
			return $this->returnMsg(201, '', $result['message']);
		}
		if($result['data'] < 1){
			return $this->returnMsg(200,'','没有可回收的金额');
		}
		$amount = intval($result['data']);
		}
		
		if ($amount < 1) {
			return $this->returnMsg(200,'','没有可回收的金额');
		}
		
		// 根据接口类型选择服务类（如果还没有选择）
		if (!isset($serviceClass)) {
			$serviceClass = '\\App\\Services\\' . ucfirst(strtolower($withApi)) . 'Service';
			if (!class_exists($serviceClass)) {
				// Special handling for Dianzi, Dbzhenren and Evo
				if (strtolower($withApi) === 'dbdianzi') {
					$serviceClass = '\\App\\Services\\DbdianziService';
				} elseif (strtolower($withApi) === 'dbzhenren') {
					$serviceClass = '\\App\\Services\\DbzhenrenService';
				} elseif (strtolower($withApi) === 'dbevo') {
					$serviceClass = '\\App\\Services\\DbevoService';
				} else {
					$serviceClass = '\\App\\Services\\TgService';
				}
			}
		}
		$service = new $serviceClass();
		$order_no = date('YmdHis').rand(100000,999999);
		$arr = [
			'order_no' => $order_no,
			// api_type 按 game_lists.with_api 写入
			'api_type' => $withApi,
			// platform_type 保存真实场馆 code
			'platform_type' => $platformType,
			'user_id' => $user->id,
			'transfer_type' => 1,
			'money' => $amount,
			'cash_fee' => 0,
			'real_money' => $amount,
			'before_money' => $user->balance,
			'after_money' => $user->balance,
			'state' => 0
		];
		TransferLog::create($arr);
		
		// 兼容不同平台 withdrawal 方法签名
		if (strtolower($withApi) === 'db') {
			// DbService::withdrawal($username, $amount, $serialNo, $venueCode, $currency)
			// 先根据 user_api 表的 api_code 去 game_lists 获取 venue_code
			$gameList = GameList::where('with_api', 'db')
				->where('platform_name', $platformType)
				->whereNotNull('venue_code')
				->where('venue_code', '!=', '')
				->first();
			
			if (!$gameList || empty($gameList->venue_code)) {
				$transferlog = TransferLog::where('order_no', $order_no)->first();
				if ($transferlog) {
					$transferlog->delete();
				}
				return $this->returnMsg(400, [], "未找到 api_code ({$platformType}) 对应的 venue_code");
			}
			
			$venueCode = $gameList->venue_code;
			$res = $service->withdrawal($user->username, $amount, $order_no, $venueCode, 'USDT');
		} else {
			// 其他平台：withdrawal($username, $amount, $orderNo, $api_code/platform)
			$res = $service->withdrawal($user->username, $amount, $order_no, $platformType);
		}
		
		if($res['code'] != 200){
			return $this->returnMsg(201, '', $res['message']);
		}
		$user->balance += $amount;
		$user->save();
		$transferlog = TransferLog::where('order_no', $order_no)->first();
		$transferlog->after_money = $user->balance+$amount;
		$transferlog->state = 1;
		$transferlog->save();
		// 如果是从 user_api 表直接获取的，使用已有的对象；否则查询
		if (isset($userApi) && $userApi) {
			$User_Api = $userApi;
		} else {
			$User_Api = User_Api::where('api_code', $platformType)->where('user_id',$user->id)->first();
		}
		if($User_Api && $User_Api->api_money <= $amount){
			$User_Api->api_money = 0;
			$User_Api->save();
		}elseif($User_Api){
			$User_Api->api_money -= $amount;
			$User_Api->save();
		}
        return $this->returnMsg(200,'','回收成功');
        //\Illuminate\Support\Facades\Log::info("手机版一键回收结果".$user->username);

        //\Illuminate\Support\Facades\Log::info($result);

    }


    /**
     * 一键回收
     * @return void
     */
    public function AllAccounttranso($user,$plat_name, $money)   // 游戏转账到余额
    {
        $client_transfer_id = time() . $user->id . rand(1000, 9999);
        $amount = abs($money);
        $platformType = $this->normalizePlatformTypeCompat($plat_name);
        $withApi = $this->resolveWithApiByPlatformCompat($platformType);
        $arr = [
            'order_no' => $client_transfer_id,
            // api_type 按 game_lists.with_api 写入
            'api_type' => $withApi,
            // platform_type 保存真实场馆 code
            'platform_type' => $platformType,
            'user_id' => $user->id,
            'transfer_type' => 1,
            'money' => $money,
            'cash_fee' => 0,
            'real_money' => $amount,
            'before_money' => $user->balance ,
            'after_money' => $user->balance + $amount,
            'state' => 1
        ];
        TransferLog::create($arr);
        $user->balance = $user->balance + $money;
        $user->save();

        return array('code' => 200);

    }

    /**
     * 回收指定平台的余额（公共方法，供其他控制器调用）
     * 
     * @param User $user 用户对象
     * @param string $platformType 平台类型（platform_name）
     * @return array 返回结果 ['code' => 200/201, 'message' => '', 'data' => []]
     */
    public function recyclePlatformBalance($user, $platformType)
    {
        try {
            // 规范化平台类型
            $originalPlatformType = $platformType;
            $platformType = $this->normalizePlatformTypeCompat($platformType);
            $withApi = $this->resolveWithApiByPlatformCompat($platformType);
            
            // 记录日志，方便调试
            Log::info('回收余额 - 开始处理', [
                'user_id' => $user->id,
                'original_platform_type' => $originalPlatformType,
                'normalized_platform_type' => $platformType,
                'resolved_with_api' => $withApi
            ]);

            // 根据接口类型选择服务类
            $serviceClass = '\\App\\Services\\' . ucfirst(strtolower($withApi)) . 'Service';
            if (!class_exists($serviceClass)) {
                // Special handling for DbDianzi/Dbzhenren/DbEvo/Dbkaiyuan
                if (strtolower($withApi) === 'dbdianzi') {
                    $serviceClass = '\\App\\Services\\DbdianziService';
                } elseif (strtolower($withApi) === 'dbzhenren') {
                    $serviceClass = '\\App\\Services\\DbzhenrenService';
                } elseif (strtolower($withApi) === 'dbevo') {
                    $serviceClass = '\\App\\Services\\DbevoService';
                } elseif (strtolower($withApi) === 'dbkaiyuan') {
                    $serviceClass = '\\App\\Services\\DbkaiyuanService';
                } elseif (strtolower($withApi) === 'dbgmag') {
                    $serviceClass = '\\App\\Services\\DbgmagService';
                } elseif (strtolower($withApi) === 'dboneapi') {
                    $serviceClass = '\\App\\Services\\DboneapiService';
                } else {
                    $serviceClass = '\\App\\Services\\TgService';
                }
            }
            $service = new $serviceClass();

            // 先获取user_api表中的余额（用于对比）
            $User_Api = User_Api::where('api_code', $platformType)
                ->where('user_id', $user->id)
                ->first();
            $userApiMoney = $User_Api ? floatval($User_Api->api_money ?? 0) : 0;
            
            // 获取游戏接口返回的实际余额（这是真实的余额，应该以此为准）
            $result = null;
            $interfaceAmount = 0;
            
            // 尝试获取余额，如果失败则使用user_api表中的余额作为兜底
            // 使用 try-catch 确保即使获取余额时抛出异常也不会中断流程
            try {
                if (method_exists($service, 'balanceOfficial')) {
                    $result = $service->balanceOfficial($platformType, $user->username);
                } elseif (method_exists($service, 'balance')) {
                    $result = $service->balance($platformType, $user->username);
                }
            } catch (\Exception $e) {
                // 获取余额时抛出异常，记录日志但继续处理（使用user_api表中的余额作为兜底）
                Log::warning('回收余额 - 获取接口余额时抛出异常，将使用user_api表中的余额作为兜底', [
                    'user_id' => $user->id,
                    'platform_type' => $platformType,
                    'with_api' => $withApi,
                    'user_api_money' => $userApiMoney,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $result = null;
                $interfaceAmount = 0;
            }

            if ($result && isset($result['code']) && $result['code'] == 200) {
                $interfaceAmount = floatval($result['data'] ?? 0);
            } else {
                // 获取余额失败，记录日志但继续处理（使用user_api表中的余额作为兜底）
                Log::warning('回收余额 - 获取接口余额失败，将使用user_api表中的余额作为兜底', [
                    'user_id' => $user->id,
                    'platform_type' => $platformType,
                    'with_api' => $withApi,
                    'user_api_money' => $userApiMoney,
                    'result' => $result
                ]);
                $interfaceAmount = 0;
            }
            
            // 优先使用接口返回的实际余额作为回收金额（这是真实的余额）
            // 如果接口返回的余额为0，则使用user_api表中的余额作为兜底
            $amount = $interfaceAmount > 0 ? $interfaceAmount : $userApiMoney;

            // 即使金额为0，也要调用接口扣除余额（确保游戏接口方的余额被清零）
            $amount = intval($amount);
            $order_no = date('YmdHis') . rand(100000, 999999);
            
            // 如果金额为0，记录日志但继续调用接口
            if ($amount < 1) {
                Log::info('回收余额 - 余额为0，但仍需调用接口确保游戏接口方余额清零', [
                    'user_id' => $user->id,
                    'platform_type' => $platformType,
                    'amount' => $amount
                ]);
            }

            // 创建转账记录（即使金额为0也要创建，确保调用接口）
            // 使用 try-catch 确保即使创建记录时出错也不会中断流程
            $transferLog = null;
            try {
                $arr = [
                    'order_no' => $order_no,
                    'api_type' => $withApi,
                    'platform_type' => $platformType,
                    'user_id' => $user->id,
                    'transfer_type' => 1, // 回收
                    'money' => $amount,
                    'cash_fee' => 0,
                    'real_money' => $amount,
                    'before_money' => $user->balance,
                    'after_money' => $user->balance,
                    'state' => 0
                ];
                $transferLog = TransferLog::create($arr);
            } catch (\Exception $e) {
                // 创建转账记录失败，记录日志但继续处理（尝试调用接口）
                Log::error('回收余额 - 创建转账记录失败', [
                    'user_id' => $user->id,
                    'platform_type' => $platformType,
                    'order_no' => $order_no,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                // 继续执行，尝试调用接口
            }

            // 检查服务类是否有 withdrawal 方法
            if (!method_exists($service, 'withdrawal')) {
                // 如果服务类没有 withdrawal 方法，删除转账记录并返回错误（但不抛出异常，让调用方继续处理其他场馆）
                if ($transferLog) {
                    try {
                        $transferLog->delete();
                    } catch (\Exception $e) {
                        // 删除记录失败，记录日志但继续
                        Log::warning('回收余额 - 删除转账记录失败', [
                            'user_id' => $user->id,
                            'platform_type' => $platformType,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
                Log::error('回收余额 - 服务类不支持withdrawal方法', [
                    'user_id' => $user->id,
                    'platform_type' => $platformType,
                    'with_api' => $withApi,
                    'service_class' => get_class($service)
                ]);
                return ['code' => 400, 'message' => "服务类不支持回收方法（withdrawal），platform_type: {$platformType}, with_api: {$withApi}", 'data' => []];
            }

            // 必须调用回收接口扣除游戏接口方的余额（即使金额为0也要调用）
            // 即使接口调用失败，也要继续处理其他场馆，所以这里捕获所有异常
            $res = null;
            try {
                if (strtolower($withApi) === 'db') {
                    // DB接口需要venue_code
                    $gameList = GameList::where('with_api', 'db')
                        ->where('platform_name', $platformType)
                        ->whereNotNull('venue_code')
                        ->where('venue_code', '!=', '')
                        ->first();

                    if (!$gameList || empty($gameList->venue_code)) {
                        if ($transferLog) {
                            try {
                                $transferLog->delete();
                            } catch (\Exception $e) {
                                // 删除记录失败，记录日志但继续
                                Log::warning('回收余额 - 删除转账记录失败', [
                                    'user_id' => $user->id,
                                    'platform_type' => $platformType,
                                    'error' => $e->getMessage()
                                ]);
                            }
                        }
                        Log::error('回收余额 - 未找到venue_code', [
                            'platform_type' => $platformType,
                            'with_api' => $withApi
                        ]);
                        return ['code' => 400, 'message' => "未找到 api_code ({$platformType}) 对应的 venue_code", 'data' => []];
                    }

                    $venueCode = $gameList->venue_code;
                    // 调用接口扣除游戏接口方的余额（即使金额为0也要调用）
                    $res = $service->withdrawal($user->username, $amount, $order_no, $venueCode, 'USDT');
                } else {
                    // 其他平台：withdrawal($username, $amount, $orderNo, $api_code/platform)
                    // 调用接口扣除游戏接口方的余额（即使金额为0也要调用）
                    $res = $service->withdrawal($user->username, $amount, $order_no, $platformType);
                }
            } catch (\Exception $e) {
                // 接口调用异常，删除转账记录，返回失败但不抛出异常（让调用方继续处理其他场馆）
                if ($transferLog) {
                    try {
                        $transferLog->delete();
                    } catch (\Exception $deleteException) {
                        // 删除记录失败，记录日志但继续
                        Log::warning('回收余额 - 删除转账记录失败', [
                            'user_id' => $user->id,
                            'platform_type' => $platformType,
                            'error' => $deleteException->getMessage()
                        ]);
                    }
                }
                Log::error('回收余额 - 接口调用异常', [
                    'user_id' => $user->id,
                    'platform_type' => $platformType,
                    'amount' => $amount,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return ['code' => 201, 'message' => '接口调用异常：' . $e->getMessage(), 'data' => []];
            }

            if ($res && isset($res['code']) && $res['code'] == 200) {
                // 接口调用成功，更新用户余额和User_Api余额
                try {
                    // 如果回收金额大于0，更新用户余额
                    if ($amount > 0) {
                        $user->balance += $amount;
                        $user->save();
                    }
                    
                    // 更新转账记录（如果存在）
                    if ($transferLog) {
                        // 如果金额与记录中的金额不一致，更新记录
                        if ($transferLog->money != $amount) {
                            $transferLog->money = $amount;
                            $transferLog->real_money = $amount;
                        }
                        $transferLog->after_money = $user->balance;
                        $transferLog->state = 1;
                        $transferLog->save();
                    }

                    // 更新User_Api余额（清零）- 无论金额多少，都清零，因为已经回收了
                    if ($User_Api) {
                        $oldApiMoney = $User_Api->api_money;
                        $User_Api->api_money = 0;
                        $saveResult = $User_Api->save();
                        
                        // 记录清零操作的结果
                        if (!$saveResult) {
                            Log::warning('回收余额 - User_Api余额清零失败', [
                                'user_id' => $user->id,
                                'platform_type' => $platformType,
                                'old_api_money' => $oldApiMoney,
                                'user_api_id' => $User_Api->id
                            ]);
                        } else {
                            Log::info('回收余额 - User_Api余额已清零', [
                                'user_id' => $user->id,
                                'platform_type' => $platformType,
                                'old_api_money' => $oldApiMoney,
                                'new_api_money' => 0,
                                'recycled_amount' => $amount
                            ]);
                        }
                    } else {
                        // 如果User_Api记录不存在，创建一条记录（api_money为0）
                        try {
                            $User_Api = User_Api::create([
                                'user_id' => $user->id,
                                'api_code' => $platformType,
                                'api_user' => $user->username,
                                'api_pass' => '', // 如果需要密码，可以从其他地方获取
                                'api_money' => 0
                            ]);
                            Log::info('回收余额 - 创建User_Api记录（余额为0）', [
                                'user_id' => $user->id,
                                'platform_type' => $platformType
                            ]);
                        } catch (\Exception $e) {
                            Log::warning('回收余额 - 创建User_Api记录失败', [
                                'user_id' => $user->id,
                                'platform_type' => $platformType,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }

                    Log::info('回收余额 - 接口调用成功', [
                        'user_id' => $user->id,
                        'platform_type' => $platformType,
                        'interface_amount' => $interfaceAmount,
                        'user_api_amount' => $userApiMoney,
                        'recycled_amount' => $amount,
                        'user_balance_before' => $user->balance - $amount,
                        'user_balance_after' => $user->balance,
                        'order_no' => $order_no
                    ]);
                    return ['code' => 200, 'message' => $amount > 0 ? '回收成功' : '接口调用成功（余额为0）', 'data' => ['amount' => $amount]];
                } catch (\Exception $e) {
                    // 更新数据时出错，记录日志但返回成功（因为接口调用已经成功）
                    Log::error('回收余额 - 接口调用成功但更新数据失败', [
                        'user_id' => $user->id,
                        'platform_type' => $platformType,
                        'amount' => $amount,
                        'order_no' => $order_no,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    return ['code' => 200, 'message' => '接口调用成功（但更新数据失败）', 'data' => ['amount' => $amount]];
                }
            } else {
                // 接口调用失败（如余额不足、接口错误等），删除转账记录，返回失败但不抛出异常
                if ($transferLog) {
                    try {
                        $transferLog->delete();
                    } catch (\Exception $e) {
                        // 删除记录失败，记录日志但继续
                        Log::warning('回收余额 - 删除转账记录失败', [
                            'user_id' => $user->id,
                            'platform_type' => $platformType,
                            'order_no' => $order_no,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
                Log::warning('回收余额 - 接口调用失败（继续处理其他场馆）', [
                    'user_id' => $user->id,
                    'platform_type' => $platformType,
                    'amount' => $amount,
                    'result' => $res,
                    'error_message' => (isset($res['message']) ? $res['message'] : '未知错误')
                ]);
                return ['code' => 201, 'message' => (isset($res['message']) ? $res['message'] : '接口调用失败'), 'data' => []];
            }
        } catch (\Throwable $e) {
            // 捕获所有异常和错误（包括 Error 和 Exception），确保不会中断其他场馆的回收
            Log::error('回收余额 - 异常', [
                'user_id' => $user->id ?? null,
                'platform_type' => $platformType ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return ['code' => 500, 'message' => '回收异常：' . $e->getMessage(), 'data' => []];
        }
    }

    public function getPayWay()
    {
        $wxinfo = CodePay::where('status',1)->where('id',3)->count();
        $usdtinfo = CodePay::where('status',1)->where('id',5)->count();
        $usdtinfo_erc = CodePay::where('status',1)->where('id',7)->count();
        $alipayinfo = CodePay::where('status',1)->where('id',4)->count();
        $cardlist = PaySetting::where('state',1)->get();
        $wechat = $wxinfo ? 1 : 0;
        // 若已配置TRON参数，则开启USDT入口但不依赖CodePay列表
        $tronAddress = SystemConfig::getValue('tron_usdt_address');
        $tronKey = SystemConfig::getValue('tron_api_key');
        $usdt = (!empty($tronAddress) && !empty($tronKey)) ? 1 : (($usdtinfo || $usdtinfo_erc) ? 1 : 0);
        $alipay = $alipayinfo ? 1 : 0;
        $card = count($cardlist) > 0 ? 1 : 0;
        return $this->returnMsg(200,compact('wechat','usdt','alipay','card'),'success');
    }

    /**
     * 获取所有支付方式信息
     * 从 code_pay 表获取所有启用的支付方式，并组装图片URL
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPayments()
    {
        try {
            // 获取所有启用的支付方式
            $payments = CodePay::where('status', 1)
                ->orderBy('id', 'asc')
                ->get()
                ->map(function ($item) {
                    // 组装图片URL
                    $payimgUrl = '';
                    if (!empty($item->payimg)) {
                        // 如果 payimg 已经是完整URL，直接使用；否则组装
                        if (filter_var($item->payimg, FILTER_VALIDATE_URL)) {
                            $payimgUrl = $item->payimg;
                        } else {
                            $payimgUrl = env('APP_URL') . '/uploads/' . ltrim($item->payimg, '/');
                        }
                    }
                    
                    return [
                        'id' => $item->id,
                        'mch_id' => $item->mch_id,
                        'content' => $item->content,
                        'payimg' => $payimgUrl,
                        'min_price' => floatval($item->min_price ?? 0),
                        'max_price' => floatval($item->max_price ?? 0),
                        'status' => $item->status,
                    ];
                })
                ->values()
                ->toArray();

            return $this->returnMsg(200, $payments, '获取成功');
        } catch (\Exception $e) {
            Log::error('获取支付方式列表失败', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->returnMsg(500, [], '获取支付方式列表失败：' . $e->getMessage());
        }
    }

    public function userRedPacket(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();
        list($start, $end) = [date('Y-m-d').' 00:00:00',date('Y-m-d').' 23:59:59'];

        $acquirednum = Userredpacket::where('uid', $user->id)
            ->when($start, function ($query) use ($start) {
                return $query->where('created_at', '>=', $start);
            })->when($end, function ($query) use ($end) {
                return $query->where('created_at', '<=', $end);
            })->count();

        $totalRecharge = Recharge::where('user_id', $user->id)->where('state',2)->where('pay_way','<>',10)
            ->when($start, function ($query) use ($start) {
                return $query->where('created_at', '>=', $start);
            })->when($end, function ($query) use ($end) {
                return $query->where('created_at', '<=', $end);
            })->sum('amount');
            // var_dump($totalRecharge);exit;

        $rule = RedEnvelopes::where('flow_money','>=',$totalRecharge)->where('day_flow','<=',$totalRecharge)
            ->where('start_time','<',date('Y-m-d H:i:s'))->where('end_time','>',date('Y-m-d H:i:s'))->where('status',1)->orderBy('recharge','desc')->first();
        if (!$rule) {
            $sendnums = 0;
        } else {
            $sendnums = $rule->recharge;
        }
        $sendnums = $sendnums - $acquirednum;

        $rules = RedEnvelopes::where('status',1)->get();
        $data = date('Y-m-d');
        $datatime = date('Y-m-d H:i:s');
        $redPacketStatus = "READY";

        $max_times = RedEnvelopes::where('status',1)->orderBy('recharge','desc')->value('recharge');
        $max_times = intval($max_times);
        $max_end_time = RedEnvelopes::where('status',1)->orderBy('end_time','desc')->value('end_time');
        $min_start_time = RedEnvelopes::where('status',1)->orderBy('start_time')->value('start_time');
        if (!$rule) {
            $redPacketStatus = "END";
        } else {
            if (time() < strtotime($max_end_time) && time() > strtotime($min_start_time)) {
                $redPacketStatus = "STARTING";
            } elseif (time() > strtotime($max_end_time)) {
                $redPacketStatus = "END";
            } elseif (time() < strtotime($min_start_time)) {
                $redPacketStatus = "READY";
            }
        }
        return $this->returnMsg(200,compact('sendnums','acquirednum','redPacketStatus','rules','max_times'));
    }

    public function doUserRedPacket(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();
        $data = $request->all();
        list($start, $end) = [date('Y-m-d').' 00:00:00',date('Y-m-d').' 23:59:59'];

        $time = date('Y-m-d H:i:s');

        if($time<$start || $time>$end){
            return $this->returnMsg(202, '','时间未到或者已过，无法领取');
        }
        // if(time()-($data['time']/1000)>3){
        //     return $this->returnMsg(203, '','非法操作');
        // }
        $acquirednum = Userredpacket::where('uid', $user->id)
            ->when($start, function ($query) use ($start) {
                return $query->where('created_at', '>=', $start);
            })->when($end, function ($query) use ($end) {
                return $query->where('created_at', '<=', $end);
            })->count();

        $totalRecharge = Recharge::where('user_id', $user->id)->where('state',2)
            ->where('pay_way','<>',10)
            ->when($start, function ($query) use ($start) {
                return $query->where('created_at', '>=', $start);
            })->when($end, function ($query) use ($end) {
                return $query->where('created_at', '<=', $end);
            })->sum('amount');
        // $condition  = array(['amount'=>100000,'nums'=>10],['amount'=>50000,'nums'=>8],['amount'=>10000,'nums'=>5],['amount'=>5000,'nums'=>3],['amount'=>1000,'nums'=>1]);
        $rule = RedEnvelopes::where('flow_money','>=',$totalRecharge)->where('day_flow','<=',$totalRecharge)
            ->where('start_time','<',date('Y-m-d H:i:s'))->where('end_time','>',date('Y-m-d H:i:s'))->orderBy('recharge','desc')->first();
        if (!$rule) return $this->returnMsg(500,[],'暂无红包可抢');
        $sendnums = (int)$rule->recharge;

        if($sendnums<=0){
            return $this->returnMsg(203, '','累计充值不满足活动条件，无法领取');
        }
        if($acquirednum>=$sendnums){
            return $this->returnMsg(203, '','领取次数已超过奖励次数，无法领取');
        }
        //$redpacketmoney = $totalRecharge*0.02;

        $redpacketmoney = $this->randFloat(1,bcdiv($totalRecharge*$rule->money,100,2));

        $userinfo = User::where('id', $user->id)->lockForUpdate()->first();
        $userinfo->balance = $userinfo->balance + $redpacketmoney;
        $userinfo->save();
/*        $userredpacket->status = 1;
        $userredpacket->usetime = date('Y-m-d H:i:s');
        $userredpacket->save();*/
        $arrs = [
            'redpacketid' => $rule->id,
            'redpacketfee' => $rule->money,
            'uid' => $userinfo->id,
            'money' => $totalRecharge,
            'status' => 1,
            'redpacketmoney' =>$redpacketmoney,
            'usetime' => date('Y-m-d H:i:s'),
            'isuse' => 1
        ];
        Userredpacket::create($arrs);
        $arr = [
            'order_no' => date('Ymd') . '_' . $userinfo->id . '_' . time(),
            'api_type' => 'web',
            'user_id' => $userinfo->id,
            'transfer_type' => 5,
            'money' => $redpacketmoney,
            'cash_fee' => 0,
            'real_money' => $redpacketmoney,
            'before_money' => $userinfo->balance - $redpacketmoney,
            'after_money' => $userinfo->balance,
            'state' => 1
        ];
        TransferLog::create($arr);
        return $this->returnMsg(200, array('redpacketmoney'=>$redpacketmoney,'sendnums'=>$sendnums-$acquirednum-1,'acquirednum'=>$acquirednum+1), '成功领取');

    }

    public function randFloat($min = 0, $max = 1) {
        $rand = $min + mt_rand() / mt_getrandmax() * ($max - $min);
        return floatval(number_format($rand,2));
    }

    public function redPacket(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();
        $data = $request->all();
        $start = $end = '';
        if (isset($data['time'])) {
            list($start, $end) = [$data['time'][0], $data['time'][1]];
        }

        $list = Userredpacket::where('uid', $user->id)
            ->when($start, function ($query) use ($start) {
                return $query->where('created_at', '>=', $start);
            })->when($end, function ($query) use ($end) {
                return $query->where('created_at', '<=', $end);
            })->orderBy('id', 'desc')->paginate(10);

        foreach ($list as $k => $v) {
            $list[$k]['amount'] = $v['redpacketmoney'];
        }

        return $this->returnMsg(200, $list);
    }

    public function getRedPacket(Request $request)
    {
        if ($request->isMethod('post')) {
            $token = $request->header('authorization');
            $token = str_replace('Bearer ','',$token) ;
            $user = User::where('api_token',$token)->first();
            $data = $request->all();
            $id = $data['id'];
            try {
                if ($id > 0) {
                    $userredpacket = Userredpacket::where('uid', $user->id)->where('id', $id)->lockForUpdate()->first();
                    if ($userredpacket && !$userredpacket->status) {
                        $userinfo = User::where('id', $user->id)->lockForUpdate()->first();
                        $userinfo->balance = $userinfo->balance + $userredpacket->redpacketmoney;
                        $userinfo->save();
                        $userredpacket->status = 1;
                        $userredpacket->usetime = date('Y-m-d H:i:s');
                        $userredpacket->save();
                        $arr = [
                            'order_no' => date('Ymd') . '_' . $userinfo->id . '_' . time(),
                            'api_type' => 'web',
                            'user_id' => $userinfo->id,
                            'transfer_type' => 5,
                            'money' => $userredpacket->redpacketmoney,
                            'cash_fee' => 0,
                            'real_money' => $userredpacket->redpacketmoney,
                            'before_money' => $userinfo->balance - $userredpacket->redpacketmoney,
                            'after_money' => $userinfo->balance,
                            'state' => 1
                        ];
                        TransferLog::create($arr);
                        /*                    $Gamereport = new GamereportService();
                                            $datae['uid'] = $userinfo->id;
                                            $datae['pid'] = $userinfo->pid;
                                            $datae['isagent'] = $userinfo->isagent;
                                            $datae['redpackectnum'] = 1;
                                            $datae['totalredpackect'] = $userredpacket->redpacketmoney;
                                            $Gamereport->add($datae);*/
                        return $this->returnMsg(200, '', '成功领取');
                    }
                }else{

                    $userfanshui = Userredpacket::where('uid', $user->id)->where('state',0)->lockForUpdate()->sum('redpacketmoney');
                    if ($userfanshui) {
                        $userinfo = User::where('id', $user->id)->lockForUpdate()->first();
                        $userinfo->balance = $userinfo->balance + $userfanshui;
                        $userinfo->save();

                        Userredpacket::where('uid', $user->id)
                            ->where('state',0)
                            ->update(['state' => 1,'usetime'=>date('Y-m-d H:i:s')]);

                        /*
                                                $Gamereport = new GamereportService();
                                                $datae['uid'] = $userinfo->id;
                                                $datae['pid'] = $userinfo->pid;
                                                $datae['isagent'] = $userinfo->isagent;
                                                $datae['releasewater'] = 1;
                                                $datae['totalredpackect'] = $userfanshui;
                                                $Gamereport->add($datae);*/

                        return $this->returnMsg(200, '', '成功领取');
                    }else{
                        return $this->returnMsg(202, '', '没有可领取的返水');
                    }

                }
            } catch (\Exception $e) {
                return $this->returnMsg(202, '', '领取失败');
            }

        }
    }
    public function cgpay_notify(Request $request)
    {
        $json = file_get_contents('php://input');
        $this->write_log('cgpay回调参数:'.$json);
        $data = json_decode($json,1);

        if(!is_array($data) || count($data) == 0) exit('error');
		$md5key = config('pay.cgpay.md5key');
        $sign = $this->PayService->cgpay_sign($data,$md5key);
        if($data['Sign'] != $sign){
			echo 'sign error';
			exit;
		}
		$recharge = Recharge::where('out_trade_no', $data['MerchantOrderId'])->where('state', 1)->first();
		if(!$recharge){
			echo 'order error';
			exit;
		}
		$user = User::where('id',$recharge->user_id)->first();
		if(!$user){
			echo 'user error';
			exit;
		}
		$recharge->state = 2;
		$recharge->save();
		$user->increment('balance',$recharge->amount);
		echo 'success';
		exit;
	}

    /**
     * RXPay 支付回调（代收）
     * 文档：回调成功需返回小写 success
     */
    public function rxpay_notify(Request $request)
    {
        // RXPay 回调为 application/x-www-form-urlencoded
        $params = $request->all();

        Log::info('rxpay_notify params', $params);

        $rxPay = new RxPayService();

        // 参考 demo/notify.php：验签只取 appid/amount/order_no/time/status
        if (!$rxPay->verifyPayCallback($params)) {
            Log::warning('rxpay_notify sign verify failed', $params);
            echo 'fail';
            return;
        }

        $orderNo = (string)($params['order_no'] ?? '');
        $status = (string)($params['status'] ?? '');

        if ($orderNo === '') {
            echo 'success';
            return;
        }

        // 只处理支付成功（参考 demo/notify.php：status=1 才执行业务）
        if ($status !== '1') {
            echo 'success';
            return;
        }else{
            $recharge = Recharge::where('out_trade_no', $orderNo)->lockForUpdate()->first();
            $recharge->state = 3;
            $recharge->save();
        }

        DB::beginTransaction();
        try {
            /** @var \App\Models\Recharge|null $recharge */
            $recharge = Recharge::where('out_trade_no', $orderNo)->lockForUpdate()->first();
            if (!$recharge) {
                DB::commit();
                echo 'success';
                return;
            }
            // 幂等：已成功则直接返回 success
            if ((int)$recharge->state === 2) {
                DB::commit();
                echo 'success';
                return;
            }

            // 金额校验（两位小数）
            $cbAmount = number_format((float)($params['amount'] ?? 0), 2, '.', '');
            $dbAmount = number_format((float)$recharge->amount, 2, '.', '');
            if ($cbAmount !== $dbAmount) {
                Log::warning('rxpay_notify amount mismatch', [
                    'order_no' => $orderNo,
                    'cb_amount' => $cbAmount,
                    'db_amount' => $dbAmount,
                ]);
                // 金额不一致也返回 success，避免三方无限重试；订单留待人工处理
                DB::commit();
                echo 'success';
                return;
            }

            $recharge->state = 2;
            // 记录备注便于排查
            $recharge->info = trim((string)$recharge->info . ' rxpay_paid_at:' . (string)($params['time'] ?? ''));
            $recharge->save();

            $user = User::where('id', $recharge->user_id)->lockForUpdate()->first();
            if ($user) {
                $user->balance = (float)$user->balance + (float)$recharge->amount;
                $user->save();
            }

            DB::commit();
            echo 'success';
            return;
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('rxpay_notify exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            echo 'fail';
            return;
        }
    }

    /**
     * 兼容线上旧版本 Lib：如果缺少方法则本地兜底，避免 fatal error
     */
    private function normalizePlatformTypeCompat($platformName): string
    {
        if (class_exists(\App\Services\Lib::class) && method_exists(\App\Services\Lib::class, 'normalizePlatformType')) {
            return \App\Services\Lib::normalizePlatformType($platformName);
        }
        return strtolower(trim((string) $platformName));
    }

    /**
     * 返回的是 game_lists.with_api（不是 platform_name）
     */
    private function resolveWithApiByPlatformCompat($platformName, $gameCode = null): string
    {
        if (class_exists(\App\Services\Lib::class) && method_exists(\App\Services\Lib::class, 'resolveWithApiByPlatform')) {
            return \App\Services\Lib::resolveWithApiByPlatform($platformName, $gameCode);
        }
        $platformName = strtolower(trim((string) $platformName));
        $gameCode = $gameCode !== null ? trim((string) $gameCode) : null;
        if ($platformName === '') {
            return '';
        }
        try {
            $query = \App\Models\GameList::where('platform_name', $platformName);
            if (!empty($gameCode)) {
                $query->where('game_code', $gameCode);
            }
            $withApi = strtolower(trim((string) $query->value('with_api')));
            return $withApi !== '' ? $withApi : $platformName;
        } catch (\Throwable $e) {
            return $platformName;
        }
	}
}
