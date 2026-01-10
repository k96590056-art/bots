<template>
  <div class="setting-page">
    <!-- 顶部导航 -->
    <div class="page-header">
      <div class="back-btn" @click="$router.back()">
        <svg viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2" width="20" height="20">
          <polyline points="15 18 9 12 15 6"/>
        </svg>
      </div>
      <span class="header-title">设置</span>
      <div class="header-right"></div>
    </div>

    <!-- 夜间模式卡片 -->
    <div class="setting-card">
      <div class="setting-item">
        <span class="item-label">夜间模式</span>
        <van-switch v-model="nightMode" size="24px" active-color="#4cd964" inactive-color="#ddd" @change="toggleNightMode" />
      </div>
    </div>

    <!-- 密码设置卡片 -->
    <div class="setting-card">
      <div class="setting-item" @click="$parent.goNav('/password?type=1')">
        <span class="item-label">修改密码</span>
        <div class="item-right">
          <svg viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" width="16" height="16">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </div>
      </div>
      <div class="setting-item no-border" @click="$parent.goNav('/password?type=2')">
        <span class="item-label">二级密码</span>
        <div class="item-right">
          <span class="item-status">{{ hasSecondPwd ? '已设置' : '未设置' }}</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" width="16" height="16">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </div>
      </div>
    </div>

    <!-- 退出按钮卡片 -->
    <div class="setting-card">
      <div class="logout-btn" @click="handleLogout">退出</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'userCent',
  data() {
    return {
      nightMode: false,
      hasSecondPwd: false,
    };
  },
  created() {
    let that = this;
    // 读取夜间模式状态
    that.nightMode = localStorage.getItem('nightMode') === 'true';
    // 检查是否设置了二级密码
    if (that.$store.state.userInfo && that.$store.state.userInfo.has_withdraw_pwd) {
      that.hasSecondPwd = true;
    }
  },
  methods: {
    toggleNightMode(val) {
      localStorage.setItem('nightMode', val);
    },
    handleLogout() {
      let that = this;
      that.$dialog.confirm({
        title: '提示',
        message: '确定要退出登录吗？',
      }).then(() => {
        // 清除所有存储（token 存储在 sessionStorage 中）
        localStorage.clear();
        sessionStorage.clear();
        // 使用正确的 mutation 名称更新 store 状态
        that.$store.commit('changUserInfo');
        that.$store.commit('changToken');
        // 跳转到首页
        that.$router.push({ path: '/' });
      }).catch(() => {});
    },
  },
  mounted() {},
};
</script>

<style lang="scss" scoped>
.setting-page {
  min-height: 100vh;
  background: #f5f5f5;
}

// 顶部导航
.page-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 15px;
  height: 50px;
  background: #fff;
  border-bottom: 1px solid #eee;

  .back-btn {
    width: 30px;
    display: flex;
    align-items: center;
  }

  .header-title {
    font-size: 17px;
    font-weight: 500;
    color: #333;
  }

  .header-right {
    width: 30px;
  }
}

// 设置卡片
.setting-card {
  background: #fff;
  margin: 10px 15px;
  border-radius: 10px;
  overflow: hidden;
}

.setting-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 15px;
  border-bottom: 1px solid #f0f0f0;

  &.no-border {
    border-bottom: none;
  }

  .item-label {
    font-size: 15px;
    color: #333;
  }

  .item-right {
    display: flex;
    align-items: center;

    .item-status {
      font-size: 14px;
      color: #999;
      margin-right: 5px;
    }
  }
}

// 退出按钮
.logout-btn {
  width: 100%;
  height: 50px;
  line-height: 50px;
  text-align: center;
  font-size: 16px;
  color: #333;
}
</style>
