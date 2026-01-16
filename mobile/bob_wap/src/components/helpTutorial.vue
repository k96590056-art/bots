<template>
  <div class="help-tutorial">
    <!-- 顶部导航 -->
    <van-nav-bar class="nav-header" :title="pageTitle" left-arrow @click-left="$router.back()" />

    <div class="tutorial-content">
      <!-- 教程类型切换 -->
      <div class="type-selector" v-if="tutorialTypes.length > 0">
        <div
          class="type-item"
          v-for="item in tutorialTypes"
          :key="item.key"
          :class="{ active: currentType === item.key }"
          @click="switchType(item.key)"
        >
          <img class="type-icon" :src="item.icon" :alt="item.title" />
          <span class="type-text">{{ item.title }}</span>
          <van-icon name="arrow" class="type-arrow" />
        </div>
      </div>

      <!-- 步骤指示器 -->
      <div class="step-indicator">
        <span class="step-text">步骤 </span>
        <span class="step-current">{{ currentStep }}</span>
        <span class="step-separator">/</span>
        <span class="step-total">{{ totalSteps }}</span>
      </div>

      <!-- 手机模拟框 -->
      <div class="phone-mockup">
        <div class="phone-screen">
          <div class="phone-content" v-html="currentStepContent"></div>
        </div>
      </div>

      <!-- 步骤点指示器 -->
      <div class="step-dots">
        <div
          class="dot"
          v-for="step in totalSteps"
          :key="step"
          :class="{ active: currentStep === step }"
          @click="goToStep(step)"
        ></div>
      </div>

      <!-- 导航按钮 -->
      <div class="nav-buttons">
        <van-button
          class="nav-btn prev"
          :disabled="currentStep === 1"
          @click="prevStep"
        >
          上一步
        </van-button>
        <van-button
          class="nav-btn next"
          type="primary"
          :disabled="currentStep === totalSteps"
          @click="nextStep"
        >
          下一步
        </van-button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'helpTutorial',
  data() {
    return {
      pageTitle: '存款教程',
      tutorialType: 'deposit',
      currentType: 'crypto',
      currentStep: 1,
      tutorialTypes: [],
      tutorialSteps: {}
    };
  },
  computed: {
    totalSteps() {
      const steps = this.tutorialSteps[this.currentType];
      return steps ? steps.length : 0;
    },
    currentStepContent() {
      const steps = this.tutorialSteps[this.currentType];
      if (steps && steps[this.currentStep - 1]) {
        return steps[this.currentStep - 1].content;
      }
      return '';
    }
  },
  created() {
    this.initTutorial();
  },
  methods: {
    initTutorial() {
      const query = this.$route.query;
      this.tutorialType = query.type || 'deposit';

      if (this.tutorialType === 'deposit') {
        this.pageTitle = '存款教程';
        this.initDepositTutorial();
      } else {
        this.pageTitle = '取款教程';
        this.initWithdrawTutorial();
      }
    },

    // 初始化存款教程
    initDepositTutorial() {
      this.tutorialTypes = [
        { key: 'crypto', title: '快捷虚拟币', icon: '/static/image/cunkuanjiaocheng.png' }
      ];
      this.currentType = 'crypto';

      this.tutorialSteps = {
        crypto: [
          {
            title: '步骤1',
            content: `
              <div class="step-content">
                <h3>支付方式</h3>
                <p>永久网址: jiuyou.com ✓</p>
                <div class="step-item highlight">
                  <div class="step-icon">
                    <img src="/static/image/cunkuanjiaocheng.png" alt="" />
                  </div>
                  <div class="step-info">
                    <span class="step-num">1</span>
                    <span class="step-desc">点击快捷虚拟币</span>
                  </div>
                </div>
                <h3>虚拟币种类</h3>
                <div class="step-item">
                  <span class="tag">USDT</span>
                  <div class="step-info">
                    <span class="step-num">2</span>
                    <span class="step-desc">选择虚拟币种类</span>
                  </div>
                </div>
                <h3>虚拟币协议</h3>
                <div class="step-item">
                  <span class="tag">TRC20</span>
                  <div class="step-info">
                    <span class="step-num">3</span>
                    <span class="step-desc">选择协议</span>
                  </div>
                </div>
                <h3>存款信息</h3>
                <div class="qrcode-box">
                  <div class="qrcode-placeholder">二维码</div>
                </div>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">4</span>
                    <span class="step-desc">点击复制地址或者截图二维码</span>
                  </div>
                </div>
              </div>
            `
          },
          {
            title: '步骤2',
            content: `
              <div class="step-content">
                <h3>打开钱包APP</h3>
                <div class="step-item highlight">
                  <div class="step-info">
                    <span class="step-num">1</span>
                    <span class="step-desc">打开您的虚拟币钱包APP（如TokenPocket、imToken等）</span>
                  </div>
                </div>
                <h3>选择转账</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">2</span>
                    <span class="step-desc">点击转账或发送功能</span>
                  </div>
                </div>
                <h3>粘贴地址</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">3</span>
                    <span class="step-desc">粘贴刚才复制的充值地址或扫描二维码</span>
                  </div>
                </div>
              </div>
            `
          },
          {
            title: '步骤3',
            content: `
              <div class="step-content">
                <h3>输入金额</h3>
                <div class="step-item highlight">
                  <div class="step-info">
                    <span class="step-num">1</span>
                    <span class="step-desc">输入您要充值的USDT数量</span>
                  </div>
                </div>
                <h3>确认信息</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">2</span>
                    <span class="step-desc">确认收款地址和金额无误</span>
                  </div>
                </div>
                <h3>确认转账</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">3</span>
                    <span class="step-desc">点击确认，完成转账</span>
                  </div>
                </div>
              </div>
            `
          },
          {
            title: '步骤4',
            content: `
              <div class="step-content">
                <h3>等待到账</h3>
                <div class="step-item highlight">
                  <div class="step-info">
                    <span class="step-num">1</span>
                    <span class="step-desc">转账成功后，等待区块链确认</span>
                  </div>
                </div>
                <h3>到账时间</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">2</span>
                    <span class="step-desc">通常1-10分钟内到账，网络拥堵时可能更长</span>
                  </div>
                </div>
                <h3>查看余额</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">3</span>
                    <span class="step-desc">到账后可在钱包页面查看余额</span>
                  </div>
                </div>
                <div class="success-tip">
                  <van-icon name="checked" />
                  <span>存款完成！</span>
                </div>
              </div>
            `
          }
        ]
      };
    },

    // 初始化取款教程
    initWithdrawTutorial() {
      this.tutorialTypes = [
        { key: 'bank', title: '银行卡取款', icon: '/static/image/qukuanjiaocheng.png' }
      ];
      this.currentType = 'bank';

      this.tutorialSteps = {
        bank: [
          {
            title: '步骤1',
            content: `
              <div class="step-content">
                <h3>绑定银行卡</h3>
                <div class="step-item highlight">
                  <div class="step-info">
                    <span class="step-num">1</span>
                    <span class="step-desc">首次取款需先绑定银行卡</span>
                  </div>
                </div>
                <h3>进入卡片管理</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">2</span>
                    <span class="step-desc">我的 → 卡片管理 → 添加银行卡</span>
                  </div>
                </div>
                <h3>填写信息</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">3</span>
                    <span class="step-desc">输入银行卡号、开户行等信息</span>
                  </div>
                </div>
              </div>
            `
          },
          {
            title: '步骤2',
            content: `
              <div class="step-content">
                <h3>进入取款页面</h3>
                <div class="step-item highlight">
                  <div class="step-info">
                    <span class="step-num">1</span>
                    <span class="step-desc">点击首页或我的钱包中的"取款"按钮</span>
                  </div>
                </div>
                <h3>选择银行卡</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">2</span>
                    <span class="step-desc">选择要接收款项的银行卡</span>
                  </div>
                </div>
              </div>
            `
          },
          {
            title: '步骤3',
            content: `
              <div class="step-content">
                <h3>输入取款金额</h3>
                <div class="step-item highlight">
                  <div class="step-info">
                    <span class="step-num">1</span>
                    <span class="step-desc">在输入框中输入取款金额</span>
                  </div>
                </div>
                <h3>确认信息</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">2</span>
                    <span class="step-desc">确认取款金额和银行卡信息</span>
                  </div>
                </div>
                <h3>提交申请</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">3</span>
                    <span class="step-desc">点击"立即取款"提交申请</span>
                  </div>
                </div>
              </div>
            `
          },
          {
            title: '步骤4',
            content: `
              <div class="step-content">
                <h3>等待审核</h3>
                <div class="step-item highlight">
                  <div class="step-info">
                    <span class="step-num">1</span>
                    <span class="step-desc">取款申请提交后等待审核</span>
                  </div>
                </div>
                <h3>审核时间</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">2</span>
                    <span class="step-desc">通常1-30分钟内完成审核</span>
                  </div>
                </div>
                <h3>到账时间</h3>
                <div class="step-item">
                  <div class="step-info">
                    <span class="step-num">3</span>
                    <span class="step-desc">审核通过后，款项将打入您的银行卡</span>
                  </div>
                </div>
                <div class="success-tip">
                  <van-icon name="checked" />
                  <span>取款完成！</span>
                </div>
              </div>
            `
          }
        ]
      };
    },

    // 切换教程类型
    switchType(type) {
      this.currentType = type;
      this.currentStep = 1;
    },

    // 上一步
    prevStep() {
      if (this.currentStep > 1) {
        this.currentStep--;
      }
    },

    // 下一步
    nextStep() {
      if (this.currentStep < this.totalSteps) {
        this.currentStep++;
      }
    },

    // 跳转到指定步骤
    goToStep(step) {
      this.currentStep = step;
    }
  }
};
</script>

