<?php
//decode by http://www.yunlu99.com/
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityApply;
use App\Models\ActivityType;
use App\Models\Bank;
use App\Models\Api;
use App\Models\User_Api;
use App\Models\Message;
use App\Models\UserMessage;
use App\Models\PaySetting;
use App\Models\SystemConfig;
use App\Models\UserCard;
use App\Models\User;
use App\Models\Users;
use App\Models\Usersmoney;
use App\Services\TgService;
use App\Services\DbdianziService;
use App\Services\DbgmagService;
use App\Services\DbevoService;
use App\Services\DbkaiyuanService;
use App\Services\Lib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransferLog;
use App\Models\Recharge;
use App\Models\Withdraw;
use App\Models\Article;
use App\Models\UserVip;
use App\Models\Banner;
use App\Models\GameRecord;
use App\Models\AgentApply;
use App\Models\GameList;
use App\Models\GameListApp;
use App\Models\GameCategory;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    protected $messages = [];
    protected $game_list ;
    protected $banklist;

    public function __construct()
    {
        $tg = New TgService;

        $this->game_list =$tg->getallgamename();
        $this->gamemoney_list =$tg->getallmoneygamelist();
        $this->banklist = ['工商银行'=>'Icbc','中国农业银行'=>'Abc','招商银行'=>'Cmb','建设银行'=>'Ccb','中信银行'=>'Cibk','中国银行'=>'Boc','交通银行'=>'Bocom','华夏银行'=>'Hxbc','民生银行'=>'Cmbc','光大银行'=>'Cebc','兴业银行'=>'Fjib','浦发银行'=>'Spdb'];
        
        // 改进域名验证逻辑，使用 Request 对象而不是 $_SERVER
        $domain = SystemConfig::getValue('safe_domain');
        if ($domain) {
            $allowedDomains = array_filter(array_map('trim', explode(',', $domain)));
            
            // 严格验证域名格式
            $allowedDomains = array_filter($allowedDomains, function($domain) {
                return filter_var($domain, FILTER_VALIDATE_URL) && 
                       in_array(parse_url($domain, PHP_URL_SCHEME), ['http', 'https']);
            });
            
            // 注意：这里不能直接使用 request() 函数，因为构造函数中还没有 Request 对象
            // 实际的域名验证应该在具体的请求方法中进行
        }
    }
    public function credit(Request $request)
    {
        $api_code = $request->input('api_code');
		$tg = New TgService;
		$data = $tg->credit($api_code);
        return $data;
    }
    
    /**
     * 公告列表
     *
     * @return void
     */
    public function bannerList(Request $request)
    {
        $type = $request->input('type') ?? 2;
        $bannerlist = array(
            ["src"=>"/static/style/2ddb21b7a3564870bbac1b02e05b3f8d.jpg","background"=>"#f4f6ff"],
            ["src"=>"/static/style/008dc0a27cdf42708dcce9b516695469.jpg","background"=>"rgb(100, 61, 202)"],
            );
        $notice = Banner::where('type',$type)->select("pic as src","jump_url")->get()->toArray();    
       
        if(count($notice)){
            $bannerlist=[];
            foreach ($notice as $val){
                $bannerlist[]=["src"=>env('APP_URL').'/uploads/'.$val['src'],"background"=>"#f4f6ff",'url'=>$val['jump_url']] ;
            }        
        }
        return $this->returnMsg(200, $bannerlist);
    }
    
    public function article(Request $request)
    {
        $type = $request->input('type');
        $data = Article::where('cateid',$type)->first();
        return $this->returnMsg(200,$data);
    }
    
    /**
     * 公告列表
     *
     * @return void
     */
    public function Systemstatus()
    {
         $isclose = SystemConfig::query()->find("isclose");
         $data =[];
        if($isclose['value']){
            $webcontent = SystemConfig::query()->find("webcontent");
            $data['content'] = $webcontent['value'];
            $data['isclose'] = 0;
        }else{
            $data['content'] = '';
            $data['isclose'] = 0;
        }
        return $this->returnMsg(200, $data);
    }
        

    /**
     * 通知公告列表
     *
     * @return void
     */
    public function uservip(Request $request)
    {
        $vip = UserVip::get();
        return $this->returnMsg(200, $vip);
    }    
    /**
     * 通知公告列表
     *
     * @return void
     */
    public function homenotice(Request $request)
    {
        $notice = Article::where('cateid',6)->limit(3)->select("name")->get();
        $shownotice=[];
        foreach ($notice as $val){
            $shownotice[]=$val['name'];
        }        
        return $this->returnMsg(200, $shownotice);
    }
    /**
     * 通知公告列表
     *
     * @return void
     */
    public function homecontent(Request $request)
    {
        $notice = Article::where('cateid','<>',6)->get();
        return $this->returnMsg(200, $notice);
    }      
    /**
     * 通知公告列表
     *
     * @return void
     */
    public function homenoticelist(Request $request)
    {
        $notice = Article::where('cateid',6)->paginate(10);
        return $this->returnMsg(200, $notice);
    }   
    /**
     * 通知公告列表
     *
     * @return void
     */
    public function homenoticedeatil(Request $request)
    {
        $data = $request->all();
        $notice = Article::where('id',$data['id'])->first();
        return $this->returnMsg(200, $notice);
    }    
    /**
     * 公告列表
     *
     * @return void
     */
    public function cateList(Request $request)
    {
        $list = array(
            ["id"=>1,"pid"=>0,"name"=>"电子游艺","enname"=>"concise"],
            ["id"=>2,"pid"=>0,"name"=>"棋牌游戏","enname"=>"joker"],
            ["id"=>3,"pid"=>0,"name"=>"视讯直播","enname"=>"realbet"],
            ["id"=>4,"pid"=>0,"name"=>"彩票游戏","enname"=>"lottery"],
            ["id"=>5,"pid"=>0,"name"=>"电竞游戏","enname"=>"gaming"],
            ["id"=>6,"pid"=>0,"name"=>"体育赛事","enname"=>"sport"],
            );
        return $this->returnMsg(200, $list);
    }    
    /**
     * 获取游戏类目（返回id、name、image、code字段，图片带域名前缀）
     */
    public function getGameCategories(Request $request)
    {
        $list = GameCategory::select('id', 'name', 'image', 'code')
            ->orderBy('order')
            ->orderBy('id')
            ->get()
            ->toArray();
        $apiUrl = env('APP_URL');
        foreach ($list as $key => $value) {
            if (!empty($value['image'])) {
                $img = $value['image'];
                // 如果image不是完整的URL，则拼接API地址和uploads目录
                if (stripos($img, 'http://') !== 0 && stripos($img, 'https://') !== 0) {
                    $list[$key]['image'] = rtrim($apiUrl, '/') . '/uploads/' . ltrim($img, '/');
                }
            }
        }
        return $this->returnMsg(200, $list);
    }
    
    /**
     * PC端获取游戏类目（返回id、name、image、code字段，图片带域名前缀）
     * 基于 getGameCategories 方法
     * 增加子分类数量统计：通过 game_lists 表中属于该分类id且 child_id > 0 的不同 child_id 数量
     * 增加游戏数据列表：返回 game_lists 表中 category_id 等于 game_categories 的 code 且 child_id 为 0 的游戏数组
     */
    public function getGamePcCategories(Request $request)
    {
        $list = GameCategory::select('id', 'name', 'image', 'code', 'pid')
            ->orderBy('order')
            ->orderBy('id')
            ->get()
            ->toArray();
        $apiUrl = env('APP_URL');
        
        // 统计每个分类下的子分类数量（通过 game_lists 表中 child_id > 0 的不同 child_id 数量）
        $categoryIds = array_column($list, 'id');
        $categoryCodes = array_column($list, 'code');
        $childCounts = [];
        if (!empty($categoryIds)) {
            $childCounts = GameList::whereIn('category_id', $categoryIds)
                ->where('child_id', '>', 0)
                ->where('is_pc', 1)
                ->where('site_state', 1)
                ->select('category_id', 'child_id')
                ->distinct()
                ->get()
                ->groupBy('category_id')
                ->map(function ($items) {
                    return $items->pluck('child_id')->unique()->count();
                })
                ->toArray();
        }
        
        // 获取所有有效的接口
        $validApis = Api::where('state', 1)->pluck('api_code')->toArray();
        
        // 预取 apis 表的 app_icon
        $apiIcons = \DB::table('apis')->whereNotNull('app_icon')->pluck('app_icon', 'api_code')->toArray();
        
        // 获取每个分类下的游戏列表（根据游戏分类数据遍历，判断 code 等于 game_lists.category_id 且 pid = 0）
        $categoryGamesMap = [];
        
        // 遍历游戏分类数据，只处理 pid = 0 的主分类
        foreach ($list as $category) {
            $categoryCode = $category['code'];
            $categoryPid = $category['pid'] ?? 0;
            
            // 只处理主分类（pid = 0）
            if ($categoryPid != 0) {
                continue;
            }
            
            // 查询 category_id 等于该分类 code 且 child_id 为空或等于 0 的游戏
            $games = GameList::where('category_id', $categoryCode)
                ->where(function($query) {
                    $query->where('child_id', 0)
                          ->orWhereNull('child_id');
                })
                ->where('is_pc', 1)
                ->where('site_state', 1)
                ->select('id', 'name', 'platform_name', 'category_id', 'child_id', 'tag_id', 'game_code', 'is_hot', 'is_new', 'is_recommend', 'order_by', 'check_yes_img', 'check_no_img', 'api_logo_img', 'mobile_img', 'header_logo', 'app_img', 'app_icon')
                ->orderBy('order_by', 'asc')
                ->get();
            
            $categoryGamesMap[$categoryCode] = [];
            
            foreach ($games as $game) {
                if (!in_array($game->platform_name, $validApis)) {
                    continue;
                }
                
                $apiCode = $game->platform_name ?? '';
                $iconPath = $apiIcons[$apiCode] ?? ($game->app_icon ?? '');
                
                $categoryGamesMap[$categoryCode][] = [
                    'id' => $game->id,
                    'name' => $game->name,
                    'platform_name' => $game->platform_name,
                    'category_id' => $game->category_id,
                    'child_id' => $game->child_id,
                    'tag_id' => $game->tag_id,
                    'game_code' => $game->game_code,
                    'is_hot' => $game->is_hot,
                    'is_new' => $game->is_new,
                    'is_recommend' => $game->is_recommend,
                    'check_yes_img' => $game->check_yes_img ? env('APP_URL').'/uploads/'.$game->check_yes_img : '',
                    'check_no_img' => $game->check_no_img ? env('APP_URL').'/uploads/'.$game->check_no_img : '',
                    'api_logo_img' => $game->api_logo_img ? env('APP_URL').'/uploads/'.$game->api_logo_img : '',
                    'mobile_img' => $game->mobile_img ? env('APP_URL').'/uploads/'.$game->mobile_img : '',
                    'header_logo' => $game->header_logo ? env('APP_URL').'/uploads/'.$game->header_logo : '',
                    'app_img' => $game->app_img ? env('APP_URL').'/uploads/'.$game->app_img : '',
                    'app_icon' => $iconPath ? env('APP_URL').'/uploads/'.$iconPath : '',
                ];
            }
        }
        
        foreach ($list as $key => $value) {
            if (!empty($value['image'])) {
                $img = $value['image'];
                // 如果image不是完整的URL，则拼接API地址和uploads目录
                if (stripos($img, 'http://') !== 0 && stripos($img, 'https://') !== 0) {
                    $list[$key]['image'] = rtrim($apiUrl, '/') . '/uploads/' . ltrim($img, '/');
                }
            }
            // 添加子分类数量
            $list[$key]['children_count'] = $childCounts[$value['id']] ?? 0;
            // 添加游戏数据列表（category_id = code 且 child_id = 0）
            $list[$key]['games'] = $categoryGamesMap[$value['code']] ?? [];
        }
        return $this->returnMsg(200, $list);
    }
    /**
     * 个人消息
     *
     * @return void
     */
    public function noticeList(Request $request)
    {
        $rules = [
            'limit' => 'nullable|integer',
            'page' => 'nullable|integer',
        ];
        $this->validate($request, $rules, $this->messages);
        $data = $request->all();
        $limit = $data['limit'] ?? 10;
        $list = Message::orderBy('id', 'desc')->paginate($limit);
        return $this->returnMsg(200, $list);
    }
    /**
     * 活动类型
     *
     * @return void
     */
    public function activityType()
    {
        $list = ActivityType::all();
        return $this->returnMsg(200, $list);
    }

    /**
     * 活动列表
     *
     * @param Request $request
     * @return void
     */
    public function activityList(Request $request)
    {
        $rules = [
            'type' => 'nullable|integer'
        ];
        $this->validate($request, $rules, $this->messages);
        $data = $request->all();
        $type = $data['type'] ?? '';
        $list = Activity::when($type, function ($query) use ($type) {
            return $query->where('type', $type);
        })->where('state',1)->select('id','title','type','entitle','apply_count','banner','can_apply','state','created_at')->orderBy('id', 'desc')->paginate(99);
		foreach($list as $key => $value){
			$list[$key]['banner'] = env('APP_URL').'/uploads/'.$value['banner'];
		}
        return $this->returnMsg(200, $list);
    }
    /**
     * 活动详情
     *
     * @param Request $request
     * @return void
     */    
    public function activitydeatil(Request $request)
    {
        $rules = [
            'id' => 'nullable|integer'
        ];
        $this->validate($request, $rules, $this->messages);
        $data = $request->all();
        $id = $data['id'] ?? 0;
        $activity = Activity::where('id', $id)->first();
		$activity->app_img = env('APP_URL').'/uploads/'.$activity->app_img;
		$activity->banner = env('APP_URL').'/uploads/'.$activity->banner;
        return $this->returnMsg(200, $activity);
    }

    /**
     * 获取客服系统配置
     *
     * @return void
     */
    public function getServicerUrl()
    {
        // 获取客服系统配置
        $kefuUrl = SystemConfig::getValue('kf_url') ?? '';
        $gongdanUrl = SystemConfig::getValue('gongdan_url') ?? '';
        
        // 获取服务类型配置
        $serviceType = SystemConfig::getValue('service_type') ?? 'kefu';
        
        // 根据服务类型确定启用状态
        $kefuEnabled = ($serviceType === 'kefu') && !empty($kefuUrl);
        $gongdanEnabled = ($serviceType === 'gongdan');
        
        // 构建返回数据
        $data = [
            'kefu_url' => $kefuUrl,
            'gongdan_url' => $gongdanUrl,
            'kefu_enabled' => $kefuEnabled,
            'gongdan_enabled' => $gongdanEnabled,
            'default_system' => $serviceType,
            'show_selector' => false, // 不再显示系统选择器
            'domain' => env('APP_URL'),
            // 保持向后兼容
            'url' => $serviceType === 'kefu' ? $kefuUrl : '',
        ];
        
        return $this->returnMsg(200, $data);
    }


    /**
     * 获取游戏分类
     *
     * @param Request $request
     * @return void
     */
    public function getGameList(Request $request)
    {
        
        
        $platform = $request->input('platform_name') ?? '';
        $category = $request->input('game_type') ?? '';
        $list = GameList::when($platform,function ($query) use ($platform){
            return $query->where('platform_name',$platform);
        })->when($category,function ($query) use ($category){
            return $query->where('category_id',$category);
        })->where('is_top',1)->where('app_state',1)->select('name','game_code as gamecode','category_id','game_code','app_state')->orderBy('order_by','desc')->get();
        //return $this->returnMsg(200,$list);
        $gamelist =[];
        foreach($list as $val){
           $gamelist[$val->gamecode] =  $val->app_state;
        }
        $rules = [
            'game_type' => 'nullable',
        ];
        $this->validate($request, $rules, $this->messages);
        $data = $request->all();
        $game_type = $data['game_type'] ?? '';
        $tg = new TgService;
        $res = $tg->gametypelist($game_type);
        $gamelist1=[];
        foreach ($res['data'] as $vals){
            if((isset($gamelist[$vals['gamecode']]) && $gamelist[$vals['gamecode']]) || in_array($vals['gamecode'],['ae','fgdz','pp','obgdy'])){
                $gamelist1[] = $vals;
            }
        }
        
        return $this->returnMsg(200,$gamelist1);
        
    }

    /**
     * 获取游戏地址
     *
     * @param Request $request
     * @return void
     */
    public function getGameUrl(Request $request)
    {
        $rules = [
            'plat_name' => 'required',
            'game_type' => 'required',
            'game_code' => 'nullable',
            'is_mobile_url' => 'nullable',
        ];
        $password = "123456";
        $this->validate($request, $rules, $this->messages);
        $data = $request->all();
        $api_code = $data['plat_name'];
        $gameCode = $data['game_code'] ?? '';
        $gameType = $data['game_type'];
        
        // 如果是本地调试环境，根据设备类型判断；否则使用传入的参数
        $is_mobile_url = isset($data['is_mobile_url']) && $data['is_mobile_url'] ? $data['is_mobile_url'] : $this->isMobile();
        $is_mobile_url = $is_mobile_url ? $is_mobile_url : 1;
        $apiInfo = Api::where('api_code', $api_code)->first();
        if (!$apiInfo || (int)$apiInfo->state !== 1) {
            return $this->returnMsg(500, '', '该游戏接口已关闭');
        }
        $gameQuery = GameList::where('platform_name', $api_code);
        if (!empty($gameCode)) {
            $gameQuery->where('game_code', $gameType);
        }
        $gameItem = $gameQuery->first();
        if ($gameItem && (((int)$gameItem->site_state !== 1) || ((int)$gameItem->app_state !== 1))) {
            return $this->returnMsg(500, '', '该游戏已关闭');
        }
        $withApi = strtolower($gameItem->with_api ?? 'dp');
        
        Log::info('=== getGameUrl 接口开始处理 ===', [
            'api_code' => $api_code,
            'game_code' => $gameCode,
            'game_type' => $gameType,
            'game_item_id' => $gameItem->id ?? null,
            'game_item_with_api' => $gameItem->with_api ?? null,
            'with_api_final' => $withApi,
            'is_dp' => ($withApi === 'dp')
        ]);
        
        $serviceClass = '\\App\\Services\\' . ucfirst($withApi) . 'Service';
        if (!class_exists($serviceClass)) {
            // Special handling for Dianzi, Dbzhenren and Evo as their class names don't follow the *Service suffix pattern
            if ($withApi === 'dbdianzi') {
                $serviceClass = '\\App\\Services\\DbdianziService';
            } elseif ($withApi === 'dbgmag') {
                $serviceClass = '\\App\\Services\\DbgmagService';
            } elseif ($withApi === 'dbzhenren') {
                $serviceClass = '\\App\\Services\\DbzhenrenService';
            } elseif ($withApi === 'dbevo') {
                $serviceClass = '\\App\\Services\\DbevoService';
            } elseif ($withApi === 'dbkaiyuan') {
                $serviceClass = '\\App\\Services\\DbkaiyuanService';
            } else {
                Log::error('接口服务类不存在', ['service_class' => $serviceClass, 'with_api' => $withApi]);
                return $this->returnMsg(500, '', '接口服务不存在');
            }
        }
        $service = new $serviceClass();
        $token = $request->header('authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = User::where('api_token', $token)->lockForUpdate()->first();

        // 重要：转账/免转 开关以 game_lists 当前游戏的 transferstatus 为准（字段可能线上自定义，仓库迁移里未体现）
        // 兜底：若 game_lists 未配置该字段，则回退到 users.transferstatus
        $gameTransferstatus = null;
        if ($gameItem) {
            // 兼容可能的字段命名
            $gameTransferstatus = $gameItem->transferstatus ?? ($gameItem->transfer_status ?? ($gameItem->transferStatus ?? null));
        }
        $effectiveTransferstatus = ($gameTransferstatus === null) ? (int)($user->transferstatus ?? 0) : (int)$gameTransferstatus;
        
        // 如果是 dp 接口，从 user_api 表获取登录信息，如果没有则根据 game_code 生成
        if ($withApi === 'dp') {
            Log::info('DP接口 - 从 user_api 获取登录信息', [
                'user_id' => $user->id ?? null,
                'username' => $user->username ?? null,
                'api_code' => $api_code,
                'game_code' => $gameCode
            ]);
            
            // 根据 api_code（platform_name）从 user_api 表获取登录信息
            $User_Api = User_Api::where('api_code', $api_code)->where('user_id', $user->id)->first();
            
            if (!$User_Api || empty($User_Api->api_user)) {
                // 如果 user_api 记录不存在或 api_user 为空，根据 game_code 生成登录用户名
                Log::info('DP接口 - user_api 记录不存在，根据 game_code 生成登录用户名', [
                    'user_id' => $user->id,
                    'api_code' => $api_code,
                    'game_code' => $gameCode
                ]);
                
                // 生成 dp 登录用户名：从 venue_code 提取前缀 + 用户名
                $venueCode = $gameItem->venue_code ?? $api_code;
                $cleanGameCode = '';
                
                if (!empty($venueCode)) {
                    // 提取前2位字母（忽略数字和其他字符）
                    preg_match('/[a-zA-Z]{1,2}/', $venueCode, $matches);
                    $cleanGameCode = isset($matches[0]) ? strtoupper($matches[0]) : '';
                }
                
                // 如果提取不到字母，使用 gameCode 清理后的值作为后备
                if (empty($cleanGameCode) && !empty($gameCode)) {
                    if (preg_match('/[^a-zA-Z0-9]/', $gameCode)) {
                        $cleanGameCode = preg_replace('/[^a-zA-Z0-9]/', '', $gameCode);
                    } else {
                        $cleanGameCode = $gameCode;
                    }
                }
                
                // 生成 dp 用户名：前缀 + 用户名
                $dpUserName = $cleanGameCode . $user->username;
                
                // 创建或更新 user_api 记录
                if ($User_Api) {
                    $User_Api->api_user = $dpUserName;
                    $User_Api->api_pass = '123456';
                    $User_Api->save();
                    Log::info('DP接口 - 更新 user_api 记录', [
                        'user_id' => $user->id,
                        'api_code' => $api_code,
                        'api_user' => $dpUserName
                    ]);
                } else {
                    $User_Api = User_Api::create([
                        'user_id' => $user->id,
                        'api_code' => $api_code,
                        'api_user' => $dpUserName,
                        'api_pass' => '123456',
                        'api_money' => 0
                    ]);
                    Log::info('DP接口 - 创建 user_api 记录', [
                        'user_id' => $user->id,
                        'api_code' => $api_code,
                        'api_user' => $dpUserName
                    ]);
                }
            } else {
                Log::info('DP接口 - 从 user_api 获取到登录信息', [
                    'user_id' => $user->id,
                    'api_code' => $api_code,
                    'api_user' => $User_Api->api_user
                ]);
            }
        } elseif ($withApi === 'tg') {
            Log::info('TG接口 - 检查User_Api并注册', ['user_id' => $user->id, 'api_code' => $api_code]);
            $User_Api = User_Api::where('api_code', $api_code)->where('user_id', $user->id)->first();
            if (!$User_Api) {
                Log::info('TG接口 - User_Api不存在，调用注册接口', ['username' => $user->username, 'api_code' => $api_code]);
                $result = $service->register($api_code, $user->username,$password);
                if ($result['code'] != 200) {
                    return $this->returnMsg(201, isset($result["data"]) ? $result["data"] : [], $result['message']);
                }
                $arr = [
                    'user_id' => $user->id,
                    'api_user' => $user->username,
                    'api_pass' => 123456,
                    'api_code' => $api_code,
                ];
                $User_Api = User_Api::create($arr);
            }
        } elseif ($withApi === 'dbzhenren') {
            Log::info('Dbzhenren接口 - 检查User_Api并注册', ['user_id' => $user->id, 'api_code' => $api_code]);
            $User_Api = User_Api::where('api_code', $api_code)->where('user_id', $user->id)->first();
            if (!$User_Api) {
                Log::info('Dbzhenren接口 - User_Api不存在，调用注册接口', ['username' => $user->username, 'api_code' => $api_code]);
                $result = $service->register($api_code, $user->username,$password);
                if ($result['code'] != 200) {
                    return $this->returnMsg(201, isset($result["data"]) ? $result["data"] : [], $result['message']);
                }
                $arr = [
                    'user_id' => $user->id,
                    'api_user' => $user->username,
                    'api_pass' => 123456,
                    'api_code' => $api_code,
                ];
                $User_Api = User_Api::create($arr);
            }
        } elseif ($withApi === 'dbdianzi') {
            Log::info('Dianzi接口 - 检查User_Api并注册', ['user_id' => $user->id, 'api_code' => $api_code]);
            $User_Api = User_Api::where('api_code', $api_code)->where('user_id', $user->id)->first();
            if (!$User_Api) {
                Log::info('Dianzi接口 - User_Api不存在，调用注册接口', ['username' => $user->username, 'api_code' => $api_code]);
                $result = $service->register($api_code, $user->username,$password);
                if ($result['code'] != 200) {
                    return $this->returnMsg(201, isset($result["data"]) ? $result["data"] : [], $result['message']);
                }
                $arr = [
                    'user_id' => $user->id,
                    'api_user' => $user->username,
                    'api_pass' => 123456,
                    'api_code' => $api_code,
                ];
                $User_Api = User_Api::create($arr);
            }
        } elseif ($withApi === 'dbgmag') {
            Log::info('Dbgmag接口 - 检查User_Api并注册', ['user_id' => $user->id, 'api_code' => $api_code]);
            $User_Api = User_Api::where('api_code', $api_code)->where('user_id', $user->id)->first();
            if (!$User_Api) {
                Log::info('Dbgmag接口 - User_Api不存在，调用注册接口', ['username' => $user->username, 'api_code' => $api_code]);
                $result = $service->register($api_code, $user->username, $password);
                if ($result['code'] != 200) {
                    return $this->returnMsg(201, isset($result["data"]) ? $result["data"] : [], $result['message']);
                }
                $arr = [
                    'user_id' => $user->id,
                    'api_user' => $user->username,
                    'api_pass' => 123456,
                    'api_code' => $api_code,
                ];
                $User_Api = User_Api::create($arr);
            }
        } elseif ($withApi === 'dbkaiyuan') {
            Log::info('Kaiyuan接口 - 检查User_Api并注册', ['user_id' => $user->id, 'api_code' => $api_code]);
            $User_Api = User_Api::where('api_code', $api_code)->where('user_id', $user->id)->first();
            if (!$User_Api) {
                Log::info('Kaiyuan接口 - User_Api不存在，调用注册接口', ['username' => $user->username, 'api_code' => $api_code]);
                $result = $service->register($api_code, $user->username,$password);
                if ($result['code'] != 200) {
                    return $this->returnMsg(201, isset($result["data"]) ? $result["data"] : [], $result['message']);
                }
                $arr = [
                    'user_id' => $user->id,
                    'api_user' => $user->username,
                    'api_pass' => 123456,
                    'api_code' => $api_code,
                ];
                $User_Api = User_Api::create($arr);
            }
        } elseif ($withApi === 'dbevo') {
            Log::info('Evo接口 - 检查User_Api并注册', ['user_id' => $user->id, 'api_code' => $api_code]);
            $User_Api = User_Api::where('api_code', $api_code)->where('user_id', $user->id)->first();
            if (!$User_Api) {
                Log::info('Evo接口 - User_Api不存在，调用注册接口', ['username' => $user->username, 'api_code' => $api_code]);
                $result = $service->register($api_code, $user->username,$password);
                if ($result['code'] != 200) {
                    return $this->returnMsg(201, isset($result["data"]) ? $result["data"] : [], $result['message']);
                }
                $arr = [
                    'user_id' => $user->id,
                    'api_user' => $user->username,
                    'api_pass' => 123456,
                    'api_code' => $api_code,
                ];
                $User_Api = User_Api::create($arr);
            }
        } else {
            // 确保 dp 接口不会进入此分支
            if ($withApi === 'dp') {
                Log::warning('DP接口不应该进入 else 分支，跳过注册逻辑', [
                    'with_api' => $withApi,
                    'user_id' => $user->id ?? null,
                    'controller' => 'IndexController'
                ]);
                // dp 接口跳过注册
            } else {
                Log::info('其他接口 - 检查User_Api并注册', ['with_api' => $withApi, 'user_id' => $user->id]);
            $User_Api = User_Api::where('api_code', $withApi)->where('user_id', $user->id)->first();
            if (!$User_Api) {
                    if ($withApi === 'pussy') {
                        Log::info('Pussy接口 - User_Api不存在，调用注册接口', ['username' => $user->username]);
                    // 调用Pussy注册接口，传入User对象
                    // 新方法签名：register($password, $agent, $name, $tel, $memo, $userType, $userNamePrefix, $user, $platformName)
                    $result = $service->register('123456', '', 'N/A', 'N/A', 'N/A', 1, 'c111111', $user, 'pussy');
                } else {
                        Log::info('其他接口 - User_Api不存在，跳过注册', ['with_api' => $withApi]);
                    $result = ['code' => 200];
                }
                if ($result['code'] != 200) {
                    return $this->returnMsg(201, '', $result['message'] ?? '注册失败');
                }
                $arr = [
                    'user_id' => $user->id,
                    'api_user' => $user->username,
                    'api_pass' => 123456,
                    'api_code' => $withApi,
                ];
                $User_Api = User_Api::create($arr);
                }
            }
        }

        /**
         * 自动上分 / 免转逻辑（在登录前执行）
         * - user_api 不存在：已在上面各分支完成注册/创建（或 dp 分支创建/更新 user_api）
         * - transferstatus = 1：调用对应平台的上分逻辑（复用 allmz，会先回收上一场馆再上分到当前场馆）
         * - transferstatus = 0：不走上分接口，直接同步 user_api.api_money（用于免转/展示）
         */
        // 注册判断完成后统一判断是否需要转账到游戏（与是否注册无关）
        // 注：dp 也支持 deposit，因此也需要纳入自动转账判断
        if (in_array($withApi, ['dp', 'tg', 'dbzhenren', 'dbdianzi', 'dbgmag', 'dbevo', 'dbkaiyuan'], true)) {
            if (!isset($User_Api) || !$User_Api) {
                $User_Api = User_Api::where('api_code', $api_code)->where('user_id', $user->id)->first();
            }
            Log::error('DP接口 - 充不充钱', [
                'user_id' => $effectiveTransferstatus,
            ]);
            if ($effectiveTransferstatus === 1) {
                // 转账模式：将余额通过对应游戏平台接口转入到当前场馆
                $transRes = $this->transferToGame($api_code, $user);
                if (isset($transRes['code']) && (int)$transRes['code'] !== 200) {
                    return $this->returnMsg(500, [], $transRes['message'] ?? '自动转账到游戏失败');
                }
            } else {
                if ($User_Api) {
                    $User_Api->api_money = $user->balance;
                    $User_Api->save();
                }
            }
        }

        $leixing = '1';
        if ($gameType == 'sport') {
            $leixing = '5';
        }
        if ($gameType == 'concise') {
            $leixing = '3';
        }
        if ($gameType == 'gaming') {
            $leixing = '7';
        }
        if ($gameType == 'joker') {
            $leixing = '6';
        }
        if ($gameType == 'lottery') {
            $leixing = '4';
        }
        if ($gameType == 'fishing') {
            $leixing = '2';
        }
        // 如果是 dp 接口，直接调用登录接口（使用上面从 user_api 获取的登录信息）
        if ($withApi === 'dp') {
            // 确保 $User_Api 变量存在（应该在上面的分支中已经处理）
            if (!isset($User_Api) || empty($User_Api->api_user)) {
                Log::error('DP接口 - user_api 记录未正确创建', [
                    'user_id' => $user->id,
                    'api_code' => $api_code
                ]);
                return $this->returnMsg(500, [], '用户登录信息获取失败');
            }
            
            // 从 user_api 表获取登录用户名
            $dpUserName = $User_Api->api_user;
            
            Log::info('DP接口 - 使用 user_api 中的登录信息进行登录', [
                'user_id' => $user->id,
                'users_username' => $user->username,
                'user_api_api_user' => $dpUserName,
                'api_code' => $api_code,
                'game_code' => $gameCode
            ]);
            
            // 确定 venueCode（场馆编码）
            $venueCode = $gameItem->venue_code ?? $api_code;
            // 确定 gameId，如果 gameCode 是数字则作为 gameId，否则为 0
            $gameId = !empty($gameCode) && is_numeric($gameCode) ? (int)$gameCode : 0;
            // 币种默认 USDT
            $currency = 'USDT';
            // 设备类型：1=PC, 2=H5
            $deviceType = $is_mobile_url ? 2 : 1;
            // 语言默认 zh_CN
            $lang = 'zh_CN';
            
            Log::info('DP接口 - 准备调用登录接口', [
                'user_id' => $user->id,
                'users_username' => $user->username,
                'user_api_api_user' => $dpUserName,
                'venue_code' => $venueCode,
                'game_code' => $gameCode,
                'game_id' => $gameId,
                'currency' => $currency,
                'device_type' => $deviceType,
                'lang' => $lang,
                'client_ip' => $request->getClientIp()
            ]);
            
            // 调用 DP 服务登录接口，使用 user_api 表中的 api_user
            $res = $service->login($dpUserName, $venueCode, $currency, $gameId, $deviceType, $lang, $request->getClientIp());
            
            Log::info('DP接口 - 登录接口返回', [
                'user_id' => $user->id,
                'username' => $user->username,
                'dp_user_name' => $dpUserName,
                'response_code' => $res['code'] ?? 'unknown',
                'response_message' => $res['message'] ?? 'unknown',
                'has_data' => isset($res['data']),
                'data_type' => isset($res['data']) ? gettype($res['data']) : 'null',
                'data_length' => isset($res['data']) && is_string($res['data']) ? strlen($res['data']) : 0,
                'data_preview' => isset($res['data']) && is_string($res['data']) ? substr($res['data'], 0, 200) : (isset($res['data']) ? json_encode($res['data']) : null),
                'full_response' => $res
            ]);
            
            // DpService::login() 成功返回格式: ['code' => 200, 'data' => $gameUrl] (data是字符串)
            // 失败返回格式: ['code' => 201, 'message' => '错误信息']
            if (isset($res['code']) && $res['code'] == 200 && !empty($res['data'])) {
                Log::info('DP接口 - 获取游戏链接成功', [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'game_url_length' => strlen($res['data']),
                    'game_url_preview' => substr($res['data'], 0, 200)
                ]);
                return $this->returnMsg(200, ['url' => $res['data']]);
            }
            
            // 如果登录失败，直接返回错误信息
            Log::error('DP接口 - 获取游戏链接失败', [
                'user_id' => $user->id,
                'username' => $user->username,
                'response_code' => $res['code'] ?? 'unknown',
                'response_message' => $res['message'] ?? 'unknown',
                'response_data' => $res['data'] ?? null,
                'full_response' => $res
            ]);
            return $this->returnMsg(500, $res, $res['message'] ?? '获取游戏链接失败');
        } elseif ($withApi === 'tg') {
            $res = $service->login($user->username,$password, $api_code, $leixing, $is_mobile_url, $gameCode);
        } elseif ($withApi === 'pussy') {
            $res = $service->login($user->username,$password, $gameCode, $is_mobile_url ? 1 : 0);
        } elseif ($withApi === 'dbzhenren') {
            // Dbzhenren接口登录，参数：username, api_code, game_type, is_mobile, game_code
            $res = $service->login($user->username,$password, $api_code, $is_mobile_url, $gameCode);
            // 如果返回的是token，需要构建游戏URL
            if ($res['code'] == 200 && isset($res['token'])) {
                // 根据token构建游戏URL，这里需要根据实际API文档调整
                // 暂时返回token，前端可以根据需要处理
                $res['data'] = $res['token'];
            }
        } elseif ($withApi === 'dbdianzi') {
            // Dbdianzi接口登录，参数：username, api_code, game_type, is_mobile, game_code
            $res = $service->login($user->username,$password, $api_code, $leixing, $is_mobile_url, $gameType);
        } elseif ($withApi === 'dbgmag') {
            // Dbgmag接口登录（按 Dbdianzi 方式）
            $res = $service->login($user->username, $api_code, $is_mobile_url, $gameType);
        } elseif ($withApi === 'dbkaiyuan') {
            // Kaiyuan接口登录（返回完整URL）
            $res = $service->login($user->username, $api_code, $leixing, $is_mobile_url, $gameType);
        } elseif ($withApi === 'dbevo') {
            // Evo接口登录，参数：username, api_code, game_type, is_mobile, game_code
            // DbevoService 的 login 方法返回完整的游戏URL
            $res = $service->login($user->username, $api_code, $is_mobile_url, $gameType);
        } else {
            $res = ['code' => 201, 'message' => '不支持的接口'];
        }
        if ($res['code'] == 200) {
            return $this->returnMsg(200, ['url' => $res['data']]);
        } else {
            return $this->returnMsg(500, $res, $res['message']);
        }
    }


    public function allmz($plat_name,$userid){
        $user = User::where('id',$userid)->first();
		$TransferLog = TransferLog::where('transfer_type', 0)->where('user_id', $user->id)->orderBy('id', 'desc')->first();
        // api_type 写的是 with_api；platform_type 写的是真实场馆。这里对比“真实场馆”是否一致。
        $plat_name = $this->normalizePlatformTypeCompat($plat_name);
        $lastPlatformType = $TransferLog ? $this->normalizePlatformTypeCompat($TransferLog->platform_type ?: $TransferLog->api_type) : '';
        $lastWithApi = $TransferLog ? strtolower($TransferLog->api_type) : '';
        // 兼容旧数据：如果上一笔 TransferLog 的 api_type 为空，则用当前场馆 platform_name 去 game_lists 查 with_api
        if ($lastWithApi === '') {
            $lastWithApi = $this->resolveWithApiByPlatformCompat($plat_name);
        }
        if ($TransferLog && $lastPlatformType !== $plat_name) {
			// 根据接口类型选择服务类
			$serviceClass = '\\App\\Services\\' . ucfirst($lastWithApi) . 'Service';
			if (!class_exists($serviceClass)) {
				// Special handling for Dianzi, Dbzhenren and Evo
				if ($lastWithApi === 'dbdianzi') {
					$serviceClass = '\\App\\Services\\DbdianziService';
				} elseif ($lastWithApi === 'dbzhenren') {
					$serviceClass = '\\App\\Services\\DbzhenrenService';
				} elseif ($lastWithApi === 'dbevo') {
					$serviceClass = '\\App\\Services\\DbevoService';
				} else {
					$serviceClass = '\\App\\Services\\TgService';
				}
			}
			$service = new $serviceClass();
			// balance/deposit/withdrawal 等第三方调用参数用真实场馆 code
			$result = $service->balance($lastPlatformType, $user->username);
			if($result['code'] != 200){
				return $result;
			}
			$api_money = $result['data'];
			if($api_money >= '1'){
				$api_money = intval($api_money);
				$client_transfer_id = time() . $user->id . rand(100000, 999999);
				$arr = [
					'order_no' => $client_transfer_id,
					// api_type 按 game_lists.with_api 写入（此处沿用上一笔的 with_api）
					'api_type' => $lastWithApi,
                    // platform_type 保存真实场馆 code（此处沿用上一笔的 platform_type）
                    'platform_type' => $lastPlatformType,
					'user_id' => $user->id,
					'transfer_type' => 1,
					'money' => $api_money,
					'cash_fee' => 0,
					'real_money' => $api_money,
					'before_money' => $user->balance ,
					'after_money' => $user->balance + $api_money,
					'state' => 2
				];
				$Transfers_id = TransferLog::create($arr);

				$res = $service->withdrawal($user->username, $api_money, $client_transfer_id, $lastPlatformType);
				if($res['code'] != 200){
					$Transfers_id->delete();
					return $res;
				}
				$user->increment('balance', $api_money);
				$transferlog = TransferLog::where('order_no', $client_transfer_id)->first();
				$transferlog->state = 1;
				$transferlog->save();
				$user_api = User_Api::where('api_code', $lastPlatformType)->where('user_id', $user->id)->where('api_user', $user->username)->first();
				if($user_api->api_money <= $api_money){
					$user_api->api_money = 0;
					$user_api->save();						
				}else{
					$user_api->api_money -= $api_money;
					$user_api->save();						
				}
			}
		}
        $balance = $user->balance;
		
		if($balance >= '1'){            
			$client_transfer_id = time() . $user->id . rand(100000, 999999);
            $platformType = $this->normalizePlatformTypeCompat($plat_name);
            $withApi = $this->resolveWithApiByPlatformCompat($platformType);
			$arr = [
				'order_no' => $client_transfer_id,
				// api_type 按 game_lists.with_api 写入
				'api_type' => $withApi,
                // platform_type 保存真实场馆 code
                'platform_type' => $platformType,
				'user_id' => $user->id,
				'transfer_type' => 0,
				'money' => -$balance,
				'cash_fee' => 0,
				'real_money' => -$balance,
				'before_money' => $user->balance ,
				'after_money' => $user->balance - $balance,
				'state' => 2
			];
			$Transfers_id = TransferLog::create($arr);
            $balance = intval($balance);
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
			$res = $service->deposit($user->username, $balance, $client_transfer_id, $platformType);
			if($res['code'] != 200){
				$Transfers_id->delete();
				return $res;
			}
			$user->decrement('balance', $balance);
			$transferlog = TransferLog::where('order_no', $client_transfer_id)->first();
			$transferlog->state = 1;
			$transferlog->save();
			$user_api = User_Api::where('api_code', $platformType)->where('user_id', $user->id)->where('api_user', $user->username)->first();
			$user_api->increment('api_money', $balance);
		}
        return array('code' => 200, 'message' => '成功');
	}

    /**
     * 转账到游戏（只做“余额 -> 指定场馆”上分，不做回收上一场馆）
     * - transferstatus=1 时由 getGameUrl 登录前调用
     * - 写入 TransferLog：api_type=with_api，platform_type=真实场馆
     */
    public function transferToGame(string $plat_name, User $user): array
    {
        $balance = (float) ($user->balance ?? 0);
        if ($balance < 1) {
            Log::error('DP接口 - 不充钱', [
                'user_id' => $plat_name,
            ]);
            return ['code' => 200, 'message' => '无需转账', 'data' => 0];
        }
        $platformType = $this->normalizePlatformTypeCompat($plat_name);
        $withApi = $this->resolveWithApiByPlatformCompat($platformType);
        Log::error('DP接口 - 要充钱', [
            'user_id' => $withApi,
        ]);

        $client_transfer_id = time() . $user->id . rand(100000, 999999);
        $amount = (int) $balance;

        $arr = [
            'order_no' => $client_transfer_id,
            // api_type 按 game_lists.with_api 写入
            'api_type' => $withApi,
            // platform_type 保存真实场馆 code
            'platform_type' => $platformType,
            'user_id' => $user->id,
            'transfer_type' => 0,
            'money' => -$amount,
            'cash_fee' => 0,
            'real_money' => -$amount,
            'before_money' => $user->balance,
            'after_money' => $user->balance - $amount,
            'state' => 2,
        ];

        $transferLog = TransferLog::create($arr);
        Log::error('DP接口 - 获取游戏链接失败', $arr);
        // 根据 with_api 选择服务类（上分接口）
        $serviceClass = '\\App\\Services\\' . ucfirst(strtolower($withApi)) . 'Service';
        if (!class_exists($serviceClass)) {
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

        // 兼容不同平台 deposit 方法签名
        if (strtolower($withApi) === 'dp') {
            // DpService::deposit($username, $amount, $transferno)
            $res = $service->deposit($user->username, $amount, $client_transfer_id);
        } else {
            // Tg/Dbzhenren/Dbdianzi/Dbevo：deposit($username, $amount, $orderNo, $api_code/platform)
            $res = $service->deposit($user->username, $amount, $client_transfer_id, $platformType);
        }
        if (!isset($res['code']) || (int) $res['code'] !== 200) {
            // 上分失败：删除流水
            $transferLog->delete();
            return [
                'code' => (int)($res['code'] ?? 201),
                'message' => $res['message'] ?? '转账到游戏失败',
                'data' => $res,
            ];
        }

        // 上分成功：扣减余额，更新流水与 user_api
        $user->decrement('balance', $amount);
        $transferLog->state = 1;
        $transferLog->save();

        $userApi = User_Api::where('api_code', $platformType)->where('user_id', $user->id)->first();
        if ($userApi) {
            $userApi->increment('api_money', $amount);
        }

        return ['code' => 200, 'message' => '成功', 'data' => $amount];
    }
    
    /**
     * 进入游戏后自动转账到游戏账户
     * @return void
     */
    public function transToTgAccount($user,$plat_name, $game_type)
    {
        $tg = new TgService;
                $plat_name = ($plat_name=='fgdz') ? 'fg' : $plat_name;
                if ($user->balance > 0) {
                    $client_transfer_id = time() . $user->id . rand(1000, 9999);
                   $amount = $user->balance;
                    $res = $tg->trans($user->username, $user->balance, $client_transfer_id, $plat_name, $game_type);
                    if ($res['code'] == 200) {
                        $user->balance = 0;
                        $user->save();
                        $platformType = $this->normalizePlatformTypeCompat($plat_name);
                        $withApi = $this->resolveWithApiByPlatformCompat($platformType);
                        $arr = [
                            'order_no' => $client_transfer_id,
                            // api_type 按 game_lists.with_api 写入
                            'api_type' => $withApi,
                            // platform_type 保存真实场馆 code
                            'platform_type' => $platformType,
                            'user_id' => $user->id,
                            'transfer_type' => 0,
                            'money' => -$amount,
                            'cash_fee' => 0,
                            'real_money' => $amount,
                            'before_money' =>$amount ,
                            'after_money' =>0,
                            'state' => 1
                        ];
                        TransferLog::create($arr);
                         Usersmoney::addinfo($user->id, $plat_name, $amount);
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }


    }    
    /**
     * 下注记录
     *
     * @param Request $request
     * @return void
     */
    public function betRecord(Request $request)
    {

        $data = $request->all();
        $start = $end = '';
        if (isset($data['date'])) {
            switch($data['date']){
                case 1:
                    list($start, $end) = [date('Y-m-d 00:00:00',time()), date('Y-m-d 23:59:59',time())];
                    break;
                case 2:
                    list($start, $end) =  [date('Y-m-d 00:00:00',time()-7*60*60*24), date('Y-m-d 23:59:59',time())];
                    break;  
                case 3:
                    list($start, $end) =[date('Y-m-d 00:00:00',time()-15*60*60*24), date('Y-m-d 23:59:59',time())];
                    break; 
                case 4:
                    list($start, $end) =[date('Y-m-d 00:00:00',time()-30*60*60*24), date('Y-m-d 23:59:59',time())];
                    break;                     
            }
        }
        $api_type = $data['api_type'] ?? '';
    
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();
        $pagesize = isset($data['pagesize']) ? $data['pagesize'] : 10 ;
        
                $list = GameRecord::where('user_id', $user->id)
                
                  ->when($api_type, function ($query) use ($api_type) {
                        return $query->where('platform_type', strtolower($api_type));
                    })
                    ->when($start, function ($query) use ($start) {
                        return $query->where('created_at', '>=', $start);
                    })->when($end, function ($query) use ($end) {
                        return $query->where('created_at', '<=', $end);
                    })->orderBy('id', 'desc')->select('bet_id','bet_time','platform_type','bet_amount','win_loss','status')->paginate($pagesize);
                    foreach ($list as $k => $v) {
                        $list[$k]['Code'] =$this->game_list[$v['platform_type']] ?? '';
                      
                    }                        
           
        return $this->returnMsg(200, $list);
    }

    /**
     * 获取游戏
     *
     * @return void
     */
    public function getdogame()
    {
        $gamelist = $this->game_list;
        //$game =[];
       // foreach ($gamelist as $key=>$val){
       //     $game[]=['id'=>$key,'name'=>$val];
       // }
        unset($gamelist['universal']);
        return $this->returnMsg(200, $gamelist);
    }


    /**
     * 交易记录
     *
     * @return void
     */
    public function transRecord(Request $request)
    {
        $data = $request->all();
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();        
        $start = $end = '';
        if (isset($data['date'])) {
            switch($data['date']){
                case 1:
                    list($start, $end) = [date('Y-m-d 00:00:00',time()), date('Y-m-d 23:59:59',time())];
                    break;
                case 2:
                    list($start, $end) =  [date('Y-m-d 00:00:00',time()-7*60*60*24), date('Y-m-d 23:59:59',time())];
                    break;  
                case 3:
                    list($start, $end) =[date('Y-m-d 00:00:00',time()-15*60*60*24), date('Y-m-d 23:59:59',time())];
                    break; 
                case 4:
                    list($start, $end) =[date('Y-m-d 00:00:00',time()-30*60*60*24), date('Y-m-d 23:59:59',time())];
                    break;                     
            }
        }
        $type = $data['type'];
        $api_type = $data['api_type'] ?? '';
        $pagesize = isset($data['pagesize']) ? $data['pagesize'] : 10 ;    
        $gamelist = $this->gamemoney_list;

        $pay_way =[1=>'银行卡',2 => '',3=>'支付宝',4=>'微信',5 => 'USDT-TRC20',6 => 'USDT-ERC20', 10 => '充值赠送', 11 => '代理充值', 66 => '客服代充'];
        switch ($type) {
            case 1:
                $list = Recharge::where('user_id', $user->id)
                    ->when($start, function ($query) use ($start) {
                        return $query->where('created_at', '>=', $start);
                    })->when($end, function ($query) use ($end) {
                        return $query->where('created_at', '<=', $end);
                    })->orderBy('id', 'desc')->select('amount','created_at','state','pay_way','out_trade_no')->paginate($pagesize);
                    foreach ($list as $k => $v) {
                        $list[$k]['pay_way'] = $pay_way[$v['pay_way']];
                        $list[$k]['amount'] = abs($v['amount']);
                    }                        
                break;
            case 2:
                $pay_way = [0 => '未记录',1 => '银行卡',2 => 'USDT-TRC20',3 => 'USDT-ERC20', 67 => '客服代扣'];
                $list = Withdraw::where('user_id', $user->id)
                    ->when($start, function ($query) use ($start) {
                        return $query->where('created_at', '>=', $start);
                    })->when($end, function ($query) use ($end) {
                        return $query->where('created_at', '<=', $end);
                    })->orderBy('id', 'desc')->select('real_money','created_at','state','order_no as out_trade_no','type')->paginate($pagesize);
                    foreach ($list as $k => $v) {
                        $list[$k]['pay_way'] = $pay_way[$v['type']];
                        $list[$k]['amount'] = abs($v['real_money']);
                    }                       
                break; 
            case 3:
                $list = TransferLog::where('user_id', $user->id)->where('transfer_type', 0)
                    ->when($start, function ($query) use ($start) {
                        return $query->where('created_at', '>=', $start);
                    })->when($end, function ($query) use ($end) {
                        return $query->where('created_at', '<=', $end);
                    })->when($api_type,function ($query) use ($api_type){
                        return $query->where('api_type',$api_type);
                    })->select('real_money','created_at','state','api_type')->orderBy('id', 'desc')->paginate($pagesize);
                  
                    foreach ($list as $k => $v) {
                        $list[$k]['pay_way'] = $gamelist[$v['api_type']];
                        $list[$k]['amount'] = abs($v['real_money']);
                    }                    
                break; 
            case 4:
                $list = TransferLog::where('user_id', $user->id)->whereIn('transfer_type', [1,3])
                    ->when($start, function ($query) use ($start) {
                        return $query->where('created_at', '>=', $start);
                    })->when($end, function ($query) use ($end) {
                        return $query->where('created_at', '<=', $end);
                    })->when($api_type,function ($query) use ($api_type){
                        return $query->where('api_type',$api_type);
                    })->select('real_money','created_at','state','api_type')->orderBy('id', 'desc')->paginate($pagesize);
                    foreach ($list as $k => $v) {
                        if($v['api_type']=='web'){
                            $list[$k]['pay_way'] ='优惠活动';
                        }else{
                            $list[$k]['pay_way'] = $gamelist[$v['api_type']];
                        }
                        
                        $list[$k]['amount'] = abs($v['real_money']);
                    }
                break;                 
            default:
                // code...
                break;
        }

        return $this->returnMsg(200, $list);

    }


    /**
     * 交易记录
     *
     * @return void
     */
    public function rechargeRecord(Request $request)
    {

        $data = $request->all();
        $start = $end = '';
        if (isset($data['time'])) {
            list($start, $end) = [$data['time'][0], $data['time'][1]];
        }

        $list = Recharge::where('user_id', Auth::id())
            ->when($start, function ($query) use ($start) {
                return $query->where('created_at', '>=', $start);
            })->when($end, function ($query) use ($end) {
                return $query->where('created_at', '<=', $end);
            })->orderBy('id', 'desc')->paginate(10);
        foreach ($list as $k => $v) {
            //$list[$k]['state'] = $this->state[$v->state];

            $list[$k]['type'] = ($v->pay_way == 10) ? '充值赠送' : '充值';
        }
        return $this->returnMsg(200, $list);

    }


    /**
     * 交易记录
     *
     * @return void
     */
    public function WithdrawRecord(Request $request)
    {
        $data = $request->all();
        $start = $end = '';
        if (isset($data['time'])) {
            list($start, $end) = [$data['time'][0], $data['time'][1]];
        }


        $list = Withdraw::where('user_id', Auth::id())
            ->when($start, function ($query) use ($start) {
                return $query->where('created_at', '>=', $start);
            })->when($end, function ($query) use ($end) {
                return $query->where('created_at', '<=', $end);
            })->orderBy('id', 'desc')->paginate(10);
        foreach ($list as $k => $v) {
            $list[$k]['state'] = $this->state[$v->state];
            $list[$k]['out_trade_no'] = $v->order_sn;
            $list[$k]['type'] = '提现';

        }
        return $this->returnMsg(200, $list);

    }

    public function userbalancelist(Request $request){
        $data = $request->all();
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();          
        $Api = Api::where('state',1)->orderBy('order_by', 'asc')->get()->toArray();
		$data = array();
        foreach($Api as $key => $v){
			$User_Api = User_Api::where('api_code',$v['api_code'])->where('user_id',$user->id)->first();
            $data[$key]['balance'] = $User_Api ? sprintf("%.2f",$User_Api->api_money) : 0;
			$data[$key]['name'] = $v['api_name'];
			$data[$key]['platname'] = $v['api_code'];
			$data[$key]['app_icon'] = env('APP_URL').'/uploads/'.$v['app_icon'];
		}
        return $this->returnMsg(200, $data);
    }
    public function userapimoney(Request $request)   
    {
        $api_code = $request->route('api_code');
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();
		$User_Api = User_Api::where('api_code',$api_code)->where('user_id',$user->id)->first();
		// 根据接口类型选择服务类
		$serviceClass = '\\App\\Services\\' . ucfirst(strtolower($api_code)) . 'Service';
		if (!class_exists($serviceClass)) {
			// Special handling for Dianzi, Dbzhenren and Evo
			if (strtolower($api_code) === 'dianzi') {
				$serviceClass = '\\App\\Services\\DbdianziService';
			} elseif (strtolower($api_code) === 'dbzhenren') {
				$serviceClass = '\\App\\Services\\DbzhenrenService';
			} elseif (strtolower($api_code) === 'dbevo') {
				$serviceClass = '\\App\\Services\\DbevoService';
			} else {
				$serviceClass = '\\App\\Services\\TgService';
			}
		}
		$service = new $serviceClass();
		if(!$User_Api){
			$result = $service->register($api_code, $user->username,$password);
            if($result['code'] != 200){
				return $this->returnMsg(201, isset($result["data"]) ? $result["data"] : [], $result['message']);
			}
			$arr = [
				'user_id' => $user->id,
				'api_user' => $user->username,
				'api_pass' => 123456,
				'api_code' => $api_code,
			];
			$User_Api = User_Api::create($arr);		    
		}        
        $result = $service->balance($api_code, $user->username);
		if($result['code'] != 200){
			return $this->returnMsg(201, isset($result["data"]) ? $result["data"] : [], $result['message']);
		}		
		$User_Api->api_money = $result['data'];
		$User_Api->save();		
        return $this->returnMsg(200,['balance' => $result['data']]);      
    } 
    public function uptransferstatus(Request $request){
            $data = $request->all();
            $token = $request->header('authorization');
            $token = str_replace('Bearer ','',$token) ;
            $user = User::where('api_token',$token)->first();  
            
            // 过滤掉中间件注入的 current_user 字段，避免 SQL 报错
            if (isset($data['current_user'])) unset($data['current_user']);
            
            $user->update($data);        
            return $this->returnMsg(200, '', '申请成功');
    }

    public function fanshui(Request $request){
        $data = $request->all();
     $token = $request->header('authorization');
     $token = str_replace('Bearer ','',$token) ;
            $user = User::where('api_token',$token)->first();         
        $start = $end = '';
        $pagesize = isset($data['pagesize']) ? $data['pagesize'] : 10 ;
        if (isset($data['date'])) {
            switch($data['date']){
                case 1:
                    list($start, $end) = [date('Y-m-d 00:00:00',time()), date('Y-m-d 23:59:59',time())];
                    break;
                case 2:
                    list($start, $end) =  [date('Y-m-d 00:00:00',time()-7*60*60*24), date('Y-m-d 23:59:59',time())];
                    break;  
                case 3:
                    list($start, $end) =[date('Y-m-d 00:00:00',time()-15*60*60*24), date('Y-m-d 23:59:59',time())];
                    break; 
                case 4:
                    list($start, $end) =[date('Y-m-d 00:00:00',time()-30*60*60*24), date('Y-m-d 23:59:59',time())];
                    break;                     
            }
        }
        $api_type = $data['api_type'];
        $type =  $data['type'];


        $lists = TransferLog::where('user_id', $user->id)->where('transfer_type', 6)
            ->when($start, function ($query) use ($start) {
                return $query->where('created_at', '>=', $start);
            })->when($end, function ($query) use ($end) {
                return $query->where('created_at', '<=', $end);
            })->when($api_type, function ($query) use ($api_type) {
                return $query->where('platform_type', '=', $api_type);
            })->when($type, function ($query) use ($type) {
                return $query->where('state', '=', ($type-1));
            })->orderBy('id', 'desc')->paginate($pagesize);

        foreach ($lists as $k => $v) {
            $lists[$k]['gamename'] = $this->game_list[$v['platform_type']];
        }
         $list['list'] = $lists;
         $list['jisuan'] = TransferLog::where('user_id', $user->id)->where('transfer_type', 6)->where('state', 1)->sum('real_money');
         $list['nojisuan'] = TransferLog::where('user_id',  $user->id)->where('transfer_type', 6)->where('state', 0)->sum('real_money');
        return $this->returnMsg(200, $list);
    }

    public function dofanshui(Request $request)
    {
        $data = $request->all();
         $token = $request->header('authorization');
         $token = str_replace('Bearer ','',$token) ;
            $user = User::where('api_token',$token)->first();
                $betlist = TransferLog::where('user_id', $user->id)->where('state', 0)->where('transfer_type', 6)->select('betid')->get();
                $userfanshui = TransferLog::where('user_id', $user->id)->where('state', 0)->where('transfer_type', 6)->sum('real_money');
                if ($userfanshui) {
                    $userinfo = Users::where('id', $user->id)->lockForUpdate()->first();
                    $userinfo->balance = $userinfo->balance + $userfanshui;
                    $userinfo->save();
                    TransferLog::where('user_id', $user->id)
                        ->where('state', 0)
                        ->update(['state' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
                    $betidarray=[];
                    foreach ($betlist as $val){
                        $betidarray[]=$val['betid'];
                    }
                    
                    GameRecord::where('user_id', $user->id)->whereIn('bet_id', $betidarray)->update(['is_back' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
                    
                    return $this->returnMsg(200, '', '成功领取');
                } else {
                    return $this->returnMsg(202, '', '没有可领取的返水');
                }

    }

    public function banklist()
    {
        $banklist = Bank::where('state', 1)->get();
        foreach ($banklist as &$val){
            $val->ico= env('APP_URL').'/uploads/'. $val->bank_img;    
        }         
         return $this->returnMsg(200, $banklist);
    }
    
    public function getpaybank()
    {
		$cardlist = PaySetting::where('state',1)->get();
		foreach ($cardlist as &$val){
			if($val->bank_data->bank_name!='USDT' || $val->bank_data->bank_name!='银行类型后台添加'){
				$val->ico= env('APP_URL').'/uploads/'. $val->bank_data->bank_img; 
			}else{
				$val->ico='';
			}
		}        
         return $this->returnMsg(200, $cardlist);
    }    

    public function doactivity(Request $request){
            $data = $request->all();
             $token = $request->header('authorization');
             $token = str_replace('Bearer ','',$token) ;
            $user = User::where('api_token',$token)->first(); 

            $activity = Activity::where('id', $data['activityid'])->first();
            if(empty($activity)){
                return $this->returnMsg(202, '', '活动不存在');
            }

            $isapple = ActivityApply::where("user_id",$user->id)->where('activity_id',$data['activityid'])->first();
            if($isapple){
                if($isapple->state==1){
                    return $this->returnMsg(202, '', '您已经申请过，等待管理员审核');
                }
                if($isapple->state==2){
                    return $this->returnMsg(202, '', '您已经申请过，已审核通过');
                }
                if($isapple->state==3){
                    return $this->returnMsg(202, '', '您已经申请过，审核未通过');
                }
            }

            $arr['activity_id'] = $data['activityid'];
            $arr['user_id'] = $user->id;
            $arr['state'] = 1;
            $arr['created_at'] = time();
            $arr['updated_at'] = time();
            if(ActivityApply::create($arr)){
                return $this->returnMsg(200, '', '申请成功');
            }else{
                return $this->returnMsg(200, '', '申请失败');
            }

    }
    
    public function activityApplyLog(Request $request)
    {
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first(); 
        $limit = $request->input('limit') ?? 10;
        $list = ActivityApply::where("user_id",$user->id)->paginate($limit);
        foreach ($list as $k => $v) {
            $list[$k]->activity_name = Activity::find($v->activity_id)->title;
        }
        return $this->returnMsg(200,$list);
    }
    /**
     * 用户所有银行卡
     */
    public function getAllUserCard(Request $request)
    {
     $token = $request->header('authorization');
     $token = str_replace('Bearer ','',$token) ;
            $user = User::where('api_token',$token)->first(); 
        $list = UserCard::where('user_id', $user->id)->get();
        foreach ($list as &$val){
			if($val->bank!='USDT' && $val->bank != 'ebpay'){
				$banklist = Bank::where('bank_name', $val->bank)->first();
				$val->ico= env('APP_URL').'/uploads/'. $banklist->bank_img;    
			}else{
				$val->ico='';
			}
        }
        return $this->returnMsg(200, $list);
    }

    /**
     * 系统银行卡信息
     */
    public function systemBankCardInfo(Request $request)
    {
        $data = $request->all();
        if($data['payType']!=1){
            $card = PaySetting::where('state', 1)->where('bank_id','>', 1)->first();
        }else{
            $card = PaySetting::where('state', 1)->where('bank_id', 1)->first();
        }

        return $this->returnMsg(200, $card);
    }
    

    public function gameslist(Request $request)
    {
        $data = $request->all();
        $tg = new TgService;
        $gamelist = $tg->gameslist($data['gamecode']);
        $gamelist = $gamelist['data'];
       return $this->returnMsg(200, $gamelist);
    }
    
    public function  messagecenter(Request $request){
     $token = $request->header('authorization');
     $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first(); 
        $map['user_id']=0;
        $map['vip_id']=0;
        $map['isagent']=0;
        
        $map1['isagent']=$user->agent;
        $map2['vip_id']=$user->vip;
        $map3['user_id']=$user->id;
        
        $data = $request->all();
        
        $list = Message::where('type',$data['type'])->whereOr($map)->whereOr($map1)->whereOr($map2)->whereOr($map3)->paginate(10);
        foreach ($list as $k => &$v) {
            $user_message = UserMessage::where('message_id', $v->id)->count();
            $v->is_read = $user_message ?? 0;
            $v->desc = mb_substr(strip_tags($v->content),0,20,'utf-8');
        }        
       
       return $this->returnMsg(200, $list);
    }  
    
    public function  message(Request $request){
     $token = $request->header('authorization');
     $token = str_replace('Bearer ','',$token) ;
            $user = User::where('api_token',$token)->first(); 
        $map['user_id']=0;
        $map['vip_id']=0;
        $map['isagent']=0;
        $map1['isagent']=$user->agent;
        $map2['vip_id']=$user->vip;
        $map3['user_id']=$user->id;
        
        $data = $request->all();
        
        $list = Message::where('id',$data['id'])->whereOr($map)->whereOr($map1)->whereOr($map2)->whereOr($map3)->first();
               
       
       return $this->returnMsg(200, $list);
    }   
    
    public function app()
    {
        // iOS相关配置
        $ios_download_url = SystemConfig::getValue('ios_download_url');
        $ios_download_qrcode = SystemConfig::getValue('ios_download_qrcode');
        $ios_download_qrcode = env('APP_URL').'/uploads/'.$ios_download_qrcode;
        
        // 新增Android相关配置
        $android_download_url = SystemConfig::getValue('android_download_url');
        $android_download_qrcode = SystemConfig::getValue('android_download_qrcode');
        $android_download_qrcode = $android_download_qrcode ? env('APP_URL').'/uploads/'.$android_download_qrcode : '';
        
        // 其他通用配置
        $h5_url = env('WAP_URL');
        $title = SystemConfig::getValue('site_title') ?? '娱乐城';
        $site_name = SystemConfig::getValue('site_name') ?? $title;
        $redpacket_switch = SystemConfig::getValue('redpacket');
        $app_download_switch = SystemConfig::getValue('app_download_switch', '1'); // 新增APP下载提示框开关
        $site_state = SystemConfig::getValue('site_state');
        $fanshui = SystemConfig::getValue('fanshui');
        $index_modal = SystemConfig::getValue('isclose');
        $repair_tips = SystemConfig::getValue('repair_tips');
        $webcontent = SystemConfig::getValue('webcontent');
        $site_logo = SystemConfig::getValue('site_logo');
        $site_logo = env('APP_URL').'/uploads/'.$site_logo;
        $app_logo = SystemConfig::getValue('app_logo');
        $app_logo = $app_logo ? env('APP_URL').'/uploads/'.$app_logo : '';
        
        // 包含Android配置项返回
        return $this->returnMsg(200,compact('ios_download_qrcode','ios_download_url','android_download_qrcode','android_download_url','h5_url','title','site_name','redpacket_switch','app_download_switch','site_state','fanshui','index_modal','repair_tips','webcontent','site_logo','app_logo'));
    }
    
    
    public function applyagentdo(Request $request)
    {
        $data = $request->all();
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first(); 
        
        $useragent = AgentApply::where('user_id',$user->id)->first();
         if ($useragent)return $this->returnMsg(500, '', '您已申请过代理'); 

            $arr = [
                'user_id' => $user->id,
                'apply_info' => $data['apply_info'],
                'state' => 1,
                'mobile' => $data['mobile'],
            ];
        if($res = AgentApply::create($arr)){
          return $this->returnMsg(200, '', '申请成功');
        }else{
            return $this->returnMsg(500, '', '申请失败');
        }
    } 
    
    public function getAgentLoginUrl()
    {
        return $this->returnMsg(200,['url' => env('AGENT_LOGIN')]);
    }
    
    public function getVisitUrl(Request $request) {
        $origin = $request->header('Origin') ?: $request->header('Referer') ?: '';
        if ($this->isMobile()) {
            $wapurl = env("WAP_URL");
            $wapurlArr = array_filter(array_map('trim', explode(',', $wapurl)));
            if ($origin && in_array($origin, $wapurlArr)) {
                return $this->returnMsg(500, [], 'wap');
            } else {
                $first = $wapurlArr ? reset($wapurlArr) : $wapurl;
                return $this->returnMsg(200, ['url' => $first]);
            }
        } else {
            $url = env("PC_URL");
            $weburlArr = array_filter(array_map('trim', explode(',', $url)));
            if ($origin && in_array($origin, $weburlArr)) {
                return $this->returnMsg(500, [], 'pc');
            } else {
                $first = $weburlArr ? reset($weburlArr) : $url;
                return $this->returnMsg(200, ['url' => $first]);
            }
        }
    }
    
    public function getAllPlat()
    {
        $vaild_plat = GameList::where('app_state',1)->where('is_top',1)->select('platform_name')->distinct()->pluck('platform_name')->toArray();
        $res = array_unique($vaild_plat);
        return $this->returnMsg(200,$res);
    }
    
    public function getAllGameList(Request $request)
    {
        $platform = $request->input('platform') ?? '';
        $category = $request->input('category') ?? '';
        $list = GameList::when($platform,function ($query) use ($platform){
            return $query->where('platform_name',$platform);
        })->when($category,function ($query) use ($category){
            return $query->where('category_id',$category);
        })->where('is_top',1)->where('site_state',1)
        // 返回字段补充 is_hot 与 app_img，供前端"热门分类"与图片优先级展示使用
        ->select('name','platform_name','category_id','game_code','app_state','is_hot','check_yes_img','check_no_img','api_logo_img','mobile_img','header_logo','app_img','app_icon')
        ->orderBy('order_by','asc')->get()->toArray();
		// 预取 apis 表的 app_icon，优先使用接口管理里的图标
		$apiIcons = \DB::table('apis')->whereNotNull('app_icon')->pluck('app_icon','api_code')->toArray();
		foreach($list as $key => $value){
			$data = Api::where('api_code',$value['platform_name'])->where('state',1)->first();
			if(!$data){
				unset($list[$key]);
				continue;
			}
			$list[$key]['check_yes_img'] = env('APP_URL').'/uploads/'.$value['check_yes_img'];
			$list[$key]['check_no_img'] = env('APP_URL').'/uploads/'.$value['check_no_img'];
			$list[$key]['api_logo_img'] = env('APP_URL').'/uploads/'.$value['api_logo_img'];
			$list[$key]['mobile_img'] = env('APP_URL').'/uploads/'.$value['mobile_img'];
			$list[$key]['header_logo'] = env('APP_URL').'/uploads/'.$value['header_logo'];
            if (!empty($value['app_img'])) {
                $list[$key]['app_img'] = env('APP_URL').'/uploads/'.$value['app_img'];
            }
            // 优先用 apis.app_icon，其次落回 game_lists.app_icon
            $apiCode = $value['platform_name'] ?? '';
            $iconPath = $apiIcons[$apiCode] ?? ($value['app_icon'] ?? '');
            $list[$key]['app_icon'] = $iconPath ? env('APP_URL').'/uploads/'.$iconPath : '';
		}
        $list = array_merge($list);
        
        // 获取 game_lists_app 表中的游戏（仅在热门分类显示）
        // 不合并到主列表，而是单独返回，由前端在热门分类中处理
        $appList = GameListApp::when($platform,function ($query) use ($platform){
            return $query->where('platform_name',$platform);
        })->where('app_state',1)
        ->select('name','platform_name','category_id','game_code','app_state','is_hot','app_img','app_icon')
        ->orderBy('order_by','asc')->get()->toArray();
        
        $appListFormatted = [];
        foreach($appList as $key => $value){
            $data = Api::where('api_code',$value['platform_name'])->where('state',1)->first();
            if(!$data){
                continue;
            }
            // 为 game_lists_app 的数据补充字段，使其格式与 game_lists 一致
            // 将 game_lists_app 中的所有游戏标记为热门，以便在热门列表中显示
            $appItem = [
                'name' => $value['name'],
                'platform_name' => $value['platform_name'],
                'category_id' => $value['category_id'],
                'game_code' => $value['game_code'],
                'app_state' => $value['app_state'],
                'is_hot' => 1, // game_lists_app 中的游戏都标记为热门
                'check_yes_img' => '',
                'check_no_img' => '',
                'api_logo_img' => '',
                'mobile_img' => !empty($value['app_img']) ? env('APP_URL').'/uploads/'.$value['app_img'] : '',
                'header_logo' => '',
                'app_img' => !empty($value['app_img']) ? env('APP_URL').'/uploads/'.$value['app_img'] : '',
            ];
            // 优先用 apis.app_icon，其次落回 game_lists_app.app_icon
            $apiCode = $value['platform_name'] ?? '';
            $iconPath = $apiIcons[$apiCode] ?? ($value['app_icon'] ?? '');
            $appItem['app_icon'] = $iconPath ? env('APP_URL').'/uploads/'.$iconPath : '';
            
            $appListFormatted[] = $appItem;
        }
        
        // 返回主列表和 app 列表，前端可以根据需要合并
        return $this->returnMsg(200, [
            'list' => $list,
            'app_list' => $appListFormatted // game_lists_app 中的游戏，仅在热门分类显示
        ]);
    }
    public function gamelistBycode(Request $request)
    {
        $list = GameList::where('site_state',1)->where('category_id','fishing')->orderBy('order_by','asc')->get()->toArray();
		$listarray = array();
		foreach($list as $key => $value){
			$data = Api::where('api_code',$value['platform_name'])->where('state',1)->first();
			if(!$data){
				unset($list[$key]);
			}
			$listarray[$key]['gamepic'] = env('APP_URL').'/uploads/'.$value['api_logo_img'];
			$listarray[$key]['catecode'] = $value['platform_name'];
			$listarray[$key]['gamename'] = $value['name'];
			$listarray[$key]['gamecode'] = $value['game_code'];
			$listarray[$key]['gametype'] = 'fishing';
		}
        $listarray = array_merge($listarray);
        return $this->returnMsg(200,$listarray);
    }
    
    /**
     * PC端获取游戏列表
     * 重构后的逻辑：按子分类和标签组织数据
     * 
     * 请求参数：
     * - category_id: 分类ID（必填，game_categories表的code）
     * - platform: 平台名称（可选）
     * - child_id: 子分类ID（可选，如果传入则过滤游戏数据）
     * - tag_id: 标签ID（可选，如果传入则过滤游戏数据）
     */
    public function getAllGamePcList(Request $request)
    {
        $platform = $request->input('platform') ?? '';
        $categoryId = $request->input('category_id') ?? '';
        $childId = $request->input('child_id') ?? '';
        $tagId = $request->input('tag_id') ?? '';
        
        // 必须传入 category_id 参数
        if (empty($categoryId)) {
            return $this->returnMsg(400, [], '参数错误：必须传入 category_id');
        }
        
        // 声明变量
        $child_games = [];
        $tag_games = [];
        $games = [];
        
        // 1. 获取 game_lists 表中 category_id 等于传来的 category_id 且 child_id > 0 的游戏数据
        $gameListQuery = GameList::when($platform, function ($query) use ($platform) {
            return $query->where('platform_name', $platform);
        })
        ->where('category_id', $categoryId)
        ->where('child_id', '>', 0)
        ->where(function($query) {
            $query->where('site_state', 1)
                  ->orWhere('app_state', 1);
        })
        ->where('is_pc', 1)
        ->select('id', 'name', 'platform_name', 'category_id', 'child_id', 'tag_id', 'game_code', 'is_hot', 'is_new', 'is_recommend', 'order_by', 'check_yes_img', 'check_no_img', 'api_logo_img', 'mobile_img', 'header_logo', 'app_img', 'app_icon', 'site_state', 'app_state')
        ->orderBy('order_by', 'asc');
        
        $game_list = $gameListQuery->get()->toArray();
        
        // 2. 根据传来的 category_id（这是 code），获取 game_categories 表中 code 等于 category_id 的记录的 id
        $category = GameCategory::where('code', $categoryId)->first();
        if (!$category) {
            return $this->returnMsg(400, [], '分类不存在');
        }
        $categoryIdValue = $category->id;
        
        // 3. 根据这个 id 去获取 pid 等于这个 id 的所有 game_categories 数据，作为 $child_games
        $childCategories = GameCategory::where('pid', $categoryIdValue)
            ->orderBy('order')
            ->orderBy('id')
            ->get()
            ->toArray();
        
        // 初始化 $child_games 数组结构
        foreach ($childCategories as $childCategory) {
            $child_games[] = [
                'child_id' => $childCategory['id'],
                'name' => $childCategory['name'] ?? '',
                'code' => $childCategory['code'] ?? '',
                'image' => !empty($childCategory['image']) ? env('APP_URL').'/uploads/'.$childCategory['image'] : '',
                'count' => 0, // 稍后统计
            ];
        }
        
        // 4. 通过遍历获得的游戏数据，按标签 ID 和子分类 ID 分别组织数组
        $tagGamesMap = []; // 以标签 ID 为键的数组
        $childGamesMap = []; // 以子分类 ID 为键的数组
        
        foreach ($game_list as $game) {
            $gameTagId = $game['tag_id'] ?? null;
            $gameChildId = $game['child_id'] ?? null;
            
            // 按标签 ID 组织数组
            if ($gameTagId) {
                if (!isset($tagGamesMap[$gameTagId])) {
                    $tagGamesMap[$gameTagId] = [];
                }
                $tagGamesMap[$gameTagId][] = $game;
            }
            
            // 按子分类 ID 组织数组
            if ($gameChildId) {
                if (!isset($childGamesMap[$gameChildId])) {
                    $childGamesMap[$gameChildId] = [];
                }
                $childGamesMap[$gameChildId][] = $game;
            }
        }
        
        // 5. 游戏数据单独复制到 $games
        $games = $game_list;
        
        // 如果传入了 child_id 或 tag_id，过滤游戏数据
        if (!empty($childId) || !empty($tagId)) {
            $games = [];
            foreach ($game_list as $game) {
                $match = true;
                if (!empty($childId) && ($game['child_id'] ?? null) != $childId) {
                    $match = false;
                }
                if (!empty($tagId) && ($game['tag_id'] ?? null) != $tagId) {
                    $match = false;
                }
                if ($match) {
                    $games[] = $game;
                }
            }
        }
        
        // 6. 获取标签信息
        $gameTagIds = array_keys($tagGamesMap);
        $gameTags = [];
        if (!empty($gameTagIds)) {
            $gameTags = \DB::table('game_tags')
                ->whereIn('id', $gameTagIds)
                ->get()
                ->keyBy('id')
                ->toArray();
        }
        
        // 7. 遍历 $child_games，通过刚才组装的数组获取每个子分类包含的游戏数
        foreach ($child_games as &$childGame) {
            $childIdKey = $childGame['child_id'];
            $childGame['count'] = isset($childGamesMap[$childIdKey]) ? count($childGamesMap[$childIdKey]) : 0;
        }
        unset($childGame);
        
        // 8. 遍历 $tag_games，通过刚才组装的数组获取每个标签包含的游戏数
        foreach ($tagGamesMap as $tagIdKey => $tagGamesArray) {
            $tag = $gameTags[$tagIdKey] ?? null;
            $tag_games[] = [
                'tag_id' => $tagIdKey,
                'name' => $tag ? ($tag->name ?? '') : '',
                'count' => count($tagGamesArray), // 通过组装的数组获取游戏数量
            ];
        }
        
        // 9. 整合数据并返回
        return $this->returnMsg(200, [
            'games' => $games,
            'tag_games' => $tag_games,
            'child_games' => $child_games,
        ]);
    }   
    public function getAppUrl()
    {
        $url = env('APP_URL');
        return $this->returnMsg(200,compact('url'));
    }
    
    /**
     * 获取赞助商列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSponsorList()
    {
        $sponsors = Sponsor::active()
            ->published()
            ->ordered()
            ->select('id', 'name', 'title', 'logo', 'banner', 'link_url', 'link_type', 'content_type', 'content', 'description')
            ->get()
            ->map(function ($sponsor) {
                return [
                    'id' => $sponsor->id,
                    'name' => $sponsor->name,
                    'title' => $sponsor->title,
                    'logo' => $sponsor->logo_url,
                    'banner' => $sponsor->banner_url,
                    'link_url' => $sponsor->link_url,
                    'link_type' => $sponsor->link_type,
                    'content_type' => $sponsor->content_type,
                    'content' => $this->cleanContent($sponsor->content),
                    'description' => $sponsor->description,
                ];
            });
        
        return $this->returnMsg(200, $sponsors);
    }
    
    /**
     * 清理文章内容，确保编码正确
     *
     * @param string|null $content
     * @return string
     */
    private function cleanContent($content)
    {
        if (empty($content)) {
            return '';
        }
        
        // 确保内容是UTF-8编码
        if (!mb_check_encoding($content, 'UTF-8')) {
            $content = mb_convert_encoding($content, 'UTF-8', 'auto');
        }
        
        // 清理HTML实体
        $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // 移除可能的BOM标记
        $content = str_replace("\xEF\xBB\xBF", '', $content);
        
        return $content;
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

    private function resolveWithApiByPlatformCompat($platformName, $gameCode = null): string
    {
        if (class_exists(\App\Services\Lib::class) && method_exists(\App\Services\Lib::class, 'resolveWithApiByPlatform')) {
            return \App\Services\Lib::resolveWithApiByPlatform($platformName, $gameCode);
        }
        // 线上若还是旧版 Lib，这里直接查 game_lists.with_api，避免回退成 platform_name
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
