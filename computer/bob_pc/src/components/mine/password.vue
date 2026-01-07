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
          <div class="T5pPAuRQ">密码管理</div>
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
              <div class="ant-tabs-nav-wrap">
                <div class="ant-tabs-nav-scroll">
                  <div class="ant-tabs-nav ant-tabs-nav-animated">
                    <div>
                      <div role="tab" @click="changType('pasType', 1)" :class="pasType == 1 ? 'ant-tabs-tab-active ant-tabs-tab' : 'ant-tabs-tab'" aria-controls="tabpane-1">登陆密码</div>
                      <div role="tab" @click="changType('pasType', 2)" :class="pasType == 2 ? 'ant-tabs-tab-active ant-tabs-tab' : 'ant-tabs-tab'" id="tab-2" aria-controls="tabpane-2">支付密码</div>
                    </div>
                    <div class="ant-tabs-ink-bar ant-tabs-ink-bar-animated" :style="`display: block; transform: translate3d(${(pasType - 1) * 88}px, 0px, 0px); width: 56px`"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="ant-tabs-content ant-tabs-content-animated ant-tabs-top-content" :style="`margin-left: ${(pasType - 1) * -100}%`">
            <div class="ant-tabs-tabpane">
              <form class="ant-form ant-form-horizontal _1JCYefEr">
                <div class="_3Pl0cJXW">
                  <div class="_1pDMxc1H _32QwQ_nM">
                    <div class="ant-row ant-form-item">
                      <div class="ant-col ant-form-item-label">
                        <label for="old_password" class="ant-form-item-required" title="原密码">原密码</label>
                      </div>
                      <div class="ant-col ant-form-item-control">
                        <div class="ant-form-item-control-input">
                          <div class="ant-form-item-control-input-content">
                            <span class="_3ON7kyGT ant-input-affix-wrapper">
                              <input autocomplete="off" class="ant-input" type="password" v-model="passwordInfo.password" maxlength="16" placeholder="请输入原密码" id="old_password" />
                              <span class="ant-input-suffix eyes1"><img class="_37O_WWSt" src="/static/image/eyes.png" alt="" /></span
                            ></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="_1pDMxc1H _32QwQ_nM">
                    <div class="ant-row ant-form-item">
                      <div class="ant-col ant-form-item-label">
                        <label for="new_password" class="ant-form-item-required" title="新密码">新密码</label>
                      </div>
                      <div class="ant-col ant-form-item-control">
                        <div class="ant-form-item-control-input">
                          <div class="ant-form-item-control-input-content">
                            <span class="_3ON7kyGT ant-input-affix-wrapper">
                              <input autocomplete="off" class="ant-input" type="password" v-model="passwordInfo.paypassword" maxlength="16" placeholder="请输入新密码" id="new_password" />
                              <span class="ant-input-suffix eyes2"><img class="_37O_WWSt" src="/static/image/eyes.png" alt="" /></span
                            ></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="_1pDMxc1H _32QwQ_nM">
                    <div class="ant-row ant-form-item">
                      <div class="ant-col ant-form-item-label">
                        <label for="new_password_confirmation" class="ant-form-item-required" title="确认新密码">确认新密码</label>
                      </div>
                      <div class="ant-col ant-form-item-control">
                        <div class="ant-form-item-control-input">
                          <div class="ant-form-item-control-input-content">
                            <span class="_3ON7kyGT ant-input-affix-wrapper">
                              <input autocomplete="off" class="ant-input" type="password" v-model="passwordInfo.newpasword" maxlength="16" placeholder="请输入确认新密码" id="new_password_confirmation" />
                              <span class="ant-input-suffix eyes3"><img class="_37O_WWSt" src="/static/image/eyes.png" alt="" /></span
                            ></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="_349CzCYy xJQe3jRu z0QZN3OV" @click="editPassword"><span>完成</span></div>
                </div>
              </form>
            </div>
            <div class="ant-tabs-tabpane">
              <form class="ant-form ant-form-horizontal gjLFKc9z">
                <div class="_3Pl0cJXW">
                  <div class="_1pDMxc1H _32QwQ_nM">
                    <div class="ant-row ant-form-item">
                      <div class="ant-col ant-form-item-label">
                        <label for="old_password" class="ant-form-item-required" title="原密码">原密码</label>
                      </div>
                      <div class="ant-col ant-form-item-control">
                        <div class="ant-form-item-control-input">
                          <div class="ant-form-item-control-input-content">
                            <span class="_3ON7kyGT ant-input-affix-wrapper">
                              <input autocomplete="off" class="ant-input" type="password" v-model="passwordInfo.password" maxlength="16" placeholder="请输入原密码" id="old_password" />
                              <span class="ant-input-suffix eyes1"><img class="_37O_WWSt" src="/static/image/eyes.png" alt="" /></span
                            ></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="_1pDMxc1H _32QwQ_nM">
                    <div class="ant-row ant-form-item">
                      <div class="ant-col ant-form-item-label">
                        <label for="new_password" class="ant-form-item-required" title="新密码">新密码</label>
                      </div>
                      <div class="ant-col ant-form-item-control">
                        <div class="ant-form-item-control-input">
                          <div class="ant-form-item-control-input-content">
                            <span class="_3ON7kyGT ant-input-affix-wrapper">
                              <input autocomplete="off" class="ant-input" type="password" v-model="passwordInfo.paypassword" maxlength="16" placeholder="请输入新密码" id="new_password" />
                              <span class="ant-input-suffix eyes2"><img class="_37O_WWSt" src="/static/image/eyes.png" alt="" /></span
                            ></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="_1pDMxc1H _32QwQ_nM">
                    <div class="ant-row ant-form-item">
                      <div class="ant-col ant-form-item-label">
                        <label for="new_password_confirmation" class="ant-form-item-required" title="确认新密码">确认新密码</label>
                      </div>
                      <div class="ant-col ant-form-item-control">
                        <div class="ant-form-item-control-input">
                          <div class="ant-form-item-control-input-content">
                            <span class="_3ON7kyGT ant-input-affix-wrapper">
                              <input autocomplete="off" class="ant-input" type="password" v-model="passwordInfo.newpasword" maxlength="16" placeholder="请输入确认新密码" id="new_password_confirmation" />
                              <span class="ant-input-suffix eyes3"><img class="_37O_WWSt" src="/static/image/eyes.png" alt="" /></span
                            ></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="_349CzCYy xJQe3jRu z0QZN3OV" @click="editPassword"><span>完成</span></div>
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
      pasType: 1, //1登陆密码  2支付密码
      passwordInfo: {},
      lodingShow: false,
    };
  },
  methods: {
    changType(name, val) {
      let that = this;
      if (that[name] == val) {
        return;
      }
      if ('pasType' == name) {
        //密码变化
        that.passwordInfo = {};
      }
      that[name] = val;
    },
    editPassword() {
      let that = this;
      if (!that.passwordInfo.password) {
        that.showTost('请输入旧密码');
        return;
      }
      if (!that.passwordInfo.paypassword) {
        that.showTost('请输入新密码');
        return;
      }
      if (that.passwordInfo.password.length < 6) {
        that.showTost('请输入正确的旧密码长度');
        return;
      }
      if (that.passwordInfo.paypassword.length < 6) {
        that.showTost('请输入正确的新密码长度');
        return;
      }
      if (!that.passwordInfo.newpasword) {
        that.showTost('请输入确认密码');
        return;
      }
      if (that.passwordInfo.newpasword != that.passwordInfo.paypassword) {
        that.showTost('两次密码不一致！');
        return;
      }
      if (that.passwordInfo.password == that.passwordInfo.paypassword) {
        that.showTost('新旧密码不能一致！');
        that.passwordInfo = {};
        return;
      }
      let url = that.pasType == 1 ? '/api/editPassword' : '/api/editPayPassword';
      that.showloading();
      that.$apiFun.post(url, that.passwordInfo).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        that.hideloading();
        if (res.code == 200) {
          that.showTost('密码修改成功！');
          that.passwordInfo = {};
          if (that.pasType == 1) {
            sessionStorage.setItem('token', '');
            that.$router.push({ path: '/login' });
          }
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
    var i = true; //表示开关
    $('.eyes1').click(function () {
      if (i) {
        var src = $(this).find('img').attr('src');
        src = src.substring(0, src.lastIndexOf('.'));
        $(this)
          .find('img')
          .attr('src', src + '-hover.png');
        $(this).prev('input').attr('type', 'text');
        i = false;
      } else {
        var src = $(this).find('img').attr('src');
        src = src.substring(0, src.lastIndexOf('-hover.png'));
        $(this)
          .find('img')
          .attr('src', src + '.png');
        $(this).prev('input').attr('type', 'password');
        i = true;
      }
    });
    var ii = true; //表示开关
    $('.eyes2').click(function () {
      if (ii) {
        var src = $(this).find('img').attr('src');
        src = src.substring(0, src.lastIndexOf('.'));
        $(this)
          .find('img')
          .attr('src', src + '-hover.png');
        $(this).prev('input').attr('type', 'text');
        ii = false;
      } else {
        var src = $(this).find('img').attr('src');
        src = src.substring(0, src.lastIndexOf('-hover.png'));
        $(this)
          .find('img')
          .attr('src', src + '.png');
        $(this).prev('input').attr('type', 'password');
        ii = true;
      }
    });
    var iii = true; //表示开关
    $('.eyes3').click(function () {
      if (iii) {
        var src = $(this).find('img').attr('src');
        src = src.substring(0, src.lastIndexOf('.'));
        $(this)
          .find('img')
          .attr('src', src + '-hover.png');
        $(this).prev('input').attr('type', 'text');
        iii = false;
      } else {
        var src = $(this).find('img').attr('src');
        src = src.substring(0, src.lastIndexOf('-hover.png'));
        $(this)
          .find('img')
          .attr('src', src + '.png');
        $(this).prev('input').attr('type', 'password');
        iii = true;
      }
    });
  },
};
</script>
<style lang="scss" scoped>
</style>
