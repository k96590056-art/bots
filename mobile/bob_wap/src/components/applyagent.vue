<template>
  <div data-v-f531b812="" class="app app-ti_green">
    <div data-v-8a75a126="" data-v-f531b812="" class="header">
      <div data-v-8a75a126="" class="header__top-wrapper">
        <div data-v-8a75a126="" class="van-nav-bar van-nav-bar--fixed fixed-top nav-header">
          <div class="van-nav-bar__content">
            <div class="van-nav-bar__left" @click="$router.back()">
              <i class="van-icon van-icon-arrow-left van-nav-bar__arrow"></i>
            </div>
            <div class="van-nav-bar__title van-ellipsis">合营计划</div>
          </div>
        </div>
      </div>
    </div>
    <div class="pahsn">
      <img data-v-56fcd294="" src="/static/image/__al__title01.7a3975958589d48b22c30b3b976a95fc.png" style="display: block; width: 80%; margin: 0 auto; padding-top: 30px" />
      <img data-v-56fcd294="" src="/static/image/__al__person01.8b896040f87c2dfffa7e8de68ed19c42.png" style="display: block; width: 100%; margin: 0 auto" />
      <div @click="$parent.openKefu" class="zixun">
        <img data-v-56fcd294="" src="/static/image/16044962635685155.png" />
        <div class="cnets">
          <div class="tos">合营部</div>
          <div class="bos">立即咨询</div>
        </div>
        <div class="zusnb">咨询</div>
      </div>
      <!-- 推广链接区域 -->
      <div class="promotion-card" v-if="$store.state.token">
        <div class="card-title">推广链接</div>
        <div class="link-section">
          <div class="link-input-wrapper">
            <input type="text" :value="inviteInfo.invite_url || ''" readonly class="link-input" />
            <van-button type="primary" size="small" @click="copyLink" class="copy-btn">复制</van-button>
          </div>
        </div>
      </div>

      <!-- 二维码区域 -->
      <div class="promotion-card" v-if="$store.state.token">
        <div class="card-title">推广二维码</div>
        <div class="qrcode-section">
          <div class="qrcode-wrapper" v-if="inviteInfo.qrcode">
            <img :src="inviteInfo.qrcode" alt="推广二维码" class="qrcode-img" />
          </div>
          <div v-else class="loading-tip">加载中...</div>
          <p class="qrcode-desc">扫描二维码即可注册</p>
        </div>
      </div>

      <div class="bsd">
        <van-form>
          <van-field label="用户名" v-model="$store.state.userInfo.username" disabled />
          <van-field label="真实姓名" v-model="$store.state.userInfo.realname" disabled />
          <van-field label="联系方式" v-model="info.mobile" placeholder="请输入您的联系方式" />
          <van-field label="申请理由" v-model="info.apply_info" placeholder="请输入申请说明" />
        </van-form>
        <van-button style="background:#1890ff;color:#fff" @click="shenqing" block >加入我们</van-button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'applyagent',
  data() {
    return {
      info: {},
      inviteInfo: {
        invite_url: '',
        qrcode: '',
        poster: '',
      },
    };
  },
  created() {
    let that = this;
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
    shenqing() {
      let that = this;
      let info = that.info;
      let regExp = /^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;

      if (!info.apply_info) {
        that.$parent.showTost(0, '请输入申请理由');
        return;
      }

      that.$parent.showLoading();
      that.$apiFun
        .post('/api/applyagentdo', info)
        .then(res => {
          that.$parent.showTost(1, res.message);
          that.$parent.hideLoading();
        })
        .catch(res => {
          that.$parent.hideLoading();
        });
    },
  },
  mounted() {
    let that = this;
  },
  updated() {
    let that = this;
  },
};
</script>

<style lang="scss" scoped>
.pahsn {
  background: url(/static/image/__al__background.2e29d452d69738493237414076a048d3.png) no-repeat;
  background-size: 100% 100%;
  margin-top: 40px;
  min-height: 100vh;
  width: 100%;
}
.zixun {
  width: 88%;
  margin: 0 auto;
  background: #fdfdfd;
  border-radius: 10px;
  display: flex;
  align-items: center;
  padding: 10px;
  position: relative;
  margin-top: -96px;
  opacity: 0.9;
  img {
    width: 30px;
    margin-right: 10px;
  }
  .cnets {
    flex: 1;
    border-left: 1px solid #ccc;
    padding-left: 10px;

    .tos {
      font-size: 12px;
      color: #999;
    }
    .bos {
      font-size: 14px;
      color: #1e1e1e;
    }
  }
  .zusnb {
    width: 60px;
    height: 20px;
    line-height: 20px;
    text-align: center;
    font-size: 12px;
    color: #fff;
    background-color: #1890ff;
    border-radius: 4px;
  }
}

.bsd {
  width: 90%;
  margin: 0 auto;
  background: #fdfdfd;
  border-radius: 10px;
  padding: 20px 10px;
  margin-top: 10px;
}

.promotion-card {
  width: 90%;
  margin: 10px auto;
  background: #fdfdfd;
  border-radius: 10px;
  padding: 20px 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);

  .card-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
    text-align: center;
  }

  .link-section {
    .link-input-wrapper {
      display: flex;
      align-items: center;
      gap: 10px;

      .link-input {
        flex: 1;
        padding: 10px 12px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        color: #333;
        background: #f8f8f8;
        outline: none;
      }

      .copy-btn {
        flex-shrink: 0;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 14px;
      }
    }
  }

  .qrcode-section {
    display: flex;
    flex-direction: column;
    align-items: center;

    .qrcode-wrapper {
      width: 200px;
      height: 200px;
      background: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      padding: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 12px;

      .qrcode-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
    }

    .loading-tip {
      width: 200px;
      height: 200px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      color: #999;
      margin-bottom: 12px;
    }

    .qrcode-desc {
      font-size: 12px;
      color: #666;
      text-align: center;
    }
  }
}
</style>
