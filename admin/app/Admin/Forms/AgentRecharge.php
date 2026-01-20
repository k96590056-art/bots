<?php

namespace App\Admin\Forms;

use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Widgets\Form;
use App\User;
use App\Models\UserOperateLog;

class AgentRecharge extends Form implements LazyRenderable
{
    use LazyWidget;
    
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        $id = $this->payload['id'] ?? null;
        $amount = floatval($input['amount'] ?? 0);

        if (!$id) {
            return $this->response()->error('参数错误');
        }

        if (!is_numeric($amount) || $amount <= 0) {
            return $this->response()->error('充值金额必须大于0');
        }

        // 使用数据库事务确保数据一致性
        return \DB::transaction(function () use ($id, $amount) {
            $user = User::find($id);
            if (!$user) {
                return $this->response()->error('代理不存在');
            }

            $before_balance = $user->balance;
            $after_balance = $user->balance + $amount;

            // 更新用户余额
            $user->balance = $after_balance;
            $user->save();

            // 记录操作日志
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
            UserOperateLog::insertLog(
                $user->id,
                7,
                $_SERVER['HTTP_USER_AGENT'] ?? '',
                $ip,
                '未知地区',
                '管理员充值【' . $user->username . '】账户余额，充值金额' . $amount . '，充值前余额' . $before_balance . '，充值后余额' . $after_balance
            );

            return $this->response()->success('充值成功')->refresh();
        });
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('amount', '充值金额')
            ->rules('required|numeric|min:0.01')
            ->required()
            ->help('请输入充值金额，必须大于0');
    }
}
