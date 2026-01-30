<template>
  <div class="promotion-page">
    <div class="header">
      <div class="header__top-wrapper">
        <div class="van-nav-bar van-nav-bar--fixed fixed-top nav-header">
          <div class="van-nav-bar__content">
            <div class="van-nav-bar__left" @click="$router.back()">
              <i class="van-icon van-icon-arrow-left van-nav-bar__arrow"></i>
            </div>
            <div class="van-nav-bar__title van-ellipsis">推广中心</div>
          </div>
        </div>
      </div>
    </div>

    <div class="promotion-content">
      <!-- 未登录提示 -->
      <div v-if="!$store.state.token" class="not-login-tip">
        <div class="tip-content">
          <p>您还未登录</p>
          <van-button type="primary" @click="$parent.goNav('/login')">立即登录</van-button>
        </div>
      </div>

      <!-- 已登录内容 -->
      <div v-else class="promotion-main">
        <!-- 推广链接区域 -->
        <div class="promotion-card">
          <div class="card-title">推广链接</div>
          <div class="link-section">
            <div class="link-input-wrapper">
              <input type="text" :value="inviteInfo.invite_url || ''" readonly class="link-input" />
              <van-button type="primary" size="small" @click="copyLink" class="copy-btn">复制</van-button>
            </div>
          </div>
        </div>

        <!-- 二维码区域 -->
        <div class="promotion-card">
          <div class="card-title">推广二维码</div>
          <div class="qrcode-section">
            <div class="qrcode-wrapper" v-if="inviteInfo.qrcode">
              <img :src="inviteInfo.qrcode" alt="推广二维码" class="qrcode-img" />
            </div>
            <div v-else class="loading-tip">加载中...</div>
            <p class="qrcode-desc">扫描二维码即可注册</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'promotion',
  data() {
    return {
      inviteInfo: {
        invite_url: '',
        qrcode: '',
        poster: '',
      },
    };
  },
  created() {
    if (this.$store.state.token) {
      this.getInviteInfo();
    }
  },
  activated() {
    // 页面激活时重新获取数据
    if (this.$store.state.token) {
      this.getInviteInfo();
    }
  },
  methods: {
    getInviteInfo() {
      let that = this;
      that.$parent.showLoading();
      that.$apiFun
        .post('/api/inviteInfo', {})
        .then(res => {
          that.$parent.hideLoading();
          if (res.code == 200) {
            that.inviteInfo = res.data || {};
          } else {
            that.$parent.showTost(0, res.message || '获取推广信息失败');
          }
        })
        .catch(res => {
          that.$parent.hideLoading();
          that.$parent.showTost(0, '获取推广信息失败，请重试');
        });
    },
    copyLink() {
      let that = this;
      if (!that.inviteInfo.invite_url) {
        that.$parent.showTost(0, '推广链接不存在');
        return;
      }
      let cInput = document.createElement('input');
      cInput.style.opacity = '0';
      cInput.value = that.inviteInfo.invite_url;
      document.body.appendChild(cInput);
      cInput.select();
      document.execCommand('copy');
      document.body.removeChild(cInput);
      that.$parent.showTost(1, '复制成功！');
    },
  },
};
</script>

<style lang="scss" scoped>
.promotion-page {
  min-height: 100vh;
  background: #f5f5f5;
  padding-top: 46px;
}

.header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 100;
  background: #fff;
}

.nav-header {
  background: #fff;
  border-bottom: 1px solid #ebedf0;
}

.promotion-content {
  padding: 3vw 4vw;
}

.not-login-tip {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 60vh;
  padding: 4vw;

  .tip-content {
    text-align: center;

    p {
      font-size: 4vw;
      color: #666;
      margin-bottom: 4vw;
    }
  }
}

.promotion-main {
  .promotion-card {
    background: #fff;
    border-radius: 3vw;
    padding: 4vw;
    margin-bottom: 3vw;
    box-shadow: 0 0.5vw 2vw rgba(0, 0, 0, 0.05);

    .card-title {
      font-size: 4vw;
      font-weight: 600;
      color: #333;
      margin-bottom: 3vw;
      text-align: center;
    }

    .link-section {
      .link-input-wrapper {
        display: flex;
        align-items: center;
        gap: 2vw;

        .link-input {
          flex: 1;
          padding: 2.5vw 3vw;
          border: 1px solid #e0e0e0;
          border-radius: 2vw;
          font-size: 3.2vw;
          color: #333;
          background: #f8f8f8;
          outline: none;
        }

        .copy-btn {
          flex-shrink: 0;
          padding: 2.5vw 4vw;
          border-radius: 2vw;
          font-size: 3.2vw;
        }
      }
    }

    .qrcode-section {
      display: flex;
      flex-direction: column;
      align-items: center;

      .qrcode-wrapper {
        width: 50vw;
        height: 50vw;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 2vw;
        padding: 3vw;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 3vw;

        .qrcode-img {
          width: 100%;
          height: 100%;
          object-fit: contain;
        }
      }

      .loading-tip {
        width: 50vw;
        height: 50vw;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5vw;
        color: #999;
        margin-bottom: 3vw;
      }

      .qrcode-desc {
        font-size: 3vw;
        color: #666;
        text-align: center;
      }
    }

    .poster-section {
      display: flex;
      flex-direction: column;
      align-items: center;

      .poster-wrapper {
        width: 100%;
        max-width: 80vw;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 2vw;
        padding: 2vw;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 3vw;

        .poster-img {
          width: 100%;
          height: auto;
          object-fit: contain;
          border-radius: 1vw;
        }
      }

      .loading-tip {
        width: 100%;
        max-width: 80vw;
        height: 60vw;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5vw;
        color: #999;
        margin-bottom: 3vw;
      }

      .poster-desc {
        font-size: 3vw;
        color: #666;
        text-align: center;
      }
    }
  }
}
</style>
