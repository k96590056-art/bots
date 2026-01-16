<template>
  <div class="message-page">
    <van-nav-bar
      title="消息"
      left-arrow
      @click-left="$router.back()"
      class="message-nav"
    >
      <template #right>
        <van-icon name="bag-o" size="20" style="margin-right: 12px;" />
        <van-icon name="ellipsis" size="20" />
      </template>
    </van-nav-bar>

    <van-tabs v-model="activeTab" animated swipeable color="#1989fa" title-active-color="#1989fa" title-inactive-color="#666">
      <van-tab name="all">
        <template #title>
          全部
          <van-badge v-if="unreadCount.all > 0" :content="unreadCount.all" max="99" />
        </template>
        <div class="message-list">
          <van-list v-if="messageList.all.length > 0" finished finished-text="">
            <div
              v-for="(item, index) in messageList.all"
              :key="index"
              class="message-item"
              @click="handleItemClick(item)"
            >
              <div class="message-icon">
                <div :class="['icon-wrapper', item.iconType]">
                  <van-icon :name="item.icon" size="24" />
                </div>
              </div>

              <div class="message-content">
                <div class="message-title">
                  <span v-html="item.title"></span>
                </div>
                <div class="message-desc">{{ item.desc }}</div>
              </div>

              <div class="message-right">
                <div class="message-time">{{ item.time }}</div>
                <div v-if="item.unread" class="unread-dot"></div>
              </div>

              <van-icon name="arrow" color="#ddd" class="arrow-icon" />
            </div>
          </van-list>
          <van-empty v-else description="暂无消息" />
        </div>
      </van-tab>

      <van-tab name="notice">
        <template #title>
          通知
          <van-badge v-if="unreadCount.notice > 0" :content="unreadCount.notice" max="99" />
        </template>
        <div class="message-list">
          <van-list v-if="messageList.notice.length > 0" finished finished-text="">
            <div
              v-for="(item, index) in messageList.notice"
              :key="index"
              class="message-item"
              @click="handleItemClick(item)"
            >
              <div class="message-icon">
                <div :class="['icon-wrapper', item.iconType]">
                  <van-icon :name="item.icon" size="24" />
                </div>
              </div>

              <div class="message-content">
                <div class="message-title">
                  <span v-html="item.title"></span>
                </div>
                <div class="message-desc">{{ item.desc }}</div>
              </div>

              <div class="message-right">
                <div class="message-time">{{ item.time }}</div>
                <div v-if="item.unread" class="unread-dot"></div>
              </div>

              <van-icon name="arrow" color="#ddd" class="arrow-icon" />
            </div>
          </van-list>
          <van-empty v-else description="暂无消息" />
        </div>
      </van-tab>

      <van-tab name="promotion">
        <template #title>
          优惠
          <van-badge v-if="unreadCount.promotion > 0" :content="unreadCount.promotion" max="99" />
        </template>
        <div class="message-list">
          <van-list v-if="messageList.promotion.length > 0" finished finished-text="">
            <div
              v-for="(item, index) in messageList.promotion"
              :key="index"
              class="message-item"
              @click="handleItemClick(item)"
            >
              <div class="message-icon">
                <div :class="['icon-wrapper', item.iconType]">
                  <van-icon :name="item.icon" size="24" />
                </div>
              </div>

              <div class="message-content">
                <div class="message-title">
                  <span v-html="item.title"></span>
                </div>
                <div class="message-desc">{{ item.desc }}</div>
              </div>

              <div class="message-right">
                <div class="message-time">{{ item.time }}</div>
                <div v-if="item.unread" class="unread-dot"></div>
              </div>

              <van-icon name="arrow" color="#ddd" class="arrow-icon" />
            </div>
          </van-list>
          <van-empty v-else description="暂无消息" />
        </div>
      </van-tab>

      <van-tab name="withdraw">
        <template #title>
          兑提
        </template>
        <div class="message-list">
          <van-list v-if="messageList.withdraw.length > 0" finished finished-text="">
            <div
              v-for="(item, index) in messageList.withdraw"
              :key="index"
              class="message-item"
              @click="handleItemClick(item)"
            >
              <div class="message-icon">
                <div :class="['icon-wrapper', item.iconType]">
                  <van-icon :name="item.icon" size="24" />
                </div>
              </div>

              <div class="message-content">
                <div class="message-title">
                  <span v-html="item.title"></span>
                </div>
                <div class="message-desc">{{ item.desc }}</div>
              </div>

              <div class="message-right">
                <div class="message-time">{{ item.time }}</div>
                <div v-if="item.unread" class="unread-dot"></div>
              </div>

              <van-icon name="arrow" color="#ddd" class="arrow-icon" />
            </div>
          </van-list>
          <van-empty v-else description="暂无消息" />
        </div>
      </van-tab>

      <van-tab name="private">
        <template #title>
          私信
          <van-badge v-if="unreadCount.private > 0" :content="unreadCount.private" max="99" />
        </template>
        <div class="message-list">
          <van-list v-if="messageList.private.length > 0" finished finished-text="">
            <div
              v-for="(item, index) in messageList.private"
              :key="index"
              class="message-item"
              @click="handleItemClick(item)"
            >
              <div class="message-icon">
                <div :class="['icon-wrapper', item.iconType]">
                  <van-icon :name="item.icon" size="24" />
                </div>
              </div>

              <div class="message-content">
                <div class="message-title">
                  <span v-html="item.title"></span>
                </div>
                <div class="message-desc">{{ item.desc }}</div>
              </div>

              <div class="message-right">
                <div class="message-time">{{ item.time }}</div>
                <div v-if="item.unread" class="unread-dot"></div>
              </div>

              <van-icon name="arrow" color="#ddd" class="arrow-icon" />
            </div>
          </van-list>
          <van-empty v-else description="暂无消息" />
        </div>
      </van-tab>
    </van-tabs>

    <!-- 消息详情弹窗 -->
    <van-dialog v-model="showDetail" :title="currentMessage.title" :showConfirmButton="true" confirmButtonText="关闭">
      <div class="message-detail">
        <div class="detail-time">{{ currentMessage.time }}</div>
        <div class="detail-content" v-html="currentMessage.fullContent || currentMessage.desc"></div>
      </div>
    </van-dialog>
  </div>
