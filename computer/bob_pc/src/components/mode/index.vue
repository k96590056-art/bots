<template>
  <div class="_24vddGqv">
    <!-- 网站弹窗 -->
    <div data-v-d47f0a72="" class="_1euN-aP1" v-if="tanshow && $store.state.appInfo.index_modal == 1">
      <div data-v-d47f0a72="" class="_2v39xVwk animated animated-3 fadeIn"></div>
      <div data-v-d47f0a72="" class="_3Pc_iCss animated animated-3 zoomIn" style="width: 700px">
        <div data-v-d47f0a72="" class="_3DZ99c6r">
          <span data-v-d47f0a72=""></span>
          <div data-v-d47f0a72="" class="_3x7x8GsG">欢迎来到{{ $store.state.appInfo.title }}</div>
          <img
            @click="changtanshow"
            data-v-d47f0a72=""
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAC0UExURUxpcf/////Uqv+2tv//qv///+u3o/////W8qv/Gxv/9/emwoOWunO+zouiyovC0peexneeyn+qxouWvnOWvneWwnOWunOWvnee5ouWxneaxoeSunOSunOWxpOSvneSvnPC4m+SvneWwn+SwnfXf1+avnPTe1fvw7eSunOewnuSum+mynuSunPXg2vLVzeSum//9/eSunOSunPPa0uStnfbm3/HWzfjr5vnh1vzz8f359////2ASjEAAAAA7dFJOUwD9BgcDAg0BCQT9G0cPFREkHxg6Pi5RYAsoNkxaE1VkEkIdMJAzlWpoK4AidYm6jPSWbZ9xf651HmONntaUtAAABAdJREFUeNrtlsly4kgQhgdJCMlaKe37ZmFAYDDgrXn/95qsqqRlRxSaufSlw3khQsn/qZSV2z8/9mN/ny3QJn0TNp/PFTD4wT9+UY+++6+fK7ougem6rgDim1xBH7iUxR29okuypsVxrGmyRBFf9Lp+c2ngEhPmuqTFquXUzoetavJIWABaRpdlf1CXUK/ommoVNjF+XY+flqoxAupBXoPHIJ/H6y84w1wUAF2OrYK0Q3q9XmeftapJQEC96thGO7ju0wycH5oODgFAUwuydDfpkRKeCk5YsJPVpHWTIHin+iMBhwCgSJplt27Qe6+zLwTUD0mXouPTiWUxIHbIsOm9xtyPBLg70BvsOYKNQpV1MaA23MBrsjBEgm1pYGoB+tRH7HvS3gc4FGCGZZ4/IsFRVQv0Qdpk+wf66LVnAEUcRIsMFJDn0Y1AbBvCR/WPTL/3O9eoVekOQLWXG/hvHkVVhIRhCeHzUP+wN71gIJbwFiARZfhat/PNMq+qG+E96ODzQ65/zJo0aW1VmAcQBPoN7AhlVK2raMUIr36T3fQhOwC9RSGAHqE2eBSAsK5W/LPDcsX0q9CkEYDLFVYTpix8BCeswVCIP6Xp9/ABFqa46AhI6CihWp8ulzOToj4D/ZLqMQJCgnQjlNH6sttt32gcvutlpp8i2G3S+1leXXbbw4ETHs552KSbJZnWI8Gi2WCG0QX0L88zPADPgBj1kwSoKciGMDptUc+uEDIALkCgFyYk3GWWA4DpZzwfepen4P8CLDngjUmfOeYdAGMGTAeBDJ2fRSfUvxzeHhjBqAUhECZTm6RNGJ1R/3LYnhnhSZRE4mSEA0D+4vsP2+3uRsBOO6nHcuD6ty213YVl9dhp/0ufNlh/5x2zy+lUrWZTBAwg77+0oFFfVdBboDBP6/Wtw/BiBIJ4sjhf9au8DMFKXtwjAfuJqKFgHaC+DM3G9xszo4iRgB1N1NJ4Xzf3qM8aL+263vNpfxi73CceQZyCkAHlEfV+GiSu6256JET5HkcbACbaeoT9z+83g0GIsYS2TAlRlPOJ8xFLyuRgeb4emT5ZksKyahiYQIBA5HlovsJ4x8EyMdqiMuN6R4W1xLIhNdnEC+Fxmk6NNsKGIFjjdbR/QfHoMu+0/LnvBe794UrHAp3ivu+lgduy/ge7Fe+Tmx6e+ynEhdT3ZiObw0nQ9V2QDAb2T94n0dEHGwYWz0a+yCzdJHGHlhSox05Ldx/01CyZxUsaEIjRtgaBuY79H9C4fhHDoB7QA1lUTAqNl+UURVFbaoz63wRw1dxFI7O4t2jCralg2rgmIuGba2JVhV2VmqSjflxV0QeuqcY6ZysxW6m/l/yCIm6+xfS6jyZyoefH/oD9C6i3ptIfvSpmAAAAAElFTkSuQmCC"
            alt=""
            class="_8iC2lrZe"
          />
        </div>
        <div data-v-d47f0a72="" class="n8VMb-cz" style="text-align:left" v-html="$store.state.appInfo.webcontent">
        </div>
      </div>
    </div>
    
    <div class="_1PthxidG" style="position: relative;">
      <!-- 轮播图区域 -->
      <div class="_2gKtEzzo" style="height: 580px; position: relative; overflow: visible; width: 100%">
        <!-- 轮播图 - 只在首页显示 -->
        <div class="ant-carousel" v-show="showCarousel">
          <div class="slick-slider swiper-container">
            <div class="swiper-wrapper">
              <div class="swiper-slide" v-for="(item, index) in bannerList" :key="index">
                <div>
                  <div class="_22T49mH0"><img class="boKYdSn5" :src="item.src" /></div>
                </div>
              </div>
            </div>
          </div>
          <!-- 左右切换箭头 -->
          <div class="swiper-nav-btn swiper-nav-prev" @click="prevSlide">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div class="swiper-nav-btn swiper-nav-next" @click="nextSlide">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <!-- 底部圆点指示器 -->
          <div class="swiper-pagination-dots">
            <span 
              v-for="(item, index) in bannerList" 
              :key="index"
              class="swiper-pagination-dot"
              :class="{ 'swiper-pagination-dot-active': currentSlideIndex === index }"
              @click="goToSlide(index)"
            ></span>
          </div>
        </div>
        
        <!-- 分类 Banner - 点击分类时显示 -->
        <div class="category-banner" v-show="!showCarousel && categoryBanner" style="height: 580px; width: 100%; position: relative;">
          <img :src="categoryBanner" alt="" style="width: 100%; height: 100%; object-fit: cover;" />
        </div>
        
        <!-- 公告滚动 - 浮动在轮播图上 -->
        <section class="notice-section">
        <div class="notice-container">
          <div class="notice-card">
            <div class="notice-icon">
              <div class="speaker-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="#1890ff" xmlns="http://www.w3.org/2000/svg">
                  <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                </svg>
              </div>
            </div>
            <div class="notice-content-wrapper">
              <div class="notice-content-scroll" ref="noticeScroll">
                <div class="notice-content-inner">
                  <span 
                    class="notice-text" 
                    v-for="(item, index) in homenoticelis" 
                    :key="index"
                    @click="changGshow"
                  >{{ item }}</span>
                </div>
              </div>
            </div>
            <div class="notice-view-btn" @click="changGshow">
              <span>查看</span>
            </div>
          </div>
        </div>
      </section>
      </div>
      
      <!-- 主要内容区域 -->
      <div class="home-main-content">
        <!-- 游戏分类入口 -->
        <div 
          class="game-categories" 
          ref="gameCategories"
          @mousedown="onDragStart"
          @mousemove="onDragMove"
          @mouseup="onDragEnd"
          @mouseleave="onDragEnd"
          @touchstart="onDragStart"
          @touchmove="onDragMove"
          @touchend="onDragEnd"
        >
          <div class="category-item" v-for="(item, index) in gameCategories" :key="index" @click="handleCategoryClick(item.path, $event)">
            <div class="category-icon">
              <img :src="item.icon" :alt="item.name" />
            </div>
            <div class="category-name">{{ item.name }}</div>
            <div class="category-desc">{{ item.desc }}</div>
          </div>
        </div>
        
        <!-- 优势展示 -->
        <div class="advantages-section">
          <div class="section-title">
            <h1>平台优势</h1>
            <h2>PLATFORM ADVANTAGES</h2>
          </div>
          <div class="advantages-list">
            <div class="advantage-item" v-for="(item, index) in advantages" :key="index">
              <div class="advantage-icon">
                <img :src="item.icon" :alt="item.title" />
              </div>
              <div class="advantage-content">
                <h3>{{ item.title }}</h3>
                <p>{{ item.desc }}</p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- 热门游戏 -->
        <div class="hot-games-section">
          <div class="section-title">
            <h1>热门游戏</h1>
            <h2>HOT GAMES</h2>
          </div>
          <div class="games-grid">
            <div class="game-card" v-for="(item, index) in hotGames" :key="index" @click="goGamePage(item.name, item.type, item.code)">
              <div class="game-image">
                <img :src="item.image" :alt="item.name" />
              </div>
              <div class="game-name">{{ item.name }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- 公告展示弹窗 -->
    <div class="office-modal-container" v-if="gaoShow">
      <div class="_1euN-aP1">
        <div class="_2v39xVwk animated animated-3 fadeIn"></div>
        <div class="_3Pc_iCss animated animated-3 zoomIn" style="width: 717px">
          <div class="_3DZ99c6r">
            <span></span>
            <div class="_3x7x8GsG">最新公告</div>
            <img
              @click="changGshow"
              class="_8iC2lrZe"
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAC0UExURUxpcf/////Uqv+2tv//qv///+u3o/////W8qv/Gxv/9/emwoOWunO+zouiyovC0peexneeyn+qxouWvnOWvneWwnOWunOWvnee5ouWxneaxoeSunOSunOWxpOSvneSvnPC4m+SvneWwn+SwnfXf1+avnPTe1fvw7eSunOewnuSum+mynuSunPXg2vLVzeSum//9/eSunOSunPPa0uStnfbm3/HWzfjr5vnh1vzz8f359////2ASjEAAAAA7dFJOUwD9BgcDAg0BCQT9G0cPFREkHxg6Pi5RYAsoNkxaE1VkEkIdMJAzlWpoK4AidYm6jPSWbZ9xf651HmONntaUtAAABAdJREFUeNrtlsly4kgQhgdJCMlaKe37ZmFAYDDgrXn/95qsqqRlRxSaufSlw3khQsn/qZSV2z8/9mN/ny3QJn0TNp/PFTD4wT9+UY+++6+fK7ougem6rgDim1xBH7iUxR29okuypsVxrGmyRBFf9Lp+c2ngEhPmuqTFquXUzoetavJIWABaRpdlf1CXUK/ommoVNjF+XY+flqoxAupBXoPHIJ/H6y84w1wUAF2OrYK0Q3q9XmeftapJQEC96thGO7ju0wycH5oODgFAUwuydDfpkRKeCk5YsJPVpHWTIHin+iMBhwCgSJplt27Qe6+zLwTUD0mXouPTiWUxIHbIsOm9xtyPBLg70BvsOYKNQpV1MaA23MBrsjBEgm1pYGoB+tRH7HvS3gc4FGCGZZ4/IsFRVQv0Qdpk+wf66LVnAEUcRIsMFJDn0Y1AbBvCR/WPTL/3O9eoVekOQLWXG/hvHkVVhIRhCeHzUP+wN71gIJbwFiARZfhat/PNMq+qG+E96ODzQ65/zJo0aW1VmAcQBPoN7AhlVK2raMUIr36T3fQhOwC9RSGAHqE2eBSAsK5W/LPDcsX0q9CkEYDLFVYTpix8BCeswVCIP6Xp9/ABFqa46AhI6CihWp8ulzOToj4D/ZLqMQJCgnQjlNH6sttt32gcvutlpp8i2G3S+1leXXbbw4ETHs552KSbJZnWI8Gi2WCG0QX0L88zPADPgBj1kwSoKciGMDptUc+uEDIALkCgFyYk3GWWA4DpZzwfepen4P8CLDngjUmfOeYdAGMGTAeBDJ2fRSfUvxzeHhjBqAUhECZTm6RNGJ1R/3LYnhnhSZRE4mSEA0D+4vsP2+3uRsBOO6nHcuD6ty213YVl9dhp/0ufNlh/5x2zy+lUrWZTBAwg77+0oFFfVdBboDBP6/Wtw/BiBIJ4sjhf9au8DMFKXtwjAfuJqKFgHaC+DM3G9xszo4iRgB1N1NJ4Xzf3qM8aL+263vNpfxi73CceQZyCkAHlEfV+GiSu6256JET5HkcbACbaeoT9z+83g0GIsYS2TAlRlPOJ8xFLyuRgeb4emT5ZksKyahiYQIBA5HlovsJ4x8EyMdqiMuN6R4W1xLIhNdnEC+Fxmk6NNsKGIFjjdbR/QfHoMu+0/LnvBe794UrHAp3ivu+lgduy/ge7Fe+Tmx6e+ynEhdT3ZiObw0nQ9V2QDAb2T94n0dEHGwYWz0a+yCzdJHGHlhSox05Ldx/01CyZxUsaEIjRtgaBuY79H9C4fhHDoB7QA1lUTAqNl+UURVFbaoz63wRw1dxFI7O4t2jCralg2rgmIuGba2JVhV2VmqSjflxV0QeuqcY6ZysxW6m/l/yCIm6+xfS6jyZyoefH/oD9C6i3ptIfvSpmAAAAAElFTkSuQmCC"
              alt=""
            />
          </div>
          <ul class="_1Gbns6cE">
            <li v-for="(item, index) in homenoticelis" :key="index">
              <p>{{ item }}</p>
            </li>
          </ul>
          <div class="Qe8HWKXx">
            <div class="_349CzCYy xJQe3jRu _2ihhyR4S" @click="changGshow">
              <span><div>我已了解</div></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'home',
  data() {
    return {
      bannerList: [],
      homenoticelis: [],
      gaoShow: false,
      scrolling: null,
      jumpUrl: null,
      tanshow: true,
      gameCategories: [],
      advantages: [
        {
          title: '安全可靠',
          desc: '独立开发，128位加密技术和严格的安全管理体系，让客户资金得到最完善的保障。',
          icon: '/static/image/advantage1.png'
        },
        {
          title: '极速出款',
          desc: '最新技术自主研发的财务处理系统，极速存、取、转。独家网络优化技术，为您提供一流的游戏体验。',
          icon: '/static/image/advantage2.png'
        },
        {
          title: '多端互通',
          desc: '支持各种终端设备，完美兼容PC、移动端。原生态App让您随时随地轻松投注。',
          icon: '/static/image/advantage3.png'
        },
        {
          title: '赛事全面',
          desc: '每天提供超过500场不同类别的精彩赛事，涵盖世界范围内主要体育运动，让客户拥有最完美的游戏体验。',
          icon: '/static/image/advantage4.png'
        }
      ],
      hotGames: [],
      currentSlideIndex: 0,
      swiperInstance: null,
      bannerLoading: false, // 防止重复请求的标志
      showCarousel: true, // 是否显示轮播图（首页显示，其他页面隐藏）
      categoryBanner: '', // 分类 banner 图片
      selectedChildId: null, // 当前选中的 child_id，用于过滤 games
      selectedChangguan: null, // 当前选中的 changguan，用于过滤 games
      pcCategoriesData: [], // PC端游戏分类数据（包含 games）
      // 拖动相关
      isDragging: false,
      startX: 0,
      scrollLeft: 0,
      dragThreshold: 5 // 拖动阈值，超过5px才认为是拖动
    };
  },
  created() {
    let that = this;
    console.log('index.vue created 钩子执行');
    console.log('$apiFun 是否存在:', typeof that.$apiFun !== 'undefined');
    that.getInit();
  },
  methods: {
    changtanshow() {
      this.tanshow = !this.tanshow;
    },
    changGshow() {
      this.gaoShow = !this.gaoShow;
    },
    goGamePage(name, type, code) {
      let that = this;
      let token = sessionStorage.getItem('token') ? sessionStorage.getItem('token') : '';
      if (!token) {
        that.$parent.openShow();
        return;
      }
      that.showTost('跳转前往中...');
      type = type || 0;
      that.$apiFun.post('/api/getGameUrl', { plat_name: name, game_type: type, game_code: code, is_mobile_url: 0 }).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.jumpUrl = res.data.url;
        }
      });
    },
    getInit() {
      let that = this;
      console.log('getInit 方法被调用');
      that.fetchGameCategories();
      that.getBanList();
      that.homenotice();
      that.getHotGames();
    },
    fetchGameCategories() {
      let that = this;
      if (!that.$apiFun) {
        return;
      }
      const routeMap = {
        sport: { path: '/sports', desc: 'SPORTS', fallbackIcon: '/static/image/sports.png' },
        realbet: { path: '/people', desc: 'LIVE CASINO', fallbackIcon: '/static/image/people.png' },
        concise: { path: '/electronic', desc: 'SLOTS', fallbackIcon: '/static/image/electronic.png' },
        lottery: { path: '/lottery', desc: 'LOTTERY', fallbackIcon: '/static/image/lottery.png' },
        joker: { path: '/cards', desc: 'CARDS', fallbackIcon: '/static/image/cards.png' },
        gaming: { path: '/electronic', desc: 'ESPORTS', fallbackIcon: '/static/image/electronic.png' },
        fishing: { path: '/electronic', desc: 'FISHING', fallbackIcon: '/static/image/electronic.png' }
      };
      that.$apiFun.get('/api/game/categories', {}).then(res => {
        if (res && res.code === 200 && Array.isArray(res.data)) {
          const list = res.data;
          const mapped = list
            .map(el => {
              const code = el.code || '';
              const map = routeMap[code];
              if (!map) return null;
              return {
                name: el.name || code,
                path: map.path,
                icon: el.image || map.fallbackIcon,
                desc: map.desc
              };
            })
            .filter(Boolean);
          that.gameCategories = mapped;
        }
      });
    },
    getBanList() {
      let that = this;
      // 防止重复请求
      if (that.bannerLoading) {
        console.log('banner 接口正在请求中，跳过重复调用');
        return;
      }
      console.log('getBanList 方法被调用');
      console.log('准备请求 /api/bannerList 接口');
      if (!that.$apiFun) {
        console.error('$apiFun 未定义！');
        return;
      }
      that.bannerLoading = true; // 设置请求标志
      that.$apiFun.post('/api/bannerList', { type: 1 }).then(res => {
        console.log('轮播图接口返回:', res);
        if (res.code != 200) {
          that.showTost(res.message || '获取轮播图失败');
          // API失败时使用默认数据
          that.bannerList = [
            { src: 'https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d4lvso06h9rghgf7eo4g_258196.jpg' },
            { src: 'https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d4865hgi2sccru47d730_207494.png' }
          ];
        }
        if (res.code == 200) {
          // 确保数据格式正确
          if (res.data && Array.isArray(res.data) && res.data.length > 0) {
            // 如果返回的数据没有src字段，尝试其他可能的字段名
            that.bannerList = res.data.map(item => {
              return {
                src: item.src || item.image || item.url || item.banner || item.img || ''
              };
            }).filter(item => item.src); // 过滤掉没有图片地址的项
          } else {
            // 数据为空时使用默认数据
            that.bannerList = [
              { src: 'https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d4lvso06h9rghgf7eo4g_258196.jpg' },
              { src: 'https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d4865hgi2sccru47d730_207494.png' }
            ];
          }
          // 数据更新后重新初始化轮播图
          that.$nextTick(() => {
            that.initSwiper();
          });
        }
        that.bannerLoading = false; // 请求完成，重置标志
      }).catch(err => {
        console.error('轮播图接口错误:', err);
        that.showTost('获取轮播图失败，请稍后重试');
        // 错误时使用默认数据
        that.bannerList = [
          { src: 'https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d4lvso06h9rghgf7eo4g_258196.jpg' },
          { src: 'https://p3static.qwevo7g2g.com/images/new_public/web/bg/fd/cs/d4865hgi2sccru47d730_207494.png' }
        ];
        that.bannerLoading = false; // 请求完成，重置标志
      });
    },
    homenotice() {
      let that = this;
      // 模拟数据
      that.homenoticelis = [
        "九游娱乐杜绝洗钱 (非法/不良资金) 行为。我司将严厉打击洗钱资金，一经发现洗钱资金一律冻结处理。",
        "为了您的资金以及隐私安全，请您尽快卸载【国家反诈中心】App！若您被该App监控到支付流水，会导致您的银行卡或支付宝等被冻结！",
        "尊敬的客户：我司双赢彩票场馆于2025年12月17日（星期三）06:00-07:10进行系统维护，维护期间场馆将无法转账及游戏，请维护前将场馆内的余额转出，给您带来不便，我们深感抱歉，谢谢。"
      ];
      /*
      that.$apiFun.post('/api/homenotice', {}).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.homenoticelis = res.data;
        }
      });
      */
    },
    getHotGames() {
      let that = this;
      // 模拟数据，实际应该从API获取
      that.hotGames = [];
      /*
      that.$apiFun.post('/api/getHotGames', {}).then(res => {
        if (res.code == 200) {
          that.hotGames = res.data;
        }
      });
      */
    },
    openKefu() {
      let that = this;
      that.showTost('正在链接人工客服');
      that.$apiFun.post('/api/getservicerurl', {}).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.jumpUrl = res.data.url;
        }
      });
    },
    showTost(title) {
      $('body').append(`
        <div class='ant-message' style='top: 400px;'><span><div class='ant-message-notice'><div class='ant-message-notice-content'>
        <div class='ant-message-custom-content ant-message-info'><span role='img' aria-label='info-circle' class='anticon anticon-info-circle'>
        <svg viewBox='64 64 896 896' focusable='false' data-icon='info-circle' width='1em' height='1em' fill='currentColor' aria-hidden='true'>
        <path d='M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm32 664c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8V456c0-4.4 3.6-8 8-8h48c4.4 0 8 3.6 8 8v272zm-32-344a48.01 48.01 0 010-96 48.01 48.01 0 010 96z'></path></svg></span><span>
        ${title}
        </span></div></div></div></span>
        </div>`);
      setTimeout('$(".ant-message").detach()', 2000);
    },
    goNav(url) {
      let that = this;
      if (url == this.$route.fullPath) {
        that.showTost('您就在当前页');
        return;
      }
      this.$router.push({ path: url });
    },
    handleCategoryClick(url, event) {
      // 如果正在拖动，不触发点击事件
      if (this.isDragging) {
        event.preventDefault();
        event.stopPropagation();
        return;
      }
      this.goNav(url);
    },
    onDragStart(e) {
      if (!this.$refs.gameCategories) return;
      // 支持触摸事件和鼠标事件
      const clientX = e.touches ? e.touches[0].clientX : e.pageX;
      this.startX = clientX - this.$refs.gameCategories.offsetLeft;
      this.scrollLeft = this.$refs.gameCategories.scrollLeft;
      this.isDragging = false; // 初始状态为false，只有移动超过阈值才设为true
      this.$refs.gameCategories.style.cursor = 'grab';
      this.$refs.gameCategories.style.userSelect = 'none';
    },
    onDragMove(e) {
      if (!this.$refs.gameCategories) return;
      // 支持触摸事件和鼠标事件
      const clientX = e.touches ? e.touches[0].clientX : e.pageX;
      const x = clientX - this.$refs.gameCategories.offsetLeft;
      const walkX = x - this.startX;
      
      // 只有移动距离超过阈值才认为是拖动
      if (Math.abs(walkX) > this.dragThreshold) {
        if (!this.isDragging) {
          this.isDragging = true;
          this.$refs.gameCategories.style.cursor = 'grabbing';
        }
        e.preventDefault();
        const walk = walkX * 2; // 滚动速度倍数
        this.$refs.gameCategories.scrollLeft = this.scrollLeft - walk;
      }
    },
    onDragEnd() {
      if (!this.$refs.gameCategories) return;
      // 延迟重置，避免拖动结束后立即触发点击
      setTimeout(() => {
        this.isDragging = false;
        this.$refs.gameCategories.style.cursor = 'grab';
        this.$refs.gameCategories.style.userSelect = '';
      }, 100);
    },
    goToSlide(index) {
      if (this.swiperInstance) {
        // 在 loop 模式下，需要使用 slideToLoop
        if (this.swiperInstance.params && this.swiperInstance.params.loop) {
          this.swiperInstance.slideToLoop(index);
        } else {
          this.swiperInstance.slideTo(index);
        }
      }
      this.currentSlideIndex = index;
    },
    // 显示分类 banner（隐藏轮播图）
    showCategoryBanner(bannerUrl) {
      if (bannerUrl) {
        this.categoryBanner = bannerUrl;
        this.showCarousel = false;
      }
    },
    // 检查路由，判断显示轮播图还是 banner
    checkRouteForBanner() {
      const currentPath = this.$route.path;
      // 如果是首页，显示轮播图
      if (currentPath === '/' || currentPath === '/index') {
        this.showCarousel = true;
        this.categoryBanner = '';
      }
      // 其他页面保持当前状态（可能已经通过事件设置了 banner）
    },
    // 获取 PC 分类数据
    fetchPcCategories() {
      let that = this;
      that.$apiFun.get('/api/getGamePcCategories', {}).then(res => {
        if (res.code === 200 && res.data) {
          that.pcCategoriesData = res.data;
        }
      }).catch(err => {
        console.error('获取 PC 分类数据失败:', err);
      });
    },
    // 获取当前显示的 games（根据 selectedChildId 或 selectedChangguan 过滤）
    getDisplayGames() {
      if (!this.pcCategoriesData || this.pcCategoriesData.length === 0) {
        return [];
      }
      
      // 遍历所有分类，找到包含 games 的分类
      for (let category of this.pcCategoriesData) {
        if (category.games && typeof category.games === 'object') {
          // 如果指定了 changguan，返回对应的 games[changguan]
          if (this.selectedChangguan !== null && this.selectedChangguan !== undefined) {
            const changguanKey = String(this.selectedChangguan);
            if (category.games[changguanKey]) {
              return category.games[changguanKey];
            }
          }
          // 如果指定了 child_id，返回对应的 games 数组
          else if (this.selectedChildId !== null && this.selectedChildId !== undefined) {
            const childIdKey = String(this.selectedChildId);
            if (category.games[childIdKey]) {
              return category.games[childIdKey];
            }
          }
        }
      }
      
      return [];
    },
    prevSlide() {
      if (this.swiperInstance) {
        this.swiperInstance.slidePrev();
      }
    },
    nextSlide() {
      if (this.swiperInstance) {
        this.swiperInstance.slideNext();
      }
    },
    initNoticeScroll() {
      let that = this;
      that.$nextTick(() => {
        const noticeScroll = that.$refs.noticeScroll;
        if (noticeScroll) {
          const inner = noticeScroll.querySelector('.notice-content-inner');
          if (inner) {
            const texts = inner.querySelectorAll('.notice-text');
            if (texts.length > 1) {
              // 克隆内容以实现无缝滚动
              texts.forEach(text => {
                const clone = text.cloneNode(true);
                inner.appendChild(clone);
              });
              // 添加滚动动画类
              inner.classList.add('scrolling');
            }
          }
        }
      });
    },
  },
  mounted() {
    let that = this;
    // 公告滚动
    if (that.homenoticelis.length > 0) {
      that.initNoticeScroll();
    }
    // 监听分类 banner 显示事件
    that.$root.$on('showCategoryBanner', (bannerUrl) => {
      that.showCategoryBanner(bannerUrl);
    });
    // 监听显示轮播图事件（点击首页时）
    that.$root.$on('showCarousel', () => {
      that.showCarousel = true;
      that.categoryBanner = '';
    });
    // 监听切换 games 显示事件（根据 child_id）
    that.$root.$on('switchGamesByChildId', (childId) => {
      that.selectedChildId = childId;
      that.selectedChangguan = null; // 清除 changguan 选择
    });
    // 监听切换 games 显示事件（根据 changguan）
    that.$root.$on('switchGamesByChangguan', (changguan) => {
      that.selectedChangguan = changguan;
      that.selectedChildId = null; // 清除 child_id 选择
    });
    // 监听 PC 分类数据更新事件
    that.$root.$on('updatePcCategoriesData', (data) => {
      that.pcCategoriesData = data;
    });
    // 根据当前路由判断显示轮播图还是 banner
    that.checkRouteForBanner();
    // 获取 PC 分类数据
    that.fetchPcCategories();
  },
  updated() {
    let that = this;
    // 轮播图初始化（参考 indexs.vue 的做法，在 updated 中初始化）
    if (that.bannerList.length > 0 && typeof Swiper !== 'undefined') {
      // 只在没有实例时才初始化
      if (!that.swiperInstance) {
        // 延迟初始化，确保 DOM 已更新
        setTimeout(() => {
          const sliderEl = document.querySelector('._2gKtEzzo .slick-slider');
          if (sliderEl && !that.swiperInstance) {
            try {
              that.swiperInstance = new Swiper(sliderEl, {
                loop: true,
                speed: 800,
                effect: 'fade',
                autoplay: {
                  delay: 2500,
                  disableOnInteraction: false
                },
                // 不使用 Swiper 自带的 pagination，使用自定义的圆点
                on: {
                  slideChange: function() {
                    // 更新当前索引（考虑 loop 模式）
                    let realIndex = this.realIndex;
                    that.currentSlideIndex = realIndex;
                  }
                }
              });
            } catch (e) {
              console.error('Swiper initialization error:', e);
            }
          }
        }, 100);
      }
    }
    // 公告开始滚动
    if (that.homenoticelis.length > 0) {
      that.initNoticeScroll();
    }
  },
  beforeDestroy() {
    let that = this;
    clearInterval(that.scrolling);
    that.scrolling = null;
    if (that.swiperInstance) {
      that.swiperInstance.destroy(true, true);
      that.swiperInstance = null;
    }
    // 移除事件监听
    that.$root.$off('showCategoryBanner');
    that.$root.$off('showCarousel');
    that.$root.$off('switchGamesByChildId');
    that.$root.$off('switchGamesByChangguan');
    that.$root.$off('updatePcCategoriesData');
  },
  watch: {
    '$route'(to, from) {
      // 路由变化时检查是否需要显示轮播图
      this.checkRouteForBanner();
    },
    jumpUrl() {
      if (this.jumpUrl) {
        window.open(this.jumpUrl, '_blank');
      }
      this.jumpUrl = null;
    }
  }
};
</script>

