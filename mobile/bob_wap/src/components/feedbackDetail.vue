<template>
  <div class="feedback-detail-page">
    <!-- 顶部导航栏 -->
    <div class="header">
      <div class="header-left" @click="goBack">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="15 18 9 12 15 6" />
        </svg>
      </div>
      <div class="header-title">反馈详情</div>
      <div class="header-right"></div>
    </div>

    <div v-if="loading" class="loading-box">
      <van-loading type="spinner" size="24px">加载中...</van-loading>
    </div>

    <div v-else-if="detail" class="detail-content">
      <!-- 工单信息 -->
      <div class="work-order-info">
        <div class="info-row">
          <span class="label">工单编号：</span>
          <span class="value">{{ detail.order_no }}</span>
        </div>
        <div class="info-row">
          <span class="label">提交时间：</span>
          <span class="value">{{ detail.created_at }}</span>
        </div>
        <div class="info-row">
          <span class="label">问题类型：</span>
          <span class="value">{{ detail.category_text }}</span>
        </div>
        <div class="info-row">
          <span class="label">状态：</span>
          <span class="value status" :class="'status-' + detail.status">{{ detail.status_text }}</span>
        </div>
      </div>

      <!-- 问题描述 -->
      <div class="problem-section">
        <div class="section-title">问题描述</div>
        <div class="section-content">{{ detail.content }}</div>
      </div>

      <!-- 回复记录 -->
      <div v-if="detail.replies && detail.replies.length > 0" class="reply-section">
        <div class="section-title">回复记录</div>
        <div class="reply-list">
          <div v-for="reply in detail.replies" :key="reply.id" class="reply-item" :class="'reply-' + reply.type">
            <div class="reply-header">
              <span class="reply-author">{{ reply.type === 'admin' ? '客服' : '我' }}</span>
              <span class="reply-time">{{ reply.created_at }}</span>
            </div>
            <div class="reply-content">{{ reply.content }}</div>
          </div>
        </div>
      </div>

      <!-- 回复区域 -->
      <div v-if="detail.status !== 'closed'" class="reply-area">
        <div class="section-title">回复内容</div>
        <textarea v-model="replyContent" placeholder="请输入您的回复内容..." maxlength="2000"></textarea>
        <div class="reply-actions">
          <div class="char-count">{{ replyContent.length }}/2000</div>
          <div class="action-buttons">
            <div class="btn-cancel" @click="replyContent = ''">清空</div>
            <div class="btn-submit" :class="{ disabled: !replyContent.trim() }" @click="handleReply">提交回复</div>
          </div>
        </div>
      </div>

      <!-- 关闭工单 -->
      <div v-if="detail.status !== 'closed'" class="close-section">
        <div class="close-btn" @click="handleClose">关闭工单</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'feedbackDetail',
  data() {
    return {
      loading: false,
      detail: null,
      replyContent: '',
      workOrderId: null,
    };
  },
  created() {
    this.workOrderId = this.$route.query.id;
    if (this.workOrderId) {
      this.loadDetail();
    } else {
      this.$toast('参数错误');
      this.$router.go(-1);
    }
  },
  methods: {
    // 返回上一页
    goBack() {
      this.$router.go(-1);
    },
    // 加载详情
    loadDetail() {
      const that = this;
      that.loading = true;

      that.$apiFun
        .post('/api/workorder/detail', {
          id: that.workOrderId,
        })
        .then(res => {
          that.loading = false;
          if (res.code == 200) {
            that.detail = res.data;
          } else {
            this.$toast(res.message || '加载失败');
          }
        })
        .catch(err => {
          that.loading = false;
          this.$toast('网络错误，请稍后重试');
        });
    },
    // 提交回复
    handleReply() {
      const that = this;
      const content = that.replyContent.trim();

      if (!content) {
        return;
      }

      this.$toast.loading({
        message: '提交中...',
        forbidClick: true,
        duration: 0,
      });

      that.$apiFun
        .post('/api/workorder/reply', {
          work_order_id: that.workOrderId,
          content: content,
        })
        .then(res => {
          this.$toast.clear();
          if (res.code == 200) {
            this.$toast.success('回复成功');
            that.replyContent = '';
            // 重新加载详情
            that.loadDetail();
          } else {
            this.$toast(res.message || '回复失败，请稍后重试');
          }
        })
        .catch(err => {
          this.$toast.clear();
          this.$toast('网络错误，请稍后重试');
        });
    },
    // 关闭工单
    handleClose() {
      const that = this;

      this.$dialog
        .confirm({
          title: '提示',
          message: '确定要关闭此工单吗？',
        })
        .then(() => {
          this.$toast.loading({
            message: '处理中...',
            forbidClick: true,
            duration: 0,
          });

          that.$apiFun
            .post('/api/workorder/close', {
              id: that.workOrderId,
            })
            .then(res => {
              this.$toast.clear();
              if (res.code == 200) {
                this.$toast.success('工单已关闭');
                // 重新加载详情
                that.loadDetail();
              } else {
                this.$toast(res.message || '操作失败，请稍后重试');
              }
            })
            .catch(err => {
              this.$toast.clear();
              this.$toast('网络错误，请稍后重试');
            });
        })
        .catch(() => {});
    },
  },
};
</script>

