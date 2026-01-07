<template>
  <div class="ant-spin-nested-loading">
    <div class="loading" v-if="lodingShow">
      <div class="ant-spin ant-spin-spinning _2PSsJSST">
        <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
      </div>
    </div>
    <div :class="lodingShow ? 'ant-spin-container ant-spin-blur' : 'ant-spin-container'">
      <div class="_1FzIdQTG">
        <div class="_4ICMeQUV" style="border-bottom: none">
          <div class="T5pPAuRQ">消息公告</div>
        </div>
        <div class="ant-tabs ant-tabs-top CxUrt0Fb ant-tabs-line">
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
                      <div role="tab" @click="changTab(0)" aria-disabled="false" aria-selected="true" tabindex="0" :class="tanNum == 0 ? 'ant-tabs-tab-active ant-tabs-tab' : 'ant-tabs-tab'" id="tab-0" aria-controls="tabpane-0">
                        收件箱
                        <!-- <span v-if="total" class="_1YeAlL16">{{ total }}</span> -->
                      </div>
                      <!-- <div role="tab" aria-disabled="false" aria-selected="false" tabindex="-1" class="ant-tabs-tab" id="tab-1" aria-controls="tabpane-1">发件箱</div> -->
                      <div @click="changTab(1)" :class="tanNum == 0 ? 'ant-tabs-tab-active ant-tabs-tab' : 'ant-tabs-tab'" id="tab-1" aria-controls="tabpane-1">
                        意见反馈<span class="_2A5aHsDj"><span>有礼</span></span>
                      </div>
                    </div>
                    <!-- 120 -->
                    <div class="ant-tabs-ink-bar ant-tabs-ink-bar-animated" :style="`display: block; transform: translate3d(${120 * tanNum}px, 0px, 0px); width: 120px`"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="ant-tabs-content ant-tabs-content-animated ant-tabs-top-content" :style="`margin-left: ${tanNum * -100}%`">
            <div role="tabpanel" aria-hidden="false" tabindex="0" class="ant-tabs-tabpane ant-tabs-tabpane-active" style="visibility: visible">
              <div class="ant-spin-nested-loading">
                <div class="ant-spin-container">
                  <form class="ant-form ant-form-horizontal _2bnbXeXN">
                    <!-- <ul class="_1D2kUmXy">
                  <li class="">红利</li>
                  <li class="">反馈</li>
                  <li class="_3L47e6NQ">通知</li>
                  <li class="">活动</li>
                </ul> -->
                    <div class="_1sgr7KlZ" v-for="item in homenoticelist" :key="item.id">
                      <div class="_39uvhKpz">
                        <div class="_1f3LKTog">
                          <img src="/static/image/d1b5b95b433bfdf76041f9ae9a315b94269f42a6.png" alt="" />
                          <div>通知</div>
                        </div>
                        <div class="NToAey35">
                          <div class="_3gx8zoTi">
                            <span class="_1_GSPp_6">{{ item.title }}</span>
                            <div class="">
                              <span>{{ item.created_at }}</span>
                            </div>
                          </div>
                          <div class="uBD8RDhi" style="color: #98a3b1 !important" v-html="item.content.replace(/<[^>]+>/g, '')"></div>
                        </div>
                      </div>
                      <!-- <div class="_39uvhKpz">
                    <div class="_1f3LKTog">
                      <img src="/static/image/d1b5b95b433bfdf76041f9ae9a315b94269f42a6.png" alt="" />
                      <div>通知</div>
                    </div>
                    <div class="NToAey35">
                      <div class="_3gx8zoTi">
                        <span class="_1_GSPp_6">{{$store.state.appInfo.title}}极速存提</span>
                        <div class="_3E5EbnxT"><span>2022-04-08 20:23:41</span><span>删除</span></div>
                      </div>
                      <div class="uBD8RDhi">
                        <h3>尊敬的用户：</h3>
                        <p>
                          平台未设置极速提款信息推送，不会有任何电话、短信和聊天软件等通知，财务人员不会使用会员联系方式联络会员，提款后请区分接收金额与转账附言备注，核查金额接收、余额变化无误后再点击确认按钮，谨防资金流失！回单上传已上线，更新APP(版本号4.1.6)更可体验极速微信/支付宝/京东付/云闪付等小额高效上分！
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="_39uvhKpz">
                    <div class="_1f3LKTog">
                      <img src="/static/image/d1b5b95b433bfdf76041f9ae9a315b94269f42a6.png" alt="" />
                      <div>通知</div>
                    </div>
                    <div class="NToAey35">
                      <div class="_3gx8zoTi">
                        <span class="_1_GSPp_6">电竞五重</span>
                        <div class="_3E5EbnxT"><span>2022-04-08 19:01:13</span><span>删除</span></div>
                      </div>
                      <div class="uBD8RDhi">
                        <h3>尊敬的用户：</h3>
                        <p>{{$store.state.appInfo.title}}邀您关注4月8日20:00DOTA2【Lilgun vs Nemiga】20:00KPL春季赛【DYG vs AG】9日01:00CS:GO【NAVI vs Faze】参与活动五重豪礼享最高10140元！金玉财满仓：4月1日-9日日享返利5188元！易币付加赠20%！</p>
                      </div>
                    </div>
                  </div>
                  <div class="_39uvhKpz">
                    <div class="_1f3LKTog">
                      <img src="/static/image/d1b5b95b433bfdf76041f9ae9a315b94269f42a6.png" alt="" />
                      <div>通知</div>
                    </div>
                    <div class="NToAey35">
                      <div class="_3gx8zoTi">
                        <span class="_1_GSPp_6">体育四重</span>
                        <div class="_3E5EbnxT"><span>2022-04-08 17:15:38</span><span>删除</span></div>
                      </div>
                      <div class="uBD8RDhi">
                        <h3>尊敬的用户：</h3>
                        <p>{{$store.state.appInfo.title}}邀您关注4月8日17:45澳超【阿德莱得联 vs 麦克阿瑟FC】9日02:30德甲【斯图加特 vs 多特蒙德】参与活动焦点赛事专场，乐享四重惊喜！金玉财满仓：4月1日-9日日享返利5188元！易币付加赠20%！</p>
                      </div>
                    </div>
                  </div>
                  <div class="_39uvhKpz">
                    <div class="_1f3LKTog">
                      <img src="/static/image/d1b5b95b433bfdf76041f9ae9a315b94269f42a6.png" alt="" />
                      <div>通知</div>
                    </div>
                    <div class="NToAey35">
                      <div class="_3gx8zoTi">
                        <span class="_1_GSPp_6">月初财满仓</span>
                        <div class="_3E5EbnxT"><span>2022-04-08 16:36:53</span><span>删除</span></div>
                      </div>
                      <div class="uBD8RDhi">
                        <h3>尊敬的用户：</h3>
                        <p>金玉财满仓 存送返利：4月1日-9日活动期间申请活动优惠首日累计存款后日享返利最高5188元，易币付加赠20%！签到可获20888元；LPL专题活动：投注享888元+趣味玩法享388元；</p>
                      </div>
                    </div>
                  </div> -->
                    </div>
                    <div class="mLpf8IBu" v-if="showData.data">
                      <ul class="ant-pagination mini" unselectable="unselectable">
                        <!-- <li title="上一页" class="ant-pagination-prev ant-pagination-disabled" aria-disabled="true">
                      <a class="ant-pagination-item-link" disabled=""
                        ><span role="img" aria-label="left" class="anticon anticon-left">
                          <svg viewbox="64 64 896 896" focusable="false" data-icon="left" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                            <path d="M724 218.3V141c0-6.7-7.7-10.4-12.9-6.3L260.3 486.8a31.86 31.86 0 000 50.3l450.8 352.1c5.3 4.1 12.9.4 12.9-6.3v-77.3c0-4.9-2.3-9.6-6.1-12.6l-360-281 360-281.1c3.8-3 6.1-7.7 6.1-12.6z"></path>
                          </svg> </span
                      ></a>
                    </li> -->
                        <li title="上一页" :class="showData.page * 1 - 1 ? 'ant-pagination-prev ' : 'ant-pagination-prev ant-pagination-disabled'" @click="changPage(page * 1 - 1)">
                          <a class="ant-pagination-item-link" disabled=""
                            ><span role="img" aria-label="left" class="anticon anticon-left">
                              <svg viewBox="64 64 896 896" focusable="false" data-icon="left" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                <path d="M724 218.3V141c0-6.7-7.7-10.4-12.9-6.3L260.3 486.8a31.86 31.86 0 000 50.3l450.8 352.1c5.3 4.1 12.9.4 12.9-6.3v-77.3c0-4.9-2.3-9.6-6.1-12.6l-360-281 360-281.1c3.8-3 6.1-7.7 6.1-12.6z"></path>
                              </svg> </span
                          ></a>
                        </li>
                        <!-- <li title="1" class="ant-pagination-item ant-pagination-item-1 ant-pagination-item-active" tabindex="0"><a>1</a></li> -->
                        <li title="1" :class="page == index + 1 ? 'ant-pagination-item ant-pagination-item-1 ant-pagination-item-active' : 'ant-pagination-item ant-pagination-item-1 '" @click="changPage(index + 1)" v-for="(item, index) in showData.last_page * 1" :key="index">
                          <a>{{ index + 1 }}</a>
                        </li>
                        <li title="下一页" :class="showData.page * 1 + 1 <= showData.last_page ? 'ant-pagination-prev ' : 'ant-pagination-prev ant-pagination-disabled'" @click="changPage(page * 1 + 1)">
                          <a class="ant-pagination-item-link" disabled=""
                            ><span role="img" aria-label="right" class="anticon anticon-right">
                              <svg viewBox="64 64 896 896" focusable="false" data-icon="right" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                <path d="M765.7 486.8L314.9 134.7A7.97 7.97 0 00302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 000-50.4z"></path>
                              </svg> </span
                          ></a>
                        </li>
                      </ul>
                      <!-- <div class="_2Ym3tjrO">全部删除</div> -->
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div role="tabpanel" aria-hidden="false" tabindex="0" class="ant-tabs-tabpane ant-tabs-tabpane-active" style="visibility: visible">
              <div class="ant-spin-nested-loading">
                <div class="ant-spin-container">
                  <form class="ant-form ant-form-horizontal _3XHw9goE">
                    <div class="_267eTqWT">尊敬的{{$store.state.appInfo.title}}会员，反馈有礼畅所欲言，说出您对平台的意见、建议，您的建议是我们前进的动力，我们将对有价值意见给予丰厚奖励，尽情吐槽吧！</div>
                    <!-- <div class="_1pDMxc1H">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="type" class="ant-form-item-required" title="反馈类型">反馈类型</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <div class="ant-select _32SoV0oI ant-select-single ant-select-show-arrow" style="width: 780px; position: relative">
                                <div class="ant-select-selector">
                                  <span class="ant-select-selection-search">
                                    <input
                                      id="type"
                                      autocomplete="off"
                                      class="ant-select-selection-search-input"
                                      role="combobox"
                                      aria-haspopup="listbox"
                                      aria-owns="type_list"
                                      aria-autocomplete="list"
                                      aria-controls="type_list"
                                      aria-activedescendant="type_list_0"
                                      readonly=""
                                      unselectable="on"
                                      value=""
                                      style="opacity: 0"
                                    /> </span
                                  ><span class="ant-select-selection-placeholder">请选择反馈类型</span>
                                </div>
                                <span class="ant-select-arrow" unselectable="on" aria-hidden="true" style="user-select: none"
                                  ><span role="img" aria-label="down" class="anticon anticon-down">
                                    <svg viewbox="64 64 896 896" focusable="false" data-icon="down" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                      <path d="M884 256h-75c-5.1 0-9.9 2.5-12.9 6.6L512 654.2 227.9 262.6c-3-4.1-7.8-6.6-12.9-6.6h-75c-6.5 0-10.3 7.4-6.5 12.7l352.6 486.1c12.8 17.6 39 17.6 51.7 0l352.6-486.1c3.9-5.3.1-12.7-6.4-12.7z"></path>
                                    </svg> </span
                                ></span>
                                <div class="ant-select-dropdown ant-select-dropdown-placement-bottomLeft ant-select-dropdown-hidden" style="min-width: 780px; width: 780px; left: 0; top: 42px">
                                  <div>
                                    <div class="" style="max-height: 256px; overflow-y: auto; overflow-anchor: none">
                                      <div>
                                        <div class="list" style="display: flex; flex-direction: column">
                                          <div class="ant-select-item ant-select-item-option ant-select-item-option-selected">
                                            <div class="ant-select-item-option-content">财务问题</div>
                                          </div>
                                          <div class="ant-select-item ant-select-item-option">
                                            <div class="ant-select-item-option-content">账号问题</div>
                                          </div>
                                          <div class="ant-select-item ant-select-item-option">
                                            <div class="ant-select-item-option-content">游戏问题</div>
                                          </div>
                                          <div class="ant-select-item ant-select-item-option">
                                            <div class="ant-select-item-option-content">活动问题</div>
                                          </div>
                                          <div class="ant-select-item ant-select-item-option">
                                            <div class="ant-select-item-option-content">其他问题</div>
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
                    <div class="_1pDMxc1H">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="title" class="ant-form-item-required" title="标题">标题</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" placeholder="请输入标题" id="title" value="" style="width: 780px" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="_1pDMxc1H">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="content" class="ant-form-item-required" title="内容">内容</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <textarea rows="4" class="ant-input _3lpQUSGQ" placeholder="请输入内容,不能少于20个字" maxlength="200" id="content" style="width: 780px"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="_1pDMxc1H">
                      <div class="ant-row ant-form-item">
                        <div class="ant-col ant-form-item-label">
                          <label for="imgs" class="" title="上传图片">上传图片</label>
                        </div>
                        <div class="ant-col ant-form-item-control">
                          <div class="ant-form-item-control-input">
                            <div class="ant-form-item-control-input-content">
                              <div class="_3BYdEpW7" style="width: 780px">
                                <div class="_3PxziwKt">（仅支持JPG、PNG、JPEG、BMP格式文件，最大不可超过2M）</div>
                                <span class="ibf1i0L9 ant-upload-picture-card-wrapper">
                                  <div class="ant-upload-list ant-upload-list-picture-card"></div>
                                  <div class="ant-upload ant-upload-select ant-upload-select-picture-card">
                                    <span tabindex="0" class="ant-upload" role="button">
                                      <input type="file" accept="" style="display: none" />
                                      <div>
                                        <span role="img" aria-label="plus" class="anticon anticon-plus">
                                          <svg viewbox="64 64 896 896" focusable="false" data-icon="plus" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                            <defs></defs>
                                            <path d="M482 152h60q8 0 8 8v704q0 8-8 8h-60q-8 0-8-8V160q0-8 8-8z"></path>
                                            <path d="M176 474h672q8 0 8 8v60q0 8-8 8H176q-8 0-8-8v-60q0-8 8-8z"></path>
                                          </svg>
                                        </span>
                                        <div class="ant-upload-text">上传图片</div>
                                      </div>
                                    </span>
                                  </div>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> -->
                    <div class="_349CzCYy xJQe3jRu _13EKJOXM" @click="openKefu"><span>联系客服</span></div>
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
export default {
  name: 'transRecord',
  data() {
    return {
      homenoticelist: [],
      showData: {},
      page: 1,
      lodingShow: true,
      total: 0,
      tanNum: 0,
    };
  },
  created() {
    let that = this;
    that.getDatalist();
  },
  methods: {
    changTab(val) {
      let that = this;
      if (val == that.tanNum) return;
      that.tanNum = val;
    },
    getDatalist() {
      let that = this;
      let page = that.page;
      that.showloading();
      // that.$apiFun.post('/api/homenoticelist', { page }).then(res => {
      that.$apiFun.post('/api/noticeList', { page }).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.homenoticelist = res.data.data;
          that.showData = res.data;
          that.total = res.data.total;
               localStorage.setItem('show',1);
            that.$store.commit('changMessageNum');
        }
        that.hideloading();
      }).catch(res=>{
          that.hideloading();
      });
    },
    changPage(page) {
      let that = this;
      if (page == 0 || page > that.showData.last_page || page == that.page) {
        //前后超出范围 或者是当前页
        return;
      }

      that.page = page;
      that.getDatalist();
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
    },    openKefu() {
      let that = this;
      that.$parent.openKefu();
    },
  },
  mounted() {
    // --------  消息公告------------------------------------------------------------------
    $('._1D2kUmXy li').click(function () {
      $(this).addClass('_3L47e6NQ').siblings().removeClass('_3L47e6NQ');
    });
    // 个人资料 ---------------------------------------------------------------------------
    var mylaydate = laydate.render({
      elem: '.ant-picker-input',
      eventElem: '.ant-picker-input .datepicker',
      theme: 'type-ym',
      trigger: 'click',
      btns: [],
      type: 'date',
      value: '2004-04-01',
    });
    $('._2tZRPt8E li').click(function () {
      $(this).addClass('d1qCTAjZ').siblings().removeClass('d1qCTAjZ');
    });
    $(function () {
      // 	$("#sjld").sjld("#shenfen","#chengshi","#quyu");
      // $("#sjld")("#shenfen","#chengshi","#quyu");
    });
  },
};
</script>
<style lang="scss" scoped>
</style>
