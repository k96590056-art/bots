<template>
  <div class="page-wrapper">
    <van-nav-bar
      style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ede9e7"
      title="游戏统计"
      left-arrow
      @click-left="$router.back()"
    />
    <div style="height: 46px"></div>
    <div class="content-container">
      <!-- 筛选条件 -->
      <div class="filter-box">
        <div class="filter-item" @click="showPlatformPopup">
          <span>{{ platformFilterName }}</span>
          <van-icon name="arrow-down" />
        </div>
        <div class="filter-item" @click="showDatePopup">
          <span>{{ dateName[date] }}</span>
          <van-icon name="arrow-down" />
        </div>
      </div>

      <!-- 总体统计卡片 -->
      <div class="total-stats-card">
        <div class="stat-item">
          <div class="stat-label">总投注金额</div>
          <div class="stat-value">{{ totalStats.total_bet_amount || '0.00' }}</div>
        </div>
        <div class="stat-item">
          <div class="stat-label">总输赢</div>
          <div class="stat-value" :class="{ 'win': parseFloat(totalStats.total_win_loss || 0) > 0, 'loss': parseFloat(totalStats.total_win_loss || 0) < 0 }">
            {{ parseFloat(totalStats.total_win_loss || 0) > 0 ? '+' : '' }}{{ totalStats.total_win_loss || '0.00' }}
          </div>
        </div>
        <div class="stat-item">
          <div class="stat-label">总有效流水</div>
          <div class="stat-value">{{ totalStats.total_valid_amount || '0.00' }}</div>
        </div>
      </div>

      <!-- 平台列表 -->
      <div class="platform-list" v-if="platforms.length > 0">
        <div
          class="platform-card"
          v-for="(platform, index) in platforms"
          :key="index"
          @click="goToBetRecord(platform.platform_code)"
        >
          <div class="platform-icon">
            <img v-if="platform.platform_icon" :src="platform.platform_icon" :alt="platform.platform_name" />
            <div v-else class="default-icon">{{ platform.platform_name ? platform.platform_name.charAt(0) : 'P' }}</div>
          </div>
          <div class="platform-content">
            <div class="platform-name">{{ platform.name }}</div>
            <div class="platform-date">{{ platform.date_range }}</div>
            <div class="platform-stats">
              <div class="platform-stat-item">
                <span class="stat-label-small">总投注金额</span>
                <span class="stat-value-small">{{ platform.total_bet_amount || '0.00' }}</span>
              </div>
              <div class="platform-stat-item">
                <span class="stat-label-small">总输赢</span>
                <span class="stat-value-small" :class="{ 'win': parseFloat(platform.total_win_loss || 0) > 0, 'loss': parseFloat(platform.total_win_loss || 0) < 0 }">
                  {{ parseFloat(platform.total_win_loss || 0) > 0 ? '+' : '' }}{{ platform.total_win_loss || '0.00' }}
                </span>
              </div>
            </div>
          </div>
          <div class="platform-arrow">
            <van-icon name="arrow" />
          </div>
        </div>
      </div>

      <!-- 空状态 -->
      <div v-else class="empty-state">
        <img src="/static/image/mescroll-empty.png" style="width: 35%" alt="" />
        <van-divider dashed :style="{ color: '#ccc', borderColor: '#ccc', padding: '20px ' }">暂无数据</van-divider>
      </div>
    </div>

    <!-- 平台选择弹出层 -->
    <van-popup v-model="showPlatformPop" position="bottom" :style="{ height: '50%' }">
      <div class="popup-header">
        <span>选择平台</span>
        <van-icon name="cross" @click="showPlatformPop = false" />
      </div>
      <div class="popup-content">
        <div
          class="popup-item"
          v-for="(item, index) in platformList"
          :key="index"
          @click="selectPlatform(item)"
        >
          <div :class="platformFilter === item.platname ? 'popup-item-text active' : 'popup-item-text'">
            {{ item.name }}
          </div>
        </div>
      </div>
    </van-popup>

    <!-- 日期选择弹出层 -->
    <van-popup v-model="showDatePop" position="bottom" :style="{ height: '40%' }">
      <div class="popup-header">
        <span>选择日期</span>
        <van-icon name="cross" @click="showDatePop = false" />
      </div>
      <div class="popup-content">
        <template v-for="(name, index) in dateName">
          <div
            v-if="index > 0"
            class="popup-item"
            :key="index"
            @click="selectDate(index)"
          >
            <div :class="date === index ? 'popup-item-text active' : 'popup-item-text'">
              {{ name }}
            </div>
          </div>
        </template>
      </div>
    </van-popup>
  </div>
