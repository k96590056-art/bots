<template>
    <div class="ant-spin-nested-loading">
    <div class="loading" v-if="lodingShow">
      <div class="ant-spin ant-spin-spinning _2PSsJSST">
        <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
      </div>
    </div>
    <div :class="lodingShow ? 'ant-spin-container ant-spin-blur':'ant-spin-container'">

    <form class="ant-form ant-form-horizontal _3sKMEkS_">
      <div class="_4ICMeQUV">
        <div class="T5pPAuRQ">交易记录<span>只显示近一个月的交易记录，如需更多信息请联系客服查询</span></div>
      </div>
      <div class="_2IDpsxiM">
        <div class="_1x1pyER-">
          <div class="_27s44Ho3">选择平台</div>
          <div class="ant-select _32SoV0oI ant-select-single ant-select-show-arrow" style="width: 184px">
            <div class="ant-select-selector">
              <span class="ant-select-selection-search">
                <input
                  autocomplete="off"
                  class="ant-select-selection-search-input"
                  role="combobox"
                  aria-haspopup="listbox"
                  aria-owns="rc_select_21_list"
                  aria-autocomplete="list"
                  aria-controls="rc_select_21_list"
                  aria-activedescendant="rc_select_21_list_0"
                  readonly=""
                  unselectable="on"
                  value=""
                  id="rc_select_21"
                  style="opacity: 0"
                /> </span
              ><span class="ant-select-selection-item">全平台</span>
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
                    <div class="list" style="display: flex; flex-direction: column">
                      <!-- ant-select-item-option-selected -->
                      <div aria-selected="true" :class="api_type == '' ? 'ant-select-item ant-select-item-option ant-select-item-option-selected' : 'ant-select-item ant-select-item-option'" @click="changPayType('api_type', '')">
                        <div class="ant-select-item-option-content">全平台</div>
                      </div>
                      <div aria-selected="true" :class="api_type == item.platname ? 'ant-select-item ant-select-item-option ant-select-item-option-selected' : 'ant-select-item ant-select-item-option'" v-for="(item, index) in dogameLis" :key="index" @click="changPayType('api_type', item.platname)">
                        <div class="ant-select-item-option-content">{{ item.name }}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="_3Ue4EhT5">
          <!-- 	1充值记录 2提现记录 3转入游戏记录 4转出游戏记录 -->
          <div class="_3nix2lDq">交易类型</div>
          <div class="_3CZO3fNE _8E8PME48" @click="changPayType('type', 1)">存款</div>
          <div class="_3CZO3fNE" @click="changPayType('type', 2)">取款</div>
          <div class="_3CZO3fNE" @click="changPayType('type', 3)">转入</div>
          <div class="_3CZO3fNE" @click="changPayType('type', 4)">转出</div>
        </div>
        <div class="_3Ue4EhT5">
          <!-- 1当日记录 2近7天记录 3近15天记录 4近30天记录 -->
          <div class="_3nix2lDq">交易时间</div>
          <div class="_3CZO3fNE _8E8PME48" @click="changPayType('date', 1)">今日</div>
          <div class="_3CZO3fNE" @click="changPayType('date', 2)">一周内</div>
          <div class="_3CZO3fNE" @click="changPayType('date', 3)">半月内</div>
          <div class="_3CZO3fNE" @click="changPayType('date', 4)">一月内</div>
        </div>
        <!-- <div class="_3Ue4EhT5 hagFlex">
          <div class="_3nix2lDq" style="padding-top:12px">游戏类型</div>
          <div class="hagFlexLis">
            <div :class="api_type == key ? '_3CZO3fNE _8E8PME48' : '_3CZO3fNE'" v-for="(val, key, index) in dogameLis" :key="index" @click="changPayType('api_type', key)">{{ val }}</div>
          </div>
        </div> -->

        <!-- <div class="_55hLZiWW">
          <div class="id4EomK1">时间筛选</div>
          <div class="ant-picker ant-picker-range _28fJvuUS">
            <div class="ant-picker-input ant-picker-input-active">
              <input id="duration" readonly="" placeholder="选择日期范围" size="12" autocomplete="off" value="" class="datepicker" />
            </div>
            <span class="ant-picker-suffix"
              ><span role="img" aria-label="calendar" class="anticon anticon-calendar">
                <svg viewbox="64 64 896 896" focusable="false" data-icon="calendar" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                  <path
                    d="M880 184H712v-64c0-4.4-3.6-8-8-8h-56c-4.4 0-8 3.6-8 8v64H384v-64c0-4.4-3.6-8-8-8h-56c-4.4 0-8 3.6-8 8v64H144c-17.7 0-32 14.3-32 32v664c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V216c0-17.7-14.3-32-32-32zm-40 656H184V460h656v380zM184 392V256h128v48c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-48h256v48c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-48h128v136H184z"
                  ></path>
                </svg> </span></span
            ><span class="ant-picker-clear"
              ><span role="img" aria-label="close-circle" class="anticon anticon-close-circle">
                <svg viewbox="64 64 896 896" focusable="false" data-icon="close-circle" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                  <path
                    d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm165.4 618.2l-66-.3L512 563.4l-99.3 118.4-66.1.3c-4.4 0-8-3.5-8-8 0-1.9.7-3.7 1.9-5.2l130.1-155L340.5 359a8.32 8.32 0 01-1.9-5.2c0-4.4 3.6-8 8-8l66.1.3L512 464.6l99.3-118.4 66-.3c4.4 0 8 3.5 8 8 0 1.9-.7 3.7-1.9 5.2L553.5 514l130 155c1.2 1.5 1.9 3.3 1.9 5.2 0 4.4-3.6 8-8 8z"
                  ></path>
                </svg> </span
            ></span>
          </div>
         _3SkQZ6Gu 禁止查询样式 
          <div @click="getData" class="_349CzCYy xJQe3jRu" style="width: 120px; margin-left: 24px">
            <span>查询</span>
          </div>
        </div> -->
      </div>
      <!--   -->
 

      <div  class="ant-table-wrapper fYo2DqtT">
     
            <div v-if="dataList.length == 0 " class="_21o37iEs">
        <img src="/static/image/ill_norecord_day-b111.png" alt="" />
        <div class="HzjbFc_d">暂无交易记录</div>
        <div class="_349CzCYy xJQe3jRu" @click="goNav('/mine/deposit')" style="width: 120px"><span>前往充值</span></div>
      </div>
          <div class="ant-spin-container" v-if="dataList.length > 0">
            <div class="ant-table">
              <div class="ant-table-container">
                <div class="ant-table-content">
                  <table style="table-layout: auto">
                    <colgroup></colgroup>
                    <thead class="ant-table-thead">
                      <tr>
                        <th class="ant-table-cell">序号</th>
                        <th class="ant-table-cell">时间</th>
                        <th class="ant-table-cell"  v-if="type == 1 || type == 2">订单号</th>
                        <th class="ant-table-cell">交易类型</th>
                        <th class="ant-table-cell">金额</th>
                        <th class="ant-table-cell">状态</th>
                      </tr>
                    </thead>
                    <tbody class="ant-table-tbody">
                      <tr class="ant-table-row ant-table-row-level-0 tzNqBmRM false" v-for="(item, index) in dataList" :key="item.id">
                        <td class="ant-table-cell">{{ index + 1 }}</td>
                        <td class="ant-table-cell">{{ item.created_at }}</td>
                        <td class="ant-table-cell" v-if="type == 1 || type == 2">
                          <div>{{ item.out_trade_no }}</div>
                        </td>
                        <td class="ant-table-cell">{{ item.pay_way }}</td>
                        <td class="ant-table-cell">{{ item.amount }}</td>
                        <td class="ant-table-cell">
                          <!-- 充值state：1待审核 2审核通过 3审核拒绝
                                提现state：1待审核 2通过 3拒绝
                          转入转出记录state：1成功 0失败 2 待结算 

                          	1充值记录 2提现记录 3转入游戏记录 4转出游戏记录
                                    <div class="_3CZO3fNE _8E8PME48" @click="changPayType('type', 1)">存款</div>
                                    <div class="_3CZO3fNE" @click="changPayType('type', 2)">取款</div>
                                    <div class="_3CZO3fNE" @click="changPayType('type', 3)">转账</div>
                                    <div class="_3CZO3fNE" @click="changPayType('type', 4)">上分</div>
                          -->
                          <span class="_20nFxBS5" v-if="type == 1 || type == 2">{{ stateType12[item.state] }}</span>
                          <span class="_20nFxBS5" v-if="type == 3 || type == 4">{{ stateType34[item.state] }}</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
                             <el-pagination v-if="showData.total" class="ant-pagination ant-table-pagination ant-table-pagination-right mini" 
          @current-change="getData"
          :current-page.sync="page"
          :page-size="10"
          layout="prev, pager, next"
          :total="showData.total"
        ></el-pagination>
            <!-- <ul class="ant-pagination ant-table-pagination ant-table-pagination-right mini" unselectable="unselectable">
              <li title="上一页" 
              :class="page*1  <= 1?'ant-pagination-prev ant-pagination-disabled':'ant-pagination-prev '" 
               @click="changPage(page*1 - 1)">
                <a class="ant-pagination-item-link" disabled=""
                  ><span role="img" aria-label="left" class="anticon anticon-left">
                    <svg viewBox="64 64 896 896" focusable="false" data-icon="left" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                      <path d="M724 218.3V141c0-6.7-7.7-10.4-12.9-6.3L260.3 486.8a31.86 31.86 0 000 50.3l450.8 352.1c5.3 4.1 12.9.4 12.9-6.3v-77.3c0-4.9-2.3-9.6-6.1-12.6l-360-281 360-281.1c3.8-3 6.1-7.7 6.1-12.6z"></path>
                    </svg> </span
                ></a>
              </li>
              <li  :title="index + 1" :class="page == index + 1 ? 'ant-pagination-item ant-pagination-item-1 ant-pagination-item-active' : 'ant-pagination-item ant-pagination-item-1 '" @click="changPage(index + 1)" v-for="(item, index) in showData.last_page * 1" :key="index">
                <a>{{ index + 1 }}</a>
              </li>
              <li title="下一页" 
              :class="page*1  >=  showData.last_page ?'ant-pagination-prev ant-pagination-disabled':'ant-pagination-prev '" 
               @click="changPage(page*1 + 1)">
                <a class="ant-pagination-item-link" disabled=""
                  ><span role="img" aria-label="right" class="anticon anticon-right">
                    <svg viewBox="64 64 896 896" focusable="false" data-icon="right" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                      <path d="M765.7 486.8L314.9 134.7A7.97 7.97 0 00302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 000-50.4z"></path>
                    </svg> </span
                ></a>
              </li>
            </ul> -->
          </div>
        </div>
    </form>
  </div>
  </div>
