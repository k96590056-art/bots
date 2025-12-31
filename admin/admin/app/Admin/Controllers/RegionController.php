<?php

namespace App\Admin\Controllers;

use App\Models\Region;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class RegionController extends AdminController
{
    protected $title = '地区设置';

    protected function grid()
    {
        return Grid::make(new Region(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name', '地区名称');
            $grid->column('code', '地区代码');
            $grid->column('status', '状态')->switch();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name', '地区名称');
            });
        });
    }

    protected function detail($id)
    {
        return Show::make($id, new Region(), function (Show $show) {
            $show->field('id');
            $show->field('name', '地区名称');
            $show->field('code', '地区代码');
            $show->field('status', '状态')->as(function ($status) {
                return $status ? '启用' : '禁用';
            });
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    protected function form()
    {
        return Form::make(new Region(), function (Form $form) {
            $form->display('id');
            $form->text('name', '地区名称')->required();
            $form->text('code', '地区代码');
            $form->switch('status', '状态')->default(1);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
