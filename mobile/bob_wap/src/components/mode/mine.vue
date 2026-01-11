<template>
  <div class="mine-page">
    <!-- 顶部用户信息 - 灰色背景 -->
    <div class="user-header">
      <div class="user-info-row">
        <div class="user-avatar" @click="!$store.state.token && $parent.goNav('/login')">
          <!-- 未登录状态：默认头像 -->
          <img v-if="!$store.state.token" class="default-avatar-img" src="/static/image/default_avatar.png" alt="默认头像" />
          <!-- 登录状态：用户头像 -->
          <template v-else>
            <img :src="$store.state.userInfo.avatar || '/static/image/imageAvatar02@3x.png'" alt="avatar" />
            <input class="avatar-input" type="file" @change="onchangemd" accept="image/gif,image/png" />
          </template>
        </div>
        <div class="user-details" @click="!$store.state.token && $parent.goNav('/login')">
          <div class="user-name">{{ $store.state.token ? $store.state.userInfo.username : '点击登录/注册' }}</div>
          <div class="user-days" v-if="$store.state.token">加入星乐第{{ joinDays }}天</div>
          <div class="user-days not-login" v-else>您还未登录</div>
        </div>
        <div class="header-actions">
          <div class="action-icon" @click="$parent.goNav('/userCent')">
            <svg viewBox="0 0 24 24" fill="#666" width="30" height="30">
              <path d="M19.14,12.94c0.04-0.31,0.06-0.63,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/>
            </svg>
          </div>
          <div class="action-icon" @click="$parent.goNav('/message')">
            <svg viewBox="0 0 24 24" fill="#666" width="30" height="30">
              <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <div class="content-area">
      <!-- VIP卡片 -->
      <div class="vip-card">
        <div class="vip-box" @click="$store.state.token ? $parent.goNav('/vip') : $parent.goNav('/login')">
          <!-- VIP等级和进度条 -->
          <div class="vip-progress-row">
            <div class="vip-level-left">
              <img :src="'/static/image/vip' + (vipInfo.currentLevel || 0) + '.png'" class="vip-level-icon" alt="当前VIP等级" />
            </div>
            <div class="vip-progress-bar">
              <div class="progress-track">
                <div class="progress-fill" :style="{ width: vipProgressPercent + '%' }"></div>
              </div>
            </div>
            <div class="vip-level-right">
              <img :src="'/static/image/vip' + (vipInfo.nextLevel || 1) + '.png'" class="vip-level-icon" alt="下一VIP等级" />
            </div>
          </div>
          <!-- 流水信息和更多特权链接 -->
          <div class="vip-info-row">
            <div class="vip-turnover">晋级流水(元) {{ vipInfo.currentTurnover || '0.00' }}/{{ vipInfo.targetTurnover || '6,000.00' }}</div>
            <div class="vip-more-link">
              <span>更多VIP特权</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2" width="12" height="12">
                <polyline points="9 18 15 12 9 6"/>
              </svg>
            </div>
          </div>
          <!-- VIP特权标签 -->
          <div class="vip-tags">
            <span class="vip-tag" :class="{ active: vipInfo.weeklyBonus }">
              <img :src="vipInfo.weeklyBonus ? '/static/image/vip_tag_check.png' : '/static/image/vip_tag_lock.png'" class="tag-icon" />
              每周红包
            </span>
            <span class="vip-tag" :class="{ active: vipInfo.upgradeBonus }">
              <img :src="vipInfo.upgradeBonus ? '/static/image/vip_tag_check.png' : '/static/image/vip_tag_lock.png'" class="tag-icon" />
              晋级礼金
            </span>
            <span class="vip-tag" :class="{ active: vipInfo.exclusiveGift }">
              <img :src="vipInfo.exclusiveGift ? '/static/image/vip_tag_check.png' : '/static/image/vip_tag_lock.png'" class="tag-icon" />
              专属豪礼
            </span>
            <span class="vip-tag" :class="{ active: vipInfo.birthdayGift }">
              <img :src="vipInfo.birthdayGift ? '/static/image/vip_tag_check.png' : '/static/image/vip_tag_lock.png'" class="tag-icon" />
              生日礼金
            </span>
          </div>
        </div>
      </div>

      <!-- 中心钱包 -->
      <div class="wallet-section">
        <div class="wallet-left">
          <!-- 已登录：显示余额 -->
          <template v-if="$store.state.token">
            <div class="wallet-title">
              <span>中心钱包</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" width="16" height="16" @click.stop="toggleBalance">
                <path v-if="showBalance" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle v-if="showBalance" cx="12" cy="12" r="3"/>
                <path v-if="!showBalance" d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                <line v-if="!showBalance" x1="1" y1="1" x2="23" y2="23"/>
              </svg>
            </div>
            <div class="wallet-balance">
              <span class="currency">¥</span>
              <span v-if="showBalance">{{ $store.state.userInfo.balance || '0.00' }}</span>
              <span v-else>****</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" width="16" height="16" @click.stop="refreshBalance">
                <path d="M23 4v6h-6M1 20v-6h6"/>
                <path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>
              </svg>
            </div>
          </template>
          <!-- 未登录：显示提示 -->
          <template v-else>
            <div class="wallet-not-login" @click="$parent.goNav('/login')">
              <div class="not-login-title">您还未登录</div>
              <div class="not-login-desc">登录/注册后查看</div>
            </div>
          </template>
        </div>
        <div class="wallet-actions">
          <div class="wallet-btn" @click="$store.state.token ? $parent.goNav('/money') : $parent.goNav('/login')">
            <div class="btn-icon">
              <img src="/static/image/blance.png" alt="余额宝" class="wallet-icon" />
            </div>
            <span>余额宝</span>
          </div>
          <div class="wallet-btn" @click="$store.state.token ? $parent.goNav('/recharge') : $parent.goNav('/login')">
            <div class="btn-icon">
              <img src="/static/image/icon_deposit.png" alt="存款" class="wallet-icon" />
            </div>
            <span>存款</span>
          </div>
          <div class="wallet-btn" @click="$store.state.token ? $parent.goNav('/transfer') : $parent.goNav('/login')">
            <div class="btn-icon">
              <img src="/static/image/icon_transfer.png" alt="转账" class="wallet-icon" />
            </div>
            <span>转账</span>
          </div>
          <div class="wallet-btn" @click="$store.state.token ? $parent.goNav('/withdrawal') : $parent.goNav('/login')">
            <div class="btn-icon">
              <img src="/static/image/imagewithdraw.png" alt="取款" class="wallet-icon" />
            </div>
            <span>取款</span>
          </div>
        </div>
      </div>

      <!-- 福利中心 + 功能菜单 -->
      <div class="welfare-menu-card">
        <div class="welfare-header" @click="$parent.goNav('/activity')">
          <div class="welfare-title">福利中心 尽享优惠</div>
          <div class="welfare-btn">
            <span>领取福利</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" width="12" height="12">
              <polyline points="9 18 15 12 9 6"/>
            </svg>
          </div>
        </div>
        <div class="menu-grid">
          <div class="menu-item" @click="$parent.goNav('/transRecord')">
            <div class="menu-icon">
              <img src="/static/image/transaction_record.png" alt="交易记录" class="menu-icon-img" />
            </div>
            <span>交易记录</span>
          </div>
          <div class="menu-item" @click="$parent.goNav('/betRecord')">
            <div class="menu-icon">
              <img src="/static/image/betting_record.png" alt="投注记录" class="menu-icon-img" />
            </div>
            <span>投注记录</span>
          </div>
          <div class="menu-item" @click="$parent.goNav('/fanshui')">
            <div class="menu-icon">
              <img src="/static/image/Real_time_water.png" alt="实时返水" class="menu-icon-img" />
            </div>
            <span>实时返水</span>
          </div>
          <div class="menu-item" @click="$parent.goNav('/userCent')">
            <div class="menu-icon">
              <img src="/static/image/Account_Management.png" alt="账户管理" class="menu-icon-img" />
            </div>
            <span>账户管理</span>
          </div>
          <div class="menu-item" @click="$parent.goNav('/applyagent')">
            <div class="menu-icon">
              <img src="/static/image/Share_earn.png" alt="分享赚钱" class="menu-icon-img" />
            </div>
            <span>分享赚钱</span>
          </div>
          <div class="menu-item" @click="$parent.openKefu()">
            <div class="menu-icon">
              <img src="/static/image/Feedback.png" alt="意见反馈" class="menu-icon-img" />
            </div>
            <span>意见反馈</span>
          </div>
          <div class="menu-item" @click="$parent.goNav('/boutBallBet')">
            <div class="menu-icon">
              <img src="/static/image/Help_center.png" alt="帮助中心" class="menu-icon-img" />
            </div>
            <span>帮助中心</span>
          </div>
          <div class="menu-item" @click="$parent.goNav('/applyagent')">
            <div class="menu-icon">
              <img src="/static/image/join.png" alt="加入我们" class="menu-icon-img" />
            </div>
            <span class="text-highlight">加入我们</span>
          </div>
        </div>
      </div>

      <!-- 邀请好友Banner -->
      <div class="invite-banner" @click="$parent.goNav('/applyagent')">
        <img src="/static/image/invite-banner.jpg" alt="邀请好友 共享盛宴" />
      </div>

      <!-- 底部列表 -->
      <div class="bottom-list">
        <div class="list-item" @click="$parent.goNav('/abouts')">
          <div class="item-left">
            <img src="/static/image/icon_about.png" alt="关于星乐" class="list-icon" />
            <span>关于星乐</span>
          </div>
          <svg viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" width="16" height="16">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </div>
        <div class="list-item" @click="$parent.openKefu()">
          <div class="item-left">
            <img src="/static/image/icon_kefu.png" alt="添加桌面客服" class="list-icon" />
            <span>添加桌面客服</span>
          </div>
          <div class="item-right">
            <span class="item-desc">一对一在线解答</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" width="16" height="16">
              <polyline points="9 18 15 12 9 6"/>
            </svg>
          </div>
        </div>
        <div class="list-item" @click="$parent.goNav('/app')">
          <div class="item-left">
            <img src="/static/image/icon_app.png" alt="打开星乐APP" class="list-icon" />
            <span>打开星乐APP</span>
          </div>
          <svg viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" width="16" height="16">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </div>
      </div>

    </div>

    <!-- 底部占位 -->
    <div style="height: 16vw;"></div>
  </div>
