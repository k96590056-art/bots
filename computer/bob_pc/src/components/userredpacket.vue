<template>
  <div style="background: url(/static/image/bg123456.jpg) top center no-repeat !important">
    <input type="hidden" id="startDate" value="2022-06-18" /> <input type="hidden" id="endDate" value="2022-06-18" /> <input type="hidden" id="startTime" value="14:00:00" /> <input type="hidden" id="endTime" value="15:59:59" />
    <input type="hidden" id="currentDateTime" value="2022-06-18 16:13:44" /> <input type="hidden" id="redPacketStatus" value="END" /> <input type="hidden" id="activityTimeId" value="" /> <input type="hidden" id="memberType" value="0" /> <input type="hidden" id="amount1" value="0" />
    <input type="hidden" id="amount2" value="00" /> <input type="hidden" id="isLocal" value="0" /> <input type="hidden" id="isWindow" value="0" /> <input type="hidden" id="windowHeight" value="" /> <input type="hidden" id="windowWidth" value="" />
    <div class="redEnveBody">
      <div class="redEnveBodyToo">
        <div class="redEnveBodyMain center">
          <div class="redEnveBodyTop">
            <div class="pen"><img src="/static/image/pen.png" /></div>
            <div class="hongbao"></div>
            <div class="jinbi"></div>
            <div class="jinbi2"></div>
            <div class="jinbi3"></div>
            <div class="caidai"></div>
            <div class="lcaidai"></div>
          </div>
          <div class="redEnveFont"><img alt="" src="/static/image/qianghb.png" /></div>
          <div class="toddyTotal"></div>
          <div class="redEnveTime" v-if="false">
            <div class="time">
              <span id="dd">00</span>: <span id="hh">00</span>
              <div class="redEnveClock redEnveClock2">
                <div id="ready" style="display: none">
                  <div data-wow-duration="0.35s" data-wow-delay="0.35s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.35s; animation-delay: 0.35s; animation-name: zoomInLeft">始</div>
                  <div data-wow-duration="0.30s" data-wow-delay="0.30s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.3s; animation-delay: 0.3s; animation-name: zoomInLeft">开</div>
                  <div data-wow-duration="0.25s" data-wow-delay="0.25s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.25s; animation-delay: 0.25s; animation-name: zoomInLeft">包</div>
                  <div data-wow-duration="0.20s" data-wow-delay="0.20s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.2s; animation-delay: 0.2s; animation-name: zoomInLeft">红</div>
                  <div data-wow-duration="0.15s" data-wow-delay="0.15s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.15s; animation-delay: 0.15s; animation-name: zoomInLeft">离</div>
                  <div data-wow-duration="0.10s" data-wow-delay="0.10s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.1s; animation-delay: 0.1s; animation-name: zoomInLeft">距</div>
                </div>
                <div id="starting" style="display: none">
                  <div data-wow-duration="0.35s" data-wow-delay="0.35s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.35s; animation-delay: 0.35s; animation-name: zoomInLeft">束</div>
                  <div data-wow-duration="0.30s" data-wow-delay="0.30s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.3s; animation-delay: 0.3s; animation-name: zoomInLeft">结</div>
                  <div data-wow-duration="0.25s" data-wow-delay="0.25s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.25s; animation-delay: 0.25s; animation-name: zoomInLeft">包</div>
                  <div data-wow-duration="0.20s" data-wow-delay="0.20s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.2s; animation-delay: 0.2s; animation-name: zoomInLeft">红</div>
                  <div data-wow-duration="0.15s" data-wow-delay="0.15s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.15s; animation-delay: 0.15s; animation-name: zoomInLeft">离</div>
                  <div data-wow-duration="0.10s" data-wow-delay="0.10s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.1s; animation-delay: 0.1s; animation-name: zoomInLeft">距</div>
                </div>
                <div id="red-packet-finish" style="display: none">
                  <div data-wow-duration="0.30s" data-wow-delay="0.30s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.3s; animation-delay: 0.3s; animation-name: zoomInLeft">完</div>
                  <div data-wow-duration="0.25s" data-wow-delay="0.25s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.25s; animation-delay: 0.25s; animation-name: zoomInLeft">抢</div>
                  <div data-wow-duration="0.20s" data-wow-delay="0.20s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.2s; animation-delay: 0.2s; animation-name: zoomInLeft">已</div>
                  <div data-wow-duration="0.15s" data-wow-delay="0.15s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.15s; animation-delay: 0.15s; animation-name: zoomInLeft">包</div>
                  <div data-wow-duration="0.10s" data-wow-delay="0.10s" class="wow zoomInLeft animated" style="visibility: visible; animation-duration: 0.1s; animation-delay: 0.1s; animation-name: zoomInLeft">红</div>
                </div>
                <div id="finish" style="display: block">
                  <div data-wow-duration="0.30s" data-wow-delay="0.30s" class="wow zoomInLeft" style="visibility: visible; animation-duration: 0.3s; animation-delay: 0.3s; animation-name: zoomInLeft">束</div>
                  <div data-wow-duration="0.25s" data-wow-delay="0.25s" class="wow zoomInLeft" style="visibility: visible; animation-duration: 0.25s; animation-delay: 0.25s; animation-name: zoomInLeft">结</div>
                  <div data-wow-duration="0.20s" data-wow-delay="0.20s" class="wow zoomInLeft" style="visibility: visible; animation-duration: 0.2s; animation-delay: 0.2s; animation-name: zoomInLeft">已</div>
                  <div data-wow-duration="0.15s" data-wow-delay="0.15s" class="wow zoomInLeft" style="visibility: visible; animation-duration: 0.15s; animation-delay: 0.15s; animation-name: zoomInLeft">包</div>
                  <div data-wow-duration="0.10s" data-wow-delay="0.10s" class="wow zoomInLeft" style="visibility: visible; animation-duration: 0.1s; animation-delay: 0.1s; animation-name: zoomInLeft">红</div>
                </div>
              </div>
              <span id="mm">00</span>: <span id="ss">00</span>
            </div>
            <div class="time2"><span>天</span> <span>时</span> <span>分</span> <span>秒</span></div>
          </div>
          <div class="receiveTimes" style="margin-top: 30px">
            <p style="text-align: center">
              剩余领取次数&nbsp;<span id="remainNum" class="yellow" style="font-size: 32px">{{ userredpacket.sendnums < 0 ? 0 : userredpacket.sendnums }}</span
              >&nbsp;次，已领取&nbsp;<span id="currentNum" class="yellow" style="font-size: 32px">{{ userredpacket.acquirednum }}</span
              >&nbsp;次
            </p>
          </div>
          <div class="currReceiveTimes">
            <p style="text-align: center">
              当前最多可领取&nbsp;<span class="yellow3" style="font-size: 29px">{{ userredpacket.max_times }}</span
              >&nbsp;次， <span id="maxMsg"> 快去满足条件吧！ </span>
            </p>
          </div>
          <div class="redEnveButtons" @click="changShow"></div>
          <div class="activityInfo" style="margin-top: 230px">
            <div class="activityTop wow zoomIn" style="visibility: visible; animation-name: zoomIn"></div>
            <table id="activityTable" v-if="false">
              <tbody>
                <tr>
                  <td style="border-radius: 17px 0px 0px">活动日期（美东时间）</td>
                  <td>时间段（美东时间）</td>
                  <td>累计充值金额</td>
                  <td style="border-radius: 0px 17px 0px 0px">红包次数</td>
                </tr>
                <tr>
                  <td rowspan="5" class="qwea">
                    2021-10-10 ~ 2021-10-30 <br />（每天）
                    <div id="22943"></div>
                  </td>
                  <td>22:00:00 - 23:59:59</td>
                  <td>1000+</td>
                  <td>1</td>
                </tr>
                <tr>
                  <td style="display: none">
                    2021-10-10 ~ 2021-10-30 <br />（每天）
                    <div id="22943"></div>
                  </td>
                  <td>22:00:00 - 23:59:59</td>
                  <td>5000+</td>
                  <td>3</td>
                </tr>
                <tr>
                  <td style="display: none">
                    2021-10-10 ~ 2021-10-30 <br />（每天）
                    <div id="22943"></div>
                  </td>
                  <td>22:00:00 - 23:59:59</td>
                  <td>10000+</td>
                  <td>5</td>
                </tr>
                <tr>
                  <td style="display: none">
                    2021-10-10 ~ 2021-10-30 <br />（每天）
                    <div id="22943"></div>
                  </td>
                  <td>22:00:00 - 23:59:59</td>
                  <td>50000+</td>
                  <td>8</td>
                </tr>
                <tr>
                  <td style="display: none">
                    2021-10-10 ~ 2021-10-30 <br />（每天）
                    <div id="22943"></div>
                  </td>
                  <td>22:00:00 - 23:59:59</td>
                  <td>100000+</td>
                  <td>10</td>
                </tr>
              </tbody>
            </table>
            <table id="activityTable" v-if="userredpacket.rules.length > 0">
              <tbody>
                <tr>
                  <td style="border-radius: 17px 0px 0px">活动时间</td>
                  <td>累计充值金额</td>
                  <td style="border-radius: 0px 17px 0px 0px">红包次数</td>
                </tr>
                <tr v-for="(item, index) in userredpacket.rules" :key="index">
                  <td>{{ item.start_time }} ~ {{ item.end_time }}</td>
                  <td>{{ item.day_flow }}-{{ item.flow_money }}</td>
                  <td>{{ Math.floor(item.recharge) }}</td>
                </tr>
              </tbody>
            </table>
            <div class="activityBot wow flipInX" style="visibility: visible; animation-name: flipInX;line-height: 2;">
              <h3 class="yellow">领取规则：</h3>
              <p>1.抢到红包后，系统自动派彩，<span class="yellow">秒到账</span>，达到流水倍数即可取款；</p>
              <p>2.领取红包条件：充值金额需要在规定的活动日期（美东时间）范围内，根据充值累计金额，获取抢红包次数，即可抢对应次数的红包；</p>
            </div>
          </div>
          <div class="h400"></div>
          <div class="activityDes">
            <div class="activityDesTop wow zoomIn" style="visibility: visible; animation-name: zoomIn"></div>
            <div class="activityDesMain">
              <p style="text-align: center"><strong>{{$store.state.appInfo.title}}</strong></p>
              <p>
                <strong>注意：<strong style="white-space: normal">抢红包</strong>北京时间为每天早上 10点到12点，存款计算为前一天12点到今天10点，谢谢~</strong><br />每日百万现金红包！存款越多，机会越多，红包享不停，惊喜抢不停，还等什么？快快叫上好友一起分享吧！！<br />
              </p>
              <p>1、会员必须在指定的活动日期（美东时间）范围内，根据充值累计金额，即可获得对应抢红包次数。若在规定的时间范围内没有达到存款金额范围，则不计算抢红包次数，逾期作废！</p>
              <p>2、所有的活动优惠特为玩家而设，如发现任何团体或个人，以不诚实的方式套取红利或任何威胁、滥用公司优惠等行为，公司保留冻结、取消该团体或个人账户及账户结余的权利。</p>
              <p>3、{{$store.state.appInfo.title}}保留所有解释权，在任何时候都可以更改、停止、取消优惠活动。</p>
              <p><br /></p>
            </div>
          </div>
        </div>
      </div>
      <div class="botLeft wow bounceInLeft" style="visibility: visible; animation-name: bounceInLeft"><img src="/static/image/botLeft.png" /></div>
      <div class="botright"><img src="/static/image/botRight.png" class="wow bounceInRight" style="visibility: visible; animation-name: bounceInRight" /></div>
    </div>
    <div id="box1" picfloat="right" class="rightFloat" style="position: fixed; z-index: 1000; top: 365px; right: 0.25px; width: 183px">
      <!-- myService -->
      <a href="javascript:;" class="myRedEnves" @click="$parent.goNav('/mine/welfare')"></a> <a href="javascript:;" @click="$parent.openKefu" class="myService"></a>
      <!-- <a href="javascript:;" id="currenTimePeriod" class="currenTimePeriod"> <span class="timePeriodTitle">当前时间段</span> <span class="currenTime">{{userredpacket.datetime}}</span> </a> -->
    </div>

    <!-- 红包还未开始 已结束 -->
    <div class="weikaishi divIndex" v-if="weikaishi">
      <p>活动还没开始，请静待活动开始。</p>
      <a href="javascript:;" @click="closeAll" class="close"></a>
    </div>
    <div class="qiangwan divIndex" v-if="end">
      <p>请静待下次活动。</p>
      <a href="javascript:;" @click="closeAll" class="close"></a>
    </div>
    <!-- 中奖了 -->
    <div class="zhongjiang divIndex" v-if="zhongjiang">
      <p>恭喜您</p>
      <p>
        抢到<span id="redPacketAmount" class="yellow bigFont">{{ mey }}</span
        >元
      </p>
      <a href="javascript:;" @click="closeAll" class="close"></a>
    </div>
    <!-- henbaoqian  很抱歉 -->
    <div class="henbaoqian divIndex" v-if="henbaoqian">
      <p id="henbaoqian">{{ message }}</p>
      <div id="viewRules" class="rules" @click="$parent.goNav('/mine/deposit')">立即充值</div>
      <a href="javascript:;" @click="closeAll" class="close"></a>
    </div>
  </div>