<style lang="scss" scoped>
/* 轮播图左右切换箭头 */
.swiper-nav-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 48px;
  height: 48px;
  background: rgba(0, 0, 0, 0.5);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 20;
  opacity: 0.6; /* 默认显示，透明度60% */
  transition: all 0.3s ease;
  color: #fff;
  
  &:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: translateY(-50%) scale(1.1);
    opacity: 1; /* 悬停时完全不透明 */
  }
  
  svg {
    width: 24px;
    height: 24px;
  }
}

.swiper-nav-prev {
  left: 20px;
}

.swiper-nav-next {
  right: 20px;
}

._2gKtEzzo:hover .swiper-nav-btn {
  opacity: 1; /* 悬停时完全不透明 */
}

/* 轮播图底部圆点指示器 */
.swiper-pagination-dots {
  position: absolute;
  bottom: 80px; /* 调整位置，确保在公告上方 */
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 10px;
  z-index: 25; /* 提高 z-index，确保在公告和箭头上方，可以点击 */
  pointer-events: auto; /* 确保可以点击 */
}

.swiper-pagination-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.5);
  cursor: pointer;
  transition: all 0.3s ease;
  pointer-events: auto; /* 确保可以点击 */
  
  &:hover {
    background: rgba(255, 255, 255, 0.8);
    transform: scale(1.2);
  }
  
  &.swiper-pagination-dot-active {
    background: #1890ff;
    width: 24px;
    border-radius: 5px;
  }
}

