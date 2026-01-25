<template>
  <div id="app">
    <div v-if="$store.state.appInfo.site_state == 1">
      <div class="meLoading" v-if="loading">
        <van-loading size="24px" vertical color="#0094ff" text-color="#0094ff">加载中...</van-loading>
      </div>
      <keep-alive>
        <router-view v-if="$route.meta.keepAlive" :key="$route.name" />
      </keep-alive>
      <router-view v-if="!$route.meta.keepAlive" :key="$route.name" />
    </div>
    <div v-if="$store.state.appInfo.site_state == 0" style="box-sizing: border-box; padding: 30px; fong-size: 26px">{{ $store.state.appInfo.repair_tips }}</div>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      daoTime: null,
      loading: false,
      pid: '',
    };
  },
  created() {
    let that = this;
    var query = that.$route.query;

    // 全局夜晚模式：监听切换事件，实时更新 body class
    try {
      const applyNightMode = () => {
        const nightMode = localStorage.getItem('nightMode') === 'true';
        document.body.classList.toggle('dark', nightMode);
      };
      applyNightMode();
      window.addEventListener('nightModeChanged', applyNightMode);
    } catch (e) {}

    that.getApp();
    that.getGameList();

    // Telegram Web App 自动登录检测
    // 延迟执行，确保 Telegram SDK 完全加载
    setTimeout(() => {
      that.checkTelegramAutoLogin();
    }, 500);

    if (sessionStorage.getItem('token')) {
      that.openDaoTime();
      that.getUserInfo();
    }
    if (query.pid) {
      that.pid = query.pid;
      that.$router.push({ path: `/login?type=1&pid=${query.pid}` });
    }
    that.getVisitUrl();
  },
  methods: {
    // 检测 Telegram 环境并自动登录
    checkTelegramAutoLogin() {
      let that = this;

      // 判断是否为开发模式
      const isDevelopment = process.env.NODE_ENV === 'development' || window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';

      // 调试信息收集（仅开发模式）
      let debugInfo = [];
      if (isDevelopment) {
        debugInfo.push('=== Telegram自动登录调试 ===');
        debugInfo.push('URL: ' + window.location.href.substring(0, 50));
        debugInfo.push('hash: ' + (window.location.hash ? window.location.hash.substring(0, 30) : '无'));
        debugInfo.push('Telegram存在: ' + (!!window.Telegram));
        debugInfo.push('WebApp存在: ' + (!!(window.Telegram && window.Telegram.WebApp)));

        console.log('=== [Telegram自动登录] 开始检测 ===');
        console.log('[Telegram自动登录] window.Telegram 存在:', !!window.Telegram);
        console.log('[Telegram自动登录] window.Telegram.WebApp 存在:', !!(window.Telegram && window.Telegram.WebApp));
        console.log('[Telegram自动登录] URL:', window.location.href);
        console.log('[Telegram自动登录] hash:', window.location.hash);
      }

      // 检测是否在 Telegram Web App 环境中
      if (window.Telegram && window.Telegram.WebApp) {
        const webApp = window.Telegram.WebApp;

        // 通知 Telegram 应用已准备好
        webApp.ready();
        webApp.expand();

        // 优先使用预保存的数据（防止被 Vue Router hash 模式覆盖）
        const initData = window.__TELEGRAM_INIT_DATA__ || webApp.initData;
        const initDataUnsafe = window.__TELEGRAM_INIT_DATA_UNSAFE__ || webApp.initDataUnsafe;
        const currentToken = sessionStorage.getItem('token');

        if (isDevelopment) {
          debugInfo.push('initData长度: ' + (initData ? initData.length : 0));
          debugInfo.push('预保存: ' + (window.__TELEGRAM_INIT_DATA__ ? '有' : '无'));
          debugInfo.push('当前token: ' + (currentToken ? '已有' : '无'));
          debugInfo.push('platform: ' + (webApp.platform || '未知'));
          debugInfo.push('user: ' + JSON.stringify((initDataUnsafe && initDataUnsafe.user) || {}));

          console.log('[Telegram自动登录] WebApp 对象:', webApp);
          console.log('[Telegram自动登录] initData 存在:', !!initData);
          console.log('[Telegram自动登录] initData 长度:', initData ? initData.length : 0);
          console.log('[Telegram自动登录] initData 内容:', initData);
          console.log('[Telegram自动登录] initDataUnsafe:', initDataUnsafe);
          console.log('[Telegram自动登录] 预保存数据:', window.__TELEGRAM_INIT_DATA__);
          console.log('[Telegram自动登录] 当前 token:', currentToken);
        }

        // 如果有 initData 且未登录，执行自动登录
        if (initData && !currentToken) {
          if (isDevelopment) {
            debugInfo.push('>>> 开始调用API...');
            console.log('[Telegram自动登录] 条件满足，准备调用后端 API...');
          }

          // 后端 API 地址
          const apiBaseUrl = 'https://jiuapi.82826.live';
          const telegramAuthUrl = apiBaseUrl + '/api/telegram/webapp-auth';
          if (isDevelopment) {
            debugInfo.push('API URL: ' + telegramAuthUrl.substring(0, 40) + '...');
            console.log('[Telegram自动登录] API URL:', telegramAuthUrl);
          }

          // 直接用 fetch 调用，避免 axios 配置问题
          fetch(telegramAuthUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ init_data: initData })
          }).then(response => response.json()).then(res => {
            if (isDevelopment) {
              console.log('[Telegram自动登录] API 响应:', res);
              debugInfo.push('API响应: ' + JSON.stringify(res));
            }

            if (res.code === 200) {
              if (isDevelopment) {
                console.log('[Telegram自动登录] 登录成功！');
                debugInfo.push('登录成功！');
              }

              // 保存 token
              sessionStorage.setItem('token', res.data.api_token);
              that.$store.commit('changToken');

              // 获取用户信息
              that.getUserInfo();
              that.openDaoTime();

              // 如果是新用户，显示密码提示
              if (res.data.is_new_user && res.data.first_password) {
                that.$dialog.alert({
                  title: '注册成功',
                  message: `您的账号：${res.data.user.username}\n初始密码：${res.data.first_password}\n\n请牢记此密码，后续将不再显示！`,
                  confirmButtonText: '我已记住'
                });
              } else {
                // 自动登录成功提示
                that.$notify({ type: 'success', message: 'Telegram自动登录成功！' });
              }
            } else {
              if (isDevelopment) {
                console.error('[Telegram自动登录] 登录失败:', res.code, res.message);
                debugInfo.push('登录失败: ' + res.message);
                // 开发模式下显示调试弹窗
                
              }
            }
          }).catch(err => {
            if (isDevelopment) {
              console.error('[Telegram自动登录] API 调用异常:', err);
              debugInfo.push('API异常: ' + (err.message || JSON.stringify(err)));
              // 开发模式下显示调试弹窗
              
            }
          });
        } else {
          if (isDevelopment) {
            if (!initData) {
              debugInfo.push('跳过: initData为空');
              console.log('[Telegram自动登录] 跳过：initData 为空');
            }
            if (currentToken) {
              debugInfo.push('跳过: 已登录');
              console.log('[Telegram自动登录] 跳过：用户已登录，token 存在');
            }
            // 开发模式下显示调试弹窗（没有initData或已登录时）
            
          }
        }
      } else {
        if (isDevelopment) {
          debugInfo.push('跳过: 非Telegram环境');
          console.log('[Telegram自动登录] 跳过：非 Telegram 环境');
          // 开发模式下在非Telegram环境也显示调试信息
          
        }
      }

      if (isDevelopment) {
        console.log('=== [Telegram自动登录] 检测结束 ===');
      }
    },
    getVisitUrl() {
      let that = this;
      // 如果是本地调试环境，不执行跳转
      if (process.env.NODE_ENV === 'development' || window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        return;
      }
      // 如果是 Telegram 环境，不执行跳转（避免中断自动登录流程）
      if (window.Telegram && window.Telegram.WebApp && window.Telegram.WebApp.initData) {
        console.log('[getVisitUrl] 跳过：Telegram 环境不执行跳转');
        return;
      }
      that.$apiFun
        .get('/api/getVisitUrl', {})
        .then(res => {
          // 如果是本地调试环境返回的响应，也不执行跳转
          if (res.code == 500 && res.message === 'local') {
            return;
          }
          if (res.code == 200) {
            let url = that.pid ? res.data.url + 'register?pid=' + that.pid : res.data.url;
            window.open(url, '_self');
          }
        })
        .catch(res => {
          // console.log(res)
        });
    },
    // 获取游戏列表
    getGameList() {
      let that = this;

      that.$apiFun.get('/api/game/list', { category: '' }).then(res => {
        if (res.code == 200) {
          // 接口返回的数据结构是 { list: [...], app_list: [...] }
          let list = res.data.list || res.data || [];
          // 使用 category_id 作为键的对象来存储游戏列表
          let gameListByCategory = {};

          console.log('接口返回的原始数据:', res.data);
          console.log('解析后的list:', list, '长度:', list.length);

          // 遍历所有数据，按 category_id 分类存储
          if (Array.isArray(list)) {
            list.forEach(el => {
              // 只处理 app_state == 1 的游戏
              if (el.app_state == 1 && el.category_id) {
                const categoryId = el.category_id;
                // 如果该 category_id 还不存在，初始化为空数组
                if (!gameListByCategory[categoryId]) {
                  gameListByCategory[categoryId] = [];
            }
                // 将游戏添加到对应 category_id 的数组中
                gameListByCategory[categoryId].push(el);
            }
            });
          } else {
            console.warn('游戏列表数据格式错误，不是数组:', list);
          }

          // 将按 category_id 组织的游戏数据保存到 localStorage
          localStorage.setItem('gameListByCategory', JSON.stringify(gameListByCategory));

          // 更新 store
          that.$store.commit('changGameList');

          // 输出统计信息
          let stats = {};
          Object.keys(gameListByCategory).forEach(categoryId => {
            stats[categoryId] = gameListByCategory[categoryId].length;
          });
          console.log('游戏列表数据已加载（按 category_id 组织）:', stats);
        }
      });
    },
    // 获取app
    getApp() {
      let that = this;
      that.$apiFun.post('/api/app', {}).then(res => {
        if (res.code == 200) {
          localStorage.setItem('appInfo', JSON.stringify(res.data));
          that.$store.commit('changappInfo');
          document.getElementsByTagName('title')[0].innerText = that.$store.state.appInfo.title;
        }
      });
    },
    // 退出登录
    outLogin() {
      let that = this;

      that.$dialog
        .confirm({
          title: '提示',
          message: '您确定要退出登录吗?',
        })
        .then(() => {
          that.showLoading();

          that.$apiFun
            .post('/api/logoff', {})
            .then(res => {
              localStorage.clear();
              sessionStorage.clear();
              that.$store.commit('changUserInfo');
              that.$store.commit('changToken');
              that.closeDaoTime();
              that.hideLoading();
              that.$router.push({ path: '/login' });
            })
            .catch(() => {
              localStorage.clear();
              sessionStorage.clear();
              // that.$cookies.remove('token' )/
              that.$store.commit('changUserInfo');
              that.$store.commit('changToken');
              that.closeDaoTime();
              that.hideLoading();
              that.$router.push({ path: '/login' });
            });
        })
        .catch(() => {});
    },
    // 打开游戏
    openGamePage(name, type, code) {
      let that = this;
      let token = sessionStorage.getItem('token') ? sessionStorage.getItem('token') : '';
      if (!token) {
        that.showTost(0, '请登录！');

        return;
      }
      that.goNav(`/gamePage?name=${name}&type=${type}&code=${code}`);
    },
    doCopy(msg) {
      let cInput = document.createElement('input');
      cInput.style.opacity = '0';
      cInput.value = msg;
      document.body.appendChild(cInput);
      // 选取文本框内容
      cInput.select();
      document.execCommand('copy');
      this.showTost(1, '复制成功！');
    },
    goNav(url) {
      let that = this;

      if (url == '/mine') {
        if (!that.$store.state.token) {
          this.$router.push({ path: '/login' });
        }
      }
      if (url == '/hongbao' || url == '/transfer') {
        if (!that.$store.state.token) {
          that.$dialog
            .confirm({
              message: '精彩内容等你来体验，快来登录吧！',
            })
            .then(() => {
              this.$router.push({ path: '/login' });
            });

          return;
        }
        if (url == '/hongbao' && that.$store.state.appInfo.redpacket_switch == 0) {
          that.showTost(0, '红包已关闭');
          return;
        }
      }
      if (url == this.$route.fullPath) {
        that.showTost(0, '已在当前页面！');
        return;
      }

      this.$router.push({ path: url });
    },
    closeDaoTime() {
      let that = this;
      if (that.daoTime != null) {
        clearInterval(that.daoTime);
      }
      that.daoTime = null;
    },
    // 不刷新页面更新用户余额
    getBalance() {
      let that = this;
      that.$apiFun
        .post('/api/balance', {})
        .then(res => {
          if (res.code == 200) {
            let userInfo = JSON.parse(localStorage.getItem('userInfo'));
            userInfo.balance = res.data.balance;
            localStorage.setItem('userInfo', JSON.stringify(userInfo));
            that.$store.commit('changUserInfo');
          }
          if (res.code == 401) {
            localStorage.clear();
            sessionStorage.clear();
            that.$store.commit('changUserInfo');
            that.$store.commit('changToken');
            that.closeDaoTime();
            that.$router.push({ path: '/login' });
          }
        })
        .catch(res => {});
    },
    openDaoTime() {
      let that = this;
      that.daoTime = setInterval(() => {
        that.getBalance();
      }, 4300);
    },
    // 不刷新页面跟新用户信息
    getUserInfo() {
      let that = this;
      that.$apiFun.post('/api/user', {}).then(res => {
        if (res.code === 200) {
          let userInfo = res.data;
          let str = userInfo.current_vip;
          let index = str.indexOf('P');
          let vip = str.substr(index + 1, str.length); //04
          userInfo.vip = vip;
          localStorage.setItem('userInfo', JSON.stringify(userInfo));
          that.userInfo = userInfo;
          that.$store.commit('changUserInfo');
        } else if (res.code === 401 || res.code === 403) {
          // token 无效，清除并触发自动登录
          sessionStorage.removeItem('token');
          that.checkTelegramAutoLogin();
        }
      }).catch(() => {
        // 请求异常时也清除 token
        sessionStorage.removeItem('token');
      });
    },
    // 刷新页面更新信息
    getUserInfoShowLoding() {
      let that = this;
      that.showLoading();
      that.$apiFun.post('/api/user', {}).then(res => {
        if (res.code === 200) {
          let userInfo = res.data;
          let str = userInfo.current_vip;
          let index = str.indexOf('P');
          let vip = str.substr(index + 1, str.length); //04
          userInfo.vip = vip;
          localStorage.setItem('userInfo', JSON.stringify(userInfo));
          that.userInfo = userInfo;
          that.$store.commit('changUserInfo');
          that.hideLoading();
        }
      });
    },
    // 获取代理
    getAgentLoginUrl() {
      let that = this;
      that.$parent.goNav(`/gamePage?dailiD=1`);
    },
    openKefu() {
      let that = this;
      that.goNav(`/kefu`);
    },
    openFeedback() {
      let that = this;
      // 检查用户是否登录
      if (!that.$store.state.token) {
        // 未登录，跳转到登录页面
        that.goNav(`/login`);
        return;
      }
      // 已登录，跳转到意见反馈页面
      that.goNav(`/feedback`);
    },
    showTost(type, title) {
      let str = type ? 'success' : 'danger';
      this.$notify({ type: str, message: title });
    },
    showLoading() {
      this.loading = true;
    },
    hideLoading() {
      this.loading = false;
    },
  },
  mounted() {},
  beforeDestroy() {
    let that = this;
    if (that.daoTime) {
      clearInterval(that.daoTime);
    }
    that.daoTime = null;
  },
};
</script>

