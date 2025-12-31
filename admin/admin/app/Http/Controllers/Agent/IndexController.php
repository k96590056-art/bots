<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\GameRecord;
use App\Models\Message;
use App\Models\Recharge;
use App\Models\TransferLog;
use App\Models\Withdraw;
use App\Services\GamereportService;
use App\Services\TgService;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;  
use App\Models\SystemConfig;
use App\Models\Article;

class IndexController extends Controller
{
    public function __construct()
    {
        try {
            $logo = SystemConfig::getValue('app_logo');
            $url  = '';
            if ($logo) {
                if (strpos($logo, 'http') === 0) {
                    $url = $logo;
                } elseif (strpos($logo, '/') === 0) {
                    // 已是绝对路径（/uploads/xxx.png）
                    $url = env('APP_URL') . $logo;
                } else {
                    // 仅文件名，拼接uploads
                    $url = env('APP_URL') . '/uploads/' . $logo;
                }
            }
            view()->share('app_logo', $url);
        } catch (\Throwable $e) {
            // 防止因数据库/配置异常导致500，降级为空
            \Log::error('Load app_logo failed', [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
            ]);
            view()->share('app_logo', '');
        }
    }
    public function index()
    {
        $user = Auth::user();
        $child = User::getAllChildIds($user->id);
        array_push($child, $user->id);
        $child = array_unique($child);

        $list = User::whereIn('id',$child)->get();
        $start = $data['start'] ?? '';
        $end = $data['end'] ?? '';
        $all_recharge = 0;
        $all_withdraw= 0;
        $all_valid_bet= 0;
        $all_win_loss= 0;
        foreach ($list as $k => $v) {
            $all_recharge += User::rechargeSum($v->id,$start,$end); //总存款
            $all_withdraw += User::withdrawSum($v->id,$start,$end); //总提款
            $all_valid_bet += User::vaildBetSum($v->id,$start,$end); //总有效投注
            $all_win_loss += User::totalfanhui($v->id,$start,$end); //总输赢
        }
        // 首页“最新公告”：读取网站后台公告（Article），类别 cateid=6
        $list = Article::where('cateid', 6)
            ->orderBy('id', 'desc')
            ->paginate(6);




        return view('agent.index', compact('user','list','all_recharge','all_withdraw','all_valid_bet','all_win_loss'));
    }

    public function getuserdata(){
        $user = Auth::user();
        $ret = User::getBetDayDta($user->id,6);
        echo json_encode($ret);
    }

    public function notice()
    {
        // 公告列表：网站后台公告（Article）类别 cateid=6
        $list = Article::where('cateid', 6)
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('agent.notice.notice', compact('list'));
    }
    public function message()
    {
        $user = Auth::user();
        // 站内信列表：读取网站后台站内信(messages表)任意类型
        // 可见范围：发给当前代理(user_id=当前) 或 群发给代理(user_id=0 且 isagent=1)
        $list = Message::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere(function ($q) {
                          $q->where('user_id', 0)
                            ->where('isagent', 1);
                      });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('agent.notice.message', compact('list'));
    }

