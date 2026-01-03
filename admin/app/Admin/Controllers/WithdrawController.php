<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Withdraw;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Admin\Actions\Grid\Withdraw\Pass;
use App\Admin\Actions\Grid\Withdraw\Refuse;
use Dcat\Admin\Admin;

class WithdrawController extends AdminController
{
    protected $title = '提现审核';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        //Admin::js('/admin/js/withdraw_apply.js');
        Admin::script(<<<JS
                $('.copyClick').click(function(){
                    var text = $(this).children('.copyValue');
                    text.unbind();
                    text.select(); // 选中文本
                    document.execCommand("copy"); // 执行浏览器复制命令
                    Dcat.success('复制成功');
                })
JS
            );
        return Grid::make(new Withdraw(with(['card_data','user_data'])), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            //$grid->column('order_no');
            $grid->column('user_data.username','用户名')->view('admin.field.user_username');
            $grid->column('card_data.bank_owner','姓名/协议');
            
            //$grid->column('card_data.bank_no','提款信息');
            
            
            $grid->column('amount','提款金额');
            $grid->column('type','提款方式')->using([0 => '未记录',1 => '银行卡',2 => 'USDT-TRC20',3 => 'USDT-ERC20',4 => 'EBpay', 67 => '客服代扣']);
            $grid->column('usdt_rate','汇率');
            $grid->column('cash_fee');
            $grid->column('real_money','实际提款');
            
            $grid->column('state')->using([1 => '待审核',2 => '已完成',3 => '已拒绝',4 => '存在错误']);
            $grid->column('created_at');

            $grid->disableCreateButton();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('user_data.username','用户名');
                $filter->between('created_at', '日期')->date();
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableEdit();
                $actions->disableDelete();
                if ($actions->row->state == 1 || $actions->row->state == 4) {
                    $actions->append(new Pass());
                    $actions->append(new Refuse());
                }
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
        // 复用 grid() 中的复制 JS
        Admin::script(<<<JS
                $('.copyClick').click(function(){
                    var text = $(this).children('.copyValue');
                    text.unbind();
                    text.select();
                    document.execCommand("copy");
                    Dcat.success('复制成功');
                })
JS
            );
        return Show::make($id, new Withdraw(with(['card_data','user_data'])), function (Show $show) {
            $show->field('id');
            $show->field('order_no')->view('admin.field.copy_content');
            $show->field('user_data.username','用户名')->view('admin.field.copy_content');

            // 根据 card_id 区分银行卡提现和 USDT 提现
            $model = $show->model();
            if ($model->card_id == 0) {
                // USDT 提现：显示 USDT 地址和网络
                $show->field('usdt_address', 'USDT钱包地址')->view('admin.field.copy_content');
                $show->field('usdt_network', '网络类型');
            } else {
                // 银行卡提现：显示银行卡信息
                $show->field('card_id')->view('admin.field.copy_content');
                $show->field('card_data.bank_owner','姓名/协议')->view('admin.field.copy_content');
                $show->field('card_data.bank_no','卡号')->view('admin.field.copy_content');
            }

            $show->field('type','提款方式')->using([0 => '未记录',1 => '银行卡',2 => 'USDT-TRC20', 3 => 'USDT-ERC20']);
            $show->field('amount')->view('admin.field.copy_content');
            $show->field('cash_fee')->view('admin.field.copy_content');
            $show->field('real_money','实际提款')->view('admin.field.copy_content');

            $show->field('info');
            $show->field('bet_amount','打码量');
            $show->field('state')->using([1 => '待审核', 2 => '已完成', 3 => '已拒绝', 4 => '存在错误']);
            $show->field('created_at');
            $show->field('updated_at');

            // USDT 提现且待审核时显示 TronLink 转账按钮
            if ($model->card_id == 0 && $model->state == 1) {
                $show->html(view('admin.withdraw.tronlink', ['row' => $model])->render());
            }
        });
    }

    /**
     * TronLink 转账确认 API
     */
    public function confirmTransfer()
    {
        $id = request('id');
        $txHash = request('tx_hash');

        if (!$id || !$txHash) {
            return response()->json(['status' => false, 'message' => '参数错误']);
        }

        $withdraw = \App\Models\Withdraw::find($id);
        if (!$withdraw) {
            return response()->json(['status' => false, 'message' => '订单不存在']);
        }

        if ($withdraw->state != 1) {
            return response()->json(['status' => false, 'message' => '订单状态异常']);
        }

        // 复用 Pass Action 的逻辑：更新订单状态为已完成
        $withdraw->state = 2;
        $withdraw->info = 'TronLink转账成功，交易哈希：' . $txHash;
        $withdraw->save();

        return response()->json(['status' => true, 'message' => '订单已完成']);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Withdraw(), function (Form $form) {
            $form->display('id');
            $form->text('order_no');
            $form->text('card_id');
            $form->text('user_id');
            $form->text('amount');
            $form->text('cash_fee');
            $form->text('real_money');
            $form->text('info');
            $form->text('state');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
