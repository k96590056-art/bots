<template>
  <div>
    <van-nav-bar style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ede9e7" title="消息中心" left-arrow @click-left="$router.back()" />
    <div style="height: 60px"></div>
    <div class="van-tabs-view van-tabs">
      <div class="van-tabs__wrap">
        <div role="tablist" class="van-tabs__nav van-tabs__nav--card">
          <div role="tab" @click="changType(1)" aria-selected="true" :class="type == 1 ? 'van-tab van-tab--active' : 'van-tab'"><span class="van-tab__text van-tab__text--ellipsis">公告</span></div>
          <div role="tab" @click="changType(2)" :class="type == 2 ? 'van-tab van-tab--active' : 'van-tab'">
            <span class="van-tab__text van-tab__text--ellipsis"><span>站内信</span></span>
          </div>
        </div>
      </div>
      <div class="van-tabs__content" style="width: 90%; margin: 0 auto">
        <div v-if="type == 1" role="tabpanel" class="van-tab__pane" style="">
          <van-list finished-text="没有更多了" :finished="true" v-if="homenoticelis.length > 0">
            <van-cell v-for="(item, index) in homenoticelis" :key="index">
              <div class="content">{{ item }}</div>
            </van-cell>
          </van-list>
          <van-divider v-else dashed :style="{ color: '#ccc', borderColor: '#ccc', padding: '20px 100px' }">没有更多了~</van-divider>
        </div>
        <div v-if="type == 2" role="tabpanel" class="van-tab__pane">
          <van-list finished-text="没有更多了" offset="300" v-model="loading" :finished="noticeList.length == noticeListInfo.total" @load="getDatalist" v-if="noticeList.length > 0">
            <van-cell v-for="(item, index) in noticeList" :key="index">
              <h3 class="unReadTitle">
                <span>{{ item.title }}</span>
              </h3>
              <div class="content" v-html="item.content">{{ item }}</div>
              <div class="content">{{ item.created_at }}</div>
            </van-cell>
          </van-list>
          <van-divider v-else dashed :style="{ color: '#ccc', borderColor: '#ccc', padding: '20px 100px' }">没有更多了~</van-divider>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'message',
  data() {
    return { type: 1, noticeList: [], homenoticelis: [], noticeListInfo: {}, page: 1 };
  },
  created() {
    let that = this;
    var query = that.$route.query;
    if (query.type) {
      that.type = query.type * 1;
    }

    that.homenotice();
    that.getDatalist();
  },
  methods: {
    changType(type) {
      let that = this;
      that.type = type;
    },
    homenotice() {
      let that = this;
      that.$parent.showLoading();
      that.$apiFun.post('/api/homenotice', {}).then(res => {
        if (res.code != 200) {
          that.showTost(0, res.message);
        }
        if (res.code == 200) {
          that.homenoticelis = res.data;
        }
        that.$parent.hideLoading();
      });
    },
    getDatalist() {
      let that = this;
      let page = that.page;
      if (page > that.noticeListInfo.last_page) {
        that.loading = false;

        return;
      }
      that.$parent.showLoading();
      that.$apiFun
        .post('/api/noticeList', { page })
        .then(res => {
          if (res.code != 200) {
            that.$parent.showTost(0, res.message);
          }
          if (res.code == 200) {
            that.noticeListInfo = res.data;
            if (page == 1) {
              that.noticeList = res.data.data;
            } else {
              let list = JSON.parse(JSON.stringify(that.list4));
              res.data.data.forEach(el => {
                list.push(el);
              });
              that.noticeList = list;
            }
            that.page = page + 1;
          }
          that.loading = false;

          that.$parent.hideLoading();
        })
        .catch(res => {
          that.$parent.hideLoading();
        });
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
.van-tabs__nav--card .van-tab.van-tab--active {
    color: #fff;
    background-color: #cf866b;
}
.van-tabs__nav--card {

    border: 1px solid #cf866b;
}
.van-tabs__nav--card .van-tab{
    color: #cf866b;

}
.van-tabs__nav--card .van-tab{
  border-right: 0 solid #cf866b;
}
</style>
