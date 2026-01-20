<?php

namespace App\Admin\Actions\Grid\Agent;

use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;
use Dcat\Admin\Widgets\Modal;
use App\Admin\Forms\AgentRecharge;

class Recharge extends RowAction
{
    /**
     * @return string
     */
    protected $title = '充值';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function render()
    {
        $form = AgentRecharge::make()->payload(['id' => $this->getKey()]);

        return Modal::make()
            ->lg()
            ->title('代理充值')
            ->body($form)
            ->button('<i class="fa fa-money"></i> 充值');
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
       // return ['你确定要删除此行内容吗？', '弹窗内容'];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