<style lang="scss" scoped>
.help-tutorial {
  min-height: 100vh;
  background: #f5f5f5;
}

.nav-header {
  background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);

  ::v-deep .van-nav-bar__title {
    color: #fff;
  }

  ::v-deep .van-nav-bar__arrow {
    color: #fff;
  }
}

.tutorial-content {
  padding: 15px;
}

// 教程类型选择器
.type-selector {
  margin-bottom: 15px;

  .type-item {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 10px;
    padding: 12px 15px;
    margin-bottom: 10px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s;

    &.active {
      border-color: #3b7dd8;
      background: #f0f7ff;
    }

    .type-icon {
      width: 32px;
      height: 32px;
      margin-right: 12px;
    }

    .type-text {
      flex: 1;
      font-size: 14px;
      color: #333;
      font-weight: 500;
    }

    .type-arrow {
      color: #999;
    }
  }
}

// 步骤指示器
.step-indicator {
  text-align: center;
  margin-bottom: 15px;
  color: #3b7dd8;
  font-size: 14px;

  .step-current {
    font-size: 18px;
    font-weight: 600;
  }

  .step-separator {
    margin: 0 2px;
  }
}

// 手机模拟框
.phone-mockup {
  background: #fff;
  border-radius: 20px;
  padding: 10px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  margin-bottom: 20px;

  .phone-screen {
    background: #f9f9f9;
    border-radius: 15px;
    min-height: 400px;
    padding: 15px;
    overflow: auto;
  }
}