</template>
<script>
export default {
  name: 'userredpacket',
  data() {
    return { show: false, redpacketList: [], page: 1, redpacketShowData: {}, userredpacket: { rules: [] }, weikaishi: false, end: false, mey: 0, zhongjiang: false, henbaoqian: false, message: '' };
  },
  created() {
    let that = this;
    that.getuserredpacket();
  },
  methods: {

    closeAll() {
      this.show = false;
      this.weikaishi = false;
      this.end = false;
      this.zhongjiang = false;
      this.henbaoqian = false;
      this.message = '';
    },
    changShow() {
      let that = this;

      // userredpacket.redPacketStatus  红包状态 READY-未开始 STARTING-进行中 END-结束
      // if (that.userredpacket.redPacketStatus == 'READY') {
      //   this.weikaishi = true;
      // }
      // if (that.userredpacket.redPacketStatus == 'END') {
      //   this.end = true;
      // }
      // if (that.userredpacket.redPacketStatus == 'STARTING') {
      //   that.getwelfare();
      // }
      if (that.userredpacket.sendnums <= 0) {
        that.henbaoqian = true;
        that.message = '您暂未达到领取条件，快去完成吧！';
        return;
      }
      that.getwelfare();
    },
    getwelfare() {
      let that = this;
      that.$parent.showLoading();
      that.$apiFun
        .post('/api/douserredpacket', {})
        .then(res => {
          console.log(res);
          if (res.code == 200) {
            that.mey = res.data.redpacketmoney;
            that.getuserredpacket();
            that.zhongjiang = true;
          } else {
            that.henbaoqian = true;
            that.message = res.message;
          }

          that.$parent.hideLoading();
        })
        .catch(() => {
          that.$parent.showTost(0, '服务器异常，请稍后再试');
          that.$parent.hideLoading();
        });
    },

    getuserredpacket() {
      let that = this;
      that.$parent.showLoading();

      that.$apiFun.get('/api/userredpacket', {}).then(res => {
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
  beforeDestroy() {},
};
</script>
<style lang="scss" scoped>
@import '../../static/style/layui.css';
@import '../../static/style/style.css';
@import '../../static/style/animate.min.css';
.activityInfo table td {
  line-height: 60px;
}
.rightFloat .currenTimePeriod .currenTime {
  position: absolute;
  display: block;
  bottom: 20px;
  left: 17px;
  width: 100%;
}
.redEnveFont {
  overflow: hidden;
  height: 158px;
  box-sizing: border-box;
  padding-top: 49px;
}
.zhongjiang {
  width: 461px;
}
.henbaoqian {
  background: url(/static/image/henbaoqian.png) no-repeat;
  width: 280px;
  background-size: 100% 100%;
  height: 447px;
  top: 50%;
  left: 0px;
  right: 0px;
  margin: 10px auto;
  padding: 145px 20px 0;
}
.henbaoqian p {
    margin-top: 110px!important;
}
</style>
