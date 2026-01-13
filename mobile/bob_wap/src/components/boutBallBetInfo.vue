<template>
  <div class="help-detail">
    <!-- 顶部导航 -->
    <van-nav-bar class="nav-header" :title="pageTitle" left-arrow @click-left="$router.back()" />

    <!-- 分类标签页 (游戏介绍/体育规则) -->
    <template v-if="isCategory">
      <van-tabs v-model="activeTab" class="category-tabs" @change="onTabChange">
        <van-tab v-for="tab in tabs" :key="tab.name" :title="tab.title" :name="tab.name">
          <div class="tab-content">
            <van-collapse v-model="activeNames" class="faq-list">
              <van-collapse-item
                v-for="item in currentList"
                :key="item.id"
                :title="item.title"
                :name="item.id"
              >
                <div class="faq-content" v-html="item.content"></div>
              </van-collapse-item>
            </van-collapse>
            <van-empty v-if="currentList.length === 0" description="暂无内容" />
          </div>
        </van-tab>
      </van-tabs>
    </template>

    <!-- 普通详情页 (联系我们/隐私政策等) -->
    <template v-else>
      <div class="article-content" v-html="articleContent"></div>
      <div v-if="articleContent" class="footer-tip">
        没有找到解决办法？请联系<a class="kefu-link" @click="$parent.openKefu">人工客服</a>解决
      </div>
    </template>
  </div>
</template>

<script>
export default {
  name: 'boutBallBetInfo',
  data() {
    return {
      pageTitle: '',
      isCategory: false,
      activeTab: '',
      activeNames: [],
      tabs: [],
      categoryData: {},
      articleContent: '',
      type: 0
    };
  },
  computed: {
    currentList() {
      return this.categoryData[this.activeTab] || [];
    }
  },
  created() {
    this.initPage();
  },
  methods: {
    initPage() {
      const query = this.$route.query;

      if (query.category) {
        // 分类页面 (游戏介绍/体育规则)
        this.isCategory = true;
        this.initCategoryPage(query.category);
      } else if (query.type) {
        // 普通详情页
        this.isCategory = false;
        this.type = query.type * 1;
        this.initArticlePage(this.type);
      }
    },

    // 初始化分类页面
    initCategoryPage(category) {
      if (category === 'games') {
        this.pageTitle = '游戏介绍';
        this.tabs = [
          { name: 'qipai', title: '棋牌玩法' },
          { name: 'dianzi', title: '电子玩法' },
          { name: 'yule', title: '娱乐玩法' },
          { name: 'tiyu', title: '体育赛事' },
          { name: 'zhenren', title: '真人娱乐' },
          { name: 'caipiao', title: '彩票投注' },
          { name: 'dianjing', title: '电子竞技' },
          { name: 'qita', title: '其它问题' }
        ];
        this.activeTab = 'qipai';
        this.loadGamesData();
      } else if (category === 'sports') {
        this.pageTitle = '体育规则';
        this.tabs = [
          { name: 'zuqiu', title: '足球规则' },
          { name: 'lanqiu', title: '篮球规则' },
          { name: 'wangqiu', title: '网球规则' },
          { name: 'paobu', title: '赛马规则' },
          { name: 'qita', title: '其它规则' }
        ];
        this.activeTab = 'zuqiu';
        this.loadSportsData();
      }
    },

    // 加载游戏介绍数据
    loadGamesData() {
      // 设置默认数据
      this.categoryData = {
        qipai: [
          { id: 1, title: '什么是对战类玩法？', content: '<p>对战类玩法是指玩家与玩家之间进行的直接对战游戏，如斗地主、德州扑克等。</p>' },
          { id: 2, title: '什么是百人玩法？', content: '<p>百人玩法是指多名玩家同时参与的游戏，如百人牛牛、百人炸金花等。</p>' },
          { id: 3, title: '什么是百家乐玩法？', content: '<p>百家乐是一种经典的纸牌游戏，玩家可以押注庄家、闲家或和局。</p>' },
          { id: 4, title: '什么是德州扑克玩法？', content: '<p>德州扑克是一种流行的扑克游戏，玩家使用两张底牌和五张公共牌组成最佳牌型。</p>' }
        ],
        dianzi: [
          { id: 1, title: '电子游戏怎么玩？', content: '<p>电子游戏包括老虎机、捕鱼等，点击进入游戏后按照提示进行操作即可。</p>' },
          { id: 2, title: '什么是累积奖金？', content: '<p>累积奖金是指随着游戏进行不断累积的奖金池，达成特定条件可获得大奖。</p>' }
        ],
        yule: [
          { id: 1, title: '娱乐游戏有哪些？', content: '<p>娱乐游戏包括各种休闲类游戏，如小游戏、互动游戏等。</p>' }
        ],
        tiyu: [
          { id: 1, title: '体育赛事投注规则？', content: '<p>体育赛事投注基于实际比赛结果进行结算，支持多种玩法。</p>' }
        ],
        zhenren: [
          { id: 1, title: '真人娱乐是什么？', content: '<p>真人娱乐是由真人荷官实时主持的游戏，包括真人百家乐、真人轮盘等。</p>' }
        ],
        caipiao: [
          { id: 1, title: '彩票投注规则？', content: '<p>彩票投注根据官方开奖结果进行结算，支持多种彩种投注。</p>' }
        ],
        dianjing: [
          { id: 1, title: '电子竞技投注？', content: '<p>电子竞技投注基于职业电竞比赛结果进行结算。</p>' }
        ],
        qita: [
          { id: 1, title: '其它常见问题？', content: '<p>如有其他问题，请联系在线客服。</p>' }
        ]
      };
    },

    // 加载体育规则数据
    loadSportsData() {
      this.categoryData = {
        zuqiu: [
          { id: 1, title: '足球比赛规则说明', content: '<p>足球比赛以90分钟常规时间结果为准，除特别说明外不包含加时赛和点球。</p>' },
          { id: 2, title: '让球盘怎么算？', content: '<p>让球盘是指强队让弱队一定的球数，最终结果需要加减让球数进行计算。</p>' },
          { id: 3, title: '大小球是什么？', content: '<p>大小球是指比赛双方的总进球数与开出的球数进行比较。</p>' }
        ],
        lanqiu: [
          { id: 1, title: '篮球比赛规则说明', content: '<p>篮球比赛包含加时赛结果，除特别说明外均以最终比分为准。</p>' },
          { id: 2, title: '篮球让分盘规则', content: '<p>篮球让分盘与足球让球盘类似，需要加减让分数计算最终结果。</p>' }
        ],
        wangqiu: [
          { id: 1, title: '网球比赛规则', content: '<p>网球比赛以最终获胜方为准，因伤退赛按规则处理。</p>' }
        ],
        paobu: [
          { id: 1, title: '赛马规则说明', content: '<p>赛马投注以官方公布的最终结果为准。</p>' }
        ],
        qita: [
          { id: 1, title: '其它体育规则', content: '<p>其它体育项目请参考具体赛事说明，如有疑问请联系客服。</p>' }
        ]
      };
    },

    // 初始化文章页面
    initArticlePage(type) {
      const titleMap = {
        1: '常见问题',
        2: '隐私政策',
        3: '免责说明',
        4: '联系我们',
        5: '代理加盟',
        7: '关于我们',
        8: '博彩责任'
      };
      this.pageTitle = titleMap[type] || '详情';
      this.loadArticle(type);
    },

    // 加载文章内容
    loadArticle(type) {
      let that = this;
      that.$parent.showLoading();

      that.$apiFun
        .post('/api/article', { type })
        .then(res => {
          if (res.data && res.data.content) {
            that.articleContent = res.data.content;
          }
          that.$parent.hideLoading();
        })
        .catch(() => {
          that.$parent.hideLoading();
        });
    },

    // 标签切换
    onTabChange(name) {
      this.activeNames = [];
    }
  }
};
</script>

