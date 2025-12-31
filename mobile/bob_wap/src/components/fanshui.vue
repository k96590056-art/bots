<template>
  <div style="width: 100%; min-height: 100vh; background: rgb(237, 241, 255)">
    <van-nav-bar style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ede9e7" title="返水中心" left-arrow @click-left="$router.back()" />
    <div style="height: 46px"></div>
    <div style="width: 95%; min-width: 250px; margin: 0 auto; background: #fff; border-radius: 10px; box-sizing: border-box; padding: 10px; min-height: 90vh">
      <div style="padding-bottom: 10px; display: flex; align-items: center; justify-content: space-between">
        <span style="font-size: 0.3rem"> 返水记录 </span>
        <van-button style="width: 3rem; height: 0.68rem; min-width: 80px" type="info" @click="lingqu"><span style="color: #fff; font-size: 0.3rem">点击领取</span></van-button>
      </div>
      <div style="display: flex; box-sizing: border-box; padding: 0 12px; font-size: 0.3rem; justify-content: space-between; height: 1.1rem; align-items: center; border-bottom: 1px solid #f1f1f1">
        <div style="font-size: 0.3rem; text-align: center; width: 49%">
          <div style="font-size: 0.3rem">累计领取</div>
          <div style="font-size: 0.3rem; color: #cf866b; font-weight: 700">￥{{ jisuan }}</div>
        </div>
        <div style="height: 76%; border-left: 1px solid #f1f1f1"></div>
        <div style="font-size: 0.3rem; text-align: center; width: 49%">
          <div style="font-size: 0.3rem">待领取</div>
          <div style="font-size: 0.3rem; color:#cf866b; font-weight: 700">￥{{ nojisuan }}</div>
        </div>
      </div>
      <!-- 筛选条件 -->
      <div class="saibox">
        <div class="sai" @click="showPopup(1)">{{ name }}</div>
        <div class="sai" @click="showPopup(2)">{{ dateName[date] }}</div>
      </div>
      <van-list style="margin-top: 10px; padding-bottom: 120px" finished-text="没有更多了" offset="300" v-model="loading" :finished="list.length == pageData.total" @load="getData" v-if="list.length > 0">
        <van-cell v-for="(item, index) in list" :key="index">
          <div style="color: #888 !important">
            <div style="display: flex; justify-content: space-between; font-size: 0.3rem">
              {{ item.gamename }} <span style="font-size: 0.3rem">返水金额 :{{ item.money }}</span>
            </div>
            <div style="font-size: 0.3rem">返水时间:{{ item.created_at }}</div>
            <div style="font-size: 0.3rem">领取时间：{{ item.state == 0 ? '暂未领取' : item.updated_at }}</div>
          </div>
        </van-cell>
      </van-list>
      <div v-else style="margin-top: 60px; text-align: center">
        <img src="/static/image/mescroll-empty.png" style="width: 35%" alt="" />
        <van-divider dashed :style="{ color: '#ccc', borderColor: '#ccc', padding: '20px ' }">空空如也</van-divider>
      </div>
    </div>
    <!-- 弹出层 -->
    <van-popup v-model="popup" position="bottom" :style="{ height: 'calc(100% - 3.9rem - 46px)' }">
      <div class="lisg" v-if="showXuan == 1">
        <div class="bs" v-for="(item, index) in dogameLis" :key="index" @click="changDogame(item.name, item.platname)">
          <div :class="api_type == item.platname ? 'lisga act' : 'lisga'">{{ item.name }}</div>
        </div>
      </div>
      <div class="lisg" v-if="showXuan == 2">
        <div class="bs" @click="changtype('date', 1)">
          <div :class="date == 1 ? 'lisga act' : 'lisga'">今日</div>
        </div>
        <div class="bs" @click="changtype('date', 2)">
          <div :class="date == 2 ? 'lisga act' : 'lisga'">近7日</div>
        </div>
        <div class="bs" @click="changtype('date', 3)">
          <div :class="date == 3 ? 'lisga act' : 'lisga'">近15日</div>
        </div>
        <div class="bs" @click="changtype('date', 4)">
          <div :class="date == 4 ? 'lisga act' : 'lisga'">近30日</div>
        </div>
      </div>
    </van-popup>
  </div>