// 步骤内容样式
::v-deep .step-content {
  h3 {
    font-size: 13px;
    color: #666;
    margin: 15px 0 10px;
    font-weight: normal;

    &:first-child {
      margin-top: 0;
    }
  }

  .step-item {
    display: flex;
    align-items: center;
    padding: 10px 12px;
    background: #fff;
    border-radius: 8px;
    margin-bottom: 8px;
    border: 1px solid #eee;

    &.highlight {
      background: #f0f7ff;
      border-color: #3b7dd8;
    }

    .step-icon {
      width: 36px;
      height: 36px;
      margin-right: 10px;

      img {
        width: 100%;
        height: 100%;
      }
    }

    .tag {
      display: inline-block;
      padding: 4px 12px;
      background: #e6f7ff;
      color: #1890ff;
      border-radius: 4px;
      font-size: 12px;
      margin-right: 10px;
    }

    .step-info {
      display: flex;
      align-items: center;
      flex: 1;

      .step-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        background: #3b7dd8;
        color: #fff;
        border-radius: 50%;
        font-size: 11px;
        margin-right: 8px;
      }

      .step-desc {
        font-size: 13px;
        color: #333;
      }
    }
  }

  .qrcode-box {
    display: flex;
    justify-content: center;
    margin: 10px 0;

    .qrcode-placeholder {
      width: 100px;
      height: 100px;
      background: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #999;
      font-size: 12px;
      border-radius: 8px;
    }
  }

  .success-tip {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px;
    background: #f6ffed;
    border-radius: 8px;
    margin-top: 20px;
    color: #52c41a;
    font-size: 14px;

    .van-icon {
      font-size: 20px;
      margin-right: 8px;
    }
  }
}

// 步骤点指示器
.step-dots {
  display: flex;
  justify-content: center;
  gap: 8px;
  margin-bottom: 20px;

  .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #ddd;
    cursor: pointer;
    transition: all 0.3s;

    &.active {
      background: #3b7dd8;
      width: 20px;
      border-radius: 4px;
    }
  }
}

// 导航按钮
.nav-buttons {
  display: flex;
  gap: 15px;

  .nav-btn {
    flex: 1;
    height: 44px;
    border-radius: 22px;
    font-size: 14px;

    &.prev {
      background: #fff;
      color: #666;
      border: 1px solid #ddd;
    }

    &.next {
      background: #3b7dd8;
      border: none;
    }
  }
}
</style>
