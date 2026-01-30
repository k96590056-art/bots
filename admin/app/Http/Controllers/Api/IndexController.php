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
use App\Services\BackflowService;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function getGameStat(Request $request)
    {
        $data = $request->all();
        $start = $end = '';

        // 日期筛选（支持 date 参数：1=今天，2=近7天，3=近15天，4=近30天）
        if (isset($data['date'])) {
            switch($data['date']){
                case 1:
                    list($start, $end) = [date('Y-m-d 00:00:00', time()), date('Y-m-d 23:59:59', time())];
                    break;
                case 2:
                    list($start, $end) = [date('Y-m-d 00:00:00', time() - 7*60*60*24), date('Y-m-d 23:59:59', time())];
                    break;
                case 3:
                    list($start, $end) = [date('Y-m-d 00:00:00', time() - 15*60*60*24), date('Y-m-d 23:59:59', time())];
                    break;
                case 4:
                    list($start, $end) = [date('Y-m-d 00:00:00', time() - 30*60*60*24), date('Y-m-d 23:59:59', time())];
                    break;
            }
        } else {
            // 默认近7天
            list($start, $end) = [date('Y-m-d 00:00:00', time() - 7*60*60*24), date('Y-m-d 23:59:59', time())];
        }

        // 获取用户信息（中间件已经验证并设置了 current_user）
        $user = $request->get('current_user');

        // 如果中间件没有设置，尝试从 header 获取
        if (!$user) {
            $token = $request->header('Authorization') ?: $request->header('authorization');
            if ($token) {
                $token = preg_replace('/^Bearer\s+/i', '', trim($token));
                $user = User::where('api_token', $token)->first();
            }
        }

        if (!$user) {
            return $this->returnMsg(401, [], '用户未登录');
        }

        // 总体统计：根据 game_records 表计算（时间筛选以 game_records 表为准）
        $totalQuery = GameRecord::where('user_id', $user->id)
            ->when($start, function ($q) use ($start) {
                return $q->where('created_at', '>=', $start);
            })
            ->when($end, function ($q) use ($end) {
                return $q->where('created_at', '<=', $end);
            })
            ->selectRaw('
                COALESCE(SUM(bet_amount), 0) as total_bet_amount,
                COALESCE(SUM(win_loss), 0) as total_win_loss,
                COALESCE(SUM(valid_amount), 0) as total_valid_amount
            ')
            ->first();

        $totalStats = [
            'total_bet_amount' => number_format((float)($totalQuery->total_bet_amount ?? 0), 2, '.', ''),
            'total_win_loss' => number_format((float)($totalQuery->total_win_loss ?? 0), 2, '.', ''),
            'total_valid_amount' => number_format((float)($totalQuery->total_valid_amount ?? 0), 2, '.', ''),
        ];

        // 判断是手机端还是电脑端访问
        $isMobile = $this->isMobile();

        // 从 game_lists 表获取所有唯一的 platform_name 和图标信息（平台名称列表）
        // 电脑端访问：只获取 site_state = 1 的数据
        // 手机端访问：只获取 app_state = 1 的数据
        $gameListQuery = GameList::select('platform_name', 'name', 'name_en', 'app_icon', 'app_img', 'api_logo_img', 'mobile_img', 'header_logo')
            ->whereNotNull('platform_name')
            ->where('platform_name', '!=', '');

        if ($isMobile) {
            // 手机端：只获取 app_state = 1 的数据
            $gameListQuery->where('app_state', 1);
        } else {
            // 电脑端：只获取 site_state = 1 的数据
            $gameListQuery->where('site_state', 1);
        }

        // 获取数据后，按 platform_name 去重，保留每个平台的第一条记录
        $gameListPlatformsRaw = $gameListQuery->orderBy('id', 'asc')->get();
        $gameListPlatforms = [];
        $seenPlatformNames = [];
        foreach ($gameListPlatformsRaw as $item) {
            if (!in_array($item->platform_name, $seenPlatformNames)) {
                $gameListPlatforms[] = $item;
                $seenPlatformNames[] = $item->platform_name;
            }
        }

        // 从 game_records 中获取所有不同的 platform_type，用于建立映射关系
        // 在 game_records 中，platform_type 对应 game_lists 的 platform_name
        // 通过查找 game_records 中实际存在的 platform_type 和对应的数据来建立映射
        // 只查询指定时间范围内的数据
        $gameRecordPlatformTypes = GameRecord::where('user_id', $user->id)
            ->when($start, function ($q) use ($start) {
                return $q->where('created_at', '>=', $start);
            })
            ->when($end, function ($q) use ($end) {
                return $q->where('created_at', '<=', $end);
            })
            ->selectRaw('DISTINCT platform_type')
            ->whereNotNull('platform_type')
            ->where('platform_type', '!=', '')
            ->pluck('platform_type')
            ->toArray();

        Log::debug('getGameStat查询到的platform_type', [
            'user_id' => $user->id,
            'start' => $start,
            'end' => $end,
            'platform_types' => $gameRecordPlatformTypes,
            'platform_types_count' => count($gameRecordPlatformTypes)
        ]);

        // 建立 game_lists.platform_name 到 platform_type 的映射关系
        // 方法：对于每个 game_lists.platform_name，在 game_records 中查找对应的 platform_type
        // 只匹配在指定时间范围内实际有数据的 platform_type
        $platformNameToTypesMap = []; // game_lists.platform_name => [platform_type1, platform_type2, ...]
        foreach ($gameListPlatforms as $gameListPlatform) {
            $platformName = $gameListPlatform->platform_name;
            $platformNameToTypesMap[$platformName] = [];

            // 在 game_records 中查找所有可能对应的 platform_type
            foreach ($gameRecordPlatformTypes as $platformType) {
                $platformTypeLower = strtolower(trim($platformType));
                $platformNameLower = strtolower(trim($platformName));

                // 方法1：如果 platform_type 就是 platform_name 的小写形式（精确匹配）
                if ($platformTypeLower === $platformNameLower) {
                    // 验证在指定时间范围内确实有数据
                    $hasData = GameRecord::where('user_id', $user->id)
                        ->where('platform_type', $platformType)
                        ->when($start, function ($q) use ($start) {
                            return $q->where('created_at', '>=', $start);
                        })
                        ->when($end, function ($q) use ($end) {
                            return $q->where('created_at', '<=', $end);
                        })
                        ->where(function($query) {
                            $query->where('bet_amount', '>', 0)
                                ->orWhere('win_loss', '!=', 0)
                                ->orWhere('valid_amount', '>', 0);
                        })
                        ->exists();

                    if ($hasData && !in_array($platformType, $platformNameToTypesMap[$platformName])) {
                        $platformNameToTypesMap[$platformName][] = $platformType;
                    }
                    continue;
                }

                // 方法2：在 game_records 中查找，如果 platform_name 字段等于 game_lists.platform_name
                // 只查询指定时间范围内有实际数据的记录
                $hasMatch = GameRecord::where('user_id', $user->id)
                    ->where('platform_type', $platformType)
                    ->when($start, function ($q) use ($start) {
                        return $q->where('created_at', '>=', $start);
                    })
                    ->when($end, function ($q) use ($end) {
                        return $q->where('created_at', '<=', $end);
                    })
                    ->where(function($query) use ($platformName) {
                        $query->where('platform_name', $platformName);
                    })
                    ->where(function($query) {
                        $query->where('bet_amount', '>', 0)
                            ->orWhere('win_loss', '!=', 0)
                            ->orWhere('valid_amount', '>', 0);
                    })
                    ->exists();

                if ($hasMatch && !in_array($platformType, $platformNameToTypesMap[$platformName])) {
                    $platformNameToTypesMap[$platformName][] = $platformType;
                }
            }
        }

        Log::debug('getGameStat映射关系', [
            'platform_name_to_types_map' => $platformNameToTypesMap
        ]);

        // 按 platform_name 分组统计（从 game_lists 获取平台列表，然后在 game_records 中统计）
        $platformList = [];
        foreach ($gameListPlatforms as $gameListPlatform) {
            $platformName = $gameListPlatform->platform_name;
            $platformTypes = $platformNameToTypesMap[$platformName] ?? [];

            // 在 game_records 表中，根据 platform_type 查找对应的记录，然后以 platform_name（厅名称）分组统计
            // 使用 COALESCE 处理 platform_name 为 NULL 的情况
            $platformStatsData = [];
            if (!empty($platformTypes)) {
                // 根据 platform_type 查找记录，然后按 platform_name（厅名称）分组
                $platformStatsData = GameRecord::where('user_id', $user->id)
                    ->whereIn('platform_type', $platformTypes)
                    ->when($start, function ($q) use ($start) {
                        return $q->where('created_at', '>=', $start);
                    })
                    ->when($end, function ($q) use ($end) {
                        return $q->where('created_at', '<=', $end);
                    })
                    ->selectRaw('
                        COALESCE(platform_name, \'\') as platform_name,
                        SUM(bet_amount) as total_bet_amount,
                        SUM(win_loss) as total_win_loss,
                        SUM(valid_amount) as total_valid_amount,
                        MIN(created_at) as start_date,
                        MAX(created_at) as end_date
                    ')
                    ->groupBy('platform_name')
                    ->havingRaw('SUM(bet_amount) > 0 OR SUM(win_loss) != 0 OR SUM(valid_amount) > 0')
                    ->get();
            }

            // 将同一平台（game_lists.platform_name）的所有厅（game_records.platform_name）的数据合并
            $totalBetAmount = 0;
            $totalWinLoss = 0;
            $totalValidAmount = 0;
            $minStartDate = null;
            $maxEndDate = null;

            foreach ($platformStatsData as $stat) {
                $totalBetAmount += (float)($stat->total_bet_amount ?? 0);
                $totalWinLoss += (float)($stat->total_win_loss ?? 0);
                $totalValidAmount += (float)($stat->total_valid_amount ?? 0);

                if ($stat->start_date && (!$minStartDate || strtotime($stat->start_date) < strtotime($minStartDate))) {
                    $minStartDate = $stat->start_date;
                }
                if ($stat->end_date && (!$maxEndDate || strtotime($stat->end_date) > strtotime($maxEndDate))) {
                    $maxEndDate = $stat->end_date;
                }
            }

            // 添加调试日志
            Log::debug('getGameStat平台统计', [
                'platform_name' => $platformName,
                'platform_types' => $platformTypes,
                'platform_stats_data_count' => count($platformStatsData),
                'total_bet_amount' => $totalBetAmount,
                'total_win_loss' => $totalWinLoss,
                'total_valid_amount' => $totalValidAmount,
                'will_add_to_list' => ($totalBetAmount > 0 || $totalWinLoss != 0 || $totalValidAmount > 0)
            ]);

            // 只有当数据不为0时才添加到列表
            if ($totalBetAmount > 0 || $totalWinLoss != 0 || $totalValidAmount > 0) {
                // 获取平台图标（从 game_lists 表获取）
                // 电脑端：使用 api_logo_img
                // 手机端：使用 mobile_img
                $platformIcon = '';
                $iconPath = '';

                $iconPath = $gameListPlatform->api_logo_img ?? '';

                // 图标路径需要加上 APP_URL
                if (!empty($iconPath)) {
                    // 如果图标路径已经包含 http:// 或 https://，则不再添加 APP_URL
                    if (strpos($iconPath, 'http://') === 0 || strpos($iconPath, 'https://') === 0) {
                        $platformIcon = $iconPath;
                    } else {
                        $platformIcon = env('APP_URL') . '/uploads/' . $iconPath;
                    }
                }

                // 获取 platform_code（使用第一个匹配的 platform_type，如果没有则使用 platform_name 的小写形式）
                $platformCode = '';
                if (!empty($platformTypes)) {
                    $platformCode = strtolower($platformTypes[0]);
                } else {
                    // 尝试从 game_records 中获取 platform_type（使用 platform_name 查找）
                    $recordType = GameRecord::where('user_id', $user->id)
                        ->where('platform_name', $platformName)
                        ->select('platform_type')
                        ->first();
                    if ($recordType && !empty($recordType->platform_type)) {
                        $platformCode = strtolower($recordType->platform_type);
                    } else {
                        $platformCode = strtolower($platformName);
                    }
                }

                // 格式化日期范围
                $startDate = '';
                $endDate = '';
                if ($minStartDate) {
                    $startDate = date('Y/m/d', strtotime($minStartDate));
                }
                if ($maxEndDate) {
                    $endDate = date('Y/m/d', strtotime($maxEndDate));
                }
                $dateRange = ($startDate && $endDate) ? ($startDate . ' ~ ' . $endDate) : '';

                // 根据 game_records 的 game_type 和 platform_type 获取游戏名称
                // 条件：game_records.game_type = game_lists.category_id 且 game_records.platform_type = game_lists.platform_name
                $gameName = $gameListPlatform->name ?? '';
                $gameNameEn = $gameListPlatform->name_en ?? '';
                
                if (!empty($platformTypes)) {
                    // 从 game_records 中获取 game_type 和 platform_type 的组合
                    $gameRecordInfo = GameRecord::where('user_id', $user->id)
                        ->whereIn('platform_type', $platformTypes)
                        ->when($start, function ($q) use ($start) {
                            return $q->where('created_at', '>=', $start);
                        })
                        ->when($end, function ($q) use ($end) {
                            return $q->where('created_at', '<=', $end);
                        })
                        ->where(function($query) {
                            $query->where('bet_amount', '>', 0)
                                ->orWhere('win_loss', '!=', 0)
                                ->orWhere('valid_amount', '>', 0);
                        })
                        ->selectRaw('DISTINCT game_type, platform_type')
                        ->first();
                    
                    if ($gameRecordInfo && !empty($gameRecordInfo->game_type) && !empty($gameRecordInfo->platform_type)) {
                        // 在 game_lists 中查找匹配的记录
                        // game_records.game_type = game_lists.category_id 且 game_records.platform_type = game_lists.platform_name
                        $gameListInfo = GameList::where('category_id', $gameRecordInfo->game_type)
                            ->where('platform_name', $gameRecordInfo->platform_type)
                            ->first();
                        
                        if ($gameListInfo) {
                            $gameName = $gameListInfo->name ?? $gameName;
                            $gameNameEn = $gameListInfo->name_en ?? $gameNameEn;
                        }
                    }
                }

                $platformList[] = [
                    'platform_code' => $platformCode,
                    'platform_name' => $platformName,
                    'name' => $gameName,
                    'name_en' => $gameNameEn,
                    'platform_icon' => $platformIcon,
                    'date_range' => $dateRange,
                    'total_bet_amount' => number_format($totalBetAmount, 2, '.', ''),
                    'total_win_loss' => number_format($totalWinLoss, 2, '.', ''),
                    'total_valid_amount' => number_format($totalValidAmount, 2, '.', ''),
                ];
            }
        }

        // 按平台名称排序
        usort($platformList, function($a, $b) {
            return strcmp($a['platform_name'], $b['platform_name']);
        });

        return $this->returnMsg(200, [
            'total' => $totalStats,
            'platforms' => $platformList,
            'date_range' => [
                'start' => $start,
                'end' => $end,
                'start_formatted' => date('Y/m/d', strtotime($start)),
                'end_formatted' => date('Y/m/d', strtotime($end)),
            ]
        ]);
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
            ->where("pid","0")
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
        // 获取筛选参数
        $childId = $request->input('child_id');
        $tagId = $request->input('tag_id');

        // 第一层：获取 GameCategory 表中 pid=0 的数据
        $mainCategories = GameCategory::where('pid', 0)
            ->select('id', 'name', 'image', 'banner', 'code', 'pid')
            ->orderBy('order')
            ->orderBy('id')
            ->get()
            ->toArray();

        // 获取所有有效的接口
        $validApis = Api::where('state', 1)->pluck('api_code')->toArray();

        // 预取 apis 表的 app_icon
        $apiIcons = \DB::table('apis')->whereNotNull('app_icon')->pluck('app_icon', 'api_code')->toArray();

        $result = [];

        foreach ($mainCategories as $mainCategory) {
            $categoryId = $mainCategory['id'];
            $categoryCode = $mainCategory['code'];

            // 第二层第一组：child_category - 基于第一层数据，获取 GameCategory 表中 pid=当前分类 id 的数据
            $childCategories = GameCategory::where('pid', $categoryId)
                ->select('id', 'name', 'image', 'banner', 'code', 'pid')
                ->orderBy('order')
                ->orderBy('id')
                ->get()
                ->toArray();

            // 获取所有子分类的 ID
            $childCategoryIds = array_column($childCategories, 'id');

            // 统计每个子分类下的游戏数量（game_lists 表中 child_id=子分类 id 的数量）
            $childCategoryCounts = [];
            if (!empty($childCategoryIds)) {
                $counts = GameList::whereIn('child_id', $childCategoryIds)
                    ->where('is_pc', 1)
                    ->where('site_state', 1)
                    ->whereIn('platform_name', $validApis)
                    ->selectRaw('child_id, COUNT(*) as count')
                    ->groupBy('child_id')
                    ->pluck('count', 'child_id')
                    ->toArray();

                foreach ($childCategoryIds as $childCatId) {
                    $childCategoryCounts[$childCatId] = $counts[$childCatId] ?? 0;
                }
            }

            // 处理 child_category 数据
            $childCategoryList = [];
            foreach ($childCategories as $childCategory) {
                $childCategoryList[] = [
                    'id' => $childCategory['id'],
                    'name' => $childCategory['name'],
                    'image' => $childCategory['image'] ? env('APP_URL').'/uploads/'.$childCategory['image'] : '',
                    'banner' => $childCategory['banner'] ? env('APP_URL').'/uploads/'.$childCategory['banner'] : '',
                    'code' => $childCategory['code'],
                    'pid' => $childCategory['pid'],
                    'count' => $childCategoryCounts[$childCategory['id']] ?? 0,
                ];
            }

            // 获取 child_category 对应的所有游戏数据（用于后续处理）
            // 需要查询 category_id = 当前分类 code 且 child_id 在子分类 ID 列表中的游戏
            $allChildGames = [];
            if (!empty($childCategoryIds)) {
                $allChildGames = GameList::where('category_id', $categoryCode)
                    ->whereIn('child_id', $childCategoryIds)
                    ->where('is_pc', 1)
                    ->where('site_state', 1)
                    ->whereIn('platform_name', $validApis)
                    ->select('id','changguan', 'name', 'platform_name', 'category_id', 'child_id', 'tag_id', 'game_icon', 'game_title_img', 'game_code', 'is_hot', 'is_new', 'is_recommend', 'order_by', 'check_yes_img', 'check_no_img', 'api_logo_img', 'mobile_img', 'header_logo', 'app_img', 'app_icon')
                    ->orderBy('order_by', 'asc')
                    ->get()
                    ->toArray();
            }

            // 第二层第二组：child_tags - 基于第一组数据（allChildGames），从 game_lists 表按 tag_id 分组，获取 game_tags 表的数据
            $tagIds = array_filter(array_unique(array_column($allChildGames, 'tag_id')));
            $childTagsList = [];
            if (!empty($tagIds)) {
                // 获取标签信息
                $gameTags = \DB::table('game_tags')
                    ->whereIn('id', $tagIds)
                    ->get()
                    ->keyBy('id')
                    ->toArray();

                // 统计每个标签下的游戏数量（基于 allChildGames 中 tag_id=标签 id 的数量）
                $tagCounts = [];
                foreach ($allChildGames as $game) {
                    $tid = $game['tag_id'] ?? 0;
                    if ($tid > 0) {
                        $tagCounts[$tid] = ($tagCounts[$tid] ?? 0) + 1;
                    }
                }

                foreach ($tagIds as $tid) {
                    $tag = $gameTags[$tid] ?? null;
                    if ($tag) {
                        $childTagsList[] = [
                            'id' => $tid,
                            'name' => $tag->name ?? '',
                            'count' => $tagCounts[$tid] ?? 0,
                        ];
                    }
                }
            }

            // 添加 game_nav：category_id 满足第一层的 code 同时 child_id 为空或为 0 的 game_lists 数据
            $gameNavList = [];
            $gameNavGames = GameList::where('category_id', $categoryCode)
                ->where(function($query) {
                    $query->where('child_id', 0)
                        ->orWhereNull('child_id');
                })
                ->where('is_pc', 1)
                ->where('site_state', 1)
                ->whereIn('platform_name', $validApis)
                ->select('id','changguan', 'name', 'platform_name', 'category_id', 'child_id', 'tag_id', 'game_icon', 'game_title_img', 'game_code', 'is_hot', 'is_new', 'is_recommend', 'order_by', 'check_yes_img', 'check_no_img', 'api_logo_img', 'mobile_img', 'header_logo', 'app_img', 'app_icon')
                ->orderBy('order_by', 'asc')
                ->get()
                ->toArray();

            foreach ($gameNavGames as $game) {
                $gameNavList[] = $this->formatGameData($game, $apiIcons);
            }

            // 第二层第三组：games - 只包含 child_id > 0 的数据
            // games 应该包含：category_id = 当前分类 code 且 child_id 在子分类 ID 列表中的游戏（child_id > 0）
            // child_id = 0 的数据只出现在 game_nav 中，不出现在 games 中
            $gamesList = [];

            // games 只包含 child_id > 0 的数据（来自 allChildGames）
            foreach ($allChildGames as $game) {
                $gameChildId = $game['child_id'] ?? 0;
                if (!empty($gameChildId) && $gameChildId > 0) {
                    $gamesList[] = $this->formatGameData($game, $apiIcons);
                }
            }

            // 应用筛选条件：只针对 games 中 child_id > 0 的数据
            // 因为 games 已经只包含 child_id > 0 的数据，所以直接应用筛选条件即可
            if (!empty($childId) || !empty($tagId)) {
                $filteredGamesList = [];
                foreach ($gamesList as $game) {
                    $match = true;

                    // 如果传入了 child_id，筛选 child_id 匹配的游戏
                    if (!empty($childId)) {
                        if (($game['child_id'] ?? 0) != $childId) {
                            $match = false;
                        }
                    }

                    // 如果传入了 tag_id，筛选 tag_id 匹配的游戏
                    if (!empty($tagId)) {
                        if (($game['tag_id'] ?? 0) != $tagId) {
                            $match = false;
                        }
                    }

                    if ($match) {
                        $filteredGamesList[] = $game;
                    }
                }
                $gamesList = $filteredGamesList;
            }

            // 按 child_id 分组 games 数据
            $gamesGrouped = [];
            foreach ($gamesList as $game) {
                $gameChildId = $game['changguan'] ?? 0;
                if (!isset($gamesGrouped[$gameChildId])) {
                    $gamesGrouped[$gameChildId] = [];
                }
                $gamesGrouped[$gameChildId][] = $game;
            }

            // 组装最终数据
            $result[] = [
                'id' => $mainCategory['id'],
                'name' => $mainCategory['name'],
                'image' => $mainCategory['image'] ? env('APP_URL').'/uploads/'.$mainCategory['image'] : '',
                'banner' => $mainCategory['banner'] ? env('APP_URL').'/uploads/'.$mainCategory['banner'] : '',
                'code' => $mainCategory['code'],
                'pid' => $mainCategory['pid'],
                'child_category' => $childCategoryList,
                'child_tags' => $childTagsList,
                'game_nav' => $gameNavList,
                'games' => $gamesGrouped,
            ];
        }

        return $this->returnMsg(200, $result);
    }

    /**
     * 格式化游戏数据
     */
    private function formatGameData($game, $apiIcons)
    {
        $apiCode = $game['platform_name'] ?? '';
        $iconPath = $apiIcons[$apiCode] ?? ($game['app_icon'] ?? '');

        return [
            'id' => $game['id'],
            'name' => $game['name'],
            'changguan' => $game['changguan'],
            'platform_name' => $game['platform_name'],
            'category_id' => $game['category_id'],
            'child_id' => $game['child_id'] ?? 0,
            'tag_id' => $game['tag_id'] ?? 0,
            'game_code' => $game['game_code'],
            'is_hot' => $game['is_hot'] ?? 0,
            'is_new' => $game['is_new'] ?? 0,
            'rebate' => rand(1,100),
            'is_recommend' => $game['is_recommend'] ?? 0,
            'check_yes_img' => !empty($game['check_yes_img']) ? env('APP_URL').'/uploads/'.$game['check_yes_img'] : '',
            'check_no_img' => !empty($game['check_no_img']) ? env('APP_URL').'/uploads/'.$game['check_no_img'] : '',
            'api_logo_img' => !empty($game['api_logo_img']) ? env('APP_URL').'/uploads/'.$game['api_logo_img'] : '',
            'game_icon' => !empty($game['game_icon']) ? env('APP_URL').'/uploads/'.$game['game_icon'] : '',
            'game_title_img' => !empty($game['game_title_img']) ? env('APP_URL').'/uploads/'.$game['game_title_img'] : '',
            'mobile_img' => !empty($game['mobile_img']) ? env('APP_URL').'/uploads/'.$game['mobile_img'] : '',
            'header_logo' => !empty($game['header_logo']) ? env('APP_URL').'/uploads/'.$game['header_logo'] : '',
            'app_img' => !empty($game['app_img']) ? env('APP_URL').'/uploads/'.$game['app_img'] : '',
            'app_icon' => !empty($iconPath) ? env('APP_URL').'/uploads/'.$iconPath : '',
        ];
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
        if (!empty($gameType)) {
            $gameQuery->where('game_code', $gameType);
        }
        $gameItem = $gameQuery->first();
        if ($gameItem && (((int)$gameItem->site_state !== 1) || ((int)$gameItem->app_state !== 1))) {
            return $this->returnMsg(500, '', '该游戏已关闭');
        }
        $withApi = strtolower($gameItem->with_api ?? 'db');
        $venueCode = $gameItem->venue_code ?? $api_code;
        Log::info('=== getGameUrl 接口开始处理 ===', [
            'api_code' => $api_code,
            'game_code' => $gameCode,
            'game_type' => $gameType,
            'game_item_id' => $gameItem->id ?? null,
            'game_item_with_api' => $gameItem->with_api ?? null,
            'with_api_final' => $withApi,
            'is_db' => ($withApi === 'db')
        ]);

        $serviceClass = '\\App\\Services\\' . ucfirst($withApi) . 'Service';
        if (!class_exists($serviceClass)) {
            // Special handling for Dianzi, Dbzhenren and Evo as their class names don't follow the *Service suffix pattern
            if ($withApi === 'dbdianzi') {
                $serviceClass = '\\App\\Services\\DbdianziService';
            } elseif ($withApi === 'dbgmag') {
                $serviceClass = '\\App\\Services\\DbgmagService';
            } elseif ($withApi === 'dboneapi') {
                $serviceClass = '\\App\\Services\\DboneapiService';
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

        if ($withApi === 'tg') {
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
        } elseif ($withApi === 'dboneapi') {
            Log::info('Dboneapi接口 - 检查User_Api并注册', ['user_id' => $user->id, 'api_code' => $api_code]);
            $User_Api = User_Api::where('api_code', $api_code)->where('user_id', $user->id)->first();
            if (!$User_Api) {
                Log::info('Dboneapi接口 - User_Api不存在，创建User_Api记录', ['username' => $user->username, 'api_code' => $api_code]);
                // OneAPI 不需要单独注册，直接创建 User_Api 记录
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
            // 确保 db 接口不会进入此分支
            if ($withApi === 'db') {
                Log::warning('DB接口不应该进入 else 分支，跳过注册逻辑', [
                    'with_api' => $withApi,
                    'user_id' => $user->id ?? null,
                    'controller' => 'IndexController'
                ]);
                // db 接口跳过注册
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

        // 统一处理：如果用户已注册任何场馆，先回收所有场馆的余额
        $User_Api = User_Api::where('api_code', $api_code)->where('user_id', $user->id)->first();
        if ($User_Api) {
            Log::info('用户已注册该场馆，先回收所有场馆余额', ['user_id' => $user->id, 'api_code' => $api_code]);
            $this->recycleAllPlatformsBalance($user);
        } else {
            // 如果User_Api不存在，根据接口类型创建记录
            if ($withApi === 'db') {
                $arr = [
                    'user_id' => $user->id,
                    'api_user' => $user->username,
                    'api_pass' => 123456,
                    'api_code' => $api_code,
                ];
                $User_Api = User_Api::create($arr);
            }
        }

        /**
         * 自动上分 / 免转逻辑（在登录前执行，但在回收之后）
         * - user_api 不存在：已在上面各分支完成注册/创建（或 db 分支创建/更新 user_api）
         * - transferstatus = 1：调用对应平台的上分逻辑（调用接口转入转出，将 users 表的金额转到 user_api）
         * - transferstatus = 0：不走上分接口，不操作将 users 表的金额转到 user_api（免转模式）
         */
        // 注册判断和回收完成后统一判断是否需要转账到游戏（与是否注册无关）
        // 注：db 也支持 deposit，因此也需要纳入自动转账判断
        if (in_array($withApi, ['tg', 'dbzhenren', 'dbdianzi', 'dbgmag', 'dboneapi', 'dbevo', 'dbkaiyuan', 'db'], true)) {
            if (!isset($User_Api) || !$User_Api) {
                $User_Api = User_Api::where('api_code', $api_code)->where('user_id', $user->id)->first();
            }
            Log::info('转账判断', [
                'user_id' => $user->id,
                'effectiveTransferstatus' => $gameItem->transferstatus,
                'with_api' => $withApi
            ]);
            // 只有当 effectiveTransferstatus === 1 时才进行转入转出操作
            if ($gameItem->transferstatus === 1) {
                // 转账模式：将余额通过对应游戏平台接口转入到当前场馆
                // 会调用接口转入转出，并将 users 表的金额转到 user_api
                $transRes = $this->transferToGame($api_code, $user,$venueCode);
                if (isset($transRes['code']) && (int)$transRes['code'] !== 200) {
                    return $this->returnMsg(500, [], $transRes['message'] ?? '自动转账到游戏失败');
                }
            } else {
                // 免转模式：不调用接口转入转出，也不操作将 users 表的金额转到 user_api
                Log::info('免转模式，跳过转账操作', [
                    'user_id' => $user->id,
                    'effectiveTransferstatus' => $gameItem->transferstatus,
                    'with_api' => $withApi
                ]);
            }
        }
        // 如果是 db 接口，直接调用登录接口（使用上面从 user_api 获取的登录信息）
        if ($withApi === 'db') {
            // 确定 venueCode（场馆编码）
            $venueCode = $gameItem->venue_code ?? $api_code;
            // 确定 gameId，如果 gameCode 是数字则作为 gameId，否则为 0
            $gameId = !empty($gameType) && is_numeric($gameType) ? (int)$gameType : 0;
            // 币种默认 USDT
            $currency = 'USDT';
            // 设备类型：1=PC, 2=H5
            $deviceType = $is_mobile_url != 1 ? 2 : 1;
            // 语言默认 zh_CN
            $lang = 'zh_CN';
            Log::info('DB接口 - 准备调用登录接口', [
                'user_id' => $user->id,
                'users_username' => $user->username,
                'venue_code' => $venueCode,
                'game_code' => $gameType,
                'game_id' => $gameId,
                'currency' => $currency,
                'device_type' => $deviceType,
                'lang' => $lang,
                'client_ip' => $request->getClientIp()
            ]);

            // 调用 DB 服务登录接口，使用 user_api 表中的 api_user
            $res = $service->login($user->username, $venueCode, $currency, $gameId, $deviceType, $lang, $request->getClientIp());

            Log::info('DB接口 - 登录接口返回', [
                'user_id' => $user->id,
                'username' => $user->username,
                'response_code' => $res['code'] ?? 'unknown',
                'response_message' => $res['message'] ?? 'unknown',
                'has_data' => isset($res['data']),
                'data_type' => isset($res['data']) ? gettype($res['data']) : 'null',
                'data_length' => isset($res['data']) && is_string($res['data']) ? strlen($res['data']) : 0,
                'data_preview' => isset($res['data']) && is_string($res['data']) ? substr($res['data'], 0, 200) : (isset($res['data']) ? json_encode($res['data']) : null),
                'full_response' => $res
            ]);

            // DbService::login() 成功返回格式: ['code' => 200, 'data' => $gameUrl] (data是字符串)
            // 失败返回格式: ['code' => 201, 'message' => '错误信息']
            if (isset($res['code']) && $res['code'] == 200 && !empty($res['data'])) {
                Log::info('DB接口 - 获取游戏链接成功', [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'game_url_length' => strlen($res['data']),
                    'game_url_preview' => substr($res['data'], 0, 200)
                ]);
                return $this->returnMsg(200, ['url' => $res['data']]);
            }

            // 如果登录失败，直接返回错误信息
            Log::error('DB接口 - 获取游戏链接失败', [
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
        } elseif ($withApi === 'dboneapi') {
            // Dboneapi接口登录（使用 getGameUrl 方法）
            // 直接使用 $user->username，移除用户名长度判断
            $platform = $is_mobile_url == 1 ? 'H5' : 'web';
            $res = $service->getGameUrl($user->username, $gameType, '', $platform, in_array(strtolower($gameItem->venue_code),["aa"]) ? "USD" : "CNY");
            // 适配返回格式，确保与 login 方法返回格式一致
            // OneAPI 的 getGameUrl 返回的 data 可能包含 url 字段，需要提取出来
            if ($res['code'] == 200) {
                if (isset($res['data']['url'])) {
                    $res['data'] = $res['data']['url'];
                } elseif (is_string($res['data'])) {
                    // 如果 data 直接是 URL 字符串，保持不变
                } elseif (is_array($res['data']) && !empty($res['data'])) {
                    // 如果 data 是数组但没有 url 字段，尝试其他可能的字段
                    $res['data'] = $res['data']['gameUrl'] ?? $res['data']['game_url'] ?? json_encode($res['data']);
                }
            }
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

                // 兼容不同平台 withdrawal 方法签名
                if (strtolower($lastWithApi) === 'db') {
                    // DbService::withdrawal($username, $amount, $serialNo, $venueCode, $currency)
                    // 先根据 user_api 表的 api_code 去 game_lists 获取 venue_code
                    $gameList = GameList::where('with_api', 'db')
                        ->where('platform_name', $lastPlatformType)
                        ->whereNotNull('venue_code')
                        ->where('venue_code', '!=', '')
                        ->first();

                    if (!$gameList || empty($gameList->venue_code)) {
                        $Transfers_id->delete();
                        return ['code' => 400, 'message' => "未找到 api_code ({$lastPlatformType}) 对应的 venue_code"];
                    }

                    $venueCode = $gameList->venue_code;
                    $res = $service->withdrawal($user->username, $api_money, $client_transfer_id, $venueCode, 'USDT');
                } else {
                    // 其他平台：withdrawal($username, $amount, $orderNo, $api_code/platform)
                    $res = $service->withdrawal($user->username, $api_money, $client_transfer_id, $lastPlatformType);
                }
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
            // 兼容不同平台 deposit 方法签名
            if (strtolower($withApi) === 'db') {
                // DbService::deposit($username, $amount, $serialNo, $venueCode, $currency)
                // $platformType 就是 venueCode（场馆编码）
                $res = $service->deposit($user->username, $balance, $client_transfer_id, $platformType, 'USDT');
            } else {
                // 其他平台：deposit($username, $amount, $orderNo, $api_code/platform)
                $res = $service->deposit($user->username, $balance, $client_transfer_id, $platformType);
            }
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
    public function transferToGame(string $plat_name, User $user, $venueCode = false): array
    {
        $balance = (float) ($user->balance ?? 0);
        if ($balance < 1) {
            Log::error('DB接口 - 不充钱', [
                'user_id' => $plat_name,
            ]);
            return ['code' => 200, 'message' => '无需转账', 'data' => 0];
        }
        $platformType = $this->normalizePlatformTypeCompat($plat_name);
        $withApi = $this->resolveWithApiByPlatformCompat($platformType);
        Log::error('DB接口 - 要充钱', [
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
        Log::error('DB接口 - 获取游戏链接失败1', $arr);
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
        if (strtolower($withApi) === 'db') {
            // DbService::deposit($username, $amount, $serialNo, $venueCode, $currency)
            // $platformType 就是 venueCode（场馆编码）
            $res = $service->deposit($user->username, $amount, $client_transfer_id, $venueCode, 'USDT');
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
    public function betRecords(Request $request)
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


    public function betRecord(Request $request)
    {

        $data = $request->all();
        $start = $end = '';

        if(isset($data['start_time']) && isset($data['end_time'])){
            $start = $data['start_time'];
            $end = $data['end_time'];
        }elseif (isset($data['date'])) {
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

        // Generate date range for filling gaps
        $dates = [];
        if ($start && $end) {
            $current = strtotime(date('Y-m-d', strtotime($start)));
            $last = strtotime(date('Y-m-d', strtotime($end)));
            while ($current <= $last) {
                $dates[] = date('Y-m-d', $current);
                $current = strtotime('+1 day', $current);
            }
            rsort($dates); // Descending order
        }

        $query = GameRecord::where('user_id', $user->id)
            ->when($api_type, function ($query) use ($api_type) {
                return $query->where('platform_type', strtolower($api_type));
            })
            ->when($start, function ($query) use ($start) {
                return $query->where('updated_at', '>=', $start);
            })->when($end, function ($query) use ($end) {
                return $query->where('updated_at', '<=', $end);
            })
            ->selectRaw('DATE(updated_at) as date, SUM(bet_amount) as bet_amount, SUM(win_loss) as win_loss')
            ->groupBy(DB::raw('DATE(updated_at)'))
            ->orderBy('date', 'desc');

        if (!empty($dates)) {
            $records = $query->get()->keyBy('date');
            $filledData = [];
            foreach ($dates as $date) {
                if (isset($records[$date])) {
                    $filledData[] = $records[$date];
                } else {
                    $filledData[] = [
                        'date' => $date,
                        'bet_amount' => "0.00",
                        'win_loss' => "0.00"
                    ];
                }
            }

            // Manual Pagination
            $page = LengthAwarePaginator::resolveCurrentPage();
            $total = count($filledData);
            $results = array_slice($filledData, ($page - 1) * $pagesize, $pagesize);

            $list = new LengthAwarePaginator($results, $total, $pagesize, $page, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]);

        } else {
            $list = $query->paginate($pagesize);
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
        
        // 判断是手机端还是电脑端访问
        $isMobile = $this->isMobile();
        
        // 从 game_lists 表获取所有游戏场馆
        // 电脑端访问：只获取 site_state = 1 的数据
        // 手机端访问：只获取 app_state = 1 的数据
        $gameListQuery = GameList::select('platform_name', 'name', 'app_icon', 'api_logo_img', 'mobile_img', 'header_logo')
            ->whereNotNull('platform_name')
            ->where('platform_name', '!=', '');
        
        if ($isMobile) {
            // 手机端：只获取 app_state = 1 的数据
            $gameListQuery->where('app_state', 1);
        } else {
            // 电脑端：只获取 site_state = 1 的数据
            $gameListQuery->where('site_state', 1);
        }
        
        // 获取所有符合条件的游戏场馆，按 platform_name 去重，保留每个平台的第一条记录
        $gameListPlatformsRaw = $gameListQuery->orderBy('id', 'asc')->get();
        $gameListPlatforms = [];
        $seenPlatformNames = [];
        foreach ($gameListPlatformsRaw as $item) {
            if (!in_array($item->platform_name, $seenPlatformNames)) {
                $gameListPlatforms[] = $item;
                $seenPlatformNames[] = $item->platform_name;
            }
        }
        
        $data = array();
        foreach($gameListPlatforms as $key => $gameList){
            // 从 user_api 表获取对应的余额
            $User_Api = User_Api::where('api_code', $gameList->platform_name)->where('user_id', $user->id)->first();
            
            // 获取图标（优先使用 api_logo_img，其次使用 app_icon）
            $iconPath = $gameList->api_logo_img ?? $gameList->app_icon ?? '';
            $appIcon = '';
            if (!empty($iconPath)) {
                // 如果图标路径已经包含 http:// 或 https://，则不再添加 APP_URL
                if (strpos($iconPath, 'http://') === 0 || strpos($iconPath, 'https://') === 0) {
                    $appIcon = $iconPath;
                } else {
                    $appIcon = env('APP_URL') . '/uploads/' . $iconPath;
                }
            }
            
            $data[$key]['balance'] = $User_Api ? sprintf("%.2f", $User_Api->api_money) : '0.00';
            $data[$key]['name'] = $gameList->name;
            $data[$key]['platname'] = $gameList->platform_name;
            $data[$key]['app_icon'] = $appIcon;
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

        // 验证用户是否存在
        if (!$user) {
            return $this->returnMsg(401, [], '用户未登录');
        }

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
        $api_type = $data['api_type'] ?? '';
        $type =  $data['type'] ?? '';

        // 同步 game_records 中 is_back=0 的记录到 TransferLog
        // 通过 valid_amount 和该用户的会员等级写入 TransferLog 表
        try {
            $this->syncBackflowFromGameRecords($user, $start, $end, $api_type);
        } catch (\Throwable $e) {
            Log::error('fanshui方法中同步返水记录失败', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // 即使同步失败，也继续返回返水列表
        }


        // 查询返水记录列表
        // 先查询所有符合条件的记录，用于调试
        $allRecords = TransferLog::where('user_id', $user->id)
            ->where('transfer_type', 6)
            ->get();

        Log::debug('fanshui查询所有返水记录（调试）', [
            'user_id' => $user->id,
            'total_records' => $allRecords->count(),
            'records' => $allRecords->map(function($r) {
                return [
                    'id' => $r->id,
                    'platform_type' => $r->platform_type,
                    'state' => $r->state,
                    'real_money' => $r->real_money,
                    'created_at' => $r->created_at,
                ];
            })->toArray(),
        ]);

        $query = TransferLog::where('user_id', $user->id)->where('transfer_type', 6);

        // 应用时间筛选
        if (!empty($start)) {
            $query->where('created_at', '>=', $start);
        }
        if (!empty($end)) {
            $query->where('created_at', '<=', $end);
        }

        // 应用平台类型筛选（使用 platform_type 字段）
        if (!empty($api_type)) {
            $query->whereRaw('LOWER(platform_type) = ?', [strtolower(trim((string)$api_type))]);
        }

        // 应用状态筛选
        if (!empty($type)) {
            $query->where('state', '=', ($type - 1));
        }

        $lists = $query->orderBy('id', 'desc')->paginate($pagesize);

        // 添加调试日志
        Log::debug('fanshui查询返水记录（应用筛选后）', [
            'user_id' => $user->id,
            'start' => $start,
            'end' => $end,
            'api_type' => $api_type,
            'type' => $type,
            'total_count' => $lists->total(),
            'current_count' => $lists->count(),
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
        ]);

        // 通过 transfer_logs 的 bet_id 去 game_records 获取 game_type，然后从 game_categories 获取 name
        $betIds = [];
        foreach ($lists as $v) {
            // transfer_logs 表的字段是 bet_id（有下划线）
            $betId = is_array($v) ? ($v['bet_id'] ?? null) : ($v->bet_id ?? null);
            if (!empty($betId)) {
                $betIds[] = $betId;
            }
        }
        $betIds = array_unique(array_filter($betIds));

        $gameNamesMap = [];
        $betIdToGameTypeMap = [];

        if (!empty($betIds)) {
            // 从 game_records 表获取 bet_id 对应的 game_type
            $gameRecords = GameRecord::whereIn('bet_id', $betIds)
                ->select('bet_id', 'game_type')
                ->get();

            // 收集所有 game_type（转小写）并建立 bet_id 到 game_type 的映射
            $gameTypeCodes = [];
            foreach ($gameRecords as $record) {
                $betId = $record->bet_id;
                $gameType = strtolower(trim($record->game_type ?? ''));
                if (!empty($gameType)) {
                    $betIdToGameTypeMap[$betId] = $gameType;
                    if (!in_array($gameType, $gameTypeCodes)) {
                        $gameTypeCodes[] = $gameType;
                    }
                }
            }

            // 从 game_categories 表根据 code 获取 name
            if (!empty($gameTypeCodes)) {
                $gameCategories = GameCategory::whereIn('code', $gameTypeCodes)
                    ->select('code', 'name')
                    ->get();

                foreach ($gameCategories as $category) {
                    $gameNamesMap[strtolower($category->code)] = $category->name;
                }
            }

            // 添加调试日志
            Log::debug('fanshui获取游戏分类名称', [
                'bet_ids_count' => count($betIds),
                'game_records_count' => $gameRecords->count(),
                'game_type_codes' => $gameTypeCodes,
                'game_names_map' => $gameNamesMap,
                'bet_id_to_game_type_map' => $betIdToGameTypeMap,
            ]);
        }

        // 设置 gamename
        foreach ($lists as $k => $v) {
            // transfer_logs 表的字段是 bet_id（有下划线）
            // 注意：$v 可能是数组或对象，需要兼容两种访问方式
            $betId = null;
            if (is_array($v)) {
                $betId = $v['bet_id'] ?? null;
            } else {
                $betId = $v->bet_id ?? null;
            }

            $gamename = '';

            // 添加调试日志（仅记录前几条，避免日志过多）
            if ($k < 3) {
                Log::debug('fanshui处理单条记录', [
                    'transfer_log_id' => is_array($v) ? ($v['id'] ?? null) : ($v->id ?? null),
                    'betid' => $betId,
                    'betid_type' => gettype($betId),
                    'has_betid_in_map' => !empty($betId) && isset($betIdToGameTypeMap[$betId]),
                ]);
            }

            if (!empty($betId) && isset($betIdToGameTypeMap[$betId])) {
                $gameType = $betIdToGameTypeMap[$betId];
                if (!empty($gameType) && isset($gameNamesMap[$gameType])) {
                    $gamename = $gameNamesMap[$gameType];
                    if ($k < 3) {
                        Log::debug('fanshui从game_categories获取gamename成功', [
                            'bet_id' => $betId,
                            'game_type' => $gameType,
                            'gamename' => $gamename,
                        ]);
                    }
                } else {
                    if ($k < 3) {
                        Log::debug('fanshui game_type未在game_categories中找到', [
                            'bet_id' => $betId,
                            'game_type' => $gameType,
                            'game_names_map_keys' => array_keys($gameNamesMap),
                        ]);
                    }
                }
            } else {
                if ($k < 3) {
                    Log::debug('fanshui bet_id未在game_records中找到或为空', [
                        'bet_id' => $betId,
                        'bet_id_to_game_type_map_keys' => array_keys($betIdToGameTypeMap),
                    ]);
                }
            }

            // 如果找不到，使用原来的逻辑作为后备
            if (empty($gamename)) {
                $platformType = is_array($v) ? ($v['platform_type'] ?? '') : ($v->platform_type ?? '');
                $gamename = $this->game_list[$platformType] ?? '';

                // 添加调试日志（仅记录前几条）
                if ($k < 3) {
                    Log::debug('fanshui使用后备逻辑设置gamename', [
                        'bet_id' => $betId,
                        'platform_type' => $platformType,
                        'gamename' => $gamename,
                    ]);
                }
            }

            // 兼容数组和对象访问方式
            if (is_array($lists[$k])) {
                $lists[$k]['gamename'] = $gamename;
            } else {
                $lists[$k]->gamename = $gamename;
            }
        }
        $list['list'] = $lists;

        // 计算已领取和未领取的返水金额（不应用时间筛选，统计所有记录）
        $jisuan = TransferLog::where('user_id', $user->id)
            ->where('transfer_type', 6)
            ->where('state', 1)
            ->sum('real_money');

        $nojisuan = TransferLog::where('user_id', $user->id)
            ->where('transfer_type', 6)
            ->where('state', 0)
            ->sum('real_money');

        // 确保返回数字类型（sum 可能返回字符串）
        $list['jisuan'] = (float)($jisuan ?? 0);
        $list['nojisuan'] = (float)($nojisuan ?? 0);

        // 添加调试日志
        Log::debug('fanshui返水统计', [
            'user_id' => $user->id,
            'jisuan' => $list['jisuan'],
            'nojisuan' => $list['nojisuan'],
            'jisuan_type' => gettype($list['jisuan']),
            'nojisuan_type' => gettype($list['nojisuan']),
            'list_count' => $lists->count(),
            'list_total' => $lists->total(),
        ]);

        return $this->returnMsg(200, $list);
    }

    public function dofanshui(Request $request)
    {
        $data = $request->all();
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();

        // 验证用户是否存在
        if (!$user) {
            return $this->returnMsg(401, [], '用户未登录');
        }

        // 查询未领取的返水记录（state=0, transfer_type=6）
        $betlist = TransferLog::where('user_id', $user->id)
            ->where('state', 0)
            ->where('transfer_type', 6)
            ->select('bet_id')
            ->get();

        $userfanshui = TransferLog::where('user_id', $user->id)
            ->where('state', 0)
            ->where('transfer_type', 6)
            ->sum('real_money');

        // 将 sum 结果转换为浮点数（sum 可能返回字符串）
        $userfanshui = (float)($userfanshui ?? 0);

        // 添加调试日志
        Log::debug('dofanshui查询返水记录', [
            'user_id' => $user->id,
            'betlist_count' => $betlist->count(),
            'userfanshui' => $userfanshui,
            'userfanshui_type' => gettype($userfanshui),
        ]);

        // 查询所有未领取的返水记录用于调试
        $allUnclaimed = TransferLog::where('user_id', $user->id)
            ->where('state', 0)
            ->where('transfer_type', 6)
            ->get();

        Log::debug('dofanshui所有未领取返水记录（调试）', [
            'user_id' => $user->id,
            'count' => $allUnclaimed->count(),
            'records' => $allUnclaimed->map(function($r) {
                return [
                    'id' => $r->id,
                    'betid' => $r->bet_id,
                    'real_money' => $r->real_money,
                    'platform_type' => $r->platform_type,
                    'state' => $r->state,
                ];
            })->toArray(),
        ]);

        if ($userfanshui > 0) {
            $userinfo = Users::where('id', $user->id)->lockForUpdate()->first();
            $userinfo->balance = $userinfo->balance + $userfanshui;
            $userinfo->save();

            // 更新返水记录状态为已发放（必须同时满足 transfer_type=6）
            TransferLog::where('user_id', $user->id)
                ->where('transfer_type', 6)
                ->where('state', 0)
                ->update(['state' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
            $betidarray=[];
            foreach ($betlist as $val){
                $betidarray[]=$val['bet_id'];
            }

            GameRecord::where('user_id', $user->id)->whereIn('bet_id', $betidarray)->update(['is_back' => 1, 'updated_at' => date('Y-m-d H:i:s')]);

            return $this->returnMsg(200, '', '成功领取');
        } else {
            return $this->returnMsg(202, '', '没有可领取的返水');
        }

    }

    /**
     * 获取下级返水记录
     * 获取所有pid是当前用户id的下级用户的返水记录（transfer_type=99）
     */
    public function subordinateFanshui(Request $request){
        $data = $request->all();
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();

        // 验证用户是否存在
        if (!$user) {
            return $this->returnMsg(401, [], '用户未登录');
        }

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
        $api_type = $data['api_type'] ?? '';
        $type =  $data['type'] ?? '';

        // 查询返水记录列表（transfer_type=99，user_id是当前用户）
        $query = TransferLog::where('user_id', $user->id)->where('transfer_type', 99);

        // 应用时间筛选
        if (!empty($start)) {
            $query->where('created_at', '>=', $start);
        }
        if (!empty($end)) {
            $query->where('created_at', '<=', $end);
        }

        // 应用平台类型筛选（使用 platform_type 字段）
        if (!empty($api_type)) {
            $query->whereRaw('LOWER(platform_type) = ?', [strtolower(trim((string)$api_type))]);
        }

        // 应用状态筛选
        if (!empty($type)) {
            $query->where('state', '=', ($type - 1));
        }

        $lists = $query->orderBy('id', 'desc')->paginate($pagesize);

        // 通过 transfer_logs 的 bet_id 去 game_records 获取 game_type，然后从 game_categories 获取 name
        $betIds = [];
        foreach ($lists as $v) {
            // transfer_logs 表的字段是 bet_id（有下划线）
            $betId = is_array($v) ? ($v['bet_id'] ?? null) : ($v->bet_id ?? null);
            if (!empty($betId)) {
                $betIds[] = $betId;
            }
        }
        $betIds = array_unique(array_filter($betIds));

        $gameNamesMap = [];
        $betIdToGameTypeMap = [];

        if (!empty($betIds)) {
            // 从 game_records 表获取 bet_id 对应的 game_type
            $gameRecords = GameRecord::whereIn('bet_id', $betIds)
                ->select('bet_id', 'game_type')
                ->get();

            // 收集所有 game_type（转小写）并建立 bet_id 到 game_type 的映射
            $gameTypeCodes = [];
            foreach ($gameRecords as $record) {
                $betId = $record->bet_id;
                $gameType = strtolower(trim($record->game_type ?? ''));
                if (!empty($gameType)) {
                    $betIdToGameTypeMap[$betId] = $gameType;
                    if (!in_array($gameType, $gameTypeCodes)) {
                        $gameTypeCodes[] = $gameType;
                    }
                }
            }

            // 从 game_categories 表根据 code 获取 name
            if (!empty($gameTypeCodes)) {
                $gameCategories = GameCategory::whereIn('code', $gameTypeCodes)
                    ->select('code', 'name')
                    ->get();

                foreach ($gameCategories as $category) {
                    $gameNamesMap[strtolower($category->code)] = $category->name;
                }
            }
        }

        // 设置 gamename
        foreach ($lists as $k => $v) {
            // transfer_logs 表的字段是 bet_id（有下划线）
            // 注意：$v 可能是数组或对象，需要兼容两种访问方式
            $betId = null;
            if (is_array($v)) {
                $betId = $v['bet_id'] ?? null;
            } else {
                $betId = $v->bet_id ?? null;
            }

            $gamename = '';

            if (!empty($betId) && isset($betIdToGameTypeMap[$betId])) {
                $gameType = $betIdToGameTypeMap[$betId];
                if (!empty($gameType) && isset($gameNamesMap[$gameType])) {
                    $gamename = $gameNamesMap[$gameType];
                }
            }

            // 如果找不到，使用原来的逻辑作为后备
            if (empty($gamename)) {
                $platformType = is_array($v) ? ($v['platform_type'] ?? '') : ($v->platform_type ?? '');
                $gamename = $this->game_list[$platformType] ?? '';
            }

            // 兼容数组和对象访问方式
            if (is_array($lists[$k])) {
                $lists[$k]['gamename'] = $gamename;
            } else {
                $lists[$k]->gamename = $gamename;
            }
        }
        $list['list'] = $lists;

        // 计算已领取和未领取的下级返水金额（不应用时间筛选，统计所有记录）
        $jisuan = TransferLog::where('user_id', $user->id)
            ->where('transfer_type', 99)
            ->where('state', 1)
            ->sum('real_money');

        $nojisuan = TransferLog::where('user_id', $user->id)
            ->where('transfer_type', 99)
            ->where('state', 0)
            ->sum('real_money');

        // 确保返回数字类型（sum 可能返回字符串）
        $list['jisuan'] = (float)($jisuan ?? 0);
        $list['nojisuan'] = (float)($nojisuan ?? 0);

        return $this->returnMsg(200, $list);
    }

    /**
     * 领取下级返水
     * 将当前用户所有state=0的下级返水记录（transfer_type=99）改为state=1，并将返水金额累加到用户余额
     */
    public function doSubordinateFanshui(Request $request)
    {
        $data = $request->all();
        $token = $request->header('authorization');
        $token = str_replace('Bearer ','',$token) ;
        $user = User::where('api_token',$token)->first();

        // 验证用户是否存在
        if (!$user) {
            return $this->returnMsg(401, [], '用户未登录');
        }

        // 使用 BackflowService 的下级返水出账方法
        $backflowService = new BackflowService();
        $result = $backflowService->subordinateBackflowOut($user->id);

        if ($result['code'] == 200) {
            return $this->returnMsg(200, $result['data'] ?? [], $result['message'] ?? '成功领取');
        } else {
            return $this->returnMsg(202, [], $result['message'] ?? '没有可领取的下级返水');
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
        })->where('is_top',1)->where('child_id', '>', 0)->where('site_state',1)
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
        $appUrl = env('APP_URL');
        $sponsors = Sponsor::active()
            ->published()
            ->ordered()
            ->select('id', 'name', 'title', 'logo', 'banner', 'link_url', 'link_type', 'content_type', 'content', 'description')
            ->get()
            ->map(function ($sponsor) use ($appUrl) {
                $content = $this->cleanContent($sponsor->content);

                // 处理内容中的图片路径，添加完整域名
                if (!empty($content)) {
                    // 匹配 src="/uploads/... " 或 src="/storage/... "
                    $content = preg_replace('/src="\/([^"]+)"/', 'src="' . $appUrl . '/$1"', $content);
                }

                return [
                    'id' => $sponsor->id,
                    'name' => $sponsor->name,
                    'title' => $sponsor->title,
                    'logo' => $sponsor->logo_url,
                    'banner' => $sponsor->banner_url,
                    'link_url' => $sponsor->link_url,
                    'link_type' => $sponsor->link_type,
                    'content_type' => $sponsor->content_type,
                    'content' => $content,
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

    /**
     * 同步 game_records 中 is_back=0 的记录到 TransferLog
     * 参考 GameRecordObserver::handleBackflow() 的逻辑
     *
     * @param User $user 用户对象
     * @param string $start 开始时间（可选）
     * @param string $end 结束时间（可选）
     * @param string $api_type 平台类型（可选）
     * @return void
     */
    private function syncBackflowFromGameRecords(User $user, $start = '', $end = '', $api_type = '')
    {
        try {
            Log::info('开始同步返水记录', [
                'user_id' => $user->id,
                'start' => $start,
                'end' => $end,
                'api_type' => $api_type,
            ]);

            $backflowService = new BackflowService();

            // 查询 game_records 中 is_back=0 且 status=1 且 valid_amount>0 的记录
            // 这些记录将通过 valid_amount 和该用户的会员等级写入 TransferLog 表
            $query = GameRecord::where('user_id', $user->id)
                ->where('is_back', 0)
                ->where('status', 1)
                ->where('valid_amount', '>', 0);

            // 应用时间筛选
            if (!empty($start)) {
                $query->where('created_at', '>=', $start);
            }
            if (!empty($end)) {
                $query->where('created_at', '<=', $end);
            }

            // 应用平台类型筛选
            if (!empty($api_type)) {
                $query->whereRaw('LOWER(platform_type) = ?', [strtolower(trim((string)$api_type))]);
            }

            $gameRecords = $query->get();

            if ($gameRecords->isEmpty()) {
                return;
            }

            $successCount = 0;
            $failCount = 0;

            foreach ($gameRecords as $gameRecord) {
                try {
                    // 检查有效投注金额
                    $validAmount = (float)($gameRecord->valid_amount ?? 0);
                    if ($validAmount <= 0) {
                        // 有效投注为0，跳过处理
                        continue;
                    }

                    // 检查用户ID
                    $userId = (int)($gameRecord->user_id ?? 0);
                    if ($userId <= 0) {
                        Log::warning('游戏记录缺少用户ID，无法生成返水记录', [
                            'game_record_id' => $gameRecord->id,
                        ]);
                        continue;
                    }

                    // 获取平台类型
                    $platformType = $gameRecord->platform_type ?? '';
                    if (empty($platformType)) {
                        Log::warning('游戏记录缺少平台类型，无法生成返水记录', [
                            'game_record_id' => $gameRecord->id,
                            'user_id' => $userId,
                        ]);
                        continue;
                    }

                    // 获取游戏类型和注单ID
                    $gameType = $gameRecord->game_type ?? null;
                    $betId = $gameRecord->bet_id ?? null;

                    // 判断 bet_id 是否已存在于 TransferLog 中（判断是否已生成返水记录）
                    if (!empty($betId)) {
                        $existingLog = TransferLog::where('bet_id', $betId)
                            ->where('transfer_type', 6)
                            ->where('user_id', $userId)
                            ->first();

                        if ($existingLog) {
                            // bet_id 已存在，跳过处理
                            Log::debug('游戏记录返水已存在，跳过', [
                                'game_record_id' => $gameRecord->id,
                                'user_id' => $userId,
                                'bet_id' => $betId,
                                'transfer_log_id' => $existingLog->id,
                            ]);
                            continue;
                        }
                    }

                    // 调用返水服务生成返水记录
                    // 参考 BackflowService::backflowIn() 的逻辑：
                    // - 使用 valid_amount 作为投注金额
                    // - 通过 game_type（转小写）获取对应的分类
                    // - 根据用户的VIP等级和游戏分类计算返水比例
                    // - 写入 TransferLog 表（transfer_type=6, state=0），并写入 bet_id
                    $result = $backflowService->backflowIn(
                        $userId,
                        $platformType,
                        $validAmount,  // 使用 valid_amount 作为投注金额
                        $gameType,     // 使用 game_type 获取分类
                        $betId,        // 传入 bet_id，用于判断是否已存在返水记录
                        null,          // gameCode（已废弃，保留用于兼容）
                        null,          // venueCode（已废弃，保留用于兼容）
                        $gameRecord->id
                    );

                    // 记录日志并处理结果
                    $resultCode = (int)($result['code'] ?? 0);
                    if ($resultCode == 200) {
                        // code=200 表示处理成功（即使返水金额为0，也表示已正确处理）
                        $backflowAmount = (float)($result['data']['backflow_amount'] ?? 0);
                        if ($backflowAmount > 0) {
                            Log::info('同步游戏记录返水成功', [
                                'game_record_id' => $gameRecord->id,
                                'user_id' => $userId,
                                'platform_type' => $platformType,
                                'game_type' => $gameType,
                                'bet_id' => $betId,
                                'valid_amount' => $validAmount,
                                'backflow_amount' => $backflowAmount,
                                'transfer_log_id' => $result['data']['transfer_log_id'] ?? null,
                            ]);
                            $successCount++;
                        } else {
                            // 返水金额为0（可能是VIP等级未设置、返水开关关闭、返水比例为0等）
                            Log::debug('游戏记录返水金额为0（已处理）', [
                                'game_record_id' => $gameRecord->id,
                                'user_id' => $userId,
                                'platform_type' => $platformType,
                                'valid_amount' => $validAmount,
                                'reason' => $result['message'] ?? '返水金额为0',
                            ]);
                        }
                        // 不再标记 is_back=1，判断是否已处理改为检查 bet_id 是否已存在
                    } else {
                        // code!=200 表示处理失败（如用户不存在、游戏不存在等错误）
                        // 不标记 is_back=1，以便后续重试
                        Log::warning('游戏记录返水处理失败，未标记is_back', [
                            'game_record_id' => $gameRecord->id,
                            'user_id' => $userId,
                            'platform_type' => $platformType,
                            'game_type' => $gameType,
                            'valid_amount' => $validAmount,
                            'result_code' => $resultCode,
                            'reason' => $result['message'] ?? '未知原因',
                        ]);
                        $failCount++;
                    }

                } catch (\Throwable $e) {
                    Log::error('同步游戏记录返水异常', [
                        'game_record_id' => $gameRecord->id ?? null,
                        'user_id' => $gameRecord->user_id ?? null,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    $failCount++;
                }
            }

            if ($successCount > 0 || $failCount > 0) {
                Log::info('同步返水记录完成', [
                    'user_id' => $user->id,
                    'success_count' => $successCount,
                    'fail_count' => $failCount,
                    'total' => $gameRecords->count(),
                ]);
            }

        } catch (\Throwable $e) {
            Log::error('同步返水记录异常', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * 将 game_records.is_back 标记为 1（不触发 observer，避免 updated 递归）
     * 参考 GameRecordObserver::markAsBacked() 的逻辑
     *
     * @param GameRecord $gameRecord
     * @param string $reason
     * @return void
     */
    /**
     * 回收用户所有场馆的余额（遍历user_api表，回收所有场馆的资产）
     * 必须遍历所有场馆，不管是否失败，都要调用接口扣除游戏接口方的余额
     * 
     * @param User $user
     * @return void
     */
    protected function recycleAllPlatformsBalance($user)
    {
        try {
            // 获取用户所有已注册的场馆（必须遍历所有，不管是否有余额）
            $userApis = User_Api::where('user_id', $user->id)->get();
            
            if ($userApis->isEmpty()) {
                Log::info('回收所有场馆余额 - 用户未注册任何场馆', ['user_id' => $user->id]);
                return;
            }

            Log::info('回收所有场馆余额 - 开始', [
                'user_id' => $user->id,
                'platforms_count' => $userApis->count(),
                'platforms' => $userApis->pluck('api_code')->toArray()
            ]);

            $payController = new \App\Http\Controllers\Api\PayController();
            $successCount = 0;
            $failCount = 0;
            $totalRecycled = 0;

            // 必须遍历所有场馆，不管是否失败，都要继续处理直到所有场馆都处理完毕
            foreach ($userApis as $userApi) {
                $platformType = $userApi->api_code;
                
                try {
                    // 调用回收接口，这会调用游戏接口方的 withdrawal 方法扣除余额
                    // 即使接口返回失败（如余额不足），也会继续处理下一个平台
                    $result = $payController->recyclePlatformBalance($user, $platformType);
                    
                    if ($result && isset($result['code'])) {
                        if ($result['code'] == 200) {
                            $recycledAmount = $result['data']['amount'] ?? 0;
                            if ($recycledAmount > 0) {
                                $totalRecycled += $recycledAmount;
                                $successCount++;
                                Log::info('回收所有场馆余额 - 单个平台回收成功', [
                                    'user_id' => $user->id,
                                    'platform_type' => $platformType,
                                    'amount' => $recycledAmount
                                ]);
                            } else {
                                // 即使没有余额，也算处理成功（因为已经调用了接口）
                                $successCount++;
                                Log::info('回收所有场馆余额 - 单个平台无余额（已调用接口）', [
                                    'user_id' => $user->id,
                                    'platform_type' => $platformType
                                ]);
                            }
                        } else {
                            // 接口返回失败（如余额不足、接口错误等），记录失败但不中断流程，继续处理下一个平台
                            $failCount++;
                            Log::warning('回收所有场馆余额 - 单个平台回收失败（已尝试调用接口，继续处理其他场馆）', [
                                'user_id' => $user->id,
                                'platform_type' => $platformType,
                                'result_code' => $result['code'],
                                'result_message' => $result['message'] ?? '未知错误',
                                'result' => $result
                            ]);
                        }
                    } else {
                        // 返回结果格式异常，记录失败但不中断流程
                        $failCount++;
                        Log::warning('回收所有场馆余额 - 单个平台返回结果格式异常（继续处理其他场馆）', [
                            'user_id' => $user->id,
                            'platform_type' => $platformType,
                            'result' => $result
                        ]);
                    }
                } catch (\Throwable $e) {
                    // 捕获所有异常和错误（包括 Error 和 Exception），确保不会中断其他场馆的回收
                    $failCount++;
                    Log::error('回收所有场馆余额 - 单个平台异常（已尝试调用接口，继续处理其他场馆）', [
                        'user_id' => $user->id,
                        'platform_type' => $platformType ?? 'unknown',
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
                
                // 无论成功或失败，都继续处理下一个平台
            }

            // 刷新用户余额（从数据库重新获取最新余额）
            $user->refresh();

            Log::info('回收所有场馆余额 - 完成', [
                'user_id' => $user->id,
                'success_count' => $successCount,
                'fail_count' => $failCount,
                'total_recycled' => $totalRecycled,
                'final_balance' => $user->balance,
                'processed_platforms' => $userApis->count()
            ]);
        } catch (\Throwable $e) {
            // 捕获所有异常和错误（包括 Error 和 Exception），确保不会中断流程
            Log::error('回收所有场馆余额 - 异常', [
                'user_id' => $user->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function markGameRecordAsBacked(GameRecord $gameRecord, string $reason)
    {
        try {
            if ((int)($gameRecord->is_back ?? 0) !== 0) {
                return;
            }

            GameRecord::withoutEvents(function () use ($gameRecord) {
                $gameRecord->is_back = 1;
                $gameRecord->save();
            });

            Log::debug('游戏记录已标记为已返水处理(is_back=1)', [
                'reason' => $reason,
                'game_record_id' => $gameRecord->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('标记游戏记录is_back失败', [
                'reason' => $reason,
                'game_record_id' => $gameRecord->id ?? null,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
