<template>
  <div class="render-container">
    <!-- 调试信息 -->
    <div v-if="debug" class="debug-info">
      <p>内容类型: {{ contentType }}</p>
      <p>内容长度: {{ contentLength }}</p>
    </div>
    
    <!-- 显示链接内容 -->
    <web-view 
      v-if="isUrl(content) && content" 
      :src="content"
      class="web-view"
    ></web-view>
    <iframe v-else-if="content" 
    :srcdoc="content"
    ref="contentIframe"
    frameborder="0"
    scrolling="no"
    :style="{ width: '100%', height: iframeHeight + 'px' }"
    @load="updateIframeHeight"
  ></iframe>
    <!-- 空状态提示 -->
    <div v-else class="empty-tip">请通过游戏列表正常进入游戏</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      debug: true, // 调试模式，生产环境设为false
      iframeHeight: 400, // 初始高度
    }
  },
  computed: {
    content() {
      return this.$store.getters.getGameContent || ''
    },
    contentType() {
      return this.isUrl(this.content) ? '链接' : 'HTML'
    },
    contentLength() {
      return this.content ? this.content.length : 0
    }
  },
  methods: {
    isUrl(str) {
      if (!str) return false
      try {
        new URL(str)
        return true
      } catch (e) {
        return false
      }
    },
    updateIframeHeight() {
      const iframe = this.$refs.contentIframe;
      if (!iframe) return;

      // 通过contentDocument获取内部文档对象
      const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
      
      // 获取内容实际高度
      const contentHeight = Math.max(
        iframeDoc.body.scrollHeight,
        iframeDoc.documentElement.scrollHeight
      );

      // 设置iframe高度（加10px缓冲）
      this.iframeHeight = contentHeight + 10;

      // 监听窗口变化（响应式调整）
      window.addEventListener('resize', this.updateIframeHeight);
    },
    // 重新加载iframe（内容变化时调用）
    reloadIframe() {
      this.showIframe = false;
      this.$nextTick(() => {
        this.showIframe = true;
      });
    }
  },
  mounted() {
    console.log('[Debug] Store state:', this.$store.state)
    console.log('[Debug] Content:', this.content)
  },
  beforeDestroy() {
    // 清除事件监听
    window.removeEventListener('resize', this.updateIframeHeight);
  }
}
</script>

<style scoped>
.render-container {
  width: 100%;
  height: 100%;
  position: relative;
}

.web-view {
  width: 100%;
  height: 100vh;
}

.html-content {
  padding: 20px;
  background: #f5f5f5;
  min-height: 100vh;
}

.empty-tip {
  padding: 40px;
  text-align: center;
  color: red;
  font-size: 18px;
}

.debug-info {
  position: fixed;
  top: 0;
  right: 0;
  background: rgba(0,0,0,0.7);
  color: white;
  padding: 10px;
  z-index: 1000;
  font-size: 12px;
}
</style>