    // 站内信详情
    public function messageDetail($id)
    {
        $user = Auth::user();
        $item = Message::where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere(function ($q) {
                          $q->where('user_id', 0)
                            ->where('isagent', 1);
                      });
            })
            ->firstOrFail();
        return view('agent.notice.message_detail', compact('item'));
    }
    public function noticeDetail($id)
    {
        // 公告详情：读取 Article 详情
        $item = Article::find($id);
        return view('agent.notice.notice_detail', compact('item'));
    }

    /**
     * 图表
     *
     * @return void
     */
    public function chart()
    {
        return view('agent.report.chart');
    }

    /**
     * 今日概况
     *
     * @return void
     */
    public function todayData()
    {
        $user = Auth::user();
        // 下级会员数
        $child_member = User::getChildMember($user->id);
        $child_member_count = count($child_member);
        // 下级代理
        $child_agent = User::getChildAgent($user->id);
        $child_agent_count = count($child_agent);
        // 直属会员
        $directly_member_count = User::where('pid', $user->id)->where('isagent', 0)->count();
        // 直属代理数
        $directly_agent_count = User::where('pid', $user->id)->where('isagent', 1)->count();
        // 今日新增会员数
        $add_member_count = User::where('pid', $user->id)->whereDate('created_at', date('Y-m-d'))->count();
        // 今日总存款
        $all_child = User::getAllChildIds($user->id);
        $all_recharge = Recharge::whereIn('user_id', $all_child)->whereDate('created_at', date('Y-m-d'))->where('state', 2)->sum('amount');
        // 今日总提款
        $all_withdraw = Withdraw::whereIn('user_id', $all_child)->whereDate('created_at', date('Y-m-d'))->where('state', 2)->sum('amount');
        // 今日投注
        $all_bet = GameRecord::whereIn('user_id', $all_child)->whereDate('created_at', date('Y-m-d'))->sum('bet_amount');
        // 今日有效投注
        $all_valid_bet = GameRecord::whereIn('user_id', $all_child)->whereDate('created_at', date('Y-m-d'))->sum('valid_amount');
        // 今日输赢
        $win_loss =  GameRecord::whereIn('user_id', $all_child)->whereDate('created_at', date('Y-m-d'))->sum('win_loss');
        return view('agent.report.today_data',compact('child_member_count','child_agent_count','directly_member_count','directly_agent_count','add_member_count','all_recharge','all_withdraw','all_bet','all_valid_bet','win_loss'));
    }

    /**
     * 盈亏报表
     *
     * @return void
     */
    public function profit(Request $request)
    {
        $data = $request->all();
        $username = $data['username'] ?? '';

        $user = Auth::user();
        $child = User::getAllChildIds($user->id);
        array_push($child,$user->id);
        $child = array_unique($child);
        
        if ($username) {
            $search_user = User::where('username',$username)->first();
            if (!$search_user) {
                return back()->with('opMsg','用户不存在');
            }
            if (!in_array($search_user->id,$child)) {
                return back()->with('opMsg','用户不在您的下级列表中');
            }
        }
        
        $list = User::whereIn('id',$child)->paginate(10);
        $start = $data['start'] ?? '';
        $end = $data['end'] ?? '';
        foreach ($list as $k => $v) {
            $rechage_times = User::rechargeTimes($v->id,$start,$end); //充值次数
            $withdraw_times = User::withdrawTimes($v->id,$start,$end); //提现次数
            $all_recharge = User::rechargeSum($v->id,$start,$end); //总存款
            $all_withdraw = User::withdrawSum($v->id,$start,$end); //总提款
            $all_valid_bet = User::vaildBetSum($v->id,$start,$end); //总有效投注
            $all_win_loss = User::winLoss($v->id,$start,$end); //总输赢
            $list[$k]->rechage_times = $rechage_times;
            $list[$k]->withdraw_times = $withdraw_times;
            $list[$k]->all_recharge = $all_recharge;
            $list[$k]->all_withdraw = $all_withdraw;
            $list[$k]->all_valid_bet = $all_valid_bet;
            $list[$k]->all_win_loss = $all_win_loss;
        }
        return view('agent.report.profit',compact('list','start','end','username'));
    }


    /**
     * 佣金报表
     *
     * @return void
     */
    public function commission(Request $request)
    {
        $data = $request->all();
        $username = $data['username'] ?? '';
        $user = Auth::user();
        $child = User::getAllChildIds($user->id);
        array_push($child,$user->id);
        $child = array_unique($child);

        $lists = User::whereIn('id',$child)->get();
        $start = $data['start'] ?? '';
        $end = $data['end'] ?? '';
        $rechage_times =0;
        $withdraw_times =0;
        $all_recharge =0;
        $all_withdraw =0;
        $all_valid_bet =0;
        $all_win_loss =0;
        $usersum =0;
        $agentsum =0;
        $all_fanshui = 0;
        $all_redpacket = 0;
        $all_valid_betsum = 0;
        $yongjinsum =0;
        $waityongjinsum = 0;
        foreach ($lists as $k => $v) {
            $rechage_times += User::rechargeTimes($v->id,$start,$end); //充值次数
            $withdraw_times += User::withdrawTimes($v->id,$start,$end); //提现次数
            $all_recharge += User::rechargeSum($v->id,$start,$end); //总存款
            $all_withdraw += User::withdrawSum($v->id,$start,$end); //总提款
            $all_valid_bet += User::vaildBetSum($v->id,$start,$end); //总有效投注
            $all_valid_betsum += User::vaildBetCount($v->id,$start,$end); //总有效投注


            $all_win_loss += User::winLoss($v->id,$start,$end); //总输赢
            $all_fanshui += User::totalfanhui($v->id,$start,$end); //总输赢
            $all_redpacket += User::redpacketSum($v->id,$start,$end); //总输赢

            $usersum += User::UserSum($v->id,$start,$end); //下级会员

            $agentsum += User::AgentSum($v->id,$start,$end); //下级代理

            //$yongjinsum += User::Agentyongjin($v->id,$start,$end); //已结算佣金统计
            
            //$waityongjinsum +=User::Agentyongjinwait($v->id,$start,$end); //未结算佣金统计
        }
        $yongjinsum = TransferLog::where('user_id',$user->id)->where('state',1)->where('transfer_type',999)->sum('yongjin');
        $waityongjinsum = TransferLog::where('user_id',$user->id)->where('state',2)->where('transfer_type',999)->sum('yongjin');

        $list = array();
        $list[0]['username'] = $user->username;
        $list[0]['realname'] = $user->realname;
        $list[0]['isagent'] = $user->isagent;
        $list[0]['rechage_times'] = $rechage_times;
        $list[0]['withdraw_times'] = $withdraw_times;
        $list[0]['all_recharge'] = $all_recharge;
        $list[0]['all_withdraw'] = $all_withdraw;
        $list[0]['all_valid_bet'] = $all_valid_bet;
        $list[0]['all_win_loss'] = $all_win_loss;
        $list[0]['all_fanshui'] = $all_fanshui;
        $list[0]['all_redpacket'] = $all_redpacket;
        $list[0]['all_valid_betsum'] = $all_valid_betsum;

        // $list[0]['usersum'] = $usersum;
        // $list[0]['agentsum'] = $agentsum;
        // $list[0]['yongjinsum'] = $yongjinsum;
        // $list[0]['waityongjinsum'] = $waityongjinsum;
        // $list[0]['rechage_times'] = $rechage_times + User::rechargeTimes($user->id,$start,$end);
        // $list[0]['withdraw_times'] = $withdraw_times+ User::withdrawTimes($user->id,$start,$end);
        // $list[0]['all_recharge'] = $all_recharge+ User::rechargeSum($user->id,$start,$end);
        // $list[0]['all_withdraw'] = $all_withdraw+ User::withdrawSum($user->id,$start,$end);
        // $list[0]['all_valid_bet'] = $all_valid_bet+ User::vaildBetSum($user->id,$start,$end);
        // $list[0]['all_win_loss'] = $all_win_loss+ User::winLoss($user->id,$start,$end);
        // $list[0]['all_fanshui'] = $all_fanshui+ User::totalfanhui($user->id,$start,$end);
        // $list[0]['all_redpacket'] = $all_redpacket+ User::redpacketSum($user->id,$start,$end);
        // $list[0]['all_valid_betsum'] = $all_valid_betsum+ User::vaildBetCount($user->id,$start,$end);
        $list[0]['usersum'] = $usersum;
        $list[0]['agentsum'] = $agentsum;
        $list[0]['yongjinsum'] = $yongjinsum;
        //$list[0]['waityongjinsum'] = $this->getwaityongjinsum($user->id);
        $list[0]['waityongjinsum'] = $waityongjinsum;
        $list = self::arrayToObject($list);

        return view('agent.report.commission',compact('list','start','end','username'));
    }
    
    protected function getwaityongjinsum($user_id)
    {
        $id = $user_id;
        $money = 0;
        $settlementday = intval(SystemConfig::getValue('settlement'));
        $diffday = strtotime(date('Y-m-d'))-$settlementday*60*60*24;
        $val = User::where('isagent','=',1)->where('id','=',$id)->first();
        if ($val){
            $transfermoney = TransferLog::where("state",2)->where('user_id',$val->id)->where('transfer_type',20)->sum('money');
            $money = $transfermoney;

            // $child = User::getChild($val->id);
            // $list = User::whereIn('id',$child)->get();
            // $totalfanhui = 0;
            // $totalredpacketSum =0;
            // $totalRechargeredpacketSum =0;
            // foreach ($list as $k => $v) {
            //     //反水
            //     $totalfanhui += User::totalfanhui($v->id, date('Y-m-d', $diffday) . ' 00:00:00', date('Y-m-d', time()) . ' 23:59:59');
            //     //紅包
            //     $totalredpacketSum +=   User::redpacketSum($v->id, date('Y-m-d', $diffday) . ' 00:00:00', date('Y-m-d', time()) . ' 23:59:59');
            //     // 充值送红包
            //     $totalRechargeredpacketSum +=   User::RechargeredpacketSum($v->id, date('Y-m-d', $diffday) . ' 00:00:00', date('Y-m-d', time()) . ' 23:59:59');
            // }
            // $user = User::where('id',$val->id)->first();
            // $money =  $transfermoney -  $totalfanhui - $totalredpacketSum - $totalRechargeredpacketSum;
        }
        return $money > 0 ? $money : 0;
    }
    
    
    function arrayToObject($e){
        if( gettype($e)!='array' ) return;
        foreach($e as $k=>$v){
            if( gettype($v)=='array' || getType($v)=='object' )
                $e[$k]=(object)self::arrayToObject($v);
        }
        return (object)$e;
    }

    /**
     * 佣金报表
     *
     * @return void
     */
    public function subordinate(Request $request)
    {
        $data = $request->all();
        $username = $data['username'] ?? '';

        $user = Auth::user();
        $child = User::getAllChildIds($user->id);
        
        if ($username) {
            $search_user = User::where('username',$username)->first();
            if (!$search_user) {
                return back()->with('opMsg','用户不存在');
            }
            if (!in_array($search_user->id,$child->toArray())) {
                return back()->with('opMsg','用户不在您的下级列表中');
            }
        }
        $list = User::whereIn('id',$child)->where('isagent',1)->paginate(10);
        $start = $data['start'] ?? '';
        $end = $data['end'] ?? '';
        foreach ($list as $k => $v) {

            $res = self::agentcommission($v->id,$start,$end);

            $list[$k]->rechage_times = $res['rechage_times'];
            $list[$k]->withdraw_times = $res['withdraw_times'];
            $list[$k]->all_recharge = $res['all_recharge'];
            $list[$k]->all_withdraw = $res['all_withdraw'];
            $list[$k]->all_valid_bet = $res['all_valid_bet'];
            $list[$k]->all_win_loss = $res['all_win_loss'];
            $list[$k]->all_fanshui = $res['all_fanshui'];
            $list[$k]->all_redpacket = $res['all_redpacket'];


            $list[$k]->usersum = User::UserSum($v->id,$start,$end);;
            $list[$k]->agentsum = User::AgentSum($v->id,$start,$end);
            // $list[$k]->yongjinsum = $res['yongjinsum'];
            //$list[$k]->yongjinsum = $this->getwaityongjinsum($v->id);
            $list[$k]->yongjinsum = TransferLog::where('user_id',$v->id)->where('transfer_type',999)->sum('yongjin');
        }
        return view('agent.report.subordinate',compact('list','start','end','username'));
    }



    /**
     * 佣金报表
     *
     * @return void
     */
    public function agentcommission($user_id,$start,$end)
    {

        $child = User::getAllChildIds($user_id);
        $lists = User::whereIn('id',$child)->get();
        $start = $data['start'] ?? '';
        $end = $data['end'] ?? '';
        $rechage_times =0;
        $withdraw_times =0;
        $all_recharge =0;
        $all_withdraw =0;
        $all_valid_bet =0;
        $all_win_loss =0;
        $usersum =0;
        $agentsum =0;
        $all_fanshui=0;
        $all_redpacket = 0;
        foreach ($lists as $k => $v) {
            $rechage_times += User::rechargeTimes($v->id,$start,$end); //充值次数
            $withdraw_times += User::withdrawTimes($v->id,$start,$end); //提现次数
            $all_recharge += User::rechargeSum($v->id,$start,$end); //总存款
            $all_withdraw += User::withdrawSum($v->id,$start,$end); //总提款
            $all_valid_bet += User::vaildBetSum($v->id,$start,$end); //总有效投注
            $all_win_loss += User::winLoss($v->id,$start,$end); //总输赢

            $all_fanshui += User::totalfanhui($v->id,$start,$end); //总输赢
            $all_redpacket += User::redpacketSum($v->id,$start,$end); //总输赢
            //
            $usersum += User::UserSum($v->id,$start,$end); //下级会员

            $agentsum += User::AgentSum($v->id,$start,$end); //下级代理


        }


        $yongjinsum = User::Agentyongjin($user_id,$start,$end); //佣金统计
        $list = array();
        $list['rechage_times'] = $rechage_times;
        $list['withdraw_times'] = $withdraw_times;
        $list['all_recharge'] = $all_recharge;
        $list['all_withdraw'] = $all_withdraw;
        $list['all_valid_bet'] = $all_valid_bet;
        $list['all_win_loss'] = $all_win_loss;
        $list['all_fanshui'] = $all_fanshui;
        $list['all_redpacket'] = $all_redpacket;
        $list['yongjinsum'] = $yongjinsum;
        $list['usersum'] = $yongjinsum;
        $list['agentsum'] = $yongjinsum;


        return $list;
    }

    /**
     * 添加下级会员
     */
    public function addMember(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (strlen($data['username']) < 6) return back()->with('opMsg','用户名至少6位');
            $user = User::where('username',$data['username'])->first();
            $puser = Auth::user();
            if ($user) return back()->with('opMsg','用户名已存在');

            // 确定是否为代理及权限
            // 如果上级代理层级 <= 4，则新用户默认为代理
            // 如果上级代理层级 > 4，则新用户强制为会员
            $current_level = $puser->agent_level ?: 1;
            $new_level = $current_level + 1;
            
            $is_agent = 1; // 默认为代理
            $allow_agent = 0; // 默认不允许发展下级

            if ($current_level > 4) {
                // 上级已经是5级或以上，只能发展会员
                $is_agent = 0;
                $allow_agent = 0;
            } else {
                // 上级是1-4级，可以发展代理
                $is_agent = 1;
                // 如果新代理是1-4级，允许发展下级；如果是5级，不允许
                if ($new_level <= 4) {
                    $allow_agent = 1;
                } else {
                    $allow_agent = 0;
                }
            }

            // 旧逻辑保留作为兜底：如果上级明确被禁止发展代理，则强制设为非代理
            $pp_user = User::where('id',$puser->pid)->first();
            // 注意：这里原逻辑是检查爷爷辈的allowagent，可能不太准确，应该主要依赖puser的权限
            // 但为了兼容旧数据，如果puser本身allowagent=0，则强制不能添加代理
            if ($puser->allowagent == 0) {
                 $is_agent = 0;
            }

            $arr = [
                'username' => $data['username'],
                'pid' => $puser->id,
                'password' => Hash::make($data['password']),
                'realname' => $data['realname'],
                'paypwd' => Hash::make('123456'),
                'vip' => 1,
                'isagent' => $is_agent,
                'allowagent' => $allow_agent, // 设置是否允许发展下级
                'region_id' => $puser->region_id, // 继承上级的所属地区
                'agent_level' => $new_level, // 设置代理层级
                'level' => $new_level, // 同步更新level字段
            ];

            // 获取可用的api_code，优先使用'ag'，如果不存在则使用第一个可用的
            /*$tg = New TgService;
            $api = \App\Models\Api::where('state', 1)->where('api_code', 'ag')->first();
            if (!$api) {
                $api = \App\Models\Api::where('state', 1)->first();
            }
            
            if (!$api) {
                return back()->with('opMsg','没有可用的游戏平台，请联系管理员');
            }
            
            $result = $tg->register($api->api_code, $arr['username'], $data['password']);
            if ($result['code'] != 200) {
                return back()->with('opMsg',$result['message']);
            }*/
            User::create($arr);

/*            if($puser->id){
                $puser = User::where('id',$puser->pid)->first();
                $Gamereport = new GamereportService();
                $data['uid'] = $puser->id;
                $data['pid'] = $puser->pid;
                $data['isagent'] = $puser->isagent;
                $data['recnum'] =  1;
                $Gamereport->add($data);
            }*/

             return redirect('/memberlist')->with('opMsg', '添加成功');
        }
        return view('agent.agent.add_member');
    }

    /**
     * 会员列表
     *
     * @param Request $request
     * @return void
     */
    public function memberList(Request $request)
    {
        $user = Auth::user();
        $username = $request->input('username') ?? '';
        
        // 使用 Models\Users 获取所有下级ID，因为它提供了更可靠的递归方法
        $userModel = \App\Models\Users::find($user->id);
        $child = $userModel ? $userModel->getAllChildrenIds() : [];
        
        // 构建查询
        $query = User::where('status', 1);

        // 权限控制：如果层级<=4，可以查看下级（递归）和同地区会员
        if ($user->agent_level <= 4) {
            $query->where(function($q) use ($child, $user) {
                // 1. 递归下级（包括代理和会员）
                $q->whereIn('id', $child);
                
                // 2. 同地区的所有会员
                if (!empty($user->region_id)) {
                    $q->orWhere(function($subQ) use ($user) {
                        $subQ->where('region_id', $user->region_id)
                             ->where('isagent', 0);
                    });
                }
            });
        } else {
            // 其他层级只看递归下级
            $query->whereIn('id', $child);
        }

        // 如果有搜索条件，添加到查询中
        if (!empty($username)) {
            $query->where('username', 'like', '%' . $username . '%');
        }

        $list = $query->paginate(10);
        
        // 保留查询参数
        $list->appends(['username' => $username]);

        foreach ($list as $k =>$v) {
            $parent = User::find($v->pid);
            $list[$k]->parent = $parent ? $parent->username : '';
            $list[$k]->is_direct = ($v['pid'] == $user->id || $v['fid'] == $user->id) ? 1 : 0;
        }
        return view('agent.agent.member',compact('list','user'));
    }

    /**
     * 下注记录
     *
     * @param Request $request
     * @return void
     */
    public function betLog(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $username = $request->input('username') ?? '';
        $child = User::getAllChildIds($user->id);
        array_push($child, $user->id);
        $child = array_unique($child);

        $start = $data['start'] ?? '';
        $end = $data['end'] ?? '';
        $list = GameRecord::whereIn('user_id',$child)
            ->when($username,function ($query) use ($username){
                return $query->where('username',$username);
            })->when($start, function ($query) use ($start) {
                $start = date('Y-m-d 00:00:00', strtotime($start));
                return $query->where('created_at', '>', $start);
            })->when($end, function ($query) use ($end) {
                $end = date('Y-m-d 23:59:59', strtotime($end));
                return $query->where('created_at', '<=', $end);
            })->orderBy('id','desc')->paginate(10);
        return view('agent.agent.bet_log',compact('list'));
    }

    /**
     * 充值记录
     *
     * @param Request $request
     * @return void
     */
    public function rechargeLog(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $username = $request->input('username') ?? '';
        $user_id = User::where('username',$username)->value('id') ?? '';
        $child = User::getAllChildIds($user->id);
        array_push($child, $user->id);
        $child = array_unique($child);

        $start = $data['start'] ?? '';
        $end = $data['end'] ?? '';
        $list = Recharge::whereIn('user_id',$child)
            ->when($user_id,function ($query) use ($user_id){
                return $query->where('user_id',$user_id);
            })->when($start, function ($query) use ($start) {
                $start = date('Y-m-d 00:00:00', strtotime($start));
                return $query->where('created_at', '>', $start);
            })->when($end, function ($query) use ($end) {
                $end = date('Y-m-d 23:59:59', strtotime($end));
                return $query->where('created_at', '<=', $end);
            })->orderBy('id','desc')->paginate(10);
        return view('agent.agent.recharge_log',compact('list'));
    }

    /**
     * 提现记录
     *
     * @param Request $request
     * @return void
     */
    public function withdrawLog(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $username = $request->input('username') ?? '';
        $user_id = User::where('username',$username)->value('id') ?? '';
        $child = User::getAllChildIds($user->id);
        array_push($child, $user->id);
        $child = array_unique($child);

        $start = $data['start'] ?? '';
        $end = $data['end'] ?? '';
        $list = Withdraw::whereIn('user_id',$child)
            ->when($user_id,function ($query) use ($user_id){
                return $query->where('user_id',$user_id);
            })->when($start, function ($query) use ($start) {
                $start = date('Y-m-d 00:00:00', strtotime($start));
                return $query->where('created_at', '>', $start);
            })->when($end, function ($query) use ($end) {
                $end = date('Y-m-d 23:59:59', strtotime($end));
                return $query->where('created_at', '<=', $end);
            })->orderBy('id','desc')->paginate(10);
        return view('agent.agent.recharge_log',compact('list'));
    }

    /**
     * 转账记录
     *
     * @param Request $request
     * @return void
     */
    public function transferLog(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $username = $request->input('username') ?? '';
        $user_id = User::where('username',$username)->value('id') ?? '';
        $child = User::getAllChildIds($user->id);
        array_push($child, $user->id);
        $child = array_unique($child);

        $start = $data['start'] ?? '';
        $end = $data['end'] ?? '';
        $list = TransferLog::whereIn('user_id',$child)->whereIn('transfer_type',[0,1])
            ->when($user_id,function ($query) use ($user_id){
                return $query->where('user_id',$user_id);
            })->when($start, function ($query) use ($start) {
                $start = date('Y-m-d 00:00:00', strtotime($start));
                return $query->where('created_at', '>', $start);
            })->when($end, function ($query) use ($end) {
                $end = date('Y-m-d 23:59:59', strtotime($end));
                return $query->where('created_at', '<=', $end);
            })->orderBy('id','desc')->paginate(10);
        return view('agent.agent.transfer_log',compact('list'));
    }


    /**
     * 提现记录
     *
     * @param Request $request
     * @return void
     */
    public function releasewaterLog(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $username = $request->input('username') ?? '';
        $user_id = User::where('username',$username)->value('id') ?? '';
        $child = User::getAllChildIds($user->id);
        array_push($child, $user->id);
        $child = array_unique($child);

        $start = $data['start'] ?? '';
        $end = $data['end'] ?? '';
        $list = TransferLog::whereIn('user_id',$child)->where('transfer_type',6)
            ->when($user_id,function ($query) use ($user_id){
                return $query->where('user_id',$user_id);
            })->when($start, function ($query) use ($start) {
                $start = date('Y-m-d 00:00:00', strtotime($start));
                return $query->where('created_at', '>', $start);
            })->when($end, function ($query) use ($end) {
                $end = date('Y-m-d 23:59:59', strtotime($end));
                return $query->where('created_at', '<=', $end);
            })->orderBy('id','desc')->paginate(10);
        return view('agent.agent.releasewater_log',compact('list'));
    }
    
    public function generateQrcode()
    {
        $user = Auth::user();
        // 使用智能跳转链接生成二维码（手机端链接，但会自动适配设备）
        $str = env('AGENT_URL')."/promotion?pid=".$user->id."&type=wap";
        // $folder = '/uploads/agent/qrcode';
        // if (!is_dir($folder)) mkdir($folder,0777,true);
        // $filename = $folder.'/'.$user->id.'.png';
        $filename = public_path('uploads/agent/qrcode/'.$user->id.'.png');
        // if (!file_exists($filename)) {
            QrCode::encoding('UTF-8')->format('png')->size(500)->generate($str,$filename); 
        // }
        return response()->download($filename,uniqid().'.png');
        
    }
    
    /**
     * 显示二维码图片
     */
    public function showQrcode()
    {
        $user = Auth::user();
        // 使用智能跳转链接（手机端链接，但会自动适配设备）
        $mobileUrl = env('AGENT_URL')."/promotion?pid=".$user->id."&type=wap";
        
        // 生成二维码并直接返回图片
        $qrcode = QrCode::encoding('UTF-8')
            ->format('png')
            ->size(200)
            ->generate($mobileUrl);
            
        return response($qrcode)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'public, max-age=3600');
    }
    
    //下级充值
    public function recharge(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (!isset($data['amount']) || !is_numeric($data['amount']) || $data['amount'] < 0) return back()->with('opMsg','请输入正确的金额');
            $user = Auth::user();
            if ($data['amount'] > $user->balance) return back()->with('opMsg','余额不足');
            $user->balance -= $data['amount'];
            $user->save();
            $child = User::find($data['user_id']);
            $child->balance += $data['amount'];
            $child->save();
            $arr['order_no'] = $child->id.time().rand(10000,90000);
            $arr['out_trade_no'] = $child->id.time().rand(10000,90000);
            $arr['user_id'] = $child->id;
            $arr['amount'] = $data['amount'];
            $arr['cash_fee'] = 0;
            $arr['real_money'] = $data['amount'];
            $arr['pay_way'] = 11;
            $arr['info'] = '代理充值';
            $arr['state'] = 2;
            Recharge::create($arr);
            return redirect('/memberlist')->with('opMsg', '充值成功');
        }
        $user_id = $request->input('user_id');
        return view('agent.agent.recharge',compact('user_id'));
    }
    
    /**
     * 推广链接跳转 - 根据设备类型自动跳转到对应的链接
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function promotionRedirect(Request $request)
    {
        $pid = $request->input('pid', 0);
        $type = $request->input('type', 'pc'); // pc 或 wap
        
        // 验证pid是否为有效数字
        $pid = intval($pid);
        if ($pid <= 0) {
            // 如果pid无效，跳转到默认注册页面
            $defaultUrl = $this->isMobile() ? env('WAP_URL') : env('PC_URL');
            return redirect($defaultUrl . '/#/register');
        }
        
        // 检测当前设备类型
        $isMobileDevice = $this->isMobile();
        
        // 根据设备类型和链接类型决定跳转目标
        if ($type === 'pc') {
            // 如果是PC端链接
            if ($isMobileDevice) {
                // 手机访问PC链接，跳转到手机端
                $targetUrl = env('WAP_URL') . '/#/register?pid=' . $pid;
            } else {
                // PC访问PC链接，保持PC端
                $targetUrl = env('PC_URL') . '/#/register?pid=' . $pid;
            }
        } else {
            // 如果是手机端链接
            if ($isMobileDevice) {
                // 手机访问手机链接，保持手机端
                $targetUrl = env('WAP_URL') . '/#/register?pid=' . $pid;
            } else {
                // PC访问手机链接，跳转到PC端
                $targetUrl = env('PC_URL') . '/#/register?pid=' . $pid;
            }
        }
        
        return redirect($targetUrl);
    }

    public function regionMemberList(Request $request)
    {
        $user = Auth::user();
        
        // Permission check: only level 1 agents with no parent (pid=0 or null)
        if ($user->agent_level != 1 || ($user->pid != 0 && !empty($user->pid))) {
             abort(403, 'Unauthorized action.');
        }

        $username = $request->input('username');
        $region_id = $request->input('region_id');

        $query = User::where('isagent', 0); // Only non-agent members

        if ($username) {
            $query->where('username', 'like', '%' . $username . '%');
        }

        if ($region_id) {
            $query->where('region_id', $region_id);
        }

        $list = $query->orderBy('id', 'desc')->paginate(15);
        
        // Append query parameters to pagination links
        $list->appends($request->all());

        // Get all regions for filter
        $regions = \App\Models\Region::all();

        return view('agent.agent.region_member', compact('list', 'regions', 'user'));
    }
}
