<template>
  <div style="width: 100%; min-height: 100vh; background: rgb(237, 241, 255)">
    <van-nav-bar style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ede9e7" title="投注记录" left-arrow @click-left="$router.back()" />
    <div style="height: 46px"></div>
    <div style="width: 95%; min-width: 250px; margin: 0 auto; background: #fff; border-radius: 10px; box-sizing: border-box; padding: 10px; min-height: 90vh">
      <van-list style="margin-top: 10px; padding-bottom: 120px" finished-text="没有更多了" offset="300" v-model="loading" :finished="list.length == pageData.total" @load="getData" v-if="list.length > 0">
        <van-cell v-for="(item, index) in list" :key="index">
          <div style="font-size: 0.3rem">订单号：{{ item.bet_id }}</div>
          <div style="display: flex; justify-content: space-between;">
            <div style="font-size: 0.3rem">金额 :{{ item.bet_amount }}</div>
            <div style="font-size: 0.3rem">派彩 :{{ item.win_loss }}</div>
          </div>
          <div style="display: flex; justify-content: space-between;">
            <div style="font-size: 0.3rem">{{ item.Code }}</div>
            <div style="font-size: 0.3rem">{{ statuType[item.status] }}</div>
          </div>
          <div style="font-size: 0.3rem">{{ item.created_at }}</div>
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
  name: 'betRecord',
  data() {
    return {
      date: 4,
      list: [],
      pageData: {},
      page: 1,
      statuType: ['无效注单', '已结算', '未结算'],
      api_type: '',
      loading: false,
    };
  },
  created() {
    let that = this;
    if (this.$route.query.api_type !== undefined) {
      this.api_type = this.$route.query.api_type;
    }
    if (this.$route.query.date !== undefined) {
      this.date = parseInt(this.$route.query.date) || 4;
    }
    that.getData();
  },
  methods: {
    // 获取交易记录
    getData() {
      let that = this;
      let page = that.page;
      if (page > that.pageData.last_page) {
        that.loading = false;

        return;
      }
      that.$parent.showLoading();
      let info = {
        date: that.date,
        page: that.page,
        api_type: that.api_type,
      };
      that.$apiFun
        .post('/api/betrecord', info)
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
