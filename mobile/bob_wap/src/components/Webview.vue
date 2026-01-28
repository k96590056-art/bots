<template>
  <div class="webview-page">
    <van-nav-bar
      :title="title"
      left-arrow
      fixed
      @click-left="$router.back()"
    />
    <div class="webview-placeholder"></div>
    <iframe
      v-if="iframeUrl"
      ref="iframe"
      :src="iframeUrl"
      class="webview-iframe"
      :style="iframeStyle"
      frameborder="0"
      sandbox="allow-scripts allow-same-origin allow-forms allow-popups allow-modals"
      allow="microphone; camera"
    ></iframe>
    <div v-else class="webview-empty">链接无效</div>
  </div>
</template>

<script>
export default {
  name: 'Webview',
  data() {
    return {
      windowHeight: window.innerHeight,
    };
  },
  computed: {
    iframeUrl() {
      const url = this.$route.query.url;
      if (!url || typeof url !== 'string') return '';
      const decoded = decodeURIComponent(url);
      if (!/^https?:\/\//i.test(decoded)) return '';
      return decoded;
    },
    title() {
      return this.$route.query.title || '打开链接';
    },
    iframeStyle() {
      // 动态计算 iframe 高度，确保自适应各种手机
      const navHeight = 46;
      const height = this.windowHeight - navHeight;
      return {
        height: height + 'px',
      };
    },
  },
  created() {
    if (!this.iframeUrl) {
      this.$toast && this.$toast('链接无效');
    }
  },
  mounted() {
    // 监听窗口大小变化
    window.addEventListener('resize', this.handleResize);
    // 初始化时也触发一次
    this.handleResize();
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.handleResize);
  },
  methods: {
    handleResize() {
      // 使用 visualViewport 获取可视区域高度（更准确，能处理软键盘弹出等情况）
      if (window.visualViewport) {
        this.windowHeight = window.visualViewport.height;
      } else {
        this.windowHeight = window.innerHeight;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.webview-page {
  min-height: 100vh;
  min-height: -webkit-fill-available;
  background: #fff;
  /* 兼容 iPhone 安全区域 */
  padding-top: constant(safe-area-inset-top);
  padding-top: env(safe-area-inset-top);
  padding-bottom: constant(safe-area-inset-bottom);
  padding-bottom: env(safe-area-inset-bottom);
}
.webview-placeholder {
  height: 46px;
}
.webview-iframe {
  position: fixed;
  top: 46px;
  left: 0;
  right: 0;
  width: 100%;
  border: none;
  /* 确保 iframe 不会被底部工具栏遮挡 */
  -webkit-overflow-scrolling: touch;
}
.webview-empty {
  padding: 40px 20px;
  text-align: center;
  color: #999;
  font-size: 14px;
}
</style>