<template>
  <div class="ant-spin-nested-loading">
    <div class="loading" v-if="lodingShow">
      <div class="ant-spin ant-spin-spinning _2PSsJSST">
        <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
      </div>
    </div>
    <div :class="lodingShow ? 'ant-spin-container ant-spin-blur' : 'ant-spin-container'">
      <form class="ant-form ant-form-horizontal UY0P2f1z">
        <div class="_4ICMeQUV">
          <div class="T5pPAuRQ">返水中心<span></span></div>
        </div>
        <div class="_3Gq99aEO">
          <div class="JJAq1KGQ">
            <i class="_1QA1BIYf _-8TfUAAV"></i>
            <div class="_1L44oUsP">
              <span>累计领取</span><span class="_142Z-wIj">{{ jisuan }}</span>
            </div>
          </div>
          <div class="JJAq1KGQ" style="cursor: pointer" @click="lingqu">
            <i class="_1QA1BIYf _2-sh3L0L"></i>
            <div class="_1L44oUsP">
              <span>待领取</span><span class="_142Z-wIj">{{ nojisuan }}</span>
            </div>
          </div>
        </div>

        <div class="Q6fDXhb1">
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
                ><span class="ant-select-selection-item ant-select-selection-item1">全平台</span>
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
          <div class="_2JVDZbvu">
            <div class="_2qRK2_XE">红利状态</div>
            <div class="ant-select _32SoV0oI ant-select-single ant-select-show-arrow" style="width: 184px; position: relative">
              <div class="ant-select-selector">
                <span class="ant-select-selection-search">
                  <input
                    autocomplete="off"
                    class="ant-select-selection-search-input"
                    role="combobox"
                    aria-haspopup="listbox"
                    aria-owns="rc_select_12_list"
                    aria-autocomplete="list"
                    aria-controls="rc_select_12_list"
                    aria-activedescendant="rc_select_12_list_0"
                    readonly=""
                    unselectable="on"
                    value=""
                    id="rc_select_12"
                    style="opacity: 0"
                  /> </span
                ><span class="ant-select-selection-item ant-select-selection-item2">全部</span>
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
                      <div class="lists" style="display: flex; flex-direction: column">
                        <div aria-selected="true" class="ant-select-item ant-select-item-option ant-select-item-option-selected" @click="changPayType('type', '')">
                          <div class="ant-select-item-option-content">全部</div>
                        </div>
                        <div aria-selected="false" class="ant-select-item ant-select-item-option" @click="changPayType('type', 1)">
                          <div class="ant-select-item-option-content">成功</div>
                        </div>
                        <div aria-selected="false" class="ant-select-item ant-select-item-option" @click="changPayType('type', 2)">
                          <div class="ant-select-item-option-content">失败</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="_3Ue4EhT5">
            <!-- 1当日记录 2近7天记录 3近15天记录 4近30天记录 -->
            <div class="_3nix2lDq">交易时间</div>
            <div class="_3CZO3fNE _8E8PME48" @click="changPayType('date', 1)">今日</div>
            <div class="_3CZO3fNE" @click="changPayType('date', 2)">一周内</div>
            <div class="_3CZO3fNE" @click="changPayType('date', 3)">半月内</div>
            <div class="_3CZO3fNE" @click="changPayType('date', 4)">一月内</div>
          </div>
        </div>

        <div class="ant-table-wrapper fYo2DqtT">
          <div class="ant-spin-nested-loading">
            <div class="loading" style="display: none">
              <div class="ant-spin ant-spin-spinning _2PSsJSST">
                <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
              </div>
            </div>
            <div class="_21o37iEs" v-if="dataList.length == 0">
              <img src="/static/image/ill_norecord_day-b111.png" alt="" />
              <div class="HzjbFc_d">暂无记录</div>
            </div>
            <div class="ant-spin-container" v-if="dataList.length > 0">
              <div class="ant-table">
                <div class="ant-table-container">
                  <div class="ant-table-content">
                    <table style="table-layout: auto">
                      <colgroup></colgroup>
                      <thead class="ant-table-thead">
                        <tr>
                          <th class="ant-table-cell">游戏名称</th>
                          <th class="ant-table-cell">返水金额</th>
                          <th class="ant-table-cell">状态</th>
                          <th class="ant-table-cell">返水时间</th>
                          <th class="ant-table-cell">领取时间</th>
                        </tr>
                      </thead>
                      <tbody class="ant-table-tbody">
                        <tr class="ant-table-row ant-table-row-level-0 tzNqBmRM false" v-for="(item, index) in dataList" :key="index">
                          <td class="ant-table-cell">{{ item.gamename }}</td>
                          <td class="ant-table-cell">{{ item.money }}</td>
                          <td class="ant-table-cell">
                            <div>{{ item.state == 0 ? '待领取' : '已领取' }}</div>
                          </td>
                          <td class="ant-table-cell"><span class="_20nFxBS5">{{ item.created_at  }}</span></td>
                          <td class="ant-table-cell"><span class="_20nFxBS5">{{ item.state == 0 ? '暂未领取' : item.updated_at }}</span></td>
                     
                        </tr>
                      </tbody>
                    </table>
                  </div>
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
    return { date: 1, api_type: '',page:1, dogameLis: [], dataList: [], showData: {}, type: '', jisuan: 0, nojisuan: 0, lodingShow: true };
  },
  created() {
    let that = this;
    that.getdogame();
    that.getData();
  },
  methods: {
        getUserInfo() {
      let that = this;
      that.$apiFun.post('/api/user', {}).then(res => {
        console.log(res);
        if (res.code !== 200) {
          that.showTost(res.message);
        }
        if (res.code === 200) {
                     let userInfo = res.data;
          let str =userInfo.current_vip ;
          let index = str.indexOf("P");
          let vip = str.substr(index + 1,str.length);   //04
          userInfo.vip = vip;
          localStorage.setItem('userInfo', JSON.stringify(userInfo));
          that.userInfo = userInfo;
          that.$store.commit('changUserInfo');
        }
      });
    },
    lingqu() {
      let that = this;
      let fanshui = that.nojisuan;
      if (fanshui <= 0) {
        that.showTost("暂无领取额度！")
        return;
      }
      that.showloading();
      that.$apiFun.post('/api/dofanshui', {}).then(res => {
        console.log(res);
        that.getUserInfo();
        that.showTost(res.message);
        that.getData();

      }).catch(res=>{
          that.hideloading();
      });
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
      let that = this;
      this.$router.push({ path: url });
    },
    getData() {
      let that = this;
      that.showloading();
      let info = {
        date: that.date,
        api_type: that.api_type,
        type: that.type,
        page:that.page
      };
      console.log(info);
      // return;betRecord
      that.$apiFun.post('/api/getfanshui', info).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.dataList = res.data.list.data;
          that.showData = res.data.list;
          that.jisuan = res.data.jisuan;
          that.nojisuan = res.data.nojisuan;
        }
        that.hideloading();
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
    hideloading() {
      this.lodingShow = false;
    },
    showloading() {
      this.lodingShow = true;
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
    //选择下拉内容
    $('.list .ant-select-item').click(function () {
      $(this).addClass('ant-select-item-option-selected').siblings().removeClass('ant-select-item-option-selected');
      var text = $(this).find('.ant-select-item-option-content').text();
      $('.ant-select-selection-search-input').attr('value', text);
      $('.ant-select-selection-item1').text(text);
    });
    $('.lists .ant-select-item').click(function () {
      $(this).addClass('ant-select-item-option-selected').siblings().removeClass('ant-select-item-option-selected');
      var text = $(this).find('.ant-select-item-option-content').text();
      $('.ant-select-selection-search-input').attr('value', text);
      $('.ant-select-selection-item2').text(text);
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
