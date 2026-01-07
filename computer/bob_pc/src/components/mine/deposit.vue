<template>
  <div class="ant-spin-nested-loading">
    <div class="loading" v-if="lodingShow">
      <div class="ant-spin ant-spin-spinning _2PSsJSST">
        <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
      </div>
    </div>
    <div :class="lodingShow ? 'ant-spin-container ant-spin-blur' : 'ant-spin-container'">
      <div class="_2hXp1MkX">
        <div class="_4ICMeQUV">
          <div class="T5pPAuRQ">存款<span>存款金额存入中心钱包</span></div>
          <!-- <span>
        <div class="xAmazytl">存款教程</div>
      </span> -->
        </div>
        <div class="animated fadeIn _340pPwLv">
          <img
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAsCAMAAAAUyMtVAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAIZUExURUxpcf////Dw/+ju+f///////////////////////+ju+f///+f//+ft+efu+ebw+ujz/+bs+ez//+n//+fv/+v1/+/v/+jw/+fv++ru+uft+efv++fu++r0/+3u/+fu+vLy/+z1//Hx/+ft+urx/+nv+efu++nw++fv+eby/+v//+jw++jv++vy/+ft++bt+ufw+ubv++jx+urv+eby/+bu+uju+/X3+ujt+ebu+ufv+uTs+ufu+efu+ubu+e7x9+ju+ebu+N7m8ebs+Obu+ent9Ofu+ujv+unt+8fR4+bu+unw/+bt+eft+uXr9ebt+ebt+NXd7Obt+87Y5+bs+ebt+eXs99ni7ubt+OXr9MnV5+Ts9+fu+ejv+uTs9/j6/Obq8vT3+srU5tnh8NTf7dzm9d3n8+ft+eLp8ufu+t7n8uft+d7n8+Lp89zk8t7n9Nzl8vH0+uDn8tHZ67nG2t3m9MrV5+vv9dbh8Nje69ff7LHA2M/Z6fH0+rnI3crV5q2708rS4rXB17K+1u/y9r/M4NDa6dfg7d3n9L7K38bS5M/Z6cDM4MXQ48jU5brH3Nji8M3X6MrV5sLO4bzI3bbD2bjF2tLd7Nbg78TP4tHb69Te7tPb6dzm87LA17C+1c/a6r3J3c3Y6bTB1/X3+q6706y60sfS5MvW57vH3MrW59rk8bTB2Kq40fL0+Nzi7MPN3rzI3MnR4Zy35/IAAACvdFJOUwAFEWQECAMBBgJbCgtWLjQWOg4MHxkPIVE8K0FLGB1tFBsTdyUvZkVhKQ1EUCdOczZTNzEVPk/3WGpfSI+o0/6uieaAXvxrb0foPyPIoey+k+VJ5uDN2eie/di3uXve/ePv2pr5M9OE9JmvwqLlc97yysVNumbO8ZH8YItg32vx97/T6PuN3/H///////////////////////////////////////////////////7730mlAAAEuUlEQVR42sVVZ1cbVxBFWq1YrcqqS7sqqK0q6oBB9F5NNS0YArjGxr2lVyeHmAgLYZKQWAgMhCKKk1+Y0ZMQENafc8+cs/P2vNmdmXffnaL/C8V5XFxw7xYJBQIeTyAUiYqzC1gJhELwP7BfJCBwcfXETR8OMUIhj8Crm+ZwQiDkDIAP8nCvvD+VSk0oxQRB4BLl/VRqPibBeaJi7s+r+PoHqflUatjE90pUWtMc+PVOvooQFHN8nhBrmTsphDqHVW6zeB7Pp+a3Huk0fDFP9N9is9lY7A9hM2yaH6H8arPhASy2GkKMukxFiC5kI+FX38ycYMQXkrU8zGTGt/qNBsphUkLAuVYSuNJ8LZFIZBIZsERiKuxT1GUS45cmybAr5NCggELXoZNKm3Hg9zO45y7t+Gq8fqbd6Za6KIfciwJQ1+Uy2Y0bisCn1/88i6Y2Ut8+8wircsb0BlZnkaCioU7Vteu/caEp6JZKK2MYFpNWR/waLY7aysOVZQt/cKLJjlVKpSRJhgdpxmyTEOiocaVct76wsL6wDlZ4IozaMWlpRUXA6FNAU72EANUssajZpVO8W3oHlvNH7bHSDp+hi6YYnUkrJgSIflqrh07u7u7v7oPt7iZ3kwj7yf390SA5WK4IUVHGYZbzvTjBEwKbbDrKuJhMLiYXzyEJ70bbpb5I9Nnz2dnZjwDPvxRns5L76cpXp9h5tQOW8wdK9F1R5if0Lr4Tj3+T5V+RifG54/H4anwVrPBEGGgrpVnmxduFPFo1fAlRpJFVO5dzWF1eBVsuYKCtgo6yjTOX8hiD0vEiK2ts+4UbA1UVNEXRLj3pxjCgU8Rj5ouLrNFAyc/cGKoqLQ9FDEYSayspcZKBcpnaIkEBG28QNt5sgJ36ZwPaTgMgpc/+3nu99xoBnII/dCYlN6nPpYSK7v14C3BUf/zrOQyhoiHCqA/rgR8ynVyLo7Y21/aMXOntvT1ev7FyBkPQ1idPf4xG6K4uWhFldNm2ooML1tRe7akbmbrSe7RwsIlwsHlw0AkH993B5lOKZWWMXwf0gIND1MAmay43XO3rGa6bam3dWztBJ1BjemVt7XuFQ2fWlPG9WWog8ukx+62aTy7XNvT11PUevU3n0Qnka365l07/8CT79Rz5EL3LA6Sz3d7c2D8GISNQyTZCZ5bewZfvt7e//bpAb3SBmJChukLa4gw2Q2p36+7VH6f/AnSiC/TsxRL4X5xcIHRFrd0ellIYBsPu4K3+bP23j94fHh525q5obPoYFp+jK5oXAa3FZFV3+1mFK4zZGyGv4ZHW45V0QQQej6f/uY9EoCDuKqXWJrd2y+hBsqS5v3ai725T/dEdkBnIFGRmbmuaBVrwzguZRGmxOqIGPfwEOlY7VmMHIXMZwy3YiZBdkEqxVq72RDoqqyYba2oaJ51hH60o79CTLQWp5BgNmm7ocktVMNiOSV0hGcMCXUv1IMbdIMYccg89M3soQ0BaKQ0YKI/OrIZedBloLrkvKL5Jx1B0OR1h0UDRqP0yVuYpDBSumWLTqB1+v0OtQSPLojGr1WZTYWRx/ESs5JfJTXKbVoKjoci32fjaDwzF05NRqcQ4kR+7YjHys/v/BY0L1gOFlsc0AAAAAElFTkSuQmCC"
            class="_3I4cTIHy"
            alt=""
          />
          <div class="_1bKTdXvU">
            <div class="TNf1HZ2U pc0kVnul" onClick="openGonggao()">
              <marquee direction="left"> 尊敬的会员：极力推荐使用【极速转卡】、【极速取款】，高效的存取款体验，减少银行风控监管，自主完成比在线存款更为高效。提款后请区分接收金额与转账附言备注，核查金额接收、余额变化无误后再点击确认按钮，谨防资金流失！ </marquee>
            </div>
          </div>
        </div>
        <div class="ant-tabs ant-tabs-top CxUrt0Fb _3J-cD19q ant-tabs-line">
          <div role="tablist" tabindex="-1" class="ant-tabs-bar ant-tabs-top-bar" style="">
            <div class="ant-tabs-nav-container">
              <span unselectable="unselectable" class="ant-tabs-tab-prev ant-tabs-tab-btn-disabled">
                <span class="ant-tabs-tab-prev-icon">
                  <span role="img" aria-label="left" class="anticon anticon-left ant-tabs-tab-prev-icon-target">
                    <svg viewbox="64 64 896 896" focusable="false" data-icon="left" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                      <path d="M724 218.3V141c0-6.7-7.7-10.4-12.9-6.3L260.3 486.8a31.86 31.86 0 000 50.3l450.8 352.1c5.3 4.1 12.9.4 12.9-6.3v-77.3c0-4.9-2.3-9.6-6.1-12.6l-360-281 360-281.1c3.8-3 6.1-7.7 6.1-12.6z"></path>
                    </svg>
                  </span>
                </span>
              </span>
              <span unselectable="unselectable" class="ant-tabs-tab-next ant-tabs-tab-btn-disabled">
                <span class="ant-tabs-tab-next-icon">
                  <span role="img" aria-label="right" class="anticon anticon-right ant-tabs-tab-next-icon-target">
                    <svg viewbox="64 64 896 896" focusable="false" data-icon="right" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                      <path d="M765.7 486.8L314.9 134.7A7.97 7.97 0 00302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 000-50.4z"></path>
                    </svg>
                  </span>
                </span>
              </span>
            </div>
          </div>
          <div v-show="tabShow == 0" class="ant-tabs-content ant-tabs-content-animated ant-tabs-top-content" style="margin-left: 0%">
            <div role="tabpanel" aria-hidden="false" tabindex="0" class="ant-tabs-tabpane ant-tabs-tabpane-active" style="visibility: visible">
              <div class="_1hzDzc7i">
                <div class="ant-spin-nested-loading">
                  <div class="ant-spin-container">
                    <div style="min-height: 400px">
                      <div class="_2ffrfDbZ animated fadeIn">
                        <div class="JjNdHUdF">付款方式</div>
                        <ul class="qhjW82GL">
                          <!--  -->
                          <li :class="pay_way == 'bank' ? '_1RAhvDLT _34uKVbSK ' : '_1RAhvDLT'" @click="changPay('bank')" v-if="payWayList.card == 1">
                            <div class="_1hBkzrhI">
                              <img class="_1Gz8zmh5" src="/static/image/d14.png" alt="" />
                              <div class="_3X6LF8yB">银行卡转账</div>
                            </div>
                          </li>
                          <li :class="pay_way == 'usdt' ? '_1RAhvDLT _34uKVbSK ' : '_1RAhvDLT'" v-if="payWayList.usdt == 1" @click="changPay('usdt')">
                            <div class="_1hBkzrhI">
                              <img class="_1Gz8zmh5" src="/static/image/ic_deposit_xunihb.png" alt="" />
                              <div class="_3X6LF8yB">虚拟币支付</div>
                              <div class="_1m3VlWMA">推荐</div>
                            </div>
                          </li>

                          <li :class="pay_way == 'alipay' ? '_1RAhvDLT _34uKVbSK ' : '_1RAhvDLT'" v-if="payWayList.alipay == 1" @click="changPay('alipay')">
                            <div class="_1hBkzrhI">
                              <img class="_1Gz8zmh5" src="https://static.xaqlt.com/wap/images/app/deposit/android/d3.png" alt="" />
                              <div class="_3X6LF8yB">支付宝</div>
                            </div>
                          </li>
                          <li :class="pay_way == 'wechat' ? '_1RAhvDLT _34uKVbSK ' : '_1RAhvDLT'" v-if="payWayList.wechat == 1" @click="changPay('wechat')">
                            <div class="_1hBkzrhI">
                              <!--  -->
                              <img class="_1Gz8zmh5" src="/static/image/weilog1515.png" alt="" />
                              <div class="_3X6LF8yB">微信支付</div>
                            </div>
                          </li>
                          <li :class="pay_way == 'rengong' ? '_1RAhvDLT _34uKVbSK ' : '_1RAhvDLT'" @click="changPay('rengong')">
                            <div class="_1hBkzrhI">
                              <img class="_1Gz8zmh5" src="/static/image/d1111.png" alt="" />
                              <div class="_3X6LF8yB">人工充值</div>
                            </div>
                          </li>
                        </ul>
                      </div>
                      <div class="zhifu">
                        <!-- 银行卡交易 -->
                        <div class="item" v-if="pay_way == 'bank'">
                          <div class="_2jSgMcz1">为了您的资金安全，请使用账号绑定的姓名存款</div>
                          <form class="ant-form ant-form-horizontal _3gwdHCHc">
                            <div class="_1pDMxc1H _219g769H" v-if="!(userbank.length == 0 && userUSD.length == 0)">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <div class="JoiHTIGs">
                                        <div class="_1lgxzaTd VnPYo1MB _3jiVkBQ9" @click="changBankId(item.id)" v-for="(item, index) in cardLis" :key="index">
                                          <div class="_2nk86HnM">
                                            <div class="_1YeYP-8D">
                                              <div class="_2jKHJAb6"></div>
                                            </div>
                                          </div>

                                          <p style="font-size: 10px; line-height: 1; color: #fff; line-height: 1.5">收款银行：{{ item.bank_data.bank_name }}</p>
                                          <p style="font-size: 10px; line-height: 1; color: #fff; line-height: 1.5">账号：{{ item.bank_no }} <img @click="doCopy(item.bank_no)" style="width: 20px; float: right" src="/static/image/clongicon.png" alt="" /></p>
                                          <p style="font-size: 10px; line-height: 1; color: #fff; line-height: 1.5">户名：{{ item.bank_owner }} <img @click="doCopy(item.bank_owner)" style="width: 20px; float: right" src="/static/image/clongicon.png" alt="" /></p>
                                          <p style="font-size: 10px; line-height: 1.2; color: #fff; line-height: 1.5">银行地址：{{ item.bank_address }}</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="d_name" class="" title="汇款姓名">汇款姓名</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入汇款姓名" id="d_name" v-model="bankBox.bank_owner" style="width: 285px" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="_3fFSHoQ9">为了您的资金安全，请使用账号绑定的姓名存款</div>
                            </div>
                            <div class="_1pDMxc1H iLNFmffG">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="bank_name" class="" title="银行类型">银行类型</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <div class="ant-select _32SoV0oI ant-select-single ant-select-show-arrow ant-select-show-search" style="width: 280px; position: relative">
                                        <div class="ant-select-selector">
                                          <span class="ant-select-selection-search">
                                            <input
                                              id="bank_name"
                                              autocomplete="off"
                                              class="ant-select-selection-search-input"
                                              role="combobox"
                                              aria-haspopup="listbox"
                                              aria-owns="bank_name_list"
                                              aria-autocomplete="list"
                                              aria-controls="bank_name_list"
                                              aria-activedescendant="bank_name_list_0"
                                              readonly=""
                                              unselectable="on"
                                              style="opacity: 0"
                                            /> </span
                                          ><span class="ant-select-selection-placeholder">请选择银行类型</span>
                                        </div>
                                        <span class="ant-select-arrow" unselectable="on" aria-hidden="true" style="user-select: none"
                                          ><span role="img" aria-label="down" class="anticon anticon-down">
                                            <svg viewBox="64 64 896 896" focusable="false" data-icon="down" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                              <path d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path>
                                            </svg> </span
                                        ></span>
                                        <div class="ant-select-dropdown ant-select-dropdown-placement-bottomLeft ant-select-dropdown-hidden" style="min-width: 280px; width: 280px; left: 0; top: 42px">
                                          <div>
                                            <div class="" style="max-height: 256px; overflow-y: auto; overflow-anchor: none">
                                              <div>
                                                <div class="list" style="display: flex; flex-direction: column">
                                                  <!-- ant-select-item-option-active -->
                                                  <div class="ant-select-item ant-select-item-option" v-for="(item, index) in banklist" :key="index">
                                                    <div class="ant-select-item-option-content">{{ item.bank_name }}</div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="_3iTW5ta0">请选择银行类型</div>
                            </div>
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="d_name" class="" title="卡号">卡号</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入卡号" v-model="bankBox.bank_no" style="width: 285px" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="_3iTW5ta0">请仔细核对银行卡号</div>
                            </div>
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="d_name" class="" title="开户行">开户行</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入开户行" v-model="bankBox.bank_address" style="width: 285px" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="_3iTW5ta0">请仔细输入正确的开户行地址</div>
                            </div>

                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="money" class="" title="存款金额">存款金额</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="off" class="ant-input _3ON7kyGT number1" type="number" v-model="amount" :placeholder="`请输入取款金额 ${min_price} - ${max_price}`" id="money" style="width: 285px" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div>
                                <div class="_3iTW5ta0">请务必输入正确金额区间范围内的金额</div>
                              </div>
                            </div>
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item" style="margin-left: 70px">
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <div class="ant-spin-nested-loading">
                                        <div class="ant-spin-container">
                                          <!-- <ul class="_2tZRPt8E select_number1">
                                        <li data-title="13003">￥13003</li>
                                        <li data-title="13009">￥13009</li>
                                        <li data-title="13003">￥15003</li>
                                        <li data-title="17007">￥17007</li>
                                        <li data-title="18001">￥18001</li>
                                      </ul> -->
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="_272Y7rsN">
                              <div class="_349CzCYy xJQe3jRu _3ARLbJkh" @click="payTest"><span>立即存款</span></div>
                            </div>
                          </form>
                        </div>
                        <!-- 虚拟币交易 -->
                        <div class="item" v-if="pay_way == 'usdt'">
                          <form class="ant-form ant-form-horizontal _3gwdHCHc">
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label class="" title="钱包协议">钱包协议</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <div class="ant-spin-nested-loading">
                                        <div class="ant-spin-container">
                                          <ul class="_2tZRPt8E">
                                            <!-- ERC20/TRC20 -->
                                            <li :class="meyXi == 'ERC20' ? 'd1qCTAjZ' : ''" @click="changMeyXi('ERC20')">ERC20</li>
                                            <li :class="meyXi == 'TRC20' ? 'd1qCTAjZ' : ''" @click="changMeyXi('TRC20')">TRC20</li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item" style="flex: 0 0 auto">
                                <div class="ant-col ant-form-item-label">
                                  <label for="money" class="" title="存款金额">存款金额</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="off" class="ant-input _3ON7kyGT" :placeholder="`请输入取款金额 ${min_price} - ${max_price}`" id="money" type="number" v-model="amount" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div>
                                <div class="_3iTW5ta0">选择协议 &gt;发起存款&gt;交易所购买USDT币种并划转USDT&gt; 转账至{{ $store.state.appInfo.title }}收款地址&gt;完成存款</div>
                              </div>
                            </div>
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <div class="CfLarj8e">
                                        <!-- Math.floor(num * 100) / 100    不四舍五入 保留两位小数-->
                                        <span>≈ {{ amount ? Math.floor((amount / $store.state.userInfo.usdtrate) * 100) / 100 : '0.00' }} USDT</span>
                                        <span class="olLUPH7p"
                                          >参考汇率: <span class="_3BZbM7Xw">{{ $store.state.userInfo.usdtrate }}</span>
                                          <!-- <i class="_3NqEPkiQ"></i>  -->
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <div class="_2C-AsUw2">
                                        <div class="_349CzCYy xJQe3jRu" @click="payTest"><span>立即存款</span></div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        <!-- 支付宝交易 -->
                        <div class="item" v-if="pay_way == 'alipay'">
                          <form class="ant-form ant-form-horizontal _3gwdHCHc">
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="money" class="" title="存款金额">存款金额</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="off" class="ant-input _3ON7kyGT number2" :placeholder="`请输入取款金额 ${min_price} - ${max_price}`" id="money" type="number" v-model="amount" style="width: 285px" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div>
                                <div class="_3iTW5ta0">支付宝官方对陌生人转账会有风控拦截的情况，若支付不成功 请使用其他充值方式进行存款。</div>
                              </div>
                            </div>
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item" style="margin-left: 70px">
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <div class="ant-spin-nested-loading">
                                        <!-- <div class="ant-spin-container">
                                      <ul class="_2tZRPt8E select_number2">
                                        <li data-title="104">￥104</li>
                                        <li data-title="151">￥151</li>
                                        <li data-title="212">￥212</li>
                                        <li data-title="305">￥305</li>
                                        <li data-title="491">￥491</li>
                                      </ul>
                                    </div> -->
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="_272Y7rsN">
                              <div class="_349CzCYy xJQe3jRu _3ARLbJkh" @click="payTest"><span>立即存款</span></div>
                            </div>
                          </form>
                        </div>
                        <!-- QQ 微信支付 -->
                        <div class="item" v-if="pay_way == 'wechat'">
                          <form class="ant-form ant-form-horizontal _3gwdHCHc">
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="money" class="" title="存款金额">存款金额</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="off" class="ant-input _3ON7kyGT number2" :placeholder="`请输入取款金额 ${min_price} - ${max_price}`" id="money" type="number" v-model="amount" style="width: 285px" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div>
                                <div class="_3iTW5ta0">若充值金额为整百，可能会影响到账，建议调整金额尾数（如：102,121,156等）</div>
                              </div>
                            </div>
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item" style="margin-left: 70px">
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <div class="ant-spin-nested-loading">
                                        <!-- <div class="ant-spin-container">
                                      <ul class="_2tZRPt8E select_number2">
                                        <li data-title="104">￥104</li>
                                        <li data-title="151">￥151</li>
                                        <li data-title="212">￥212</li>
                                        <li data-title="305">￥305</li>
                                        <li data-title="491">￥491</li>
                                      </ul>
                                    </div> -->
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="_272Y7rsN">
                              <div class="_349CzCYy xJQe3jRu _3ARLbJkh" @click="payTest"><span>立即存款</span></div>
                            </div>
                          </form>
                        </div>

                        <!-- 人工充值 -->
                        <div class="item" v-if="pay_way == 'rengong'">
                          <form class="ant-form ant-form-horizontal _3gwdHCHc">
                            <div class="_3W3SGWwh">温馨提示：若其他支付方式失败，建议您使用人工充值功能，由专人客服引导您进行充值。</div>
                            <div class="_349CzCYy xJQe3jRu _3NscHHtE" @click="payTest"><span>立即存款</span></div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div role="tabpanel" aria-hidden="true" tabindex="-1" class="ant-tabs-tabpane ant-tabs-tabpane-inactive" style="visibility: hidden"></div>
          </div>

          <div v-show="tabShow == 1" class="ant-tabs-content ant-tabs-content-animated ant-tabs-top-content" style="margin-left: -100%">
            <div role="tabpanel" aria-hidden="true" tabindex="-1" class="ant-tabs-tabpane ant-tabs-tabpane-inactive" style="visibility: hidden">
              <div class="_1hzDzc7i">
                <div></div>
              </div>
            </div>
            <div role="tabpanel" aria-hidden="false" tabindex="0" class="ant-tabs-tabpane ant-tabs-tabpane-active" style="visibility: visible">
              <div class="_1hzDzc7i">
                <div class="ant-spin-nested-loading">
                  <div class="ant-spin-container">
                    <form class="ant-form ant-form-horizontal">
                      <img src="/static/image/feccbd564047003e30cdab74ae7704e99407c6c2.png" class="_1jxQ4Dk2" alt="" />
                      <div style="height: 24px"></div>
                      <div class="_1pDMxc1H _10dODYXN">
                        <div class="ant-row ant-form-item">
                          <div class="ant-col ant-form-item-label">
                            <label for="type" class="" title="钱包协议">钱包协议</label>
                          </div>
                          <div class="ant-col ant-form-item-control">
                            <div class="ant-form-item-control-input">
                              <div class="ant-form-item-control-input-content">
                                <div class="ant-spin-nested-loading">
                                  <div class="ant-spin-container">
                                    <ul class="_2tZRPt8E _2_SbSPyY">
                                      <li :class="meyXi == 'ERC20' ? 'd1qCTAjZ' : ''" @click="changMeyXi('ERC20')">ERC20</li>
                                      <li :class="meyXi == 'TRC20' ? 'd1qCTAjZ' : ''" @click="changMeyXi('TRC20')">TRC20</li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <a class="_1S7hWL0Q" href="javascript:;" target="_self">点我了解更多？</a>
                      </div>
                      <div class="con_box1">
                        <div class="_1pDMxc1H _10dODYXN">
                          <div class="ant-row ant-form-item">
                            <div class="ant-col ant-form-item-label">
                              <label class="" title="充币地址">充币地址</label>
                            </div>
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input">
                                <div class="ant-form-item-control-input-content">
                                  <input autocomplete="off" id="copy1" class="ant-input _3ON7kyGT" type="text" readonly value="0x7a7f1E0E63FF12056cF83B899798CE9bB85b4DD5" style="width: 390px" />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="_349CzCYy xJQe3jRu _1WgPdyC- copy1" data-clipboard-target="#copy1"><span>复制地址</span></div>
                        </div>
                        <div class="KuS9Gny2">
                          <img src="/static/image/ewm.png" width="184" height="184" class="LDv5Jj8Y" />
                          <div class="_131tYPAc">扫描二维码获得充币地址</div>
                        </div>
                        <div class="_1tHPgOqN">
                          <div>充值须知</div>
                          <div>1.向该地址充值后，资金直接入账{{ $store.state.appInfo.title }}用户:<span>&nbsp;1021610216</span>。</div>
                          <div>2.请勿向上述地址充值任何非<span>USDT-ERC20</span>和<span>USDT-TRC20</span>的货币，否则将无法找回，一概自行负责。</div>
                          <div>3.当前汇率为：<span>6.43</span>CNY/USDT（仅供参考，以实际上分为准）。</div>
                          <div>4.具体到账金额以实际到账金额为准</div>
                        </div>
                      </div>
                      <div class="con_box2" style="display: none">
                        <div class="_1pDMxc1H _10dODYXN">
                          <div class="ant-row ant-form-item">
                            <div class="ant-col ant-form-item-label">
                              <label class="" title="充币地址">充币地址</label>
                            </div>
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input">
                                <div class="ant-form-item-control-input-content">
                                  <input autocomplete="off" id="copy2" class="ant-input _3ON7kyGT" type="text" readonly value="TRiGytmdq7GPqEYxzQ26VeBs1qUvCS7YHv" style="width: 390px" />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="_349CzCYy xJQe3jRu _1WgPdyC- copy2" data-clipboard-target="#copy2"><span>复制地址</span></div>
                        </div>
                        <div class="KuS9Gny2">
                          <img src="/static/image/ewm1.png" width="184" height="184" class="LDv5Jj8Y" />
                          <div class="_131tYPAc">扫描二维码获得充币地址</div>
                        </div>
                        <div class="_1tHPgOqN">
                          <div>充值须知</div>
                          <div>1.向该地址充值后，资金直接入账{{ $store.state.appInfo.title }}用户:<span>&nbsp;1021610216</span>。</div>
                          <div>2.请勿向上述地址充值任何非<span>USDT-ERC20</span>和<span>USDT-TRC20</span>的货币，否则将无法找回，一概自行负责。</div>
                          <div>3.当前汇率为：<span>6.43</span>CNY/USDT（仅供参考，以实际上分为准）。</div>
                          <div>4.具体到账金额以实际到账金额为准</div>
                        </div>
                      </div>
                      <!-- <div class="_1rV-jIpS">
                    官方推荐交易所下载
                    <div class="_3lu--EcE">
                      <a href="javascript:;" target="_self"><img src="/static/image/c2ca5c0fa95d3a4d016796d7750f8db7.jpg" alt="https://www.yibifu.net/ybf/" /></a>
                    </div>
                  </div> -->
                      <!-- <div class="_1rV-jIpS">
                    虚拟币存款教程
                    <div class="_3lu--EcE">
                      <a href="javascript:;" target="_self"
                        ><img
                          src="data:image/png;base64,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"
                          alt="文字教程"
                      /></a>
                    </div>
                  </div> -->
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="QWVbbD2t">
      <div class="_2nBIhPkx"><a href="javascript:;">更多活动</a></div>
      <div class="_3KIF2T1t" style="padding: 0 23px; overflow: hidden">
        <div class="swiper-container lunbo">
          <div class="swiper-wrapper">
            <div class="swiper-slide hR-oz47F"><img width="100%" height="100%" src="/static/image/76be8058cdef9cdd5b729be237f31166.png" /></div>
            <div class="swiper-slide hR-oz47F"><img width="100%" height="100%" src="/static/image/4aae59ee1b18d960529d777587d39344.png" /></div>
            <div class="swiper-slide hR-oz47F"><img width="100%" height="100%" src="/static/image/6f8b85d67739fde6ea9cfdd5d4ed4a0b.png" /></div>
            <div class="swiper-slide hR-oz47F"><img width="100%" height="100%" src="/static/image/cd9dc0cf19d23c754b708ae6833fbb78.png" /></div>
            <div class="swiper-slide hR-oz47F"><img width="100%" height="100%" src="/static/image/c4199dd1739adc2cdf8340b7ddc6db1b.png" /></div>
            <div class="swiper-slide hR-oz47F"><img src="/static/image/83782ef80839fc4804ed9424ba769290.png" /></div>
          </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
    </div> -->
      </div>
    </div>


    <!-- 我绑定卡片 -->
         <div data-v-d47f0a72="" class="_1euN-aP1" v-if="userbank.length == 0 && userUSD.length == 0">
        <div data-v-d47f0a72="" class="_2v39xVwk animated animated-3 fadeIn"></div>
        <div data-v-d47f0a72="" class="_3Pc_iCss animated animated-3 zoomIn" style="width: 700px">
          <div data-v-d47f0a72="" class="_3DZ99c6r">
            <span data-v-d47f0a72=""></span>
            <div data-v-d47f0a72="" class="_3x7x8GsG">温馨提示</div>
            <img
              @click="$router.back()"
              data-v-d47f0a72=""
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAC0UExURUxpcf/////Uqv+2tv//qv///+u3o/////W8qv/Gxv/9/emwoOWunO+zouiyovC0peexneeyn+qxouWvnOWvneWwnOWunOWvnee5ouWxneaxoeSunOSunOWxpOSvneSvnPC4m+SvneWwn+SwnfXf1+avnPTe1fvw7eSunOewnuSum+mynuSunPXg2vLVzeSum//9/eSunOSunPPa0uStnfbm3/HWzfjr5vnh1vzz8f359////2ASjEAAAAA7dFJOUwD9BgcDAg0BCQT9G0cPFREkHxg6Pi5RYAsoNkxaE1VkEkIdMJAzlWpoK4AidYm6jPSWbZ9xf651HmONntaUtAAABAdJREFUeNrtlsly4kgQhgdJCMlaKe37ZmFAYDDgrXn/95qsqqRlRxSaufSlw3khQsn/qZSV2z8/9mN/ny3QJn0TNp/PFTD4wT9+UY+++6+fK7ougem6rgDim1xBH7iUxR29okuypsVxrGmyRBFf9Lp+c2ngEhPmuqTFquXUzoetavJIWABaRpdlf1CXUK/ommoVNjF+XY+flqoxAupBXoPHIJ/H6y84w1wUAF2OrYK0Q3q9XmeftapJQEC96thGO7ju0wycH5oODgFAUwuydDfpkRKeCk5YsJPVpHWTIHin+iMBhwCgSJplt27Qe6+zLwTUD0mXouPTiWUxIHbIsOm9xtyPBLg70BvsOYKNQpV1MaA23MBrsjBEgm1pYGoB+tRH7HvS3gc4FGCGZZ4/IsFRVQv0Qdpk+wf66LVnAEUcRIsMFJDn0Y1AbBvCR/WPTL/3O9eoVekOQLWXG/hvHkVVhIRhCeHzUP+wN71gIJbwFiARZfhat/PNMq+qG+E96ODzQ65/zJo0aW1VmAcQBPoN7AhlVK2raMUIr36T3fQhOwC9RSGAHqE2eBSAsK5W/LPDcsX0q9CkEYDLFVYTpix8BCeswVCIP6Xp9/ABFqa46AhI6CihWp8ulzOToj4D/ZLqMQJCgnQjlNH6sttt32gcvutlpp8i2G3S+1leXXbbw4ETHs552KSbJZnWI8Gi2WCG0QX0L88zPADPgBj1kwSoKciGMDptUc+uEDIALkCgFyYk3GWWA4DpZzwfepen4P8CLDngjUmfOeYdAGMGTAeBDJ2fRSfUvxzeHhjBqAUhECZTm6RNGJ1R/3LYnhnhSZRE4mSEA0D+4vsP2+3uRsBOO6nHcuD6ty213YVl9dhp/0ufNlh/5x2zy+lUrWZTBAwg77+0oFFfVdBboDBP6/Wtw/BiBIJ4sjhf9au8DMFKXtwjAfuJqKFgHaC+DM3G9xszo4iRgB1N1NJ4Xzf3qM8aL+263vNpfxi73CceQZyCkAHlEfV+GiSu6256JET5HkcbACbaeoT9z+83g0GIsYS2TAlRlPOJ8xFLyuRgeb4emT5ZksKyahiYQIBA5HlovsJ4x8EyMdqiMuN6R4W1xLIhNdnEC+Fxmk6NNsKGIFjjdbR/QfHoMu+0/LnvBe794UrHAp3ivu+lgduy/ge7Fe+Tmx6e+ynEhdT3ZiObw0nQ9V2QDAb2T94n0dEHGwYWz0a+yCzdJHGHlhSox05Ldx/01CyZxUsaEIjRtgaBuY79H9C4fhHDoB7QA1lUTAqNl+UURVFbaoz63wRw1dxFI7O4t2jCralg2rgmIuGba2JVhV2VmqSjflxV0QeuqcY6ZysxW6m/l/yCIm6+xfS6jyZyoefH/oD9C6i3ptIfvSpmAAAAAElFTkSuQmCC"
              alt=""
              class="_8iC2lrZe"
            />
          </div>
          <div data-v-d47f0a72="" class="n8VMb-cz" style="text-align:left" >
         您还为绑定钱包卡片，请前往添加！
          <div data-v-65b291c8="" class="_349CzCYy xJQe3jRu" @click="$parent.goNav('/mine/bankCard')" style="width: 150px;margin: 0 auto;margin-top:50px"><span data-v-65b291c8="">去绑定</span></div>

          </div>
        </div>
      </div>
  </div>
