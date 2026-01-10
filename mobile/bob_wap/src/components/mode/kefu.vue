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

    <!-- 主播推荐区域 -->
    <div class="anchor-section">
      <div class="section-header">
        <img class="section-icon" src="/static/image/icon_app.png" alt="主播" />
        <span class="section-title">主播推荐</span>
      </div>
      <div class="anchor-list">
        <div class="empty-tip">暂无主播推荐</div>
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
    // 打开在线客服
    openOnlineService() {
      if (this.url) {
        window.open(this.url, '_blank');
      } else {
        this.$toast('客服链接获取中，请稍后再试');
      }
    },
    // 跳转意见反馈
    goFeedback() {
      this.$parent.openKefu();
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
      width: 22px;
      height: 18px;
      background-color: #fff;
      border-radius: 9px;
      position: relative;

      &::before {
        content: "...";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 14px;
        font-weight: bold;
        color: #4a4a4a;
        line-height: 1;
        letter-spacing: 1px;
      }
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