</template>

<script>
export default {
  name: 'gameStat',
  data() {
    return {
      date: 1, // 默认今日
      dateName: ['', '今日', '近7日', '近15日', '近30日'],
      platformFilter: '', // 空字符串表示全部平台
      platformFilterName: '全部',
      platformList: [],
      totalStats: {
        total_bet_amount: '0.00',
        total_win_loss: '0.00',
        total_valid_amount: '0.00',
      },
      platforms: [],
      showPlatformPop: false,
      showDatePop: false,
    };
  },
  created() {
    let that = this;
    that.getPlatformList();
    that.getGameStat();
  },
  methods: {
    // 获取平台列表
    getPlatformList() {
      let that = this;
      that.$apiFun.post('/api/balancelist', {}).then(res => {
        if (res.code == 200 && res.data) {
          that.platformList = res.data || [];
          that.platformList.unshift({ name: '全部', platname: '' });
        }
      }).catch(err => {
        console.error('获取平台列表失败:', err);
      });
    },
    // 获取游戏统计
    getGameStat() {
      let that = this;
      that.$parent.showLoading();
      let params = {
        date: that.date,
      };
      that.$apiFun
        .post('/api/get_game_stat', params)
        .then(res => {
          that.$parent.hideLoading();
          if (res.code != 200) {
            that.$parent.showTost(0, res.message || '获取数据失败');
            return;
          }
          if (res.code == 200 && res.data) {
            that.totalStats = res.data.total || that.totalStats;
            // 如果有平台筛选，过滤平台列表
            if (that.platformFilter) {
              that.platforms = (res.data.platforms || []).filter(
                p => p.platform_code === that.platformFilter
              );
            } else {
              that.platforms = res.data.platforms || [];
            }
          }
        })
        .catch(err => {
          that.$parent.hideLoading();
          console.error('获取游戏统计失败:', err);
          that.$parent.showTost(0, '获取数据失败，请稍后重试');
        });
    },
    // 显示平台选择弹出层
    showPlatformPopup() {
      this.showPlatformPop = true;
    },
    // 显示日期选择弹出层
    showDatePopup() {
      this.showDatePop = true;
    },
    // 选择平台
    selectPlatform(item) {
      this.platformFilter = item.platname;
      this.platformFilterName = item.name;
      this.showPlatformPop = false;
      this.getGameStat();
    },
    // 选择日期
    selectDate(index) {
      this.date = index;
      this.showDatePop = false;
      this.getGameStat();
    },
    // 跳转到投注记录页面，带上平台编码
    goToBetRecord(platformCode) {
      this.$router.push({
        name: 'betRecord',
        query: {
          api_type: platformCode,
          date: this.date,
        },
      });
    },
  },
  mounted() {
    let that = this;
    // 如果从路由参数中获取了 platform_code，设置筛选
    if (that.$route.query.api_type) {
      that.platformFilter = that.$route.query.api_type;
      // 找到对应的平台名称
      let platform = that.platformList.find(p => p.platname === that.platformFilter);
      if (platform) {
        that.platformFilterName = platform.name;
      }
    }
    if (that.$route.query.date) {
      that.date = parseInt(that.$route.query.date) || 1;
    }
  },
};
</script>

<style lang="scss" scoped>
.page-wrapper {
  width: 100%;
  height: 100vh;
  background: #f5f5f5;
  overflow: hidden;
  position: relative;
}

