<template>
  <div class="_35lz77bA">
    <div class="_24vddGqv">
      <div class="_3zvhjTF6">
        <section class="_17n-yHoK">
          <div class="_2S8ndEN8">
            <div class="_1G6hnAcg">
              <img
                class="_15aWJef4"
                src="data:image/png;base64,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"
                alt=""
              />
              <div class="_3Ls3Qjt7">
                <div class="VRwEtREQ"><span class="_2IUXcOkz" style="background-position-y: -260px"></span></div>
                <div class="VRwEtREQ"><span class="_2IUXcOkz" style="background-position-y: -196px"></span></div>
                <div class="VRwEtREQ"><span class="_2IUXcOkz" style="background-position-y: -293px"></span></div>
                <div class="_2lanDCB3"></div>
                <div class="VRwEtREQ"><span class="_2IUXcOkz" style="background-position-y: -100px"></span></div>
                <div class="VRwEtREQ"><span class="_2IUXcOkz" style="background-position-y: -163px"></span></div>
                <div class="VRwEtREQ"><span class="_2IUXcOkz" style="background-position-y: -130px"></span></div>
                <div class="_2lanDCB3"></div>
                <div class="VRwEtREQ"><span class="_2IUXcOkz" style="background-position-y: 224px"></span></div>
                <div class="VRwEtREQ"><span class="_2IUXcOkz" style="background-position-y: 3206px"></span></div>
                <div class="VRwEtREQ"><span class="_2IUXcOkz" style="background-position-y: 33436px"></span></div>
                <div class="_2lanDCB3"></div>
                <div class="VRwEtREQ"><span class="_2IUXcOkz" style="background-position-y: 149234px"></span></div>
              </div>
            </div>
            <div class="_3K51SiXw">
              <div :class="gamecode == 'obgdy' ? 'AVArLkuS _3iUQXhCk' : 'AVArLkuS'" @click="changgamecode('obgdy')">
                <div class="k4nFxoEz">
                  <div>OB电子</div>
                  <img style="width: 50px" src="/static/image/ob.png" alt="icon" class="img" /><img style="width: 50px" src="/static/image/ob-hover.png" alt="icon" class="hover" />
                </div>
                <img class="_1Wf_Qpnk" src="/static/image/elt_people_bob-8fcb.png" />
              </div>
              <div :class="gamecode == 'fgdz' ? 'AVArLkuS _3iUQXhCk' : 'AVArLkuS'" @click="changgamecode('fgdz')">
                <div class="k4nFxoEz">
                  <div>FG电子</div>
                  <img style="width: 40px" src="/static/image/fg.png" alt="icon" class="img" /><img style="width: 40px" src="/static/image/fg-hover.png" alt="icon" class="hover" />
                </div>
                <img class="_1Wf_Qpnk" src="/static/image/bg3_pg-c85b.png" />
              </div>
              <div :class="gamecode == 'pp' ? 'AVArLkuS _3iUQXhCk' : 'AVArLkuS'" @click="changgamecode('pp')">
                <div class="k4nFxoEz">
                  <div>PP电子</div>
                  <img src="/static/image/pp.png" alt="icon" class="img" /><img src="/static/image/pp-hover.png" alt="icon" class="hover" />
                </div>
                <img class="_1Wf_Qpnk" src="/static/image/bg3_pp-6fdd.png" />
              </div>
              <div :class="gamecode == 'ae' ? 'AVArLkuS _3iUQXhCk' : 'AVArLkuS'" @click="changgamecode('ae')">
                <div class="k4nFxoEz">
                  <div>AE电子</div>
                  <img src="/static/image/ae.png" alt="icon" class="img" /><img src="/static/image/ae-hover.png" alt="icon" class="hover" />
                </div>
                <img class="_1Wf_Qpnk" src="/static/image/bg3_mg-5756.png" />
              </div>
            </div>
          </div>
        </section>
        <div class="qCh9TJJF">
          <div class="_2scQI3mb">
            <ul class="_2jociKy1">
              <li @click="changgamecode('obgdy')" :class="gamecode == 'obgdy' ? '_2lYO0Bvw active' : ''"><img src="/static/image/ob.png" alt="icon" class="img" /><img src="/static/image/ob-hover.png" alt="icon" class="hover" /><span>OB电子</span></li>
              <li @click="changgamecode('fgdz')" :class="gamecode == 'fgdz' ? '_2lYO0Bvw active' : ''"><img src="/static/image/fg.png" alt="icon" class="img" /><img src="/static/image/fg-hover.png" alt="icon" class="hover" /><span>FG电子</span></li>
              <li @click="changgamecode('pp')" :class="gamecode == 'pp' ? '_2lYO0Bvw active' : ''"><img src="/static/image/pp.png" alt="icon" class="img" /><img src="/static/image/pp-hover.png" alt="icon" class="hover" /><span>PP电子</span></li>
              <li @click="changgamecode('ae')" :class="gamecode == 'ae' ? '_2lYO0Bvw active' : ''"><img src="/static/image/ae.png" alt="icon" class="img" /><img src="/static/image/ae-hover.png" alt="icon" class="hover" /><span>AE电子</span></li>
            </ul>
          </div>
        </div>
        <div class="ant-spin-nested-loading">
          <div class="loading" v-if="lodingShow">
            <div class="ant-spin ant-spin-spinning _2PSsJSST">
              <span class="ant-spin-dot ant-spin-dot-spin"><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i><i class="ant-spin-dot-item"></i></span>
            </div>
          </div>
          <div :class="lodingShow ? 'ant-spin-container ant-spin-blur' : 'ant-spin-container'">
            <div class="_3g38oEEP">
              <ul class="_3-gfKTg8" v-if="gamecode == 'obgdy'">
                <li class="_189EGvQu" v-for="(item, index) in obgdyList" :key="index">
                  <div class="ENpaF5Nc"><img class="ls-is-cached lazyloaded" :src="item.gamepic" style="object-fit: cover" /></div>
                  <div class="_12gWax5w">
                    <span>{{ item.gamename }}</span>
                  </div>
                  <div class="_2jsTUiGa">
                    <div class="_349CzCYy xJQe3jRu _12ZkQT2g _1fZocrmP" @click="goGamePage(item.catecode, item.gamecode, '')"><span>立即游戏</span></div>
                  </div>
                </li>
              </ul>
              <ul class="_3-gfKTg8" v-if="gamecode == 'fgdz'">
                <li class="_189EGvQu" v-for="(item, index) in fgdzList" :key="index">
                  <div class="ENpaF5Nc"><img class="ls-is-cached lazyloaded" :src="item.gamepic" style="object-fit: cover" /></div>
                  <div class="_12gWax5w">
                    <span>{{ item.gamename }}</span>
                  </div>
                  <div class="_2jsTUiGa">
                    <div class="_349CzCYy xJQe3jRu _12ZkQT2g _1fZocrmP" @click="goGamePage(item.catecode, item.gamecode, '')"><span>立即游戏</span></div>
                  </div>
                </li>
              </ul>
              <ul class="_3-gfKTg8" v-if="gamecode == 'pp'">
                <li class="_189EGvQu" v-for="(item, index) in ppList" :key="index">
                  <div class="ENpaF5Nc"><img class="ls-is-cached lazyloaded" :src="item.gamepic" style="object-fit: cover" /></div>
                  <div class="_12gWax5w">
                    <span>{{ item.gamename }}</span>
                  </div>
                  <div class="_2jsTUiGa">
                    <div class="_349CzCYy xJQe3jRu _12ZkQT2g _1fZocrmP" @click="goGamePage(item.catecode, item.gamecode, '')"><span>立即游戏</span></div>
                  </div>
                </li>
              </ul>
              <ul class="_3-gfKTg8" v-if="gamecode == 'ae'">
                <li class="_189EGvQu" v-for="(item, index) in aeList" :key="index">
                  <div class="ENpaF5Nc"><img class="ls-is-cached lazyloaded" :src="item.gamepic" style="object-fit: cover" /></div>
                  <div class="_12gWax5w">
                    <span>{{ item.gamename }}</span>
                  </div>
                  <div class="_2jsTUiGa">
                    <div class="_349CzCYy xJQe3jRu _12ZkQT2g _1fZocrmP" @click="goGamePage(item.catecode, item.gamecode, '')"><span>立即游戏</span></div>
                  </div>
                </li>
              </ul>

              <div class="_3FfSWfyA"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { MessageBox } from 'element-ui';
