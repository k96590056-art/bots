<template>
  <div class="feedback-page">
    <!-- 顶部导航栏 -->
    <div class="header">
      <div class="header-left" @click="goBack">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="15 18 9 12 15 6" />
        </svg>
      </div>
      <div class="header-title">意见反馈</div>
      <div class="header-right" @click="goMyFeedback">我的反馈</div>
    </div>

    <!-- 表单内容 -->
    <div class="form-content">
      <!-- 问题类型 -->
      <div class="form-item">
        <div class="form-label">
          <span>问题类型</span>
          <span class="required">*</span>
        </div>
        <div class="form-input" @click="showCategoryPicker = true">
          <input type="text" :value="categoryText" placeholder="请选择问题类型" readonly />
          <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#999" stroke-width="2">
            <polyline points="9 18 15 12 9 6" />
          </svg>
        </div>
      </div>

      <!-- 问题描述 -->
      <div class="form-item">
        <div class="form-label">
          <span>问题描述</span>
          <span class="required">*</span>
          <span class="hint">（内容介于20~200字）</span>
        </div>
        <div class="textarea-wrapper">
          <textarea
            v-model="content"
            placeholder="请详细描述您的问题或建议，我们将在24小时人工置顶，确保为您解答处理，感谢您的支持。"
            maxlength="200"
          ></textarea>
          <div class="char-count">{{ content.length }}/200</div>
        </div>
      </div>

      <!-- 提交按钮 -->
      <div class="submit-btn" :class="{ disabled: !canSubmit }" @click="handleSubmit">
        提交
        <span v-if="!canSubmit && content.length > 0 && content.length < 20" class="hint-text">
          （还需{{ 20 - content.length }}字）
        </span>
      </div>
    </div>

    <!-- 问题类型选择器 -->
    <van-popup v-model="showCategoryPicker" position="bottom">
      <van-picker
        :columns="categoryOptions"
        @confirm="onCategoryConfirm"
        @cancel="showCategoryPicker = false"
        show-toolbar
        title="请选择问题类型"
      />
    </van-popup>
  </div>
</template>

<script>
export default {
  name: 'feedback',
  data() {
    return {
      category: '',
      categoryText: '',
      content: '',
      showCategoryPicker: false,
      categoryOptions: [
        { text: '一般问题', value: 'general' },
        { text: '技术问题', value: 'technical' },
        { text: '账户问题', value: 'account' },
        { text: '支付问题', value: 'payment' },
        { text: '游戏问题', value: 'game' },
        { text: '其他', value: 'other' },
      ],
    };
  },
  computed: {
    canSubmit() {
      return this.category && this.content.length >= 20 && this.content.length <= 200;
    },
  },
  methods: {
    // 返回上一页
    goBack() {
      this.$router.go(-1);
    },
    // 跳转到我的反馈
    goMyFeedback() {
      this.$router.push({ path: '/myFeedback' });
    },
    // 选择问题类型
    onCategoryConfirm(value) {
      this.category = value.value;
      this.categoryText = value.text;
      this.showCategoryPicker = false;
    },
    // 提交反馈
    handleSubmit() {
      const that = this;

      // 检查问题类型
      if (!this.category) {
        this.$toast('请选择问题类型');
        return;
      }

      // 检查问题描述长度
      if (this.content.length < 20) {
        this.$toast('问题描述至少需要20个字符');
        return;
      }

      if (this.content.length > 200) {
        this.$toast('问题描述不能超过200个字符');
        return;
      }

      // 检查登录状态
      if (!this.$store.state.token) {
        this.$toast('请先登录');
        this.$router.push({ path: '/login' });
        return;
      }

      // 显示加载提示
      this.$toast.loading({
        message: '提交中...',
        forbidClick: true,
        duration: 0,
      });

      // 调用创建工单接口
      that.$apiFun
        .post('/api/workorder/create', {
          title: that.categoryText,
          content: that.content,
          category: that.category,
          priority: 'normal',
        })
        .then(res => {
          this.$toast.clear();
          if (res.code == 200) {
            this.$toast.success('提交成功');
            // 清空表单
            that.category = '';
            that.categoryText = '';
            that.content = '';
            // 延迟跳转到我的反馈页面
            setTimeout(() => {
              that.$router.push({ path: '/myFeedback' });
            }, 1500);
          } else {
            this.$toast(res.message || '提交失败，请稍后重试');
          }
        })
        .catch(err => {
          this.$toast.clear();
          this.$toast('网络错误，请稍后重试');
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.feedback-page {
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
    text-align: right;
    color: #666;
    font-size: 14px;
    cursor: pointer;
  }
}

// 表单内容
.form-content {
  padding: 16px;
}

.form-item {
  margin-bottom: 20px;

  .form-label {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    font-size: 15px;
    color: #333;

    .required {
      color: #ff4444;
      margin-left: 2px;
    }

    .hint {
      font-size: 12px;
      color: #999;
      margin-left: 4px;
    }
  }

  .form-input {
    display: flex;
    align-items: center;
    background-color: #fff;
    border-radius: 8px;
    padding: 12px 16px;
    cursor: pointer;

    input {
      flex: 1;
      border: none;
      outline: none;
      font-size: 14px;
      color: #333;

      &::placeholder {
        color: #ccc;
      }
    }

    svg {
      flex-shrink: 0;
      margin-left: 8px;
      transform: rotate(90deg);
    }
  }

  .textarea-wrapper {
    position: relative;
    background-color: #fff;
    border-radius: 8px;
    padding: 12px 16px;

    textarea {
      width: 100%;
      min-height: 120px;
      border: none;
      outline: none;
      font-size: 14px;
      color: #333;
      resize: none;
      line-height: 1.6;

      &::placeholder {
        color: #ccc;
      }
    }

    .char-count {
      text-align: right;
      font-size: 12px;
      color: #999;
      margin-top: 8px;
    }
  }
}

// 提交按钮
.submit-btn {
  margin-top: 30px;
  padding: 14px;
  background: linear-gradient(135deg, #4a4a4a 0%, #2d2d2d 100%);
  color: #fff;
  font-size: 16px;
  font-weight: 500;
  text-align: center;
  border-radius: 8px;
  cursor: pointer;

  &.disabled {
    background: #e0e0e0;
    color: #999;
    cursor: not-allowed;
  }

  .hint-text {
    font-size: 12px;
    color: #ff9800;
    margin-left: 8px;
  }
}
</style>
