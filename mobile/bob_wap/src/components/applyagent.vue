<template>
  <div data-v-f531b812="" class="app app-ti_green">
    <div data-v-8a75a126="" data-v-f531b812="" class="header">
      <div data-v-8a75a126="" class="header__top-wrapper">
        <div data-v-8a75a126="" class="van-nav-bar van-nav-bar--fixed fixed-top nav-header">
          <div class="van-nav-bar__content">
            <div class="van-nav-bar__left" @click="$router.back()">
              <i class="van-icon van-icon-arrow-left van-nav-bar__arrow"></i>
            </div>
            <div class="van-nav-bar__title van-ellipsis">合营计划</div>
          </div>
        </div>
      </div>
    </div>
    <div class="pahsn">
      <img data-v-56fcd294="" src="/static/image/__al__title01.7a3975958589d48b22c30b3b976a95fc.png" style="display: block; width: 80%; margin: 0 auto; padding-top: 30px" />
      <img data-v-56fcd294="" src="/static/image/__al__person01.8b896040f87c2dfffa7e8de68ed19c42.png" style="display: block; width: 100%; margin: 0 auto" />
      <div @click="$parent.openKefu" class="zixun">
        <img data-v-56fcd294="" src="/static/image/16044962635685155.png" />
        <div class="cnets">
          <div class="tos">合营部</div>
          <div class="bos">立即咨询</div>
        </div>
        <div class="zusnb">咨询</div>
      </div>
      <div class="bsd">
        <van-form>
          <van-field label="用户名" v-model="$store.state.userInfo.username" disabled />
          <van-field label="真实姓名" v-model="$store.state.userInfo.realname" disabled />
          <van-field label="联系方式" v-model="info.mobile" placeholder="请输入您的联系方式" />
          <van-field label="申请理由" v-model="info.apply_info" placeholder="请输入申请说明" />
        </van-form>
        <van-button style="background:#cf866b;color:#fff" @click="shenqing" block >加入我们</van-button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'applyagent',
  data() {
    return {
      info: {},
    };
  },
  created() {
    let that = this;
  },
  methods: {
    shenqing() {
      let that = this;
      let info = that.info;
      let regExp = /^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;
      if (!regExp.test(info.mobile)) {
        that.$parent.showTost(0, '请输入正确手机号');
        return;
      }

      if (!info.apply_info) {
        that.$parent.showTost(0, '请输入申请理由');
        return;
      }

      that.$parent.showLoading();
      that.$apiFun
        .post('/api/applyagentdo', info)
        .then(res => {
          that.$parent.showTost(1, res.message);
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
.pahsn {
  background: url(/static/image/__al__background.2e29d452d69738493237414076a048d3.png) no-repeat;
  background-size: 100% 100%;
  margin-top: 40px;
  min-height: 100vh;
  width: 100%;
}
.zixun {
  width: 88%;
  margin: 0 auto;
  background: #fdfdfd;
  border-radius: 10px;
  display: flex;
  align-items: center;
  padding: 10px;
  position: relative;
  margin-top: -96px;
  opacity: 0.9;
  img {
    width: 30px;
    margin-right: 10px;
  }
  .cnets {
    flex: 1;
    border-left: 1px solid #ccc;
    padding-left: 10px;

    .tos {
      font-size: 12px;
      color: #999;
    }
    .bos {
      font-size: 14px;
      color: #1e1e1e;
    }
  }
  .zusnb {
    width: 60px;
    height: 20px;
    line-height: 20px;
    text-align: center;
    font-size: 12px;
    color: #fff;
    background-color: #cf866b;
    border-radius: 4px;
  }
}

.bsd {
  width: 90%;
  margin: 0 auto;
  background: #fdfdfd;
  border-radius: 10px;
  padding: 20px 10px;
  margin-top: 10px;
}
</style>
