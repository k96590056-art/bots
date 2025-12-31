<template>
  <div v-if="bannerList.length > 0" class="page-wrapper">
    <div id="redPacket" v-if="$store.state.appInfo.redpacket_switch == 1 && hongbashow">
      <i @click="$parent.goNav('/hongbao')" class="grab"></i>
      <img @click="changhongbashow" src="/static/image/hongbaocolse.png" />
    </div>

    <!-- Logo展示 -->
    <div class="top-logo-wrapper">
      <div class="top-logo" @click="goToH5">
        <img :src="$store.state.appInfo.site_logo" alt="" class="logo" />
        <div class="logo-text">
          <div class="logo-title">{{ $store.state.appInfo.site_name }}</div>
          <div class="logo-domain">{{ ($store.state.appInfo.h5_url || '').replace(/^https?:\/\//, '') }}</div>
        </div>
      </div>
    </div>

    <div style="position: relative">
      <van-swipe ref="bannerSwipe" :autoplay="false" :initial-swipe="current" @change="onChange">
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
    <!-- 用户信息栏 -->
    <div class="user-info-card">
      <!-- 公告信息 -->
      <div class="user-notice-bar" v-if="homenoticelis && homenoticelis.length > 0">
        <svg class="notice-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z" fill="#1890ff"/>
        </svg>
        <div class="user-notice-content">
          <van-notice-bar color="#333333" background="transparent" scrollable>
            <span v-for="(item, index) in homenoticelis" @click="openGogao(item)" :key="index">{{ item }}</span>
          </van-notice-bar>
        </div>
      </div>
      
      <!-- 分隔线 -->
      <div class="user-info-divider" v-if="homenoticelis && homenoticelis.length > 0"></div>
      
      <div class="user-info-content">
        <div class="user-info-left" v-if="$store.state.token">
          <div class="user-name">{{ $store.state.userInfo.username }}</div>
          <div class="user-balance"><span>￥</span>{{ $store.state.userInfo.balance }}</div>
        </div>
        <div v-else class="user-info-left" @click="$parent.goNav('/login')">
          <div class="user-name">您还未登录</div>
          <div class="user-tip">登录/注册后查看</div>
        </div>
        <div class="user-actions">
          <div class="action-btn" @click="$parent.goNav('/recharge')">
            <div class="action-icon">💰</div>
            <div class="action-text">存款</div>
          </div>
          <div class="action-btn" @click="$parent.goNav('/transfer')">
            <div class="action-icon">↔️</div>
            <div class="action-text">转账</div>
          </div>
          <div class="action-btn" @click="$parent.goNav('/withdrawal')">
            <div class="action-icon">💵</div>
            <div class="action-text">取款</div>
          </div>
          <div class="action-btn" @click="$parent.goNav('/vip')">
            <div class="action-icon">📢</div>
            <div class="action-text">推广</div>
          </div>
        </div>
      </div>
    </div>
    <!-- 游戏栏 -->
    <div class="game-section">
      <!-- 导航栏 -->
      <div class="game-nav">
        <div :class="['nav-item', gameType == 3 ? 'active' : '']" @click="changGameType(3)">
          <span>棋牌</span>
        </div>
        <div :class="['nav-item', gameType == 4 ? 'active' : '']" @click="changGameType(4)">
          <span>电子</span>
        </div>
        <div :class="['nav-item', gameType == 5 ? 'active' : '']" @click="changGameType(5)">
          <span>彩票</span>
        </div>
        <div :class="['nav-item', gameType == 0 ? 'active' : '']" @click="changGameType(0)">
          <span>真人</span>
        </div>
        <div :class="['nav-item', gameType == 1 ? 'active' : '']" @click="changGameType(1)">
          <span>体育</span>
        </div>
        <div :class="['nav-item', gameType == 2 ? 'active' : '']" @click="changGameType(2)">
          <span>电竞</span>
        </div>
      </div>
      <!-- 游戏列表 - 横向滚动 -->
      <div class="game-list-scroll">
        <div class="game-list-container">
          <!-- 电子游戏特殊处理：第一个是DB棋牌 -->
          <div v-if="gameType == 4" class="game-list-item" @click="$parent.goNav('/concise?type=obgdy')">
            <div class="game-card-header official-rec">官方推荐</div>
            <div class="game-card-body">
              <div class="game-card-title">DB棋牌</div>
              <div class="game-card-desc">
                <span>高达1.20% 无限返水</span>
                <span class="game-tag">无限返水</span>
              </div>
              <div class="game-card-count">21种</div>
            </div>
            <div class="game-card-image">
              <img src="/static/image/concise/obgdy.png" alt="" />
            </div>
          </div>
          
          <!-- 通用游戏列表 -->
          <template v-if="currentGameList && currentGameList.length > 0">
            <div 
              class="game-list-item" 
              v-for="(item, index) in currentGameList" 
              :key="`${gameType}-${index}`" 
              @click="handleGameClick(item, index)"
            >
              <div class="game-card-header" :class="getCardHeaderClass(index)">
                {{ getCardHeaderText(index) }}
              </div>
              <div class="game-card-body">
                <div class="game-card-title">{{ getCardTitle(item, index) }}</div>
                <div class="game-card-desc">
                  <span>高达1.20% 无限返水</span>
                  <span class="game-tag">无限返水</span>
                </div>
                <div class="game-card-count">{{ getCardCount(index) }}</div>
              </div>
              <div class="game-card-image">
                <img :src="getCardImage(item)" alt="" @error="handleImageError" />
              </div>
            </div>
          </template>
          <div v-else-if="gameType !== 4" class="empty-game-list">暂无游戏数据</div>
        </div>
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
        if (res.code != 200) {
          that.showTost(0, res.message);
        }
        if (res.code == 200) {
          that.homenoticelis = res.data;
          that.ok = true;
        }
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
      if (this.gameType === 3 && index === 0) {
        return 'official-cert';
      }
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
      return `${count}种`;
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
// 顶部Logo样式
.top-logo-wrapper {
  padding: 10px 15px;
  background: #ffffff;
  
  .top-logo {
    display: flex;
    align-items: center;
    cursor: pointer;
    
    .logo {
      width: 40px;
      height: 40px;
      margin-right: 10px;
    }
    
    .logo-text {
      display: flex;
      flex-direction: column;
      
      .logo-title {
        font-size: 16px;
        font-weight: 600;
        color: #333333;
        line-height: 1.2;
      }
      
      .logo-domain {
        font-size: 12px;
        color: #999999;
        line-height: 1.2;
        margin-top: 2px;
      }
    }
  }
}

// 轮播图底部圆点样式
.banner-pagination {
  position: absolute;
  bottom: 15px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 8px;
  z-index: 10;
  
  .pagination-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(128, 128, 128, 0.6);
    cursor: pointer;
    transition: all 0.3s ease;
    
    &.active {
      background: #1890ff;
      width: 20px;
      border-radius: 4px;
    }
  }
}

.banner-image {
  border-radius: 0;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

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
  padding-bottom: 20px;
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
  margin: 15px;
  padding: 0;
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  
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

.user-actions {
  display: flex;
  gap: 8px;
  
  .action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background: #f5f5f5;
    border-radius: 50%;
    cursor: pointer;
    
    .action-icon {
      font-size: 20px;
      margin-bottom: 4px;
    }
    
    .action-text {
      font-size: 10px;
      color: #666666;
    }
  }
}

/* 游戏区域样式 */
.game-section {
  background: #ffffff;
  padding: 15px 0;
}

/* 导航栏样式 */
.game-nav {
  display: flex;
  gap: 10px;
  padding: 0 15px 15px;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  
  &::-webkit-scrollbar {
    display: none;
  }
  
  .nav-item {
    flex-shrink: 0;
    padding: 8px 20px;
    background: #f5f5f5;
    border-radius: 20px;
    font-size: 14px;
    color: #666666;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    
    &.active {
      background: #1890ff;
      color: #ffffff;
    }
  }
}

/* 游戏列表横向滚动 */
.game-list-scroll {
  overflow-x: auto;
  overflow-y: hidden;
  -webkit-overflow-scrolling: touch;
  padding: 0 15px;
  height: 280px; /* 固定高度 */
  
  &::-webkit-scrollbar {
    display: none;
  }
}

.game-list-container {
  display: flex;
  flex-direction: row; /* 横向排列 */
  gap: 15px;
  height: 100%; /* 占满父容器高度 */
  align-items: stretch; /* 确保所有卡片高度一致 */
}

.game-list-item {
  flex-shrink: 0;
  width: 280px;
  height: 100%; /* 占满容器高度 */
  background: #ffffff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column; /* 卡片内部垂直排列 */
  
  &:active {
    transform: scale(0.98);
  }
  
  .game-card-header {
    background: #333333;
    color: #ffffff;
    padding: 8px 15px;
    font-size: 12px;
    font-weight: 600;
  }
  
  .game-card-body {
    padding: 15px;
    flex: 0 0 auto; /* 不伸缩，根据内容自适应 */
    
    .game-card-title {
      font-size: 18px;
      font-weight: 700;
      color: #333333;
      margin-bottom: 8px;
    }
    
    .game-card-desc {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 8px;
      
      span:first-child {
        font-size: 12px;
        color: #666666;
      }
      
      .game-tag {
        background: #1890ff;
        color: #ffffff;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 10px;
      }
    }
    
    .game-card-count {
      font-size: 12px;
      color: #999999;
    }
  }
  
  .game-card-image {
    flex: 1; /* 占据剩余空间 */
    min-height: 120px;
    overflow: hidden;
    background: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
    
    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block; /* 确保图片正确显示 */
    }
  }
}

.empty-game-list {
  padding: 40px 20px;
  text-align: center;
  color: #999999;
  font-size: 14px;
}

</style>
