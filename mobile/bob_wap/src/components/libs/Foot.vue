<template>
  <van-tabbar v-model="type" @change="onChange" active-color="#1890ff" inactive-color="#999" style="border-top: 1px solid #eee; box-sizing: border-box; background-color: #fff; z-index: 200">
    <van-tabbar-item>
      <span>首页</span>
      <template #icon="props">
        <img src="/static/image/imagehome.png" alt="首页" class="tab-icon" :class="{ active: props.active }" />
      </template>
    </van-tabbar-item>
    <van-tabbar-item>
      <span>客服</span>
      <template #icon="props">
        <img src="/static/image/imagecustomer.png" alt="客服" class="tab-icon" :class="{ active: props.active }" />
      </template>
    </van-tabbar-item>
    <van-tabbar-item>
      <span>优惠</span>
      <template #icon="props">
        <img src="/static/image/imagediscount.png" alt="优惠" class="tab-icon" :class="{ active: props.active }" />
      </template>
    </van-tabbar-item>
    <van-tabbar-item>
      <span>赞助</span>
      <template #icon="props">
        <img src="/static/image/imagesponsorship.png" alt="赞助" class="tab-icon" :class="{ active: props.active }" />
      </template>
    </van-tabbar-item>
    <van-tabbar-item>
      <span>我的</span>
      <template #icon="props">
        <img src="/static/image/imagemine.png" alt="我的" class="tab-icon" :class="{ active: props.active }" />
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
  height: 6.5vw;
  width: 6.5vw;
}
.van-tabbar-item {
  font-size: 3vw;
}
.van-tabbar {
  height: 14vw;
}
.van-tabbar-item--active {
  background-color: #fff;
}
.tab-icon {
  width: 6.5vw;
  height: 6.5vw;
  object-fit: contain;
  filter: brightness(0) saturate(100%) invert(60%) sepia(0%) saturate(0%) hue-rotate(0deg);
  &.active {
    filter: brightness(0) saturate(100%) invert(42%) sepia(93%) saturate(1352%) hue-rotate(196deg) contrast(91%);
  }
}
</style>
