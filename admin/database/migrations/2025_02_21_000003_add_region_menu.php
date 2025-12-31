<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddRegionMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 查找"管理设置"父菜单
        $parentMenu = DB::table('admin_menu')->where('title', '管理设置')->first();
        
        $parentId = 0;
        if ($parentMenu) {
            $parentId = $parentMenu->id;
        } else {
             // 如果找不到管理设置，尝试找"系统"
             $systemMenu = DB::table('admin_menu')->where('title', '系统')->first();
             if ($systemMenu) {
                 $parentId = $systemMenu->id;
             }
        }

        // 添加地区设置菜单
        if (!DB::table('admin_menu')->where('uri', 'regions')->exists()) {
            DB::table('admin_menu')->insert([
                'parent_id' => $parentId,
                'order' => 10,
                'title' => '地区设置',
                'icon' => 'fa-map-marker',
                'uri' => 'regions',
                'extension' => '',
                'show' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 删除地区设置菜单
        DB::table('admin_menu')->where('title', '地区设置')->delete();
    }
}
