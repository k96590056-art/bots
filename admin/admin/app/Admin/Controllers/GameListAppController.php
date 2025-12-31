<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\GameListApp;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Services\TgService;
use App\Admin\Tools\UrlEdit;
use App\Models\GameCategory;
class GameListAppController extends AdminController
{
    protected $is_hot = [0 => '非热门',1 => '热门'];
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
        return Grid::make(new GameListApp(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('platform_name');
            $grid->column('name');
            $grid->column('game_code');
            $grid->column('with_api', '所属接口')->using($this->getApiOptions());
            $grid->column('category_id')->using($this->getCategories());
            $grid->column('app_state')->using([1 => '正常',0 => '关闭']);
            $grid->column('created_at');
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
        return Show::make($id, new GameListApp(), function (Show $show) {
            $show->field('id');
            $show->field('platform_name');
            $show->field('name');
            $show->field('name_en');
            $show->field('with_api','所属接口')->using($this->getApiOptions());
            $show->field('app_state');
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
        
        return Form::make(new GameListApp(), function (Form $form) {
            $plat = [];
            $form->display('id');
            $form->text('platform_name')->required();
            $form->text('name')->required();
            $form->text('game_code')->required();
            $form->select('with_api','所属接口')->options($this->getApiOptions())->required()->help('选择该游戏所属的接口来源');
			$form->select('category_id')->options($this->getCategories())->required();
            $form->image('app_img','手机热门图片')->uniqueName();
            $form->number('order_by','排序')->default(0)->help("数字越小越靠前");
            $form->radio('app_state')->options([1 => '正常',0 => '关闭'])->default(1);
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
