<template>
  <div class="sponsor-page">
    <!-- 顶部标题 -->
    <div class="page-header">
      <span>赞助专题</span>
    </div>

    <!-- 赞助卡片列表 -->
    <div class="sponsor-list">
      <!-- 佛罗伦萨 -->
      <div class="sponsor-card" @click="toDetail(1)">
        <div class="card-left">
          <div class="team-logo">
            <img src="/static/image/ddf471901f2b4fff9ee57015a1698227.png" alt="佛罗伦萨" />
          </div>
          <div class="partner-label">官方区域合作伙伴</div>
          <div class="team-name">佛罗伦萨</div>
          <div class="view-btn">查看详情</div>
        </div>
        <div class="card-right">
          <img src="/static/image/01.png" alt="球队图片" />
        </div>
      </div>

      <!-- 赫塔菲 -->
      <div class="sponsor-card" @click="toDetail(2)">
        <div class="card-left">
          <div class="team-logo">
            <img src="/static/image/ddf471901f2b4fff9ee57015a1698227.png" alt="赫塔菲" />
          </div>
          <div class="partner-label">官方独家区域合作伙伴</div>
          <div class="team-name">赫塔菲</div>
          <div class="view-btn">查看详情</div>
        </div>
        <div class="card-right">
          <img src="/static/image/02.png" alt="球队图片" />
        </div>
      </div>
    </div>

    <!-- 底部占位 -->
    <div style="height: 80px;"></div>
  </div>
</template>

<script>
export default {
  name: 'zhanzhu',
  data() {
    return {};
  },
  methods: {
    toDetail(/*type*/) {
      this.$router.push({ path: '/applyagent' });
    },
  },
  created() {},
  mounted() {},
  updated() {},
  beforeDestroy() {},
};
</script>

<style lang="scss" scoped>
.sponsor-page {
  min-height: 100vh;
  background: #f5f5f5;
}

// 顶部标题
.page-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 50px;
  background: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  border-bottom: 1px solid #eee;
  z-index: 100;

  span {
    font-size: 18px !important;
    font-weight: 600 !important;
    color: #333 !important;
  }
}

// 赞助列表
.sponsor-list {
  padding: 60px 15px 0;
}

// 赞助卡片
.sponsor-card {
  display: flex;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  margin-bottom: 15px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);

  .card-left {
    width: 40%;
    padding: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    .team-logo {
      width: 50px;
      height: 50px;
      margin-bottom: 8px;

      img {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
    }

    .partner-label {
      font-size: 11px;
      color: #999;
      margin-bottom: 5px;
      text-align: center;
    }

    .team-name {
      font-size: 20px;
      font-weight: 700;
      color: #333;
      margin-bottom: 12px;
    }

    .view-btn {
      padding: 6px 16px;
      border: 1px solid #4a8cca;
      border-radius: 15px;
      font-size: 12px;
      color: #4a8cca;
      cursor: pointer;
    }
  }

  .card-right {
    width: 60%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;

    img {
      width: 100%;
      object-fit: cover;
    }
  }
}
</style>
