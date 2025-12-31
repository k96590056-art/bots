<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TgService;
use App\Models\GameList;

class SyncGame extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SyncGame';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步游戏';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tg = new TgService();
        $all_type = $tg->getallbetgamelist();
        dd($all_type);
        foreach($all_type as $k => $v) {
            if ($k > 0) {
                $category_id = $v['value'];
                $all_platform = $v['children'];
                foreach ($all_platform as $v1) {
                    $name = $v1['label'];
                    $plat = $v1['value'];
                    $list = $tg->gameslist($plat);
                    if (empty($list['data'])) {
                        // 没有下级游戏
                        $res = GameList::where('platform_name',$plat)->where('category_id',$category_id)->count();
                        if ($res == 0) {
                            $arr = [
                                'platform_name' => $plat,
                                'name' => $name,
                                'game_code' => $plat,
                                'category_id' => $category_id,
                                'is_top' => 1
                            ];
                            var_dump($arr);
                        }
                    } else {
                        foreach ($list['data'] as $v2) {
                            
                        }
                    }
                }
            }
        }
    }
}
