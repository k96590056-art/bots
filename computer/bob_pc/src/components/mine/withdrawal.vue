<template>
  <div class="ant-spin-nested-loading">
    <div class="loading" v-if="lodingShow">
      <div class="ant-spin ant-spin-spinning _2PSsJSST">
        <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
      </div>
    </div>
    <div :class="lodingShow ? 'ant-spin-container ant-spin-blur' : 'ant-spin-container'">
      <div class="_2hXp1MkX">
        <div class="_4ICMeQUV" style="border-bottom: none">
          <div class="T5pPAuRQ">取款</div>
          <!-- <a class="xAmazytl" target="_self" href="javascript:;">取款教程</a> -->
        </div>
        <div class="animated fadeIn _340pPwLv">
          <img
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAsCAMAAAAUyMtVAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAIZUExURUxpcf////Dw/+ju+f///////////////////////+ju+f///+f//+ft+efu+ebw+ujz/+bs+ez//+n//+fv/+v1/+/v/+jw/+fv++ru+uft+efv++fu++r0/+3u/+fu+vLy/+z1//Hx/+ft+urx/+nv+efu++nw++fv+eby/+v//+jw++jv++vy/+ft++bt+ufw+ubv++jx+urv+eby/+bu+uju+/X3+ujt+ebu+ufv+uTs+ufu+efu+ubu+e7x9+ju+ebu+N7m8ebs+Obu+ent9Ofu+ujv+unt+8fR4+bu+unw/+bt+eft+uXr9ebt+ebt+NXd7Obt+87Y5+bs+ebt+eXs99ni7ubt+OXr9MnV5+Ts9+fu+ejv+uTs9/j6/Obq8vT3+srU5tnh8NTf7dzm9d3n8+ft+eLp8ufu+t7n8uft+d7n8+Lp89zk8t7n9Nzl8vH0+uDn8tHZ67nG2t3m9MrV5+vv9dbh8Nje69ff7LHA2M/Z6fH0+rnI3crV5q2708rS4rXB17K+1u/y9r/M4NDa6dfg7d3n9L7K38bS5M/Z6cDM4MXQ48jU5brH3Nji8M3X6MrV5sLO4bzI3bbD2bjF2tLd7Nbg78TP4tHb69Te7tPb6dzm87LA17C+1c/a6r3J3c3Y6bTB1/X3+q6706y60sfS5MvW57vH3MrW59rk8bTB2Kq40fL0+Nzi7MPN3rzI3MnR4Zy35/IAAACvdFJOUwAFEWQECAMBBgJbCgtWLjQWOg4MHxkPIVE8K0FLGB1tFBsTdyUvZkVhKQ1EUCdOczZTNzEVPk/3WGpfSI+o0/6uieaAXvxrb0foPyPIoey+k+VJ5uDN2eie/di3uXve/ePv2pr5M9OE9JmvwqLlc97yysVNumbO8ZH8YItg32vx97/T6PuN3/H///////////////////////////////////////////////////7730mlAAAEuUlEQVR42sVVZ1cbVxBFWq1YrcqqS7sqqK0q6oBB9F5NNS0YArjGxr2lVyeHmAgLYZKQWAgMhCKKk1+Y0ZMQENafc8+cs/P2vNmdmXffnaL/C8V5XFxw7xYJBQIeTyAUiYqzC1gJhELwP7BfJCBwcfXETR8OMUIhj8Crm+ZwQiDkDIAP8nCvvD+VSk0oxQRB4BLl/VRqPibBeaJi7s+r+PoHqflUatjE90pUWtMc+PVOvooQFHN8nhBrmTsphDqHVW6zeB7Pp+a3Huk0fDFP9N9is9lY7A9hM2yaH6H8arPhASy2GkKMukxFiC5kI+FX38ycYMQXkrU8zGTGt/qNBsphUkLAuVYSuNJ8LZFIZBIZsERiKuxT1GUS45cmybAr5NCggELXoZNKm3Hg9zO45y7t+Gq8fqbd6Za6KIfciwJQ1+Uy2Y0bisCn1/88i6Y2Ut8+8wircsb0BlZnkaCioU7Vteu/caEp6JZKK2MYFpNWR/waLY7aysOVZQt/cKLJjlVKpSRJhgdpxmyTEOiocaVct76wsL6wDlZ4IozaMWlpRUXA6FNAU72EANUssajZpVO8W3oHlvNH7bHSDp+hi6YYnUkrJgSIflqrh07u7u7v7oPt7iZ3kwj7yf390SA5WK4IUVHGYZbzvTjBEwKbbDrKuJhMLiYXzyEJ70bbpb5I9Nnz2dnZjwDPvxRns5L76cpXp9h5tQOW8wdK9F1R5if0Lr4Tj3+T5V+RifG54/H4anwVrPBEGGgrpVnmxduFPFo1fAlRpJFVO5dzWF1eBVsuYKCtgo6yjTOX8hiD0vEiK2ts+4UbA1UVNEXRLj3pxjCgU8Rj5ouLrNFAyc/cGKoqLQ9FDEYSayspcZKBcpnaIkEBG28QNt5sgJ36ZwPaTgMgpc/+3nu99xoBnII/dCYlN6nPpYSK7v14C3BUf/zrOQyhoiHCqA/rgR8ynVyLo7Y21/aMXOntvT1ev7FyBkPQ1idPf4xG6K4uWhFldNm2ooML1tRe7akbmbrSe7RwsIlwsHlw0AkH993B5lOKZWWMXwf0gIND1MAmay43XO3rGa6bam3dWztBJ1BjemVt7XuFQ2fWlPG9WWog8ukx+62aTy7XNvT11PUevU3n0Qnka365l07/8CT79Rz5EL3LA6Sz3d7c2D8GISNQyTZCZ5bewZfvt7e//bpAb3SBmJChukLa4gw2Q2p36+7VH6f/AnSiC/TsxRL4X5xcIHRFrd0ellIYBsPu4K3+bP23j94fHh525q5obPoYFp+jK5oXAa3FZFV3+1mFK4zZGyGv4ZHW45V0QQQej6f/uY9EoCDuKqXWJrd2y+hBsqS5v3ai725T/dEdkBnIFGRmbmuaBVrwzguZRGmxOqIGPfwEOlY7VmMHIXMZwy3YiZBdkEqxVq72RDoqqyYba2oaJ51hH60o79CTLQWp5BgNmm7ocktVMNiOSV0hGcMCXUv1IMbdIMYccg89M3soQ0BaKQ0YKI/OrIZedBloLrkvKL5Jx1B0OR1h0UDRqP0yVuYpDBSumWLTqB1+v0OtQSPLojGr1WZTYWRx/ESs5JfJTXKbVoKjoci32fjaDwzF05NRqcQ4kR+7YjHys/v/BY0L1gOFlsc0AAAAAElFTkSuQmCC"
            class="_3I4cTIHy"
            alt=""
          />
          <div class="_1bKTdXvU">
            <div class="TNf1HZ2U pc0kVnul" onClick="openGonggao()">
              <marquee direction="left"> 尊敬的会员：【极速取款】交易风控小，自主完成率高，可以有效的规避风险。极力推荐您使用【极速取款】核实无误后及时点击“确认按钮”到账快人一步哦！ </marquee>
            </div>
          </div>
        </div>
        <div class="ant-tabs ant-tabs-top CxUrt0Fb _3J-cD19q ant-tabs-line">
          <div role="tablist" tabindex="-1" class="ant-tabs-bar ant-tabs-top-bar">
            <div class="ant-tabs-nav-container">
              <span unselectable="unselectable" class="ant-tabs-tab-prev ant-tabs-tab-btn-disabled"
                ><span class="ant-tabs-tab-prev-icon"
                  ><span role="img" aria-label="left" class="anticon anticon-left ant-tabs-tab-prev-icon-target">
                    <svg viewbox="64 64 896 896" focusable="false" data-icon="left" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                      <path d="M724 218.3V141c0-6.7-7.7-10.4-12.9-6.3L260.3 486.8a31.86 31.86 0 000 50.3l450.8 352.1c5.3 4.1 12.9.4 12.9-6.3v-77.3c0-4.9-2.3-9.6-6.1-12.6l-360-281 360-281.1c3.8-3 6.1-7.7 6.1-12.6z"></path>
                    </svg> </span></span></span
              ><span unselectable="unselectable" class="ant-tabs-tab-next ant-tabs-tab-btn-disabled"
                ><span class="ant-tabs-tab-next-icon"
                  ><span role="img" aria-label="right" class="anticon anticon-right ant-tabs-tab-next-icon-target">
                    <svg viewbox="64 64 896 896" focusable="false" data-icon="right" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                      <path d="M765.7 486.8L314.9 134.7A7.97 7.97 0 00302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 000-50.4z"></path>
                    </svg> </span></span
              ></span>
              <div class="ant-tabs-nav-wrap">
                <div class="ant-tabs-nav-scroll">
                  <div class="ant-tabs-nav ant-tabs-nav-animated">
                    <div>
                      <div role="tab" @click="changType(0)" aria-disabled="false" aria-selected="true" tabindex="0" :class="ctype == 0 ? 'ant-tabs-tab-active ant-tabs-tab' : ' ant-tabs-tab'" id="tab-0" aria-controls="tabpane-0">
                        <div class="_2CqeV2cs">人民币取款</div>
                      </div>
                      <div role="tab" @click="changType(1)" aria-disabled="false" aria-selected="false" tabindex="-1" :class="ctype == 1 ? 'ant-tabs-tab-active ant-tabs-tab' : ' ant-tabs-tab'" id="tab-1" aria-controls="tabpane-1">
                        <div class="_2CqeV2cs">虚拟币取款 <img src="/static/image/f7e370f156029035d421b94fc86edd92.png" alt="" /></div>
                      </div>
                    </div>
                    <div class="ant-tabs-ink-bar ant-tabs-ink-bar-animated" :style="`display: block; transform: translate3d(${ctype * 130}px, 0px, 0px); width: 130px`"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="ant-tabs-content ant-tabs-content-animated ant-tabs-top-content" :style="`margin-left: ${ctype * -100}%`">
            <div role="tabpanel" aria-hidden="false" tabindex="0" class="ant-tabs-tabpane ant-tabs-tabpane-active" style="visibility: visible">
              <div class="_1hzDzc7i">
                <div class="ant-spin-nested-loading">
                  <div class="ant-spin-container">
                    <div class="_1P86xn1X">
                      <div class="_3qllqZi4">取款方式</div>
                      <div class="_3b5uh5dv">
                        <div class="_3xvkQWoG _1aMF1vmk">极速取款</div>
                      </div>
                    </div>
                    <div class="_21o37iEs" v-if="cardLis.length == 0">
                      <img src="/static/image/ill_norecord_day-b111.png" alt="" />
                      <div class="HzjbFc_d">您还没绑定银行卡，为了您的资金安全，绑定银行卡时，需要填写您的个人信息</div>
                      <div class="_349CzCYy xJQe3jRu" style="width: 150px" @click="changAddShow"><span>去绑定</span></div>
                    </div>
                    <form v-if="cardLis.length > 0" class="ant-form ant-form-horizontal _2ABMlQ45">
                      <div style="margin-top: 15px; margin-left: 7px">
                        <div class="_1pDMxc1H _219g769H">
                          <div class="ant-row ant-form-item">
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input">
                                <div class="ant-form-item-control-input-content">
                                  <div class="JoiHTIGs">
                                    <div class="_1lgxzaTd VnPYo1MB _3jiVkBQ9" @click="changBankId(item.id)" v-for="(item, index) in cardLis" :key="index">
                                      <div class="_2nk86HnM">
                                        <div class="_1YeYP-8D">
                                          <div class="_2jKHJAb6">
                                            <div class="_3zJ5EeYL _2i6zOyWR">
                                              <img :src="item.ico" alt="" />
                                            </div>
                                            <div class="_1lfcA5kI">{{ item.bank }}</div>
                                          </div>
                                        </div>
                                        <div class="_2kHgqbKY" v-if="bankId == item.id">
                                          <div class="_32MC0_V7">
                                            <div class="_2uVogIHQ">
                                              <span role="img" aria-label="check" class="anticon anticon-check"
                                                ><svg viewBox="64 64 896 896" focusable="false" data-icon="check" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                                  <path d="M912 190h-69.9c-9.8 0-19.1 4.5-25.1 12.2L404.7 724.5 207 474a32 32 0 00-25.1-12.2H112c-6.7 0-10.4 7.7-6.3 12.9l273.9 347c12.8 16.2 37.4 16.2 50.3 0l488.4-618.9c4.1-5.1.4-12.8-6.3-12.8z"></path></svg
                                              ></span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="J5X-nZnR">{{ item.bank_no }}</div>
                                      <!-- <div class="_2hLYjBpM"><div class="_1GrKjNGn">禁用</div></div> -->
                                    </div>
                                    <div class="_2EJsOuqN" @click="changAddShow">
                                      <span role="img" aria-label="plus" class="anticon anticon-plus"
                                        ><svg viewBox="64 64 896 896" focusable="false" data-icon="plus" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                          <path d="M482 152h60q8 0 8 8v704q0 8-8 8h-60q-8 0-8-8V160q0-8 8-8z"></path>
                                          <path d="M176 474h672q8 0 8 8v60q0 8-8 8H176q-8 0-8-8v-60q0-8 8-8z"></path></svg
                                      ></span>
                                      <p>
                                        <span class="B1Y9hxs9"
                                          >绑定银行卡<span class="_2QjkbEbY">可绑定银行卡({{ 5 - cardLis.length }}/5)</span></span
                                        >
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="_1pDMxc1H _219g769H">
                          <div class="ant-row ant-form-item">
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input"><div class="ant-form-item-control-input-content"></div></div>
                            </div>
                          </div>
                        </div>
                        <div class="_1pDMxc1H">
                          <div class="ant-row ant-form-item" style="flex: 0 0 auto">
                            <div class="ant-col ant-form-item-label">
                              <label for="money" class="" title="打码量">打码量</label>
                            </div>
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input">
                                <div class="ant-form-item-control-input-content">
                                  <input autocomplete="off" class="ant-input _3ON7kyGT" placeholder="打码量" id="money" type="text" v-model="betAmount" disabled />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div></div>
                        </div>
                        <div class="_1pDMxc1H">
                          <div class="ant-row ant-form-item" style="flex: 0 0 auto">
                            <div class="ant-col ant-form-item-label">
                              <label for="money" class="" title="取款金额">取款金额</label>
                            </div>
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input">
                                <div class="ant-form-item-control-input-content">
                                  <input autocomplete="off" class="ant-input _3ON7kyGT" placeholder="单笔取款金额,¥100元-¥100000元" id="money" type="number" v-model="amount" />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div></div>
                        </div>
                        <div class="_1pDMxc1H">
                          <div class="ant-row ant-form-item" style="flex: 0 0 auto">
                            <div class="ant-col ant-form-item-label">
                              <label for="money" class="" title="支付密码">支付密码</label>
                            </div>
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input">
                                <div class="ant-form-item-control-input-content">
                                  <input autocomplete="new-password" class="ant-input _3ON7kyGT" placeholder="请输入支付密码" id="money" type="password" v-model="password" />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div></div>
                        </div>

                        <div class="_1pDMxc1H">
                          <div class="ant-row ant-form-item ant-form-item-has-success">
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input">
                                <div class="ant-form-item-control-input-content">
                                  <div class="_2nKrQ25r">
                                    <!-- <div>保证金：<span class="_1Aqq6T6q">0.00</span>元</div> -->
                                    <!-- <div>您发起取款后平台将会临时冻结一定保证金，待取款完成后将返还至您的主账户中，</div>
                                    <div>在收到提款资金后请您及时确认到账，以免您的保证金被扣除！</div> -->
                                  </div>
                                  <!-- _3SkQZ6Gu 有这属性 不可点击 -->
                                  <div @click="withdraw" class="_349CzCYy xJQe3jRu aQRs03CY" style="margin-top: 19px; width: 160px"><span>立即取款</span></div>
                                  <div class="_1p4xgQvp">
                                    <div>
                                      提示：如需取款，请先转账至中心钱包，方可取款！<br />您今日剩余可提款次数为<span><span>20</span></span
                                      >次，可提款金额为<span><span>200000</span></span
                                      >.<span><span>00</span></span
                                      >元！
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="_1euN-aP1" v-if="addShow">
                  <div class="_2v39xVwk animated animated-3 fadeIn"></div>
                  <div class="_3Pc_iCss animated animated-3 zoomIn" style="width: 700px">
                    <div class="_3DZ99c6r">
                      <span></span>
                      <div class="_3x7x8GsG">绑定银行卡</div>
                      <img
                        @click="changAddShow"
                        class="_8iC2lrZe"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAC0UExURUxpcf/////Uqv+2tv//qv///+u3o/////W8qv/Gxv/9/emwoOWunO+zouiyovC0peexneeyn+qxouWvnOWvneWwnOWunOWvnee5ouWxneaxoeSunOSunOWxpOSvneSvnPC4m+SvneWwn+SwnfXf1+avnPTe1fvw7eSunOewnuSum+mynuSunPXg2vLVzeSum//9/eSunOSunPPa0uStnfbm3/HWzfjr5vnh1vzz8f359////2ASjEAAAAA7dFJOUwD9BgcDAg0BCQT9G0cPFREkHxg6Pi5RYAsoNkxaE1VkEkIdMJAzlWpoK4AidYm6jPSWbZ9xf651HmONntaUtAAABAdJREFUeNrtlsly4kgQhgdJCMlaKe37ZmFAYDDgrXn/95qsqqRlRxSaufSlw3khQsn/qZSV2z8/9mN/ny3QJn0TNp/PFTD4wT9+UY+++6+fK7ougem6rgDim1xBH7iUxR29okuypsVxrGmyRBFf9Lp+c2ngEhPmuqTFquXUzoetavJIWABaRpdlf1CXUK/ommoVNjF+XY+flqoxAupBXoPHIJ/H6y84w1wUAF2OrYK0Q3q9XmeftapJQEC96thGO7ju0wycH5oODgFAUwuydDfpkRKeCk5YsJPVpHWTIHin+iMBhwCgSJplt27Qe6+zLwTUD0mXouPTiWUxIHbIsOm9xtyPBLg70BvsOYKNQpV1MaA23MBrsjBEgm1pYGoB+tRH7HvS3gc4FGCGZZ4/IsFRVQv0Qdpk+wf66LVnAEUcRIsMFJDn0Y1AbBvCR/WPTL/3O9eoVekOQLWXG/hvHkVVhIRhCeHzUP+wN71gIJbwFiARZfhat/PNMq+qG+E96ODzQ65/zJo0aW1VmAcQBPoN7AhlVK2raMUIr36T3fQhOwC9RSGAHqE2eBSAsK5W/LPDcsX0q9CkEYDLFVYTpix8BCeswVCIP6Xp9/ABFqa46AhI6CihWp8ulzOToj4D/ZLqMQJCgnQjlNH6sttt32gcvutlpp8i2G3S+1leXXbbw4ETHs552KSbJZnWI8Gi2WCG0QX0L88zPADPgBj1kwSoKciGMDptUc+uEDIALkCgFyYk3GWWA4DpZzwfepen4P8CLDngjUmfOeYdAGMGTAeBDJ2fRSfUvxzeHhjBqAUhECZTm6RNGJ1R/3LYnhnhSZRE4mSEA0D+4vsP2+3uRsBOO6nHcuD6ty213YVl9dhp/0ufNlh/5x2zy+lUrWZTBAwg77+0oFFfVdBboDBP6/Wtw/BiBIJ4sjhf9au8DMFKXtwjAfuJqKFgHaC+DM3G9xszo4iRgB1N1NJ4Xzf3qM8aL+263vNpfxi73CceQZyCkAHlEfV+GiSu6256JET5HkcbACbaeoT9z+83g0GIsYS2TAlRlPOJ8xFLyuRgeb4emT5ZksKyahiYQIBA5HlovsJ4x8EyMdqiMuN6R4W1xLIhNdnEC+Fxmk6NNsKGIFjjdbR/QfHoMu+0/LnvBe794UrHAp3ivu+lgduy/ge7Fe+Tmx6e+ynEhdT3ZiObw0nQ9V2QDAb2T94n0dEHGwYWz0a+yCzdJHGHlhSox05Ldx/01CyZxUsaEIjRtgaBuY79H9C4fhHDoB7QA1lUTAqNl+UURVFbaoz63wRw1dxFI7O4t2jCralg2rgmIuGba2JVhV2VmqSjflxV0QeuqcY6ZysxW6m/l/yCIm6+xfS6jyZyoefH/oD9C6i3ptIfvSpmAAAAAElFTkSuQmCC"
                        alt=""
                      />
                    </div>
                    <div class="n8VMb-cz">
                      <div class="ant-spin-nested-loading">
                        <div class="ant-spin-container">
                          <form class="ant-form ant-form-horizontal">
                            <div class="_1pDMxc1H iLNFmffG">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="real_name" class="" title="姓名">姓名</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入姓名" id="real_name" v-model="cardInfo.bank_owner" style="width: 220px" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="_3RKaxxFo">为了您的资金能迅速到账，请确保填写的姓名和银行卡的开户姓名一致；目前仅支持中文、英文和“·”</div>
                            </div>

                            <div class="_1pDMxc1H iLNFmffG">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="bank_name" class="" title="银行名称">银行名称</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <div class="ant-select ant-selects _32SoV0oI ant-select-single ant-select-show-arrow ant-select-show-search" style="width: 220px; position: relative">
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
                                              value=""
                                              style="opacity: 0"
                                            /> </span
                                          ><span class="ant-select-selection-placeholder">请选择银行名称</span>
                                        </div>
                                        <span class="ant-select-arrow" unselectable="on" aria-hidden="true" style="user-select: none"
                                          ><span role="img" aria-label="down" class="anticon anticon-down">
                                            <svg viewBox="64 64 896 896" focusable="false" data-icon="down" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                              <path d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path>
                                            </svg> </span
                                        ></span>
                                        <div class="ant-select-dropdown ant-select-dropdown-placement-bottomLeft ant-select-dropdown-hidden" style="min-width: 220px; width: 220px; left: 0; top: 42px">
                                          <div>
                                            <div class="" style="max-height: 256px; overflow-y: auto; overflow-anchor: none">
                                              <div>
                                                <div class="list lists" style="display: flex; flex-direction: column">
                                                  <!-- ant-select-item-option-active -->
                                                  <div class="ant-select-item ant-select-item-option" v-for="(item, index) in banklist" :key="index">
                                                    <div class="ant-select-item-option-content ant-select-item-option-content1">{{ item.bank_name }}</div>
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
                            </div>
                            <div class="_1pDMxc1H iLNFmffG">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="bank_name" class="" title="开户行地址">开户行地址</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入开户行" id="real_name" v-model="cardInfo.bank_address" style="width: 220px" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="_1pDMxc1H iLNFmffG">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="bank_card" class="" title="卡号">卡号</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入银行卡号" id="bank_card" v-model="cardInfo.bank_no" style="width: 220px" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="_1pDMxc1H iLNFmffG">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="bank_card" class="" title="支付密码">支付密码</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="new-password" class="ant-input _3ON7kyGT" type="password" placeholder="请输入支付密码" id="bank_card" v-model="cardInfo.pay_pass" style="width: 220px" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="_1QgODINo">请认真校对银行卡号，卡号错误将导致资金无法到账。经过云加密的银行卡系统，全面保障您的用卡安全</div>
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <div class="_349CzCYy xJQe3jRu _3jxa2p2I" @click="bindCard"><span>绑定银行卡</span></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- 虚拟币取款 -->
            <div role="tabpanel" aria-hidden="false" tabindex="0" class="ant-tabs-tabpane ant-tabs-tabpane-active" style="visibility: visible">
              <div class="_1hzDzc7i">
                <div class="_21o37iEs" v-if="usdssLis.length == 0">
                  <img src="/static/image/ill_norecord_day-b111.png" alt="" />
                  <div class="HzjbFc_d">您还没绑定USDT地址，为了您的资金安全，绑定USDT地址时，需要您仔细核对</div>
                  <div class="_349CzCYy xJQe3jRu" style="width: 150px" @click="changAddShow1"><span>去绑定</span></div>
                </div>
                <div class="ant-spin-nested-loading" v-if="usdssLis.length > 0">
                  <div class="ant-spin-container">
                    <form class="ant-form ant-form-horizontal _2ABMlQ45">
                      <div style="margin-top: 15px; margin-left: 7px">
                        <div class="_1pDMxc1H _219g769H">
                          <div class="ant-row ant-form-item">
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input"><div class="ant-form-item-control-input-content"></div></div>
                            </div>
                          </div>
                        </div>
                        <div class="_1pDMxc1H iLNFmffG">
                          <div class="ant-row ant-form-item">
                            <div class="ant-col ant-form-item-label">
                              <label for="bank_name" class="" title="USDT地址">USDT地址</label>
                            </div>
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input">
                                <div class="ant-form-item-control-input-content">
                                  <div class="ant-select ant-usdt _32SoV0oI ant-select-single ant-select-show-arrow ant-select-show-search" style="width: 220px; position: relative">
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
                                          value=""
                                          style="opacity: 0"
                                        /> </span
                                      ><span class="ant-select-selection-placeholder">请选择USDT地址</span>
                                    </div>
                                    <span class="ant-select-arrow" unselectable="on" aria-hidden="true" style="user-select: none"
                                      ><span role="img" aria-label="down" class="anticon anticon-down">
                                        <svg viewBox="64 64 896 896" focusable="false" data-icon="down" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                          <path d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path>
                                        </svg> </span
                                    ></span>
                                    <div class="ant-select-dropdown ant-select-dropdown-placement-bottomLeft ant-select-dropdown-hidden" style="min-width: 220px; width: 220px; left: 0; top: 42px">
                                      <div>
                                        <div class="" style="max-height: 256px; overflow-y: auto; overflow-anchor: none">
                                          <div>
                                            <div class="list list-usdg" style="display: flex; flex-direction: column">
                                              <!-- ant-select-item-option-active -->
                                              <div class="ant-select-item ant-select-item-option" v-for="(item, index) in usdssLis" :key="index">
                                                <div class="ant-select-item-option-content ant-select-item-option-contents" style="height: auto; display: block; word-wrap: break-word; white-space: normal; width: 200px; overflow: auto" @click="changBankId(item.id, item.bank_owner)">
                                                  {{ item.bank_owner }}-{{ item.bank_no }}
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
                          </div>
                          <div class="_3RKaxxFo" @click="changAddShow1" style="display: flex; align-items: center; color: red; cursor: pointer">新增USDT地址</div>
                        </div>
                                <div class="_1pDMxc1H">
                          <div class="ant-row ant-form-item" style="flex: 0 0 auto">
                            <div class="ant-col ant-form-item-label">
                              <label for="money" class="" title="打码量">打码量</label>
                            </div>
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input">
                                <div class="ant-form-item-control-input-content">
                                  <input autocomplete="off" class="ant-input _3ON7kyGT" placeholder="打码量" id="money" type="text" v-model="betAmount" disabled />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div></div>
                        </div>
                        <div class="_1pDMxc1H">
                          <div class="ant-row ant-form-item" style="flex: 0 0 auto">
                            <div class="ant-col ant-form-item-label">
                              <label for="money" class="" title="取款金额">取款金额</label>
                            </div>
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input">
                                <div class="ant-form-item-control-input-content">
                                  <input autocomplete="off" class="ant-input _3ON7kyGT" placeholder="单笔取款金额,¥100元-¥100000元" id="money" type="number" v-model="amount" />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div></div>
                        </div>
                        <div class="_1pDMxc1H">
                          <div class="ant-row ant-form-item" style="flex: 0 0 auto">
                            <div class="ant-col ant-form-item-label">
                              <label for="money" class="" title="支付密码">支付密码</label>
                            </div>
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input">
                                <div class="ant-form-item-control-input-content">
                                  <input autocomplete="new-password" class="ant-input _3ON7kyGT" placeholder="请输入支付密码" id="money" type="password" v-model="password" />
                                </div>
                              </div>
                            </div>
                          </div>
                          <div></div>
                        </div>

                        <div class="_1pDMxc1H">
                          <div class="ant-row ant-form-item ant-form-item-has-success">
                            <div class="ant-col ant-form-item-control">
                              <div class="ant-form-item-control-input">
                                <div class="ant-form-item-control-input-content">
                                  <div class="_2nKrQ25r">
                                    <!-- withdrawcashfee  ERC20    withdrawfeeusdttrc  提款手续费 （TRC20） -->
                                    <div v-if="chanmeyXi">每笔手续费：{{ chanmeyXi == 'ERC20' ? $store.state.userInfo.withdrawcashfee : $store.state.userInfo.withdrawfeeusdttrc }} USDT</div>
                                    <div>USDT换算：≈ {{ amount ? Math.floor((amount / $store.state.userInfo.withdrawusdtrate) * 100) / 100 : '0.00' }} USDT 参考汇率：{{ $store.state.userInfo.withdrawusdtrate }}</div>
                                    <div>
                                      实际到账：<span class="_1Aqq6T6q">{{ amount ? Math.floor((amount / $store.state.userInfo.withdrawusdtrate) * 100) / 100 - (chanmeyXi == 'ERC20' ? $store.state.userInfo.withdrawcashfee * 1 : $store.state.userInfo.withdrawfeeusdttrc * 1) : '0.00' }} </span>USDT
                                    </div>
                                  </div>
                                  <div @click="withdraw1" class="_349CzCYy xJQe3jRu aQRs03CY" style="margin-top: 19px; width: 160px"><span>立即取款</span></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="_1euN-aP1" v-if="addShow1">
                  <div class="_2v39xVwk animated animated-3 fadeIn"></div>
                  <div class="_3Pc_iCss animated animated-3 zoomIn" style="width: 700px">
                    <div class="_3DZ99c6r">
                      <span></span>
                      <div class="_3x7x8GsG">绑定USDT地址</div>
                      <img
                        @click="changAddShow1"
                        class="_8iC2lrZe"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAC0UExURUxpcf/////Uqv+2tv//qv///+u3o/////W8qv/Gxv/9/emwoOWunO+zouiyovC0peexneeyn+qxouWvnOWvneWwnOWunOWvnee5ouWxneaxoeSunOSunOWxpOSvneSvnPC4m+SvneWwn+SwnfXf1+avnPTe1fvw7eSunOewnuSum+mynuSunPXg2vLVzeSum//9/eSunOSunPPa0uStnfbm3/HWzfjr5vnh1vzz8f359////2ASjEAAAAA7dFJOUwD9BgcDAg0BCQT9G0cPFREkHxg6Pi5RYAsoNkxaE1VkEkIdMJAzlWpoK4AidYm6jPSWbZ9xf651HmONntaUtAAABAdJREFUeNrtlsly4kgQhgdJCMlaKe37ZmFAYDDgrXn/95qsqqRlRxSaufSlw3khQsn/qZSV2z8/9mN/ny3QJn0TNp/PFTD4wT9+UY+++6+fK7ougem6rgDim1xBH7iUxR29okuypsVxrGmyRBFf9Lp+c2ngEhPmuqTFquXUzoetavJIWABaRpdlf1CXUK/ommoVNjF+XY+flqoxAupBXoPHIJ/H6y84w1wUAF2OrYK0Q3q9XmeftapJQEC96thGO7ju0wycH5oODgFAUwuydDfpkRKeCk5YsJPVpHWTIHin+iMBhwCgSJplt27Qe6+zLwTUD0mXouPTiWUxIHbIsOm9xtyPBLg70BvsOYKNQpV1MaA23MBrsjBEgm1pYGoB+tRH7HvS3gc4FGCGZZ4/IsFRVQv0Qdpk+wf66LVnAEUcRIsMFJDn0Y1AbBvCR/WPTL/3O9eoVekOQLWXG/hvHkVVhIRhCeHzUP+wN71gIJbwFiARZfhat/PNMq+qG+E96ODzQ65/zJo0aW1VmAcQBPoN7AhlVK2raMUIr36T3fQhOwC9RSGAHqE2eBSAsK5W/LPDcsX0q9CkEYDLFVYTpix8BCeswVCIP6Xp9/ABFqa46AhI6CihWp8ulzOToj4D/ZLqMQJCgnQjlNH6sttt32gcvutlpp8i2G3S+1leXXbbw4ETHs552KSbJZnWI8Gi2WCG0QX0L88zPADPgBj1kwSoKciGMDptUc+uEDIALkCgFyYk3GWWA4DpZzwfepen4P8CLDngjUmfOeYdAGMGTAeBDJ2fRSfUvxzeHhjBqAUhECZTm6RNGJ1R/3LYnhnhSZRE4mSEA0D+4vsP2+3uRsBOO6nHcuD6ty213YVl9dhp/0ufNlh/5x2zy+lUrWZTBAwg77+0oFFfVdBboDBP6/Wtw/BiBIJ4sjhf9au8DMFKXtwjAfuJqKFgHaC+DM3G9xszo4iRgB1N1NJ4Xzf3qM8aL+263vNpfxi73CceQZyCkAHlEfV+GiSu6256JET5HkcbACbaeoT9z+83g0GIsYS2TAlRlPOJ8xFLyuRgeb4emT5ZksKyahiYQIBA5HlovsJ4x8EyMdqiMuN6R4W1xLIhNdnEC+Fxmk6NNsKGIFjjdbR/QfHoMu+0/LnvBe794UrHAp3ivu+lgduy/ge7Fe+Tmx6e+ynEhdT3ZiObw0nQ9V2QDAb2T94n0dEHGwYWz0a+yCzdJHGHlhSox05Ldx/01CyZxUsaEIjRtgaBuY79H9C4fhHDoB7QA1lUTAqNl+UURVFbaoz63wRw1dxFI7O4t2jCralg2rgmIuGba2JVhV2VmqSjflxV0QeuqcY6ZysxW6m/l/yCIm6+xfS6jyZyoefH/oD9C6i3ptIfvSpmAAAAAElFTkSuQmCC"
                        alt=""
                      />
                    </div>
                    <div class="n8VMb-cz">
                      <div class="ant-spin-nested-loading">
                        <div class="ant-spin-container">
                          <form class="ant-form ant-form-horizontal">
                            <div class="_1pDMxc1H iLNFmffG">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="real_name" class="" title="USDT地址">USDT地址</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入USDT地址" id="real_name" v-model="usdss" style="width: 220px" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="_3RKaxxFo">为了您的资金能到账，请确保地址填写正确</div>
                            </div>
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
                            <div class="_1pDMxc1H iLNFmffG">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-label">
                                  <label for="bank_card" class="" title="支付密码">支付密码</label>
                                </div>
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <input autocomplete="new-password" class="ant-input _3ON7kyGT" type="password" placeholder="请输入支付密码" id="bank_card" v-model="pay_pass" style="width: 220px" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="_1QgODINo">请认真校对地址内容，地址错误讲导致资金无法到账，经过云加密的安全系统，全面保障您的财务安全</div>
                            <div class="_1pDMxc1H">
                              <div class="ant-row ant-form-item">
                                <div class="ant-col ant-form-item-control">
                                  <div class="ant-form-item-control-input">
                                    <div class="ant-form-item-control-input-content">
                                      <div class="_349CzCYy xJQe3jRu _3jxa2p2I" @click="bindUsdss"><span>绑定USDT地址</span></div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
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
  </div>