/* 公告区域样式 - 浮动在轮播图上 */
.notice-section {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 10;
  padding: 0 20px;
  pointer-events: none; /* 让点击事件穿透到轮播图 */
  transform: translateY(50%); /* 向上偏移自身高度的50% */
  overflow: visible; /* 确保内容不被裁剪 */
}


.notice-container {
  max-width: 1200px;
  margin: 0 auto;
  pointer-events: auto; /* 恢复公告卡片的点击事件 */
}

.notice-card {
  background: #fff;
  border: 1px solid #e8e8e8;
  border-radius: 50px; /* 增加圆角幅度 */
  padding: 8px 20px;
  display: flex;
  align-items: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  margin-top: -20px; /* 调整覆盖位置，只让公告的一半浮动在轮播图上 */
}

.notice-icon {
  width: 28px;
  height: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 12px;
  flex-shrink: 0;
}

.speaker-icon {
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;

  svg {
    width: 100%;
    height: 100%;
  }
}

.notice-content-wrapper {
  flex: 1;
  overflow: hidden;
  margin-right: 12px;
  height: 28px;
  position: relative;
}

.notice-content-scroll {
  width: 100%;
  height: 100%;
  overflow: hidden;
  position: relative;
}

.notice-content-inner {
  display: flex;
  align-items: center;
  white-space: nowrap;
  height: 100%;
  
  &.scrolling {
    animation: scroll-notice 30s linear infinite;
  }
}

