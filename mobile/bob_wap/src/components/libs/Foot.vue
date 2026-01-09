<template>
  <van-tabbar v-model="type" @change="onChange" active-color="#1890ff" inactive-color="#999" style="border-top: 1px solid #eee; box-sizing: border-box; background-color: #fff; z-index: 200">
    <van-tabbar-item>
      <span>首页</span>
      <template #icon="props">
        <svg viewBox="0 0 24 24" fill="none" :stroke="props.active ? '#1890ff' : '#999'" stroke-width="1.8" width="24" height="24">
          <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
      </template>
    </van-tabbar-item>
    <van-tabbar-item>
      <span>客服</span>
      <template #icon="props">
        <svg viewBox="0 0 24 24" fill="none" :stroke="props.active ? '#1890ff' : '#999'" stroke-width="1.8" width="24" height="24">
          <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
          <path d="M13.73 21a2 2 0 01-3.46 0"/>
        </svg>
      </template>
    </van-tabbar-item>
    <van-tabbar-item>
      <span>优惠</span>
      <template #icon="props">
        <svg viewBox="0 0 24 24" fill="none" :stroke="props.active ? '#1890ff' : '#999'" stroke-width="1.8" width="24" height="24">
          <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
          <line x1="3" y1="9" x2="21" y2="9"/>
          <line x1="9" y1="21" x2="9" y2="9"/>
        </svg>
      </template>
    </van-tabbar-item>
    <van-tabbar-item>
      <span>赞助</span>
      <template #icon="props">
        <svg viewBox="0 0 24 24" fill="none" :stroke="props.active ? '#1890ff' : '#999'" stroke-width="1.8" width="24" height="24">
          <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
        </svg>
      </template>
    </van-tabbar-item>
    <van-tabbar-item>
      <span>我的</span>
      <template #icon="props">
        <svg viewBox="0 0 24 24" :fill="props.active ? '#1890ff' : 'none'" :stroke="props.active ? '#1890ff' : '#999'" stroke-width="1.8" width="24" height="24">
          <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
      </template>
    </van-tabbar-item>
  </van-tabbar>
</template>
<script>
export default {
  name: 'Foot',
  data() {
    return { type: 0 };
  },
  methods: {
    onChange(type) {
      let that = this;
      if (type == 0) {
        that.$parent.goNav(`/`);
      }
      if (type == 1) {
        that.$parent.openKefu();
      }
      if (type == 2) {
        that.$parent.goNav(`/activity`);
      }
      if (type == 3) {
        that.$parent.goNav(`/zhanzhu`);
      }
      if (type == 4) {
        that.$parent.goNav(`/mine`);
      }
    },
    changPath() {
      let that = this;
      let path = this.$route.path;
      if (path == '/') {
        that.type = 0;
      }
      if (path == '/kefu') {
        that.type = 1;
      }
      if (path == '/activity') {
        that.type = 2;
      }
      if (path == '/zhanzhu') {
        that.type = 3;
      }
      if (path == '/mine') {
        that.type = 4;
      }
      if (path == '/gamePage' || path == '/hongbao') {
        that.type = 5;
      }
    },
  },
  mounted() {},
  watch: {
    $route: {
      immediate: true,
      handler() {
        let that = this;
        that.changPath();
      },
    },
  },
};
</script>

<style lang="scss" scoped>
.van-tabbar-item__icon img,
.van-tabbar-item__icon svg {
  display: block;
  height: 24px;
  width: 24px;
}
.van-tabbar-item {
  font-size: 14px;
}
.van-tabbar {
  height: 55px;
}
.van-tabbar-item--active {
  background-color: #fff;
}
</style>
