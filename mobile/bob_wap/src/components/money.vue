<template>
  <div style="background-color: #f8f8f8">
    <div style="min-height: 100vh; background: url('/static/image/bg_01.c00a1854e1446ef9fbd9f5b282da92f1.c00a1854.png') no-repeat; background-size: 100% auto; background-attachment: fixed">
      <img class="bancgs" style="opacity: 1" @click="$router.back()" src="/static/image/bank_020021515.png" alt="" />
      <div class="tit">我的钱包</div>
      <div class="mefs">
        <div class="conts" style="padding-top: 1.4rem">
          <div class="titsg">总资产（元）</div>
          <div class="mehs">
            <div class="lfs">￥</div>
            <div class="num">{{ ($store.state.userInfo.balance || 0) * 1 + ($store.state.userInfo.gameblance || 0) * 1 }}</div>
            <img @click="$parent.getUserInfoShowLoding()" class="shua" src="/static/image/icon_sx.88b45347bfcdb11586ef9a0872038bf9.png" alt="" />
          </div>
        </div>
      </div>
      <div class="bios">
        <div class="toptit">
          <div class="shu"></div>
          中心钱包（元）
        </div>
        <div class="mesg">
          <div class="bosgf">
            <div class="wallet-card">
              <div class="top"><img src="/static/image/qianbao123.png" alt="" />中心钱包</div>
              <div class="bots"><span class="currency">$</span><span class="amount">{{ $store.state.userInfo.balance || 0 }}</span></div>
            </div>
          </div>
          <div class="qibao">
            <van-button class="recover-btn" type="primary" size="small" @click="transall">
              <span class="btn-icon">🔄</span>
              一键回收
            </van-button>
          </div>
        </div>
        <div class="typelist">
          <div class="lis" @click="$parent.goNav('/recharge')">
            <div class="icon-wrapper">
              <img src="/static/image/feature_moneydraw.ddbdd6cb1996bc0dccf6c8570d9e0183.ddbdd6cb.png" alt="" />
            </div>
            <span class="lis-text">存款</span>
          </div>
          <div class="lis" @click="$parent.goNav('/withdrawal')">
            <div class="icon-wrapper">
              <img src="/static/image/feature_withdrawmoney.932feadcf30fa1646577e19f04412aaf.932feadc.png" alt="" />
            </div>
            <span class="lis-text">取款</span>
          </div>
          <div class="lis" @click="$parent.goNav('/wallet')">
            <div class="icon-wrapper">
              <img src="/static/image/feature_bankcard.30833143844bfe739725bd4781495a2d.30833143.png" alt="" />
            </div>
            <span class="lis-text">卡片管理</span>
          </div>
        </div>
        <div style="height: 1rem"></div>
      </div>
      <div style="height: 1rem"></div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'money',
  data() {
    return {};
  },
  created() {
    let that = this;
  },
  methods: {
    transall() {
      let that = this;
      that.$parent.showLoading();
      that.$apiFun
        .post('/api/transall', {})
        .then(res => {
          that.showTost(1, res.message);
          that.refreshusermoney();
          that.$parent.hideLoading();
        })
        .catch(res => {
          that.$parent.hideLoading();
        });
    },
    refreshusermoney() {
      let that = this;
      that.$apiFun.post('/api/refreshusermoney', {}).then(res => {
        if (res.code == 200) {
          localStorage.setItem('userInfo', JSON.stringify(res.data));
          that.$store.commit('changUserInfo');
        }
      });
    },
    showTost(type, title) {
      this.$parent.showTost(type, title);
    },
  },
  mounted() {
    let that = this;
  },
  updated() {},
  beforeDestroy() {
    let that = this;
  },
};
</script>

