<template>
  <van-tabbar v-model="type" @change="onChange" active-color="#1890ff" inactive-color="#cdcdcd" style="border-top: 1px solid #d5d8e0; box-sizing: border-box; background-color: rgb(243, 246, 255); z-index: 200">
    <van-tabbar-item>
      <span>首页</span>
      <template #icon="props">
        <img :src="props.active ? '/static/image/tabbar_icon1_select.png' : '/static/image/tabbar_icon1_nor.png'" />
      </template>
    </van-tabbar-item>
    <van-tabbar-item>
      <span>优惠</span>
      <template #icon="props">
        <img :src="props.active ? '/static/image/tabbar_icon3_select.png' : '/static/image/tabbar_icon3_nor.png'" />

      </template>
    </van-tabbar-item>
    <van-tabbar-item>
      <span>客服</span>
      <template #icon="props">
       <img :src="props.active ? '/static/image/tabbar_icon6_select.png' : '/static/image/tabbar_icon6_nor.png'" />

      </template>
    </van-tabbar-item>
    <van-tabbar-item>
      <span>赞助</span>
      <template #icon="props">
        <img :src="props.active ? '/static/image/tabbar_icon4_select.png' : '/static/image/tabbar_icon4_nor.png'" />
      </template>
    </van-tabbar-item>
    <van-tabbar-item>
      <span>我的</span>
      <template #icon="props">
        <img :src="props.active ? '/static/image/tabbar_icon5_select.png' : '/static/image/tabbar_icon5_nor.png'" />
      </template>
    </van-tabbar-item>
  </van-tabbar>
</template>
<script>
//
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
        that.$parent.goNav(`/activity`);
      }
      if (type == 2) {
        that.$parent.openKefu();
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
      if (path == '/activity') {
        that.type = 1;
      }

      if (path == '/kefu') {
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
    //监听路由地址的改变
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
// @import '../../../static/css/chunk-611499bd.2ebefcf0.css';
.van-tabbar-item__icon img {
  display: block;
  height: 34px;
}
.van-tabbar-item {
  font-size: 14px;
}
.van-tabbar {
  height: 68px;
}
.van-tabbar-item--active {
  background-color: rgb(243, 246, 255);
}
</style>
