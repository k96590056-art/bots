<template>
  <div class="ant-spin-nested-loading">
    <div class="loading" v-if="lodingShow">
      <div class="ant-spin ant-spin-spinning _2PSsJSST">
        <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
      </div>
    </div>
    <div :class="lodingShow ? 'ant-spin-container ant-spin-blur' : 'ant-spin-container'">
      <div class="_1bmWvOD_" v-if="vipLis.length > 0 && $store.state.userInfo">
        <div class="_4ICMeQUV">
          <div class="T5pPAuRQ">我的VIP等级</div>
        </div>
        <p class="_1sn8gNIZ">
          我的VIP等级 :&nbsp;<span>VIP{{ $store.state.userInfo.vip }}</span>
        </p>
        <div class="_1HdjKA9J">
          <div class="_3WYomrxF">
            <div class="_2bVqnNDW">
              <img
                src="data:image/png;base64,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"
                alt=""
              />
              <div>VIP{{ $store.state.userInfo.vip }}</div>
            </div>
            <div class="L_D8PDRY">
              <div class="_2wbl037f" :style="`width: ${bfNum}%`"></div>
              <!-- Math.round((3.6666)*100)/100 -->
              <div class="_1KmXNsqI" style="left: calc(0% - 17px)">
                <span>{{bfNum }}%</span>
              </div>
              <!-- <div class="_1KmXNsqI" style="left: calc(0% - 17px)"><span>{{$store.state.userInfo./vipLis[$store.state.userInfo.vip*1+1].flow}}%</span></div> -->
            </div>
            <div class="_2bVqnNDW">
              <img src="image/vip_icon_1_bright-9255.png" alt="" />
              <div>VIP{{ $store.state.userInfo.vip * 1 + 1 }}</div>
            </div>
          </div>
          <a href="javascript:;" @click="goNav('/vipInfo')">
            <div class="_349CzCYy xJQe3jRu _3IRjfGT0"><span>查看VIP详情</span></div>
          </a>
        </div>
        <div class="_2VuzJz7n">
          提示：升级还需<span>&nbsp; ¥{{ vipLis[$store.state.userInfo.vip * 1 ].flow }}元&nbsp;</span>流水（每日16点更新）
        </div>
      </div>
      <!-- <div class="zyT36KE1">
        <div class="_4ICMeQUV">
          <div class="T5pPAuRQ">我的VIP特权</div>
        </div>
        <div class="_1eP4Wfkw">
          <div class="_3di95a3H">
            <div class="_1HjYPvvp">
              <p>日提款次数</p>
              <p>5次</p>
            </div>
            <div class="_1HjYPvvp">
              <p>每日提款额度</p>
              <p>￥200000.00元</p>
            </div>
            <div class="_1HjYPvvp">
              <p>升级礼金</p>
              <p>￥0.00元</p>
            </div>
          </div>
          <div class="_3di95a3H">
            <div class="_1HjYPvvp bigItemView">
              <p>生日礼金</p>
              <p>￥0.00元</p>
            </div>
            <div class="_1HjYPvvp bigItemView">
              <p>每周免费红包</p>
              <p>￥0.00元</p>
            </div>
          </div>
        </div>
      </div> -->
      <div class="_2Y7hWd_P" v-if="vipLis.length > 0" >
        <div class="_4ICMeQUV">
          <div class="T5pPAuRQ">我的VIP详情</div>
        </div>
        <div class="_3a08phY2">
          <div class="_3di95a3H">
            <div class="_1HjYPvvp">
              <p>等级要求</p>
            </div>
            <div class="_1HjYPvvp pQE4kzXH">
              <p>累计流水<br/>
                {{vipLis[$store.state.userInfo.vip*1 -1].flow}}</p>
              <p>累计充值<br/>{{vipLis[$store.state.userInfo.vip*1 -1].recharge}}</p>
            </div>
          </div>
          <div class="_3di95a3H" >
            <div class="_1HjYPvvp">
              <p>VIP返水比例</p>
            </div>
            <div class="_1HjYPvvp returnBack">
              <p>真人返水</p>
              <p>{{ vipLis[$store.state.userInfo.vip*1 -1].realperson }}%</p>
            </div>
            <div class="_1HjYPvvp returnBack">
              <p>电子返水</p>
              <p>{{ vipLis[$store.state.userInfo.vip*1 -1].electron }}%</p>
            </div>
            <div class="_1HjYPvvp returnBack">
              <p>棋牌返水</p>
              <p>{{ vipLis[$store.state.userInfo.vip*1 -1].joker }}%</p>
            </div>
            <div class="_1HjYPvvp returnBack">
              <p>体育返水</p>
              <p>{{ vipLis[$store.state.userInfo.vip*1 -1].sport }}%</p>
            </div>
            <div class="_1HjYPvvp returnBack">
              <p>彩票返水</p>
              <p>{{ vipLis[$store.state.userInfo.vip*1 -1].lottery }}%</p>
            </div>
            <div class="_1HjYPvvp returnBack">
              <p>电竞返水</p>
              <p>{{ vipLis[$store.state.userInfo.vip*1 -1].e_sport }}%</p>
            </div>
          </div>
        </div>
        <p class="_2Mb1FwnA">注：以上为最高返水比例，具体返水金额请以实际游戏为准，其它疑问请联系7*24在线客服咨询。</p>
        <a class="Pn0Nku_-" href="javascript:;">
          <div class="_349CzCYy xJQe3jRu" @click="goNav('/vipInfo')" style="width: 150px"><span>进入查看vip特权</span></div>
        </a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'transRecord',
  data() {
    return { vipLis: [], lodingShow: true ,bfNum:0};
  },
  created() {
    let that = this;
    that.uservip();
  },
  methods: {
    getbfNum() {
      let that = this;
      let num = 0; //当前vip充值钱
      let vip = that.$store.state.userInfo.vip * 1; //当前vip等级
      that.vipLis.forEach((el, index) => {
        console.log();
        if (index == vip) {
          num = el.recharge * 1;
        }
      });
      let userMey = that.$store.state.userInfo.paysum * 1;
      let bfNum = userMey == 0 || num == 0 ? 0 : Math.round((userMey / num) * 100) ;
      that.bfNum = bfNum > 100 ? 100 : bfNum ;
    },
    goNav(url) {
      let that = this;
      // let urlStr = url.split('?')[0];
      if (url == this.$route.path) {
        return;
      }
      this.url = url;
      this.$router.push({ path: url });
    },
    uservip() {
      let that = this;
      that.showloading();
      that.$apiFun.post('/api/uservip', {}).then(res => {
        if (res.code != 200) {
          that.showTost(res.message);
        }
        if (res.code == 200) {
          that.vipLis = res.data;
          that.getbfNum();

        }
        that.hideloading();
      }).catch(res=>{
          that.hideloading();
      });
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
    hideloading() {
      this.lodingShow = false;
    },
    showloading() {
      this.lodingShow = true;
    },
  },
  mounted() {
    // --------  账户中心------------------------------------------------------------------
    //触发修改头像
    $('._30Ip3J8d').click(function () {
      openTouxiang();
    });
    //选择头像
    $('._1LEonN-h li').click(function () {
      $(this).addClass('_2M-yJFJL').siblings().removeClass('_2M-yJFJL');
      var src = $(this).find('img').attr('src');
      $('.img-preview').attr('src', src);
    });
    //修改头像弹窗
    function openTouxiang() {
      $('.touxiang').show();
      $('.touxiang ._1euN-aP1').show();
    }
    //关闭弹窗
    function closebox() {
      $('.touxiang').hide();
      $('._1euN-aP1').hide();
    }
  },
};
</script>
<style lang="scss" scoped>
._3WYomrxF ._1KmXNsqI {
  width: 56px;
}
</style>
