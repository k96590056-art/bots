<template>
  <div class="my-feedback-page">
    <!-- 顶部导航栏 -->
    <div class="header">
      <div class="header-left" @click="goBack">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="15 18 9 12 15 6" />
        </svg>
      </div>
      <div class="header-title">我的反馈</div>
      <div class="header-right"></div>
    </div>

    <!-- 反馈列表 -->
    <div class="feedback-list">
      <div v-if="loading" class="loading-box">
        <van-loading type="spinner" size="24px">加载中...</van-loading>
      </div>

      <div v-else-if="list.length === 0" class="empty-box">
        <img src="/static/image/__al__noData.d3fb15d01bf13bd9bd9f693001cf1661.png" alt="暂无数据" />
        <p>暂无反馈记录</p>
      </div>

      <div v-else class="list-content">
        <div v-for="item in list" :key="item.id" class="feedback-item" @click="goDetail(item.id)">
          <div class="item-header">
            <div class="item-title">{{ item.title }}</div>
            <div class="item-status" :class="'status-' + item.status">{{ item.status_text }}</div>
          </div>
          <div class="item-content">{{ item.content }}</div>
          <div class="item-footer">
            <div class="item-time">{{ item.created_at }}</div>
            <div class="item-category">{{ item.category_text }}</div>
          </div>
        </div>
      </div>

      <!-- 加载更多 -->
      <div v-if="!loading && hasMore" class="load-more" @click="loadMore">加载更多</div>
      <div v-if="!loading && !hasMore && list.length > 0" class="no-more">没有更多了</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'myFeedback',
  data() {
    return {
      loading: false,
      list: [],
      page: 1,
      limit: 10,
      total: 0,
    };
  },
  computed: {
    hasMore() {
      return this.list.length < this.total;
    },
  },
  created() {
    this.loadList();
  },
  methods: {
    // 返回上一页
    goBack() {
      this.$router.go(-1);
    },
    // 加载列表
    loadList() {
      const that = this;
      that.loading = true;

      that.$apiFun
        .post('/api/workorder/list', {
          page: that.page,
          limit: that.limit,
        })
        .then(res => {
          that.loading = false;
          if (res.code == 200) {
            if (that.page === 1) {
              that.list = res.data.list;
            } else {
              that.list = that.list.concat(res.data.list);
            }
            that.total = res.data.total;
          } else {
            this.$toast(res.message || '加载失败');
          }
        })
        .catch(err => {
          that.loading = false;
          this.$toast('网络错误，请稍后重试');
        });
    },
    // 加载更多
    loadMore() {
      if (this.loading || !this.hasMore) {
        return;
      }
      this.page++;
      this.loadList();
    },
    // 查看详情
    goDetail(id) {
      this.$router.push({ path: '/feedbackDetail', query: { id } });
    },
  },
};
</script>

<style lang="scss" scoped>
.my-feedback-page {
  min-height: 100vh;
  background-color: #f5f5f5;
}

// 顶部导航栏
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  background-color: #fff;
  position: sticky;
  top: 0;
  z-index: 100;

  .header-left {
    width: 60px;
    display: flex;
    align-items: center;
    cursor: pointer;
    color: #333;
  }

  .header-title {
    flex: 1;
    font-size: 18px;
    font-weight: 500;
    color: #333;
    text-align: center;
  }

  .header-right {
    width: 60px;
  }
}

// 反馈列表
.feedback-list {
  padding: 16px;

  .loading-box,
  .empty-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;

    img {
      width: 120px;
      height: 120px;
      margin-bottom: 16px;
    }

    p {
      font-size: 14px;
      color: #999;
    }
  }

  .list-content {
    .feedback-item {
      background-color: #fff;
      border-radius: 8px;
      padding: 16px;
      margin-bottom: 12px;
      cursor: pointer;

      .item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;

        .item-title {
          flex: 1;
          font-size: 16px;
          font-weight: 500;
          color: #333;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
        }

        .item-status {
          flex-shrink: 0;
          margin-left: 12px;
          padding: 4px 10px;
          font-size: 12px;
          border-radius: 4px;

          &.status-pending {
            background-color: #fff3e0;
            color: #ff9800;
          }

          &.status-processing {
            background-color: #e3f2fd;
            color: #2196f3;
          }

          &.status-replied {
            background-color: #e8f5e9;
            color: #4caf50;
          }

          &.status-closed {
            background-color: #f5f5f5;
            color: #999;
          }
        }
      }

      .item-content {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 10px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
      }

      .item-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        color: #999;

        .item-time {
          flex: 1;
        }

        .item-category {
          flex-shrink: 0;
          margin-left: 12px;
        }
      }
    }
  }

  .load-more,
  .no-more {
    text-align: center;
    padding: 16px;
    font-size: 14px;
    color: #999;
  }

  .load-more {
    cursor: pointer;
    color: #666;
  }
}
</style>
