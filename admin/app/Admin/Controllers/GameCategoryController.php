<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\GameCategory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;

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
            // 使用树形结构展示
            $grid->model()->orderBy('order')->orderBy('id');
            
            // 设置树形结构的父级字段和标题字段
            $grid->column('id')->sortable();
            $grid->column('image', '缩略图')->image('', 50, 50);
            
            // 显示分类名称，添加展开/折叠按钮
            $grid->column('name', '游戏类目名称')->display(function ($name) {
                $categoryId = $this->id;
                $hasChildren = \App\Models\GameCategory::where('pid', $categoryId)->exists();
                
                $toggleBtn = '';
                if ($hasChildren) {
                    $toggleBtn = '<span class="category-toggle-btn" data-id="' . $categoryId . '" style="cursor: pointer; margin-right: 5px; display: inline-block; width: 16px;">
                        <i class="fa fa-caret-right"></i>
                    </span>';
                } else {
                    $toggleBtn = '<span style="margin-right: 20px; display: inline-block; width: 16px;"></span>';
                }
                
                return $toggleBtn . $name;
            });
            
            $grid->column('code', '类目编码')->display(function ($code) {
                return $code ?: '-';
            });
            
            // 显示上级分类名称
            $grid->column('pid', '上级分类')->display(function ($pid) {
                if ($pid == 0) {
                    return '<span class="label label-primary">顶级分类</span>';
                }
                $parent = \App\Models\GameCategory::find($pid);
                return $parent ? $parent->name : '-';
            });
            
            $grid->column('order', '排序')->sortable();
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name', '游戏类目名称');
                $filter->like('code', '类目编码');
                // 添加按上级分类过滤
                $parentOptions = \App\Models\GameCategory::where('pid', 0)
                    ->pluck('name', 'id')
                    ->toArray();
                $filter->equal('pid', '上级分类')->select([0 => '顶级分类'] + $parentOptions);
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
            });
            
            // 默认只显示顶级分类，子分类通过展开显示
            $grid->model()->where('pid', 0);
            
            // 添加 JavaScript 实现展开/折叠功能
            // 在 PHP 中生成 URL，避免 Blade 语法在 heredoc 中不生效
            $childrenUrl = admin_url('game-categories/children');
            $script = <<<SCRIPT
