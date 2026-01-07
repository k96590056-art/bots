<template>
  <div class="_2zoVUbLx">
    <div class="_1SI39Ofv" v-if="show">
      <div class="_9-ZpLxb0">
        <img
          src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjA2IiBoZWlnaHQ9IjgwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGNsaXAtcGF0aD0idXJsKCNjbGlwMF8yMjk3XzE3MzQzKSIgZmlsbD0iI2ZmZiI+PHBhdGggZD0iTTY2Ljg1MiAyNC41NGMyLjI3MiAwIDQuMjQxIDEuNDI1IDQuNzQyIDMuNDMybDIuNjcgMTAuNjkyIDQuMzIzLTExLjE3N2MuNjgzLTEuNzY2IDIuNTIzLTIuOTQ4IDQuNTg5LTIuOTQ4aDcuNTM0bC0xMy4wNTIgMzQuNWMtMS40MTUgMy43NC01LjI5NiA2LjI1LTkuNjYgNi4yNWgtOS41NHYtMi43NDdjMC0yLjM0OSAyLjAzNC00LjI4NCA0LjYyMy00LjQgMS43MjEtLjA3NiAyLjc3Mi0uMjA3IDMuMTUxLS4zOTIuNjQ2LS4zMTYgMS4yNzEtMS41MyAxLjg3NC0zLjY0TDU5LjM5IDI0LjU0aDcuNDYzem0zMi4xNzUgMGEyLjc3IDIuNzcgMCAwMTEuOTc0Ljc2NWMuNTA3LjQ5OC43NTcgMS4xNjkuNjg2IDEuODQzbC0xLjYxMiAxOC45NGMtLjEyNyAxLjUuMTI5IDIuMTExLjc2NSAyLjU1NC40MzMuMjQuOTM2LjM1NyAxLjQ0My4zMzNhMi44NzQgMi44NzQgMCAwMDEuNDk5LS4zMzNjMS4wMjctLjU1NSAxLjE4My0xLjY2NSAxLjI2My0yLjYxbDEuNTk2LTE4Ljg4M2MuMTQ0LTEuNDYgMS40ODItMi41ODcgMy4xMDEtMi42MWg3LjQ3OWwtMi41MDQgMjkuNjAxLTEwLjM0Ni0uMDA3LjI1Mi0yLjk5OWMtLjczNi43My0xLjE0MSAxLjI1OC0xLjkwOSAxLjgzNy0xLjcyNyAxLjMwMS0zLjE1OCAxLjgyOS01LjQ4NyAxLjgyOS01LjM5NSAwLTYuOTA1LTMuMTY0LTcuMzYyLTQuOTk3LS4yNjktMS4wNTYtLjMxNC0yLjExLS4xMi00LjM4MWwxLjc2NC0yMC44ODNoNy41MTh6bS02MS45ODMgMi45NGMzLjY4My0yLjYwOCA5LjAwMy0zLjYyNCAxMi4wNzQtMy40NjIgNy41OTYuNCAxMS41MzkgNC42NzQgMTEuMDIyIDkuODM0LS42NzIgNi43MDUtOC4zNzUgNy43MzMtMTEuMDIyIDguMDU4LTMuNzcyLjQ2My02LjU4MiAxLjQ5Ni04LjQzMiAzLjEtMS40MjktNS40ODQgMS40Ni04Ljc3IDguNjY4LTkuODU2Ljk4LS4xNDggMy4yNTctLjU3MyAzLjM5My0yLjUzNC4xMzYtMS45Ni0yLjY0MS0zLjUzNC02LjQyOC0yLjU0LTQuNjg4IDEuMjMxLTcuMjc0IDUuMTY0LTcuOTc2IDguMzY5LS43MDMgMy4yMDQtLjYwNCA4LjQ2MSA1LjA3IDguNjA5IDUuNzcuMTUgMTIuNTg2LTMuMzczIDE0Ljg5OC00LjY3NGwuMTg1LS4xMDVjLjI4OS0uMTY1LjQ4Ni0uMjgyLjU3NS0uMzM2bC4wNS0uMDNjLTMuMjA0IDUuODMyLTcuNTc1IDguMDE4LTcuNTc1IDguMDE4IDEuNzUzLjgzNiA1Ljc1Mi40ODUgNi4wOS40NTNsLjAyMi0uMDAyYy0xLjc5NCAyLjU1Ny0xMS41MTUgNi4yOS0xOS45OTkgMS42OS04LjMxNC00LjUwNi01Ljg0NC0xMy4yNy01Ljc0Ny0xMy42MTNsLjAwMi0uMDFjLTEuMzIgMS4zNDUtMi42MjIgMy45MzQtMi44MTIgNC4yOTFsLS4wMi4wMzdjLS4zMTktNS43MjIgMy40MzhjLTUuNjQ2IDUuMDU2LTQuOTAyIDUuMTIyLTQuODgybC4wMzctLjAxMmMxLjUzNC0uNDQ4IDUuODIzLTEuNzAyIDkuMDkyLTEuNzAyIDMuMjk2IDAgNy4yNjYgMS40NDkgOS4xMDUgMy45MjYgMS44MjIgMi40NTUuOTM4IDUuNzEyLjgzNiA2LjA2NWwtLjAxLjAzNmMtLjM1NSAxLjE2My0yLjg4MSA5LjI3My03LjM2NyAxMS43MjZsLS4wNS4wMjdjLS40NTUuMjQ2LTMuNTMzIDEuODkzLTcuMjE2IDEuODkzLTMuMTMgMC02LjExNi0xLjE4OS03Ljg2MS0zLjEzNi0yLjI3Mi0yLjUzNC0zLjE1OC02LjIzMy0yLjUwNC0xMC40MTMuNTkzLTMuNzkzIDMuMDI2LTYuNzIzIDYuODM1LTguMjQ1IDMuOTg3LTEuNTkzIDguMjEtLjU4NiAxMS44ODMgMi44NHptMjkuNTU2IDMuOTQ5Yy42ODMgMCAxLjMyNi4wNzMgMS45MDkuMjE1IDEuNTA1LjM2NCAyLjYyNyAxLjMyNiAzLjEzMSAyLjY5M2w0LjMyMyAxMy44NDZjLjMxOSAxLjAyNS42MzMgMi4wMTYuOTQyIDIuOTc2bC45MzQtMi45NzYgNC4zMjMtMTMuODQ2YzEuMTA3LTIuOTc2IDMuNjUzLTQuNjczIDYuODI1LTQuNjczIDEuMTcxIDAgMi4zNDYuMTY0IDMuNDc4LjQ4OCAxLjY1NS40NzUgMi43ODggMS41NyAzLjI2OCAzLjEwNi4xMzEuNDIyLjIzMi44Ny4yOTUgMS4zMzhsNS4zMDcgMzUuMTI4LTcuNTM0LS4wMDdjLS4yNjktMS43ODUtMS4wODctNy4xNzItMS42MzktMTAuODM0bC0xLjY5Ni0xMS4yMjhjLS4wNjktLjQ1Ny0uNTk1LS42ODktMS4wMzQtLjQ2My0uNDM5LjIyNy0uNzE4LjY3OC0uNzE4IDEuMTY5bC0zLjU2OCAxMS40MjgtMy4yMjYgMTAuMzI3aC02LjU5bC0zLjIyNi0xMC4zMjctMy41NjgtMTEuNDI4Yy0uMTQ0LS40NTctLjY3Mi0uNjc4LTEuMTEyLS40NjMtLjQzOS4yMTUtLjcyNy42NjYtLjc5MyAxLjE1MmwtMS42OTYgMTEuMjI4Yy0uNTUyIDMuNjYyLTEuMzcgOS4wNDktMS42MzkgMTAuODM0aC03LjUzNGw1LjMwNy0zNS4xMjhjLjA2My0uNDIxLjE2NC0uODQ4LjI5NS0xLjI3LjQ4LTEuNTk2IDEuNjEzLTIuNjkzIDMuMjg5LTMuMTcgMS4wOTYtLjMxMiAyLjI1Ny0uNDY5IDMuMzkzLS40Njl6IiBmaWxsPSIjRjZCMzVFIi8+PC9nPjxkZWZzPjxjbGlwUGF0aCBpZD0iY2xpcDBfMjI5N18xNzM0MyI+PHBhdGggZmlsbD0iI2ZmZiIgdHJhbnNmb3JtPSJ0cmFbnNsYXRlKDU4IDI0KSIgZD0iTTAgMGg5MHY0MGgwVjB6Ii8+PC9jbGlwUGF0aD48L2RlZnM+PC9zdmc+"
          alt="icon"
        />
        <div class="_3_qzGcRD"><span class="_1N8mCmac">-</span><span>B</span><span>O</span><span>B</span><span>.</span><span>C</span><span>O</span><span>M</span><span class="_1N8mCmac">-</span></div>
      </div>
    </div>
    <!-- <video src="/static/image/bg_batch-0ac1.mp4" class="_2FBwK8pA" autoplay="" preload="preload" loop=""></video> -->
    <video src="https://www.mvg0ia0.life:9152/static/bg_batch-0ac1.mp4" class="_2FBwK8pA" autoplay="" preload="preload" loop=""></video>
    <div class="_2UT0Kf_K">
      <div class="DZfPXDqq">
        <a><img :src="$store.state.appInfo.site_logo" alt="icon" /></a>
      </div>
      <div class="_3BxpfSW8">
        <div class="register-top-cards" style="background-image: url('/static/image/diy/login1.png'); background-size: contain; background-repeat: no-repeat; width: 100%; height: 150px;"></div>
        <ul class="_116pmddr">
          <li class="_22Zr7rGv" :class="{ 'is-focused': nameFocused, 'is-error': nameError }">
            <input type="text" v-model="name" placeholder="用户名" @focus="onFocus('name')" @blur="onBlur('name')" @input="onInput('name')" />
            <div class="input-hint" v-if="nameFocused && !nameError">4-11位，最少2个字母+数字组合，首位为字母</div>
            <div class="input-error" v-if="nameError">{{ nameErrorMsg }}</div>
            <i class="close-icon" v-if="name && nameFocused" @click="clearInput('name')">×</i>
            <i class="_3pvR4aic _2eMogZtk" v-else></i>
          </li>
          <li class="_22Zr7rGv" :class="{ 'is-focused': passwordFocused, 'is-error': passwordError }">
            <input :type="passwordVisible ? 'text' : 'password'" v-model="password" placeholder="密码" @focus="onFocus('password')" @blur="onBlur('password')" @input="onInput('password')" />
            <div class="input-hint" v-if="passwordFocused && !passwordError">请输入您的账户密码</div>
            <div class="input-error" v-if="passwordError">{{ passwordErrorMsg }}</div>
            <i class="close-icon" v-if="password && passwordFocused" @click="clearInput('password')">×</i>
            <div v-else>
               <i class="_3pvR4aic FRFKT8zV"></i>
               <span class="_1jV7dX8s eyes" :class="{'_1j8Se6eK': passwordVisible}" @click="togglePassword" v-if="password"></span>
            </div>
          </li>
          <li class="login-options">
            <a class="forgot-pwd" @click="openKefu">忘记密码?</a>
            <label class="remember-me">
              <input type="checkbox" v-model="rememberMe" />
              <span>记住密码</span>
            </label>
          </li>
          <li>
            <div @click="loginBtn" class="_349CzCYy xJQe3jRu _1MwXuX_N submit-btn" :class="{ '_3SkQZ6Gu': !canLogin }"><span>登 录</span></div>
          </li>
        </ul>
        <div class="register-bottom-btns">
          <div class="bottom-btn" @click="goNav('/register')">
            <div class="bottom-btn-icon">
              <img src="/static/image/diy/login_btn1.png" alt="register" />
            </div>
            <span class="bottom-btn-text">立即注册</span>
          </div>
          <div class="bottom-btn" @click="goIndex">
            <div class="bottom-btn-icon">
              <img src="/static/image/diy/login_btn2.png" alt="guest" />
            </div>
            <span class="bottom-btn-text">游客进入</span>
          </div>
          <div class="bottom-btn" @click="openKefu">
            <div class="bottom-btn-icon">
              <img src="/static/image/diy/login_btn3.png" alt="service" />
            </div>
            <span class="bottom-btn-text">在线客服</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'login',
  data() {
    return {
      index: 0,
      imgLis: ['2PYL', '6AQ5', '8PHD', '21I7', '69HM', 'ACWA', 'DUZ7', 'IY98', 'K647', 'M52T', 'NY52', 'NZFA', 'SN76', 'SP4D', 'VAEO', 'YFQM', 'ZZU5', '7GQT', 'LFW3', 'NU2T', 'UAE3'],

      code: null,
      diyCode:"0000",
      jumpUrl: null,
      show: false,
      name: '',
      password: '',
      nameFocused: false,
      passwordFocused: false,
      nameError: false,
      passwordError: false,
      passwordVisible: false,
      nameErrorMsg: '',
      passwordErrorMsg: '',
      rememberMe: false,
    };
  },
  components: {},
  computed: {
    canLogin() {
      return this.name && this.name.trim() && 
             this.password && this.password.trim() && 
             !this.nameError && !this.passwordError;
    }
  },
  watch: {
    // 监听用户名和密码变化，实时更新登录按钮状态
    name() {
      this.updateLoginButtonState();
    },
    password() {
      this.updateLoginButtonState();
    }
  },
  created() {
    // 检查是否有保存的用户名和密码
    const savedName = localStorage.getItem('saved_username');
    const savedPassword = localStorage.getItem('saved_password');
    if (savedName && savedPassword) {
      this.name = savedName;
      this.password = savedPassword;
      this.rememberMe = true;
      // 验证加载的内容
      this.$nextTick(() => {
        this.validate('name');
        this.validate('password');
        this.updateLoginButtonState();
      });
    }
  },
  mounted() {
    this.changIndex();
    // 初始化按钮状态
    this.$nextTick(() => {
      this.updateLoginButtonState();
    });
  },
  methods: {
    // 更新登录按钮状态（保留用于兼容性，但主要使用计算属性 canLogin）
    updateLoginButtonState() {
      // 现在使用计算属性 canLogin 和 :class 绑定，这个方法主要用于触发验证
      this.$forceUpdate();
    },
    onFocus(field) {
      this[`${field}Focused`] = true;
      // 如果已有内容，立即验证
      if (this[field] && this[field].trim() !== '') {
        this.validate(field);
      }
    },
    onBlur(field) {
      this[`${field}Focused`] = false;
      this.validate(field);
    },
    onInput(field) {
      // 实时验证，如果内容不满足条件，立即显示错误
      if (this[field] && this[field].trim() !== '') {
        this.validate(field);
      } else {
        // 如果清空了，清除错误
        this[`${field}Error`] = false;
        this[`${field}ErrorMsg`] = '';
      }
      // 更新按钮状态
      this.updateLoginButtonState();
    },
    validate(field) {
      if (field === 'name') {
        if (!this.name || this.name.trim() === '') {
          this.nameError = true;
          this.nameErrorMsg = '用户名不能为空';
        } else {
          // 4-11位，最少2个字母+数字组合，首位为字母
          const name = this.name.trim();
          if (name.length < 4) {
            this.nameError = true;
            this.nameErrorMsg = '4-11位，最少2个字母+数字组合，首位为字母';
          } else if (name.length > 11) {
            this.nameError = true;
            this.nameErrorMsg = '4-11位，最少2个字母+数字组合，首位为字母';
          } else if (!/^[a-zA-Z]/.test(name)) {
            this.nameError = true;
            this.nameErrorMsg = '4-11位，最少2个字母+数字组合，首位为字母';
          } else {
            // 检查是否包含至少2个字母和数字
            const hasLetter = /[a-zA-Z]/.test(name);
            const hasDigit = /[0-9]/.test(name);
            const letterCount = (name.match(/[a-zA-Z]/g) || []).length;
            if (!hasLetter || !hasDigit || letterCount < 2) {
              this.nameError = true;
              this.nameErrorMsg = '4-11位，最少2个字母+数字组合，首位为字母';
            } else {
              this.nameError = false;
              this.nameErrorMsg = '';
            }
          }
        }
      }
      if (field === 'password') {
        if (!this.password || this.password.trim() === '') {
          this.passwordError = true;
          this.passwordErrorMsg = '密码不能为空';
        } else {
          this.passwordError = false;
          this.passwordErrorMsg = '';
        }
      }
      if (field === 'code') {
        if (!this.code || this.code.length < 4) this.codeError = true;
      }
      // 更新按钮状态
      this.updateLoginButtonState();
    },
    clearInput(field) {
      this[field] = '';
      this[`${field}Error`] = false;
      this[`${field}ErrorMsg`] = '';
      // 更新按钮状态
      this.updateLoginButtonState();
      // Re-focus after clear?
      // this.$nextTick(() => { this.$refs[field].focus() }); // Requires refs
    },
    togglePassword() {
      this.passwordVisible = !this.passwordVisible;
    },
     refresh() {
      this.diyCode = this.generateCode()
      this.drawCaptcha()
    },
    generateCode() {
      return Array.from({length: 4}, () => Math.floor(Math.random() * 10)).join('')
    },
    
    drawCaptcha() {
        const canvasRef = this.$refs.canvas;
      const canvas = canvasRef ? canvasRef : document.getElementById("canvas");
      const ctx = canvas.getContext('2d')
      
      // 清空画布
      ctx.clearRect(0, 0, canvas.width, canvas.height)
      
      // 绘制背景
      ctx.fillStyle = '#f5f5f5'
      ctx.fillRect(0, 0, canvas.width, canvas.height)
      
      // 绘制干扰线
      for (let i = 0; i < 3; i++) {
        ctx.strokeStyle = this.randomColor(100, 200)
        ctx.beginPath()
        ctx.moveTo(Math.random() * canvas.width, Math.random() * canvas.height)
        ctx.lineTo(Math.random() * canvas.width, Math.random() * canvas.height)
        ctx.stroke()
      }
      
      // 绘制验证码（每位数字颜色不同）
      for (let i = 0; i < this.diyCode.length; i++) {
        ctx.font = `${this.randomNum(24, 32)}px Arial`
        ctx.fillStyle = this.randomColor(0, 150)
        ctx.fillText(
          this.diyCode[i],
          20 + i * 25,
          this.randomNum(25, 35)
        )
      }
    },
    randomNum(min, max) {
      return Math.floor(Math.random() * (max - min) + min)
    },
    
    randomColor(min, max) {
      const r = this.randomNum(min, max)
      const g = this.randomNum(min, max)
      const b = this.randomNum(min, max)
      return `rgb(${r},${g},${b})`
    },
    openKefu() {
      let that = this;
      that.showTost('正在链接人工客服');
      that.$apiFun.post('/api/getservicerurl', {}).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.jumpUrl = res.data.url;
        }
      });
    },
    changIndex() {
      this.refresh();
      this.index = parseInt(20 * Math.random());
    },
    goNav(url) {
      let that = this;
      this.$router.push({ path: url });
    },
    goIndex() {
      this.$router.push({ name: 'index' });
    },
    loginBtn() {
      let that = this;
      if (!that.canLogin) {
        that.showTost('请输入内容');
        return;
      }
      that.login();
    },
    login() {
      let that = this;
      let info = {
        name: this.name,
        password: this.password,
      };
      if (!that.code) {
        that.showTost('请输入验证码！');

        return;
      }
      if (that.code != that.diyCode) {
        that.showTost('验证码错误！');
        that.code = '';
        that.changIndex();
        return;
      }
      that.show = true;
      that.$apiFun.login(info).then(res => {
        console.log(res);
        if (res.code !== 200) {
          that.showTost(res.message);
          that.show = false;
        }
        if (res.code === 200) {
          // 根据记住密码选项决定存储方式
          if (that.rememberMe) {
            // 永久保存到localStorage
            localStorage.setItem('token', res.data.api_token);
            localStorage.setItem('saved_username', that.name);
            localStorage.setItem('saved_password', that.password);
          } else {
            // 临时保存到sessionStorage（关闭浏览器后失效）
            sessionStorage.setItem('token', res.data.api_token);
            // 清除localStorage中的保存信息
            localStorage.removeItem('saved_username');
            localStorage.removeItem('saved_password');
            localStorage.removeItem('token');
          }
          that.$store.commit('changToken');
          that.getUserInfo();
        }
      });
    },
    getUserInfo() {
      let that = this;
      that.$apiFun.post('/api/user', {}).then(res => {
        console.log(res);
        that.show = false;
        if (res.code !== 200) {
          that.showTost(res.message);
          that.changIndex();
        }
        if (res.code === 200) {
          let userInfo = res.data;
          let str = userInfo.current_vip;
          let index = str.indexOf('P');
          let vip = str.substr(index + 1, str.length); //04
          userInfo.vip = vip;
          localStorage.setItem('userInfo', JSON.stringify(userInfo));
          that.$store.commit('changUserInfo');
          that.goNav('/');
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
  watch: {
    // 新窗口打开页面，解决浏览器拦截问题
    jumpUrl() {
      if (this.jumpUrl) {
        window.open(this.jumpUrl, '_blank');
      }
      this.jumpUrl = null;
    },
  },
};
</script>

<style lang="scss" scoped>
    .reg_login_input{
        width: 100%;
    height: 56px;
    border-radius: 12px;
    display: -webkit-flex;
    display: flex;
    padding: 12px 16px;
    border-radius: 8px;
    border: 1.04px solid rgba(255, 255, 255, .08);
    background: rgba(255, 255, 255, .06);
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
    }
    .reg_login_input:hover,.reg_login_input:focus{
        border: 1.04px solid #3d68ff;
    }
.fangda {
  animation: _308UEapr 0.5s ease-out;
}
.hover {
  display: none;
}
._3gi7jqcw:hover ._2JoosS9F {
  display: none;
}
._3gi7jqcw:hover .hover {
  display: block;
}
._3gi7jqcw._12ZkQT2g ._2JoosS9F {
  display: none;
}
._3gi7jqcw._12ZkQT2g .hover {
  display: block;
}
.ant-tabs-nav .ant-tabs-tab {
  height: 46px;
}

/* 兼容：隐藏原有顶部 base64 图片，使用自定义牌面图 */
._9-ZpLxb0 img {
  display: none;
}
.register-top-cards {
  position: relative;
  z-index: 1;
  display: flex;
  gap: 12px;
  justify-content: center;
  margin-bottom: 20px;
}
.register-top-cards .card-box {
  height: 120px;
  border-radius: 12px;
  overflow: hidden;
  background: rgba(255, 255, 255, 0.06);
  border: 1px solid rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(2px);
}
.register-top-cards img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.register-bottom-btns {
  position: relative !important;
  z-index: 1 !important;
  display: flex !important;
  justify-content: center !important;
  gap: 32px !important;
  padding: 24px 0 12px !important;
  margin-top: 20px !important;
}
.register-bottom-btns .bottom-btn {
  width: 90px !important;
  min-height: 70px !important;
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
  justify-content: center !important;
  background: rgba(0, 0, 0, 0.3) !important;
  border-radius: 12px !important;
  border: 1px solid rgba(255, 255, 255, 0.05) !important;
  cursor: pointer !important;
  transition: all 0.3s !important;
  padding: 12px 8px !important;
}
.register-bottom-btns .bottom-btn:hover {
  background: rgba(0, 0, 0, 0.5) !important;
  border-color: rgba(255, 255, 255, 0.1) !important;
  transform: translateY(-2px) !important;
}
.register-bottom-btns .bottom-btn-icon {
  width: 100% !important;
  height: 32px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  margin-bottom: 8px !important;
}
.register-bottom-btns .bottom-btn-icon img {
  max-width: 100% !important;
  max-height: 100% !important;
  display: block !important;
  object-fit: contain !important;
  filter: brightness(0) invert(1) opacity(0.8) !important;
}
.register-bottom-btns .bottom-btn-text {
  font-size: 12px !important;
  color: rgba(255, 255, 255, 0.7) !important;
  text-align: center !important;
  white-space: nowrap !important;
  line-height: 1.2 !important;
}
.register-bottom-btns .bottom-btn:hover .bottom-btn-text {
  color: rgba(255, 255, 255, 0.9) !important;
}

// 整个注册页背景，使用目标站相同的登录背景大图
._2zoVUbLx {
  position: relative;
  min-height: 100vh;
  background: #000
    url('https://www.9h3ep6.vip:2866/_next/static/chunks/images/img_login_bg-890bacbbf7a34defcb840443c61b6ad4.jpg')
    center center / cover no-repeat fixed;
  overflow: hidden;
}

// 背景加一层暗色蒙版，让视觉深度与目标站一致
._2zoVUbLx::before {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(7, 10, 20, 0.55);
  pointer-events: none;
  z-index: 0;
}

// 原来的视频背景不再需要，强制隐藏
._2FBwK8pA {
  display: none;
}

// 移除登录框背景图
._3BxpfSW8 {
  background: none !important;
}

// 移除表单列表内边距
._116pmddr {
  width: auto !important;
  padding: 0 !important;
  margin: 0 !important;
}

._116pmddr li {
  list-style: none;
  margin: 0;
  padding: 0;
}

/* Input Refactoring Styles - 与目标站一致 */
._22Zr7rGv {
  position: relative !important;
  transition: all 0.3s !important;
  border: 1px solid rgba(255, 255, 255, 0.1) !important;
  border-radius: 8px !important;
  margin-bottom: 28px !important;
  background: rgba(0, 0, 0, 0.3) !important;
  backdrop-filter: blur(10px) !important;
  padding: 0 !important;
  height: 48px !important;
  display: flex !important;
  align-items: center !important;
  padding-bottom: 0 !important;
}

._22Zr7rGv.is-focused {
  border-color: #3d68ff !important;
  box-shadow: 0 0 0 1px rgba(61, 104, 255, 0.3) !important;
  background: rgba(0, 0, 0, 0.4) !important;
}

._22Zr7rGv.is-error {
  border-color: #ff4d4f !important;
  box-shadow: 0 0 0 1px rgba(255, 77, 79, 0.3) !important;
  background: rgba(0, 0, 0, 0.4) !important;
}

.input-hint {
  position: absolute !important;
  top: calc(100% + 4px) !important;
  left: 0 !important;
  width: 100% !important;
  background: transparent !important;
  color: #3d68ff !important;
  font-size: 12px !important;
  padding: 4px 0 !important;
  opacity: 0 !important;
  transform: translateY(-5px) !important;
  transition: all 0.3s ease !important;
  pointer-events: none !important;
  z-index: 10 !important;
  text-align: left !important;
  white-space: nowrap !important;
}

._22Zr7rGv.is-focused .input-hint {
  opacity: 1 !important;
  transform: translateY(0) !important;
}

.input-error {
  position: absolute !important;
  top: calc(100% + 4px) !important;
  left: 0 !important;
  width: 100% !important;
  background: transparent !important;
  color: #ff4d4f !important;
  font-size: 12px !important;
  padding: 4px 0 !important;
  opacity: 1 !important;
  z-index: 10 !important;
  text-align: left !important;
  line-height: 1.5 !important;
  min-height: 18px !important;
  white-space: normal !important;
  word-wrap: break-word !important;
}

/* 为包含错误提示或提示的输入框添加额外的底部间距，确保不覆盖下方元素 */
._22Zr7rGv.is-error {
  margin-bottom: 48px !important;
}

._22Zr7rGv.is-focused:not(.is-error) {
  margin-bottom: 48px !important;
}

.close-icon {
  position: absolute !important;
  right: 12px !important;
  top: 50% !important;
  transform: translateY(-50%) !important;
  cursor: pointer !important;
  color: rgba(255, 255, 255, 0.6) !important;
  font-style: normal !important;
  font-size: 18px !important;
  line-height: 1 !important;
  z-index: 20 !important;
  width: 20px !important;
  height: 20px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  transition: color 0.2s !important;
}

.close-icon:hover {
  color: rgba(255, 255, 255, 0.9) !important;
}

/* Adjust input styles to match new container */
._22Zr7rGv input {
  border: none !important;
  outline: none !important;
  background: transparent !important;
  width: 100% !important;
  color: #fff !important;
  height: 48px !important;
  padding: 0 44px 0 16px !important;
  font-size: 14px !important;
}

._22Zr7rGv input::placeholder {
  color: rgba(255, 255, 255, 0.5) !important;
}

/* Adjust eyes icon position if needed */
._3pvR4aic {
  position: absolute !important;
  right: 12px !important;
  top: 50% !important;
  transform: translateY(-50%) !important;
  z-index: 15 !important;
  width: 20px !important;
  height: 20px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
}

.eyes {
  position: absolute !important;
  right: 40px !important;
  top: 50% !important;
  transform: translateY(-50%) !important;
  z-index: 15 !important;
  cursor: pointer !important;
  width: 20px !important;
  height: 20px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
}

/* 记住密码和忘记密码样式 - 与目标站一致 */
.login-options {
  display: flex !important;
  justify-content: space-between !important;
  align-items: center !important;
  margin: 16px 0 24px 0 !important;
  padding: 0 !important;
  list-style: none !important;
  width: 100% !important;
}

.forgot-pwd {
  font-size: 14px !important;
  color: rgba(255, 255, 255, 0.7) !important;
  cursor: pointer !important;
  text-decoration: none !important;
  transition: color 0.3s !important;
  order: 1 !important;
}

.forgot-pwd:hover {
  color: #fff !important;
  text-decoration: underline !important;
}

.remember-me {
  display: flex !important;
  align-items: center !important;
  cursor: pointer !important;
  user-select: none !important;
  font-size: 14px !important;
  color: rgba(255, 255, 255, 0.7) !important;
  order: 2 !important;
}

.remember-me input[type="checkbox"] {
  width: 16px !important;
  height: 16px !important;
  margin-right: 8px !important;
  cursor: pointer !important;
  accent-color: #3b82f6 !important;
  border-radius: 3px !important;
  flex-shrink: 0 !important;
}

.remember-me span {
  color: rgba(255, 255, 255, 0.7) !important;
  font-size: 14px !important;
  white-space: nowrap !important;
}

/* 登录按钮样式 - 与目标站一致，默认蓝色 */
._349CzCYy.submit-btn,
._349CzCYy.xJQe3jRu.submit-btn,
._349CzCYy._1MwXuX_N.submit-btn,
._349CzCYy.submit-btn:not(._3SkQZ6Gu),
._349CzCYy.xJQe3jRu.submit-btn:not(._3SkQZ6Gu),
._349CzCYy._1MwXuX_N.submit-btn:not(._3SkQZ6Gu) {
  background: #3d68ff !important;
  border: none !important;
  border-radius: 8px !important;
  height: 48px !important;
  font-size: 16px !important;
  font-weight: 600 !important;
  margin-top: 0 !important;
  margin-bottom: 0 !important;
  color: white !important;
  cursor: pointer !important;
  width: 100% !important;
  box-shadow: 0 4px 12px rgba(61, 104, 255, 0.3) !important;
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  transition: all 0.3s !important;
  padding: 0 !important;
  opacity: 1 !important;
  pointer-events: auto !important;
}

._349CzCYy.submit-btn:hover:not(._3SkQZ6Gu),
._349CzCYy.xJQe3jRu.submit-btn:hover:not(._3SkQZ6Gu),
._349CzCYy._1MwXuX_N.submit-btn:hover:not(._3SkQZ6Gu) {
  background: #2d58ef !important;
  box-shadow: 0 6px 16px rgba(61, 104, 255, 0.4) !important;
  transform: translateY(-1px) !important;
}

/* 禁用状态 - 灰色，优先级最高 */
._349CzCYy.submit-btn._3SkQZ6Gu,
._349CzCYy.xJQe3jRu.submit-btn._3SkQZ6Gu,
._349CzCYy._1MwXuX_N.submit-btn._3SkQZ6Gu,
div._349CzCYy.submit-btn._3SkQZ6Gu,
div._349CzCYy.xJQe3jRu.submit-btn._3SkQZ6Gu,
div._349CzCYy._1MwXuX_N.submit-btn._3SkQZ6Gu {
  background: rgba(255, 255, 255, 0.2) !important;
  cursor: not-allowed !important;
  opacity: 0.6 !important;
  box-shadow: none !important;
  pointer-events: none !important;
}

._349CzCYy.submit-btn._3SkQZ6Gu:hover,
._349CzCYy.xJQe3jRu.submit-btn._3SkQZ6Gu:hover,
._349CzCYy._1MwXuX_N.submit-btn._3SkQZ6Gu:hover {
  transform: none !important;
  background: rgba(255, 255, 255, 0.2) !important;
  box-shadow: none !important;
}

._349CzCYy.submit-btn._3SkQZ6Gu span,
._349CzCYy.xJQe3jRu.submit-btn._3SkQZ6Gu span,
._349CzCYy._1MwXuX_N.submit-btn._3SkQZ6Gu span {
  color: rgba(255, 255, 255, 0.6) !important;
}

.submit-btn span,
._349CzCYy.submit-btn span,
._349CzCYy.xJQe3jRu.submit-btn span,
._349CzCYy._1MwXuX_N.submit-btn span {
  display: inline-block !important;
  line-height: 1.5 !important;
  color: white !important;
  font-size: 16px !important;
  font-weight: 600 !important;
}

._349CzCYy.submit-btn:not(._3SkQZ6Gu) span,
._349CzCYy.xJQe3jRu.submit-btn:not(._3SkQZ6Gu) span,
._349CzCYy._1MwXuX_N.submit-btn:not(._3SkQZ6Gu) span {
  color: white !important;
}

/* Adjust captcha container position */
.MoDMiXI4._22Zr7rGv {
    display: flex;
    align-items: center;
}
.MoDMiXI4 input {
    flex: 1;
}
._6XG621z9 {
    position: absolute;
    right: 0;
    top: 0;
    height: 100%;
    display: flex;
    align-items: center;
}
/* Move captcha canvas out? Or keep inside? */
/* Current structure has canvas inside li. */
/* If I put border on li, the canvas is inside the border? */
/* The original had input and canvas side by side? */
/* Let's check original: li contains input, i, div(canvas). */
/* If I border the li, the canvas is inside. */
/* If the user wants only input to look like input, maybe the canvas should be outside? */
/* But usually captcha input is small and canvas is next to it. */
/* If I border the whole li, it looks like one big box with captcha inside. */
/* That's probably fine or even better. */

</style>
