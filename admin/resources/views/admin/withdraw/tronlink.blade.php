@if(isset($row) && $row->card_id == 0 && $row->state == 1)
<div class="tronlink-transfer-container" style="margin-top: 15px; padding: 20px; background: #f8f9fa; border-radius: 5px; text-align: center;">
    <h5 style="margin-bottom: 15px;"><b>TronLink USDT 转账</b></h5>
    <p style="margin-bottom: 8px;">收款地址：<code id="withdraw-address" style="font-size: 14px;">{{ $row->usdt_address }}</code></p>
    <p style="margin-bottom: 15px;">转账金额：<code id="withdraw-amount" style="font-size: 16px; color: #e74c3c; font-weight: bold;">{{ round($row->real_money / ($row->usdt_rate ?: 7), 2) }}</code> USDT</p>

    <div style="margin-bottom: 15px;">
        <button type="button" class="btn btn-primary" id="tronlink-transfer-btn" onclick="initTronLinkTransfer()">
            <i class="fa fa-send"></i> 转账并通过
        </button>
        <span id="tronlink-status" style="margin-left: 10px;"></span>
    </div>

    <hr style="margin: 20px 0; border-top: 1px dashed #ccc;">

    <div style="margin-top: 15px;">
        <p style="margin-bottom: 10px; color: #666; font-size: 13px;">如果已在其他钱包完成转账，请输入交易 Hash：</p>
        <div style="display: inline-flex; align-items: center; gap: 10px;">
            <input type="text" id="manual-tx-hash" class="form-control" placeholder="请输入交易 Hash" style="width: 400px; display: inline-block;">
            <button type="button" class="btn btn-success" id="manual-transfer-btn" onclick="manualConfirmTransfer()">
                <i class="fa fa-check"></i> 已手动转账通过
            </button>
        </div>
        <span id="manual-status" style="display: block; margin-top: 10px;"></span>
    </div>
</div>

<script>
const USDT_CONTRACT = "TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t";
const WITHDRAW_ORDER_ID = {{ $row->id }};
const CONFIRM_URL = "{{ admin_url('withdraw/confirm-transfer') }}";

// 防重复转账标记
let isTransferring = false;
let transferCompleted = false;

async function waitForTronLink(maxWait = 5000) {
    const start = Date.now();
    while (Date.now() - start < maxWait) {
        if (window.tronWeb && window.tronWeb.ready) return true;
        if (window.tronLink && window.tronLink.ready) return true;
        await new Promise(resolve => setTimeout(resolve, 200));
    }
    return false;
}

async function initTronLinkTransfer() {
    const statusEl = document.getElementById("tronlink-status");
    const btn = document.getElementById("tronlink-transfer-btn");

    // 防重复转账检查
    if (transferCompleted) {
        Dcat.warning("该订单已转账完成，请勿重复操作");
        return;
    }
    if (isTransferring) {
        Dcat.warning("正在处理中，请勿重复点击");
        return;
    }
    isTransferring = true;

    btn.disabled = true;
    statusEl.textContent = "正在检测 TronLink...";

    await waitForTronLink();

    if (!window.tronWeb && !window.tronLink) {
        isTransferring = false;
        btn.disabled = false;
        Dcat.error("请先安装 TronLink 浏览器插件");
        statusEl.innerHTML = "<a href=\"https://www.tronlink.org/\" target=\"_blank\">点击下载 TronLink</a>";
        return;
    }

    let tronWeb = window.tronWeb;
    if (!tronWeb && window.tronLink) {
        tronWeb = window.tronLink.tronWeb;
    }

    if (!tronWeb || !tronWeb.ready) {
        isTransferring = false;
        btn.disabled = false;
        Dcat.warning("请先在 TronLink 中登录钱包，然后点击插件图标授权此网站");
        statusEl.textContent = "请点击右上角 TronLink 图标登录并授权";
        return;
    }

    const toAddress = document.getElementById("withdraw-address").textContent.trim();
    const amount = parseFloat(document.getElementById("withdraw-amount").textContent.trim());

    if (!toAddress || !amount) {
        isTransferring = false;
        btn.disabled = false;
        Dcat.error("获取转账信息失败");
        return;
    }

    try {
        btn.innerHTML = "<i class=\"fa fa-spinner fa-spin\"></i> 处理中...";
        statusEl.textContent = "正在唤起 TronLink...";

        const contract = await tronWeb.contract().at(USDT_CONTRACT);
        const amountInSun = Math.floor(amount * 1e6);

        statusEl.textContent = "请在 TronLink 中确认交易...";

        const tx = await contract.transfer(toAddress, amountInSun).send({
            feeLimit: 30000000,
            shouldPollResponse: false
        });

        statusEl.textContent = "交易已提交，等待确认...";
        await updateOrderStatus(tx);

    } catch (error) {
        isTransferring = false;
        btn.disabled = false;
        btn.innerHTML = "<i class=\"fa fa-send\"></i> 转账并通过";

        if (error.message && error.message.includes("cancel")) {
            Dcat.warning("用户取消了交易");
            statusEl.textContent = "交易已取消";
        } else {
            Dcat.error("转账失败: " + (error.message || "未知错误"));
            statusEl.textContent = "转账失败";
            console.error("TronLink transfer error:", error);
        }
    }
}

