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
          <div class="T5pPAuRQ">红包记录<span></span></div>
          <a @click="goNav('/userredpacket')">抢红包</a>
        </div>
        <div class="_3Gq99aEO">
          <div class="JJAq1KGQ">
            <i class="_1QA1BIYf _-8TfUAAV"></i>
            <div class="_1L44oUsP">
              <span>累计领取次数</span><span class="_142Z-wIj">{{ userredpacket.acquirednum }}</span>
            </div>
          </div>
          <div class="JJAq1KGQ" style="cursor: pointer" @click="goNav('/userredpacket')">
            <i class="_1QA1BIYf _2-sh3L0L"></i>
            <div class="_1L44oUsP">
              <span>剩余次数</span><span class="_142Z-wIj">{{ userredpacket.sendnums }} </span>
            </div>
            <!-- <span style="margin-left:10px">点击领取红包</span> -->
          </div>
        </div>

        <div class="ant-table-wrapper fYo2DqtT">
          <div class="ant-spin-nested-loading">
            <div class="loading" style="display: none">
              <div class="ant-spin ant-spin-spinning _2PSsJSST">
                <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
              </div>
            </div>
            <div class="_21o37iEs" v-if="redpacketList.length == 0">
              <img src="/static/image/ill_norecord_day-b111.png" alt="" />
              <div class="HzjbFc_d">暂无记录</div>
            </div>
            <div class="ant-spin-container" v-if="redpacketList.length > 0">
              <div class="ant-table">
                <div class="ant-table-container">
                  <div class="ant-table-content">
                    <table style="table-layout: auto">
                      <colgroup></colgroup>
                      <thead class="ant-table-thead">
                        <tr>
                          <th class="ant-table-cell">充值金额</th>
                          <th class="ant-table-cell">红包金额</th>
                          <th class="ant-table-cell">充值时间</th>
                          <th class="ant-table-cell">领取时间</th>
                        </tr>
                      </thead>
                      <tbody class="ant-table-tbody">
                        <tr class="ant-table-row ant-table-row-level-0 tzNqBmRM false" v-for="(item, index) in redpacketList" :key="index">
                          <td class="ant-table-cell">{{ item.money }}</td>
                          <td class="ant-table-cell">{{ item.redpacketmoney }}</td>
                          <td class="ant-table-cell">{{ item.created_at }}</td>
                          <td class="ant-table-cell">{{ item.usetime }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <el-pagination v-if="redpacketShowData.total" class="ant-pagination ant-table-pagination ant-table-pagination-right mini" @current-change="getredpacket" :current-page.sync="page" :page-size="10" layout="prev, pager, next" :total="redpacketShowData.total"></el-pagination>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  name: 'welfare',
  data() {
    return { redpacketList: [], lodingShow: false, page: 1, redpacketShowData: {}, userredpacket: {} };
  },
  created() {
    let that = this;
    that.getredpacket();
    that.getuserredpacket();
  },
  methods: {
    getwelfare() {
      let that = this;
      if (that.userredpacket.sendnums < 1) {
        that.showTost('您的剩余次数不足！');

        return;
      }
      that.showLoading();
      that.$apiFun
        .post('/api/douserredpacket', {})
        .then(res => {
          console.log(res);

          that.showTost(res.message);
          that.hideLoading();
          that.getredpacket();
          that.getuserredpacket();
        })
        .catch(() => {
          that.showTost('服务器异常，请稍后再试');
          that.hideLoading();
        });
    },

    getuserredpacket() {
      let that = this;
      that.showLoading();
      let info = {
        page: that.page,
      };
      that.$apiFun.get('/api/userredpacket', info).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.userredpacket = res.data;
        }
        that.hideLoading();
      });
    },
    // 获取红包记录
    getredpacket() {
      let that = this;
      that.showLoading();
      let info = {
        page: that.page,
      };
      that.$apiFun.post('/api/redpacket', info).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.redpacketList = res.data.data;
          that.redpacketShowData = res.data;
        }
        that.hideLoading();
      });
    },
    goNav(url) {
      let that = this;
      if (url == '/userredpacket') {
        if (that.$store.state.appInfo.redpacket_switch == 0) {
          that.showTost('红包已关闭');
          return;
        }
        let routerData = this.$router.resolve({
          path: `/userredpacket`,
        });
        window.open(routerData.href, '_blank');

        return;
      }
      this.$router.push({ path: url });
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
    hideLoading() {
      this.lodingShow = false;
    },
    showLoading() {
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
