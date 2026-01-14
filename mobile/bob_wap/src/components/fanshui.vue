<template>
  <div class="rebate-page">
    <!-- 背景装饰圆 -->
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>
    <div class="bg-circle bg-circle-3"></div>

    <!-- 顶部导航栏 -->
    <div class="nav-bar">
      <div class="nav-back" @click="$router.back()">
        <van-icon name="arrow-left" size="20" color="#333" />
      </div>
      <div class="nav-title">实时返水</div>
      <div class="nav-right">
        <div class="nav-link" @click="goVipLevel">VIP等级 <van-icon name="arrow" size="12" /></div>
        <div class="nav-link" @click="showRules">返水规则 <van-icon name="arrow" size="12" /></div>
      </div>
    </div>

    <!-- 可结算返水卡片 -->
    <div class="rebate-card-wrapper">
      <div class="rebate-card">
        <div class="rebate-card-inner">
          <div class="rebate-label">可结算返水</div>
          <div class="rebate-tip">VIP等级越高返水比例越高</div>
          <div class="rebate-amount">{{ nojisuan.toFixed(2) }}</div>
        </div>
      </div>
    </div>

    <!-- 立即领取按钮 -->
    <div class="claim-btn-wrapper">
      <div class="claim-btn" @click="lingqu">立即领取</div>
    </div>

    <!-- 返水记录区域 -->
    <div class="record-section">
      <div class="record-header">
        <div class="record-title">返水记录</div>
        <div class="record-more" @click="showMoreRecords">查看更多 <van-icon name="arrow" size="12" /></div>
      </div>

      <!-- 有记录时显示列表 -->
      <div class="record-list" v-if="list.length > 0">
        <div class="record-item" v-for="(item, index) in list.slice(0, 5)" :key="index">
          <div class="record-item-left">
            <div class="record-game">{{ item.gamename }}</div>
            <div class="record-time">{{ item.created_at }}</div>
          </div>
          <div class="record-item-right">
            <div class="record-money">+{{ item.money }}</div>
            <div class="record-status" :class="item.state == 0 ? 'pending' : 'claimed'">
              {{ item.state == 0 ? '待领取' : '已领取' }}
            </div>
          </div>
        </div>
      </div>

      <!-- 空状态 -->
      <div class="empty-state" v-else>
        <img src="/static/image/giftnew.png" class="empty-icon" alt="" />
        <div class="empty-text">暂无返水记录</div>
      </div>
    </div>

    <!-- 返水规则弹窗 -->
    <van-popup v-model="rulesPopup" position="bottom" round :style="{ maxHeight: '70%' }">
      <div class="rules-popup">
        <div class="rules-title">返水规则</div>
        <div class="rules-content">
          <p>1. 返水金额根据您的有效投注额和VIP等级计算</p>
          <p>2. VIP等级越高，返水比例越高</p>
          <p>3. 返水每日结算，可随时领取</p>
          <p>4. 领取的返水将直接到账您的余额</p>
        </div>
        <div class="rules-close" @click="rulesPopup = false">我知道了</div>
      </div>
    </van-popup>

    <!-- 更多记录弹窗 -->
    <van-popup v-model="morePopup" position="bottom" :style="{ height: '80%' }" round>
      <div class="more-popup">
        <div class="more-header">
          <div class="more-title">返水记录</div>
          <van-icon name="cross" size="20" @click="morePopup = false" />
        </div>
        <!-- 筛选条件 -->
        <div class="filter-bar">
          <div class="filter-item" @click="showPopup(1)">
            {{ name }} <van-icon name="arrow-down" size="12" />
          </div>
          <div class="filter-item" @click="showPopup(2)">
            {{ dateName[date] }} <van-icon name="arrow-down" size="12" />
          </div>
        </div>
        <van-list
          class="more-list"
          finished-text="没有更多了"
          offset="300"
          v-model="loading"
          :finished="list.length == pageData.total"
          @load="getData"
        >
          <div class="record-item" v-for="(item, index) in list" :key="index">
            <div class="record-item-left">
              <div class="record-game">{{ item.gamename }}</div>
              <div class="record-time">{{ item.created_at }}</div>
            </div>
            <div class="record-item-right">
              <div class="record-money">+{{ item.money }}</div>
              <div class="record-status" :class="item.state == 0 ? 'pending' : 'claimed'">
                {{ item.state == 0 ? '待领取' : '已领取' }}
              </div>
            </div>
          </div>
        </van-list>
        <div class="empty-state" v-if="list.length === 0">
          <img src="/static/image/giftnew.png" class="empty-icon" alt="" />
          <div class="empty-text">暂无返水记录</div>
        </div>
      </div>
    </van-popup>

    <!-- 筛选弹出层 -->
    <van-popup v-model="popup" position="bottom" round>
      <div class="filter-popup">
        <div class="filter-options" v-if="showXuan == 1">
          <div
            class="filter-option"
            v-for="(item, index) in dogameLis"
            :key="index"
            :class="{ active: api_type == item.platname }"
            @click="changDogame(item.name, item.platname)"
          >
            {{ item.name }}
          </div>
        </div>
        <div class="filter-options" v-if="showXuan == 2">
          <div class="filter-option" :class="{ active: date == 1 }" @click="changtype('date', 1)">今日</div>
          <div class="filter-option" :class="{ active: date == 2 }" @click="changtype('date', 2)">近7日</div>
          <div class="filter-option" :class="{ active: date == 3 }" @click="changtype('date', 3)">近15日</div>
          <div class="filter-option" :class="{ active: date == 4 }" @click="changtype('date', 4)">近30日</div>
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
      showXuan: 1,
      rulesPopup: false,
      morePopup: false,
    };
  },
  created() {
    this.getdogame();
    this.getData();
  },
  methods: {
    goVipLevel() {
      this.$router.push('/vip');
    },
    showRules() {
      this.rulesPopup = true;
    },
    showMoreRecords() {
      this.morePopup = true;
    },
    changDogame(name, type) {
      this.name = name;
      this.api_type = type;
      this.popup = false;
      this.page = 1;
      this.getData();
    },
    changtype(name, val) {
      this[name] = val;
      this.popup = false;
      this.page = 1;
      this.getData();
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
          that.$parent.getUserInfo();
          that.$parent.showTost(1, res.message);
          that.getData();
        })
        .catch(res => {
          that.$parent.hideLoading();
        });
    },
    getdogame() {
      let that = this;
      that.$apiFun.post('/api/balancelist', {}).then(res => {
        if (res.code == 200) {
          that.dogameLis = res.data;
          that.dogameLis.unshift({ name: '全平台', platname: '' });
        }
      });
    },
    getData() {
      let that = this;
      let page = that.page;
      if (page > that.pageData.last_page && that.pageData.last_page) {
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
};
</script>

<style lang="scss" scoped>
.rebate-page {
  min-height: 100vh;
  background: linear-gradient(180deg, #e8f4ff 0%, #f0f7ff 50%, #ffffff 100%);
  position: relative;
  overflow: hidden;
  padding-bottom: 30px;
}

// 背景装饰圆
.bg-circle {
  position: absolute;
  border-radius: 50%;
  background: rgba(64, 158, 255, 0.08);
}

.bg-circle-1 {
  width: 200px;
  height: 200px;
  top: -50px;
  right: -80px;
}

.bg-circle-2 {
  width: 150px;
  height: 150px;
  top: 300px;
  left: -60px;
}

.bg-circle-3 {
  width: 100px;
  height: 100px;
  bottom: 200px;
  right: -30px;
}

// 顶部导航栏
.nav-bar {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  padding: 15px 15px 10px;
  position: relative;
  z-index: 10;
}

.nav-back {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.nav-title {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  font-size: 18px;
  font-weight: 600;
  color: #333;
}

.nav-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 8px;
}

.nav-link {
  font-size: 13px;
  color: #666;
  display: flex;
  align-items: center;
  gap: 2px;
}

// 可结算返水卡片
.rebate-card-wrapper {
  display: flex;
  justify-content: center;
  padding: 30px 20px 20px;
}

.rebate-card {
  width: 280px;
  height: 280px;
  border-radius: 50%;
  background: linear-gradient(135deg, rgba(64, 158, 255, 0.15) 0%, rgba(64, 158, 255, 0.05) 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;

  &::before {
    content: '';
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(64, 158, 255, 0.3) 0%, rgba(64, 158, 255, 0.1) 50%, transparent 100%);
    z-index: -1;
  }

  &::after {
    content: '';
    position: absolute;
    top: 10px;
    left: 10px;
    right: 10px;
    bottom: 10px;
    border-radius: 50%;
    background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    z-index: 0;
  }
}

.rebate-card-inner {
  position: relative;
  z-index: 1;
  text-align: center;
}

.rebate-label {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  margin-bottom: 8px;
}

.rebate-tip {
  font-size: 12px;
  color: #f5a623;
  margin-bottom: 20px;
}

.rebate-amount {
  font-size: 48px;
  font-weight: 700;
  color: #409eff;
  line-height: 1;
}

// 立即领取按钮
.claim-btn-wrapper {
  padding: 10px 30px 30px;
}

.claim-btn {
  height: 50px;
  background: linear-gradient(90deg, #409eff 0%, #66b1ff 100%);
  border-radius: 25px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  font-weight: 600;
  color: #fff;
  box-shadow: 0 4px 15px rgba(64, 158, 255, 0.4);

  &:active {
    transform: scale(0.98);
    opacity: 0.9;
  }
}

// 返水记录区域
.record-section {
  margin: 0 15px;
  background: #fff;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
}

.record-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.record-title {
  font-size: 16px;
  font-weight: 600;
  color: #333;
}

.record-more {
  font-size: 13px;
  color: #409eff;
  display: flex;
  align-items: center;
  gap: 2px;
}

// 记录列表
.record-list {
  .record-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f5f5f5;

    &:last-child {
      border-bottom: none;
    }
  }
}

.record-item-left {
  .record-game {
    font-size: 14px;
    color: #333;
    margin-bottom: 4px;
  }

  .record-time {
    font-size: 12px;
    color: #999;
  }
}

.record-item-right {
  text-align: right;

  .record-money {
    font-size: 16px;
    font-weight: 600;
    color: #f5a623;
    margin-bottom: 4px;
  }

  .record-status {
    font-size: 12px;

    &.pending {
      color: #409eff;
    }

    &.claimed {
      color: #67c23a;
    }
  }
}

// 空状态
.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 40px 0;
}

.empty-icon {
  width: 120px;
  height: auto;
  margin-bottom: 15px;
}

.empty-text {
  font-size: 14px;
  color: #999;
}

// 返水规则弹窗
.rules-popup {
  padding: 20px;
}

.rules-title {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  text-align: center;
  margin-bottom: 20px;
}

.rules-content {
  padding: 0 10px;

  p {
    font-size: 14px;
    color: #666;
    line-height: 2;
    margin: 0;
  }
}

.rules-close {
  margin-top: 25px;
  height: 45px;
  background: linear-gradient(90deg, #409eff 0%, #66b1ff 100%);
  border-radius: 22px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 15px;
  color: #fff;
}

// 更多记录弹窗
.more-popup {
  height: 100%;
  display: flex;
  flex-direction: column;
}

.more-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  border-bottom: 1px solid #f5f5f5;
}

.more-title {
  font-size: 16px;
  font-weight: 600;
  color: #333;
}

.filter-bar {
  display: flex;
  padding: 15px 20px;
  gap: 15px;
}

.filter-item {
  flex: 1;
  height: 40px;
  background: #f5f7fa;
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  color: #666;
  gap: 5px;
}

.more-list {
  flex: 1;
  overflow-y: auto;
  padding: 0 20px;

  .record-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #f5f5f5;
  }
}

// 筛选弹窗
.filter-popup {
  padding: 20px;
}

.filter-options {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.filter-option {
  width: calc(25% - 8px);
  height: 40px;
  border: 1px solid #dcdfe6;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
  color: #666;

  &.active {
    background: #409eff;
    border-color: #409eff;
    color: #fff;
  }
}
</style>