</template>
<script>
export default {
  name: 'deposit',
  data() {
    return {
      pay_way: 'bank', //bank/alipay/wxpay/usdt  1/2/3/4
      amount: null, //支付金额
      tabShow: 0, //当前选中的
      meyXi: 'ERC20', //qian
      bankBox: {},
      lodingShow: true,
      banklist: [],
      cardLis: [],
      bankId: null,
      jumpUrl: null,
      baseURL: '',
      payWayList: {},
      userbank: [],
      userUSD: [1],
      min_price: 100,
      max_price: 10000,
    };
  },
  created() {
    let that = this;
    that.getPayWay();
    that.getBanklist();
    that.getcard();
    that.baseURL = sessionStorage.getItem('baseURL') || '';
    console.log(sessionStorage.getItem('baseURL'));
  },
  methods: {
    getPayRange() {
      let that = this;
      let type = null;

      if (that.pay_way == 'bank') {
        type = 'bank';
      }
      if (that.pay_way == 'wechat') {
        type = 'wechat';
      }
      if (that.pay_way == 'alipay') {
        type = 'alipay';
      }
      if (that.pay_way == 'alipay') {
        type = 'alipay';
      }
      if (that.pay_way == 'usdt') {
        if (that.meyXi == 'ERC20') {
          type = 'usdt-erc20';
        }
        if (that.meyXi == 'TRC20') {
          type = 'usdt-trc20';
        }
      }
      // bank/wechat/alipay/usdt-erc20/usdt-trc20/ebpay    min_price max_price
      that.showloading();

      that.$apiFun
        .post('/api/getPayRange', { type })
        .then(res => {
          if (res.code == 200) {
            that.min_price = res.data.min_price;
            that.max_price = res.data.max_price;
          }
          that.hideloading();
        })
        .catch(res => {
          that.hideloading();
        });
    },
    getuseCardlist() {
      let that = this;
      that.$apiFun.post('/api/getcard', { type: 1 }).then(res => {
        if (res.code == 200) {
          that.userbank = res.data;
        }
      });
      that.$apiFun.post('/api/getcard', { type: 2 }).then(res => {
        if (res.code == 200) {
          that.userUSD = res.data;
        }
      });
    },
    changPay(type) {
      if (this.pay_way == type) {
        return;
      }
      this.pay_way = type;
      this.getPayRange();
    },
    changBankId(id, chanmeyXi) {
      let that = this;
      // that.bankId = id;
      // that.chanmeyXi = chanmeyXi;
    },
    getPayWay() {
      let that = this;
      that.showloading();

      that.$apiFun
        .get('/api/get_pay_way', {})
        .then(res => {
          if (res.code == 200) {
            that.payWayList = res.data;
            that.payWayList.rengong = 1;
            let obj = that.payWayList;
            for (let i in obj) {
              if (obj[i] == 1) {
                that.pay_way = i == 'card' ? 'bank' : i;
                that.hideloading();
                that.getPayRange();

                return;
              }
            }
          }
          that.hideloading();
        })
        .catch(res => {
          that.hideloading();
        });
    },
    getcard() {
      let that = this;
      that.showloading();
      that.$apiFun
        .post('/api/getpaybank', {})
        .then(res => {
          if (res.code != 200) {
            that.showTost(res.message);
          }
          if (res.code == 200) {
            that.cardLis = res.data;

            that.hideloading();
          }
        })
        .catch(res => {
          that.hideloading();
        });
    },
    hideloading() {
      this.lodingShow = false;
    },
    showloading() {
      this.lodingShow = true;
    },
    getBanklist() {
      let that = this;
      that.$apiFun
        .post('/api/banklist', {})
        .then(res => {
          if (res.code != 200) {
            that.showTost(res.message);
          }
          if (res.code == 200) {
            that.banklist = res.data;
          }
          that.hideloading();
        })
        .catch(res => {
          that.hideloading();
        });
    },

    openKefu() {
      let that = this;
      that.showloading();
      that.$parent.openKefu();
      that.hideloading();
    },
    payTest() {
      let that = this;
      let info = {};

      if (that.pay_way == 'rengong') {
        that.openKefu();
        return;
      }
      // bank 情况下  bank  bank_address  bank_no  bank_owner
      if (that.pay_way == 'bank') {
        info = {
          paytype: that.pay_way,
          amount: that.amount * 1,
          bank: that.bankBox.bank,
          bank_address: that.bankBox.bank_address,
          bank_no: that.bankBox.bank_no,
          bank_owner: that.bankBox.bank_owner,
        };
        console.log(info);
        // 银行卡信息内容的限制
        if (!info.bank_owner) {
          that.showTost('请输入存款人姓名');
          return;
        }
        if (!info.bank) {
          that.showTost('请输入银行类型');
          return;
        }

        if (!info.bank_no) {
          that.showTost('请输入银行卡号');
          return;
        }
        if (!info.bank_address) {
          that.showTost('请输入银行开户行地址');
          return;
        }
      } else {
        //暂时
        info = {
          paytype: that.pay_way,
          amount: that.amount * 1,
        };
      }
      if (that.pay_way == 'usdt') {
        info.catepay = that.meyXi;
      }
      // usdt 情况下  catepay 必填

      // 支付的金额判断
     if (info.amount < that.min_price || info.amount > that.max_price) {
        that.showTost(0, `请输入金额在${that.min_price}-${that.max_price}之间！`);
        return;
      }
      that.showloading();
      info.paytype = info.paytype == 'wechat' ? 'wxpay' : info.paytype;
      that.$apiFun
        .post('/api/recharge', info)
        .then(res => {
          console.log(res);
          if (res.code != 200) {
            that.showTost(res.message);
          }
          if (res.code == 200) {
            that.amount = null;
            if (that.pay_way == 'bank') {
              that.showTost('提交成功，等待后台审核');
              that.bankBox = {};
              that.amount = null;
              $('.ant-select-selection-placeholder').text('请选择内容');
              that.$router.push({ path: '/mine/transRecord' });
              return;
            }
            that.bankBox = {};
            that.amount = null;
            $('.ant-select-selection-placeholder').text('请选择内容');
            that.showTost('正在跳转...');
            that.goPath('/payInfo', { deposit_no: res.message });
            // ;
            setTimeout(() => {
              that.$router.push({ path: '/mine/transRecord' });
            }, 2000);
          }
          that.hideloading();
        })
        .catch(res => {
          that.hideloading();
        });
    },
    // 支付大类型
    changtabShow(val) {
      let that = this;
      that.tabShow = val;
    },
    // 钱包协议的选择
    changMeyXi(val) {
      if (this.meyXi == val) {
        return;
      }
      this.meyXi = val;
      this.getPayRange();
    },
    doCopy(msg) {
      let cInput = document.createElement('input');
      cInput.style.opacity = '0';
      cInput.value = msg;
      document.body.appendChild(cInput);
      // 选取文本框内容
      cInput.select();
      console.log(msg);
      // 执行浏览器复制命令
      // 复制命令会将当前选中的内容复制到剪切板中（这里就是创建的input标签）
      // Input要在正常的编辑状态下原生复制方法才会生效
      document.execCommand('copy');

      // 复制成功后再将构造的标签 移除
      this.showTost('复制成功！');
    },
    showTost(title) {
      $('body').append(`
            <div class='ant-message' style='top: 400px;'><span><div class='ant-message-notice'><div class='ant-message-notice-content'>
            <div class='ant-message-custom-content ant-message-info'><span role='img' aria-label='info-circle' class='anticon anticon-info-circle'>
            <svg viewBox='64 64 896 896' focusable='false' data-icon='info-circle' width='1em' height='1em' fill='currentColor' aria-hidden='true'>
            <path d='M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm32 664c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8V456c0-4.4 3.6-8 8-8h48c4.4 0 8 3.6 8 8v272zm-32-344a48.01 48.01 0 010-96 48.01 48.01 0 010 96z'></path></svg></span><span>
            ${title}
            </span></div></div></div></span>
            </div>`);
      setTimeout('$(".ant-message").detach()', 2000);
    },
    goPath(path, query) {
      let that = this;
      const routeData = this.$router.resolve({
        path,
        query,
      });

      that.jumpUrl = routeData.href;
    },
    beforeRouteEnter(to, from, next) {
      next(vm => {
        vm.getuseCardlist();
      });
    },
  },
  mounted() {
    //公告弹窗
    let that = this;
    function openGonggao() {
      $('.gonggao').show();
      $('.gonggao ._1euN-aP1').show();
    }
    //关闭弹窗
    function closebox() {
      $('.office-modal-container').hide();
      $('._1euN-aP1').hide();
    }
    //切换支付方式
    $('.qhjW82GL li._1RAhvDLT').click(function () {
      var index = $(this).index();

      that.amount = null;
      $(this).addClass('_34uKVbSK').siblings().removeClass('_34uKVbSK');
      $('.zhifu .item').eq(index).fadeIn(300).siblings().hide();
    });
    //选择金额1
    $('.select_number1 li').click(function () {
      var index = $(this).index();
      var number = $(this).attr('data-title');
      $(this).addClass('d1qCTAjZ').siblings().removeClass('d1qCTAjZ');
      $('.number1').attr('value', number);
    });
    //选择金额2
    $('.select_number2 li').click(function () {
      var index = $(this).index();
      var number = $(this).attr('data-title');
      $(this).addClass('d1qCTAjZ').siblings().removeClass('d1qCTAjZ');
      $('.number2').attr('value', number);
    });
    var swiper = new Swiper('.lunbo', {
      slidesPerView: 2,
      spaceBetween: 12,
      speed: 400,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });

    //切换钱包协议
    $('._2tZRPt8E li').click(function () {
      $(this).addClass('d1qCTAjZ').siblings().removeClass('d1qCTAjZ');
    });
    $('._2tZRPt8E li:eq(0)').click(function () {
      $('.con_box1').show();
      $('.con_box2').hide();
    });
    $('._2tZRPt8E li:eq(1)').click(function () {
      $('.con_box1').hide();
      $('.con_box2').show();
    });

    //复制方法
    //erc
    var clipboard1 = new ClipboardJS('.copy1');
    clipboard1.on('success', function (e) {
      $('body').append(
        "<div class='ant-message' style='top: 400px;'><span><div class='ant-message-notice'><div class='ant-message-notice-content'><div class='ant-message-custom-content ant-message-info'><span role='img' aria-label='info-circle' class='anticon anticon-info-circle'><svg viewBox='64 64 896 896' focusable='false' data-icon='info-circle' width='1em' height='1em' fill='currentColor' aria-hidden='true'><path d='M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm32 664c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8V456c0-4.4 3.6-8 8-8h48c4.4 0 8 3.6 8 8v272zm-32-344a48.01 48.01 0 010-96 48.01 48.01 0 010 96z'></path></svg></span><span>复制成功!</span></div></div></div></span></div>",
      );
      setTimeout('$(".ant-message").detach()', 1000);
    });
    clipboard1.on('error', function (e) {
      $('body').append(
        "<div class='ant-message' style='top: 400px;'><span><div class='ant-message-notice'><div class='ant-message-notice-content'><div class='ant-message-custom-content ant-message-info'><span role='img' aria-label='info-circle' class='anticon anticon-info-circle'><svg viewBox='64 64 896 896' focusable='false' data-icon='info-circle' width='1em' height='1em' fill='currentColor' aria-hidden='true'><path d='M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm32 664c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8V456c0-4.4 3.6-8 8-8h48c4.4 0 8 3.6 8 8v272zm-32-344a48.01 48.01 0 010-96 48.01 48.01 0 010 96z'></path></svg></span><span>当前浏览器不支持此功能，请手动复制!</span></div></div></div></span></div>",
      );
      setTimeout('$(".ant-message").detach()', 1000);
    });
    //trc
    var clipboard2 = new ClipboardJS('.copy2');
    clipboard2.on('success', function (e) {
      $('body').append(
        "<div class='ant-message' style='top: 400px;'><span><div class='ant-message-notice'><div class='ant-message-notice-content'><div class='ant-message-custom-content ant-message-info'><span role='img' aria-label='info-circle' class='anticon anticon-info-circle'><svg viewBox='64 64 896 896' focusable='false' data-icon='info-circle' width='1em' height='1em' fill='currentColor' aria-hidden='true'><path d='M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm32 664c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8V456c0-4.4 3.6-8 8-8h48c4.4 0 8 3.6 8 8v272zm-32-344a48.01 48.01 0 010-96 48.01 48.01 0 010 96z'></path></svg></span><span>复制成功!</span></div></div></div></span></div>",
      );
      setTimeout('$(".ant-message").detach()', 1000);
    });
    clipboard2.on('error', function (e) {
      $('body').append(
        "<div class='ant-message' style='top: 400px;'><span><div class='ant-message-notice'><div class='ant-message-notice-content'><div class='ant-message-custom-content ant-message-info'><span role='img' aria-label='info-circle' class='anticon anticon-info-circle'><svg viewBox='64 64 896 896' focusable='false' data-icon='info-circle' width='1em' height='1em' fill='currentColor' aria-hidden='true'><path d='M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm32 664c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8V456c0-4.4 3.6-8 8-8h48c4.4 0 8 3.6 8 8v272zm-32-344a48.01 48.01 0 010-96 48.01 48.01 0 010 96z'></path></svg></span><span>当前浏览器不支持此功能，请手动复制!</span></div></div></div></span></div>",
      );
      setTimeout('$(".ant-message").detach()', 1000);
    });

    //提示弹窗
    function openTips() {
      $('.tips').show();
      $('.tips ._1euN-aP1').show();
    }
    //公告弹窗
    function openGonggao() {
      $('.gonggao').show();
      $('.gonggao ._1euN-aP1').show();
    }
    //关闭弹窗
    function closebox() {
      $('.office-modal-container').hide();
      $('._1euN-aP1').hide();
    }

    //鼠标经过li变色
    $('.ant-select-item').hover(
      function () {
        $(this).addClass('ant-select-item-option-active');
      },
      function () {
        $(this).removeClass('ant-select-item-option-active');
      },
    );
  },
  updated() {
    let that = this;
    //弹出银行列表
    $('.ant-select')
      .unbind('click')
      .click(function () {
        $(this).find('.ant-select-dropdown').slideToggle(200);
      });
    //选择银行
    $('.list .ant-select-item')
      .unbind('click')
      .click(function () {
        $(this).addClass('ant-select-item-option-active').siblings().removeClass('ant-select-item-option-active');
        var text = $(this).find('.ant-select-item-option-content').text();
        that.bankBox.bank = text;
        $('.ant-select-selection-search-input').attr('value', text);
        $('.ant-select-selection-placeholder').text(text).addClass('ant-select-selection-item');
      });
  },
  watch: {
    // 新窗口打开页面，解决浏览器拦截问题
    jumpUrl() {
      if (this.jumpUrl) {
        window.open(this.jumpUrl, '_blank');
      }
      this.jumpUrl = null;
    },
  },
};
</script>
<style lang="scss" scoped>
.swiper-button-next:after,
.swiper-rtl .swiper-button-prev:after {
  display: none;
}
.swiper-button-prev:after,
.swiper-rtl .swiper-button-next:after {
  display: none;
}
._1lgxzaTd {
  width: 243px;
}
</style>