<style lang="scss" scoped>
.tit {
  text-align: center;
  font-size: 0.5rem;
  font-weight: 700;
  height: 1.4rem;
  line-height: 1.4rem;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  color: #fff;
  background: url('/static/image/bg_01.c00a1854e1446ef9fbd9f5b282da92f1.c00a1854.png') no-repeat;
  background-size: 100% auto;
}
.mefs {
  color: #fff;
  height: 5.8rem;
  .conts {
    width: calc(100% - 80px);
    margin: 0 auto;
    padding-top: 0.6rem;
    .titsg {
      font-size: 0.48rem;
      opacity: 0.9;
      font-weight: 500;
    }
    .mehs {
      display: flex;
      align-items: flex-end;
      height: 0.62rem;
      padding-top: 0.4rem;
      line-height: 0.62rem;

      .lfs {
        font-size: 0.5rem;
        padding-top: 6px;
        display: table-cell;
        vertical-align: bottom;
        opacity: 0.9;
      }
      .num {
        font-size: 0.88rem;
        font-weight: 700;
        margin: 0 0.3rem 0 0.1rem;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        letter-spacing: 0.02rem;
      }
      .shua {
        width: 0.62rem;
        opacity: 0.9;
        transition: transform 0.3s ease;
        &:active {
          transform: rotate(180deg);
        }
      }
    }
  }
}
.bios {
  position: relative;
  width: calc(100% - 24px);
  margin: 0 auto;
  margin-top: -1.5rem;
  border-radius: 20px;
  background: #fff;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  .toptit {
    background: linear-gradient(135deg, #f2f4fc 0%, #e8ecf5 100%);
    height: 1.2rem;
    display: flex;
    align-items: center;
    color: #383b43;
    font-size: 0.4rem;
    font-weight: 600;
    box-sizing: border-box;
    padding: 0 20px;
    .shu {
      margin-right: 15px;
      height: 0.5rem;
      width: 3px;
      background: linear-gradient(180deg, #597ef7 0%, #1890ff 100%);
      border-radius: 2px;
    }
  }
}
.mesg {
  display: flex;
  align-items: center;
  min-height: 2.2rem;
  padding: 0.3rem 0;
  background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
  .bosgf {
    flex: 1;
    text-align: center;
    padding: 0 0.2rem;
    .wallet-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 16px;
      padding: 0.4rem 0.3rem;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
      .top {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.36rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 0.2rem;
        img {
          width: 0.5rem;
          margin-right: 0.1rem;
          filter: brightness(0) invert(1);
        }
      }
      .bots {
        display: flex;
        align-items: baseline;
        justify-content: center;
        .currency {
          font-size: 0.4rem;
          font-weight: 600;
          color: rgba(255, 255, 255, 0.9);
          margin-right: 0.1rem;
        }
        .amount {
          font-size: 0.64rem;
          font-weight: 700;
          color: #fff;
          letter-spacing: 0.02rem;
        }
      }
    }
  }
  .qibao {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    box-sizing: border-box;
    border-left: 1px solid #f0f0f0;
    padding: 0 0.2rem;
    .recover-btn {
      height: 0.8rem;
      line-height: 0.8rem;
      padding: 0 0.4rem;
      font-size: 0.32rem;
      font-weight: 600;
      border-radius: 0.4rem;
      min-width: 1.8rem;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
      transition: all 0.3s ease;
      .btn-icon {
        margin-right: 0.1rem;
        font-size: 0.32rem;
      }
      &:active {
        transform: scale(0.95);
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
      }
    }
  }
}
.typelist {
  display: flex;
  align-items: center;
  justify-content: space-around;
  padding: 0.4rem 0.2rem 0.5rem;
  gap: 0.2rem;
  .lis {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 0.3rem 0.2rem;
    border-radius: 12px;
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
    transition: all 0.3s ease;
    cursor: pointer;
    .icon-wrapper {
      width: 1rem;
      height: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 50%;
      margin-bottom: 0.2rem;
      box-shadow: 0 2px 8px rgba(102, 126, 234, 0.25);
      img {
        width: 0.5rem;
        height: 0.5rem;
        filter: brightness(0) invert(1);
      }
    }
    .lis-text {
      font-size: 0.3rem;
      color: #383b43;
      font-weight: 500;
      margin-top: 0.1rem;
    }
    &:active {
      transform: scale(0.95);
      background: linear-gradient(135deg, #e8ecf5 0%, #f2f4fc 100%);
    }
  }
}

</style>