<style lang="scss" scoped>
.help-detail {
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

// 分类标签页
.category-tabs {
  ::v-deep .van-tabs__nav {
    background: #fff;
  }

  ::v-deep .van-tab {
    color: #666;
    font-size: 13px;

    &--active {
      color: #3b7dd8;
      font-weight: 500;
    }
  }

  ::v-deep .van-tabs__line {
    background: #3b7dd8;
    width: 20px !important;
  }

  ::v-deep .van-tabs__wrap {
    border-bottom: 1px solid #eee;
  }
}

.tab-content {
  padding: 12px;
}

// FAQ列表
.faq-list {
  background: #fff;
  border-radius: 10px;
  overflow: hidden;

  ::v-deep .van-collapse-item {
    &__title {
      padding: 15px;
      font-size: 14px;
      color: #333;
    }

    &__content {
      padding: 0 15px 15px;
      font-size: 13px;
      color: #666;
      line-height: 1.6;
    }
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
}

// 文章内容
.article-content {
  padding: 15px;
  background: #fff;
  min-height: calc(100vh - 100px);
  font-size: 14px;
  line-height: 1.8;
  color: #333;

  ::v-deep {
    p {
      margin: 10px 0;
    }

    h1, h2, h3, h4, h5, h6 {
      margin: 15px 0 10px;
      color: #222;
    }

    ul, ol {
      padding-left: 20px;
      margin: 10px 0;
    }

    a {
      color: #3b7dd8;
    }

    img {
      max-width: 100%;
      height: auto;
    }
  }
}

// 底部提示
.footer-tip {
  text-align: center;
  padding: 20px;
  color: #6c7c9d;
  font-size: 13px;

  .kefu-link {
    color: #3b7dd8;
    font-weight: 600;
    cursor: pointer;
  }
}
</style>
