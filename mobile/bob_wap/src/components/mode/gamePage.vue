<template>
  <div class="game-container">
    <!-- 顶部导航栏 -->
    <van-nav-bar 
      class="game-nav-bar"
      title="" 
      left-arrow 
      @click-left="$router.back()"
    />
    
    <!-- 主要内容区域 -->
    <main class="game-main">
      <!-- 统一使用iframe渲染 -->
      <transition name="fade">
        <div v-if="content" class="iframe-container">
          <iframe 
            class="game-iframe"
            ref="iframe"
            :src="isUrl ? content : null"
            :srcdoc="!isUrl ? content : null"
            scrolling="auto" 
            frameborder="0"
            @load="adjustIframeHeight"
          ></iframe>
        </div>
      </transition>
      
      <!-- 加载状态 -->
      <transition name="fade">
        <div v-if="isLoading" class="loading-container">
          <div class="loading-content">
            <div class="loading-spinner"></div>
            <p class="loading-text">{{ msg }}</p>
          </div>
        </div>
      </transition>
    </main>
  </div>
</template>

<script>
export default {
  name: 'gamePage',
  data() {
    return {
      content: null,
      isUrl: false,
      isLoading: true,
      msg: "游戏加载中...",
      resizeObserver: null,
      maxHeight: 0,
      checkInterval: null
    };
  },
  created() {
    this.init();
    this.calculateMaxHeight();
  },
  methods: {
    init() {
      let that = this;
      var query = that.$route.query;
      
      if (query.dailiD == 1) {
        that.getAgentLoginUrl();
        return;
      }
      
      if (query.dailiD == 2) {
        that.getservicerurl();
        return;
      }
      
      if (query.app == 1) {
        that.content = that.$store.state.appInfo.ios_download_url;
        that.isUrl = true;
        that.isLoading = false;
        return;
      }
      
      if (query.name) {
        that.goGamePage(query.name, query.type, query.code);
      }
    },
    
    calculateMaxHeight() {
      this.maxHeight = window.innerHeight - 46; // 减去导航栏高度
    },
    
    isUrlAction(content) {
      try {
        new URL(content);
        return true;
      } catch (e) {
        return false;
      }
    },
    
    adjustIframeHeight() {
      try {
        const iframe = this.$refs.iframe;
        if (iframe && iframe.contentWindow) {
          // 清除之前的观察器和定时器
          this.cleanupObservers();
          
          // 设置初始高度
          this.setIframeHeight(iframe);
          
          // 尝试使用ResizeObserver
          if (typeof ResizeObserver !== 'undefined') {
            this.resizeObserver = new ResizeObserver(() => {
              this.setIframeHeight(iframe);
            });
            
            const body = iframe.contentWindow.document.body;
            const html = iframe.contentWindow.document.documentElement;
            
            if (body) this.resizeObserver.observe(body);
            if (html) this.resizeObserver.observe(html);
          } else {
            // 浏览器不支持ResizeObserver时使用轮询作为备用方案
            this.checkInterval = setInterval(() => {
              this.setIframeHeight(iframe);
            }, 300);
          }
        }
      } catch (e) {
        console.error('调整iframe高度出错:', e);
      }
    },
    
    setIframeHeight(iframe) {
      try {
        const doc = iframe.contentWindow.document;
        const bodyHeight = doc.body.scrollHeight;
        const htmlHeight = doc.documentElement.scrollHeight;
        const contentHeight = Math.max(bodyHeight, htmlHeight, this.maxHeight);
        
        // 应用高度限制
        const finalHeight = Math.min(contentHeight, this.maxHeight);
        
        iframe.style.height = `${finalHeight}px`;
        iframe.style.overflowY = contentHeight > this.maxHeight ? 'auto' : 'hidden';
      } catch (e) {
        console.error('设置iframe高度出错:', e);
      }
    },
    
    cleanupObservers() {
      if (this.resizeObserver) {
        this.resizeObserver.disconnect();
        this.resizeObserver = null;
      }
      if (this.checkInterval) {
        clearInterval(this.checkInterval);
        this.checkInterval = null;
      }
    },
    
    getservicerurl() {
      let that = this;
      that.$apiFun.post('/api/getservicerurl', {}).then(res => {
        if (res.code != 200) {
          that.showTost(0, res.message);
        }
        if (res.code == 200) {
          that.content = res.data.url;
          that.isUrl = true;
          that.isLoading = false;
        }
      });
    },
    
    getAgentLoginUrl() {
      let that = this;
      that.$apiFun.get('/api/getAgentLoginUrl', {}).then(res => {
        if (res.code != 200) {
          that.showTost(0, res.message);
        }
        if (res.code == 200) {
          that.content = res.data.url;
          that.isUrl = true;
          that.isLoading = false;
        }
      });
    },
    
    goGamePage(name, type, code) {
      let that = this;
      that.isLoading = true;
      
      that.$apiFun
        .post('/api/getGameUrl', {
          plat_name: name, 
          game_type: type || 0, 
          game_code: code, 
          is_mobile_url: 1
        })
        .then(res => {
          if (res.code == 501) {
            that.msg = res.message;
            that.$dialog.confirm({
              title: '提示',
              message: res.message,
              confirmButtonText: '前往转账',
              cancelButtonText: '先逛逛',
            })
            .then(() => {
              that.goNav('/transfer', name);
            })
            .catch(() => {
              if (res.data && res.data.url) {
                that.content = res.data.url;
                that.isUrl = that.isUrlAction(res.data.url);
              }
              that.isLoading = false;
            });
          } else {
            if (res.code != 200) {
              that.$parent.showTost(0, res.message);
              setTimeout(() => {
                this.$router.go(-1);
              }, 3000);
              return;
            }
            
            if (res.data && res.data.url) {
              that.content = res.data.url;
              that.isUrl = that.isUrlAction(res.data.url);
            }
            that.isLoading = false;
          }
        })
        .catch(res => {
          that.isLoading = false;
        });
    },
  },
  mounted() {
    window.addEventListener('resize', () => {
      this.calculateMaxHeight();
      this.adjustIframeHeight();
    });
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.adjustIframeHeight);
    this.cleanupObservers();
  }
};
</script>

<style scoped>
.game-container {
  height: 100vh;
  display: flex;
  flex-direction: column;
  background: #f5f5f5;
}

.game-nav-bar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background: linear-gradient(135deg, #6e8efb, #a777e3);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.game-nav-bar /deep/ .van-nav-bar__arrow {
  color: white;
}

.game-main {
  flex: 1;
  margin-top: 46px;
  height: calc(100vh - 46px);
  position: relative;
  overflow-y: auto;
}

.iframe-container {
  width: 100%;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.game-iframe {
  width: 100%;
  min-height: 100px;
  border: none;
  border-radius: 8px;
  display: block;
  overflow-y: auto;
}

.loading-container {
  height: 100%;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background: white;
  border-radius: 8px;
  position: absolute;
  top: 0;
  left: 0;
}

.loading-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #6e8efb;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

.loading-text {
  font-size: 18px;
  color: #666;
  font-weight: 500;
  text-align: center;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@media (max-width: 768px) {
  .loading-text {
    font-size: 16px;
  }
  
  .loading-spinner {
    width: 40px;
    height: 40px;
  }
}
</style>