</template>
<script>
export default {
  name: 'withdrawal',
  data() {
    return {
      cardLis: [],
      addShow: false,
      cardInfo: {},
      bank: null,
      bankId: null,
      amount: null,
      password: null,
      banklist: [],
      usdssLis: [],
      lodingShow: true,
      meyXi: 'ERC20', //qian
      chanmeyXi: null,
      ctype: 0,
      addShow1: false,
      usdss: null,
      pay_pass: null,
      baseURL: '',
      betAmount: null,
    };
  },
  created() {
    let that = this;
    that.baseURL = sessionStorage.getItem('baseURL') || '';
    that.getBetAmount();

    that.getcard();
    that.getBanklist();
    that.getUsdssList();
  },
  methods: {
    getBetAmount() {
      let that = this;
      that.$apiFun
        .post('/api/getBetAmount', {})
        .then(res => {
          if (res.code == 200) {
            that.betAmount = res.data.bet_amount;
          }
        })
        .catch(res => {});
    },
    // 钱包协议的选择
    changMeyXi(val) {
      let that = this;
      this.meyXi = val;
    },
    changType(val) {
      let that = this;
      if (this.ctype == val) {
        return;
      }
      this.ctype = val;
      this.amount = null;
      this.pay_pass = null;
      this.password = null;
      this.chanmeyXi = null;

      $('.ant-select-selection-placeholder').text('请选择内容');
    },
    changBankId(id, chanmeyXi) {
      let that = this;
      that.bankId = id;
      that.chanmeyXi = chanmeyXi;
    },
    getBanklist() {
      let that = this;
      that.$apiFun.post('/api/banklist', {}).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.banklist = res.data;
        }
      });
    },
    getcard() {
      let that = this;
      that.showloading();
      that.$apiFun
        .post('/api/getcard', { type: 1 })
        .then(res => {
          if (res.code != 200) {
            that.showTost(res.message);
          }
          if (res.code == 200) {
            that.cardLis = res.data;
            if (res.data.length > 0) {
              that.bankId = res.data[0].id;
            }
            that.hideloading();
          }
        })
        .catch(res => {
          that.showTost('网络连接错误！');
          that.hideloading();
        });
    },
    getUsdssList() {
      let that = this;
      that.$apiFun.post('/api/getcard', { type: 2 }).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.usdssLis = res.data;
        }
      });
    },
    changAddShow() {
      let that = this;
      that.addShow = !that.addShow;
      that.cardInfo = {};
      $('.ant-select-selection-placeholder').text('请选择内容');
    },
    changAddShow1() {
      let that = this;
      that.addShow1 = !that.addShow1;
      that.usdss = null;
      $('.ant-select-selection-placeholder').text('请选择内容');
    },
    withdraw() {
      let that = this;
      // amount	是	float	金额
      // bank	是	int	提现银行卡id
      let bank = that.bankId;
      let amount = that.amount;
      let password = that.password;

      if (amount < 100) {
        that.showTost('单笔取款不能低于100元');
        return;
      }
      if (!bank) {
        that.showTost('请选择您要提现到的银行卡');
        return;
      }
      if (!password) {
        that.showTost('请输入您的支付密码');
        return;
      }
      that.showloading();
      that.$apiFun
        .post('/api/withdraw', { amount, bank, password })
        .then(res => {
          if (res.code != 200) {
            that.showTost(res.message);
          }
          if (res.code == 200) {
            that.showTost('提交成功，等待后台审核');
            that.getcard();
            that.addShow = false;
            that.amount = null;
            that.password = null;
            that.bank = null;
            setTimeout(() => {
              that.$router.push({ path: '/mine/transRecord' });
            }, 1500);
          }
          that.hideloading();
        })
        .catch(res => {
          that.showTost('网络连接错误！');
          that.hideloading();
        });
    },
    withdraw1() {
      let that = this;
      // amount	是	float	金额
      // bank	是	int	提现银行卡id
      let bank = that.bankId;
      let amount = that.amount;
      let password = that.password;
      if (!bank) {
        that.showTost('请选择USDT地址');
        return;
      }
      if (amount < 100) {
        that.showTost('单笔取款不能低于100元');
        return;
      }

      if (!password) {
        that.showTost('请输入您的支付密码');
        return;
      }
      that.showloading();
      that.$apiFun
        .post('/api/withdraw', { amount, bank, password })
        .then(res => {
          if (res.code != 200) {
            that.showTost(res.message);
          }
          if (res.code == 200) {
            that.showTost('提交成功，等待后台审核');
            that.getcard();
            that.addShow = false;

            that.chanmeyXi = null;
            that.amount = null;
            that.password = null;
            that.bank = null;
            setTimeout(() => {
              that.$router.push({ path: '/mine/transRecord' });
            }, 1500);
          }
          that.hideloading();
        })
        .catch(res => {
          that.hideloading();
        });
    },
    bindUsdss() {
      let that = this;
      let usdss = that.usdss;
      let meyXi = that.meyXi;

      if (usdss == null || usdss == '') {
        that.showTost('请输入USDT地址');
        return;
      }
      if (!meyXi) {
        that.showTost('请选择钱包协议');
        return;
      }
      if (!that.pay_pass) {
        that.showTost('请输入支付密码');
        return;
      }
      that.showloading();
      that.$apiFun
        .post('/api/bindcard', { bank: 'USDT', bank_no: usdss, bank_owner: meyXi, pay_pass: that.pay_pass })
        .then(res => {
          if (res.code != 200) {
            that.showTost(res.message);
          }
          if (res.code == 200) {
            that.showTost('提交成功，等待后台审核');
            that.getUsdssList();
            that.addShow1 = false;
          }
          that.hideloading();
        })
        .catch(res => {
          that.hideloading();
        });
    },
    bindCard() {
      let that = this;
      that.cardInfo.bank = that.bank;
      if (!that.cardInfo.bank_owner) {
        that.showTost('请输入姓名');
        return;
      }
      if (!that.cardInfo.bank) {
        that.showTost('请输入银行');
        return;
      }
      if (!that.cardInfo.bank_address) {
        that.showTost('请输入开户行地址');
        return;
      }
      if (!that.cardInfo.bank_no) {
        that.showTost('请输入银行卡号');
        return;
      }
      if (!that.cardInfo.pay_pass) {
        that.showTost('请输入支付密码');
        return;
      }
      if (that.cardInfo.bank_no.length < 8) {
        that.showTost('请输入正确的卡号长度');
        return;
      }
      if (that.cardInfo.pay_pass.length < 6 || that.cardInfo.pay_pass.length > 18) {
        that.showTost('请输入支付密码长度');
        return;
      }
      that.showloading();
      that.$apiFun
        .post('/api/bindcard', that.cardInfo)
        .then(res => {
          if (res.code != 200) {
            that.showTost(res.message);
          }
          if (res.code == 200) {
            that.showTost('绑定成功');
            that.getcard();
            that.addShow = false;
          }
          that.hideloading();
        })
        .catch(res => {
          that.hideloading();
        });
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

    hideloading() {
      this.lodingShow = false;
    },
    showloading() {
      this.lodingShow = true;
    },
  },
  mounted() {
    // --------  取款------------------------------------------------------------------
    //公告弹窗
    function openGonggao() {
      $('.office-modal-container').show();
      $('.office-modal-container ._1euN-aP1').show();
    }
    //绑定银行卡弹窗
    function openBank() {
      $('._1euN-aP1').show();
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
    var m2daconfig = laydate.render({
      elem: '.datepicker',
      eventElem: '.person_date_input',
      theme: 'type-ym',
      trigger: 'click',
      btns: [],
      type: 'date',
    });
  },
  updated() {
    let that = this;
    //弹出银行列表
    $('.ant-selects')
      .unbind('click')
      .click(function (e) {
        $(this).find('.ant-select-dropdown').slideToggle(200);
      });
    //选择银行
    $('.lists .ant-select-item')
      .unbind('click')
      .click(function () {
        $(this).addClass('ant-select-item-option-active').siblings().removeClass('ant-select-item-option-active');
        var text = $(this).find('.ant-select-item-option-content').text();
        that.bank = text;
        $('.ant-select-selection-search-input').attr('value', text);
        $('.ant-select-selection-placeholder').text(text).addClass('ant-select-selection-item');
      });

    $('.ant-usdt')
      .unbind('click')
      .click(function (e) {
        $(this).find('.ant-select-dropdown').slideToggle(200);
      });
    //选择银行
    $('.list-usdg .ant-select-item')
      .unbind('click')
      .click(function () {
        $(this).addClass('ant-select-item-option-active').siblings().removeClass('ant-select-item-option-active');
        var text = $(this).find('.ant-select-item-option-content').text();
        that.bank = text;
        $('.ant-select-selection-search-input').attr('value', text);
        $('.ant-select-selection-placeholder').text(text).addClass('ant-select-selection-item');
      });
  },
};
</script>
<style lang="scss" scoped>
.layui-laydate-footer {
  display: none;
}
</style>