<style lang="scss" scoped>
.feedback-detail-page {
  min-height: 100vh;
  background-color: #f5f5f5;
  padding-bottom: 20px;
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

.loading-box {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 20px;
}

.detail-content {
  padding: 16px;

  .section-title {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    margin-bottom: 12px;
  }

  // 工单信息
  .work-order-info {
    background-color: #fff;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;

    .info-row {
      display: flex;
      align-items: center;
      margin-bottom: 12px;
      font-size: 14px;

      &:last-child {
        margin-bottom: 0;
      }

      .label {
        color: #999;
        width: 80px;
        flex-shrink: 0;
      }

      .value {
        flex: 1;
        color: #333;

        &.status {
          display: inline-block;
          padding: 4px 10px;
          border-radius: 4px;
          font-size: 12px;

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
    }
  }

  // 问题描述
  .problem-section {
    background-color: #fff;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;

    .section-content {
      font-size: 14px;
      color: #666;
      line-height: 1.6;
      white-space: pre-wrap;
    }
  }

  // 回复记录
  .reply-section {
    background-color: #fff;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;

    .reply-list {
      .reply-item {
        margin-bottom: 16px;
        padding: 12px;
        border-radius: 6px;

        &:last-child {
          margin-bottom: 0;
        }

        &.reply-admin {
          background-color: #f5f5f5;
        }

        &.reply-user {
          background-color: #e3f2fd;
        }

        .reply-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 8px;

          .reply-author {
            font-size: 14px;
            font-weight: 500;
            color: #333;
          }

          .reply-time {
            font-size: 12px;
            color: #999;
          }
        }

        .reply-content {
          font-size: 14px;
          color: #666;
          line-height: 1.6;
          white-space: pre-wrap;
        }
      }
    }
  }

  // 回复区域
  .reply-area {
    background-color: #fff;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;

    textarea {
      width: 100%;
      min-height: 100px;
      border: 1px solid #e0e0e0;
      border-radius: 6px;
      padding: 12px;
      font-size: 14px;
      color: #333;
      resize: none;
      outline: none;
      line-height: 1.6;

      &::placeholder {
        color: #ccc;
      }
    }

    .reply-actions {
      margin-top: 12px;

      .char-count {
        font-size: 12px;
        color: #999;
        margin-bottom: 8px;
      }

      .action-buttons {
        display: flex;
        gap: 12px;

        .btn-cancel,
        .btn-submit {
          flex: 1;
          padding: 10px;
          text-align: center;
          font-size: 14px;
          border-radius: 6px;
          cursor: pointer;
        }

        .btn-cancel {
          background-color: #f5f5f5;
          color: #666;
        }

        .btn-submit {
          background: linear-gradient(135deg, #4a4a4a 0%, #2d2d2d 100%);
          color: #fff;

          &.disabled {
            background: #e0e0e0;
            color: #999;
            cursor: not-allowed;
          }
        }
      }
    }
  }

  // 关闭工单
  .close-section {
    .close-btn {
      padding: 12px;
      background-color: #fff;
      color: #ff4444;
      font-size: 14px;
      text-align: center;
      border-radius: 8px;
      cursor: pointer;
      border: 1px solid #ff4444;
    }
  }
}
</style>
