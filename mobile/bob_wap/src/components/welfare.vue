<template>
  <div style="width: 100%; min-height: 100vh; background: rgb(237, 241, 255)">
    <van-nav-bar style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ede9e7" title="福利中心" left-arrow @click-left="$router.back()" />
    <div style="height: 46px"></div>
    <div style="width: 95%;min-width:250px; margin: 0 auto; background: #fff; border-radius: 10px; box-sizing: border-box; padding: 10px; min-height: 90vh">
      <div style="padding-bottom: 10px; display: flex; align-items: center; justify-content: space-between">
        <span style="font-size: 0.3rem"> 红包记录 </span>

        <van-button style="width:3rem;height: 0.68rem;min-width:80px"  type="info" @click="$parent.goNav('/hongbao')"><span style="color: #fff; font-size: 0.3rem">前往领取</span></van-button>
      </div>
      <div style="display: flex; box-sizing: border-box; padding: 0 12px; font-size: 0.3rem; justify-content: space-between; height: 1.1rem;align-items: center;">
        <div style="font-size: 0.3rem;"> 剩余领取次数：{{ userredpacket.sendnums }}</div>
        <div style="font-size: 0.3rem;">已领取次数：{{ userredpacket.acquirednum }}</div>
      </div>

      <van-list style="margin-top: 10px; padding-bottom: 120px" finished-text="没有更多了" offset="300" v-model="loading" :finished="list.length == pageData.total" @load="getData" v-if="list.length > 0">
        <van-cell v-for="(item, index) in list" :key="index">
          <div style="color: #888 !important">
            <div style="display: flex; justify-content: space-between">
              充值金额 :{{ item.money }} <span>红包金额：{{ item.redpacketmoney }}</span>
            </div>
            <div>充值时间:{{ item.created_at }}</div>
            <div>领取时间：{{ item.usetime }}</div>
          </div>
        </van-cell>
      </van-list>
      <div v-else style="margin-top: 60px; text-align: center">
        <img src="/static/image/mescroll-empty.png" style="width: 35%" alt="" />
        <van-divider dashed :style="{ color: '#ccc', borderColor: '#ccc', padding: '20px ' }">空空如也</van-divider>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'welfare',
  data() {
    return {
      list: [],
      pageData: {},
      userredpacket: {},
      page: 1,
      loading: false,
    };
  },
  created() {
    let that = this;
    that.getuserredpacket();
    that.getData();
  },
  methods: {
    getData() {
      let that = this;
      let page = that.page;
      if (page > that.pageData.last_page) {
        that.loading = false;

        return;
      }
      that.$parent.showLoading();
      let info = {
        page: that.page,
      };
      that.$apiFun
        .post('/api/redpacket', info)
        .then(res => {
          if (res.code != 200) {
            that.$parent.showTost(0, res.message);
          }
          if (res.code == 200) {
            that.pageData = res.data;

            if (that.page == 1) {
              that.list = res.data.data;
            } else {
              let list = JSON.parse(JSON.stringify(that.list));
              res.data.data.forEach(el => {
                list.push(el);
              });
              that.list = list;
            }
            that.page = page + 1;
          }
          that.loading = false;
          that.$parent.hideLoading();
        })
        .catch(res => {
          that.$parent.hideLoading();
          that.loading = false;
        });
    },
    getuserredpacket() {
      let that = this;
      that.$parent.showLoading();
      let info = {
        page: that.page,
      };
      that.$apiFun.get('/api/userredpacket', info).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.$parent.showTost(0, res.message);
        }
        if (res.code == 200) {
          that.userredpacket = res.data;
        }
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
};
</script>

<style lang="scss" scoped>
</style>
