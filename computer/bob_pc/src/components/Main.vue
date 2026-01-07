<template>
  <div class="">
    <Header />
    <router-view />
    <Foot />
    <ShowAfter v-if="showAfter.show" :title="showAfter.title" :id="showAfter.id" />
  </div>
</template>

<script>
import Header from './libs/Header';
import Foot from './libs/Foot';
import ShowAfter from './assembly/ShowAfter';

export default {
  name: 'Main',
  data() {
    return {
      daoTime: null,
      showAfter: { show: false, title: '您还未登陆，请前往登录！' },
      jumpUrl: null,
    };
  },
  components: {
    Header,
    Foot,
    ShowAfter,
  },
  created() {
    let that = this;

    if (sessionStorage.getItem('token')) {
      that.openDaoTime();
      that.getUserInfo();
    }
  
  },
  updated() {},
  mounted() {},
  methods: {
    getUserInfo() {
      let that = this;
      that.$apiFun.post('/api/user', {}).then(res => {
        console.log(res);
        if (res.code !== 200) {
          that.showTost(res.message);
        }
        if (res.code === 200) {
          let userInfo = res.data;
          let str = userInfo.current_vip;
          let index = str.indexOf('P');
          let vip = str.substr(index + 1, str.length); //04
          userInfo.vip = vip;
          localStorage.setItem('userInfo', JSON.stringify(userInfo));
          that.userInfo = userInfo;
          that.$store.commit('changUserInfo');
        }
      });
    },
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
        }
      });
    },
    showAfterHide() {
      let that = this;
      that.showAfter.show = false;
    },
    showAfterOk() {
      let that = this;
      this.$router.push({ path: '/login' });
    },
    openShow() {
      let that = this;
      that.showAfter.show = true;
    },
    openDaoTime() {
      let that = this;
      that.daoTime = setInterval(() => {
        that.getBalance();
      }, 2300);
    },
    close() {
      let that = this;
      if (that.daoTime) {
        clearInterval(that.daoTime);
      }
      that.daoTime = null;
    },
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
            that.showTost('登陆过期！');
            localStorage.clear();
            sessionStorage.clear();
            that.$store.commit('changUserInfo');
            that.$store.commit('changToken');
            that.close();
            that.$router.push({ path: '/login' });
          }
        })
        .catch(res => {
          // console.log(res)
        });
    },
    refreshusermoney() {
      let that = this;
      that.$apiFun
        .post('/api/refreshusermoney', {})
        .then(res => {
          if (res.code == 200) {
            localStorage.setItem('userInfo', JSON.stringify(res.data));
            that.$store.commit('changUserInfo');
          }
        })
        .catch(res => {
          // console.log(res)
        });
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
  beforeDestroy() {
    let that = this;
    if (that.daoTime) {
      clearInterval(that.daoTime);
    }
    that.daoTime = null;
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
</style>
