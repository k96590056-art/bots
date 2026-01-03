@if(isset($row) && $row->card_id == 0 && $row->state == 1)
<div class="tronlink-transfer-container" style="margin-top: 15px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
    <h5 style="margin-bottom: 10px;"><b>TronLink USDT 转账</b></h5>
    <p>收款地址：<code id="withdraw-address">{{ $row->usdt_address }}</code></p>
    <p>转账金额：<code id="withdraw-amount">{{ round($row->real_money / ($row->usdt_rate ?: 7), 2) }}</code> USDT</p>
    <button type="button" class="btn btn-primary" id="tronlink-transfer-btn" onclick="initTronLinkTransfer()">
        <i class="fa fa-send"></i> 转账并通过
    </button>
    <span id="tronlink-status" style="margin-left: 10px;"></span>
</div>

<script>
// USDT TRC20 合约地址
const USDT_CONTRACT = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t';
const WITHDRAW_ORDER_ID = {{ $row->id }};

async function initTronLinkTransfer() {
    const statusEl = document.getElementById('tronlink-status');
    const btn = document.getElementById('tronlink-transfer-btn');

    // 检查 TronLink 是否安装
    if (typeof window.tronWeb === 'undefined') {
        Dcat.error('请先安装 TronLink 浏览器插件');
        statusEl.innerHTML = '<a href="https://www.tronlink.org/" target="_blank">点击下载 TronLink</a>';
        return;
    }

    // 检查 TronLink 是否登录
    if (!window.tronWeb.ready) {
        Dcat.warning('请先登录 TronLink 钱包');
        statusEl.textContent = '请在 TronLink 中登录钱包';
        return;
    }

    const toAddress = document.getElementById('withdraw-address').textContent.trim();
    const amount = parseFloat(document.getElementById('withdraw-amount').textContent.trim());

    if (!toAddress || !amount) {
        Dcat.error('获取转账信息失败');
        return;
    }

    try {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> 处理中...';
        statusEl.textContent = '正在唤起 TronLink...';

        // 获取合约实例
        const contract = await window.tronWeb.contract().at(USDT_CONTRACT);

        // 转换金额为最小单位（USDT 有 6 位小数）
        const amountInSun = Math.floor(amount * 1e6);

        statusEl.textContent = '请在 TronLink 中确认交易...';

        // 发起转账
        const tx = await contract.transfer(toAddress, amountInSun).send({
            feeLimit: 30000000,
            shouldPollResponse: false
        });

        statusEl.textContent = '交易已提交，等待确认...';

        // 更新订单状态
        await updateOrderStatus(tx);

    } catch (error) {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-send"></i> 转账并通过';

        if (error.message && error.message.includes('cancel')) {
            Dcat.warning('用户取消了交易');
            statusEl.textContent = '交易已取消';
        } else {
            Dcat.error('转账失败: ' + (error.message || '未知错误'));
            statusEl.textContent = '转账失败';
            console.error('TronLink transfer error:', error);
        }
    }
}

async function updateOrderStatus(txHash) {
    const statusEl = document.getElementById('tronlink-status');
    const btn = document.getElementById('tronlink-transfer-btn');

    try {
        const response = await fetch('{{ admin_url("withdraw/confirm-transfer") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': Dcat.token,
            },
            body: JSON.stringify({
                id: WITHDRAW_ORDER_ID,
                tx_hash: txHash
            })
        });

        const result = await response.json();

        if (result.status) {
            Dcat.success('转账成功，订单已完成');
            statusEl.innerHTML = '<span style="color: green;">✓ 转账成功</span>';
            btn.innerHTML = '<i class="fa fa-check"></i> 已完成';
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');

            // 2秒后刷新页面
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            Dcat.error(result.message || '更新订单状态失败');
            statusEl.textContent = '更新失败，请手动处理';
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-send"></i> 转账并通过';
        }
    } catch (error) {
        Dcat.error('请求失败: ' + error.message);
        statusEl.textContent = '请求失败，请手动处理';
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-send"></i> 转账并通过';
        console.error('Update order error:', error);
    }
}
</script>
@endif
