<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\GameList;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Services\TgService;
use App\Admin\Tools\UrlEdit;
use App\Models\GameCategory;
class GameListController extends AdminController
{
    /**
     * 所属接口选项
     * @return array
     */
    protected function getApiOptions()
    {
        return [
            'tg' => 'Leyu聚合',
            'dp' => 'DP',
            'pussy' => 'Pussy888',
        ];
    }
    /**
     * 获取游戏类目列表（用于下拉选择）
     * @return array
     */
    protected function getCategories()
    {
        $categories = GameCategory::orderBy('order')->orderBy('id')->get();
        $result = [];
        foreach ($categories as $category) {
            $result[$category->code] = $category->name;
        }
        return $result;
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        // $tg = new TgService();
        // dd($tg->gameslist('ae'));
        return Grid::make(new GameList(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('platform_name');
            $grid->column('name');
            $grid->column('game_code');
            $grid->column('venue_code', '接口编码');
            $grid->column('with_api', '所属接口')->using($this->getApiOptions());
            //$grid->column('game_icon')->image('',100,100);
            // $grid->column('name_en');
            // $grid->column('keywords');
            $grid->column('category_id')->using($this->getCategories());
            // $grid->column('order_by');
            // $grid->column('state');
            $grid->column('is_hot','热门状态')->switch();
            $grid->column('transferstatus','免转状态')->switch();
            $grid->column('site_state','站点状态')->switch();
            $grid->column('app_state','APP状态')->switch();
            $grid->column('created_at');
            // $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('category_id')->select($this->getCategories());
                $filter->equal('with_api','所属接口')->select($this->getApiOptions());
                $filter->like('name');
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
                $actions->disableDelete();
              
            });
			//$grid->tools(new UrlEdit());
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new GameList(), function (Show $show) {
            $show->field('id');
            $show->field('platform_name');
            $show->field('name');
            $show->field('name_en');
            // $show->field('keywords');
            // $show->field('category_id');
            // $show->field('game_code');
            // $show->field('game_img');
            $show->field('with_api','所属接口')->using($this->getApiOptions());
            // $show->field('order_by');
            // $show->field('state');
            // $show->field('is_hot');
            // $show->field('is_new');
            // $show->field('is_recommend');
            // $show->field('is_pc');
            // $show->field('is_mobile');
            $show->field('site_state');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        
        return Form::make(new GameList(), function (Form $form) {
            $plat = [];
            $form->display('id');
            $form->text('platform_name')->required();
            $form->text('name')->required();
            // $form->text('name_en')->required();
            // $form->text('keywords');
            $form->text('game_code')->required();
            $form->text('venue_code', '接口编码')->help('用于DP服务获取游戏链接的场馆编码，如果不填则使用平台名称');
            $form->select('with_api','所属接口')->options($this->getApiOptions())->required()->help('选择该游戏所属的接口来源');
			$form->select('category_id')->options($this->getCategories())->required();
			$form->image('api_logo_img','接口图标')->uniqueName();
            //$form->image('check_yes_img','PC选中状态')->uniqueName();
            //$form->image('check_no_img','PC未选中状态')->uniqueName();
            $form->image('mobile_img','手机端图片')->uniqueName();
			$form->image('app_img','手机热门图片')->uniqueName();
            $form->number('order_by')->default(0)->help("数字越小越靠前");
            $form->radio('is_hot','热门状态')->options([1 => '是',0 => '否'])->default(0)->help("热门游戏会显示在热门分类中");
            $form->radio('transferstatus','免转状态')->options([0 => '免转',1 => '非免转'])->default(0)->help("0=免转（不需要转入转出），1=非免转（需要转入转出）");
            $form->radio('site_state')->options([1 => '正常',0 => '关闭'])->default(1);
            $form->radio('app_state','APP状态')->options([1 => '正常',0 => '关闭'])->default(1);
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
