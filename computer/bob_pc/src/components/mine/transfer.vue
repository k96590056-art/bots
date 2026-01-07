<template>
  <div class="ant-spin-nested-loading">
    <div class="loading" v-if="lodingShow">
      <div class="ant-spin ant-spin-spinning _2PSsJSST">
        <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
      </div>
    </div>
    <div :class="lodingShow ? 'ant-spin-container ant-spin-blur' : 'ant-spin-container'">
      <div class="_2i9-Qvs8">
        <div class="ant-spin-container">
          <form class="ant-form ant-form-horizontal DV6kcvQI">
            <div class="_4ICMeQUV">
              <div class="T5pPAuRQ">转账<span>场馆钱包之间不可以互转。当您开启免转钱包时，每个场馆无需转账即可畅玩。</span></div>
              <div class="_3As_wNPm">
                <span class="_2I0IgJOg">免转钱包</span>
                <div class="ant-spin-nested-loading">
                  <div class="ant-spin-container">
                    <!-- <div class="_2AeMNme1 _2WDU2ivR"> -->
                    <!-- 0 转账 1免转 -->

                    <div :class="$store.state.userInfo.transferstatus == 1 ? '_2AeMNme1 _2WDU2ivR' : '_2AeMNme1 '">
                      <div class="_1_oYuS9O"></div>
                      <!-- 0 转账 1免转 -->
                      <div class="_2qDuOeWT">{{ $store.state.userInfo.transferstatus == 0 ? '关' : '开' }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="_3AwqQ9Nt">
              <div class="_3uhGlsJA">主账户</div>
              <div class="_222AIEz7">¥{{ $store.state.userInfo.balance }}元</div>
              <div class="wEDAX4ja">
                <img
                  src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAcCAMAAABBJv+bAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAABvUExURUxpcdqagdiWgNeWgP/dltiXgOCnh9eWgNiXgNiWf9ybh9eXf9iWgNeWgNeWgNiXgNeWf9eWf9iWgNiXgNmZgdmZgdeWgNeWgNiXf9eWgNqbf9iWf9eXf9eWf9eWf9iWgd+ff9iYf9eXf9iWf9eWf00yFsAAAAAkdFJOUwAqxvwCTwj3QfMOZ+CquWyxwH6PLzbc54XRG5qhetZHGFxgePmWBHcAAADtSURBVHjafZPbroMgEEVHRblYb1XRVq09Pfv/v7GxCYHo6HohZIUJsxnIIVQb3+TwqvMnHRD5AEdSRDvbvQBZ5GvXp+MDSO4itKmGXjK3Uw1QZoFNEL8poJKBjzQKt3EFJCZ3qwdiZ31BYKUff9BMKxOs+B22uNMRo5Fuaw9piKFFuS0jakZGi4I05UQNckbPaDRiWLJQjO4lNlLSCBMOowJmOtNUAYMhV/zIctuEuxqLb4zHx8LjQ+Xhn6QqzcWDfoDuYhwStKfDJP4T1OJkFMXaAHW2H2S9DbL6jBaQ1cU3kHPkxe4TxUUVpvQFhcEU/UFvXFcAAAAASUVORK5CYII="
                  alt=""
                />刷新
              </div>
              <div class="g0QdLp5Y">一键回收</div>
              <div class="_1thJMFup">
                <b>游戏余额</b><i>¥{{ $store.state.userInfo.gameblance }}</i
                >元<em></em>
              </div>
              <div class="_1thJMFup">
                <!-- <b>可领取红利</b><i>¥{{ $store.state.userInfo.fanshui }}</i
              >元 -->
                <em class="_1-tG2KDV" @click="goNav('/mine/boonCenter')">前往领取福利 &gt;</em>
              </div>
            </div>
            <!-- <div class="TvaHBjGU" v-if="$store.state.userInfo.transferstatus == 0"> -->
            <div class="TvaHBjGU" v-if="false">
              <div class="_1pDMxc1H">
                <div class="ant-row ant-form-item">
                  <div class="ant-col ant-form-item-control">
                    <div class="ant-form-item-control-input">
                      <div class="ant-form-item-control-input-content">
                        <div class="ant-select _32SoV0oI ant-select-single ant-select-show-arrow ant-select-show-search" style="width: 185px">
                          <div class="ant-select-selector">
                            <span class="ant-select-selection-search">
                              <input
                                id="transfer_out"
                                autocomplete="off"
                                class="ant-select-selection-search-input"
                                role="combobox"
                                aria-haspopup="listbox"
                                aria-owns="transfer_out_list"
                                aria-autocomplete="list"
                                aria-controls="transfer_out_list"
                                aria-activedescendant="transfer_out_list_0"
                                readonly=""
                                unselectable="on"
                                value=""
                                style="opacity: 0"
                              /> </span
                            ><span class="ant-select-selection-item transfer_out"></span>
                          </div>
                          <span class="ant-select-arrow" unselectable="on" aria-hidden="true" style="user-select: none"
                            ><span role="img" aria-label="down" class="anticon anticon-down">
                              <svg viewbox="64 64 896 896" focusable="false" data-icon="down" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                <path d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path>
                              </svg> </span
                          ></span>
                          <div class="ant-select-dropdown ant-select-dropdown-placement-bottomLeft ant-select-dropdown-hidden" style="min-width: 184px; width: 184px; left: 0; top: 42px">
                            <div>
                              <div role="listbox" id="rc_select_10_list" style="height: 0px; width: 0px; overflow: hidden">
                                <div aria-label="全部" role="option" id="rc_select_10_list_0" aria-selected="true"></div>
                                <div aria-label="未领取" role="option" id="rc_select_10_list_1" aria-selected="false">3</div>
                              </div>
                              <div class="" style="max-height: 256px; overflow-y: auto; overflow-anchor: none">
                                <div>
                                  <div class="list_out" style="display: flex; flex-direction: column">
                                    <div @click="changVal('lfVal', 'userbalance')" :class="lfVal == 'userbalance' ? 'ant-select-item ant-select-item-option ant-select-item-option-selected' : 'ant-select-item ant-select-item-option '">
                                      <div class="ant-select-item-option-content">中心钱包</div>
                                    </div>
                                    <div @click="changVal('lfVal', item.platname)" :class="lfVal == item.platname ? 'ant-select-item ant-select-item-option ant-select-item-option-selected' : 'ant-select-item ant-select-item-option '" v-for="(item, index) in balancelist" :key="index">
                                      <div class="ant-select-item-option-content">{{ item.name }}</div>
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
              <img
                @click="changLfOrRg"
                src="data:image/png;base64,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"
                class="_1FGdtVxx"
                alt=""
              />
              <div class="_1pDMxc1H">
                <div class="ant-row ant-form-item">
                  <div class="ant-col ant-form-item-control">
                    <div class="ant-form-item-control-input">
                      <div class="ant-form-item-control-input-content">
                        <div class="ant-select _32SoV0oI ant-select-single ant-select-show-arrow ant-select-show-search" style="width: 185px">
                          <div class="ant-select-selector">
                            <span class="ant-select-selection-search">
                              <input
                                id="transfer_in"
                                autocomplete="off"
                                class="ant-select-selection-search-input"
                                role="combobox"
                                aria-haspopup="listbox"
                                aria-owns="transfer_in_list"
                                aria-autocomplete="list"
                                aria-controls="transfer_in_list"
                                aria-activedescendant="transfer_in_list_0"
                                readonly=""
                                unselectable="on"
                                value=""
                                style="opacity: 0"
                              /> </span
                            ><span class="ant-select-selection-item transfer_in"></span>
                          </div>
                          <span class="ant-select-arrow" unselectable="on" aria-hidden="true" style="user-select: none"
                            ><span role="img" aria-label="down" class="anticon anticon-down">
                              <svg viewbox="64 64 896 896" focusable="false" data-icon="down" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                <path d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path>
                              </svg> </span
                          ></span>
                          <div class="ant-select-dropdown ant-select-dropdown-placement-bottomLeft ant-select-dropdown-hidden" style="min-width: 184px; width: 184px; left: 0; top: 42px">
                            <div>
                              <div role="listbox" id="rc_select_10_list" style="height: 0px; width: 0px; overflow: hidden">
                                <div aria-label="全部" role="option" id="rc_select_10_list_0" aria-selected="true"></div>
                                <div aria-label="未领取" role="option" id="rc_select_10_list_1" aria-selected="false">3</div>
                              </div>
                              <div class="" style="max-height: 256px; overflow-y: auto; overflow-anchor: none">
                                <div>
                                  <div class="list_in" style="display: flex; flex-direction: column">
                                    <div @click="changVal('rgVal', 'userbalance')" :class="rgVal == 'userbalance' ? 'ant-select-item ant-select-item-option ant-select-item-option-selected' : 'ant-select-item ant-select-item-option '">
                                      <div class="ant-select-item-option-content">中心钱包</div>
                                    </div>
                                    <div @click="changVal('rgVal', item.platname)" :class="rgVal == item.platname ? 'ant-select-item ant-select-item-option ant-select-item-option-selected' : 'ant-select-item ant-select-item-option '" v-for="(item, index) in balancelist" :key="index">
                                      <div class="ant-select-item-option-content">{{ item.name }}</div>
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
              <div class="_1pDMxc1H _2hx3M_SZ">
                <div class="ant-row ant-form-item">
                  <div class="ant-col ant-form-item-label">
                    <label for="money" class="" title="转账金额">转账金额</label>
                  </div>
                  <div class="ant-col ant-form-item-control">
                    <div class="ant-form-item-control-input">
                      <div class="ant-form-item-control-input-content">
                        <input autocomplete="off" class="ant-input _3ON7kyGT" type="number" placeholder="请输入金额" id="money" v-model="payMey" style="width: 154px" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="_349CzCYy xJQe3jRu _2qF4OsAr" @click="oneIsOk"><span>确认转账</span></div>
            </div>
            <ul class="_2t1-MPZv">
              <li v-for="(item, index) in balancelist" :key="index">
                <div v-if="$store.state.userInfo.transferstatus == 1" style="height: 20px"></div>
                <div class="y_2iDbFt">{{ item.name }}</div>
                <div class="vdVlICI6">
                  余额<span>{{ item.balance }}</span
                  >元
                </div>
                <!-- {{ $store.state.userInfo.transferstatus == 0 ? '开' : '关' }} -->
                <div class="_1MOlxztA" v-if="$store.state.userInfo.transferstatus == 0" @click="oneUpdate(item)">额度转换</div>
              </li>
            </ul>
          </form>
        </div>

        <!-- 弹窗 -->
        <div class="_1euN-aP1" v-if="show">
          <div class="_2v39xVwk animated animated-3 fadeIn"></div>
          <div class="_3Pc_iCss animated animated-3 zoomIn" style="width: 700px">
            <div class="_3DZ99c6r">
              <span></span>
              <div class="_3x7x8GsG">额度转换</div>
              <img
                @click="hideShow"
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
                        <div class="ant-col ant-form-item-label"><label for="real_name" class="" title="中心钱包">中心钱包</label></div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content"><input class="ant-input ant-input-disabled _3ON7kyGT" disabled type="text" :value="$store.state.userInfo.balance" style="width: 220px" /></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="_1pDMxc1H iLNFmffG">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="bank_name" class="" :title="oneInfo.name">{{ oneInfo.name }}</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content"><input class="ant-input ant-input-disabled _3ON7kyGT" disabled type="text" :value="oneInfo.balance" style="width: 220px" /></div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="_1pDMxc1H iLNFmffG">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="bank_name" class="" title="操作金额">操作金额 </label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content"><input class="ant-input _3ON7kyGT" type="number" v-model="amount" style="width: 220px" /></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="_1pDMxc1H iLNFmffG">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label"><label for="bank_card" class="" title="转账方式">转账方式</label></div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <div class="ant-col ant-form-item-control">
                                <div class="ant-form-item-control-input">
                                  <div class="ant-form-item-control-input-content">
                                    <div class="ant-spin-nested-loading">
                                      <div class="ant-spin-container">
                                        <ul class="_2tZRPt8E">
                                          <li :class="payType == 0 ? 'd1qCTAjZ' : ''" @click="changVal('payType', 0)">转入</li>
                                          <li :class="payType == 1 ? 'd1qCTAjZ' : ''" @click="changVal('payType', 1)">转出</li>
                                        </ul>
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
                    <div class="_1pDMxc1H">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <div class="_349CzCYy xJQe3jRu u _3jxa2p2I" @click="isOk"><span>确认操作</span></div>
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
</template>
<script>
import { mapState } from 'vuex';
export default {
  name: 'transRecord',
  data() {
    return {
      balancelist: [],
      lfVal: null,
      rgVal: null,
      amount: null,
      show: false,
      oneInfo: {},
      payType: 0,
      payMey: null,
      lodingShow: true,
      daoTime: null,
    };
  },
  computed: mapState({
    count: state => state.userInfo, //理解为传入state对象，修改state.count属性
  }),
  created() {
    let that = this;
    that.getbalancelists();
    that.daoTime = setInterval(() => {
      that.getbalancelist();
    }, 1500);

  },
  methods: {
    goNav(url) {
      let that = this;
      // let urlStr = url.split('?')[0];
      if (url == this.$route.path) {
        return;
      }
      this.url = url;
      this.$router.push({ path: url });
    },
    oneIsOk() {
      let that = this;
      if (that.lfVal == null || that.rgVal == null) {
        that.showTost('请选择要操作的平台哦！');
        return;
      }
      if (that.lfVal == that.rgVal) {
        that.showTost('不可同平台转换哦！');
        return;
      }
      if (that.payMey == null || that.payMey <= 0) {
        that.showTost('请输入正确的金额哦！');
        return;
      }
      let info = { amount: that.payMey, sourcetype: that.lfVal, targettype: that.rgVal };
      that.showloading();
      that.$apiFun.post('/api/transfer', info).then(res => {
        that.showTost(res.message);
        if (res.code === 200) {
            that.payMey = null;
            that.refreshusermoney();
            that.getbalancelist();
        }
        that.hideloading();
      }).catch(res=>{
          that.hideloading();
      });
    },
    changLfOrRg() {
      let that = this;
      let lfVal = that.rgVal + '';
      let rgVal = that.lfVal + '';
      that.lfVal = lfVal;
      that.rgVal = rgVal;
    },
    changVal(name, val) {
      let that = this;
      that[name] = val;
    },

    oneUpdate(val) {
      let that = this;
      that.oneInfo = val;
      that.show = true;
    },
    hideShow() {
      this.show = false;
      this.amount = null;
    },
    isOk() {
      let that = this;
      let info = { amount: that.amount };
      if (that.amount == null) {
        that.showTost('请输入操作金额！');
        return;
      }
      if (that.payType == 0) {
        //转入
        info.sourcetype = 'userbalance'; //sourcetype  出钱的
        info.targettype = that.oneInfo.platname; //targettype  收钱的
        console.log(that.amount);
        console.log(that.$store.state.userInfo.balance);
        if (that.amount * 1 > that.$store.state.userInfo.balance * 1) {
          that.showTost('操作金额超出了您的账户余额！');
          return;
        }
      }
      if (that.payType == 1) {
        //转出
        info.sourcetype = that.oneInfo.platname;
        info.targettype = 'userbalance';
        if (that.amount * 1 > that.oneInfo.balance * 1) {
          //
          that.showTost('操作金额超出了您该游戏平台的余额！');
          return;
        }
      }
      that.showloading()
      that.$apiFun.post('/api/transfer', info).then(res => {
        that.showTost(res.message);
        if (res.code === 200) {
          that.hideShow();
          that.showloading();
          that.refreshusermoney();
          that.getbalancelist();
          that.hideloading();
        }
        that.hideloading();
      });
    },
        getbalancelists() {
      let that = this;
      that.$apiFun.post('/api/balancelist', {}).then(res => {
        if (res.code !== 200) {
          that.showTost(res.message);
        }
        if (res.code === 200) {
          that.balancelist = res.data;
        }
        that.hideloading();
      }).catch(res=>{
          that.hideloading();
      });
    },
    getbalancelist() {
      let that = this;
      that.$apiFun.post('/api/balancelist', {}).then(res => {
        if (res.code !== 200) {
          that.showTost(res.message);
        }
        if (res.code === 200) {
          that.balancelist = res.data;
        }
      }).catch(res=>{
          that.hideloading();
      });
    },
    transall() {
      let that = this;
      that.$apiFun.post('/api/transall', {}).then(res => {
        that.showTost(res.message);
        that.refreshusermoney();
        that.hideloading();
      }).catch(res=>{
          that.hideloading();
      });
    },
    refreshusermoney() {
      let that = this;
      that.$apiFun.post('/api/refreshusermoney', {}).then(res => {
        that.hideloading();
        if (res.code == 200) {
          localStorage.setItem('userInfo', JSON.stringify(res.data));
          that.$store.commit('changUserInfo');
        }
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
    let that = this;

    //刷新
    $('.wEDAX4ja').click(function () {
      that.showloading();
      that.refreshusermoney();
      that.getbalancelist();
    });
    //一键回收
    $('.g0QdLp5Y').click(function () {
      that.showloading();
      that.transall();

    });
    //弹出下拉
    $('.ant-select').click(function () {
      $(this).find('.ant-select-dropdown').slideToggle(200);
    });

    //钱包对调
    $('._1FGdtVxx').click(function () {
      var transfer_in = $('.transfer_in').text();
      var transfer_out = $('.transfer_out').text();
      $('#transfer_in').attr('value', transfer_out);
      $('.transfer_in').text(transfer_out);
      $('#transfer_out').attr('value', transfer_in);
      $('.transfer_out').text(transfer_in);
    });

    //免转开关

    $('._2AeMNme1').click(function () {
      that.showloading();
      let userInfo = JSON.parse(localStorage.getItem('userInfo'));
      let mianzhuan = userInfo.transferstatus == 0 ? 1 : 0;

      that.$apiFun.post('/api/uptransferstatus', { transferstatus: mianzhuan }).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          userInfo.transferstatus = mianzhuan;
          localStorage.setItem('userInfo', JSON.stringify(userInfo));
          that.$store.commit('changUserInfo');
          that.showTost('操作成功！');
        }
        that.hideloading();
      }).catch(res=>{
          that.hideloading();
      });
    });
  },
  updated() {
    let that = this;
    //鼠标经过li变色
    $('.ant-select-item').hover(
      function () {
        $(this).addClass('ant-select-item-option-active');
      },
      function () {
        $(this).removeClass('ant-select-item-option-active');
      },
    );
    //选择下拉内容转出
    $('.list_out .ant-select-item').click(function () {
      $(this).addClass('ant-select-item-option-selected').siblings().removeClass('ant-select-item-option-selected');
      var text = $(this).find('.ant-select-item-option-content').text();
      $('#transfer_out').attr('value', text);
      $('.transfer_out').text(text);
    });
    //选择下拉内容转入
    $('.list_in .ant-select-item').click(function () {
      $(this).addClass('ant-select-item-option-selected').siblings().removeClass('ant-select-item-option-selected');
      var text = $(this).find('.ant-select-item-option-content').text();
      $('#transfer_in').attr('value', text);
      $('.transfer_in').text(text);
    });
  },
  beforeDestroy() {
    let that = this;
    if (that.daoTime) {
      clearInterval(that.daoTime);
    }
    that.daoTime = null;
  },
};
</script>
<style lang="scss" scoped>
</style>
