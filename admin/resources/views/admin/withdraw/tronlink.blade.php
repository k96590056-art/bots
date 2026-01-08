@if(isset($row) && $row->card_id == 0 && $row->state == 1)
@php
    $isErc20 = $row->type == 3;
    $walletName = $isErc20 ? 'ETH钱包' : 'TRON钱包';
    $networkName = $isErc20 ? 'ERC20' : 'TRC20';
    $btnColor = $isErc20 ? '#f39c12' : '#007bff';
@endphp
<div class="tronlink-transfer-container" style="margin-top: 15px; padding: 20px; background: #f8f9fa; border-radius: 5px; text-align: center;">
    <h5 style="margin-bottom: 15px;"><b>{{ $walletName }} USDT 转账 ({{ $networkName }})</b></h5>
    <p style="margin-bottom: 8px;">收款地址：<code id="withdraw-address" style="font-size: 14px;">{{ $row->usdt_address }}</code></p>
    <p style="margin-bottom: 15px;">转账金额：<code id="withdraw-amount" style="font-size: 16px; color: #e74c3c; font-weight: bold;">{{ round($row->real_money / ($row->usdt_rate ?: 7), 2) }}</code> USDT</p>

    <div style="margin-bottom: 15px;">
        <button type="button" class="btn btn-primary" id="wallet-transfer-btn" onclick="initWalletTransfer()" style="background-color: {{ $btnColor }}; border-color: {{ $btnColor }};">
            <i class="fa fa-send"></i> {{ $walletName }} 转账并通过
        </button>
        <span id="wallet-status" style="margin-left: 10px;"></span>
    </div>

    <hr style="margin: 20px 0; border-top: 1px dashed #ccc;">

    <div style="margin-top: 15px;">
        <p style="margin-bottom: 10px; color: #666; font-size: 13px;">如果已在其他钱包完成转账，请输入交易 Hash：</p>
        <div style="display: inline-flex; align-items: center; gap: 10px;">
            <input type="text" id="manual-tx-hash" class="form-control" placeholder="请输入 {{ $networkName }} 交易 Hash" style="width: 400px; display: inline-block;">
            <button type="button" class="btn btn-success" id="manual-transfer-btn" onclick="manualConfirmTransfer()">
                <i class="fa fa-check"></i> 已手动转账通过
            </button>
        </div>
        <span id="manual-status" style="display: block; margin-top: 10px;"></span>
    </div>
</div>

<script>
// TRC20 相关常量
const TRC20_USDT_CONTRACT = "TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t";
// ERC20 相关常量
const ERC20_USDT_CONTRACT = "0xdAC17F958D2ee523a2206206994597C13D831ec7";
const ETH_MAINNET_CHAIN_ID = "0x1";

const WITHDRAW_ORDER_ID = {{ $row->id }};
const WITHDRAW_TYPE = {{ $row->type }};  // 2=TRC20, 3=ERC20
const IS_ERC20 = WITHDRAW_TYPE === 3;
const CONFIRM_URL = "{{ admin_url('withdraw/confirm-transfer') }}";
const WALLET_NAME = IS_ERC20 ? "ETH钱包" : "TRON钱包";

// 防重复转账标记
let isTransferring = false;
let transferCompleted = false;

// ============ TronLink 相关 ============
async function waitForTronLink(maxWait = 5000) {
    const start = Date.now();
    while (Date.now() - start < maxWait) {
        if (window.tronWeb && window.tronWeb.ready) return true;
        if (window.tronLink && window.tronLink.ready) return true;
        await new Promise(resolve => setTimeout(resolve, 200));
    }
    return false;
}

// ============ ETH钱包相关（支持MetaMask/OKX/TokenPocket等） ============
function getEthereumProvider() {
    // 方法1: 检查 providers 数组（多钱包共存时）
    if (window.ethereum && window.ethereum.providers && Array.isArray(window.ethereum.providers)) {
        // 优先找 MetaMask
        const metamask = window.ethereum.providers.find(p => p.isMetaMask && !p.isBraveWallet);
        if (metamask) return metamask;
        // 否则返回第一个可用的 provider
        return window.ethereum.providers[0] || null;
    }
    // 方法2: 直接检查 window.ethereum（单钱包情况，如OKX）
    if (window.ethereum) {
        return window.ethereum;
    }
    return null;
}