export default {
  name: 'amusementList',
  data() {
    return { obgdyList: [], fgdzList: [], ppList: [], aeList: [], gamecode: 'obgdy', lodingShow: true, jumpUrl: null };
  },
  created() {
    let that = this;
    if (this.$route.query) {
      that.gamecode = this.$route.query.type;
    }
    that.gamelistBycode();
  },
  methods: {
    hideloading() {
      this.lodingShow = false;
    },
    showloading() {
      this.lodingShow = true;
    },
    changgamecode(code) {
      let that = this;
      if (code == that.gamecode) {
        return;
      }
      that.gamecode = code;
      that.gamelistBycode();
    },
    //  参数  gamecode  pp ae fg obgdy  获取二级游戏 获取二级游戏
    // 游戏地址之前发的就两个参数，plat_name是游戏名称代码，game_type是游戏类型代码
    gamelistBycode() {
      let that = this;
      let name = that.gamecode + 'List';
      if (that[name].length > 0) {
        return;
      }
      that.showloading();
      //  pp ae fg obgdy
      that.$apiFun
        .post('/api/gamelistBycode', { gamecode: that.gamecode })
        .then(res => {
          console.log(res);
          if (res.code != 200) {
            that.showTost(res.message);
          }
          if (res.code == 200) {
            that[name] = res.data;
          }
          that.hideloading();
        })
        .catch(res => {
          that.hideloading();
        });
    },
    goGamePage(name, type, code) {
      let that = this;
      let token = sessionStorage.getItem('token') ? sessionStorage.getItem('token') : '';
      if (!token) {
        that.$parent.openShow();
        return;
      }
      that.showTost('正在前往打开游戏页面');
      type = type || 0;
      that.$apiFun.post('/api/getGameUrl', { plat_name: name, game_type: type, game_code: code, is_mobile_url: 0 }).then(res => {
        if (res.code == 501) {
            that.$confirm(res.message, '提示', {
  confirmButtonText: '前往转账',
  cancelButtonText: '先逛逛',
  type: 'warning'
})
  .then(() => {
    this.$router.push({ path: "/mine/transfer" });
  })
  .catch(() => {
      that.jumpUrl = res.data.url;
  });
        }else{
            if (res.code == 200) {
          that.jumpUrl = res.data.url;
        }else
            that.showTost(res.message);
        }
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
  },
  mounted() {
    //电子游艺场馆切换
    $('._3K51SiXw .AVArLkuS').click(function () {
      $(this).addClass('_3iUQXhCk').siblings().removeClass('_3iUQXhCk');
    });
    //下面游戏分类切换
    $('._2jociKy1 li').click(function () {
      $(this).addClass('_2lYO0Bvw active').siblings().removeClass('_2lYO0Bvw active');
    });
  },
  updated() {
    let that = this;
  },
  watch: {
    // 新窗口打开页面，解决浏览器拦截问题
    jumpUrl() {
      if (this.jumpUrl) {
        window.open(this.jumpUrl, '_blank');
      }
      this.jumpUrl = null;
    },
    $route: {
      immediate: true,
      handler() {
        let that = this;
        let query = this.$route.query;
        if (query.type) {
          that.gamecode = query.type;
          that.gamelistBycode();
        }
      },
    },
  },
};
</script>
<style lang="scss" scoped>
.img {
  display: block;
}
.hover {
  display: none;
}
._3iUQXhCk .hover {
  display: block;
}
.AVArLkuS .k4nFxoEz p {
  display: none;
}
.AVArLkuS,
._3iUQXhCk .k4nFxoEz p {
  display: block;
}
._3iUQXhCk .img {
  display: none;
}
._2lYO0Bvw .hover {
  display: block;
}
._2lYO0Bvw .img {
  display: none;
}
</style>
