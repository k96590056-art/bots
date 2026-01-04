<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Withdraw;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Admin;

class WithdrawController extends AdminController
{
    protected $title = '提现审核';

    protected function grid()
    {
        Admin::script(<<<JS
            $('.copyClick').click(function(){
                var text = $(this).children('.copyValue');
                text.unbind();
                text.select();
                document.execCommand("copy");
                Dcat.success('复制成功');
            });
            window.passWithdraw = function(id) {
                if (!confirm('确认通过此提现申请？')) return;
                $.post('/admin/withdraws/' + id + '/pass', {_token: Dcat.token}, function(r) {
                    if (r.status) { Dcat.success(r.message); Dcat.reload(); }
                    else { Dcat.error(r.message); }
                });
            };
            window.refuseWithdraw = function(id) {
                if (!confirm('确认拒绝此提现申请？')) return;
                $.post('/admin/withdraws/' + id + '/refuse', {_token: Dcat.token}, function(r) {
                    if (r.status) { Dcat.success(r.message); Dcat.reload(); }
                    else { Dcat.error(r.message); }
                });
            };
JS
        );
        return Grid::make(new Withdraw(['card_data','user_data']), function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id')->sortable();
            $grid->column('user_data.username','用户名')->view('admin.field.user_username');
            $grid->column('card_data.bank_owner','姓名/协议')->display(function ($value) {
                if (in_array($this->type, [2, 3])) {
                    return $this->usdt_address ?: '-';
                }
                return $value ?: '-';
            });
            $grid->column('amount','提款金额');
            $grid->column('type','提款方式')->using([0 => '未记录',1 => '银行卡',2 => 'USDT-TRC20',3 => 'USDT-ERC20',4 => 'EBpay', 67 => '客服代扣']);
            $grid->column('usdt_rate','汇率');
            $grid->column('cash_fee');
            $grid->column('real_money','实际提款');
            $grid->column('state')->using([1 => '待审核',2 => '已完成',3 => '已拒绝',4 => '存在错误'])->label([
                1 => 'warning',
                2 => 'success',
                3 => 'danger',
                4 => 'danger'
            ]);
            $grid->column('created_at');
            $grid->disableActions();
            $grid->disableCreateButton();
            $grid->column('操作')->display(function () {
                $id = $this->id;
                $html = '<div style="text-align:center;">';
                $html .= '<a href="' . admin_url("withdraws/{$id}") . '" class="btn btn-sm btn-primary" style="margin:2px;">查看</a>';
                if ($this->state == 1 || $this->state == 4) {
                    $html .= '<button type="button" class="btn btn-sm btn-success" style="margin:2px;" onclick="passWithdraw(' . $id . ')">通过</button>';
                    $html .= '<button type="button" class="btn btn-sm btn-danger" style="margin:2px;" onclick="refuseWithdraw(' . $id . ')">拒绝</button>';
                }
                $html .= '</div>';
                return $html;
            })->style('min-width:180px;');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('user_data.username','用户名');
                $filter->between('created_at', '日期')->date();
            });
        });
    }

    public function pass($id)
    {
        $withdraw = \App\Models\Withdraw::find($id);
        if (!$withdraw) {
            return response()->json(['status' => false, 'message' => '订单不存在']);
        }
        if ($withdraw->state != 1 && $withdraw->state != 4) {
            return response()->json(['status' => false, 'message' => '订单状态异常']);
        }
        $withdraw->state = 2;
        $withdraw->info = '管理员审核通过';
        $withdraw->save();
        return response()->json(['status' => true, 'message' => '审核通过']);
    }

    public function refuse($id)
    {
        $withdraw = \App\Models\Withdraw::find($id);
        if (!$withdraw) {
            return response()->json(['status' => false, 'message' => '订单不存在']);
        }
        if ($withdraw->state != 1 && $withdraw->state != 4) {
            return response()->json(['status' => false, 'message' => '订单状态异常']);
        }
        $user = \App\Models\User::find($withdraw->user_id);
        if ($user) {
            $user->money = bcadd($user->money, $withdraw->amount, 2);
            $user->save();

            // 发送Telegram通知
            if ($user->telegram_id) {
                try {
                    $telegramBot = new \App\Services\TelegramBotService();
                    $text = "❌ <b>提现申请被拒绝</b>\n\n";
                    $text .= "━━━━━━━━━━━━━━━━━━━━\n";
                    $text .= "📋 订单号：<code>{$withdraw->order_no}</code>\n";
                    $text .= "💰 提现金额：<b>{$withdraw->amount}</b> 元\n";
                    $text .= "💵 已退回余额：<b>{$withdraw->amount}</b> 元\n";
                    $text .= "━━━━━━━━━━━━━━━━━━━━\n\n";
                    $text .= "如有疑问请联系客服。";
                    $telegramBot->sendMessage($user->telegram_id, $text, ['parse_mode' => 'HTML']);
                } catch (\Exception $e) {
                    \Log::error('发送提现拒绝通知失败', ['error' => $e->getMessage()]);
                }
            }
        }
        $withdraw->state = 3;
        $withdraw->info = '管理员拒绝';
        $withdraw->save();
        return response()->json(['status' => true, 'message' => '已拒绝']);
    }

    protected function detail($id)
    {
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
        return Show::make($id, new Withdraw(['card_data','user_data']), function (Show $show) {
            $show->field('id');
            $show->field('order_no')->view('admin.field.copy_content');
            $show->field('user_data.username','用户名')->view('admin.field.copy_content');
            $model = $show->model();
            if ($model->card_id == 0) {
                $show->field('usdt_address', 'USDT钱包地址')->view('admin.field.copy_content');
                $show->field('usdt_network', '网络类型');
            } else {
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
            if ($model->card_id == 0 && $model->state == 1) {
                $show->html(view('admin.withdraw.tronlink', ['row' => $model])->render());
            }
        });
    }

    public function confirmTransfer($id)
    {
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
        $withdraw->state = 2;
        $withdraw->info = 'TronLink转账成功，交易哈希：' . $txHash;
        $withdraw->save();
        return response()->json(['status' => true, 'message' => '订单已完成']);
    }

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
