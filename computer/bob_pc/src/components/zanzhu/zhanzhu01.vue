<template>
  <div class="_24vddGqv">
    <div class="p5MlIAH9">
      <ul class="_13TuK--f" v-if="1==2">
        <li class="_2w8HqNAg" @click="goNav('/zhanzhu01')">
          <h4>威尔士赞助专题</h4>
          <img
            src="data:image/png;base64,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"
            alt="威尔士赞助专题"
          /><span></span><i></i>
        </li>
        <li class="" @click="goNav('/zhanzhu02')">
          <h4>那不勒斯赞助专题</h4>
          <img
            src="data:image/png;base64,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"
            alt="那不勒斯赞助专题"
          /><span></span><i></i>
        </li>
        <li class="" @click="goNav('/zhanzhu03')">
          <h4>多特蒙德赞助专题</h4>
          <img
            src="data:image/png;base64,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"
            alt="多特蒙德赞助专题"
          /><span></span><i></i>
        </li>
        <li class="" @click="goNav('/zhanzhu04')">
          <h4>菲利波·因扎吉专题</h4>
          <img
            src="data:image/png;base64,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"
            alt="菲利波·因扎吉专题"
          /><span></span><i></i>
        </li>
        <li class="" @click="goNav('/zhanzhu05')">
          <h4>法甲里昂赞助专题</h4>
          <img
            src="data:image/png;base64,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"
            alt="法甲里昂赞助专题"
          /><span></span><i></i>
        </li>
      </ul>
      <div class="y-HUEmX_" style="height: auto;">
          <div class="_2RTjvPAW" style="display: flex;">
        <div style="flex-grow: 1; padding: 0 10px;" @click="goNav('/zhanzhu01')">
          <img style="width:100%;" src="/static/image/01.png" data-src="/static/image/01.png" />
        </div>
        <div style="flex-grow: 1; padding: 0 10px;" @click="goNav('/zhanzhu02')">
          <img style="width:100%;" src="/static/image/01.png" data-src="/static/image/02.png" />
        </div>
      </div>
      <div>
          <img style="width: 100%; height: auto;" src="/static/image/ll.jpg">
      </div>
        <div v-if="1==2" class="swiper-wrapper">
          <div class="swiper-slide _2_kzNCcp"><img src="/static/image/sponsor_wales_bigbanner-d1c3.jpg" alt="" /></div>
          <div class="swiper-slide swiper-slide-next">
            <div class="_12decU8e">
              <div class="_2z6M-NO7 _12Z1VdJ9">
                <h1>赞助盛典视频</h1>
                <div class="_3jdlPnaH">
                  <video src="https://webassets.6bjy0.com/assets/sponsor/wales/signup_grand_ceremony.mp4" poster="/static/image/signed_welsh_video_cover-48dc.jpg" controls="" preload='metadata'  ></video>
                  <div class="_2kk48oMX">
                    2021年6月3日，{{$store.state.appInfo.title}}体育平台与威尔士国家足球队在卡迪夫正式签约，达成深度战略合作。作为世界上最古老的足球协会之一，威尔士国家足球队发现人才、培养冠军、见证传奇，而此次签约则是年轻的{{$store.state.appInfo.title}}跻身世界一流的崛起见证。经典的体育赛事，经典的品牌形象，两者结合是{{$store.state.appInfo.title}}不断创新，追求荣誉与梦想的有力表达。相信双方牵手必将共同迈向更高的台阶，抓住未来的每一次机遇，战胜未来的每一次挑战。&nbsp;
                  </div>
                </div>
                <div class="_3y1IdHNm">
                  <div class="_2WOoXvm3"><img src="/static/image/signed_welsh_video_img1-1c0a.jpg" alt="" /></div>
                  <div class="_2WOoXvm3"><img src="/static/image/signed_welsh_video_img2-b285.jpg" alt="" /></div>
                  <div class="_2WOoXvm3"><img src="/static/image/signed_welsh_video_img3-8c1a.jpg" alt="" /></div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="_12decU8e">
              <div class="_2z6M-NO7 _27ZOCPKE">
                <h1>威尔士国家足球队</h1>
                <div class="_2AcpkcuF">
                  <!-- https://webassets.6bjy0.com/assets/sponsor/wales/wales.mp4 -->
                  <video src="" poster="/static/image/sponsor_wales_video_cover-7faf.jpg" controls="" preload='metadata'  ></video>
                  <div class="_4J_Cz3Qf">
                    <div>
                      <p>2020年</p>
                      <p>2020-21欧洲国际联赛，联赛B，胜五场</p>
                    </div>
                    <div>
                      <p>2018年</p>
                      <p>2018-19欧洲国际联赛，联赛B，胜两场</p>
                    </div>
                    <div>
                      <p>2016年</p>
                      <p>欧洲足球锦标赛，准决赛，总排名第三</p>
                    </div>
                    <div>
                      <p>1958年</p>
                      <p>国际足联世界杯，八强，总排名第六</p>
                    </div>
                  </div>
                </div>
                <div class="_3mbX40pp">
                  威尔士国家队创立于1876年，有着欧洲“红龙”的美誉，是世界上历史最悠久的球队之一，主场设立于卡迪夫城体育场。威尔士在1907,1920, 1924, 1928, 1933,
                  1934和1937年七次力压劲旅英格兰和苏格兰队，夺得不列颠锦标赛的冠军，也在本土四角锦标赛获得12届冠军（其中5届为并列冠军）。2016欧洲杯，威尔士国家队在欧洲杯预选赛和正赛中表现出色，以小组第一的成绩出线，更于四分之一决赛中3-1逆转比利时晋级四强。在145年队史中人才辈出，国际影响力与日俱增，2015年进入国际足联FIFA官方排名前十，是欧洲足坛具有重要影响力和竞争力的老牌劲旅。
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="_12decU8e">
              <div class="_2z6M-NO7 OqgjpAtJ">
                <h1>精彩逐梦瞬间</h1>
                <div class="_3jdlPnaH">
                  <img src="/static/image/sponsor_wales_img1-57e9.jpg" alt="" />
                  <div>2016年，威尔士国家队首次参加欧洲国家杯，球队气势如虹，不仅压倒英格兰以小组第一晋级16强赛，之后更淘汰同属英伦的北爱尔兰，并于半准决赛击败当时的夺标热门比利时，历史性地晋级至准决赛，最终排名第3名，也是队史在国际赛最佳的成绩。</div>
                </div>
                <div class="_3y1IdHNm">
                  <div class="_3Ik8nujP">
                    <img src="/static/image/sponsor_wales_img1-57e9.jpg" alt="" />
                    <p>2016年，威尔士国家队首次参加欧洲国家杯，球队气势如虹，不仅压倒英格兰以小组第一晋级16强赛，之后更淘汰同属英伦的北爱尔兰，并于半准决赛击败当时的夺标热门比利时，历史性地晋级至准决赛，最终排名第3名，也是队史在国际赛最佳的成绩。</p>
                  </div>
                  <div class="">
                    <img src="/static/image/sponsor_wales_img2-ccbe.jpg" alt="" />
                    <p>威尔士在1976年欧洲国家杯外围赛排在第2组，以5胜1负的成绩压倒匈牙利及奥地利。</p>
                  </div>
                  <div class="">
                    <img src="/static/image/sponsor_wales_img3-b269.jpg" alt="" />
                    <p>科学发展的理念和严谨的态度，与借助于联赛的锻炼，促使国家队涌现出一批实力干将。</p>
                  </div>
                  <div class="">
                    <img src="/static/image/sponsor_wales_img4-99a5.jpg" alt="" />
                    <p>威尔士还有大量在英超、英冠赛场担任主力的球员，为国家队的比赛提供了坚实的后盾。</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="_12decU8e">
              <div class="_2z6M-NO7 pnQRWQMI">
                <h1>球员信息与故事</h1>
                <div style="background-image: url(/static/image/sponsor_wales_player1-7b0e.png)">
                  <p>泰勒·罗伯茨</p>
                  <p>Tyler Roberts</p>
                  <p>1999年1月12日出生于英格兰格洛斯特，在威尔士国家队司职中锋；现效力于英超的利兹联足球俱乐部。</p>
                </div>
                <div style="background-image: url(/static/image/sponsor_wales_player2-07fa.png)">
                  <p>丹尼尔·詹姆斯</p>
                  <p>Daniel James</p>
                  <p>1997年11月10日出生于英格兰，在威尔士国家队司职边锋，拥有惊人的爆发力和冲刺速度；目前效力于英超的曼彻斯特联队。</p>
                </div>
                <div style="background-image: url(/static/image/sponsor_wales_player3-e241.png)">
                  <p>加雷斯·贝尔</p>
                  <p>Gareth Bale</p>
                  <p>1989年7月16日出生于威尔士卡迪夫，国家队传奇球星之一，曾在2012-13赛季包揽PFA、FWA、英超官方最佳球员三项大奖；现效力于西甲俱乐部皇家马德里并租借至英超俱乐部热刺。</p>
                </div>
                <div style="background-image: url(/static/image/sponsor_wales_player4-b867.png)">
                  <p>哈里·威尔逊</p>
                  <p>Harry Wilson</p>
                  <p>1997年3月22日出生于威尔士雷克瑟姆，是威尔士国家队历史上最年轻的出场球员，场上司职右边锋；现时由英超球队利物浦外借至英冠球队卡迪夫城。</p>
                </div>
                <div style="background-image: url(/static/image/sponsor_wales_player5-ba24.png)">
                  <p>伊桑·阿姆帕杜</p>
                  <p>Ethan Ampadu</p>
                  <p>2000年9月14日出生于英格兰埃克塞特，威尔士足球运动员，场上司职中后卫，现时被英超俱乐部切尔西外借至英超俱乐部谢菲尔德联。</p>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="_12decU8e">
              <div class="_2z6M-NO7 _16OCTCe0">
                <h1>{{$store.state.appInfo.title}}体育权威认证</h1>
                <div class="_1MDF8TaU">
                  <div class="_1UAN_1QV">
                    <div>
                      <p>更安全</p>
                      <pre>
