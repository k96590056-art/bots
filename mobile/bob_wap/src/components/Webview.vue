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
      :src="iframeUrl"
      class="webview-iframe"
      frameborder="0"
    ></iframe>
    <div v-else class="webview-empty">链接无效</div>
  </div>
</template>

<script>
export default {
  name: 'Webview',
  data() {
    return {};
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
  },
  created() {
    if (!this.iframeUrl) {
      this.$toast && this.$toast('链接无效');
    }
  },
};
</script>

<style lang="scss" scoped>
.webview-page {
  min-height: 100vh;
  background: #fff;
}
.webview-placeholder {
  height: 46px;
}
.webview-iframe {
  position: fixed;
  top: 46px;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  height: calc(100vh - 46px);
  border: none;
}
.webview-empty {
  padding: 40px 20px;
  text-align: center;
  color: #999;
  font-size: 14px;
}
</style>
