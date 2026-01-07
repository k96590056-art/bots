<template>
  <div id="foot">
    <div class="_98keS0eu">
      <div class="QZmtDyqs">
        <div class="_2rOWqGKR">
          <div class="foot_logo"><img src="/static/image/logo1.png" /></div>
          <div class="foot_logo"><img src="/static/image/logo2.png" /></div>
          <div class="foot_logo"><img src="/static/image/logo3.png" /></div>
          <div class="foot_logo"><img src="/static/image/logo4.png" /></div>
          <div class="foot_logo"><img src="/static/image/logo5.png" /></div>
          <div class="foot_logo"><img src="/static/image/logo6.png" /></div>
          <div class="foot_logo"><img src="/static/image/logo7.png" /></div>
          <div class="foot_logo"><img src="/static/image/logo8.png" /></div>
          <div class="foot_logo"><img src="/static/image/logo9.png" /></div>
          <div class="foot_logo"><img src="/static/image/logo10.png" /></div>
        </div>
      </div>
      <div class="_1ihQB55Y">
        <div class="_3U5bGbKV">
          <div class="foot_logo">
            <img src="/static/image/logo11.png" alt="" />
            <div>
              <p>威尔士</p>
              <p>赞助合作伙伴</p>
            </div>
          </div>
          <div class="foot_logo">
            <img src="/static/image/logo12.png" alt="" />
            <div>
              <p>意甲·那不勒斯</p>
              <p>官方合作伙伴</p>
            </div>
          </div>
          <div class="foot_logo">
            <img src="/static/image/logo13.png" alt="" />
            <div>
              <p>德甲·多特蒙德</p>
              <p>官方合作伙伴</p>
            </div>
          </div>
          <div class="foot_logo">
            <img src="/static/image/logo14.png" alt="" />
            <div>
              <p>菲利波·因扎吉</p>
              <p>官方独家代言</p>
            </div>
          </div>
          <div class="foot_logo">
            <img src="/static/image/logo15.png" alt="" />
            <div>
              <p>法甲·里昂</p>
              <p>官方合作伙伴</p>
            </div>
          </div>
        </div>
        <div class="_33x_Rmdv">
          <div class="_1nH8X2_T foot_logo">
            <img class="_2Ogll0o3" src="/static/image/logo16.png" alt="" />
            <div class="CgdZDVWN">
              <div>英国GC</div>
              <div>监督委员会</div>
            </div>
          </div>
          <div class="_1nH8X2_T foot_logo">
            <img class="_2Ogll0o3" src="/static/image/logo17.png" alt="" />
            <div class="CgdZDVWN">
              <div>英属维尔京群岛</div>
              <div>(BVI)认证</div>
            </div>
          </div>
          <div class="_1nH8X2_T foot_logo">
            <img class="_2Ogll0o3" src="/static/image/logo18.png" alt="" />
            <div class="CgdZDVWN">
              <div>马耳他博彩牌照</div>
              <div>（MGA)认证</div>
            </div>
          </div>
          <div class="_1nH8X2_T foot_logo">
            <img class="_2Ogll0o3" src="/static/image/logo19.png" alt="" />
            <div class="CgdZDVWN">
              <div>菲律宾（PAGCOR)</div>
              <div>监管博彩执照</div>
            </div>
          </div>
        </div>
        <div class="_27rUvYBI">{{$store.state.appInfo.title}}拥有欧洲马耳他博彩管理局（MGA）和博彩委员会（PAGCOR）颁发的合法执照；注册于英属维尔京群岛，是受国际博彩</div>
        <div class="_27rUvYBI">协会认可的合法博彩公司；进行注册并娱乐前，请确保您年满18周岁！</div>
        <div class="jOVuY00X">
          <div @click="goNav('/help?topType=2&sumType=0')">新手帮助</div>
          <div @click="goNav('/help?topType=5&sumType=0')">博彩责任</div>
          <div @click="goNav('/help?topType=5&sumType=4')">隐私保护</div>
          <div @click="goNav('/help?topType=5&sumType=2')">免责说明</div>
          <div @click="goNav('/help?topType=6&sumType=0')">联系我们</div>
          <div @click="open('/agent')">合营伙伴</div>
          <!-- <div><a href="javascript:;" download="">清除缓存</a></div> -->
          <!-- <div><span><span>防劫持工具</span></span></div> -->
        </div>
      </div>
      <div class="_1EpnAijt">版权所有 ©2022 {{$store.state.appInfo.title}} 保留所有权</div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Foot',
  data() {
    return {jumpUrl:null};
  },
  methods: {
    goNav(url) {
		let that = this;
      // let urlStr = url.split('?')[0];
      if (url == this.$route.fullPath) {
        that.$parent.showTost('您就在当前页');
        return;
      }
      this.url = url;
      this.$router.push({ path: url });
    },
	open(url){
    let that = this;
		    const routeData = this.$router.resolve({
           path: url,
           query:{}
         });
         that.jumpUrl = routeData.href;
	}
  },
  mounted() {},
   watch: {
     // 新窗口打开页面，解决浏览器拦截问题
     jumpUrl() {
       if (this.jumpUrl) {
         window.open(this.jumpUrl, '_blank')
       }
       this.jumpUrl = null
     }
   },
};
</script>
<style lang="scss" scoped>
</style>