</template>
<script>
export default {
  name: 'transRecord',
  data() {
    return {
      date: 1,
      type: 1,
      page: 1,
      api_type: '',
      dogameLis: [],
      dataList: [],
      stateType12: ['未定义', '待审核', '审核通过', '审核拒绝'],
      stateType34: ['失败', '成功', '待结算', '未定义'],
      showData: {},lodingShow:true
    };
  },
  created() {
    let that = this;
    that.getdogame();
  },
  methods: {
    hideloading() {
      this.lodingShow = false;
    },
    showloading() {
      this.lodingShow = true;
    },
    changPage(page) {
      let that = this;
      console.log(page)
      if (page == 0 || page > that.showData.last_page || page == that.page || !page) {
        //前后超出范围 或者是当前页
        return;
      }

      that.page = page;
      that.getData();
    },
    changPayType(name, val) {
      let that = this;

      if (that[name] == val) {
        return;
      }
      that[name] = val;
      that.getData();
    },
    goNav(url) {
      this.$router.push({ path: url });
    },
    getData() {
      let that = this;
      that.showloading()

      let info = {
        date: that.date,
        type: that.type,
        page: that.page,
        api_type: that.api_type,
      };
      console.log(info);
      // return;
      that.$apiFun.post('/api/gettransrecord', info).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.dataList = res.data.data;
          that.showData = res.data;
        }
        that.hideloading()
      }).catch(res=>{
          that.hideloading();
      });
    },
    getdogame() {
      let that = this;

      that.$apiFun.post('/api/balancelist', {}).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.dogameLis = res.data;
          that.dogameLis.push({name:'全平台',platname:''})
          that.getData();
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
  },
  mounted() {
    //弹出下拉
    $('.ant-select').click(function () {
      $(this).find('.ant-select-dropdown').slideToggle(200);
    });
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
    // --------  交易记录------------------------------------------------------------------
    //选择最近日期
    $('._3Ue4EhT5 ._3CZO3fNE').click(function () {
      that.page = 1;
      $(this).addClass('_8E8PME48').siblings().removeClass('_8E8PME48');
    });
    //选择下拉内容
    $('.list .ant-select-item').click(function () {
      $(this).addClass('ant-select-item-option-selected').siblings().removeClass('ant-select-item-option-selected');
      var text = $(this).find('.ant-select-item-option-content').text();
      $('.ant-select-selection-search-input').attr('value', text);
      $('.ant-select-selection-item').text(text);
    });
    //选择最近日期
    $('._3Ue4EhT5 ._3CZO3fNE').click(function () {
      $(this).addClass('_8E8PME48').siblings().removeClass('_8E8PME48');
    });
    laydate.render({
      elem: '.datepicker',
      range: true,
    });
  },
};
</script>
<style lang="scss" scoped>

</style>
