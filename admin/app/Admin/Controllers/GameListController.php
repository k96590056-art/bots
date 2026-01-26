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
use Illuminate\Http\Request;
use App\Models\GameList as GameListModel;
class GameListController extends AdminController
{
    /**
     * 所属接口选项
     * @return array
     */
    protected function getApiOptions()
    {
        return [
            // 'tg' => 'Leyu聚合',
            'db' => 'DB',
            // 'pussy' => 'Pussy888',
            // 'dbdianzi' => '1369',
            'dbgmag' => 'GMAG',
            'dboneapi' => 'ONEAPI',
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
     * 获取场馆列表（用于 AJAX 加载）
     * 场馆数据来源：已选择分类的game_lists表中child_id为空或为0的游戏
     */
    public function getVenues(Request $request)
    {
        // 获取child_id（二级分类ID）
        $childId = $request->get('child_id', $request->get('depends', $request->get('q', '')));
        
        // 获取category_id（一级分类的code）
        $categoryId = $request->get('category_id', '');
        
        // 如果child_id为空，说明没有选择二级分类，不需要加载场馆
        if (empty($childId)) {
            return response()->json([]);
        }
        
        // 如果没有category_id，尝试从child_id获取
        if (empty($categoryId)) {
            $childCategory = GameCategory::find($childId);
            if ($childCategory && $childCategory->pid > 0) {
                $parentCategory = GameCategory::find($childCategory->pid);
                if ($parentCategory) {
                    $categoryId = $parentCategory->code;
                }
            }
        }
        
        if (empty($categoryId)) {
            return response()->json([]);
        }
        
        // 通过code找到一级分类
        $category = GameCategory::where('code', $categoryId)->where('pid', 0)->first();
        if (!$category) {
            return response()->json([]);
        }
        
        // 使用一级分类的code来查找场馆
        // 场馆数据来源：该分类下child_id为空或为0的游戏
        $venues = \App\Models\GameList::where('category_id', $category->code)
            ->where(function($query) {
                $query->whereNull('child_id')
                      ->orWhere('child_id', 0);
            })
            ->orderBy('order_by')
            ->orderBy('id')
            ->get();
        
        // Dcat Admin 的 loads() 方法期望的格式是: [{"id": 1, "text": "名称"}, ...]
        $result = [];
        foreach ($venues as $venue) {
            $result[] = [
                'id' => $venue->id,
                'text' => $venue->name . ' (' . $venue->platform_name . ')'
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
        return Grid::make(new GameList(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('platform_name');
            $grid->column('name');
            $grid->column('game_code');
            $grid->column('venue_code', '接口编码');
            $grid->column('with_api', '所属接口')->using($this->getApiOptions());
            // 所属场馆：表中存的是场馆(game_lists.id)的引用，这里展示为“场馆名(平台)”
            $grid->column('changguan', '所属场馆')->display(function ($venueId) {
                $venueId = (int)($venueId ?? 0);
                if ($venueId <= 0) {
                    return '-';
                }

                static $cache = [];
                if (!array_key_exists($venueId, $cache)) {
                    $venue = GameListModel::query()->select(['id', 'name', 'platform_name'])->find($venueId);
                    $cache[$venueId] = $venue
                        ? ($venue->name . ' (' . $venue->platform_name . ')')
                        : ('#' . $venueId);
                }
                return $cache[$venueId];
            });
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
            $form->text('game_code');
            $form->text('venue_code', '接口编码')->help('用于DP服务获取游戏链接的场馆编码，如果不填则使用平台名称');
            $form->select('with_api','所属接口')->options($this->getApiOptions())->required()->help('选择该游戏所属的接口来源');
			
			// 一级分类选择（联动二级分类和场馆）
			$apiUrl = admin_url('game-lists/child-categories');
			$venueApiUrl = admin_url('game-lists/venues');
			$form->select('category_id', '一级分类')
				->options($this->getParentCategories())
				->required()
				->help('先选择一级分类')
				->loads('child_id', $apiUrl);
			
			// 二级分类选择（联动一级分类和场馆）
			$currentId = $form->getKey();
			$currentCategoryId = '';
			$currentChildId = 0;
			$currentChangguan = 0;
			
			// 编辑模式：获取当前游戏的一级分类和二级分类
			if ($currentId) {
				$currentGame = \App\Models\GameList::find($currentId);
				if ($currentGame) {
					$currentCategoryId = $currentGame->category_id ?? '';
					$currentChildId = $currentGame->child_id ?? 0;
					$currentChangguan = $currentGame->changguan ?? 0;
					
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
					
					// 编辑模式下，获取场馆选项
					$venueOptions = [];
					if ($currentCategoryId) {
						$venues = \App\Models\GameList::where('category_id', $currentCategoryId)
							->where(function($query) {
								$query->whereNull('child_id')
									  ->orWhere('child_id', 0);
							})
							->orderBy('order_by')
							->orderBy('id')
							->get();
						foreach ($venues as $venue) {
							$venueOptions[$venue->id] = $venue->name . ' (' . $venue->platform_name . ')';
						}
					}
					
					$form->select('child_id', '二级分类')
						->options($childOptions)
						->default($currentChildId)
						->help('选择二级分类（可选，不选择则属于一级分类）')
						->loads('changguan', $venueApiUrl);
					
					// 场馆选择（当选择了二级分类时显示）
					$form->select('changguan', '所属场馆')
						->options($venueOptions)
						->default($currentChangguan)
						->help('选择所属场馆（仅在选择二级分类时需要选择）');
				} else {
					// 新建模式，不设置 options，由 loads() 动态加载
					$form->select('child_id', '二级分类')
						->options([])
						->help('选择二级分类（可选，不选择则属于一级分类）')
						->loads('changguan', $venueApiUrl);
					
					$form->select('changguan', '所属场馆')
						->options([])
						->help('选择所属场馆（仅在选择二级分类时需要选择）');
				}
			} else {
				// 新建模式，不设置 options，由 loads() 动态加载
				$form->select('child_id', '二级分类')
					->options([])
					->help('选择二级分类（可选，不选择则属于一级分类）')
					->loads('changguan', $venueApiUrl);
				
				$form->select('changguan', '所属场馆')
					->options([])
					->help('选择所属场馆（仅在选择二级分类时需要选择）');
			}
			
			// 游戏标签选择
			$tagOptions = \App\Models\GameTag::orderBy('order')->orderBy('id')->pluck('name', 'id')->toArray();
			$currentTagId = 0;
			if ($currentId && isset($currentGame)) {
				$currentTagId = $currentGame->tag_id ?? 0;
			}
			$form->select('tag_id', '游戏标签')
				->options([0 => '无标签'] + $tagOptions)
				->default($currentTagId)
				->help('选择游戏标签（可选）');
			
			$form->image('game_title_img', '标题图标')->uniqueName()->help('游戏标题图标');
			$form->image('game_icon', '导航图标')->uniqueName()->help('游戏导航图标');
			
			$form->image('api_logo_img','接口图标')->uniqueName();
            //$form->image('check_yes_img','PC选中状态')->uniqueName();
            //$form->image('check_no_img','PC未选中状态')->uniqueName();
            $form->image('mobile_img','手机端图片')->uniqueName();
			$form->image('app_img','电脑端图片')->uniqueName();
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
