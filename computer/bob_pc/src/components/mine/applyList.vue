<template>
  <div class="ant-spin-nested-loading">
    <div class="loading" v-if="lodingShow">
      <div class="ant-spin ant-spin-spinning _2PSsJSST">
        <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
      </div>
    </div>
    <div :class="lodingShow ? 'ant-spin-container ant-spin-blur' : 'ant-spin-container'">
      <form class="ant-form ant-form-horizontal _3GOAOYQ8">
        <div class="_4ICMeQUV">
          <div class="T5pPAuRQ">活动申请记录<span></span></div>
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
              <div class="HzjbFc_d">暂无活动申请</div>
            </div>
            <div class="ant-spin-container">
              <div v-if="dataList.length > 0">
                <div class="ant-table">
                  <div class="ant-table-container">
                    <div class="ant-table-content">
                      <table style="table-layout: auto">
                        <colgroup></colgroup>
                        <thead class="ant-table-thead">
                          <tr>
                            <th class="ant-table-cell" style="text-align: left; box-sizing: border-box; padding-left: 20px">活动标题</th>
                            <th class="ant-table-cell">申请时间</th>
                            <th class="ant-table-cell">状态</th>
                          </tr>
                        </thead>
                        <tbody class="ant-table-tbody">
                          <tr class="ant-table-row ant-table-row-level-0 tzNqBmRM false" v-for="item in dataList" :key="item.id">
                            <td class="ant-table-cell" style="text-align: left; box-sizing: border-box; padding-left:20px!important">{{ item.activity_name }}</td>
                            <td class="ant-table-cell">{{ item.created_at }}</td>
                            <td class="ant-table-cell">
                              <!-- 结算和未结算  待审核 2未结算 0无效注单-->
                              <span class="_20nFxBS5">{{ statuType[item.state] }}</span>
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
                   
                    @click="changPage(page * 1 - 1)">
                    <a class="ant-pagination-item-link" disabled=""
                      ><span role="img" aria-label="left" class="anticon anticon-left">
                        <svg viewBox="64 64 896 896" focusable="false" data-icon="left" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                          <path d="M724 218.3V141c0-6.7-7.7-10.4-12.9-6.3L260.3 486.8a31.86 31.86 0 000 50.3l450.8 352.1c5.3 4.1 12.9.4 12.9-6.3v-77.3c0-4.9-2.3-9.6-6.1-12.6l-360-281 360-281.1c3.8-3 6.1-7.7 6.1-12.6z"></path>
                        </svg> </span
                    ></a>
                  </li>
                  <li title="1" :class="page == index + 1 ? 'ant-pagination-item ant-pagination-item-1 ant-pagination-item-active' : 'ant-pagination-item ant-pagination-item-1 '" @click="changPage(index + 1)" v-for="(item, index) in showData.last_page * 1" :key="index">
                    <a>{{ index + 1 }}</a>
                  </li>
                  <li title="下一页" 
              :class="page*1  >=  showData.last_page ?'ant-pagination-prev ant-pagination-disabled':'ant-pagination-prev '" 

                   @click="changPage(page * 1 + 1)">
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
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  name: 'applyList',
  data() {
    return {
      date: 1,
      page: 1,
      api_type: '',
      dogameLis: [],
      dataList: [],
      statuType: ['0未约定', '待审核', '通过', '拒绝','4未约定'],
      showData: {},
      lodingShow: true,
    };
  },
  created() {
    let that = this;
    that.getData();
  },
  methods: {
    changPage(page) {
      let that = this;
      console.log(page);
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
      let that = this;
      this.$router.push({ path: url });
    },
    getData() {
      let that = this;
      that.showloading();
      let info = {
        date: that.date,
        page: that.page,
        api_type: that.api_type,
      };
      console.log(info);
      // return;betRecord
      that.$apiFun.post('/api/activityApplyLog', {}).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.dataList = res.data.data;
          that.showData = res.data;
        }
        that.hideloading();
      }).catch(res=>{
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