</template>

<script>
export default {
  name: 'mine',
  data() {
    return {
      showBalance: true,
      vipLis: [],
      joinDays: 1,
      nextVipAmount: '0.00',
      vipProgress: 0,
    };
  },
  computed: {
    vipInfo() {
      const userInfo = this.$store.state.userInfo || {};
      const currentLevel = (userInfo.vip || 0) * 1;
      const nextLevel = Math.min(currentLevel + 1, 10);
      const currentTurnover = userInfo.paysum ? Number(userInfo.paysum).toFixed(2) : '0.00';
      const targetTurnover = this.nextVipAmount || '6,000.00';
      return {
        currentLevel,
        nextLevel,
        currentTurnover,
        targetTurnover,
        weeklyBonus: currentLevel >= 1,
        upgradeBonus: currentLevel >= 1,
        exclusiveGift: currentLevel >= 2,
        birthdayGift: currentLevel >= 3,
      };
    },
    vipProgressPercent() {
      return this.vipProgress || 0;
    },
  },
  created() {
    this.uservip();
    this.calcJoinDays();
  },
  activated() {
    // 页面从缓存激活时，强制更新视图并重新检查登录状态
    this.$forceUpdate();
    this.calcJoinDays();
    if (this.$store.state.token) {
      this.uservip();
    }
  },
  methods: {
    onchangemd(e) {
      let that = this;
      let formdata = new FormData();
      Array.from(e.target.files).map(item => {
        formdata.append('file', item);
      });
      that.$parent.showLoading();
      that.$apiFun.post('/api/uploadimg', formdata).then(res => {
        that.$parent.hideLoading();
        that.$parent.getUserInfoShowLoding();
      });
    },
    toggleBalance() {
      this.showBalance = !this.showBalance;
    },
    refreshBalance() {
      this.$parent.getUserInfoShowLoding();
    },
    calcJoinDays() {
      if (this.$store.state.userInfo && this.$store.state.userInfo.created_at) {
        const created = new Date(this.$store.state.userInfo.created_at);
        const now = new Date();
        const diff = Math.floor((now - created) / (1000 * 60 * 60 * 24));
        this.joinDays = diff > 0 ? diff : 1;
      }
    },
    uservip() {
      let that = this;
      that.$apiFun
        .post('/api/uservip', {})
        .then(res => {
          if (res.code == 200) {
            that.vipLis = res.data;
            that.calcNextVip();
          }
        })
        .catch(() => {});
    },
    calcNextVip() {
      let vip = (this.$store.state.userInfo.vip || 0) * 1;
      if (this.vipLis && this.vipLis[vip]) {
        this.nextVipAmount = this.vipLis[vip].recharge || '6,000.00';
        let userPay = this.$store.state.userInfo.paysum * 1 || 0;
        let targetPay = this.vipLis[vip].recharge * 1 || 6000;
        this.vipProgress = Math.min(100, Math.round((userPay / targetPay) * 100));
      } else {
        this.nextVipAmount = '6,000.00';
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.mine-page {
  min-height: 100vh;
  background: #f5f5f5;
}

// 顶部用户信息 - 灰色背景
.user-header {
  background: linear-gradient(180deg, #e8e8e8 0%, #f5f5f5 100%);
  padding: 4vw 4vw 5vw;

  .user-info-row {
    display: flex;
    align-items: center;
  }

  .user-avatar {
    position: relative;
    width: 13vw;
    height: 13vw;

    .default-avatar {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background: #e0e0e0;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 0.8vw solid #fff;
      box-shadow: 0 0.5vw 2vw rgba(0,0,0,0.1);
    }

    img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
      border: 0.8vw solid #fff;
      box-shadow: 0 0.5vw 2vw rgba(0,0,0,0.1);
    }

    .avatar-input {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
    }
  }

  .user-details {
    flex: 1;
    margin-left: 3vw;

    .user-name {
      font-size: 4vw;
      font-weight: 600;
      color: #333;
    }

    .user-days {
      font-size: 2.8vw;
      color: #666;
      margin-top: 0.8vw;

      &.not-login {
        color: #999;
      }
    }
  }

  .header-actions {
    display: flex;
    gap: 4vw;

    .action-icon {
      cursor: pointer;
    }
  }
}

// 内容区域
.content-area {
  padding: 0 5vw;
}

// VIP卡片
.vip-card {
  background: #fff;
  border-radius: 3vw 3vw 0 0;
  padding: 3vw;
  margin-bottom: 0;

  .vip-box {
    border: 1px solid #e0e0e0;
    border-radius: 2vw;
    padding: 3vw;
  }

  // VIP等级和进度条行
  .vip-progress-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2vw;

    .vip-level-left,
    .vip-level-right {
      flex-shrink: 0;
    }

    .vip-level-icon {
      width: 12vw;
      height: auto;
    }

    .vip-progress-bar {
      flex: 1;
      margin: 0 3vw;

      .progress-track {
        background: #e0e0e0;
        border-radius: 1vw;
        height: 1.5vw;
        overflow: hidden;
      }

      .progress-fill {
        background: linear-gradient(90deg, #3b7ddd 0%, #5a9cff 100%);
        height: 100%;
        border-radius: 1vw;
        transition: width 0.3s ease;
      }
    }
  }

  // 流水信息行
  .vip-info-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 3vw;

    .vip-turnover {
      font-size: 2.8vw;
      color: #666;
    }

    .vip-more-link {
      display: flex;
      align-items: center;
      font-size: 2.8vw;
      color: #666;

      svg {
        margin-left: 0.5vw;
      }
    }
  }

  // VIP特权标签
  .vip-tags {
    display: flex;
    justify-content: space-between;
    gap: 1.5vw;

    .vip-tag {
      display: flex;
      align-items: center;
      font-size: 2.5vw;
      color: #999;
      padding: 1vw 1.5vw;
      border: 1px solid #e0e0e0;
      border-radius: 4vw;
      background: #f8f8f8;
      white-space: nowrap;
      flex-shrink: 0;

      &.active {
        color: #333;
        border-color: #3b7ddd;
        background: rgba(59, 125, 221, 0.1);
      }

      .tag-icon {
        width: 3vw;
        height: 3vw;
        margin-right: 0.8vw;
        flex-shrink: 0;
      }
    }
  }
}

// 中心钱包
.wallet-section {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #fff;
  border-radius: 0 0 3vw 3vw;
  padding: 3vw;
  margin-bottom: 2vw;
  box-shadow: 0 0.5vw 2vw rgba(0,0,0,0.05);

  .wallet-left {
    .wallet-title {
      display: flex;
      align-items: center;
      font-size: 3vw;
      color: #333;

      svg {
        margin-left: 1.5vw;
        cursor: pointer;
      }
    }

    .wallet-balance {
      display: flex;
      align-items: center;
      font-size: 6vw;
      font-weight: 700;
      color: #333;
      margin-top: 0.8vw;

      .currency {
        font-size: 4vw;
        margin-right: 0.5vw;
      }

      svg {
        margin-left: 1.5vw;
        cursor: pointer;
      }
    }

    .wallet-not-login {
      cursor: pointer;

      .not-login-title {
        font-size: 3.5vw;
        font-weight: 600;
        color: #333;
      }

      .not-login-desc {
        font-size: 2.8vw;
        color: #999;
        margin-top: 0.8vw;
      }
    }
  }

  .wallet-actions {
    display: flex;
    gap: 3.5vw;

    .wallet-btn {
      display: flex;
      flex-direction: column;
      align-items: center;

      .btn-icon {
        width: 9vw;
        height: 9vw;
        border-radius: 50%;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1vw;

        &.dark {
          background: #333;
        }

        &:has(.wallet-icon) {
          background: transparent;
        }

        .wallet-icon {
          width: 9vw;
          height: 9vw;
          object-fit: contain;
        }
      }

      span {
        font-size: 2.5vw;
        color: #666;
      }
    }
  }
}

// 福利中心 + 功能菜单合并卡片
.welfare-menu-card {
  background: #fff;
  border-radius: 3vw;
  margin-top: 3vw;
  margin-bottom: 2vw;
  box-shadow: 0 0.5vw 2vw rgba(0,0,0,0.05);
  overflow: hidden;

  .welfare-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #2c3e50 0%, #3d5166 100%);
    padding: 2vw 4vw;
    cursor: pointer;

    .welfare-title {
      font-size: 4vw !important;
      font-weight: 600;
      color: #fff;
    }

    .welfare-btn {
      display: flex;
      align-items: center;
      background: rgba(255,255,255,0.2);
      padding: 1.5vw 3vw;
      border-radius: 4vw;
      font-size: 3vw !important;
      color: #fff;

      svg {
        margin-left: 0.8vw;
      }
    }
  }

  .menu-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    background: #fff;
    padding: 3vw 0;

    .menu-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2vw 0;

      .menu-icon {
        width: 10vw;
        height: 10vw;
        border-radius: 50%;
        background: #f2f2f2;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5vw;

        &:has(.menu-icon-img) {
          background: transparent;
        }

        .menu-icon-img {
          width: 10vw;
          height: 10vw;
          object-fit: contain;
        }
      }

      span {
        font-size: 2.8vw !important;
        color: #333;
      }
    }
  }
}

