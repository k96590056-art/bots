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
use Illuminate\Http\Request;
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
            'dbdianzi' => '1369',
            'dbgmag' => 'GMAG',
            'dbzhenren' => 'DB真人',
            'dbevo' => 'EVO',
            'dbkaiyuan' => '开元棋牌',
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
     * 获取一级分类列表（pid=0）
     * @return array
     */
    protected function getParentCategories()
    {
        $categories = GameCategory::where('pid', 0)
            ->orderBy('order')
            ->orderBy('id')
            ->get();
        $result = [];
        foreach ($categories as $category) {
            $result[$category->code] = $category->name;
        }
        return $result;
    }
    
    /**
     * 获取子分类列表（用于 AJAX 加载）
     */
    public function getChildCategories(Request $request)
    {
        // Dcat Admin 的 loads() 方法会将父级字段的值作为参数传递
        // 可能使用 depends、q 或字段名 category_id 作为参数名
        $parentCode = $request->get('category_id', $request->get('depends', $request->get('q', '')));
        if (empty($parentCode)) {
            return response()->json([]);
        }
        
        // 先通过 code 找到一级分类
        $parentCategory = GameCategory::where('code', $parentCode)->where('pid', 0)->first();
        if (!$parentCategory) {
            return response()->json([]);
        }
        
        // 获取该一级分类下的所有子分类
        $childCategories = GameCategory::where('pid', $parentCategory->id)
            ->orderBy('order')
            ->orderBy('id')
            ->get();
        
        // Dcat Admin 的 loads() 方法期望的格式是: [{"id": 1, "text": "名称"}, ...]
        $result = [];
        foreach ($childCategories as $category) {
            $result[] = [
                'id' => $category->id,
                'text' => $category->name
            ];
        }
        
        return response()->json($result);
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
			
			// 一级分类选择（联动二级分类）
			$apiUrl = admin_url('game-lists-app/child-categories');
			$form->select('category_id', '一级分类')
				->options($this->getParentCategories())
				->required()
				->help('先选择一级分类')
				->loads('child_id', $apiUrl);
			
			// 二级分类选择（联动一级分类）
			$currentId = $form->getKey();
			$currentCategoryId = '';
			$currentChildId = 0;
			
			// 编辑模式：获取当前游戏的一级分类和二级分类
			if ($currentId) {
				$currentGame = \App\Models\GameListApp::find($currentId);
				if ($currentGame) {
					$currentCategoryId = $currentGame->category_id ?? '';
					$currentChildId = $currentGame->child_id ?? 0;
					
					// 编辑模式下，获取当前一级分类下的子分类用于显示
					$childOptions = [];
					if ($currentCategoryId) {
						$parentCategory = GameCategory::where('code', $currentCategoryId)->where('pid', 0)->first();
						if ($parentCategory) {
							$childCategories = GameCategory::where('pid', $parentCategory->id)
								->orderBy('order')
								->orderBy('id')
								->get();
							foreach ($childCategories as $category) {
								$childOptions[$category->id] = $category->name;
							}
						}
					}
					
					$form->select('child_id', '二级分类')
						->options($childOptions)
						->default($currentChildId)
						->help('选择二级分类（可选，不选择则属于一级分类）');
				} else {
					// 新建模式，不设置 options，由 loads() 动态加载
					$form->select('child_id', '二级分类')
						->options([])
						->help('选择二级分类（可选，不选择则属于一级分类）');
				}
			} else {
				// 新建模式，不设置 options，由 loads() 动态加载
				$form->select('child_id', '二级分类')
					->options([])
					->help('选择二级分类（可选，不选择则属于一级分类）');
			}
			
            $form->image('app_img','手机热门图片')->uniqueName();
            $form->number('order_by','排序')->default(0)->help("数字越小越靠前");
            $form->radio('app_state')->options([1 => '正常',0 => '关闭'])->default(1);
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
