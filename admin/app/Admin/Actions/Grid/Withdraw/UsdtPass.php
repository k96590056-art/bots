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
        $networkType = $withdraw->type == 2 ? 'TRC20' : 'ERC20';

        // 根据类型添加对应的钱包脚本
        if ($withdraw->type == 2) {
            $this->addTronLinkScript();
            $btnClass = 'tronlink-pass-btn';
            $btnText = 'TRC20转账';
        } else {
            $this->addMetaMaskScript();
            $btnClass = 'metamask-pass-btn';
            $btnText = 'ERC20转账';
        }

        return <<<HTML
<a href="javascript:void(0)" class="btn btn-sm btn-primary {$btnClass}"
   data-id="{$id}"
   data-address="{$address}"
   data-amount="{$usdtAmount}"
   data-network="{$networkType}"
   data-confirm-url="{$confirmUrl}">
   <i class="feather icon-send"></i> {$btnText}
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
            btn.prop('disabled', false).html('<i class="feather icon-send"></i> TRC20转账');
            Swal.fire({
                title: '未检测到支持 TRON 的钱包',
                html: '<div style="text-align:left;font-size:14px;">' +
                    '<p style="margin-bottom:15px;color:#666;">请安装以下任一钱包插件：</p>' +
                    '<div style="background:#e8f5e9;padding:12px;border-radius:8px;margin-bottom:12px;">' +
                    '<p style="margin:0 0 8px 0;color:#2e7d32;font-weight:bold;">⭐ 推荐：OKX Wallet（一个插件支持所有链）</p>' +
                    '<p style="margin:0;color:#666;font-size:12px;">同时支持 TRC20 和 ERC20，无需安装多个插件</p>' +
                    '<a href="https://www.okx.com/zh-hans/web3" target="_blank" class="btn btn-success btn-sm" style="margin-top:10px;">下载 OKX Wallet</a>' +
                    '</div>' +
                    '<div style="background:#f5f5f5;padding:12px;border-radius:8px;">' +
                    '<p style="margin:0 0 8px 0;font-weight:bold;">其他选择：</p>' +
                    '<p style="margin:0 0 5px 0;"><a href="https://www.tronlink.org/" target="_blank">TronLink</a> - TRON 官方钱包（仅支持 TRC20）</p>' +
                    '<p style="margin:0;"><a href="https://www.tokenpocket.pro/" target="_blank">TokenPocket</a> - 多链钱包</p>' +
                    '</div>' +
                    '</div>',
                icon: 'warning',
                confirmButtonText: '我知道了',
                confirmButtonColor: '#3085d6'
            });
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
                // 后端更新失败，显示交易哈希供手动处理
                Swal.fire({
                    title: '转账已完成，但更新订单失败',
                    html: '<p>请保存以下交易哈希，在订单详情中手动填写：</p>' +
                          '<p style="word-break:break-all;background:#f5f5f5;padding:10px;border-radius:4px;"><code>' + tx + '</code></p>' +
                          '<p style="color:#dc3545;margin-top:10px;">错误：' + (result.message || '未知错误') + '</p>',
                    icon: 'warning'
                });
                btn.prop('disabled', false).html('<i class="feather icon-send"></i> TRC20转账');
            }
        } catch (error) {
            btn.prop('disabled', false).html('<i class="feather icon-send"></i> TRC20转账');

            var errorMsg = error.message || '未知错误';
            if (errorMsg.includes('cancel') || errorMsg.includes('Cancel')) {
                Dcat.warning('交易已取消');
            } else if (errorMsg.includes('balance') || errorMsg.includes('insufficient')) {
                Dcat.error('钱包 USDT 余额不足');
            } else if (errorMsg.includes('bandwidth') || errorMsg.includes('energy')) {
                Dcat.error('钱包 TRX 不足（需要支付手续费）');
            } else {
                Dcat.error('转账失败: ' + errorMsg);
                console.error('TronLink error:', error);
            }
        }
    });
}
JS
        );
    }

    protected function addMetaMaskScript()
    {
        Admin::script(<<<JS
// ERC20 USDT转账脚本（支持MetaMask/OKX/TokenPocket等ETH钱包）
if (!window.metaMaskPassInitialized) {
    window.metaMaskPassInitialized = true;

    // ERC20 USDT 合约地址 (以太坊主网)
    const ERC20_USDT_CONTRACT = '0xdAC17F958D2ee523a2206206994597C13D831ec7';
    // 以太坊主网 Chain ID
    const ETH_MAINNET_CHAIN_ID = '0x1';

    // 获取 ETH provider（支持多钱包共存情况）
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

    $(document).on('click', '.metamask-pass-btn', async function(e) {
        e.preventDefault();
        const btn = $(this);
        const orderId = btn.data('id');
        const toAddress = btn.data('address');
        const amount = parseFloat(btn.data('amount'));
        const confirmUrl = btn.data('confirm-url');

        // 弹出确认框
        const confirmed = await Dcat.confirm('ERC20 USDT转账确认',
            '<div style="text-align:left;padding:10px;">' +
            '<p><b>收款地址：</b></p><p style="word-break:break-all;background:#f5f5f5;padding:8px;border-radius:4px;">' + toAddress + '</p>' +
            '<p style="margin-top:10px;"><b>转账金额：</b><span style="color:#e74c3c;font-size:18px;">' + amount + ' USDT</span></p>' +
            '<p style="margin-top:10px;color:#f39c12;"><b>⚠️ 网络：</b>以太坊主网 (ERC20)</p>' +
            '<hr><p style="color:#666;font-size:12px;">点击确定将唤起 MetaMask 钱包进行转账</p></div>'
        );

        if (!confirmed) return;

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> 检测钱包...');

        await waitForEthWallet();

        const provider = getEthereumProvider();
        if (!provider) {
            btn.prop('disabled', false).html('<i class="feather icon-send"></i> ERC20转账');
            Swal.fire({
                title: '未检测到支持 ETH 的钱包',
                html: '<div style="text-align:left;font-size:14px;">' +
                    '<p style="margin-bottom:15px;color:#666;">请安装以下任一钱包插件：</p>' +
                    '<div style="background:#e8f5e9;padding:12px;border-radius:8px;margin-bottom:12px;">' +
                    '<p style="margin:0 0 8px 0;color:#2e7d32;font-weight:bold;">⭐ 推荐：OKX Wallet（一个插件支持所有链）</p>' +
                    '<p style="margin:0;color:#666;font-size:12px;">同时支持 TRC20 和 ERC20，无需安装多个插件</p>' +
                    '<a href="https://www.okx.com/zh-hans/web3" target="_blank" class="btn btn-success btn-sm" style="margin-top:10px;">下载 OKX Wallet</a>' +
                    '</div>' +
                    '<div style="background:#f5f5f5;padding:12px;border-radius:8px;">' +
                    '<p style="margin:0 0 8px 0;font-weight:bold;">其他选择：</p>' +
                    '<p style="margin:0 0 5px 0;"><a href="https://metamask.io/download/" target="_blank">MetaMask</a> - 以太坊官方推荐钱包（仅支持 ERC20）</p>' +
                    '<p style="margin:0;"><a href="https://www.tokenpocket.pro/" target="_blank">TokenPocket</a> - 多链钱包</p>' +
                    '</div>' +
                    '</div>',
                icon: 'warning',
                confirmButtonText: '我知道了',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        try {
            btn.html('<i class="fa fa-spinner fa-spin"></i> 连接钱包...');

            // 请求连接钱包（使用获取到的 provider）
            const accounts = await provider.request({ method: 'eth_requestAccounts' });
            if (!accounts || accounts.length === 0) {
                Dcat.warning('请先在钱包中授权此网站');
                btn.prop('disabled', false).html('<i class="feather icon-send"></i> ERC20转账');
                return;
            }

            // 检查网络是否为以太坊主网
            const chainId = await provider.request({ method: 'eth_chainId' });
            if (chainId !== ETH_MAINNET_CHAIN_ID) {
                Dcat.warning('正在切换到以太坊主网...');
                try {
                    await provider.request({
                        method: 'wallet_switchEthereumChain',
                        params: [{ chainId: ETH_MAINNET_CHAIN_ID }],
                    });
                } catch (switchError) {
                    Dcat.error('切换网络失败，请手动切换到以太坊主网');
                    btn.prop('disabled', false).html('<i class="feather icon-send"></i> ERC20转账');
                    return;
                }
            }

            btn.html('<i class="fa fa-spinner fa-spin"></i> 唤起钱包...');

            // ERC20 transfer 方法的 ABI 编码
            // transfer(address,uint256) 的函数签名: 0xa9059cbb
            const amountHex = (BigInt(Math.floor(amount * 1e6))).toString(16).padStart(64, '0');
            const toAddressHex = toAddress.toLowerCase().replace('0x', '').padStart(64, '0');
            const data = '0xa9059cbb' + toAddressHex + amountHex;

            btn.html('<i class="fa fa-spinner fa-spin"></i> 请在钱包确认...');

            const txHash = await provider.request({
                method: 'eth_sendTransaction',
                params: [{
                    from: accounts[0],
                    to: ERC20_USDT_CONTRACT,
                    data: data,
                    gas: '0x186A0', // 100000 gas limit
                }],
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
                    tx_hash: txHash
                })
            });

            const result = await response.json();

            if (result.status) {
                Dcat.success('转账成功，订单已完成');
                btn.removeClass('btn-primary').addClass('btn-success')
                   .html('<i class="feather icon-check"></i> 已完成');
                setTimeout(() => location.reload(), 1500);
            } else {
                // 后端更新失败，显示交易哈希供手动处理
                Swal.fire({
                    title: '转账已完成，但更新订单失败',
                    html: '<p>请保存以下交易哈希，在订单详情中手动填写：</p>' +
                          '<p style="word-break:break-all;background:#f5f5f5;padding:10px;border-radius:4px;"><code>' + txHash + '</code></p>' +
                          '<p style="color:#dc3545;margin-top:10px;">错误：' + (result.message || '未知错误') + '</p>',
                    icon: 'warning'
                });
                btn.prop('disabled', false).html('<i class="feather icon-send"></i> ERC20转账');
            }
        } catch (error) {
            btn.prop('disabled', false).html('<i class="feather icon-send"></i> ERC20转账');

            var errorMsg = error.message || '未知错误';
            if (error.code === 4001 || errorMsg.includes('cancel') || errorMsg.includes('Cancel')) {
                Dcat.warning('交易已取消');
            } else if (errorMsg.includes('insufficient funds') || errorMsg.includes('balance')) {
                Dcat.error('钱包余额不足（ETH 或 USDT）');
            } else if (errorMsg.includes('gas')) {
                Dcat.error('ETH 余额不足以支付 Gas 费用');
            } else {
                Dcat.error('转账失败: ' + errorMsg);
                console.error('ETH wallet error:', error);
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
