<template>
  <div v-if="bannerList.length > 0" class="page-wrapper">
    <div id="redPacket" v-if="$store.state.appInfo.redpacket_switch == 1 && hongbashow">
      <i @click="$parent.goNav('/hongbao')" class="grab"></i>
      <img @click="changhongbashow" src="/static/image/hongbaocolse.png" />
    </div>

    <!-- Logo展示 - 不做卡片 -->
    <div class="top-logo-area">
      <div class="top-logo" @click="goToH5">
        <img :src="$store.state.appInfo.site_logo" alt="" class="logo" />
        <div class="logo-text">
          <div class="logo-title">{{ $store.state.appInfo.site_name }}</div>
          <div class="logo-domain">{{ ($store.state.appInfo.h5_url || '').replace(/^https?:\/\//, '') }}</div>
        </div>
      </div>
    </div>

    <!-- Banner + 用户信息 合并卡片 -->
    <div class="card-block banner-user-card">
      <!-- 轮播图 -->
      <div class="banner-wrapper">
        <van-swipe ref="bannerSwipe" :autoplay="false" :initial-swipe="current" @change="onChange" :show-indicators="false">
          <van-swipe-item v-for="(item, index) in bannerList" :key="index">
            <img :src="item.src" style="width: 100%" alt="" class="banner-image" />
          </van-swipe-item>
        </van-swipe>
        <!-- 轮播图底部圆点 -->
        <div class="banner-pagination">
          <div
            v-for="(item, index) in bannerList"
            :key="index"
            :class="['pagination-dot', current === index ? 'active' : '']"
            @click="goToBanner(index)"
          ></div>
        </div>
      </div>

      <!-- 公告栏 -->
      <div class="notice-bar-inline">
        <div class="notice-icon-wrap">
          <svg viewBox="0 0 24 24" fill="#1890ff" width="16" height="16">
            <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
          </svg>
        </div>
        <div class="notice-content">
          <van-notice-bar color="#666" background="transparent" scrollable v-if="homenoticelis && homenoticelis.length > 0">
            <span v-for="(item, index) in homenoticelis" @click="openGogao(item)" :key="index">{{ item }}</span>
          </van-notice-bar>
          <span v-else class="notice-placeholder">暂无公告</span>
        </div>
      </div>

      <!-- 用户信息和操作按钮 -->
      <div class="user-wallet-area">
        <div class="user-info-left" v-if="$store.state.token">
          <div class="user-name">{{ $store.state.userInfo.username }}</div>
          <div class="user-balance">
            <span class="balance-amount">{{ balanceVisible ? '¥ ' + $store.state.userInfo.balance : '******' }}</span>
            <img
              @click="toggleBalanceVisible"
              :class="['toggle-eye-icon', balanceVisible ? 'eye-open' : 'eye-closed']"
              :src="balanceVisible ? eyeOpenIcon : eyeClosedIcon"
              alt="显示/隐藏余额"
            />
          </div>
        </div>
        <div v-else class="user-info-left" @click="$parent.goNav('/login')">
          <div class="user-name not-login">您还未登录</div>
          <div class="user-tip">登录/注册后查看</div>
        </div>
        <div class="user-actions">
          <div class="action-btn" @click="$parent.goNav('/recharge')">
            <div class="action-icon">
              <img src="/static/image/icon_deposit.png" alt="存款" class="action-icon-img" />
            </div>
            <span>存款</span>
          </div>
          <div class="action-btn" @click="$parent.goNav('/transfer')">
            <div class="action-icon">
              <img src="/static/image/icon_transfer.png" alt="转账" class="action-icon-img" />
            </div>
            <span>转账</span>
          </div>
          <div class="action-btn" @click="$parent.goNav('/withdrawal')">
            <div class="action-icon">
              <img src="/static/image/imagewithdraw.png" alt="取款" class="action-icon-img" />
            </div>
            <span>取款</span>
          </div>
          <div class="action-btn" @click="$parent.goNav('/applyagent')">
            <div class="action-icon">
              <img src="/static/image/icon_promote.png" alt="推广" class="action-icon-img" />
            </div>
            <span>推广</span>
          </div>
        </div>
      </div>
    </div>
    <div class="domainModal_domainView__FWCzg" v-if="goInfo">
      <div class="domainModal_mask__24Y2m domainModal_fadeIn__1I3AS false" @click="goInfo = null"></div>
      <div class="domainModal_content__1nBgc" style="width: 80%">
        <img src="/static/image/hongbaocolse.png" @click="goInfo = null" style="position: absolute; top: 5px; right: 13px; width: 0.7rem" alt="" />

        <div class="domainModal_middle__3gQPm" style="padding: 35px 10px 15px">
          {{ goInfo }}

          <van-button type="info" style="margin: 0 auto; margin-top: 20px; width: 120px; border-radius: 10px; height: 35px" @click="$parent.goNav('/message')">更多公告</van-button>
        </div>
      </div>
    </div>
    <!-- 游戏菜单 - 单独卡片 -->
    <div class="card-block game-nav-card">
      <div class="game-nav">
        <div :class="['nav-item', gameType == 3 ? 'active' : '']" @click="changGameType(3)">
          <img v-if="gameType == 3" src="/static/image/chess.png" class="nav-icon" />
          <span>棋牌</span>
        </div>
        <div :class="['nav-item', gameType == 4 ? 'active' : '']" @click="changGameType(4)">
          <img v-if="gameType == 4" src="/static/image/electronic.png" class="nav-icon" />
          <span>电子</span>
        </div>
        <div :class="['nav-item', gameType == 5 ? 'active' : '']" @click="changGameType(5)">
          <img v-if="gameType == 5" src="/static/image/lottery.png" class="nav-icon" />
          <span>彩票</span>
        </div>
        <div :class="['nav-item', gameType == 0 ? 'active' : '']" @click="changGameType(0)">
          <img v-if="gameType == 0" src="/static/image/real_person.png" class="nav-icon" />
          <span>真人</span>
        </div>
        <div :class="['nav-item', gameType == 1 ? 'active' : '']" @click="changGameType(1)">
          <img v-if="gameType == 1" src="/static/image/sports.png" class="nav-icon" />
          <span>体育</span>
        </div>
        <div :class="['nav-item', gameType == 2 ? 'active' : '']" @click="changGameType(2)">
          <img v-if="gameType == 2" src="/static/image/esports.png" class="nav-icon" />
          <span>电竞</span>
        </div>
      </div>
    </div>

    <!-- 游戏列表 - 卡片横向滚动 -->
    <div class="game-list-scroll">
      <div class="game-list-container">
        <!-- 电子游戏特殊处理：第一个是DB棋牌 -->
        <div v-if="gameType == 4" class="game-list-item card-block" @click="$parent.goNav('/concise?type=obgdy')">
          <div class="game-card-tag official-rec">官方推荐</div>
          <div class="game-card-body">
            <div class="game-card-title">DB棋牌</div>
            <div class="game-card-desc">
              <div class="backwater-wrapper">
                <img src="/static/image/backwater.png" alt="无限返水" class="backwater-img" />
                <div class="rebate-tag">
                  <span class="rebate-label">高达</span>
                  <span class="rebate-value">1.20<em>%</em></span>
                </div>
              </div>
            </div>
            <div class="game-card-count">
              <span class="count-line"></span>
              <span class="count-num">21<em>种</em></span>
              <span class="count-line"></span>
            </div>
          </div>
          <div class="game-card-image">
            <img src="/static/image/concise/obgdy.png" alt="" />
          </div>
        </div>

        <!-- 通用游戏列表 -->
        <template v-if="currentGameList && currentGameList.length > 0">
          <div
            class="game-list-item card-block"
            v-for="(item, index) in currentGameList"
            :key="`${gameType}-${index}`"
            @click="handleGameClick(item, index)"
          >
            <div class="game-card-tag" :class="getCardHeaderClass(index)">
              {{ getCardHeaderText(index) }}
            </div>
            <div class="game-card-body">
              <div class="game-card-title">{{ getCardTitle(item, index) }}</div>
              <div class="game-card-desc">
                <div class="backwater-wrapper">
                  <img src="/static/image/backwater.png" alt="无限返水" class="backwater-img" />
                  <div class="rebate-tag">
                    <span class="rebate-label">高达</span>
                    <span class="rebate-value">1.20<em>%</em></span>
                  </div>
                </div>
              </div>
              <div class="game-card-count">
                <span class="count-line"></span>
                <span class="count-num">{{ getCardCount(index) }}<em>种</em></span>
                <span class="count-line"></span>
              </div>
            </div>
            <div class="game-card-image">
              <img :src="getCardImage(item)" alt="" @error="handleImageError" />
            </div>
          </div>
        </template>
        <div v-else-if="gameType !== 4" class="empty-game-list">暂无游戏数据</div>
      </div>
    </div>

    <!-- 弹出层 -->
    <van-popup v-model="leftshow" position="left" :style="{ height: '100%' }">
      <div class="leftbox">
        <div class="side__main__1NhyG">
          <h3>Hi，欢迎进入{{ $store.state.appInfo.title }}</h3>
          <dl class="side__vip__1dW8w">
            <div class="topxs">专属VIP体验</div>
            <p>立享会员特权</p>
            <p>享受只属于你的与众不同</p>
            <dd @click="$parent.goNav('/vip')">会员中心</dd>
          </dl>
          <ul class="menu-list">
            <li v-if="$store.state.token" @click="$parent.goNav('/message')"><img src="/static/image/meunIcon.39f38dc98ad956615952d485d0e6af04.svg" />消息中心<span class="side__subtitle__3QtYC"></span></li>
            <li @click="$parent.openKefu"><img src="/static/image/meunIcon2.5d0d78496889fb8b027f603254286fdf.svg" />意见反馈<span class="side__subtitle__3QtYC"></span></li>
            <li @click="doCopy($store.state.appInfo.h5_url)">
              <img src="/static/image/menuIcon5.5687ef4d1512d53aa3535e3b1088fe70.png" />永久域名<span class="side__subtitle__3QtYC">{{ $store.state.appInfo.h5_url }}</span>
            </li>
            <li @click="$parent.goNav('/abouts')"><img src="/static/image/meunIcon3.c51bbb9ebece978f1976397ab12acba7.svg" />关于我们<span class="side__subtitle__3QtYC"></span></li>
          </ul>
          <div class="nisd login-btn" v-if="!$store.state.token" @click="$parent.goNav('/login')">立即登录</div>
          <div class="nisd logout-btn" v-else @click="$parent.outLogin"><img src="/static/image/tuichu.93c1b9e3d4b4a7772481916ca32c074f.svg" />安全退出</div>
        </div>
      </div>
    </van-popup>

    <!-- 官网弹窗 -->
    <div class="domainModal_domainView__FWCzg" v-if="$store.state.appInfo.index_modal == 1 && tanshow">
      <div class="domainModal_mask__24Y2m domainModal_fadeIn__1I3AS false" @click="changtanshow"></div>
      <div class="domainModal_content__1nBgc" style="width: 80%">
        <div id="domain" class="domainModal_contentTop__2C4jc">
          <img src="/static/image/hongbaocolse.png" @click="changtanshow" style="position: absolute; top: 5px; right: 13px; width: 0.6rem" alt="" />

          <div class="domainModal_top__1omYS">欢迎来到{{ $store.state.appInfo.title }}</div>
          <div class="domainModal_middle__3gQPm" v-html="$store.state.appInfo.webcontent"></div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'index',
  data() {
    return {
      hongbashow: true,
      current: 0,
      bannerList: [],
      homenoticelis: [],
      // 弹出层
      leftshow: false,
      activeKey: 0,
      gameType: 0,
      tanshow: true,
      goInfo: null,
      // 余额显示控制
      balanceVisible: true,
      // 眼睛图标 - 睁眼
      eyeOpenIcon: '/static/image/see.png',
      // 眼睛图标 - 闭眼
      eyeClosedIcon: '/static/image/no_see.png',
    };
  },
  computed: {
    // 根据当前游戏类型返回对应的游戏列表
    currentGameList() {
      const gameTypeMap = {
        0: this.$store.state.realbetList || [],
        1: this.$store.state.sportList || [],
        2: this.$store.state.gamingList || [],
        3: this.$store.state.jokerList || [],
        4: this.$store.state.conciseList || [],
        5: this.$store.state.lotteryList || []
      };
      return gameTypeMap[this.gameType] || [];
    },
    // 游戏类型对应的图片路径前缀
    imagePathPrefix() {
      const prefixMap = {
        0: 'realbet',
        1: 'sport',
        2: 'gaming',
        3: 'joker',
        4: 'concise',
        5: 'lottery'
      };
      return prefixMap[this.gameType] || '';
    }
  },
  created() {
    let that = this;
    // 从 localStorage 加载游戏列表数据到 store
    that.$store.commit('changGameList');
    
    // 调试信息：检查数据是否加载成功
    console.log('首页组件创建，游戏列表数据:', {
      realbetList: that.$store.state.realbetList.length,
      jokerList: that.$store.state.jokerList.length,
      gamingList: that.$store.state.gamingList.length,
      sportList: that.$store.state.sportList.length,
      lotteryList: that.$store.state.lotteryList.length,
      conciseList: that.$store.state.conciseList.length,
      currentGameType: that.gameType
    });
    
    that.getBanList();
    that.homenotice(); //获取公告
  },
  methods: {
    openGogao(val) {
      this.goInfo = val;
    },
    toggleBalanceVisible() {
      this.balanceVisible = !this.balanceVisible;
    },
    changtanshow() {
      this.tanshow = !this.tanshow;
    },
    changGameType(type) {
      this.gameType = type;
      // 调试信息：切换游戏类型时检查数据
      let listName = ['realbetList', 'sportList', 'gamingList', 'jokerList', 'conciseList', 'lotteryList'][type];
      let list = this.$store.state[listName] || [];
      console.log(`切换到游戏类型 ${type} (${['真人', '体育', '电竞', '棋牌', '电子', '彩票'][type]}), 数据量:`, list.length, list);
    },
    doCopy(msg) {
      let cInput = document.createElement('input');
      cInput.style.opacity = '0';
      cInput.value = msg;
      document.body.appendChild(cInput);
      // 选取文本框内容
      cInput.select();

      // 执行浏览器复制命令
      // 复制命令会将当前选中的内容复制到剪切板中（这里就是创建的input标签）
      // Input要在正常的编辑状态下原生复制方法才会生效
      document.execCommand('copy');

      // 复制成功后再将构造的标签 移除
      this.$parent.showTost(1, '复制成功！');
    },
    changleftshow() {
      this.leftshow = !this.leftshow;
    },
    getBanList() {
      let that = this;
      that.$parent.showLoading();
      that.$apiFun
        .post('/api/bannerList', { type: 2 })
        .then(res => {
          if (res.code != 200) {
            that.showTost(0, res.message);
          }
          if (res.code == 200) {
            that.bannerList = res.data;
          }
          that.$parent.hideLoading();
        })
        .catch(res => {
          that.$parent.hideLoading();
        });
    },
    homenotice() {
      let that = this;
      that.$apiFun.post('/api/homenotice', {}).then(res => {
        console.log('公告接口返回:', res);
        if (res.code != 200) {
          console.log('公告接口错误:', res.message);
        }
        if (res.code == 200) {
          console.log('公告数据:', res.data);
          that.homenoticelis = res.data;
          that.ok = true;
        }
      }).catch(err => {
        console.error('公告接口请求失败:', err);
      });
    },
    onChange(index) {
      this.current = index;
    },
    // 点击圆点切换到指定轮播图
    goToBanner(index) {
      this.current = index;
      // 手动触发轮播图切换
      if (this.$refs.bannerSwipe) {
        this.$refs.bannerSwipe.swipeTo(index);
      }
    },
    changhongbashow() {
      this.hongbashow = false;
    },
    handleImageError(event) {
      // 图片加载失败时的处理
      event.target.style.display = 'none';
      console.warn('图片加载失败:', event.target.src);
    },
    // 获取卡片头部class
    getCardHeaderClass(index) {
      // 所有标签都使用黑色背景
      return 'official-rec';
    },
    // 获取卡片头部文本
    getCardHeaderText(index) {
      if (this.gameType === 0) {
        return '官方认证';
      }
      if (this.gameType === 3 && index === 0) {
        return '官方认证';
      }
      return '官方推荐';
    },
    // 获取卡片标题
    getCardTitle(item, index) {
      // 直接使用缓存中的游戏名称，优先使用 name 字段，如果没有则使用 platform_name
      // 不再使用默认名称，确保显示的数据与缓存数据一致
      return item.name || item.platform_name || '';
    },
    // 获取卡片数量
    getCardCount(index) {
      // 直接使用缓存中的实际数据，不使用硬编码值
      const count = this.currentGameList.length;
      return count;
    },
    // 获取卡片图片
    getCardImage(item) {
      // 优先使用接口返回的图片
      if (item.mobile_img) return item.mobile_img;
      if (item.api_logo_img) return item.api_logo_img;
      if (item.app_img) return item.app_img;
      
      // 后备方案：使用本地图片
      let platformName = item.platform_name;
      if (this.gameType === 5 && item.platform_name === 'ig') {
        platformName = item.game_code;
      }
      return `/static/image/${this.imagePathPrefix}/${platformName}.png`;
    },
    // 处理游戏点击
    handleGameClick(item, index) {
      this.$parent.openGamePage(item.platform_name, item.game_code, '');
    },
    goToH5() {
      const url = this.$store.state.appInfo.h5_url;
      if (url) {
        window.location.href = url;
      }
    },
  },
  mounted() {
    let that = this;
  },
  updated() {
    let that = this;
  },
  beforeDestroy() {},
};
</script>
<style lang="scss" scoped>
// 顶部Logo区域 - 不做卡片
.top-logo-area {
  background: #f5f5f5;
  padding: 2.5vw 5vw 1.5vw 5vw;

  .top-logo {
    display: flex;
    align-items: center;
    cursor: pointer;

    .logo {
      width: 8vw;
      height: 8vw;
      margin-right: 2vw;
      border-radius: 1.5vw;
    }

    .logo-text {
      display: flex;
      flex-direction: column;

      .logo-title {
        font-size: 4vw;
        font-weight: 700;
        color: #222;
        line-height: 1.2;
        letter-spacing: 0.2vw;
        font-family: "PingFang SC", "Microsoft YaHei", sans-serif;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
      }

      .logo-domain {
        font-size: 2.5vw;
        color: #999999;
        line-height: 1.2;
        margin-top: 0.3vw;
      }
    }
  }
}

// 轮播图底部圆点样式
.banner-pagination {
  position: absolute;
  bottom: 4vw;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 2vw;
  z-index: 10;

  .pagination-dot {
    width: 2vw;
    height: 2vw;
    border-radius: 50%;
    background: rgba(128, 128, 128, 0.6);
    cursor: pointer;
    transition: all 0.3s ease;

    &.active {
      background: #1890ff;
      width: 5vw;
      border-radius: 1vw;
    }
  }
}

// banner-image 样式已移入 .banner-card 内部

.footer-copyright {
  background: linear-gradient(to right, #002040, #004080);
  color: #ffffff;
  text-align: center;
  padding: 15px 0;
  font-size: 12px;
  margin-top: 20px;
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
  p {
    margin: 5px 0;
  }
}

.page-wrapper {
  padding-bottom: 16vw;
  width: 100%;
  min-height: 100vh;
  background: #f5f5f5;
}

// 通用卡片样式
.card-block {
  margin: 3.5vw 5vw;
  background: #ffffff;
  border-radius: 3vw;
  overflow: hidden;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
}

// Banner + 用户信息合并卡片
.banner-user-card {
  margin-top: 0.5vw;

  .banner-wrapper {
    position: relative;
    width: 100%;
    height: 52vw;
    overflow: hidden;

    .van-swipe {
      height: 100%;
    }

    .van-swipe-item {
      height: 100%;
    }

    .banner-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 0;
      box-shadow: none;
    }
  }

  // 公告栏
  .notice-bar-inline {
    display: flex;
    align-items: center;
    padding: 2vw 4vw;
    background: #fff;
    position: relative;

    &::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 4vw;
      right: 4vw;
      height: 1px;
      background: #f0f0f0;
    }

    .notice-icon-wrap {
      flex-shrink: 0;
      margin-right: 2vw;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .notice-content {
      flex: 1;
      overflow: hidden;

      ::v-deep .van-notice-bar {
        font-size: 3vw !important;
      }

      .notice-placeholder {
        font-size: 3vw;
        color: #999;
      }
    }
  }

  // 用户钱包区域
  .user-wallet-area {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 4vw 4vw;

    .user-info-left {
      flex: 1;
      cursor: pointer;
      display: flex;
      flex-direction: column;
      justify-content: center;
      min-height: 12vw;

      .user-name {
        font-size: 3.8vw;
        font-weight: 400;
        color: #999999;

        &.not-login {
          color: #333333;
          font-weight: 700;
        }
      }

      .user-balance {
        display: flex;
        align-items: center;
        margin-top: 1vw;

        .balance-amount {
          font-size: 5.8vw;
          font-weight: 700;
          color: #333333;
        }

        .toggle-eye-icon {
          width: 5vw;
          height: 5vw;
          margin-left: 2vw;
          cursor: pointer;

          &.eye-open {
            margin-top: 0;
          }

          &.eye-closed {
            margin-top: -1.5vw;
          }
        }
      }

      .user-tip {
        font-size: 3vw;
        color: #999999;
        margin-top: 2vw;
      }
    }

    .user-actions {
      display: flex;
      gap: 1vw;

      .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;

        .action-icon {
          width: 10vw;
          height: 10vw;
          border-radius: 50%;
          background: #e0e0e0;
          display: flex;
          align-items: center;
          justify-content: center;
          margin-bottom: 0.5vw;

          &.dark {
            background: #333;
          }

          &:has(.action-icon-img) {
            background: transparent;
          }

          .action-icon-img {
            width: 10vw;
            height: 10vw;
            object-fit: contain;
          }
        }

        span {
          font-size: 3.2vw;
          color: #333;
        }
      }
    }
  }
}

// 游戏导航卡片
.game-nav-card {
  margin: 3.5vw 5vw;
  padding: 1.5vw 2vw;
  background: #ffffff;

  .game-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;

    &::-webkit-scrollbar {
      display: none;
    }

    .nav-item {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5vw 2vw;
      background: transparent;
      border-radius: 3vw;
      font-size: 3.5vw !important;
      color: #666666;
      cursor: pointer;
      transition: all 0.3s ease;
      white-space: nowrap;
      font-weight: 600;

      .nav-icon {
        width: 4.5vw;
        height: 4.5vw;
        margin-right: 1vw;
        object-fit: contain;
      }

      span {
        font-size: 3.5vw !important;
      }

      &.active {
        background: #e8f0fe;
        color: #3b7ddd;
        font-weight: 500;

        span {
          font-size: 3.5vw !important;
          color: #3b7ddd;
        }
      }
    }
  }
}