// 邀请好友Banner
.invite-banner {
  display: block;
  background: #fff;
  border-radius: 3vw;
  margin-bottom: 2vw;
  box-shadow: 0 0.5vw 2vw rgba(0,0,0,0.05);
  overflow: hidden;

  img {
    width: 100%;
    height: auto;
    display: block;
  }
}

// 底部列表
.bottom-list {
  background: #fff;
  border-radius: 3vw;
  overflow: hidden;
  margin-bottom: 2vw;
  box-shadow: 0 0.5vw 2vw rgba(0,0,0,0.05);

  .list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 3vw 4vw;
    border-bottom: 1px solid #f5f5f5;

    &:last-child {
      border-bottom: none;
    }

    .item-left {
      display: flex;
      align-items: center;

      svg {
        margin-right: 2.5vw;
      }

      .list-icon {
        width: 5vw;
        height: 5vw;
        margin-right: 2.5vw;
        object-fit: contain;
      }

      span {
        font-size: 3.5vw !important;
        color: #222;
        font-weight: 600;
      }
    }

    .item-right {
      display: flex;
      align-items: center;

      .item-desc {
        font-size: 3vw;
        color: #999;
        margin-right: 1.2vw;
      }
    }
  }
}

// 退出登录
.logout-section {
  margin: 4vw 0;
  text-align: center;

  .logout-btn {
    font-size: 3.5vw;
    color: #4a8cca;
    cursor: pointer;
  }
}
</style>