async function waitForEthWallet(maxWait = 3000) {
    const start = Date.now();
    while (Date.now() - start < maxWait) {
        if (getEthereumProvider()) return true;
        await new Promise(resolve => setTimeout(resolve, 200));
    }
    return false;
}

// ============ 统一入口 ============
async function initWalletTransfer() {
    if (IS_ERC20) {
        await initMetaMaskTransfer();
    } else {
        await initTronLinkTransfer();
    }
}

async function initTronLinkTransfer() {
    const statusEl = document.getElementById("wallet-status");
    const btn = document.getElementById("wallet-transfer-btn");

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

        const contract = await tronWeb.contract().at(TRC20_USDT_CONTRACT);
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
        btn.innerHTML = "<i class=\"fa fa-send\"></i> " + WALLET_NAME + " 转账并通过";

        var errorMsg = error.message || "未知错误";
        if (errorMsg.includes("cancel") || errorMsg.includes("Cancel")) {
            Dcat.warning("用户取消了交易");
            statusEl.textContent = "交易已取消";
        } else if (errorMsg.includes("balance") || errorMsg.includes("insufficient")) {
            Dcat.error("钱包 USDT 余额不足");
            statusEl.textContent = "USDT 余额不足";
        } else if (errorMsg.includes("bandwidth") || errorMsg.includes("energy")) {
            Dcat.error("钱包 TRX 不足（需要支付手续费）");
            statusEl.textContent = "TRX 余额不足";
        } else {
            Dcat.error("转账失败: " + errorMsg);
            statusEl.textContent = "转账失败";
            console.error("TronLink transfer error:", error);
        }
    }
}

