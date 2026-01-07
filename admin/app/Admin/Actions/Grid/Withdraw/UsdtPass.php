<?php

namespace App\Admin\Actions\Grid\Withdraw;

use App\Models\Withdraw;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Dcat\Admin\Admin;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UsdtPass extends RowAction
{
    protected $title = '<i class="feather icon-check"></i> USDT转账';

    // 不使用默认的Ajax请求
    protected $usingAjax = false;

    public function render()
    {
        $id = $this->getKey();
        $withdraw = Withdraw::find($id);

        if (!$withdraw || $withdraw->state != 1) {
            return '';
        }

        // 只对USDT提现显示此按钮
        if (!in_array($withdraw->type, [2, 3])) {
            return '';
        }

        $usdtAmount = round($withdraw->real_money / ($withdraw->usdt_rate ?: 7), 2);
        $address = $withdraw->usdt_address;
        $confirmUrl = admin_url('withdraw/confirm-transfer');

        // 添加TronLink脚本（只添加一次）
        $this->addTronLinkScript();

        return <<<HTML
<a href="javascript:void(0)" class="btn btn-sm btn-primary tronlink-pass-btn"
   data-id="{$id}"
   data-address="{$address}"
   data-amount="{$usdtAmount}"
   data-confirm-url="{$confirmUrl}">
   <i class="feather icon-send"></i> USDT转账
</a>
HTML;
    }

    protected function addTronLinkScript()
    {
        Admin::script(<<<JS
// TronLink USDT转账脚本
if (!window.tronLinkPassInitialized) {
    window.tronLinkPassInitialized = true;

    const USDT_CONTRACT = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t';

    async function waitForTronLink(maxWait = 3000) {
        const start = Date.now();
        while (Date.now() - start < maxWait) {
            if (window.tronWeb && window.tronWeb.ready) return true;
            if (window.tronLink && window.tronLink.ready) return true;
            await new Promise(resolve => setTimeout(resolve, 200));
        }
        return false;
    }

    $(document).on('click', '.tronlink-pass-btn', async function(e) {
        e.preventDefault();
        const btn = $(this);
        const orderId = btn.data('id');
        const toAddress = btn.data('address');
        const amount = parseFloat(btn.data('amount'));
        const confirmUrl = btn.data('confirm-url');

        // 弹出确认框
        const confirmed = await Dcat.confirm('USDT转账确认',
            '<div style="text-align:left;padding:10px;">' +
            '<p><b>收款地址：</b></p><p style="word-break:break-all;background:#f5f5f5;padding:8px;border-radius:4px;">' + toAddress + '</p>' +
            '<p style="margin-top:10px;"><b>转账金额：</b><span style="color:#e74c3c;font-size:18px;">' + amount + ' USDT</span></p>' +
            '<hr><p style="color:#666;font-size:12px;">点击确定将唤起 TronLink 钱包进行转账</p></div>'
        );

        if (!confirmed) return;

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> 检测钱包...');

        await waitForTronLink();

        if (!window.tronWeb && !window.tronLink) {
            Dcat.error('请先安装 TronLink 浏览器插件');
            btn.prop('disabled', false).html('<i class="feather icon-send"></i> USDT转账');
            window.open('https://www.tronlink.org/', '_blank');
            return;
        }

        let tronWeb = window.tronWeb;
        if (!tronWeb && window.tronLink) {
            tronWeb = window.tronLink.tronWeb;
        }

        if (!tronWeb || !tronWeb.ready) {
            Dcat.warning('请先在 TronLink 中登录钱包并授权此网站');
            btn.prop('disabled', false).html('<i class="feather icon-send"></i> USDT转账');
            return;
        }

        try {
            btn.html('<i class="fa fa-spinner fa-spin"></i> 唤起钱包...');

            const contract = await tronWeb.contract().at(USDT_CONTRACT);
            const amountInSun = Math.floor(amount * 1e6);

            btn.html('<i class="fa fa-spinner fa-spin"></i> 请在钱包确认...');

            const tx = await contract.transfer(toAddress, amountInSun).send({
                feeLimit: 30000000,
                shouldPollResponse: false
            });

            btn.html('<i class="fa fa-spinner fa-spin"></i> 更新订单...');

            // 更新订单状态
            const response = await fetch(confirmUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': Dcat.token,
                },
                body: JSON.stringify({
                    id: orderId,
                    tx_hash: tx
                })
            });

            const result = await response.json();

            if (result.status) {
                Dcat.success('转账成功，订单已完成');
                btn.removeClass('btn-primary').addClass('btn-success')
                   .html('<i class="feather icon-check"></i> 已完成');
                setTimeout(() => location.reload(), 1500);
            } else {
                Dcat.error(result.message || '更新订单失败');
                btn.prop('disabled', false).html('<i class="feather icon-send"></i> USDT转账');
            }
        } catch (error) {
            btn.prop('disabled', false).html('<i class="feather icon-send"></i> USDT转账');

            if (error.message && error.message.includes('cancel')) {
                Dcat.warning('交易已取消');
            } else {
                Dcat.error('转账失败: ' + (error.message || '未知错误'));
                console.error('TronLink error:', error);
            }
        }
    });
}
JS
        );
    }

    public function handle(Request $request)
    {
        // 这个方法不会被调用，因为我们使用了前端JS处理
        return $this->response()->success('操作成功');
    }
}
