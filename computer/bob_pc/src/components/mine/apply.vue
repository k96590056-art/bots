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
          <div class="T5pPAuRQ">申请代理<span>请填写真实申请信息，以便管理员审核代理信息！</span></div>
        </div>
        <div class="ant-tabs ant-tabs-top ant-tabs-line">
          <div class="ant-tabs-content ant-tabs-content-animated ant-tabs-top-content" :style="`margin-left: ${(pasType - 1) * -100}%`">
               <div role="tabpanel" aria-hidden="false" tabindex="0" class="ant-tabs-tabpane ant-tabs-tabpane-active" style="visibility: visible">
              <form class="ant-form ant-form-horizontal _1JCYefEr">
                                <div class="_1pDMxc1H">
                  <div class="ant-row ant-form-item">
                    <div class="ant-col ant-form-item-label">
                      <label for="email" class="ant-form-item-required" title="您的姓名">您的姓名</label>
                    </div>

                    <div class="ant-col ant-form-item-control">
                      <div class="ant-form-item-control-input">
                        <div class="ant-form-item-control-input-content">
                          <input autocomplete="off" class="ant-input _3ON7kyGT" type="text" :value='$store.state.userInfo.realname'  placeholder="请输入您的姓名"   />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="_1pDMxc1H">
                  <div class="ant-row ant-form-item">
                    <div class="ant-col ant-form-item-label">
                      <label for="phone" class="ant-form-item-required" title="手机号码">手机号码</label>
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
                      <label for="birth" class="ant-form-item-required" title="申请说明">申请说明</label>
                    </div>
                           <div class="ant-col ant-form-item-control">
                      <div class="ant-form-item-control-input">
                        <div class="ant-form-item-control-input-content">
                          <textarea class="ant-input _3ON7kyGT" style="height:200px;padding:10px" v-model="apply_info" placeholder="请输入申请说明" ></textarea>

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
                          <div class="_349CzCYy xJQe3jRu _2HG_3opa" @click="isOk"><span>提交申请</span></div>
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
      pasType: 1, //1登陆密码  2支付密码
      passwordInfo: {},
      lodingShow: false,apply_info:null,mobile:null
    };
  },
  methods: {
        isOk() {
      let that = this;
      that.birthday = $('.ant-picker-input').html();
      let info = { mobile: that.mobile, apply_info: that.apply_info };
      let regExp = /^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;
      if (!regExp.test(that.mobile)) {
        that.showTost('请输入正确手机号');
        return;
      }

      if (!that.apply_info) {
        that.showTost('请输入申请理由');
        return;
      }
      that.showloading();
      that.$apiFun.post('/api/applyagentdo', info).then(res => {
         that.showTost(res.message);
         that.hideloading();

      }).catch(res=>{
          that.hideloading();
      });
    },
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
