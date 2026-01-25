<template>
  <div class="sponsor-page">
    <!-- 顶部标题 -->
    <div class="page-header">
      <span>赞助专题</span>
    </div>

    <!-- 赞助卡片列表 -->
    <div class="sponsor-list">
      <div
        v-for="item in sponsorList"
        :key="item.id"
        class="sponsor-card"
      >
        <div class="card-left">
          <div class="team-logo">
            <img :src="item.logo" :alt="item.name" />
          </div>
          <div class="partner-label">{{ item.title }}</div>
          <div class="team-name">{{ item.name }}</div>
        </div>
        <div class="card-right">
          <img :src="item.banner" :alt="item.name" />
        </div>
      </div>
      <div v-if="sponsorList.length === 0 && !loading" class="empty-tip">暂无赞助数据</div>
    </div>

    <!-- 底部占位 -->
    <div style="height: 80px;"></div>
  </div>
</template>

<script>
export default {
  name: 'zhanzhu',
  data() {
    return {
      sponsorList: [],
      loading: false,
    };
  },
  methods: {
    getList() {
      const that = this;
      that.loading = true;
      that.$parent && that.$parent.showLoading && that.$parent.showLoading();
      that.$apiFun.get('/api/sponsorList', {}).then(res => {
        that.loading = false;
        that.$parent && that.$parent.hideLoading && that.$parent.hideLoading();
        if (res.code === 200 && Array.isArray(res.data)) {
          that.sponsorList = res.data;
        } else {
          that.$toast && that.$toast(res.message || '获取失败');
        }
      }).catch(() => {
        that.loading = false;
        that.$parent && that.$parent.hideLoading && that.$parent.hideLoading();
      });
    },
    toDetail(item) {
      const url = item && item.link_url;
      if (url && typeof url === 'string' && url.trim()) {
        const trimmed = url.trim();
        if (/^https?:\/\//i.test(trimmed)) {
          this.$router.push({
            path: '/webview',
            query: {
              url: encodeURIComponent(trimmed),
              title: (item && item.name) || '打开链接',
            },
          });
          return;
        }
        if (trimmed.startsWith('/')) {
          this.$router.push({ path: trimmed });
          return;
        }
      }
      this.$router.push({ path: '/applyagent' });
    },
  },
  created() {
    this.getList();
  },
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
.empty-tip {
  text-align: center;
  padding: 40px 20px;
  font-size: 14px;
  color: #999;
}

// 赞助卡片：左右高度与图片一致，上下 10px 内边距
.sponsor-card {
  display: flex;
  align-items: center;
  padding: 10px;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  margin-bottom: 15px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);

  .card-left {
    width: 40%;
    padding: 0 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    .team-logo {
      width: 40px;
      height: 40px;
      margin-bottom: 4px;
      flex-shrink: 0;

      img {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
    }

    .partner-label {
      font-size: 10px;
      color: #999;
      margin: 5px 0 2px 0;
      text-align: center;
      line-height: 1.2;
    }

    .team-name {
      font-size: 16px;
      font-weight: 700;
      color: #333;
      margin: 6px 0;
      line-height: 1.2;
    }

    .view-btn {
      padding: 4px 12px;
      border: 1px solid #4a8cca;
      border-radius: 12px;
      font-size: 11px;
      color: #4a8cca;
      cursor: pointer;
    }
  }

  .card-right {
    width: 60%;
    height: 90px;
    border-radius: 5px;
    flex-shrink: 0;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
  }
}
</style>