<style>
/* @import '../static/css/registermember.css';
 @import '../static/css/registermember.css';
 @import '../static/css/registermember.css';
 @import '../static/css/registermember.css'; */

.meLoading {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 999;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 0, 0, 0.3);
}
.van-dialog__confirm,
.van-dialog__confirm:active {
  color: #069b71;
}

.step .van-tab--active {
  color: #fff;
  background: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjUwIiBoZWlnaHQ9IjM2IiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik0wIDB2MzZoMjQwLjgzN0wyNTAgMThsLTkuMTYzLTE4eiIgZmlsbD0iIzA2OUI3MSIgZmlsbC1ydWxlPSJldmVub2RkIi8+PC9zdmc+) no-repeat 100% / cover;
}

.step .van-tabs--line .van-tabs__wrap {
  height: 27px;
}
.metransRecord .van-tabs__nav--card .van-tab.van-tab--active {
  color: #fff;
  background-color: #069b71;
  border-radius: 22px;
}
.metransRecord .van-tabs__nav--card {
  border: none;
}
.metransRecord .van-tabs__nav--card .van-tab {
  border: none;
}
.metransRecord .van-tabs__nav--card .van-tab {
  color: #000;
}

/* 页眉 */

.pageTop {
  background-color: rgba(0, 0, 0, 0.7);
  color: #ffffff;
  text-align: center;
  font-size: 16px;
  font-weight: 700;
  height: 40px;
  line-height: 40px;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 200;
}

