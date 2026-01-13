<template>
  <div class="help-center">
    <!-- 顶部导航 -->
    <van-nav-bar class="nav-header" title="帮助中心" left-arrow @click-left="$router.back()" />

    <div class="help-content">
      <!-- 教程卡片区域 -->
      <div class="tutorial-cards">
        <div class="card deposit" @click="goTutorial('deposit')">
          <img class="card-icon" src="/static/image/cunkuanjiaocheng.png" alt="存款教程" />
          <div class="card-info">
            <span class="card-title">存款教程</span>
            <span class="card-desc">轻松存取财富增值</span>
          </div>
          <van-icon name="arrow" class="card-arrow" />
        </div>
        <div class="card withdraw" @click="goTutorial('withdraw')">
          <img class="card-icon" src="/static/image/qukuanjiaocheng.png" alt="取款教程" />
          <div class="card-info">
            <span class="card-title">取款教程</span>
            <span class="card-desc">便捷取款轻松到账</span>
          </div>
          <van-icon name="arrow" class="card-arrow" />
        </div>
      </div>

      <!-- 快捷入口 -->
      <div class="quick-links">
        <div class="link-item" @click="goCategory('games')">
          <img class="link-icon" src="/static/image/youxijieshao.png" alt="游戏介绍" />
          <span class="link-text">游戏介绍</span>
        </div>
        <div class="link-item" @click="goCategory('sports')">
          <img class="link-icon" src="/static/image/tiyuanguize.png" alt="体育规则" />
          <span class="link-text">体育规则</span>
        </div>
        <div class="link-item" @click="goCategory('support')">
          <img class="link-icon" src="/static/image/jishuzhichi.png" alt="技术支持" />
          <span class="link-text">技术支持</span>
        </div>
        <div class="link-item" @click="goCategory('contact')">
          <img class="link-icon" src="/static/image/lianxiwomen.png" alt="联系我们" />
          <span class="link-text">联系我们</span>
        </div>
      </div>

      <!-- 常见问题 -->
      <div class="faq-section">
        <div class="section-header">
          <img class="section-icon" src="/static/image/1587555761884253.png" alt="常见问题" />
          <span class="section-title">常见问题</span>
        </div>
        <van-collapse v-model="activeNames" class="faq-collapse">
          <van-collapse-item
            v-for="item in faqList"
            :key="item.id"
            :title="item.title"
            :name="item.id"
          >
            <div class="faq-content" v-html="item.content"></div>
          </van-collapse-item>
        </van-collapse>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'boutBallBet',
  data() {
    return {
      activeNames: [],
      faqList: []
    };
  },
  created() {
    this.loadFaqList();
  },
  methods: {
    // 加载常见问题列表
    loadFaqList() {
      let that = this;
      that.$parent.showLoading();

      that.$apiFun
        .post('/api/article', { type: 1 })
        .then(res => {
          // 解析FAQ内容，将HTML内容转换为问题列表
          if (res.data && res.data.content) {
            // 尝试解析后端返回的内容
            that.parseFaqContent(res.data.content);
          }
          that.$parent.hideLoading();
        })
        .catch(() => {
          that.$parent.hideLoading();
          // 使用默认FAQ
          that.setDefaultFaq();
        });
    },

    // 解析FAQ内容
    parseFaqContent(content) {
      // 如果后端返回的是结构化数据，直接使用
      // 否则设置默认FAQ
      this.setDefaultFaq();
    },

    // 设置默认FAQ列表
    setDefaultFaq() {
      this.faqList = [
        {
          id: 1,
          title: '如何取款',
          content: `
            <p><strong>1</strong> 第一次取款请先绑定银行卡，绑定银行卡步骤：</p>
            <p>a.登录账号 -- 我的页面 -- 卡片管理 -- 添加银行卡；</p>
            <p>b.登录账号 -- 首页/我的钱包 -- 点击取款 -- 添加银行卡。</p>
            <p><strong>2</strong> 绑定完成后在取款金额输入框输入金额，点击立即取款。</p>
          `
        },
        {
          id: 2,
          title: '可以使用别人的银行卡进行取款吗？',
          content: '<p>不可以，为了保障您的资金安全，取款银行卡必须是本人实名认证的银行卡。</p>'
        },
        {
          id: 3,
          title: '申请取款需要注意些什么？',
          content: '<p>1. 确保银行卡信息正确无误；<br/>2. 注意取款限额；<br/>3. 确保账户余额充足；<br/>4. 注意取款时间可能因银行处理而有所延迟。</p>'
        },
        {
          id: 4,
          title: '游戏账户里有钱为什么无法取款？',
          content: '<p>可能原因：<br/>1. 未完成流水要求；<br/>2. 存在未结算的投注；<br/>3. 账户存在异常需要审核；<br/>请联系客服获取更多帮助。</p>'
        },
        {
          id: 5,
          title: '可以绑定多张银行卡吗？',
          content: '<p>可以绑定多张银行卡，但取款时只能选择其中一张进行取款。</p>'
        },
        {
          id: 6,
          title: '取款为什么还需要审核？',
          content: '<p>为了保障您的资金安全，所有取款申请都需要经过风控审核，正常情况下审核时间为1-30分钟。</p>'
        }
      ];
    },

    // 跳转到教程页面
    goTutorial(type) {
      this.$parent.goNav(`/helpTutorial?type=${type}`);
    },

    // 跳转到分类页面
    goCategory(category) {
      const categoryMap = {
        games: { type: 'games', title: '游戏介绍' },
        sports: { type: 'sports', title: '体育规则' },
        support: { type: 4, title: '技术支持' },
        contact: { type: 4, title: '联系我们' }
      };

      const item = categoryMap[category];
      if (category === 'games' || category === 'sports') {
        this.$parent.goNav(`/boutBallBetInfo?category=${item.type}`);
      } else if (category === 'support') {
        // 技术支持 - 打开客服
        this.$parent.openKefu();
      } else if (category === 'contact') {
        // 联系我们
        this.$parent.goNav('/boutBallBetInfo?type=4');
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.help-center {
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

.help-content {
  padding: 12px;
}

// 教程卡片
.tutorial-cards {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;

  .card {
    flex: 1;
    display: flex;
    align-items: center;
    padding: 15px 12px;
    border-radius: 10px;
    cursor: pointer;

    &.deposit {
      background: linear-gradient(135deg, #3b7dd8 0%, #2563a8 100%);
    }

    &.withdraw {
      background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
    }

    .card-icon {
      width: 36px;
      height: 36px;
      margin-right: 10px;
    }

    .card-info {
      flex: 1;
      display: flex;
      flex-direction: column;

      .card-title {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 4px;
      }

      .card-desc {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.7);
      }
    }

    .card-arrow {
      color: rgba(255, 255, 255, 0.5);
      font-size: 14px;
    }
  }
}

// 快捷入口
.quick-links {
  display: flex;
  justify-content: space-around;
  background: #fff;
  border-radius: 10px;
  padding: 20px 10px;
  margin-bottom: 15px;

  .link-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;

    .link-icon {
      width: 40px;
      height: 40px;
      margin-bottom: 8px;
    }

    .link-text {
      font-size: 12px;
      color: #333;
    }
  }
}

// 常见问题
.faq-section {
  background: #fff;
  border-radius: 10px;
  overflow: hidden;

  .section-header {
    display: flex;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;

    .section-icon {
      width: 20px;
      height: 20px;
      margin-right: 8px;
    }

    .section-title {
      font-size: 14px;
      font-weight: 600;
      color: #333;
    }
  }

  .faq-collapse {
    ::v-deep .van-collapse-item__title {
      padding: 15px;
      font-size: 14px;
      color: #333;
    }

    ::v-deep .van-collapse-item__content {
      padding: 0 15px 15px;
      font-size: 13px;
      color: #666;
      line-height: 1.6;
    }

    ::v-deep .van-cell::after {
      left: 15px;
      right: 15px;
    }
  }

  .faq-content {
    p {
      margin: 8px 0;
    }

    strong {
      display: inline-block;
      width: 20px;
      height: 20px;
      line-height: 20px;
      text-align: center;
      background: #3b7dd8;
      color: #fff;
      border-radius: 50%;
      font-size: 12px;
      margin-right: 8px;
    }
  }
}
</style>
