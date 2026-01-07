<template>
  <div id="app">
    <div v-if="$store.state.appInfo.site_state == 1">
      <div class="_1SI39Ofv" v-if="lodingShow">
        <div class="_9-ZpLxb0">
          <img
            src="data:image/png;base64,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"
            alt="icon"
          />
          <div class="_3_qzGcRD"><span class="_1N8mCmac">-</span><span>B</span><span>O</span><span>B</span><span>.</span><span>C</span><span>O</span><span>M</span><span class="_1N8mCmac">-</span></div>
        </div>
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
      jumpUrl: null,
      lodingShow: false,
    };
  },
  created() {
    let that = this;
    that.getVisitUrl();
    that.getApp();
  },
  methods: {
    getApp() {
      let that = this;
      that.$apiFun.post('/api/app', {}).then(res => {
        if (res.code == 200) {
          // "ios_download_qrcode": "http://mb2.tg-demo.cc:86/uploads/images/e13177382b3e958789c877f71b034ca9.jpg",
          // "ios_download_url": "http://mb2.tg-demo.cc:86/",
          // "h5_url": "http://mb2m.tg-demo.cc"
          localStorage.setItem('appInfo', JSON.stringify(res.data));
          that.$store.commit('changappInfo');
          document.getElementsByTagName('title')[0].innerText = that.$store.state.appInfo.title;
          // logo $store.state.appInfo.site_logo
        }
      });
    },
    getVisitUrl() {
      let that = this;
      // 如果是本地调试环境，不执行跳转
      if (process.env.NODE_ENV === 'development' || window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        return;
      }
      var query = that.$route.query;
      let pid = '';
      if (query.pid) {
        pid = query.pid;
      }

      that.$apiFun.get('/api/getVisitUrl', {}).then(res => {
        // 如果是本地调试环境返回的响应，也不执行跳转
        if (res.code == 500 && res.message === 'local') {
          return;
        }
        if (res.code == 200) {
          let url = that.pid ? res.data.url + '?pid=' + that.pid : res.data.url;
          window.open(url, '_self');
        }
      });
    },
    goNav(url) {
      let that = this;
      this.$router.push({ path: url });
    },

    showTost(type, title) {
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
    openKefu() {
      let that = this;
      that.showTost('正在链接人工客服');
      that.$apiFun.post('/api/getservicerurl', {}).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(1, res.message);
        }
        if (res.code == 200) {
          that.jumpUrl = res.data.url;
        }
      });
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

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  margin: 0;
  padding: 0;
}
.el-pager li {
  min-width: 26px;
  font-weight: 400 !important;
}
.el-pager li.active {
  color: #d7967f !important;
  background: transparent !important;
  border-color: #d7967f !important;
  border: 1px solid #d7967f;
  min-width: 26px;
  border-radius: 2px;
}
</style>