.content-container {
  width: 95%;
  min-width: 250px;
  margin: 0 auto;
  box-sizing: border-box;
  padding: 10px;
  height: calc(100vh - 46px);
  max-height: calc(100vh - 46px);
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.filter-box {
  display: flex;
  align-items: center;
  justify-content: space-around;
  height: 1.1rem;
  box-sizing: border-box;
  padding: 0 12px;
  margin-bottom: 15px;

  .filter-item {
    height: 0.8rem;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40%;
    background: #fff;
    border-radius: 1.1rem;
    font-size: 0.3rem;
    color: #333;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);

    span {
      margin-right: 5px;
    }
  }
}

.total-stats-card {
  background: #fff;
  border-radius: 10px;
  padding: 20px;
  margin-bottom: 15px;
  display: flex;
  justify-content: space-around;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
  flex-shrink: 0;

  .stat-item {
    flex: 1;
    text-align: center;
    position: relative;

    &:not(:last-child)::after {
      content: '';
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 1px;
      height: 40px;
      background: #f0f0f0;
    }

    .stat-label {
      font-size: 0.26rem;
      color: #999;
      margin-bottom: 10px;
    }

    .stat-value {
      font-size: 0.36rem;
      font-weight: bold;
      color: #333;

      &.win {
        color: #ee0a24; // 红色表示盈利
      }

      &.loss {
        color: #07c160; // 绿色表示亏损
      }
    }
  }
}

.platform-list {
  flex: 1;
  overflow-y: auto;
  overflow-x: hidden;
  -webkit-overflow-scrolling: touch;
  min-height: 0;
  /* 隐藏滚动条 */
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE 和 Edge */
  
  &::-webkit-scrollbar {
    display: none; /* Chrome, Safari 和 Opera */
  }

  .platform-card {
    background: #fff;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: all 0.3s;

    &:active {
      background: #f7f8fc;
      transform: scale(0.98);
    }

    .platform-icon {
      width: 1rem;
      height: 1rem;
      margin-right: 12px;
      border-radius: 8px;
      overflow: hidden;
      flex-shrink: 0;

      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .default-icon {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #9c27b0 0%, #7b2cbf 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.4rem;
        font-weight: bold;
      }
    }

    .platform-content {
      flex: 1;
      min-width: 0;

      .platform-name {
        font-size: 0.32rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
      }

      .platform-date {
        font-size: 0.24rem;
        color: #999;
        margin-bottom: 10px;
      }

      .platform-stats {
        display: flex;
        justify-content: space-between;

        .platform-stat-item {
          display: flex;
          flex-direction: column;

          .stat-label-small {
            font-size: 0.24rem;
            color: #999;
            margin-bottom: 3px;
          }

          .stat-value-small {
            font-size: 0.28rem;
            font-weight: bold;
            color: #333;

            &.win {
              color: #ee0a24; // 红色表示盈利
            }

            &.loss {
              color: #07c160; // 绿色表示亏损
            }
          }
        }
      }
    }

    .platform-arrow {
      margin-left: 10px;
      color: #999;
      font-size: 0.3rem;
      flex-shrink: 0;
      transition: all 0.3s;
    }
    
    &:hover .platform-arrow,
    &:active .platform-arrow {
      color: #9c27b0;
      transform: translateX(3px);
    }
  }
}

.empty-state {
  flex: 1;
  overflow-y: auto;
  overflow-x: hidden;
  -webkit-overflow-scrolling: touch;
  min-height: 0;
  margin-top: 60px;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  /* 隐藏滚动条 */
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE 和 Edge */
  
  &::-webkit-scrollbar {
    display: none; /* Chrome, Safari 和 Opera */
  }
}

.popup-header {
  height: 1rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 20px;
  border-bottom: 1px solid #eee;
  font-size: 0.32rem;
  font-weight: bold;
  background: #fff;
  color: #333;
}

.popup-content {
  padding: 10px;
  max-height: calc(100% - 1rem);
  overflow-y: auto;

  .popup-item {
    height: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 5px;

    .popup-item-text {
      width: calc(100% - 8px);
      height: 0.9rem;
      border: 0.02rem solid #cbced8;
      border-radius: 0.08rem;
      color: #a5a9b3;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.28rem;
      text-align: center;

      &.active {
        background: #9c27b0 !important;
        color: #fff;
        border: none;
      }
    }
  }
}

</style>
