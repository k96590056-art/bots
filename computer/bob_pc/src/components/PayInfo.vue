<template>
  <div id="app-container" v-if="payInfo.deposit_no">
    <div class="n1sHi1_gDox2Q8ezpdZH5">
      <div class="_3nvVZbeP_KKFGRKZ3SxfW4" style="">
        <div class="_2uM338LxSZnEUB6bCz4axi">
          <div>
            <div class="_2HCazjAzieT4L96opZihj9">剩余支付时间：</div>
            <div class="_1ar3pTm_JYB-u2qWpt6e_z"></div>
          </div>
          <div class="_3ATbZ84037ZhIQDiT-2nyD"></div>
          <div class="_3CQ4hAT8Rn9-ZCUrRPjV7M">
            <div class="_9SJLkU9QpzPYzWOZY3Rqk">
              <span>订单编号：</span><span>{{ payInfo.deposit_no }}</span>
            </div>
            <div class="_9SJLkU9QpzPYzWOZY3Rqk" v-if="type == 'usdtpay'">
              <span>当前汇率：</span><span class="_3ZmEMAaXkrKqQ113p9F_uq">1 {{ payInfo.cardlist.content }} = {{ payInfo.info.usdtrate }} CNY</span>
            </div>
            <div class="_9SJLkU9QpzPYzWOZY3Rqk" v-if="type == 'usdtpay'">
              <span>充值数量：</span><span class="_3ZmEMAaXkrKqQ113p9F_uq">{{ payInfo.info.real_money }} {{ payInfo.cardlist.content }}</span>
            </div>
            <div class="_9SJLkU9QpzPYzWOZY3Rqk">
              <span>充值金额：</span><span class="_3ZmEMAaXkrKqQ113p9F_uq">{{ payInfo.info.amount }} CNY</span>
            </div>
          </div>
        </div>
        <div class="_2xx45NdpwT5KPaYgeMsdYE">
          <div class="_2q5dKVSXvbkX8syq1-Hl2W">
            <div class="_3VdBrxwboIJ2v_ON4OCRjS">{{ payInfo.info.paytype }}</div>
            <div class="_3785zJoWCXtLIHtAS_cA1C">
              <span>{{ payInfo.info.real_money }} {{ type == 'usdtpay' ? payInfo.cardlist.content : '' }}</span>
              <!-- <div class="f9bxdbnqcRudnKSP3y-bt" v-if="type =='usdtpay'" @click="doCopy(payInfo.info.real_money)">复制</div> -->
            </div>
            <div class="_1QI9TzXm1Ybnj9BJm4UQ7V">请注意：您的实际到账金额要与此金额完全一致，否则无法及时到账</div>
            <div class="_21R49Y-pIno9CckiAjl0Id">
              <div class="_1f6333Dfetv7YoltY9pL-t">{{ payInfo.cardlist.content }}</div>
              <div class="_2_w4FbHMpnRRSdxBYtSL0e">
                <img style="height: 210px; width: 210px" :src="payInfo.cardlist.payimg" alt="" />
              </div>
            </div>
            <div class="_3sbSiVFgNQ2SK94qDJaI90" v-if="type == 'usdtpay'">
              <span class="_2Vrrgjd_XLAifnNQgYu0NQ">{{ payInfo.cardlist.mch_id }}</span>
              <div class="f9bxdbnqcRudnKSP3y-bt" style="cursor: pointer" @click="doCopy(payInfo.cardlist.mch_id)">复制</div>
            </div>
          </div>
          <div class="_2eg9lTattt1yp1qvWhgifb">
            <div class="_2-xkzXq0hmbuW9CZeDhVx_">温馨提示</div>
            <div class="HU1qShwkRp6KtCq22dC6O" v-if="type != 'usdtpay'">
              1. 请勿向上述地址充值任何非<span class="M8ZjTEuW7Q3mUpU0PbEeW">{{ payInfo.cardlist.content }}</span
              >资产，否则资产将会丢失；<br />2. 请务必确认电脑及浏览器安全，防止信息被篡改或泄密。
              <br />
            </div>
            <div class="HU1qShwkRp6KtCq22dC6O" v-if="type == 'usdtpay'">
              1. 请勿向上述地址充值任何非<span class="M8ZjTEuW7Q3mUpU0PbEeW">{{ payInfo.cardlist.content }}</span
              >资产，否则资产将会丢失；<br />2. 向上述地址充值后，需要网络节点区块确认，链上网络确认后到账； <br />3. 请务必确认电脑及浏览器安全，防止信息被篡改或泄密。 <br />4. {{ type == 'usdtpay' ? payInfo.cardlist.content : 'TRC20' }}协议：请使用<span style="color: red">
                {{ type == 'usdtpay' ? (payInfo.info.bank == 'TRC20' ? '波场链' : '以太坊链') : '波场链' }}（{{ type == 'usdtpay' ? payInfo.info.bank : 'TRC20' }}协议） </span
              >进行交易 ，其他智能链充值造成的不到账，金额损失自己承担。
            </div>
          </div>
          <div style="display: flex; align-items: center; justify-content: center; height: 30px; margin-top: 25px">
            <el-button type="success" @click="$router.push({ path: '/mine/transRecord' })">已完成付款</el-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'payInfo',
  data() {
    return {
      payInfo: {},
      daoTime: null,
      m: 0,
      s: 0,
      type: null,
    };
  },
  components: {},
  created() {
    let that = this;

    var query = that.$route.query;
    if (query.deposit_no) {
      that.getpayinfo(query.deposit_no);
    }
  },
  mounted() {},
  methods: {
    doCopy(msg) {
      let cInput = document.createElement('input');
      cInput.style.opacity = '0';
      cInput.value = msg;
      document.body.appendChild(cInput);
      // 选取文本框内容
      cInput.select();

      // 执行浏览器复制命令
      // 复制命令会将当前选中的内容复制到剪切板中（这里就是创建的input标签）
      // Input要在正常的编辑状态下原生复制方法才会生效
      document.execCommand('copy');

      // 复制成功后再将构造的标签 移除
      this.showTost('复制成功！');
    },
    getpayinfo(deposit_no) {
      let that = this;
      that.$apiFun.post('/api/payinfo', { deposit_no }).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.payInfo = res.data;
          that.type = res.message;
          that.countTime();
        }
      });
    },
    countTime() {
      //获取当前时间
      let that = this;
      var date = new Date();
      var now = date.getTime(); //当前时间
      //   创建时间
      let created_at = that.payInfo.info.created_at;
      let createdTime = new Date(created_at).getTime();
      //设置截止时间
      var end = createdTime + 1000 * 60 * 60;
      //时间差
      var leftTime = end - now;

      //定义变量 d,h,m,s保存倒计时的时间
      if (leftTime >= 0) {
        // that.h = Math.floor((leftTime / 1000 / 60 / 60) % 24);
        that.m = Math.floor((leftTime / 1000 / 60) % 60);
        that.s = Math.floor((leftTime / 1000) % 60);
      } else {
        $('._1ar3pTm_JYB-u2qWpt6e_z').html('00:00');
        return;
      }
      let m = that.m >= 10 ? that.m : `0${that.m}`;
      let s = that.s >= 10 ? that.s : `0${that.s}`;
      $('._1ar3pTm_JYB-u2qWpt6e_z').html(`${m}:${s}`);
      //递归每秒调用countTime方法，显示动态时间效果
      setTimeout(this.countTime, 1000);
    },
    showTost(title) {
      $('body').append(`
            <div class='ant-message' style='top: 400px;'><span><div class='ant-message-notice'><div class='ant-message-notice-content'>
            <div class='ant-message-custom-content ant-message-info'><span role='img' aria-label='info-circle' class='anticon anticon-info-circle'>
            <svg viewBox='64 64 896 896' focusable='false' data-icon='info-circle' width='1em' height='1em' fill='currentColor' aria-hidden='true'>
            <path d='M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm32 664c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8V456c0-4.4 3.6-8 8-8h48c4.4 0 8 3.6 8 8v272zm-32-344a48.01 48.01 0 010-96 48.01 48.01 0 010 96z'></path></svg></span><span>
            ${title}
            </span></div></div></div></span>
            </div>`);
      setTimeout('$(".ant-message").detach()', 2000);
    },
  },
  beforeDestroy() {
    let that = this;
    if (that.countTime) {
      clearInterval(that.countTime);
    }
    that.countTime = null;
  },
};
</script>

<style lang="scss" scoped>
</style>