async function initMetaMaskTransfer() {
    const statusEl = document.getElementById("wallet-status");
    const btn = document.getElementById("wallet-transfer-btn");

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
    statusEl.textContent = "正在检测 ETH 钱包...";

    await waitForEthWallet();

    const provider = getEthereumProvider();
    if (!provider) {
        isTransferring = false;
        btn.disabled = false;
        Dcat.error("请先安装支持 ETH 的钱包（如 OKX Wallet、MetaMask）");
        statusEl.innerHTML = "<a href=\"https://www.okx.com/zh-hans/web3\" target=\"_blank\">推荐下载 OKX Wallet</a>";
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
        statusEl.textContent = "正在连接钱包...";

        const accounts = await provider.request({ method: 'eth_requestAccounts' });
        if (!accounts || accounts.length === 0) {
            isTransferring = false;
            btn.disabled = false;
            Dcat.warning("请先在钱包中授权");
            statusEl.textContent = "请在钱包中授权";
            btn.innerHTML = "<i class=\"fa fa-send\"></i> ETH钱包 转账并通过";
            return;
        }

        // 检查网络
        const chainId = await provider.request({ method: 'eth_chainId' });
        if (chainId !== ETH_MAINNET_CHAIN_ID) {
            statusEl.textContent = "切换到以太坊主网...";
            try {
                await provider.request({
                    method: 'wallet_switchEthereumChain',
                    params: [{ chainId: ETH_MAINNET_CHAIN_ID }],
                });
            } catch (switchError) {
                isTransferring = false;
                btn.disabled = false;
                Dcat.error("请手动切换到以太坊主网");
                statusEl.textContent = "请切换到以太坊主网";
                btn.innerHTML = "<i class=\"fa fa-send\"></i> ETH钱包 转账并通过";
                return;
            }
        }

        statusEl.textContent = "请在钱包中确认交易...";

        // ERC20 transfer 编码
        const amountHex = (BigInt(Math.floor(amount * 1e6))).toString(16).padStart(64, '0');
        const toAddressHex = toAddress.toLowerCase().replace('0x', '').padStart(64, '0');
        const data = '0xa9059cbb' + toAddressHex + amountHex;

        const txHash = await provider.request({
            method: 'eth_sendTransaction',
            params: [{
                from: accounts[0],
                to: ERC20_USDT_CONTRACT,
                data: data,
                gas: '0x186A0',
            }],
        });

        statusEl.textContent = "交易已提交，等待确认...";
        await updateOrderStatus(txHash);

    } catch (error) {
        isTransferring = false;
        btn.disabled = false;
        btn.innerHTML = "<i class=\"fa fa-send\"></i> " + WALLET_NAME + " 转账并通过";

        var errorMsg = error.message || "未知错误";
        if (error.code === 4001 || errorMsg.includes("cancel") || errorMsg.includes("Cancel")) {
            Dcat.warning("用户取消了交易");
            statusEl.textContent = "交易已取消";
        } else if (errorMsg.includes("insufficient funds") || errorMsg.includes("balance")) {
            Dcat.error("钱包余额不足（ETH 或 USDT）");
            statusEl.textContent = "余额不足";
        } else if (errorMsg.includes("gas")) {
            Dcat.error("ETH 余额不足以支付 Gas 费用");
            statusEl.textContent = "Gas 费用不足";
        } else {
            Dcat.error("转账失败: " + errorMsg);
            statusEl.textContent = "转账失败";
            console.error("ETH wallet transfer error:", error);
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

    // TRC20: 64位十六进制; ERC20: 0x开头66位
    if (IS_ERC20) {
        if (!/^0x[a-fA-F0-9]{64}$/.test(txHash)) {
            Dcat.warning("ERC20 交易 Hash 格式不正确，应为 0x 开头的 66 位字符");
            txHashInput.focus();
            return;
        }
    } else {
        if (!/^[a-fA-F0-9]{64}$/.test(txHash)) {
            Dcat.warning("TRC20 交易 Hash 格式不正确，应为 64 位十六进制字符");
            txHashInput.focus();
            return;
        }
    }

    isTransferring = true;
    btn.disabled = true;
    btn.innerHTML = "<i class=\"fa fa-spinner fa-spin\"></i> 处理中...";
    statusEl.textContent = "正在验证并更新订单...";

    await updateOrderStatus(txHash, true);
}

async function updateOrderStatus(txHash, isManual = false) {
    const statusEl = document.getElementById(isManual ? "manual-status" : "wallet-status");
    const btn = document.getElementById(isManual ? "manual-transfer-btn" : "wallet-transfer-btn");
    const otherBtn = document.getElementById(isManual ? "wallet-transfer-btn" : "manual-transfer-btn");

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
            // 如果是钱包转账，显示交易哈希供手动处理
            if (!isManual) {
                Swal.fire({
                    title: "转账已完成，但更新订单失败",
                    html: "<p>请复制以下交易哈希，手动填写到下方输入框：</p>" +
                          "<p style=\"word-break:break-all;background:#f5f5f5;padding:10px;border-radius:4px;\"><code>" + txHash + "</code></p>" +
                          "<p style=\"color:#dc3545;margin-top:10px;\">错误：" + (result.message || "未知错误") + "</p>",
                    icon: "warning"
                });
                statusEl.innerHTML = "<span style=\"color: orange;\">请手动填写交易哈希</span>";
            } else {
                Dcat.error(result.message || "更新订单状态失败");
                statusEl.innerHTML = "<span style=\"color: red;\">" + (result.message || "更新失败") + "</span>";
            }
            btn.disabled = false;
            btn.innerHTML = isManual
                ? "<i class=\"fa fa-check\"></i> 已手动转账通过"
                : "<i class=\"fa fa-send\"></i> " + WALLET_NAME + " 转账并通过";
        }
    } catch (error) {
        isTransferring = false;
        // 网络错误时，如果是钱包转账，显示交易哈希
        if (!isManual) {
            Swal.fire({
                title: "网络错误，请手动处理",
                html: "<p>转账已发送，但无法更新订单状态。</p>" +
                      "<p>请复制以下交易哈希，手动填写到下方输入框：</p>" +
                      "<p style=\"word-break:break-all;background:#f5f5f5;padding:10px;border-radius:4px;\"><code>" + txHash + "</code></p>",
                icon: "error"
            });
            statusEl.innerHTML = "<span style=\"color: orange;\">请手动填写交易哈希</span>";
        } else {
            Dcat.error("请求失败: " + error.message);
            statusEl.innerHTML = "<span style=\"color: red;\">请求失败，请重试</span>";
        }
        btn.disabled = false;
        btn.innerHTML = isManual
            ? "<i class=\"fa fa-check\"></i> 已手动转账通过"
            : "<i class=\"fa fa-send\"></i> " + WALLET_NAME + " 转账并通过";
        console.error("Update order error:", error);
    }
}
</script>
@endif