.acts .van-tabs__line {
  background-color: #1890ff !important;
}
.acts .van-tab--active {
  color: #1890ff !important;
}

.van-nav-bar .van-icon {
  color: #000;
}
.van-nav-bar {
  background-color: #ede9e7;
}
.van-nav-bar__arrow {
  font-size: 24px;
}
.van-nav-bar__title {
  font-weight: 700;
}

.bancgs {
  position: fixed;
  top: 10px;
  left: 10px;
  width: 30px;
  opacity: 0.8;
  z-index: 200;
}
p {
  margin-block-start: 5px !important;
  margin-block-end: 5px !important;
}
.inputsw {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  z-index: 999;
  cursor: pointer;
}
.van-tab--active {
  color: #108ee9;
}
.van-tabs__line {
  background-color: #108ee9;
}
/* 优惠页面菜单样式 */
.activity-tabs .van-tab {
  font-size: 17px !important;
  flex: 1 0 20% !important;
  padding: 0 5px !important;
  color: #999 !important;
}
.activity-tabs .van-tab--active {
  color: #000 !important;
}
.van-cell {
  padding: 5px 8px;
}
.sdg .van-field__label {
  width: 0.2rem;
}
[class*='van-hairline']:after {
  border: none;
}
.sdgg .van-popup {
  border-radius: 15px 15px 0 0;
}

.stddss .van-field__control {
  font-size: 0.5rem;
}

.van-button--info {
  color: #fff;
  background-color: #1890ff;
  border: 1px solid #cf866b;
}
</style>