.login-btn {
  background: linear-gradient(to right, #00a0e9, #0066cc) !important;
  color: #ffffff !important;
  border-radius: 20px !important;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3) !important;
  font-weight: bold !important;
  transition: all 0.3s ease !important;
  &:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4) !important;
  }
}

.logout-btn {
  background: linear-gradient(to right, #ff3366, #ff0033) !important;
  color: #ffffff !important;
  border-radius: 20px !important;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3) !important;
}

.menu-list {
  li {
    background: rgba(255, 255, 255, 0.1);
    margin-bottom: 10px;
    border-radius: 8px;
    transition: all 0.3s ease;
    &:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateX(5px);
    }
  }
}

.top-banner {
  background: linear-gradient(to right, #00a0e9, #0066cc);
  padding: 8px 0;
  text-align: center;
  color: #ffffff;
  font-weight: bold;
  font-size: 14px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  .banner-text {
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
  }
}
@import '../../../static/css/2d87bbdbffeb4734e5c7.css';
.domainModal_content__1nBgc {
  overflow: auto;
}
// 轮播样式
.swiper-dots {
  display: flex;
  position: absolute;
  left: 40px;
  bottom: 10px;
  width: 48px;
  height: 24px;
  background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAABkCAYAAADDhn8LAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTMyIDc5LjE1OTI4NCwgMjAxNi8wNC8xOS0xMzoxMzo0MCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6OTk4MzlBNjE0NjU1MTFFOUExNjRFQ0I3RTQ0NEExQjMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6OTk4MzlBNjA0NjU1MTFFOUExNjRFQ0I3RTQ0NEExQjMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6Q0E3RUNERkE0NjExMTFFOTg5NzI4MTM2Rjg0OUQwOEUiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6Q0E3RUNERkI0NjExMTFFOTg5NzI4MTM2Rjg0OUQwOEUiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4Gh5BPAAACTUlEQVR42uzcQW7jQAwFUdN306l1uWwNww5kqdsmm6/2MwtVCp8CosQtP9vg/2+/gY+DRAMBgqnjIp2PaCxCLLldpPARRIiFj1yBbMV+cHZh9PURRLQNhY8kgWyL/WDtwujjI8hoE8rKLqb5CDJaRMJHokC6yKgSCR9JAukmokIknCQJpLOIrJFwMsBJELFcKHwM9BFkLBMKFxNcBCHlQ+FhoocgpVwwnv0Xn30QBJGMC0QcaBVJiAMiec/dcwKuL4j1QMsVCXFAJE4s4NQA3K/8Y6DzO4g40P7UcmIBJxbEesCKWBDg8wWxHrAiFgT4fEGsB/CwIhYE+AeBAAdPLOcV8HRmWRDAiQVcO7GcV8CLM8uCAE4sQCDAlHcQ7x+ABQEEAggEEAggEEAggEAAgQACASAQQCCAQACBAAIBBAIIBBAIIBBAIABe4e9iAe/xd7EAJxYgEGDeO4j3EODp/cOCAE4sYMyJ5cwCHs4rCwI4sYBxJ5YzC84rCwKcXxArAuthQYDzC2JF0H49LAhwYUGsCFqvx5EF2T07dMaJBetx4cRyaqFtHJ8EIhK0i8OJBQxcECuCVutxJhCRoE0cZwMRyRcFefa/ffZBVPogePihhyCnbBhcfMFFEFM+DD4m+ghSlgmDkwlOgpAl4+BkkJMgZdk4+EgaSCcpVX7bmY9kgXQQU+1TgE0c+QJZUUz1b2T4SBbIKmJW+3iMj2SBVBWz+leVfCQLpIqYbp8b85EskIxyfIOfK5Sf+wiCRJEsllQ+oqEkQfBxmD8BBgA5hVjXyrBNUQAAAABJRU5ErkJggg==);
  background-size: 100% 100%;
}
.swiper-dots .num {
  width: 24px;
  height: 24px;
  border-radius: 50px;
  font-size: 16px;
  color: #fff;
  text-align: center;
  line-height: 24px;
}
.swiper-dots .sign {
  position: absolute;
  top: 0;
  left: 50%;
  line-height: 24px;
  font-size: 8px;
  color: #fff;
  -webkit-transform: translateX(-50%);
  transform: translateX(-50%);
}
// 主页头部标题

