<template>
  <div class="xy_container">
    <div class="xy_loading" v-if="xy_show">
      <div class="xy_loading_content">
        <img
          src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjA2IiBoZWlnaHQ9IjgwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yMjk3XzE3MzQzKSIgZmlsbD0iI2ZmZiI+PHBhdGggZD0iTTY2Ljg1MiAyNC41NGMyLjI3MiAwIDQuMjQxIDEuNDI1IDQuNzQyIDMuNDMybDIuNjcgMTAuNjkyIDQuMzIzLTExLjE3N2MuNjgzLTEuNzY2IDIuNTIzLTIuOTQ4IDQuNTg5LTIuOTQ4aDcuNTM0bC0xMy4wNTIgMzQuNWMtMS40MTUgMy43NC01LjI5NiA2LjI1LTkuNjYgNi4yNWgtOS41NHYtMi43NDdjMC0yLjM0OSAyLjAzNC00LjI4NCA0LjYyMy00LjQgMS43MjEtLjA3NiAyLjc3Mi0uMjA3IDMuMTUxLS4zOTIuNjQ2LS4zMTYgMS4yNzEtMS41MyAxLjg3NC0zLjY0TDU5LjM5IDI0LjU0aDcuNDYzem0zMi4xNzUgMGEyLjc3IDIuNzcgMCAwMTEuOTc0Ljc2NWMuNTA3LjQ5OC43NTcgMS4xNjkuNjg2IDEuODQzbC0xLjYxMiAxOC45NGMtLjEyNyAxLjUuMTI5IDIuMTExLjc2NSAyLjU1NC40MzMuMjQuOTM2LjM1NyAxLjQ0My4zMzNhMi44NzQgMi44NzQgMCAwMDEuNDk5LS4zMzNjMS4wMjctLjU1NSAxLjE4My0xLjY2NSAxLjI2My0yLjYxbDEuNTk2LTE4Ljg4M2MuMTQ0LTEuNDYgMS40ODItMi41ODcgMy4xMDEtMi42MWg3LjQ3OWwtMi41MDQgMjkuNjAxLTEwLjM0Ni0uMDA3LjI1Mi0yLjk5OWMtLjczNi43My0xLjE0MSAxLjI1OC0xLjkwOSAxLjgzNy0xLjcyNyAxLjMwMS0zLjE1OCAxLjgyOS01LjQ4NyAxLjgyOS01LjM5NSAwLTYuOTA1LTMuMTY0LTcuMzYyLTQuOTk3LS4yNjktMS4wNTYtLjMxNC0yLjExLS4xMi00LjM4MWwxLjc2NC0yMC44ODNoNy41MTh6bS02MS45ODMgMi45NGMzLjY4My0yLjYwOCA5LjAwMy0zLjYyNCAxMi4wNzQtMy40NjIgNy41OTYuNCAxMS41MzkgNC42NzQgMTEuMDIyIDkuODM0LS42NzIgNi43MDUtOC4zNzUgNy43MzMtMTEuMDIyIDguMDU4LTMuNzcyLjQ2My02LjU4MiAxLjQ5Ni04LjQzMiAzLjEtMS40MjktNS40ODQgMS40Ni04Ljc3IDguNjY4LTkuODU2Ljk4LS4xNDggMy4yNTctLjU3MyAzLjM5My0yLjUzNC4xMzYtMS45Ni0yLjY0MS0zLjUzNC02LjQyOC0yLjU0LTQuNjg4IDEuMjMxLTcuMjc0IDUuMTY0LTcuOTc2IDguMzY5LS43MDMgMy4yMDQtLjYwNCA4LjQ2MSA1LjA3IDguNjA5IDUuNzcuMTUgMTIuNTg2LTMuMzczIDE0Ljg5OC00LjY3NGwuMTg1LS4xMDVjLjI4OS0uMTY1LjQ4Ni0uMjgyLjU3NS0uMzM2bC4wNS0uMDNjLTMuMjA0IDUuODMyLTcuNTc1IDguMDE4LTcuNTc1IDguMDE4IDEuNzUzLjgzNiA1Ljc1Mi40ODUgNi4wOS40NTNsLjAyMi0uMDAyYy0xLjc5NCAyLjU1Ny0xMS41MTUgNi4yOS0xOS45OTkgMS42OS04LjMxNC00LjUwNi01Ljg0NC0xMy4yNy01Ljc0Ny0xMy42MTNsLjAwMi0uMDFjLTEuMzIgMS4zNDUtMi42MjIgMy45MzQtMi44MTIgNC4yOTFsLS4wMi4wMzdjLS4zMTktNS43MjIgM[... 4999 chars omitted ...]"
          alt="icon"
        />
        <div class="xy_loading_text"><span class="xy_dash">-</span><span>B</span><span>O</span><span>B</span><span>.</span><span>C</span><span>O</span><span>M</span><span class="xy_dash">-</span></div>
      </div>
    </div>
    <video src="https://www.mvg0ia0.life:9152/static/bg_batch-0ac1.mp4" class="xy_video" autoplay="" preload="preload" loop=""></video>
    <div class="xy_wrapper">
      <div class="xy_logo">
        <a><img :src="$store.state.appInfo.site_logo" alt="icon" /></a>
      </div>
      <div class="xy_form_container">
        <div class="xy_top_cards">
          <div class="xy_card_box">
            <img src="/static/image/diy/login1.png" alt="card1" />
          </div>
        </div>
        <ul class="xy_form_list">
          <li class="xy_input_wrapper" :class="{ 'xy_focused': xy_nameFocused, 'xy_error': xy_nameError }">
            <input type="text" v-model="xy_name" placeholder="用户名" @focus="xy_onFocus('name')" @blur="xy_onBlur('name')" @input="xy_onInput('name')" />
            <div class="xy_input_hint" v-if="xy_nameFocused && !xy_nameError">4-11位，最少2个字母+数字组合，首位为字母</div>
            <div class="xy_input_error" v-if="xy_nameError">{{ xy_nameErrorMsg }}</div>
            <i class="xy_close_icon" v-if="xy_name && xy_nameFocused" @click="xy_clearInput('name')">×</i>
            <i class="xy_input_icon xy_user_icon" v-else></i>
          </li>
          <li class="xy_input_wrapper" :class="{ 'xy_focused': xy_passwordFocused, 'xy_error': xy_passwordError }">
            <input :type="xy_passwordVisible ? 'text' : 'password'" v-model="xy_password" placeholder="密码" @focus="xy_onFocus('password')" @blur="xy_onBlur('password')" @input="xy_onInput('password')" />
            <div class="xy_input_hint" v-if="xy_passwordFocused && !xy_passwordError">请输入您的账户密码</div>
            <div class="xy_input_error" v-if="xy_passwordError">{{ xy_passwordErrorMsg }}</div>
            <i class="xy_close_icon" v-if="xy_password && xy_passwordFocused" @click="xy_clearInput('password')">×</i>
            <div v-else class="xy_password_icons">
              <i class="xy_input_icon xy_lock_icon"></i>
              <span class="xy_eye_icon" :class="{'xy_eye_open': xy_passwordVisible}" @click="xy_togglePassword" v-if="xy_password"></span>
            </div>
          </li>
          <li class="xy_options">
            <label class="xy_remember_me">
              <input type="checkbox" v-model="xy_rememberMe" />
              <span>记住密码</span>
            </label>
            <a class="xy_forgot_pwd" @click="xy_openKefu">忘记密码?</a>
          </li>
          <li>
            <div @click="xy_loginBtn" class="xy_submit_btn" :class="{ 'xy_disabled': !xy_canLogin }">
              <span>登 录</span>
            </div>
          </li>
        </ul>
        <div class="xy_bottom_btns">
          <div class="xy_bottom_btn" @click="xy_goNav('/register')">
            <div class="xy_bottom_btn_icon">
              <img src="/static/image/diy/login_btn1.png" alt="register" />
            </div>
            <span class="xy_bottom_btn_text">立即注册</span>
          </div>
          <div class="xy_bottom_btn" @click="xy_goIndex">
            <div class="xy_bottom_btn_icon">
              <img src="/static/image/diy/login_btn2.png" alt="guest" />
            </div>
            <span class="xy_bottom_btn_text">游客进入</span>
          </div>
          <div class="xy_bottom_btn" @click="xy_openKefu">
            <div class="xy_bottom_btn_icon">
              <img src="/static/image/diy/login_btn3.png" alt="service" />
            </div>
            <span class="xy_bottom_btn_text">在线客服</span>
          </div>
        </div>
      </div>
    </div>
    <ClickCaptcha :visible="xy_showCaptcha" @success="xy_onCaptchaSuccess" @close="xy_showCaptcha = false" />
  </div>