@keyframes scroll-notice {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%);
  }
}

.notice-text {
  display: inline-block;
  margin-right: 40px;
  color: #333;
  font-size: 13px;
  line-height: 28px;
  cursor: pointer;

  &:hover {
    color: #1890ff;
  }
}

.notice-view-btn {
  padding: 5px 16px;
  background: #f5f5f5;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.3s;
  flex-shrink: 0;

  span {
    color: #666;
    font-size: 13px;
  }
  
  &:hover {
    background: #e8e8e8;
    
    span {
      color: #333;
    }
  }
}

.home-main-content {
  padding: 40px 20px;
  max-width: 1200px;
  margin: 50px auto 0;
}

.game-categories {
  display: flex;
  flex-wrap: nowrap;
  gap: 20px;
  margin-bottom: 60px;
  overflow-x: auto;
  overflow-y: hidden;
  padding-bottom: 10px;
  -webkit-overflow-scrolling: touch; /* iOS 平滑滚动 */
  cursor: grab; /* 鼠标样式为抓取 */
  user-select: none; /* 禁止选中文本 */
  
  /* 完全隐藏滚动条 */
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE 10+ */
  
  &::-webkit-scrollbar {
    display: none; /* Chrome/Safari/Edge */
  }
  
  /* 拖动时的样式 */
  &:active {
    cursor: grabbing;
  }
  
  .category-item {
    flex: 0 0 auto; /* 不允许收缩，保持固定宽度 */
    width: 150px;
    min-width: 150px; /* 最小宽度 */
    text-align: center;
    cursor: pointer;
    transition: transform 0.3s;
    
    &:hover {
      transform: translateY(-5px);
    }
    
    .category-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto 15px;
      
      img {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
    }
    
    .category-name {
      font-size: 18px;
      font-weight: bold;
      color: #333;
      margin-bottom: 5px;
    }
    
    .category-desc {
      font-size: 12px;
      color: #999;
    }
  }
}

