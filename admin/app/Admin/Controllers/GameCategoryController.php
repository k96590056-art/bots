<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\GameCategory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class GameCategoryController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new GameCategory(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('image', '缩略图')->image('', 50, 50);
            $grid->column('name', '游戏类目名称');
            $grid->column('code', '类目编码');
            $grid->column('order', '排序')->sortable();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            
            // 默认按排序字段排序
            $grid->model()->orderBy('order')->orderBy('id');
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name', '游戏类目名称');
                $filter->like('code', '类目编码');
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
        return Show::make($id, new GameCategory(), function (Show $show) {
            $show->field('id');
            $show->field('image', '缩略图')->image();
            $show->field('name', '游戏类目名称');
            $show->field('code', '类目编码');
            $show->field('order', '排序');
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
        return Form::make(new GameCategory(), function (Form $form) {
            $form->display('id');
            $form->text('name', '游戏类目名称')->required();
            $form->text('code', '类目编码')->required()->help('类目编码必须唯一，例如：realbet、sport等');
            $form->image('image', '缩略图')->uniqueName()->help('游戏类目缩略图');
            $form->number('order', '排序')->default(0)->help('数字越小越靠前');
            
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}