独家网络技术
超强防劫持</pre
                      >
                    </div>
                    <div>
                      <p>更丰富</p>
                      <pre>
丰富的游戏产品
您想要的我们都有</pre
                      >
                    </div>
                    <div>
                      <p>更稳定</p>
                      <pre>
强大的技术团队
提供最稳定的产品</pre
                      >
                    </div>
                    <div>
                      <p>更私密</p>
                      <pre>
三重数据加密保护
您的资料安全</pre
                      >
                    </div>
                  </div>
                  <div class="YiShHCXw">
                    <pre>
英国GC监督
委员会</pre
                    >
                    <pre>
英属维尔京群
岛(BVI)认证</pre
                    >
                    <pre>
马耳他博彩牌照
（MGA)认证</pre
                    >
                    <pre>
菲律宾(PAGCOR)
监管博彩执照</pre
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'zhanzhu01',
  data() {
    return {};
  },
  created() {
    let that = this;
  },
  methods: {
    goNav(url) {
      // let urlStr = url.split('?')[0];
      let that = this;
      if (url == this.$route.fullPath) {
        that.$parent.showTost('您就在当前页');
        return;
      }
      this.url = url;
      this.$router.push({ path: url });
    },
  },
  mounted() {
    //页面滑动
    var swiper = new Swiper('.y-HUEmX_', {
      direction: 'vertical',
      mousewheel: true,
      speed: 1000,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });

    //切换图片
    $('._3y1IdHNm>div').click(function () {
      $(this).addClass('_3Ik8nujP').siblings().removeClass('_3Ik8nujP');
      var src = $(this).find('img').attr('src');
      var text = $(this).find('p').text();
      $('._3jdlPnaH img').attr('src', src);
      $('._3jdlPnaH div').text(text);
    });
  },
  updated() {
    let that = this;
  },
};
</script>
<style lang="scss" >
.fangda {
  animation: _308UEapr 0.5s ease-out;
}
.hover {
  display: none;
}
._3gi7jqcw:hover ._2JoosS9F {
  display: none;
}
._3gi7jqcw:hover .hover {
  display: block;
}
._3gi7jqcw._12ZkQT2g ._2JoosS9F {
  display: none;
}
._3gi7jqcw._12ZkQT2g .hover {
  display: block;
}
 .swiper-pagination-vertical.swiper-pagination-bullets,
 .swiper-vertical > .swiper-pagination-bullets {
  right: 140px;
}
   .swiper-pagination-bullet {
  background: url('/static/image/bullet.png') no-repeat;
  background-size: 24px 24px;
  margin: 0 0 13px !important;
  opacity: 1 !important;
  width: 24px;
  height: 24px;
}
  .swiper-pagination-bullet-active {
  background: url('/static/image/bullet-active.png') no-repeat;
  background-size: 24px 24px;
}
.swiper-container .swiper-pagination .swiper-pagination-bullet:before {
    content: "";
    display: block;
    position: absolute;
    width: 1px;
    height: 1420px;
    background: hsla(0,0%,100%,.5);
    left: 13px;
    top: -1435px;
}
.swiper-container .swiper-pagination .swiper-pagination-bullet:after {
    content: "";
    display: block;
    position: absolute;
    width: 1px;
    height: 1420px;
    background: hsla(0,0%,100%,.5);
    left: 13px;
    bottom: -1435px;
}
</style>