<script>
$(document).ready(function() {
    // 绑定展开/折叠按钮点击事件
    $(document).on('click', '.category-toggle-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var \$btn = $(this);
        var categoryId = \$btn.data('id');
        var \$icon = \$btn.find('i');
        var \$row = \$btn.closest('tr');
        var \$childrenRows = \$row.nextAll('tr.category-children-' + categoryId);
        
        if (\$childrenRows.length > 0) {
            // 如果子行已存在，切换显示/隐藏
            if (\$childrenRows.first().is(':visible')) {
                // 收起：隐藏所有子行
                \$childrenRows.hide();
                \$icon.removeClass('fa-caret-down').addClass('fa-caret-right');
            } else {
                // 展开：显示子行
                \$childrenRows.show();
                \$icon.removeClass('fa-caret-right').addClass('fa-caret-down');
            }
        } else {
            // 如果子容器不存在，通过 AJAX 加载
            \$icon.removeClass('fa-caret-right').addClass('fa-spinner fa-spin');
            
            $.ajax({
                url: '{$childrenUrl}',
                type: 'GET',
                data: { parent_id: categoryId },
                success: function(html) {
                    \$icon.removeClass('fa-spinner fa-spin').addClass('fa-caret-down');
                    
                    // 在父分类行后插入子分类行
                    \$row.after(html);
                },
                error: function() {
                    \$icon.removeClass('fa-spinner fa-spin').addClass('fa-caret-right');
                    alert('加载子分类失败');
                }
            });
        }
    });
});
</script>
SCRIPT;
            $grid->html($script);
        });
    }
    
    /**
     * 获取子分类数据（用于 AJAX 加载）
     */
    public function getChildren(Request $request)
    {
        $parentId = $request->get('parent_id', 0);
        $categories = \App\Models\GameCategory::where('pid', $parentId)
            ->orderBy('order')
            ->orderBy('id')
            ->get();
        
        if ($categories->isEmpty()) {
            return '<tr class="category-children-' . $parentId . '"><td colspan="10" style="padding-left: 30px; color: #999; padding: 10px;">暂无子分类</td></tr>';
        }
        
        $html = '';
        foreach ($categories as $category) {
            $hasChildren = \App\Models\GameCategory::where('pid', $category->id)->exists();
            $toggleBtn = '';
            if ($hasChildren) {
                $toggleBtn = '<span class="category-toggle-btn" data-id="' . $category->id . '" style="cursor: pointer; margin-right: 5px; display: inline-block; width: 16px;">
                    <i class="fa fa-caret-right"></i>
                </span>';
            } else {
                $toggleBtn = '<span style="margin-right: 20px; display: inline-block; width: 16px;"></span>';
            }
            
            $imageHtml = '';
            if ($category->image) {
                $imageHtml = '<img src="' . asset('uploads/' . $category->image) . '" style="width: 50px; height: 50px;">';
            }
            
            // 获取上级分类名称
            $parentName = '';
            if ($category->pid > 0) {
                $parent = \App\Models\GameCategory::find($category->pid);
                $parentName = $parent ? $parent->name : '-';
            } else {
                $parentName = '<span class="label label-primary">顶级分类</span>';
            }
            
            $html .= '<tr class="category-children-' . $parentId . '" data-parent="' . $parentId . '">';
            $html .= '<td></td>'; // checkbox 列（空）
            $html .= '<td>' . $category->id . '</td>'; // ID 列
            $html .= '<td>' . $imageHtml . '</td>'; // 缩略图列
            $html .= '<td style="padding-left: 30px;">' . $toggleBtn . $category->name . '</td>'; // 游戏类目名称列
            $html .= '<td>' . ($category->code ?: '-') . '</td>'; // 类目编码列
            $html .= '<td>' . $parentName . '</td>'; // 上级分类列
            $html .= '<td>' . $category->order . '</td>'; // 排序列
            $html .= '<td>' . $category->created_at . '</td>'; // 创建时间列
            $html .= '<td>' . $category->updated_at . '</td>'; // 更新时间列
            $html .= '<td>'; // 操作列
            $html .= '<a href="' . admin_url('game-categories/' . $category->id . '/edit') . '" class="btn btn-sm btn-primary">编辑</a> ';
            $html .= '<a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="if(confirm(\'确定删除吗？\')) { $.post(\'' . admin_url('game-categories/' . $category->id) . '\', {_method:\'delete\',_token:\'' . csrf_token() . '\'}, function(){ location.reload(); }); }">删除</a>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        
        return $html;
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
            
            // 上级分类选择（需要先定义，以便在类目编码字段中使用）
            $currentId = $form->getKey();
            $parentOptions = \App\Models\GameCategory::where('pid', 0)
                ->when($currentId, function ($query) use ($currentId) {
                    // 编辑时排除当前分类，避免循环引用
                    return $query->where('id', '!=', $currentId);
                })
                ->pluck('name', 'id')
                ->toArray();
            
            $form->select('pid', '上级分类')
                ->options([0 => '无（主分类）'] + $parentOptions)
                ->default(0)
                ->help('选择上级分类，不选择则为顶级分类（主分类）。非顶级分类不需要填写类目编码');
            
            // 类目编码：只有顶级分类（pid=0）才需要填写
            $form->text('code', '类目编码')
                ->help('类目编码必须唯一，例如：realbet、sport等（仅顶级分类需要填写）');
            
            // 在保存时根据 pid 判断类目编码是否为必填
            $form->saving(function (Form $form) {
                $pid = intval($form->pid ?? 0);
                $code = trim($form->code ?? '');
                
                // 如果是顶级分类（pid=0），类目编码为必填
                if ($pid == 0 && empty($code)) {
                    return $form->response()->error('顶级分类必须填写类目编码');
                }
                
                // 如果是非顶级分类（pid!=0），可以没有类目编码，设置为空字符串
                if ($pid != 0 && empty($code)) {
                    $form->code = '';
                }
            });
            
            $form->image('image', '缩略图')->uniqueName()->help('游戏类目缩略图');
            $form->image('banner', 'Banner广告图')->uniqueName()->help('Banner广告图');
            $form->number('order', '排序')->default(0)->help('数字越小越靠前');
            
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}

