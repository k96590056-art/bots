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
        $adminUrl = rtrim(admin_url('/'), '/') . '/';
        Admin::script(<<<JS
            // 管理后台URL前缀
            const ADMIN_URL = '{$adminUrl}';

            $('.copyClick').click(function(){
                var text = $(this).children('.copyValue');
                text.unbind();
                text.select();
                document.execCommand("copy");
                Dcat.success('复制成功');
            });
            // TronLink USDT 转账相关常量
            const USDT_CONTRACT = "TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t";

            // 记录正在处理中的订单，防止重复转账
            const processingOrders = new Set();

            // 获取可用的 tronWeb 对象
            function getTronWeb() {
                let tronWeb = window.tronWeb;
                if (!tronWeb && window.tronLink) {
                    tronWeb = window.tronLink.tronWeb;
                }
                return tronWeb;
            }

            // 检查钱包是否已解锁并连接
            function isWalletReady() {
                let tronWeb = getTronWeb();
                return tronWeb && tronWeb.ready && tronWeb.defaultAddress && tronWeb.defaultAddress.base58;
            }

            // 显示解锁钱包指引
            function showUnlockGuide(orderId, toAddress, amount, realMoney, usdtRate) {
                Swal.fire({
                    title: '请先解锁 TronLink 钱包',
                    html: '<div style="padding:20px;">' +
                          '<div style="background:#fff3cd;border:1px solid #ffc107;border-radius:8px;padding:15px;margin-bottom:20px;">' +
                          '<p style="margin:0;color:#856404;font-size:15px;"><b>检测到钱包未解锁</b></p>' +
                          '</div>' +
                          '<div style="text-align:left;background:#f8f9fa;padding:20px;border-radius:8px;">' +
                          '<p style="margin:0 0 15px;font-size:16px;color:#333;"><b>请按以下步骤操作：</b></p>' +
                          '<p style="margin:12px 0;font-size:15px;color:#555;"><span style="background:#2196F3;color:#fff;padding:2px 8px;border-radius:50%;margin-right:10px;">1</span>点击浏览器右上角的 <b style="color:#2196F3;">TronLink 图标</b></p>' +
                          '<p style="margin:12px 0;font-size:15px;color:#555;"><span style="background:#4CAF50;color:#fff;padding:2px 8px;border-radius:50%;margin-right:10px;">2</span>输入密码 <b style="color:#4CAF50;">解锁钱包</b></p>' +
                          '<p style="margin:12px 0;font-size:15px;color:#555;"><span style="background:#FF9800;color:#fff;padding:2px 8px;border-radius:50%;margin-right:10px;">3</span>解锁后点击下方 <b style="color:#FF9800;">"已解锁，继续"</b></p>' +
                          '</div>' +
                          '</div>',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '已解锁，继续',
                    cancelButtonText: '取消',
                    width: '500px',
                    allowOutsideClick: false
                }).then((r) => {
                    if (r.isConfirmed || r.value) {
                        // 再次检查钱包状态
                        if (isWalletReady()) {
                            // 已解锁，执行转账
                            doTransfer(orderId, toAddress, amount, realMoney, usdtRate);
                        } else {
                            // 仍未解锁，再次提示
                            Dcat.error("钱包仍未解锁，请先解锁钱包");
                            setTimeout(function() {
                                showUnlockGuide(orderId, toAddress, amount, realMoney, usdtRate);
                            }, 500);
                        }
                    }
                });
            }

            // 执行转账
            async function doTransfer(orderId, toAddress, amount, realMoney, usdtRate) {
                let tronWeb = getTronWeb();
                let fromAddress = tronWeb.defaultAddress.base58;

                // 显示转账确认
                Swal.fire({
                    title: '',
                    html: '<div style="padding:10px 0;">' +
                          '<div style="text-align:center;margin-bottom:20px;">' +
                          '<div style="width:60px;height:60px;background:linear-gradient(135deg,#1e88e5,#42a5f5);border-radius:50%;margin:0 auto 15px;display:flex;align-items:center;justify-content:center;">' +
                          '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>' +
                          '</div>' +
                          '<h3 style="margin:0;font-size:20px;color:#333;">USDT 转账确认</h3>' +
                          '</div>' +
                          '<div style="background:#f8fafc;border-radius:12px;padding:20px;margin-bottom:15px;">' +
                          '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:12px;border-bottom:1px dashed #e0e0e0;">' +
                          '<span style="color:#666;font-size:13px;">发送地址</span>' +
                          '<span style="color:#333;font-size:12px;font-family:monospace;">' + fromAddress.substring(0,8) + '...' + fromAddress.substring(fromAddress.length-6) + '</span>' +
                          '</div>' +
                          '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:12px;border-bottom:1px dashed #e0e0e0;">' +
                          '<span style="color:#666;font-size:13px;">收款地址</span>' +
                          '<span style="color:#333;font-size:12px;font-family:monospace;">' + toAddress.substring(0,8) + '...' + toAddress.substring(toAddress.length-6) + '</span>' +
                          '</div>' +
                          '<div style="background:#e3f2fd;border-radius:8px;padding:12px;margin-bottom:12px;">' +
                          '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">' +
                          '<span style="color:#666;font-size:13px;">实际提款金额</span>' +
                          '<span style="color:#333;font-size:14px;font-weight:600;">' + realMoney + ' 元</span>' +
                          '</div>' +
                          '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">' +
                          '<span style="color:#666;font-size:13px;">汇率</span>' +
                          '<span style="color:#333;font-size:14px;">' + usdtRate + '</span>' +
                          '</div>' +
                          '<div style="color:#1565c0;font-size:12px;text-align:right;">USDT = ' + realMoney + ' ÷ ' + usdtRate + ' ≈ ' + amount + '</div>' +
                          '</div>' +
                          '<div style="text-align:center;padding-top:5px;">' +
                          '<span style="color:#666;font-size:13px;display:block;margin-bottom:8px;">转账金额</span>' +
                          '<span style="font-size:32px;font-weight:700;color:#1e88e5;">' + amount + '</span>' +
                          '<span style="font-size:16px;color:#666;margin-left:5px;">USDT</span>' +
                          '</div>' +
                          '</div>' +
                          '</div>',
                    showCancelButton: true,
                    confirmButtonColor: '#1e88e5',
                    cancelButtonColor: '#e0e0e0',
                    confirmButtonText: '立即转账',
                    cancelButtonText: '取消',
                    width: '400px',
                    customClass: {
                        cancelButton: 'swal-cancel-dark'
                    }
                }).then((r) => {
                    if (r.isConfirmed || r.value) {
                        executeTransfer(orderId, toAddress, amount, tronWeb);
                    }
                });
            }

            // TronLink 转账入口函数
            function tronLinkTransfer(orderId, toAddress, amount, realMoney, usdtRate) {
                console.log("=== TronLink转账 ===");
                console.log("orderId:", orderId, "toAddress:", toAddress, "amount:", amount, "realMoney:", realMoney, "usdtRate:", usdtRate);

                // 防止重复转账：检查订单是否正在处理中
                if (processingOrders.has(orderId)) {
                    Dcat.warning('该订单正在处理中，请勿重复操作');
                    return;
                }

                // 检查是否安装了 TronLink
                if (!window.tronLink && !window.tronWeb) {
                    Swal.fire({
                        title: '未检测到 TronLink',
                        html: '<div style="padding:15px;">' +
                              '<p>请先安装 TronLink 浏览器插件</p>' +
                              '<p style="margin-top:15px;"><a href="https://www.tronlink.org/" target="_blank" style="color:#007bff;">点击此处下载 TronLink</a></p>' +
                              '</div>',
                        type: 'error',
                        confirmButtonText: '我已安装，刷新页面'
                    }).then(() => {
                        location.reload();
                    });
                    return;
                }

                // 检查钱包是否已解锁
                if (!isWalletReady()) {
                    console.log("钱包未解锁，显示解锁指引");
                    showUnlockGuide(orderId, toAddress, amount, realMoney, usdtRate);
                    return;
                }

                // 钱包已解锁，直接显示转账确认
                console.log("钱包已解锁，显示转账确认");
                doTransfer(orderId, toAddress, amount, realMoney, usdtRate);
            }

            // 执行转账 - 调用合约
            async function executeTransfer(orderId, toAddress, amount, tronWeb) {
                // 标记订单正在处理中
                processingOrders.add(orderId);

                // 显示加载中
                Swal.fire({
                    title: '正在唤起 TronLink',
                    html: '<div style="padding:20px;"><p>请在 TronLink 弹窗中确认交易...</p></div>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onBeforeOpen: () => { Swal.showLoading(); }
                });

                try {
                    console.log("获取合约对象...");
                    const contract = await tronWeb.contract().at(USDT_CONTRACT);
                    console.log("合约对象:", contract);

                    const amountInSun = Math.floor(amount * 1e6);
                    console.log("转账金额(Sun):", amountInSun);
                    console.log("收款地址:", toAddress);

                    // 调用 transfer 方法 - 这会触发 TronLink 弹窗
                    console.log("调用 transfer 方法...");
                    const tx = await contract.transfer(toAddress, amountInSun).send({
                        feeLimit: 30000000,
                        shouldPollResponse: false
                    });

                    console.log("交易hash:", tx);
                    Swal.close();

                    // 转账成功，更新订单状态
                    Swal.fire({
                        title: '交易已提交',
                        html: '<div style="padding:10px;"><p>正在更新订单状态...</p><p style="font-size:12px;word-break:break-all;">TxHash: ' + tx + '</p></div>',
                        type: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });

                    $.ajax({
                        url: ADMIN_URL + 'withdraw/confirm-transfer',
                        type: 'POST',
                        data: {
                            _token: Dcat.token,
                            id: orderId,
                            tx_hash: tx
                        },
                        success: function(r) {
                            // 移除处理中标记
                            processingOrders.delete(orderId);
                            if (r.status) {
                                Swal.fire({
                                    title: '转账成功',
                                    text: '订单已完成',
                                    type: 'success'
                                }).then(() => {
                                    Dcat.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: '更新失败',
                                    text: r.message || '更新订单状态失败，请手动处理',
                                    type: 'error'
                                });
                            }
                        },
                        error: function() {
                            // 移除处理中标记
                            processingOrders.delete(orderId);
                            Swal.fire({
                                title: '请求失败',
                                text: '网络错误，请手动处理订单',
                                type: 'error'
                            });
                        }
                    });

                } catch (error) {
                    console.error("转账错误:", error);
                    // 移除处理中标记
                    processingOrders.delete(orderId);
                    Swal.close();

                    let errorMsg = error.message || '未知错误';

                    if (errorMsg.includes('cancel') || errorMsg.includes('Cancel')) {
                        Swal.fire({
                            title: '交易已取消',
                            text: '您取消了本次转账',
                            type: 'warning'
                        });
                    } else {
                        Swal.fire({
                            title: '转账失败',
                            html: '<div style="padding:10px;"><p>' + errorMsg + '</p></div>',
                            type: 'error'
                        });
                    }
                }
            }

            window.passWithdraw = function(id, type, usdtAddress, realMoney, usdtRate) {
                // 如果是 TRC20 提现 (type=2)，需要通过 TronLink 转账
                if (type == 2 && usdtAddress) {
                    var rate = usdtRate || 7;
                    var usdtAmount = (realMoney / rate).toFixed(2);
                    tronLinkTransfer(id, usdtAddress, parseFloat(usdtAmount), realMoney, rate);
                } else {
                    // 其他类型，直接通过
                    Swal.fire({
                        title: '确认通过',
                        text: '确认通过此提现申请？',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '确认',
                        cancelButtonText: '取消'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: ADMIN_URL + 'withdraws/' + id + '/pass',
                                type: 'POST',
                                data: {_token: Dcat.token},
                                success: function(r) {
                                    if (r.status) { Dcat.success(r.message); Dcat.reload(); }
                                    else { Dcat.error(r.message); }
                                }
                            });
                        }
                    });
                }
            };
            window.refuseWithdraw = function(id) {
                Swal.fire({
                    title: '确认拒绝',
                    text: '确认拒绝此提现申请？金额将退回用户余额。',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '确认拒绝',
                    cancelButtonText: '取消'
                }).then((result) => {
                    if (result.isConfirmed || result.value) {
                        $.ajax({
                            url: ADMIN_URL + 'withdraws/' + id + '/refuse',
                            type: 'POST',
                            data: {_token: Dcat.token},
                            success: function(r) {
                                if (r.status) { Dcat.success(r.message); Dcat.reload(); }
                                else { Dcat.error(r.message); }
                            }
                        });
                    }
                });
            };

            // 批量通过队列
            var batchTransferQueue = [];
            var batchTransferIndex = 0;

            // 页面加载后立即隐藏 checkbox 列（多次尝试确保生效）
            function hideCheckboxColumn() {
                $('th:first-child, td:first-child').each(function() {
                    if ($(this).find('input[type="checkbox"]').length > 0) {
                        $(this).hide();
                    }
                });
                $('.column-__row_selector__').hide();
                $('[class*="row_selector"]').hide();
                $('input.grid-row-checkbox, input.grid-select-all-checkbox').closest('th, td').hide();
            }

            // 立即执行一次
            hideCheckboxColumn();

            // 延迟执行确保表格渲染完成
            setTimeout(hideCheckboxColumn, 100);
            setTimeout(hideCheckboxColumn, 300);
            setTimeout(hideCheckboxColumn, 500);

            // 操作列表头居中
            $('<style>th:last-child { text-align: center !important; }</style>').appendTo('head');

            // 更新选中数量显示
            function updateSelectedCount() {
                var count = $('table tbody input[type="checkbox"]:checked:not(:disabled)').length;
                if (count > 0) {
                    $('#batch-selected-count').text('已选中 ' + count + ' 条').show();
                } else {
                    $('#batch-selected-count').hide();
                }
            }

            // 进入批量操作模式
            $('#enter-batch-mode-btn').click(function() {
                // 显示表头 checkbox 列
                $('table thead th:first-child').each(function() {
                    if ($(this).find('input[type="checkbox"]').length > 0) {
                        $(this).show();
                    }
                });
                $('th.column-__row_selector__, th[class*="row_selector"]').show();
                $('input.grid-select-all-checkbox').closest('th').show();

                var pendingCount = 0;

                // 只显示待审核(state=1)订单的 checkbox，隐藏其他状态的
                $('table tbody tr').each(function() {
                    var row = $(this);
                    // 查找状态列中是否有"待审核"文本
                    var isPending = row.find('span.badge, span.label, span[class*="bg-"]').filter(function() {
                        return $(this).text().trim() === '待审核';
                    }).length > 0;

                    // 找到 checkbox 所在的单元格（第一个td或包含checkbox的td）
                    var checkboxCell = row.find('td:first-child');
                    if (checkboxCell.find('input[type="checkbox"]').length === 0) {
                        checkboxCell = row.find('td.column-__row_selector__, td[class*="row_selector"]');
                    }
                    if (checkboxCell.length === 0) {
                        checkboxCell = row.find('input[type="checkbox"]').closest('td');
                    }

                    var checkbox = row.find('input[type="checkbox"]');

                    if (!isPending) {
                        // 不是待审核状态，显示 checkbox 单元格但隐藏 checkbox（保持td存在以维持表格布局）
                        checkboxCell.show();
                        checkbox.hide().prop('disabled', true).data('pending', false);
                    } else {
                        // 待审核状态，显示 checkbox 单元格和 checkbox
                        checkboxCell.show();
                        checkbox.show().prop('disabled', false).data('pending', true);
                        pendingCount++;
                    }
                });

                // 绑定 checkbox change 事件更新计数
                $('table tbody input[type="checkbox"]').off('change.batch').on('change.batch', updateSelectedCount);

                // 自定义全选逻辑：只选中待审核的订单
                $('table thead input[type="checkbox"]').off('change.batch').on('change.batch', function() {
                    var isChecked = $(this).prop('checked');
                    $('table tbody input[type="checkbox"]').each(function() {
                        if ($(this).data('pending')) {
                            $(this).prop('checked', isChecked);
                        }
                    });
                    updateSelectedCount();
                });

                // 切换按钮显示，隐藏刷新和筛选按钮
                $(this).hide();
                $('.grid-refresh, .grid-filter-btn, button[data-action="filter"], .filter-btn, [data-toggle="filter"], .btn-filter, .dropdown-filter, a[data-toggle="collapse"]').hide();
                // Dcat Admin 筛选按钮
                $('button:contains("筛选"), a:contains("筛选")').hide();

                // 禁用每行的通过和拒绝按钮
                $('table tbody tr').find('button').each(function() {
                    var btnText = $(this).text().trim();
                    if (btnText === '通过' || btnText === '拒绝') {
                        $(this).prop('disabled', true).addClass('batch-disabled').css('opacity', '0.5');
                    }
                });

                $('#batch-pass-btn, #batch-refuse-btn, #exit-batch-mode-btn').show();
                updateSelectedCount();
                Dcat.info('已进入批量操作模式，当前页有 ' + pendingCount + ' 条待审核订单');
            });

            // 退出批量操作模式
            $('#exit-batch-mode-btn').click(function() {
                // 取消所有选中，恢复 checkbox 状态和显示
                $('table input[type="checkbox"]').prop('checked', false).prop('disabled', false).removeData('pending').show();

                // 隐藏 checkbox 列
                hideCheckboxColumn();

                // 移除事件绑定
                $('table input[type="checkbox"]').off('change.batch');

                // 切换按钮显示，恢复刷新和筛选按钮
                $(this).hide();
                $('#batch-pass-btn, #batch-refuse-btn, #batch-selected-count').hide();
                $('.grid-refresh, .grid-filter-btn, button[data-action="filter"], .filter-btn, [data-toggle="filter"], .btn-filter, .dropdown-filter, a[data-toggle="collapse"]').show();
                // Dcat Admin 筛选按钮
                $('button:contains("筛选"), a:contains("筛选")').show();

                // 恢复每行的通过和拒绝按钮
                $('table tbody tr').find('button.batch-disabled').each(function() {
                    $(this).prop('disabled', false).removeClass('batch-disabled').css('opacity', '');
                });

                $('#enter-batch-mode-btn').show();
                Dcat.info('已退出批量操作模式');
            });

            // 手动获取选中的订单ID
            function getSelectedIds() {
                var ids = [];
                $('table tbody input[type="checkbox"]:checked').each(function() {
                    // 尝试多种方式获取ID
                    var val = $(this).val();
                    var dataId = $(this).data('id');
                    var rowId = $(this).closest('tr').data('key') || $(this).closest('tr').data('id');
                    var name = $(this).attr('name');

                    console.log('checkbox信息:', {val: val, dataId: dataId, rowId: rowId, name: name});

                    // 优先使用 data-id，其次是 tr 的 data-key，然后是 value
                    var id = dataId || rowId || (val && val !== 'on' && val !== '' ? val : null);

                    // 如果 name 是 _row_selector_[] 格式，尝试从 value 获取
                    if (!id && name && name.indexOf('_row_selector_') >= 0 && val) {
                        id = val;
                    }

                    if (id) {
                        ids.push(id);
                    }
                });
                console.log('最终获取的IDs:', ids);
                return ids;
            }

            // 批量通过按钮点击
            $('#batch-pass-btn').click(function() {
                var ids = getSelectedIds();
                console.log('选中的ID:', ids);
                if (!ids || ids.length === 0) {
                    Dcat.warning('请先选择要通过的订单');
                    return;
                }

                // 获取选中订单的数据
                $.ajax({
                    url: ADMIN_URL + 'withdraws/batch-info',
                    type: 'POST',
                    data: {
                        _token: Dcat.token,
                        ids: ids
                    },
                    success: function(res) {
                    if (!res.status) {
                        Dcat.error(res.message);
                        return;
                    }

                    var orders = res.data;
                    var skipped = res.skipped || 0;
                    var trc20Orders = orders.filter(o => o.type == 2);
                    var otherOrders = orders.filter(o => o.type != 2);

                    var html = '<div style="text-align:left;padding:10px;">' +
                               '<p>可处理待审核订单：<b>' + orders.length + '</b> 个</p>';

                    if (skipped > 0) {
                        html += '<p style="color:#999;">⊘ 已跳过非待审核：<b>' + skipped + '</b> 个</p>';
                    }
                    if (otherOrders.length > 0) {
                        html += '<p style="color:#28a745;">✓ 普通提现：<b>' + otherOrders.length + '</b> 个（直接通过）</p>';
                    }
                    if (trc20Orders.length > 0) {
                        html += '<p style="color:#1e88e5;">⟐ TRC20提现：<b>' + trc20Orders.length + '</b> 个（需逐个转账）</p>';
                    }
                    html += '</div>';

                    Swal.fire({
                        title: '批量通过确认',
                        html: html,
                        type: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '确认批量通过',
                        cancelButtonText: '取消'
                    }).then((result) => {
                        if (result.isConfirmed || result.value) {
                            // 先处理普通提现
                            if (otherOrders.length > 0) {
                                var otherIds = otherOrders.map(o => o.id);
                                $.ajax({
                                    url: ADMIN_URL + 'withdraws/batch-pass',
                                    type: 'POST',
                                    data: {
                                        _token: Dcat.token,
                                        ids: otherIds
                                    },
                                    success: function(r) {
                                        if (r.status) {
                                            Dcat.success(r.message);
                                        } else {
                                            Dcat.error(r.message);
                                        }
                                    }
                                });
                            }

                            // 处理 TRC20 提现（需要逐个转账）
                            if (trc20Orders.length > 0) {
                                batchTransferQueue = trc20Orders;
                                batchTransferIndex = 0;
                                processBatchTRC20Transfer();
                            } else {
                                setTimeout(() => Dcat.reload(), 1000);
                            }
                        }
                    });
                }});
            });

            // 处理批量 TRC20 转账
            function processBatchTRC20Transfer() {
                if (batchTransferIndex >= batchTransferQueue.length) {
                    Swal.fire({
                        title: '批量转账完成',
                        text: '共处理 ' + batchTransferQueue.length + ' 个TRC20订单',
                        type: 'success'
                    }).then(() => {
                        Dcat.reload();
                    });
                    return;
                }

                var order = batchTransferQueue[batchTransferIndex];
                var progress = (batchTransferIndex + 1) + '/' + batchTransferQueue.length;

                Swal.fire({
                    title: 'TRC20 批量转账 (' + progress + ')',
                    html: '<div style="padding:15px;text-align:left;">' +
                          '<div style="margin-bottom:12px;">' +
                          '<span style="color:#666;">收款地址：</span>' +
                          '<code style="font-size:11px;">' + order.usdt_address + '</code>' +
                          '</div>' +
                          '<div style="background:#e3f2fd;border-radius:8px;padding:12px;margin-bottom:12px;">' +
                          '<div style="display:flex;justify-content:space-between;margin-bottom:6px;">' +
                          '<span style="color:#666;font-size:13px;">实际提款金额</span>' +
                          '<span style="font-weight:600;">' + order.real_money + ' 元</span>' +
                          '</div>' +
                          '<div style="display:flex;justify-content:space-between;margin-bottom:6px;">' +
                          '<span style="color:#666;font-size:13px;">汇率</span>' +
                          '<span>' + order.usdt_rate + '</span>' +
                          '</div>' +
                          '<div style="color:#1565c0;font-size:12px;text-align:right;">' +
                          'USDT = ' + order.real_money + ' ÷ ' + order.usdt_rate + ' ≈ ' + order.usdt_amount +
                          '</div>' +
                          '</div>' +
                          '<div style="text-align:center;">' +
                          '<span style="font-size:24px;font-weight:700;color:#1e88e5;">' + order.usdt_amount + '</span>' +
                          '<span style="color:#666;margin-left:5px;">USDT</span>' +
                          '</div>' +
                          '</div>',
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#1e88e5',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '转账此订单',
                    cancelButtonText: '跳过剩余',
                    width: '420px'
                }).then((result) => {
                    if (result.isConfirmed || result.value) {
                        // 执行转账
                        executeBatchTransfer(order, function() {
                            batchTransferIndex++;
                            processBatchTRC20Transfer();
                        });
                    } else {
                        // 跳过剩余
                        Dcat.reload();
                    }
                });
            }

            // 执行单个批量转账
            async function executeBatchTransfer(order, callback) {
                if (!isWalletReady()) {
                    Dcat.error('请先解锁 TronLink 钱包');
                    showUnlockGuide(order.id, order.usdt_address, order.usdt_amount, order.real_money, order.usdt_rate);
                    return;
                }

                let tronWeb = getTronWeb();

                Swal.fire({
                    title: '正在转账...',
                    html: '<p>请在 TronLink 中确认</p>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onBeforeOpen: () => { Swal.showLoading(); }
                });

                try {
                    const contract = await tronWeb.contract().at(USDT_CONTRACT);
                    const amountInSun = Math.floor(order.usdt_amount * 1e6);
                    const tx = await contract.transfer(order.usdt_address, amountInSun).send({
                        feeLimit: 30000000,
                        shouldPollResponse: false
                    });

                    // 更新订单状态
                    $.ajax({
                        url: ADMIN_URL + 'withdraw/confirm-transfer',
                        type: 'POST',
                        data: {
                            _token: Dcat.token,
                            id: order.id,
                            tx_hash: tx
                        },
                        success: function(r) {
                            if (r.status) {
                                Dcat.success('订单 #' + order.id + ' 转账成功');
                            }
                            callback();
                        }
                    });
                } catch (error) {
                    if (error.message && error.message.includes('cancel')) {
                        Dcat.warning('已取消转账');
                    } else {
                        Dcat.error('转账失败: ' + error.message);
                    }
                    callback();
                }
            }

            // 批量拒绝按钮点击
            $('#batch-refuse-btn').click(function() {
                var ids = getSelectedIds();
                console.log('选中的ID:', ids);
                if (!ids || ids.length === 0) {
                    Dcat.warning('请先选择要拒绝的订单');
                    return;
                }

                Swal.fire({
                    title: '批量拒绝确认',
                    html: '<p>确定要拒绝选中的 <b>' + ids.length + '</b> 个订单吗？</p><p style="color:#dc3545;">金额将退回用户余额</p>',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '确认批量拒绝',
                    cancelButtonText: '取消'
                }).then((result) => {
                    if (result.isConfirmed || result.value) {
                        $.ajax({
                            url: ADMIN_URL + 'withdraws/batch-refuse',
                            type: 'POST',
                            data: {
                                _token: Dcat.token,
                                ids: ids
                            },
                            success: function(r) {
                                if (r.status) {
                                    Dcat.success(r.message);
                                    Dcat.reload();
                                } else {
                                    Dcat.error(r.message);
                                }
                            }
                        });
                    }
                });
            });
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
                $type = $this->type;
                $usdtAddress = $this->usdt_address ?: '';
                $realMoney = $this->real_money ?: 0;
                $usdtRate = $this->usdt_rate ?: 7;
                $html = '<div style="text-align:center;">';
                $html .= '<a href="' . admin_url("withdraws/{$id}") . '" class="btn btn-sm btn-primary" style="margin:2px;">查看</a>';
                if ($this->state == 1 || $this->state == 4) {
                    $html .= '<button type="button" class="btn btn-sm btn-success" style="margin:2px;" onclick="passWithdraw(' . $id . ', ' . $type . ', \'' . $usdtAddress . '\', ' . $realMoney . ', ' . $usdtRate . ')">通过</button>';
                    $html .= '<button type="button" class="btn btn-sm btn-danger" style="margin:2px;" onclick="refuseWithdraw(' . $id . ')">拒绝</button>';
                }
                $html .= '</div>';
                return $html;
            })->style('min-width:180px;text-align:center;');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('user_data.username','用户名');
                $filter->between('created_at', '日期')->date();
            });

            // 启用行选择器（默认通过 JS 隐藏）
            $grid->showRowSelector();

            // 添加CSS确保初始状态隐藏，防止闪烁
            Admin::style('.column-__row_selector__ { display: none; }');

            // 批量操作工具栏
            $grid->tools(function (Grid\Tools $tools) {
                $tools->append('<button class="btn btn-outline-primary btn-sm" id="enter-batch-mode-btn" style="margin-right:5px;"><i class="feather icon-list"></i> 批量操作</button>');
                $tools->append('<button class="btn btn-success btn-sm" id="batch-pass-btn" style="margin-right:5px;display:none;"><i class="feather icon-check"></i> 批量通过</button>');
                $tools->append('<button class="btn btn-danger btn-sm" id="batch-refuse-btn" style="margin-right:5px;display:none;"><i class="feather icon-x"></i> 批量拒绝</button>');
                $tools->append('<span id="batch-selected-count" style="display:none;margin-right:10px;color:#1e88e5;font-weight:bold;line-height:30px;"></span>');
                $tools->append('<button class="btn btn-secondary btn-sm" id="exit-batch-mode-btn" style="display:none;"><i class="feather icon-x-circle"></i> 退出批量</button>');
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
        // TRC20 提现不能直接通过，必须通过 TronLink 转账
        if ($withdraw->type == 2) {
            return response()->json(['status' => false, 'message' => 'TRC20提现请使用TronLink转账']);
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
            // 使用 increment 原子操作避免并发问题
            \App\Models\User::where('id', $user->id)->increment('balance', $withdraw->amount);
            $user->refresh();

            // 发送Telegram通知
            if ($user->telegram_id) {
                try {
                    $telegramBot = new \App\Services\TelegramBotService();
                    $text = "❌ <b>提现申请被拒绝</b>\n\n";
                    $text .= "━━━━━━━━━━━━\n";
                    $text .= "📋 订单号：<code>{$withdraw->order_no}</code>\n";
                    $text .= "💰 提现金额：<b>{$withdraw->amount}</b> 元\n";
                    $text .= "💵 已退回余额：<b>{$withdraw->amount}</b> 元\n";
                    $text .= "━━━━━━━━━━━━\n\n";
                    $text .= "如有疑问请联系客服。";
                    $inlineKeyboard = [
                        [['text' => '🏠 返回主菜单', 'callback_data' => 'back_main']]
                    ];
                    $telegramBot->sendMessageWithInlineKeyboard($user->telegram_id, $text, $inlineKeyboard);
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

    public function confirmTransfer($id = null)
    {
        $id = $id ?: request('id');
        $txHash = request('tx_hash');
        if (!$id || !$txHash) {
            return response()->json(['status' => false, 'message' => '参数错误']);
        }

        // 检查 tx_hash 是否已被使用（防止重复提交相同交易）
        $existingWithTxHash = \App\Models\Withdraw::where('info', 'like', '%' . $txHash . '%')
            ->where('state', 2)
            ->where('id', '!=', $id)
            ->first();
        if ($existingWithTxHash) {
            return response()->json(['status' => false, 'message' => '该交易哈希已被使用，请勿重复提交']);
        }

        // 使用事务和行锁，防止并发重复处理
        try {
            \DB::beginTransaction();

            // 使用 FOR UPDATE 锁定该行，防止并发修改
            $withdraw = \App\Models\Withdraw::where('id', $id)->lockForUpdate()->first();

            if (!$withdraw) {
                \DB::rollBack();
                return response()->json(['status' => false, 'message' => '订单不存在']);
            }

            // 再次检查状态（锁定后检查，确保状态正确）
            if ($withdraw->state != 1 && $withdraw->state != 4) {
                \DB::rollBack();
                return response()->json(['status' => false, 'message' => '订单已处理，请勿重复操作']);
            }

            $withdraw->state = 2;
            $withdraw->info = 'TronLink转账成功，交易哈希：' . $txHash;
            $withdraw->save();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('确认转账失败', ['error' => $e->getMessage(), 'id' => $id]);
            return response()->json(['status' => false, 'message' => '操作失败，请重试']);
        }

        // 发送Telegram通知
        $user = \App\Models\User::find($withdraw->user_id);
        if ($user && $user->telegram_id) {
            try {
                $telegramBot = new \App\Services\TelegramBotService();
                $usdtAmount = round($withdraw->real_money / ($withdraw->usdt_rate ?: 7), 2);
                $text = "✅ <b>提现已完成</b>\n\n";
                $text .= "━━━━━━━━━━━━━━━━━━━━\n";
                $text .= "📋 订单号：<code>{$withdraw->order_no}</code>\n";
                $text .= "💰 提现金额：<b>{$withdraw->amount}</b> 元\n";
                $text .= "💵 到账金额：<b>{$usdtAmount}</b> USDT\n";
                $text .= "🔗 交易哈希：<code>{$txHash}</code>\n";
                $text .= "━━━━━━━━━━━━━━━━━━━━\n\n";
                $text .= "感谢您的使用！";
                $telegramBot->sendMessage($user->telegram_id, $text, ['parse_mode' => 'HTML']);
            } catch (\Exception $e) {
                \Log::error('发送提现成功通知失败', ['error' => $e->getMessage()]);
            }
        }

        return response()->json(['status' => true, 'message' => '订单已完成']);
    }

    /**
     * 获取批量订单信息
     * 兜底校验：只返回待审核(state=1)的订单
     */
    public function batchInfo()
    {
        $ids = request('ids', []);
        if (empty($ids)) {
            return response()->json(['status' => false, 'message' => '请选择订单']);
        }

        // 查询所有选中的订单
        $allWithdraws = \App\Models\Withdraw::whereIn('id', $ids)->get();
        $totalCount = count($ids);
        $foundCount = $allWithdraws->count();

        // 只处理待审核(state=1)的订单
        $withdraws = $allWithdraws->where('state', 1);
        $validCount = $withdraws->count();
        $skippedCount = $foundCount - $validCount;

        if ($withdraws->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => '没有可处理的待审核订单',
                'detail' => "选中 {$totalCount} 个，其中 {$skippedCount} 个已处理或状态异常"
            ]);
        }

        $data = $withdraws->map(function ($item) {
            return [
                'id' => $item->id,
                'type' => $item->type,
                'amount' => $item->amount,
                'real_money' => $item->real_money,
                'usdt_address' => $item->usdt_address,
                'usdt_rate' => $item->usdt_rate ?: 7,
                'usdt_amount' => round($item->real_money / ($item->usdt_rate ?: 7), 2),
            ];
        })->values();

        return response()->json([
            'status' => true,
            'data' => $data,
            'skipped' => $skippedCount
        ]);
    }

    /**
     * 批量通过（普通提现）
     * 兜底校验：只处理待审核(state=1)且非TRC20的订单
     */
    public function batchPass()
    {
        $ids = request('ids', []);
        if (empty($ids)) {
            return response()->json(['status' => false, 'message' => '请选择订单']);
        }

        $totalCount = count($ids);
        $passedCount = 0;
        $skippedCount = 0;
        $trc20Count = 0;

        try {
            \DB::beginTransaction();

            // 只处理待审核(state=1)且非TRC20的订单
            $withdraws = \App\Models\Withdraw::whereIn('id', $ids)
                ->where('state', 1)
                ->lockForUpdate()
                ->get();

            foreach ($withdraws as $withdraw) {
                // TRC20 订单不能批量通过，需要单独转账
                if ($withdraw->type == 2) {
                    $trc20Count++;
                    continue;
                }

                $withdraw->state = 2;
                $withdraw->info = '管理员批量审核通过';
                $withdraw->save();
                $passedCount++;
            }

            $skippedCount = $totalCount - $withdraws->count();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('批量通过失败', ['error' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => '操作失败，请重试']);
        }

        $message = "批量通过成功：{$passedCount} 个";
        if ($skippedCount > 0) {
            $message .= "，跳过已处理：{$skippedCount} 个";
        }
        if ($trc20Count > 0) {
            $message .= "，TRC20需单独转账：{$trc20Count} 个";
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'count' => $passedCount,
            'skipped' => $skippedCount,
            'trc20' => $trc20Count
        ]);
    }

    /**
     * 批量拒绝
     * 兜底校验：只处理待审核(state=1)的订单
     */
    public function batchRefuse()
    {
        $ids = request('ids', []);
        if (empty($ids)) {
            return response()->json(['status' => false, 'message' => '请选择订单']);
        }

        $totalCount = count($ids);
        $refusedCount = 0;
        $skippedCount = 0;

        try {
            \DB::beginTransaction();

            // 只处理待审核(state=1)的订单
            $withdraws = \App\Models\Withdraw::whereIn('id', $ids)
                ->where('state', 1)
                ->lockForUpdate()
                ->get();

            foreach ($withdraws as $withdraw) {
                // 退款给用户 - 使用 increment 原子操作
                \App\Models\User::where('id', $withdraw->user_id)->increment('balance', $withdraw->amount);

                $withdraw->state = 3;
                $withdraw->info = '管理员批量拒绝';
                $withdraw->save();
                $refusedCount++;
            }

            $skippedCount = $totalCount - $withdraws->count();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('批量拒绝失败', ['error' => $e->getMessage()]);
            return response()->json(['status' => false, 'message' => '操作失败，请重试']);
        }

        $message = "批量拒绝成功：{$refusedCount} 个，已退款";
        if ($skippedCount > 0) {
            $message .= "，跳过已处理：{$skippedCount} 个";
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'count' => $refusedCount,
            'skipped' => $skippedCount
        ]);
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
