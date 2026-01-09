<template>
  <div class="activity-page" v-if="activitytypeList.length > 0">
    <!-- 顶部标题 -->
    <div class="page-header">
      <span>全部优惠</span>
    </div>

    <!-- 分类标签 -->
    <div class="tabs-wrapper">
      <van-tabs v-model="actType" class="activity-tabs" @click="activitylist" line-width="0" line-height="0">
        <van-tab title="全部优惠" :name="''"></van-tab>
        <van-tab v-for="(item, index) in activitytypeList" :name="item.id" :title="item.name" :key="index"></van-tab>
      </van-tabs>
    </div>

    <!-- 活动列表 -->
    <div class="activity-list">
      <div class="activity-card" v-for="(item, index) in activitylistList" :key="index" @click="$parent.goNav(`/activityInfo?id=${item.id}`)">
        <div class="card-left">
          <div class="card-title">
            <span class="title-text">{{ item.title }}</span>
          </div>
        </div>
        <div class="card-right">
          <img :src="item.banner" alt="" />
        </div>
      </div>

      <van-divider dashed :style="{ color: '#ccc', borderColor: '#ccc', padding: '20px 16px' }">END</van-divider>
    </div>

    <!-- 底部占位 -->
    <div style="height: 70px;"></div>
  </div>
</template>

<script>
export default {
  name: 'activity',
  data() {
    return {
      activitytypeList: [],
      actType: '',
      activitylistList: [],
    };
  },
  created() {
    let that = this;
    that.activitytype();
    that.activitylist();
  },
  methods: {
    activitytype() {
      let that = this;
      that.$apiFun.post('/api/activitytype', {}).then(res => {
        console.log(res);
        if (res.code !== 200) {
          that.$parent.showTost(0, res.message);
        }
        if (res.code === 200) {
          that.activitytypeList = res.data;
        }
      });
    },
    activitylist() {
      let that = this;
      let info = that.actType == '' ? {} : { type: that.actType };
      that.$parent.showLoading();
      that.$apiFun.post('/api/activitylist', info).then(res => {
        console.log(res);
        if (res.code !== 200) {
          that.$parent.showTost(0, res.message);
        }
        if (res.code === 200) {
          that.activitylistList = res.data.data;
        }
        that.$parent.hideLoading();
      });
    },
    changActType(val) {
      let that = this;
      if (val == that.actType) {
        return;
      }
      that.actType = val;
      that.activitylist();
    },
  },
  mounted() {},
  updated() {},
  beforeDestroy() {},
};
</script>

<style lang="scss" scoped>
.activity-page {
  min-height: 100vh;
  background: #f5f5f5;
}

// 顶部标题
.page-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 45px;
  background: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 101;

  span {
    font-size: 18px !important;
    font-weight: 600 !important;
    color: #333 !important;
  }
}

// 标签栏
.tabs-wrapper {
  position: fixed;
  top: 45px;
  left: 0;
  right: 0;
  z-index: 100;
  background: #fff;
  border-bottom: 1px solid #eee;
}

.activity-tabs ::v-deep .van-tabs__wrap {
  height: 44px;
}

.activity-tabs ::v-deep .van-tab {
  font-size: 14px;
  color: #666;
  padding: 0 12px;
  flex: none;
}

.activity-tabs ::v-deep .van-tab--active {
  color: #ff6600;
  font-weight: 600;
}

.activity-tabs ::v-deep .van-tabs__nav {
  background: #fff;
}

// 活动列表
.activity-list {
  padding: 100px 15px 0;
}

// 活动卡片
.activity-card {
  display: flex;
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);

  .card-left {
    flex: 1;
    padding: 12px;
    display: flex;
    flex-direction: column;
    justify-content: center;

    .card-title {
      .title-text {
        font-size: 16px;
        font-weight: 700;
        color: #333;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
      }
    }
  }

  .card-right {
    width: 110px;
    min-height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }
}
</style>
