<template>
  <div style="width: 100%; min-height: 100vh; background: rgb(237, 241, 255)">
    <van-nav-bar style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ede9e7" title="卡片管理" left-arrow @click-left="$router.back()" />
    <div style="height: 46px"></div>

    <van-tabs v-model="type" >
      <van-tab title="虚拟币" name='1'>
        <div class="lis" v-for="(item, index) in usdssLis" :key="index">
          <img class="lefs" src="/static/image/1595237922936176.png" alt="" />
          <div class="cest">
            <div class="type">{{ item.bank }}-{{ item.bank_owner }}</div>
            <div class="num">
              <span>****</span><span>****</span><span>****</span><span>{{ item.bank_no.substr(-4) }}</span>
            </div>
          </div>
          <img class="rigss" @click="delCard(item.id)" src="/static/style/wdb_icon.png" alt="" />
        </div>
        <div class="adds">
          <van-button v-if="usdssLis.length < 5" plain  style="width: 100%" @click="$parent.goNav('/addUsdtCard')">添加USDT地址</van-button>
          <div class="btntits">最多支持添加5个地址</div>
        </div>
      </van-tab>
      <van-tab title="银行卡" name='2'>
        <div class="lis" v-for="(item, index) in usercardLis" :key="index">
          <img class="lefs" :src="item.ico" alt="" />
          <div class="cest">
            <div class="type">{{ item.bank }}</div>
            <div class="type">{{ item.bank_owner }}</div>
            <!-- <div class="type">{{ item.bank_address }}</div> -->
            <div class="num">
              <span>****</span><span>****</span><span>****</span><span>{{ item.bank_no.substr(-4) }}</span>
            </div>
          </div>
          <img class="rigss" @click="delCard(item.id)" src="/static/style/wdb_icon.png" alt="" />
        </div>
        <div class="adds">
          <van-button v-if="usercardLis.length < 5" @click="$parent.goNav('/addBankCard')" plain  style="width: 100%">添加银行卡</van-button>
          <div class="btntits">最多支持添加5张银行卡</div>
        </div>
      </van-tab>
    </van-tabs>
  </div>
</template>
<script>
export default {
  name: 'wallet',
  data() {
    return {
      usercardLis: [],
      usdssLis: [],type:1
    };
  },
  created() {
    let that = this;
        var query = that.$route.query;
    if (query.type) {
      that.type = query.type;
    }
    that.getUsercard();
    that.getUsdssList();
  },
  methods: {
    delCard(id) {
      let that = this;
      that.$dialog
        .confirm({
          title: '温馨提示',
          message: '确定要解除绑定该卡片吗？',
        })
        .then(() => {
          that.$parent.showLoading();

          that.$apiFun.post('/api/delcard', { id }).then(res => {
            if (res.code != 200) {
              that.$parent.showTost(0, res.message);
            }
            that.$parent.hideLoading();

            if (res.code == 200) {
              that.$parent.showTost(1, '解绑成功');
              that.getUsercard();
              that.getUsdssList();
            }
          });
        })
        .catch(() => {});
    },

    getUsercard() {
      let that = this;
      this.$parent.showLoading();

      that.$apiFun.post('/api/getcard', { type: 1 }).then(res => {
        if (res.code == 200) {
          that.usercardLis = res.data;
        }
        this.$parent.hideLoading();
      });
    },
    getUsdssList() {
      let that = this;
      this.$parent.showLoading();

      that.$apiFun.post('/api/getcard', { type: 2 }).then(res => {
        if (res.code == 200) {
          that.usdssLis = res.data;
        }
        this.$parent.hideLoading();
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
// @import '../../static/css/chunk-3963b0d4.845808c9.css';
.adds {
  width: 60%;
  margin: 0 auto;
  margin-top: 100px;
  .btntits {
    text-align: center;
    margin-top: 20px;
    font-size: 0.28rem;
    color: #6c6e82;
  }
}
.lis {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 95%;
  margin: 0 auto;
  margin-top: 20px;
  box-sizing: border-box;
  padding: 10px 25px;
  min-height: 80px;
  border-radius: 10px;
  position: relative;
  background: #fff;
  .lefs {
    width: 1.5rem;
  }
  .cest {
    flex: 1;
    margin: 0 20px;
    .type {
      font-size: 0.4rem;
      font-weight: 700;
      color: #98a8c5;
      margin-top: 6px;
    }
    .num {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 6px;
      color: #98a8c5;
      span {
        font-size: 0.6rem;
      }
    }
  }
  .rigss {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 0.6rem;
  }
}
</style>