</template>
<script>
export default {
  name: 'fanshui',
  data() {
    return {
      date: 4,
      list: [],
      pageData: {},
      page: 1,
      dogameLis: [],
      api_type: '',
      loading: false,
      name: '全平台',
      show: false,
      jisuan: 0,
      nojisuan: 0,
      dateName: ['', '今日', '近7日', '近15日', '近30日'],
      popup: false,
      showXuan: 1, //1平台选择 2 日期选择
    };
  },
  created() {
    let that = this;
    that.getdogame();
    that.getData();
  },
  methods: {
    changDogame(name, type) {
      let that = this;
      that.name = name;
      that.api_type = type;
      that.popup = false;
      that.page = 1;
      that.getData();
    },
    changtype(name, val) {
      let that = this;
      that[name] = val;
      that.popup = false;
      that.page = 1;
      that.getData();
    },
    showPopup(val) {
      this.popup = true;
      this.showXuan = val;
    },
    lingqu() {
      let that = this;
      let fanshui = that.nojisuan;
      if (fanshui <= 0) {
        that.$parent.showTost(0, '暂无领取额度！');
        return;
      }
      that.$parent.showLoading();
      that.$apiFun
        .post('/api/dofanshui', {})
        .then(res => {
          console.log(res);
          that.$parent.getUserInfo();
          that.$parent.showTost(1, res.message);
          that.getfanshui();
        })
        .catch(res => {
          that.$parent.hideLoading();
        });
    },
 
    openOrclose() {
      this.show = !this.show;
    },
    changtab() {
      let that = this;
      that.page = 1;
      that.list = [];
      that.pageData = {};
      that.getData();
    },
    getdogame() {
      let that = this;

      that.$apiFun.post('/api/balancelist', {}).then(res => {
        console.log(res);
        if (res.code != 200) {
          that.$parent.showTost(res.message);
        }
        if (res.code == 200) {
          that.dogameLis = res.data;
          that.dogameLis.unshift({ name: '全平台', platname: '' });
        }
      });
    },
    changeDate() {
      let that = this;
      that.page = 1;
      that.getData();
    },

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
        type: '',
      };
      that.$apiFun
        .post('/api/getfanshui', info)
        .then(res => {
          if (res.code != 200) {
            that.$parent.showTost(0, res.message);
          }
          if (res.code == 200) {
            that.pageData = res.data.list;
            that.jisuan = res.data.jisuan;
            that.nojisuan = res.data.nojisuan;
            if (that.page == 1) {
              that.list = res.data.list.data;
            } else {
              let list = JSON.parse(JSON.stringify(that.list));
              res.data.list.data.forEach(el => {
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
// @import '../../static/css/chunk-10680dc4.7fc8cdde.css';
.saibox {
  display: flex;
  align-items: center;
  justify-content: space-around;
  height: 1.1rem;
  box-sizing: border-box;
  padding: 0 12px;
  .sai {
    height: 0.8rem;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40%;
    background: #f7f8fc;
    border-radius: 1.1rem;
    font-size: 0.3rem;
  }
}
.lisg {
  box-sizing: border-box;
  padding: 10px 8px;
  display: flex;
  flex-wrap: wrap;
  .bs {
    width: 25%;
    height: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    .lisga {
      width: calc(100% - 8px);
      height: 0.9rem;
      border: 0.02rem solid #cbced8;
      border-radius: 0.08rem;
      color: #a5a9b3;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.2rem;
      text-align: center;
    }
    .lisga.act {
      background: #ede9e7;
      color: #fff;
      border: none;
    }
  }
}
</style>
