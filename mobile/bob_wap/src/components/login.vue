<template>
  <div class="mobile-login-container">
    <!-- 顶部Logo -->
    <div class="login-header">
      <div class="login-logo">
        <img 
          :src="$store.state.appInfo.site_logo || '/static/image/uacPoGJlb02AMGnUAAAYLvRuglw960.png'" 
          alt="Logo" 
          class="logo-img"
          @error="handleLogoError"
        />
      </div>
    </div>

    <!-- 登录表单 -->
    <div class="login-form-wrapper">
      <div class="login-form">
        <!-- 账号输入 -->
        <div class="input-group">
          <input 
            v-model="formData.name" 
            type="text" 
            placeholder="账号" 
            class="login-input"
            maxlength="32"
            autocomplete="off"
          />
        </div>
        
        <!-- 密码输入 -->
        <div class="input-group password-group">
          <input 
            v-model="formData.password" 
            :type="psw1 ? 'password' : 'text'" 
            placeholder="密码" 
            class="login-input"
            maxlength="32"
            autocomplete="off"
          />
          <div class="password-toggle" @click="changPsw('psw1')">
            <img
              :src="psw1 ? '/static/image/no_see.png' : '/static/image/see.png'"
              alt="显示/隐藏密码"
              class="eye-icon"
            />
          </div>
        </div>

        <!-- 确认密码输入（仅注册模式显示） -->
        <div class="input-group password-group" v-if="!isLogin">
          <input 
            v-model="formData.confirmPass" 
            :type="psw2 ? 'password' : 'text'" 
            placeholder="确定密码" 
            class="login-input"
            maxlength="32"
            autocomplete="off"
          />
          <div class="password-toggle" @click="changPsw('psw2')">
            <img
              :src="psw2 ? '/static/image/no_see.png' : '/static/image/see.png'"
              alt="显示/隐藏密码"
              class="eye-icon"
            />
          </div>
        </div>

        <!-- 图片数字验证码（在记住密码上方） -->
        <div class="input-group captcha-group">
          <input
            v-model="captchaCode"
            type="text"
            placeholder="请输入图片中的数字"
            class="login-input captcha-input"
            maxlength="6"
            autocomplete="off"
          />
          <div class="captcha-image-wrap" @click="getCaptcha">
            <canvas ref="captchaCanvas" class="captcha-canvas" width="120" height="50"></canvas>
          </div>
        </div>

        <!-- 记住密码和忘记密码（仅登录模式显示） -->
        <div class="login-options" v-if="isLogin">
          <label class="remember-password">
            <input type="checkbox" v-model="rememberPassword" />
            <span>记住密码</span>
          </label>
          <a href="#" class="forgot-password" @click.prevent="handleForgotPassword">忘记密码?</a>
        </div>

        <!-- 同意条款（仅注册模式显示） -->
        <div class="agree-terms" v-if="!isLogin">
          <label class="agree-checkbox">
            <input type="checkbox" v-model="agreeTerms" />
            <span class="checkbox-custom"></span>
          </label>
          <span class="agree-text">
            我已阅读并同意
            <a href="#" class="terms-link" @click.prevent="handleTermsClick">相关条款</a>
            和
            <a href="#" class="terms-link" @click.prevent="handlePrivacyClick">隐私政策</a>
          </span>
        </div>

        <!-- 登录/注册按钮 -->
        <button class="login-btn" @click="submitForm">
          {{ isLogin ? '登录' : '注册' }}
        </button>
      </div>
    </div>

    <!-- 合作伙伴区域 -->
    <div class="sponsor-section">
      <img src="/static/image/diy/login1.png" alt="" class="sponsor-image" />
    </div>

    <!-- 底部按钮 -->
    <div class="bottom-actions">
      <button class="action-btn register-btn" @click="toggleLoginMode">
        <img src="/static/image/diy/login_btn1.png" :alt="isLogin ? '立即注册' : '前往登录'" class="btn-image" />
        <span class="btn-text">{{ isLogin ? '立即注册' : '前往登录' }}</span>
      </button>
      <button class="action-btn guest-btn" @click="$parent.goNav('/')">
        <img src="/static/image/diy/login_btn2.png" alt="游客进入" class="btn-image" />
        <span class="btn-text">游客进入</span>
      </button>
      <button class="action-btn service-btn" @click="$parent.openKefu">
        <img src="/static/image/diy/login_btn3.png" alt="在线客服" class="btn-image" />
        <span class="btn-text">在线客服</span>
      </button>
    </div>
    
  </div>
</template>

