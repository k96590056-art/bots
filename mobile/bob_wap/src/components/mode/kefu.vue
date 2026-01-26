<template>
  <div class="kefu-page">
    <!-- 顶部标题栏 -->
    <div class="header">
      <div class="header-placeholder"></div>
      <div class="header-title">我的客服</div>
      <div class="header-feedback" @click="goFeedback">意见反馈</div>
    </div>

    <!-- 用户问候区域 -->
    <div class="user-greeting">
      <div class="avatar">
        <img :src="userAvatar" alt="avatar" />
      </div>
      <div class="greeting-text">
        <div class="greeting-title">Hi，尊敬的用户</div>
        <div class="greeting-subtitle">欢迎来到客服中心</div>
      </div>
    </div>

    <!-- 在线客服按钮 -->
    <div class="service-card" @click="openOnlineService">
      <div class="service-info">
        <div class="service-title">在线客服</div>
        <div class="service-subtitle">Customer Service</div>
      </div>
      <div class="service-icon">
        <div class="bubble-icon"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'kefu',
  data() {
    return {
      url: null,
    };
  },
  computed: {
    userAvatar() {
      var userInfo = this.$store.state.userInfo;
      return (userInfo && userInfo.avatar) || '/static/image/default_customer.png';
    },
  },
  created() {
    this.getservicerurl();
  },
  methods: {
    // 获取客服URL
    getservicerurl() {
      let that = this;
      that.$apiFun.post('/api/getservicerurl', {}).then(res => {
        if (res.code == 200) {
          that.url = res.data.url;
        }
      });
    },
    // 打开在线客服（通过公共 webview 路由打开）
    openOnlineService() {
      const userId = this.$store.state.userInfo.id || 0;

      // 检测是否在 Telegram 环境中
      const isTelegram = window.Telegram && window.Telegram.WebApp && window.Telegram.WebApp.initData;

      if (isTelegram) {
        // Telegram 环境下使用特定的客服链接，强制手机端
        const telegramKefuUrl = `https://xb0033.xyz/chat?business_id=59&groupid=72&uid=${userId}&mobile=1`;
        // 在 Telegram 中直接打开外部链接
        window.Telegram.WebApp.openLink(telegramKefuUrl);
        return;
      }

      // 非 Telegram 环境（电脑浏览器、手机浏览器）
      const kefuUrl = `https://xb0033.xyz/chat?business_id=59&groupid=72&uid=${userId}`;
      this.$router.push({
        path: '/webview',
        query: { url: encodeURIComponent(kefuUrl), title: '在线客服' },
      });
    },
    // 跳转意见反馈
    goFeedback() {
      // 检查用户是否登录
      if (!this.$store.state.token) {
        // 未登录，跳转到登录页面
        this.$router.push({ path: '/login' });
        return;
      }
      // 已登录，跳转到意见反馈页面
      this.$router.push({ path: '/feedback' });
    },
  },
};
</script>

<style lang="scss" scoped>
.kefu-page {
  min-height: 100vh;
  background-color: #f5f5f5;
  padding-bottom: 60px;
}

// 顶部标题栏
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 16px;
  background-color: #fff;

  .header-placeholder {
    width: 56px;
  }

  .header-title {
    font-size: 18px;
    font-weight: 500;
    color: #333;
    text-align: center;
  }

  .header-feedback {
    color: #999;
    font-size: 14px;
    cursor: pointer;
  }
}

// 用户问候区域
.user-greeting {
  display: flex;
  align-items: center;
  padding: 20px 16px;
  background-color: #fff;
  margin-bottom: 10px;

  .avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 12px;
    background-color: #e0e0e0;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  .greeting-text {
    .greeting-title {
      font-size: 16px;
      font-weight: 500;
      color: #333;
      margin-bottom: 4px;
    }

    .greeting-subtitle {
      font-size: 13px;
      color: #999;
    }
  }
}

// 在线客服按钮
.service-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 0 16px 15px;
  padding: 16px 20px;
  background: linear-gradient(135deg, #4a4a4a 0%, #2d2d2d 100%);
  border-radius: 10px;
  cursor: pointer;

  .service-info {
    border-radius: 8px;
    padding: 10px 15px;
    .service-title {
      font-size: 16px;
      font-weight: 500;
      color: #fff;
      margin-bottom: 4px;
    }

    .service-subtitle {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.7);
    }
  }

  .service-icon {
    width: 40px;
    height: 40px;
    background-color: transparent;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;

    .bubble-icon {
      width: 24px;
      height: 24px;
      background-image: url('/static/image/customer_qipao.png');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
    }
  }
}

// 主播推荐区域
.anchor-section {
  background-color: #fff;
  margin: 0 16px;
  border-radius: 10px;
  padding: 16px;

  .section-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;

    .section-icon {
      width: 20px;
      height: 20px;
      margin-right: 8px;
    }

    .section-title {
      font-size: 15px;
      font-weight: 500;
      color: #333;
    }
  }

  .anchor-list {
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;

    .empty-tip {
      font-size: 14px;
      color: #999;
    }
  }
}
</style>
