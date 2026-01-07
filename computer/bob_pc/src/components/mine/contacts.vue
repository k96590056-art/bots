<template>
  <div class="ant-spin-nested-loading">
    <div class="loading" v-if="lodingShow">
      <div class="ant-spin ant-spin-spinning _2PSsJSST">
        <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
      </div>
    </div>
    <div :class="lodingShow ? 'ant-spin-container ant-spin-blur' : 'ant-spin-container'">
      <div class="_25BGlJ4o">
        <div class="_4ICMeQUV" style="border: none">
          <div class="T5pPAuRQ">手机邮箱及生日</div>
        </div>
        <div class="ant-tabs ant-tabs-top ant-tabs-line">
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
            </div>
          </div>

          <!-- 手机 -->
          <div v-if="tabindex" class="ant-tabs-content ant-tabs-content-animated ant-tabs-top-content" style="margin-left: 0%">
            <div role="tabpanel" aria-hidden="false" tabindex="0" class="ant-tabs-tabpane ant-tabs-tabpane-active" style="visibility: visible">
              <form class="ant-form ant-form-horizontal _1JCYefEr">
                <div class="_1pDMxc1H">
                  <div class="ant-row ant-form-item">
                    <div class="ant-col ant-form-item-label">
                      <label for="phone" class="" title="手机号码">手机号码</label>
                    </div>
                    <div class="ant-col ant-form-item-control">
                      <div class="ant-form-item-control-input">
                        <div class="ant-form-item-control-input-content">
                          <input autocomplete="off" class="ant-input _3ON7kyGT" type="number" v-model="mobile" placeholder="请输入手机号码" id="phone" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="_1pDMxc1H">
                  <div class="ant-row ant-form-item">
                    <div class="ant-col ant-form-item-label">
                      <label for="email" class="" title="邮箱账号">邮箱账号</label>
                    </div>

                    <div class="ant-col ant-form-item-control">
                      <div class="ant-form-item-control-input">
                        <div class="ant-form-item-control-input-content">
                          <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" v-model="email" placeholder="请输入邮箱账号" id="email" value="" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="_1pDMxc1H">
                  <div class="ant-row ant-form-item">
                    <div class="ant-col ant-form-item-label">
                      <label for="birth" class="ant-form-item-required" title="出生日期">出生日期</label>
                    </div>
                    <div class="ant-col ant-form-item-control">
                      <div class="ant-form-item-control-input">
                        <div class="ant-form-item-control-input-content">
                          <div class="ant-picker _1F2h_OVm" style="color: #777">
                            <div class="ant-picker-input">
                              <input readonly="" placeholder="请选择出生日期" size="12" class="datepicker" />
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
                          <div class="_349CzCYy xJQe3jRu _2HG_3opa" @click="isOk"><span>保存</span></div>
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
</template>
<script>
export default {
  name: 'transRecord',
  data() {
    return {
      tabindex: true,
      mobile: null,
      email: null,
      birthday: null,
      lodingShow: false,
    };
  },
  created() {
    let that = this;
    let userInfo = JSON.parse(localStorage.getItem('userInfo'));
    that.mobile = userInfo.mobile;
    that.email = userInfo.email;
    that.birthday = userInfo.birthday;
    $('.ant-picker-input').html(userInfo.birthday);
  },
  methods: {
    changTabIndex(type) {
      let that = this;
    },
    isOk() {
      let that = this;
      that.birthday = $('.ant-picker-input').html();
      let info = { email: that.email, mobile: that.mobile, birthday: that.birthday };
      //    let regEmail = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/
      let regExp = /^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;
      let regEmail = /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/;
      if (!regExp.test(that.mobile)) {
        that.showTost('请输入正确手机号');
        return;
      }
      if (!regEmail.test(that.email)) {
        that.showTost('请输入正确邮箱号');
        return;
      }

      if (!that.birthday) {
        that.showTost('请输入生日');
        return;
      }
      that.showloading();
      that.$apiFun.post('/api/updateuserinfo', info).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          let userInfo = JSON.parse(localStorage.getItem('userInfo'));
          userInfo.mobile = info.mobile;
          userInfo.email = info.email;
          userInfo.birthday = info.birthday;
          localStorage.setItem('userInfo', JSON.stringify(userInfo));
          that.$parent.getUserInfo();
          that.showTost('操作成功');
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
    var mylaydate = laydate.render({
      elem: '.ant-picker-input',
      eventElem: '.ant-picker-input .datepicker',
      theme: 'type-ym',
      trigger: 'click',
      btns: [],
      type: 'date',
      value: '1990-04-26',
    });

    $('._2tZRPt8E li').click(function () {
      $(this).addClass('d1qCTAjZ').siblings().removeClass('d1qCTAjZ');
    });
    $(function () {
      $('#sjld').sjld('#shenfen', '#chengshi', '#quyu');
    });
  },
  watch: {
    // '$route.query'(val) {
    //   let that = this;
    //   if (val.type) {
    //     that.tabindex = val.type == 1 ? true : false;
    //   }
    // },
  },
};
</script>
<style lang="scss" scoped>
.layui-laydate-footer {
  display: none;
}
/* m_zlxg */
.m_zlxg {
  width: 93px;
  height: 40px;
  line-height: 40px;
  cursor: pointer;
  float: left;
  margin: 0 10px 0 0;
  display: inline;
  background: #f9fafc !important;
  box-shadow: inset 0 2px 4px 0 #d8e1f0 !important;
  border-radius: 6px;
}
.m_zlxg:hover {
  border: 1px solid #d7967f;
}
.m_zlxg p {
  padding-left: 10px;
  overflow: hidden;
  line-height: 40px;
  color: #666;
  font-size: 12px;
  font-family: '微软雅黑';
  text-overflow: ellipsis;
  white-space: nowrap;
}
.m_zlxg2 {
  position: absolute;
  top: 40px;
  border: 1px solid #ded3c1;
  background: #fff;
  width: 91px;
  display: none;
  max-height: 224px;
  -height: 224px;
  overflow-x: hidden;
  overflow-y: auto;
  white-space: nowrap;
}
.m_zlxg2 li {
  line-height: 28px;
  white-space: nowrap;
  padding-left: 10px;
  font-family: '微软雅黑';
  color: #333333;
  font-size: 12px;
}
.m_zlxg2 li:hover {
  color: #7a5a21;
}
</style>