</template>

<script>
export default {
  name: 'message',
  data() {
    return {
      activeTab: 'all',
      unreadCount: {
        all: 0,
        notice: 0,
        promotion: 0,
        withdraw: 0,
        private: 0
      },
      messageList: {
        all: [],
        notice: [],
        promotion: [],
        withdraw: [],
        private: []
      },
      showDetail: false,
      currentMessage: {}
    };
  },
  created() {
    this.loadMessages();
  },
  methods: {
    loadMessages() {
      this.loadNotices();
      this.loadPrivateMessages();
    },

    loadNotices() {
      this.$apiFun.post('/api/homenotice', {}).then(res => {
        if (res.code == 200 && res.data) {
          const notices = res.data.map((content, index) => ({
            id: `notice_${index}`,
            type: 'notice',
            icon: 'volume-o',
            iconType: 'icon-blue',
            title: '系统公告',
            desc: this.truncateText(content, 30),
            fullContent: content,
            time: '',
            unread: false
          }));

          this.messageList.notice = notices;
          this.updateAllMessages();
          this.calculateUnreadCount();
        }
      }).catch(err => {
        console.error('加载公告失败', err);
      });
    },

    loadPrivateMessages() {
      this.$apiFun.post('/api/noticeList', { page: 1 }).then(res => {
        if (res.code == 200 && res.data && res.data.data) {
          const privateMessages = res.data.data.map(item => ({
            id: item.id,
            type: 'private',
            icon: 'service-o',
            iconType: 'icon-orange',
            title: item.title,
            desc: this.stripHtml(item.content, 30),
            fullContent: item.content,
            time: this.formatTime(item.created_at),
            unread: item.is_read === 0,
            rawData: item
          }));

          this.messageList.private = privateMessages;
          this.updateAllMessages();
          this.calculateUnreadCount();
        }
      }).catch(err => {
        console.error('加载站内信失败', err);
      });
    },

    updateAllMessages() {
      this.messageList.all = [
        ...this.messageList.notice,
        ...this.messageList.promotion,
        ...this.messageList.withdraw,
        ...this.messageList.private
      ].sort((a, b) => {
        return this.getTimeValue(b.time) - this.getTimeValue(a.time);
      });
    },

    calculateUnreadCount() {
      this.unreadCount.notice = this.messageList.notice.filter(m => m.unread).length;
      this.unreadCount.promotion = this.messageList.promotion.filter(m => m.unread).length;
      this.unreadCount.withdraw = this.messageList.withdraw.filter(m => m.unread).length;
      this.unreadCount.private = this.messageList.private.filter(m => m.unread).length;

      this.unreadCount.all =
        this.unreadCount.notice +
        this.unreadCount.promotion +
        this.unreadCount.withdraw +
        this.unreadCount.private;
    },

    getTimeValue(timeStr) {
      if (!timeStr) return 0;
      if (timeStr.includes(':')) {
        const [h, m] = timeStr.split(':');
        return parseInt(h) * 60 + parseInt(m);
      }
      if (timeStr === '昨天') return -1;
      if (timeStr.includes('星期')) return -2;
      return -3;
    },

    truncateText(text, maxLength) {
      if (!text) return '';
      const cleanText = this.stripHtml(text);
      if (cleanText.length <= maxLength) return cleanText;
      return cleanText.substring(0, maxLength) + '…';
    },

    stripHtml(html, maxLength) {
      if (!html) return '';
      const div = document.createElement('div');
      div.innerHTML = html;
      const text = div.textContent || div.innerText || '';
      if (maxLength && text.length > maxLength) {
        return text.substring(0, maxLength) + '…';
      }
      return text;
    },

    formatTime(datetime) {
      if (!datetime) return '';
      const date = new Date(datetime);
      const now = new Date();
      const diff = now - date;

      if (diff < 24 * 60 * 60 * 1000) {
        return `${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;
      }
      if (diff < 48 * 60 * 60 * 1000) {
        return '昨天';
      }
      if (diff < 7 * 24 * 60 * 60 * 1000) {
        const days = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
        return days[date.getDay()];
      }
      return `${date.getMonth() + 1}-${date.getDate()}`;
    },

    handleItemClick(item) {
      this.currentMessage = item;
      this.showDetail = true;

      // 标记为已读
      if (item.unread && item.rawData) {
        this.markAsRead(item);
      }
    },

    markAsRead(item) {
      // 如果有站内信ID，调用已读接口
      if (item.rawData && item.rawData.id) {
        this.$apiFun.post('/api/readNotice', { id: item.rawData.id }).then(res => {
          if (res.code == 200) {
            item.unread = false;
            this.calculateUnreadCount();
          }
        }).catch(err => {
          console.error('标记已读失败', err);
        });
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.message-page {
  min-height: 100vh;
  background-color: #f7f8fa;
}

.message-nav {
  background-color: #fff;
}

.message-list {
  background-color: #fff;
}

.message-item {
  display: flex;
  align-items: center;
  padding: 12px 16px;
  background-color: #fff;
  border-bottom: 1px solid #f0f0f0;
  position: relative;

  &:active {
    background-color: #f7f8fa;
  }
}

.message-icon {
  margin-right: 12px;

  .icon-wrapper {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;

    &.icon-blue {
      background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
      color: #fff;
    }

    &.icon-orange {
      background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
      color: #fff;
    }

    &.icon-red {
      background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      color: #fff;
    }
  }
}

.message-content {
  flex: 1;
  min-width: 0;
  margin-right: 8px;
}

.message-title {
  font-size: 15px;
  font-weight: 500;
  color: #323233;
  margin-bottom: 4px;
}

.message-desc {
  font-size: 13px;
  color: #969799;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.message-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  margin-right: 8px;
}

.message-time {
  font-size: 12px;
  color: #969799;
  margin-bottom: 4px;
}

.unread-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background-color: #ee0a24;
}

.arrow-icon {
  font-size: 14px;
}

.message-detail {
  padding: 16px;
  max-height: 60vh;
  overflow-y: auto;

  .detail-time {
    font-size: 12px;
    color: #969799;
    margin-bottom: 12px;
    text-align: center;
  }

  .detail-content {
    font-size: 14px;
    line-height: 1.6;
    color: #323233;
    word-wrap: break-word;
  }
}
</style>

<style lang="scss">
.message-nav .van-nav-bar__title {
  font-size: 17px;
  font-weight: 500;
}

.message-page .van-tabs__wrap {
  background-color: #fff;
}

.message-page .van-tab {
  font-size: 15px;
  padding: 0 12px;
}

.message-page .van-tab .van-badge {
  margin-left: 4px;
}

.message-page .van-tabs__line {
  width: 20px;
  height: 3px;
}
</style>