</template>

<script>
import ClickCaptcha from './libs/ClickCaptcha.vue';

export default {
  name: 'logins',
  components: {
    ClickCaptcha
  },
  data() {
    return {
      xy_show: false,
      xy_showCaptcha: false,
      xy_name: '',
      xy_password: '',
      xy_nameFocused: false,
      xy_passwordFocused: false,
      xy_nameError: false,
      xy_passwordError: false,
      xy_passwordVisible: false,
      xy_nameErrorMsg: '',
      xy_passwordErrorMsg: '',
      xy_rememberMe: false,
      xy_jumpUrl: null,
    };
  },
  computed: {
    xy_canLogin() {
      return this.xy_name && this.xy_name.trim() && 
             this.xy_password && this.xy_password.trim() && 
             !this.xy_nameError && !this.xy_passwordError;
    }
  },
  watch: {
    xy_name() {
      this.xy_updateButtonState();
    },
    xy_password() {
      this.xy_updateButtonState();
    },
    xy_jumpUrl() {
      if (this.xy_jumpUrl) {
        window.open(this.xy_jumpUrl, '_blank');
      }
      this.xy_jumpUrl = null;
    },
  },
  created() {
    // 检查是否有保存的用户名和密码
    const savedName = localStorage.getItem('saved_username');
    const savedPassword = localStorage.getItem('saved_password');
    if (savedName && savedPassword) {
      this.xy_name = savedName;
      this.xy_password = savedPassword;
      this.xy_rememberMe = true;
      // 验证加载的内容
      this.$nextTick(() => {
        this.xy_validate('name');
        this.xy_validate('password');
        this.xy_updateButtonState();
      });
    }
  },
  mounted() {
    // 初始化按钮状态
    this.$nextTick(() => {
      this.xy_updateButtonState();
    });
  },
  methods: {
    xy_updateButtonState() {
      this.$forceUpdate();
    },
    xy_onFocus(field) {
      this[`xy_${field}Focused`] = true;
      if (this[`xy_${field}`] && this[`xy_${field}`].trim() !== '') {
        this.xy_validate(field);
      }
    },
    xy_onBlur(field) {
      this[`xy_${field}Focused`] = false;
      this.xy_validate(field);
    },
    xy_onInput(field) {
      if (this[`xy_${field}`] && this[`xy_${field}`].trim() !== '') {
        this.xy_validate(field);
      } else {
        this[`xy_${field}Error`] = false;
        this[`xy_${field}ErrorMsg`] = '';
      }
      this.xy_updateButtonState();
    },
    xy_validate(field) {
      if (field === 'name') {
        if (!this.xy_name || this.xy_name.trim() === '') {
          this.xy_nameError = true;
          this.xy_nameErrorMsg = '用户名不能为空';
        } else {
          const name = this.xy_name.trim();
          if (name.length < 4) {
            this.xy_nameError = true;
            this.xy_nameErrorMsg = '4-11位，最少2个字母+数字组合，首位为字母';
          } else if (name.length > 11) {
            this.xy_nameError = true;
            this.xy_nameErrorMsg = '4-11位，最少2个字母+数字组合，首位为字母';
          } else if (!/^[a-zA-Z]/.test(name)) {
            this.xy_nameError = true;
            this.xy_nameErrorMsg = '4-11位，最少2个字母+数字组合，首位为字母';
          } else {
            const hasLetter = /[a-zA-Z]/.test(name);
            const hasDigit = /[0-9]/.test(name);
            const letterCount = (name.match(/[a-zA-Z]/g) || []).length;
            if (!hasLetter || !hasDigit || letterCount < 2) {
              this.xy_nameError = true;
              this.xy_nameErrorMsg = '4-11位，最少2个字母+数字组合，首位为字母';
            } else {
              this.xy_nameError = false;
              this.xy_nameErrorMsg = '';
            }
          }
        }
      }
      if (field === 'password') {
        if (!this.xy_password || this.xy_password.trim() === '') {
          this.xy_passwordError = true;
          this.xy_passwordErrorMsg = '密码不能为空';
        } else {
          this.xy_passwordError = false;
          this.xy_passwordErrorMsg = '';
        }
      }
      this.xy_updateButtonState();
    },
    xy_clearInput(field) {
      this[`xy_${field}`] = '';
      this[`xy_${field}Error`] = false;
      this[`xy_${field}ErrorMsg`] = '';
      this.xy_updateButtonState();
    },
    xy_togglePassword() {
      this.xy_passwordVisible = !this.xy_passwordVisible;
    },
    xy_openKefu() {
      let that = this;
      that.xy_showTost('正在链接人工客服');
      that.$apiFun.post('/api/getservicerurl', {}).then(res => {
        if (res.code != 200) {
          that.xy_showTost(res.message);
        }
        if (res.code == 200) {
          that.xy_jumpUrl = res.data.url;
        }
      });
    },
    xy_goNav(url) {
      this.$router.push({ path: url });
    },
    xy_goIndex() {
      this.$router.push({ name: 'index' });
    },
    xy_loginBtn() {
      let that = this;
      if (!that.xy_canLogin) {
        that.xy_showTost('请输入内容');
        return;
      }
      // 先显示验证码
      that.xy_showCaptcha = true;
    },
    xy_onCaptchaSuccess() {
      // 验证码验证成功后执行登录
      this.xy_showCaptcha = false;
      this.xy_login();
    },
    xy_login() {
      let that = this;
      let info = {
        name: this.xy_name,
        password: this.xy_password,
      };
      that.xy_show = true;
      that.$apiFun.login(info).then(res => {
        if (res.code !== 200) {
          that.xy_showTost(res.message);
          that.xy_show = false;
        }
        if (res.code === 200) {
          if (that.xy_rememberMe) {
            localStorage.setItem('token', res.data.api_token);
            localStorage.setItem('saved_username', that.xy_name);
            localStorage.setItem('saved_password', that.xy_password);
          } else {
            sessionStorage.setItem('token', res.data.api_token);
            localStorage.removeItem('saved_username');
            localStorage.removeItem('saved_password');
            localStorage.removeItem('token');
          }
          that.$store.commit('changToken');
          that.xy_getUserInfo();
        }
      });
    },
    xy_getUserInfo() {
      let that = this;
      that.$apiFun.post('/api/user', {}).then(res => {
        that.xy_show = false;
        if (res.code !== 200) {
          that.xy_showTost(res.message);
        }
        if (res.code === 200) {
          let userInfo = res.data;
          let str = userInfo.current_vip;
          let index = str.indexOf('P');
          let vip = str.substr(index + 1, str.length);
          userInfo.vip = vip;
          localStorage.setItem('userInfo', JSON.stringify(userInfo));
          that.$store.commit('changUserInfo');
          that.xy_goNav('/');
        }
      });
    },
    xy_showTost(title) {
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
};
</script>

<style lang="scss" scoped>
/* 容器样式 */
.xy_container {
  position: relative;
  min-height: 100vh;
  background: #000
    url('/static/image/diy/login_bg.jpg')
    center center / cover no-repeat fixed;
  overflow: hidden;
}

.xy_container::before {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(7, 10, 20, 0.55);
  pointer-events: none;
  z-index: 0;
}

.xy_video {
  display: none;
}

.xy_wrapper {
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 40px 20px;
}

.xy_logo {
  margin-bottom: 30px;
}

.xy_logo img {
  max-width: 200px;
  height: auto;
}

.xy_form_container {
  width: 100%;
  max-width: 420px;
  position: relative;
  z-index: 1;
}

/* 顶部卡片 */
.xy_top_cards {
  position: relative;
  z-index: 1;
  display: flex;
  gap: 12px;
  justify-content: center;
  margin-bottom: 20px;
}

.xy_card_box {
  height: 120px;
  border-radius: 12px;
  overflow: hidden;
  background: rgba(31, 33, 37, 0.41);
  backdrop-filter: blur(2px);
}

.xy_card_box img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

/* 表单列表 */
.xy_form_list {
  width: 100%;
  padding: 0;
  margin: 0;
  list-style: none;
}

.xy_form_list li {
  list-style: none;
  margin: 0 0 28px 0;
  padding: 0;
}

/* 输入框样式 */
.xy_input_wrapper {
  position: relative;
  transition: all 0.3s;
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  margin-bottom: 28px;
  background: rgba(0, 0, 0, 0.3);
  backdrop-filter: blur(10px);
  padding: 0;
  height: 48px;
  display: flex;
  align-items: center;
}

.xy_input_wrapper.xy_focused {
  border-color: #3d68ff;
  box-shadow: 0 0 0 1px rgba(61, 104, 255, 0.3);
  background: rgba(0, 0, 0, 0.4);
}

.xy_input_wrapper.xy_error {
  border-color: #ff4d4f;
  box-shadow: 0 0 0 1px rgba(255, 77, 79, 0.3);
  background: rgba(0, 0, 0, 0.4);
}

.xy_input_wrapper.xy_error {
  margin-bottom: 30px;
}

.xy_input_wrapper.xy_focused:not(.xy_error) {
  margin-bottom: 30px;
}

.xy_input_wrapper input {
  border: none;
  outline: none;
  background: transparent;
  width: 100%;
  color: #fff;
  height: 48px;
  padding: 0 44px 0 16px;
  font-size: 14px;
}

.xy_input_wrapper input::placeholder {
  color: rgba(255, 255, 255, 0.5);
}

.xy_input_icon {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  z-index: 15;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.xy_password_icons {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  z-index: 15;
  display: flex;
  align-items: center;
  gap: 8px;
}

.xy_eye_icon {
  width: 20px;
  height: 20px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTggMTBDMTAuNzYxNCAxMCAxMyA3Ljc2MTQyIDEzIDVDMTMgMi4yMzg1OCAxMC43NjE0IDAgOCAwQzUuMjM4NTggMCAzIDIuMjM4NTggMyA1QzMgNy43NjE0MiA1LjIzODU4IDEwIDggMTBaIiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuNSIvPgo8L3N2Zz4K') no-repeat center;
  background-size: contain;
}

.xy_eye_icon.xy_eye_open {
  background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTggMTBDMTAuNzYxNCAxMCAxMyA3Ljc2MTQyIDEzIDVDMTMgMi4yMzg1OCAxMC43NjE0IDAgOCAwQzUuMjM4NTggMCAzIDIuMjM4NTggMyA1QzMgNy43NjE0MiA1LjIzODU4IDEwIDggMTBaIiBzdHJva2U9IiNmZmYiIHN0cm9rZS13aWR0aD0iMS41IiBmaWxsPSJub25lIi8+CjxwYXRoIGQ9Ik0xIDFMMTUgMTUiIHN0cm9rZT0iI2ZmZiIgc3Ryb2tlLXdpZHRoPSIxLjUiLz4KPC9zdmc+') no-repeat center;
  background-size: contain;
}

.xy_close_icon {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: rgba(255, 255, 255, 0.6);
  font-style: normal;
  font-size: 18px;
  line-height: 1;
  z-index: 20;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: color 0.2s;
}

.xy_close_icon:hover {
  color: rgba(255, 255, 255, 0.9);
}

.xy_input_hint {
  position: absolute;
  top: calc(100% + 4px);
  left: 0;
  width: 100%;
  background: transparent;
  color: #3d68ff;
  font-size: 12px;
  padding: 4px 0;
  opacity: 0;
  transform: translateY(-5px);
  transition: all 0.3s ease;
  pointer-events: none;
  z-index: 10;
  text-align: left;
  white-space: nowrap;
}

.xy_input_wrapper.xy_focused .xy_input_hint {
  opacity: 1;
  transform: translateY(0);
}

.xy_input_error {
  position: absolute;
  top: calc(100% + 4px);
  left: 0;
  width: 100%;
  background: transparent;
  color: #ff4d4f;
  font-size: 12px;
  padding: 4px 0;
  opacity: 1;
  z-index: 10;
  text-align: left;
  line-height: 1.5;
  min-height: 18px;
  white-space: normal;
  word-wrap: break-word;
}

/* 选项样式 */
.xy_options {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 16px 0 24px 0;
  padding: 0;
  list-style: none;
  width: 100%;
}

.xy_forgot_pwd {
  font-size: 14px;
  color: rgba(255, 255, 255, 0.7);
  cursor: pointer;
  text-decoration: none;
  transition: color 0.3s;
}

.xy_forgot_pwd:hover {
  color: #fff;
  text-decoration: underline;
}

.xy_remember_me {
  display: flex;
  align-items: center;
  cursor: pointer;
  user-select: none;
  font-size: 14px;
  color: rgba(255, 255, 255, 0.7);
}

.xy_remember_me input[type="checkbox"] {
  width: 16px;
  height: 16px;
  margin-right: 8px;
  cursor: pointer;
  accent-color: #3b82f6;
  border-radius: 3px;
  flex-shrink: 0;
}

.xy_remember_me span {
  color: rgba(255, 255, 255, 0.7);
  font-size: 14px;
  white-space: nowrap;
}

/* 登录按钮样式 */
.xy_submit_btn {
  background: #3d68ff;
  border: none;
  border-radius: 8px;
  height: 48px;
  font-size: 16px;
  font-weight: 600;
  margin-top: 15px;
  margin-bottom: 0;
  color: white;
  cursor: pointer;
  width: 100%;
  box-shadow: 0 4px 12px rgba(61, 104, 255, 0.3);
  display: flex;
  justify-content: center;
  align-items: center;
  transition: all 0.3s;
  padding: 0;
  opacity: 1;
  pointer-events: auto;
}

.xy_submit_btn:hover:not(.xy_disabled) {
  background: #2d58ef;
  box-shadow: 0 6px 16px rgba(61, 104, 255, 0.4);
  transform: translateY(-1px);
}

.xy_submit_btn.xy_disabled {
  background: #2d57efb8;
  cursor: not-allowed;
  opacity: 0.6;
  box-shadow: none;
  pointer-events: none;
}

.xy_submit_btn.xy_disabled:hover {
  transform: none;
  background: rgba(255, 255, 255, 0.2);
  box-shadow: none;
}

.xy_submit_btn span {
  display: inline-block;
  line-height: 1.5;
  color: white;
  font-size: 16px;
  font-weight: 600;
}

.xy_submit_btn.xy_disabled span {
  color: rgba(255, 255, 255, 0.6);
}

/* 底部按钮 */
.xy_bottom_btns {
  position: relative;
  z-index: 1;
  display: flex;
  justify-content: center;
  gap: 12px;
  padding: 24px 0 12px;
}

.xy_bottom_btn {
  width: 100%;
  min-height: 70px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: #ffffff0a;
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.05);
  cursor: pointer;
  transition: all 0.3s;
  padding: 12px 8px;
}

.xy_bottom_btn:hover {
  background: rgba(0, 0, 0, 0.5);
  border-color: rgba(255, 255, 255, 0.1);
  transform: translateY(-2px);
}

.xy_bottom_btn_icon {
  width: 100%;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 8px;
}

.xy_bottom_btn_icon img {
  max-width: 100%;
  max-height: 100%;
  display: block;
  object-fit: contain;
  filter: brightness(0) invert(1) opacity(0.8);
}

.xy_bottom_btn_text {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.7);
  text-align: center;
  white-space: nowrap;
  line-height: 1.2;
}

.xy_bottom_btn:hover .xy_bottom_btn_text {
  color: rgba(255, 255, 255, 0.9);
}

/* 加载动画 */
.xy_loading {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.xy_loading_content {
  text-align: center;
}

.xy_loading_text {
  color: #fff;
  font-size: 24px;
  margin-top: 20px;
}

.xy_dash {
  opacity: 0.5;
}
</style>