<script>
export default {
  name: 'login',
  data() {
    return {
      captchaCode: '',
      captchaAnswer: '', // 前端生成的正确答案，提交时本地校验
      formData: {
        name: '',
        password: '',
        confirmPass: '',
        realname: '',
        paypassword: '',
      },
      isLogin: true,
      psw1: true,
      psw2: true,
      psw3: true,
      pid: '',
      rememberPassword: false,
      agreeTerms: false,
    };
  },
  created() {
    let that = this;
    var query = that.$route.query;
    if (query.type) {
      that.isLogin = query.type === '0';
    }
    if (query.pid) {
      that.pid = query.pid;
    }
    // 回填记住的账号密码
    try {
      const saved = localStorage.getItem('login_remember');
      if (saved) {
        const obj = JSON.parse(saved);
        if (obj && obj.name) {
          that.formData.name = obj.name;
          that.formData.password = obj.password || '';
          that.rememberPassword = true;
        }
      }
    } catch (e) {}
  },
  mounted() {
    this.$nextTick(() => this.getCaptcha());
  },
  methods: {
    // 在 captcha-image-wrap 内的 canvas 上直接绘制数字验证码
    getCaptcha() {
      const canvas = this.$refs.captchaCanvas;
      if (!canvas) return;
      const ctx = canvas.getContext('2d');
      if (!ctx) return;
      const len = 4;
      const chars = '0123456789';
      let text = '';
      for (let i = 0; i < len; i++) {
        text += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      this.captchaAnswer = text;
      this.captchaCode = '';
      const w = 120;
      const h = 50;
      // 白底，与紫色区域对比明显
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(0, 0, w, h);
      // 噪线
      for (let i = 0; i < 4; i++) {
        ctx.strokeStyle = 'rgba(150,150,150,0.4)';
        ctx.beginPath();
        ctx.moveTo(Math.random() * w, Math.random() * h);
        ctx.lineTo(Math.random() * w, Math.random() * h);
        ctx.stroke();
      }
      // 噪点
      for (let i = 0; i < 30; i++) {
        ctx.fillStyle = 'rgba(120,120,120,0.4)';
        ctx.fillRect(Math.random() * w, Math.random() * h, 2, 2);
      }
      // 数字：深色加粗，清晰可见
      const fontGap = w / (len + 1);
      ctx.textBaseline = 'middle';
      for (let i = 0; i < len; i++) {
        ctx.save();
        ctx.font = `bold ${24 + Math.random() * 4}px Arial`;
        ctx.fillStyle = '#222222';
        const x = fontGap * (i + 1) - 8;
        const y = h / 2 + (Math.random() - 0.5) * 6;
        ctx.translate(x, y);
        ctx.rotate((Math.random() - 0.5) * 0.3);
        ctx.fillText(text[i], 0, 0);
        ctx.restore();
      }
    },
    changPsw(name) {
      this[name] = !this[name];
    },
    toggleLoginMode() {
      // 切换登录/注册模式
      this.isLogin = !this.isLogin;
      // 切换时清空确认密码
      if (this.isLogin) {
        this.formData.confirmPass = '';
      }
    },
    handleForgotPassword() {
      // 处理忘记密码逻辑
      this.$parent.showTost(0, '忘记密码功能开发中');
    },
    handleTermsClick() {
      // 处理相关条款点击
      this.$parent.showTost(0, '相关条款功能开发中');
    },
    handlePrivacyClick() {
      // 处理隐私政策点击
      this.$parent.showTost(0, '隐私政策功能开发中');
    },
    handleLogoError(e) {
      // Logo加载失败时的处理
      console.error('Logo加载失败:', e.target.src);
      // 可以设置一个默认logo或者隐藏图片
      e.target.style.display = 'none';
    },
    submitForm() {
      let that = this;
      let info = that.formData;

      if (!info.name || !info.password) {
        that.$parent.showTost(0, '请输入您的账号和密码！');
        return;
      }

      if (!that.captchaCode || !String(that.captchaCode).trim()) {
        that.$parent.showTost(0, '请输入验证码！');
        return;
      }
      if (String(that.captchaCode).trim() !== that.captchaAnswer) {
        that.$parent.showTost(0, '验证码错误');
        that.getCaptcha();
        return;
      }

      // 注册模式需要验证确认密码和同意条款
      if (!that.isLogin) {
        if (!info.confirmPass) {
          that.$parent.showTost(0, '请输入确认密码！');
          return;
        }
        if (info.password !== info.confirmPass) {
          that.$parent.showTost(0, '两次输入的密码不一致！');
          return;
        }
        if (!that.agreeTerms) {
          that.$parent.showTost(0, '请先阅读并同意相关条款和隐私政策！');
          return;
        }
      }

      if (that.isLogin) {
        that.doLogin();
      } else {
        that.doRegister();
      }
    },
    doRegister() {
      let that = this;
      let info = { ...that.formData };
      info.captcha_code = that.captchaCode;

      that.$parent.showLoading();
      if (that.pid) {
        info.pid = that.pid;
      }
      
      that.$apiFun.register(info).then(res => {
        that.$parent.hideLoading();
        if (res.code == 200) {
          that.$parent.showTost(1, res.message);
          sessionStorage.setItem('token', res.data.api_token);
          that.$store.commit('changToken');
          that.$parent.getUserInfo();
          that.$parent.openDaoTime();
          that.$parent.goNav('/');
        } else {
          that.$parent.showTost(0, res.message || '注册失败');
          that.getCaptcha();
        }
      }).catch(() => {
        that.$parent.hideLoading();
        that.getCaptcha();
      });
    },
    doLogin() {
      let that = this;
      let info = {
        name: that.formData.name,
        password: that.formData.password,
        captcha_code: that.captchaCode,
      };

      that.$parent.showLoading();
      that.$apiFun.login(info).then(res => {
        that.$parent.hideLoading();
        if (res.code === 200) {
          if (that.rememberPassword) {
            try {
              localStorage.setItem('login_remember', JSON.stringify({
                name: that.formData.name,
                password: that.formData.password,
              }));
            } catch (e) {}
          } else {
            try {
              localStorage.removeItem('login_remember');
            } catch (e) {}
          }
          sessionStorage.setItem('token', res.data.api_token);
          that.$store.commit('changToken');
          that.$parent.getUserInfo();
          that.$parent.openDaoTime();
          that.$parent.goNav('/');
        } else {
          that.$parent.showTost(0, res.message || '登录失败');
          that.getCaptcha();
        }
      }).catch(() => {
        that.$parent.hideLoading();
        that.getCaptcha();
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.mobile-login-container {
  width: 100vw;
  min-height: 100vh;
  background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
  background-image: url('/static/image/diy/login_bg.jpg');
  background-size: cover;
  background-position: center;
  background-blend-mode: overlay;
  padding: 20px 15px;
  box-sizing: border-box;
}

// 顶部Logo
.login-header {
  text-align: center;
  padding: 20px 0;
  
  .login-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    
    .logo-img {
      width: 35%;
      display: block;
      margin-top: 20px;
      object-fit: contain;
    }
  }
}

// 登录表单
.login-form-wrapper {
  margin-bottom: 30px;
}

.login-form {
  .input-group {
    position: relative;
    margin-bottom: 15px;
    
    .login-input {
      width: 100%;
      height: 50px;
      padding: 0 15px;
      background: rgba(200, 200, 200, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 12px;
      font-size: 16px;
      color: white;
      box-sizing: border-box;
      
      &::placeholder {
        color: #999;
      }
      
      &:focus {
        outline: none;
        border-color: #1890ff;
        background: rgba(200, 200, 200, 0.4);
      }
    }
    
    &.password-group {
      .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;

        .eye-icon {
          width: 20px;
          height: 20px;
          display: block;
          object-fit: contain;
        }
      }
    }

    &.captcha-group {
      display: flex;
      align-items: center;
      gap: 10px;

      .captcha-input {
        flex: 1;
        margin-bottom: 0;
      }

      .captcha-image-wrap {
        width: 120px;
        height: 50px;
        flex-shrink: 0;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.3);
        background: #764ba2;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
      }

      .captcha-canvas {
        width: 100%;
        height: 100%;
        display: block;
      }
    }
  }
  
  .login-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    
    .remember-password {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #ffffff;
      font-size: 14px;
      cursor: pointer;
      
      input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #1890ff;
        cursor: pointer;
      }
    }
    
    .forgot-password {
      color: #ffffff;
      font-size: 14px;
      text-decoration: none;
      
      &:hover {
        text-decoration: underline;
      }
    }
  }
  
  .agree-terms {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 20px;
    
    .agree-checkbox {
      position: relative;
      display: inline-block;
      cursor: pointer;
      
      input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
        
        &:checked + .checkbox-custom {
          background: #1890ff;
          border-color: #1890ff;
          
          &::after {
            display: block;
          }
        }
      }
      
      .checkbox-custom {
        display: inline-block;
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-radius: 4px;
        background: transparent;
        position: relative;
        flex-shrink: 0;
        
        &::after {
          content: '';
          position: absolute;
          left: 5px;
          top: 2px;
          width: 4px;
          height: 8px;
          border: solid white;
          border-width: 0 2px 2px 0;
          transform: rotate(45deg);
          display: none;
        }
      }
    }
    
    .agree-text {
      color: rgba(255, 255, 255, 0.9);
      font-size: 12px;
      line-height: 1.5;
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 2px;
      
      .terms-link {
        color: #1890ff;
        text-decoration: none;
        font-size: 12px;
        
        &:hover {
          text-decoration: underline;
        }
      }
    }
  }
  
  .login-btn {
    width: 100%;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    color: #ffffff;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    
    &:active {
      transform: scale(0.98);
      opacity: 0.9;
    }
  }
  
}

// 合作伙伴区域
.sponsor-section {
  margin-bottom: 30px;
  padding: 0 10px;
  text-align: center;
  
  .sponsor-image {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
  }
}

// 底部按钮
.bottom-actions {
  display: flex;
  gap: 10px;
  padding: 0 10px;
  
  .action-btn {
    flex: 1;
    height: auto;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    border-radius: 12px;
    padding: 15px 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    
    .btn-image {
      width: 30%;
      max-width: 35px;
      height: auto;
      display: block;
    }
    
    .btn-text {
      color: rgba(255, 255, 255, 0.9);
      font-size: 12px;
      text-align: center;
    }
    
    &:active {
      transform: scale(0.98);
      opacity: 0.9;
      background: rgba(255, 255, 255, 0.15);
    }
  }
}
</style>
