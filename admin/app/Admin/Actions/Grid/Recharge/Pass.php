<?php

namespace App\Admin\Actions\Grid\Recharge;


use App\Models\SystemConfig;
use App\Models\Users;
use App\Models\UserVip;
use App\Models\Activity;
use App\Models\ActivityApply;
use App\Models\UserOperateLog;
use App\Services\Lib;
use App\Services\GamereportService;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Recharge;
use App\Models\RedEnvelopes;
use App\Models\Userredpacket;

use App\User;
use App\Services\TelegramBotService;

class Pass extends RowAction
{
    /**
     * @return string
     */
	protected $title = '通过';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $id = $this->getKey();
        $model = Recharge::find($id);
        $user = User::find($model->user_id);
        $user->balance += $model->amount;
        $user->paysum += $model->amount;
        $user->save();
        $model->state = 2;
        // 如果是USDT充值且没有交易Hash，设置后台审核标识
        if ($model->pay_way == 5 && empty($model->tron_tx_hash)) {
            $model->tron_tx_hash = 'ADMIN_MANUAL_' . date('YmdHis') . '_' . $id;
        }
        $model->save();
        $ip = $request->ip();
            $res = Lib::getIpAddress($ip);
            $res = json_decode($res, true);
            $ip_address = '';
            if ($res && isset($res['code']) && $res['code'] == 200 && isset($res['data'])) {
                $ip_address = ($res['data']['country'] ?? '') . ($res['data']['province'] ?? '') . ($res['data']['city'] ?? '');
            }
 UserOperateLog::insertLog($user->id, 7, $_SERVER['HTTP_USER_AGENT'], $ip, $ip_address, '管理员审核【' . $user->username . '】充值通过'.'充值金额'.$model->real_money);
/*        $Gamereport = new GamereportService();
        $data['uid'] = $user->id;
        $data['pid'] = $user->pid;
        $data['isagent'] = $user->isagent;
        $data['totalrechange'] =  $model->real_money;
        $Gamereport->add($data);*/
        self::sendmoney($user,$model->amount);
        //self::checkredbao($user,$model->real_money);
        self::upuserlevel($model->user_id);  //会员升级

        // 发送Telegram充值成功通知
        self::notifyUserRechargeSuccess($user, $model);

        return $this->response()->success('审核成功')->refresh();
    }

    /**
     * 送金额
     * @return string|array|void
     */
    public function sendmoney($user,$money)
    {

        \Illuminate\Support\Facades\Log::info("充值送金额");
        $recharge_fee = SystemConfig::getValue("recharge_fee");
        if($recharge_fee) {
            $amount = $money * $recharge_fee /100;
            if($amount) {
                $user = User::find($user->id);
                $user->balance += $amount;
                $user->save();
                $arr['order_no'] = $user->id.time().rand(10000,90000);
                $arr['out_trade_no'] = $user->id.time().rand(10000,90000);
                $arr['user_id'] = $user->id;
                $arr['amount'] = $amount;
                $arr['cash_fee'] = 0;
                $arr['real_money'] =$amount;
                $arr['pay_way'] = 10;
                $arr['info'] = '充值送金额';
                $arr['state'] = 2;
                Recharge::create($arr);
            }
        }
    }


    /**
     * 发红包
     * @return string|array|void
     */
    public function checkredbao($user,$money)
    {
        if(Activity::where('user_id',$user->id)->where('activity_id',1)>count()){
            $redblist=RedEnvelopes::where(array('status'=>1))->get();
            foreach ($redblist as $val){
                if($val->day_flow<$money && $val->flow_money>$money){
                    $count = $this->getUserRedpacketNum($user,$val->id);
                    if($count<$val->recharge){ //红包数小于
                        $arr['uid'] = $user->id;
                        $arr['redpacketid'] = $val->id;
                        $arr['redpacketfee'] = $val->money;
                        $arr['money'] = $money;
                        $arr['redpacketmoney'] = $money * $val->money / 100 ;
                        $arr['status'] = 0;
                        Userredpacket::create($arr);

                    }
                }
            }
        }
    }

    public function getUserRedpacketNum($user,$redpacketid)
    {
        return Userredpacket::where(array('uid'=>$user->id,'redpacketid'=>$redpacketid))->count();
    }
    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		return ['确定审核通过', ''];
	}

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }

    public function upuserlevel($uid){

        $userinfo = Users::find($uid);
        // $uservip = UserVip::where("status",1)->orderBy("id","desc")->get();
        $uservip = UserVip::where('status',1)->where('recharge','<=',$userinfo->paysum)->where('flow','<=',$userinfo->totalgame)->orderBy('id','desc')->first();
        if ($uservip) {
            $userinfo->vip = $uservip->id;
            $userinfo->save();
        }
        // dd($uservip);
        // foreach ($uservip as $val){
        //     if($userinfo->paysum>=$val->recharge && $userinfo->totalgame>=$val->flow && $userinfo->vip>$val->id){
        //         $userinfo->vip = $val->id;
        //         $userinfo->save();
        //         break;
        //     }
        // }
    }

    /**
     * 发送Telegram充值成功通知
     */
    public static function notifyUserRechargeSuccess($user, $order)
    {
        try {
            if (empty($user->telegram_id)) {
                return;
            }

            $telegramBot = new TelegramBotService();

            $walletBalance = number_format($user->balance, 2);
            $text = "✅ <b>充值成功</b>\n\n";
            $text .= "订单编号：<code>{$order->id}</code>\n";
            $text .= "充值金额：<b>{$order->amount}</b> 元\n";
            if ($order->tron_usdt_amount) {
                $text .= "USDT金额：<b>{$order->tron_usdt_amount} USDT</b>\n";
            }
            $text .= "\n💵 余额：<b>{$walletBalance}</b> 元\n";
            $text .= "\n💰 感谢使用！";

            $inlineKeyboard = [
                [['text' => '🏠 返回主菜单', 'callback_data' => 'back_main']]
            ];

            // 如果有保存消息ID，则编辑原消息；否则发送新消息
            if (!empty($order->telegram_message_id)) {
                // 获取主菜单图片URL用于编辑
                $mainImageConfig = \App\Models\SystemConfig::getValue('telegram_bot_main_image');
                $mainImageUrl = null;
                if ($mainImageConfig) {
                    $mainImageUrl = env('APP_URL') . '/uploads/' . $mainImageConfig;
                } else {
                    $mainImageUrl = env('APP_URL') . '/images/telegram/main_banner.jpg';
                }

                $telegramBot->editMessageMedia($user->telegram_id, $order->telegram_message_id, $mainImageUrl, $text, $inlineKeyboard);
            } else {
                $telegramBot->sendMessageWithInlineKeyboard($user->telegram_id, $text, $inlineKeyboard);
            }

            \Illuminate\Support\Facades\Log::info('后台审核充值通知已发送', [
                'user_id' => $user->id,
                'telegram_id' => $user->telegram_id,
                'order_id' => $order->id,
                'edited_message' => !empty($order->telegram_message_id)
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('发送充值成功通知失败', [
                'error' => $e->getMessage(),
                'order_id' => $order->id
            ]);
        }
    }
}