// 手动输入 Hash 确认转账
async function manualConfirmTransfer() {
    const txHashInput = document.getElementById("manual-tx-hash");
    const statusEl = document.getElementById("manual-status");
    const btn = document.getElementById("manual-transfer-btn");
    const txHash = txHashInput.value.trim();

    // 防重复检查
    if (transferCompleted) {
        Dcat.warning("该订单已转账完成，请勿重复操作");
        return;
    }
    if (isTransferring) {
        Dcat.warning("正在处理中，请勿重复点击");
        return;
    }

    // 验证 Hash 格式
    if (!txHash) {
        Dcat.warning("请输入交易 Hash");
        txHashInput.focus();
        return;
    }

    // TRON 交易 Hash 通常是 64 位十六进制字符
    if (!/^[a-fA-F0-9]{64}$/.test(txHash)) {
        Dcat.warning("交易 Hash 格式不正确，应为 64 位十六进制字符");
        txHashInput.focus();
        return;
    }

    isTransferring = true;
    btn.disabled = true;
    btn.innerHTML = "<i class=\"fa fa-spinner fa-spin\"></i> 处理中...";
    statusEl.textContent = "正在验证并更新订单...";

    await updateOrderStatus(txHash, true);
}

async function updateOrderStatus(txHash, isManual = false) {
    const statusEl = document.getElementById(isManual ? "manual-status" : "tronlink-status");
    const btn = document.getElementById(isManual ? "manual-transfer-btn" : "tronlink-transfer-btn");
    const otherBtn = document.getElementById(isManual ? "tronlink-transfer-btn" : "manual-transfer-btn");

    try {
        const response = await fetch(CONFIRM_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": Dcat.token,
            },
            body: JSON.stringify({
                id: WITHDRAW_ORDER_ID,
                tx_hash: txHash
            })
        });

        const result = await response.json();

        if (result.status) {
            // 转账成功，标记为已完成，防止重复操作
            transferCompleted = true;
            isTransferring = false;
            Dcat.success("订单已完成");
            statusEl.innerHTML = "<span style=\"color: green;\">✓ 订单已通过</span>";
            btn.innerHTML = "<i class=\"fa fa-check\"></i> 已完成";
            btn.classList.remove("btn-primary", "btn-success");
            btn.classList.add("btn-secondary");
            btn.disabled = true;

            // 禁用另一个按钮
            if (otherBtn) {
                otherBtn.disabled = true;
                otherBtn.classList.remove("btn-primary", "btn-success");
                otherBtn.classList.add("btn-secondary");
            }

            setTimeout(() => { window.location.reload(); }, 2000);
        } else {
            isTransferring = false;
            Dcat.error(result.message || "更新订单状态失败");
            statusEl.innerHTML = "<span style=\"color: red;\">" + (result.message || "更新失败") + "</span>";
            btn.disabled = false;
            btn.innerHTML = isManual
                ? "<i class=\"fa fa-check\"></i> 已手动转账通过"
                : "<i class=\"fa fa-send\"></i> 转账并通过";
        }
    } catch (error) {
        isTransferring = false;
        Dcat.error("请求失败: " + error.message);
        statusEl.innerHTML = "<span style=\"color: red;\">请求失败，请重试</span>";
        btn.disabled = false;
        btn.innerHTML = isManual
            ? "<i class=\"fa fa-check\"></i> 已手动转账通过"
            : "<i class=\"fa fa-send\"></i> 转账并通过";
        console.error("Update order error:", error);
    }
}
</script>
@endif
