<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\GameTag;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class GameTagController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new GameTag(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name', '标签名称');
            $grid->column('order', '排序')->sortable();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name', '标签名称');
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
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
        return Show::make($id, new GameTag(), function (Show $show) {
            $show->field('id');
            $show->field('name', '标签名称');
            $show->field('order', '排序');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }



    protected function getAutoDiyRoute($name)
    {
        $token = "动态生成";
        $url = "{$this->h5->url}?token={$token}&route={$name}";
        return $url;
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new GameTag(), function (Form $form) {
            $form->display('id');
            $form->text('name', '标签名称')->required()->help('游戏标签名称，例如：热门、推荐、新品等');
            $form->number('order', '排序')->default(0)->help('数字越小越靠前');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}