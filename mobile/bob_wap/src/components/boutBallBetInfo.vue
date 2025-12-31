<template>
  <div class="sdddd">
    <div style="height: 180px"></div>
    <img class="bancgs" @click="$router.back()" src="/static/image/bank_020021515.png" alt="" />
    <div class="topsf">
      <div class="tois">
        <img src="/static/style/tx.0d38194b71b5a32ef1df50b7090ca7f5.png" alt="" />
        <div class="dwd">
          <div class="tisaa">Hi,尊敬的会员用户</div>
          <div class="newsa">早上好，欢迎来到帮助中心</div>
          <div class="newsa">若相关问题仍未解决，可咨询在线客服</div>
        </div>
      </div>
      <div style="color: #fff; text-align: center; margin-top: 10px; font-size: 20px">{{ title }}</div>
    </div>
    <div style="color: #666; padding: 0px 20px; box-sizing: border-box" v-html="dataBox.content"></div>
    <div v-if="dataBox.content" style="margin-top: 0.48rem; text-align: center; color: #6c7c9d; padding-bottom: 0.6rem">没有找到解决办法？请联系<a style="color: #597ef7; font-weight: 600" @click="$parent.openKefu">人工客服</a>解决</div>
  </div>
</template>
<script>
export default {
  name: 'boutBallBetInfo',
  data() {
    return {
      title: '',
      // 1常见问题  2隐私政策  3免责说明  4联系我们  5代理加盟  7关于我们 8博彩责任
      type: 0,
      dataBox: {},
    };
  },
  created() {
    let that = this;
    let query = that.$route.query;
    if (query.type) {
      let type = query.type * 1;
      that.type = type;
      if (type == 1) {
        that.title = '常见问题';
      }
      if (type == 2) {
        that.title = '隐私政策';
      }
      if (type == 3) {
        that.title = '免责说明';
      }
      if (type == 4) {
        that.title = '联系我们';
      }
      if (type == 5) {
        that.title = '代理加盟';
      }
      if (type == 7) {
        that.title = '关于我们';
      }
      if (type == 8) {
        that.title = '博彩责任';
      }
      that.getAllCont(type);
    }
  },
  methods: {
    getAllCont(type) {
      let that = this;
      that.$parent.showLoading();

      that.$apiFun
        .post('/api/article', { type })
        .then(res => {
          that.dataBox = res.data;
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
};
</script>

<style lang="scss" scoped>
.topsf {
  background: url(/static/image/welcome-bg.812e6eebb547ed38a04db1056d489b08.812e6eeb.png) bottom no-repeat;
  background-size: 100% 100%;
  height: 180px;
  width: 100%;
  position: fixed;
  width: 100%;
  top: 0;
  left: 0;
  .tois {
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid #fff;
    margin: 0 auto;
    width: 90%;
    color: #fff;
    .tisaa {
      font-size: 16px;
      font-weight: 700;
    }
    .newsa {
      margin-top: 6px;
      font-size: 10px;
    }
    img {
      width: 50px;
      margin-right: 15px;
    }
  }
}

.bosfs {
  margin-top: 15px;
  border-radius: 15px;
  padding: 4px 12px;
  box-sizing: border-box;
  width: 90%;
  margin: 0 auto;
  margin-top: 15px;
  background-size: 100% 100%;
  -webkit-box-shadow: 0 0.04rem 0.2rem 0 rgb(93 114 162 / 11%);
  box-shadow: 0 0.04rem 0.2rem 0 rgb(93 114 162 / 11%);
  .hgsw {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 40px;
    box-sizing: border-box;
    border-bottom: 1px solid #f5f0f0;
    .firsimg {
      width: 24px;
    }
    .tit {
      color: #4e6693;
      margin-left: 10px;
    }
    .tisf {
      flex: 1;
      margin: 0 12px;
      color: #a2aec8;
      text-align: right;
    }
    .rigiong {
      width: 6px;
    }
  }
}


</style>