.homeHeder {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 60px;
  display: flex;
  box-sizing: border-box;
  padding: 0 15px;
  z-index: 999;
  align-items: center;
  justify-content: space-between;
  background-color: rgba(0, 0, 0, 0.5);
  .leftImg {
    width: 24px;
    height: 24px;
    padding: 5px;
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
  }
  .site-logo {
    font-size: 1.2rem;
    font-weight: bold;
    color: #ffffff;
    text-shadow: 0 0 5px #00a0e9;
    font-family: Arial, sans-serif;
  }
  .rbox {
    display: flex;
    height: 100%;
    align-items: center;
    font-size: 0.24rem;
    font-family: PingFangSC-Regular, sans-serif;
    color: #fff;
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    padding: 5px 12px;
    img {
      width: 24px;
      height: 24px;
      margin-right: 5px;
    }
  }
}
.leftbox {
  width: 7.5rem;
  height: 100%;
  background: linear-gradient(to right, #002040, #004080);
  color: #ffffff;
  .side__main__1NhyG {
    box-sizing: border-box;
    padding: 0 20px;
    h3 {
      font-size: 20px;
      font-weight: 400;
      margin: 0;
      padding-top: 72px;
    }
    .side__vip__1dW8w {
      background: url(/static/style/sidebr_vip_card.1ce7485811699286f87aae1827de7acf.png) no-repeat;
      background-size: 100% 100%;
      box-sizing: border-box;
      padding: 20px;
      color: #fff;
      position: relative;
      p {
        color: hsla(0, 0%, 100%, 0.6);
        font-size: 12px;
        margin: 5px 0 0 0;
      }
      .topxs {
        font-size: 16px;
      }
      dd {
        float: right;
        border: 0.02rem solid #fff;
        border-radius: 0.24rem;
        height: 0.48rem;
        line-height: 0.48rem;
        width: 1.88rem;
        text-align: center;
        font-size: 10px;
        position: absolute;
        top: 20px;
        right: 20px;
      }
    }
  }
  ul {
    list-style: none;
    margin-top: 0.36rem;
    li {
      display: block;
      line-height: 0.96rem;
      height: 0.96rem;
      border-bottom: 0.02rem solid #e6ebf6;
      color: #4e6693;
      font-size: 0.28rem;
      padding: 0 0.14rem;
      img {
        width: 0.36rem;
        vertical-align: middle;
        margin: -0.04rem 0.24rem 0 0;
      }
      span {
        float: right;
      }
    }
  }
  .nisd {
    position: absolute;
    width: 4.72rem;
    height: 0.8rem;
    line-height: 0.8rem;
    left: 0.9rem;
    bottom: 1rem;
    background: #dfe5ff;
    border-radius: 0.4rem;
    border: 0;
    color: #4e6693;
    font-size: 0.28rem;
    display: flex;
    justify-content: center;
    align-items: center;
    img {
      vertical-align: middle;
      margin: -0.04rem 0.08rem 0 -0.08rem;
      width: 0.32rem;
    }
  }
}
/* 公告栏样式 */
.notice-bar-wrapper {
  padding: 10px 15px;
  background: #f5f5f5;
}

.notice-bar {
  display: flex;
  align-items: center;
  background: #ffffff;
  border-radius: 8px;
  padding: 10px 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.notice-icon {
  width: 20px;
  height: 20px;
  margin-right: 10px;
  flex-shrink: 0;
}

.notice-content-wrapper {
  flex: 1;
  overflow: hidden;
}

/* 用户信息卡片样式 */
.user-info-card {
  padding: 0;
  
  // 用户信息卡片内的公告栏
  .user-notice-bar {
    display: flex;
    align-items: center;
    background: #ffffff;
    padding: 0 15px;
    
    .notice-icon {
      width: 16px;
      height: 16px;
      flex-shrink: 0;
      margin-right: 8px;
    }
    
    .user-notice-content {
      flex: 1;
      overflow: hidden;
    }
  }
  
  // 分隔线
  .user-info-divider {
    height: 1px;
    background: #e8e8e8;
    margin: 0 15px;
  }
}

.user-info-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #ffffff;
  padding: 15px;
}

.user-info-left {
  flex: 1;
  cursor: pointer;
  
  .user-name {
    font-size: 16px;
    font-weight: 600;
    color: #333333;
    margin-bottom: 5px;
  }
  
  .user-balance {
    font-size: 20px;
    font-weight: 700;
    color: #333333;
    
    span {
      font-size: 14px;
      font-weight: 400;
    }
  }
  
  .user-tip {
    font-size: 12px;
    color: #999999;
    margin-top: 5px;
  }
}


/* 游戏列表横向滚动 */
.game-list-scroll {
  overflow-x: auto;
  overflow-y: hidden;
  -webkit-overflow-scrolling: touch;
  padding: 0 5vw 2.5vw;
  margin-top: 1.5vw;

  &::-webkit-scrollbar {
    display: none;
  }
}

.game-list-container {
  display: flex;
  flex-direction: row;
  gap: 3vw;
}

.game-list-item {
  flex-shrink: 0;
  // 自适应宽度：(屏幕宽度 - 左右边距10vw - 卡片间距3vw) / 2
  width: calc((100vw - 10vw - 3vw) / 2);
  height: 55vw;
  margin: 0;
  cursor: pointer;
  transition: transform 0.3s ease;
  display: flex;
  flex-direction: column;
  position: relative;

  &:active {
    transform: scale(0.98);
  }

  .game-card-tag {
    position: absolute;
    top: 0;
    left: 0;
    background: #333333;
    color: #ffffff;
    padding: 1vw 2.5vw;
    font-size: 2.5vw;
    font-weight: 500;
    border-radius: 3vw 0 2vw 0;
    z-index: 1;

    &.official-rec {
      background: #333333;
    }

    &.official-cert {
      background: #e74c3c;
    }
  }

  .game-card-body {
    padding: 3vw;
    padding-top: 7vw;
    flex: 0 0 auto;

    .game-card-title {
      font-size: 4vw;
      font-weight: 700;
      color: #333333;
      margin-bottom: 1.5vw;
      text-align: center;
    }

    .game-card-desc {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1vw;

      .backwater-wrapper {
        position: relative;
        display: inline-block;

        .backwater-img {
          height: 4vw;
          width: auto;
          object-fit: contain;
          display: block;
        }

        .rebate-tag {
          position: absolute;
          left: 0.8vw;
          top: 50%;
          transform: translateY(-50%);
          display: flex;
          align-items: baseline;

          .rebate-label {
            font-size: 1.8vw;
            color: #333;
            font-weight: 700;
            margin-right: 0.3vw;
          }

          .rebate-value {
            font-size: 2.8vw;
            font-weight: 700;
            color: #3b7ddd;

            em {
              font-style: normal;
              font-size: 2.2vw;
            }
          }
        }
      }
    }

    .game-card-count {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 2vw;

      .count-line {
        flex: 1;
        height: 0;
        border-top: 1px dashed #ccc;
      }

      .count-num {
        font-size: 4vw;
        color: #333;
        font-weight: 700;
        white-space: nowrap;

        em {
          font-style: normal;
          font-size: 2.5vw;
          color: #999;
          font-weight: 400;
          margin-left: 0.5vw;
        }
      }
    }
  }

  .game-card-image {
    flex: 1;
    overflow: hidden;
    background: #f8f8f8;
    display: flex;
    align-items: center;
    justify-content: center;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
  }
}

.empty-game-list {
  padding: 8vw 4vw;
  text-align: center;
  color: #999999;
  font-size: 3.5vw;
  width: 100%;
}

</style>