.section-title {
  text-align: center;
  margin-bottom: 40px;
  
  h1 {
    font-size: 32px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
  }
  
  h2 {
    font-size: 14px;
    color: #999;
    letter-spacing: 2px;
  }
}

.advantages-section {
  margin-bottom: 60px;
  
  .advantages-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    
    .advantage-item {
      display: flex;
      align-items: flex-start;
      padding: 20px;
      background: #f8f9fa;
      border-radius: 8px;
      transition: box-shadow 0.3s;
      
      &:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }
      
      .advantage-icon {
        width: 60px;
        height: 60px;
        margin-right: 20px;
        flex-shrink: 0;
        
        img {
          width: 100%;
          height: 100%;
          object-fit: contain;
        }
      }
      
      .advantage-content {
        flex: 1;
        
        h3 {
          font-size: 18px;
          font-weight: bold;
          color: #333;
          margin-bottom: 10px;
        }
        
        p {
          font-size: 14px;
          color: #666;
          line-height: 1.6;
        }
      }
    }
  }
}

.hot-games-section {
  .games-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    
    .game-card {
      cursor: pointer;
      border-radius: 8px;
      overflow: hidden;
      transition: transform 0.3s;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      
      &:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      }
      
      .game-image {
        width: 100%;
        height: 150px;
        overflow: hidden;
        
        img {
          width: 100%;
          height: 100%;
          object-fit: cover;
        }
      }
      
      .game-name {
        padding: 15px;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        color: #333;
      }
    }
  }
}
</style>
