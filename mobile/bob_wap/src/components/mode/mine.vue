<template>
  <div class="mine-page">
    <!-- 顶部用户信息 - 灰色背景 -->
    <div class="user-header">
      <div class="user-info-row">
        <div class="user-avatar">
          <img :src="$store.state.userInfo.avatar || '/static/image/imageAvatar02@3x.png'" alt="avatar" />
          <input class="avatar-input" type="file" @change="onchangemd" accept="image/gif,image/png" />
        </div>
        <div class="user-details" @click="!$store.state.token && $parent.goNav('/login')">
          <div class="user-name">{{ $store.state.token ? $store.state.userInfo.username : '点击登录/注册' }}</div>
          <div class="user-days" v-if="$store.state.token">加入星乐第{{ joinDays }}天</div>
          <div class="user-days not-login" v-else>您还未登录</div>
        </div>
        <div class="header-actions">
          <div class="action-icon" @click="$parent.goNav('/userCent')">
            <svg viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2" width="22" height="22">
              <circle cx="12" cy="12" r="3"/>
              <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/>
            </svg>
          </div>
          <div class="action-icon" @click="$parent.goNav('/message')">
            <svg viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2" width="22" height="22">
              <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <div class="content-area">
      <!-- VIP卡片 -->
      <div class="vip-card" @click="$parent.goNav('/vip')">
        <div class="vip-header">
          <div class="vip-slider">
            <div class="vip-level-box active">
              <span>VIP{{ $store.state.userInfo.vip || 0 }}</span>
            </div>
            <div class="vip-progress-bar">
              <div class="progress-fill" :style="{width: vipProgress + '%'}"></div>
            </div>
            <div class="vip-level-box">
              <span>VIP{{ ($store.state.userInfo.vip || 0) + 1 }}</span>
            </div>
          </div>
          <div class="vip-more">
            <span>更多VIP特权</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" width="14" height="14">
              <polyline points="9 18 15 12 9 6"/>
            </svg>
          </div>
        </div>
        <div class="vip-progress-info">
          <span class="progress-label">晋级流水(元)</span>
          <span class="progress-value">{{ $store.state.userInfo.paysum || '0.00' }}/{{ nextVipAmount }}</span>
        </div>
        <div class="vip-tags">
          <span class="vip-tag"><span class="tag-check">✓</span> 每周红包</span>
          <span class="vip-tag"><span class="tag-check">✓</span> 晋级礼金</span>
          <span class="vip-tag"><span class="tag-check">✓</span> 专属豪礼</span>
          <span class="vip-tag"><span class="tag-check">✓</span> 生日礼金</span>
        </div>
      </div>

      <!-- 中心钱包 -->
      <div class="wallet-section">
        <div class="wallet-left">
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
            <span v-if="showBalance">{{ $store.state.token ? $store.state.userInfo.balance : '0.00' }}</span>
            <span v-else>****</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" width="16" height="16" @click.stop="refreshBalance">
              <path d="M23 4v6h-6M1 20v-6h6"/>
              <path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>
            </svg>
          </div>
        </div>
        <div class="wallet-actions">
          <div class="wallet-btn" @click="$store.state.token ? $parent.goNav('/money') : $parent.goNav('/login')">
            <div class="btn-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="20" height="20">
                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                <line x1="2" y1="7" x2="22" y2="7"/>
                <circle cx="12" cy="13" r="2"/>
              </svg>
            </div>
            <span>余额宝</span>
          </div>
          <div class="wallet-btn" @click="$store.state.token ? $parent.goNav('/recharge') : $parent.goNav('/login')">
            <div class="btn-icon dark">
              <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" width="18" height="18">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                <line x1="1" y1="10" x2="23" y2="10"/>
              </svg>
            </div>
            <span>存款</span>
          </div>
          <div class="wallet-btn" @click="$store.state.token ? $parent.goNav('/transfer') : $parent.goNav('/login')">
            <div class="btn-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="20" height="20">
                <circle cx="12" cy="12" r="10"/>
                <path d="M8 12h8M12 8l4 4-4 4"/>
              </svg>
            </div>
            <span>转账</span>
          </div>
          <div class="wallet-btn" @click="$store.state.token ? $parent.goNav('/withdrawal') : $parent.goNav('/login')">
            <div class="btn-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="20" height="20">
                <circle cx="12" cy="12" r="10"/>
                <path d="M8 12l4 4 4-4M12 8v8"/>
              </svg>
            </div>
            <span>取款</span>
          </div>
        </div>
      </div>

      <!-- 福利中心 -->
      <div class="welfare-card" @click="$parent.goNav('/activity')">
        <div class="welfare-content">
          <div class="welfare-title">福利中心 尽享优惠</div>
        </div>
        <div class="welfare-btn">
          <span>领取福利</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" width="12" height="12">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </div>
      </div>

      <!-- 功能菜单 -->
      <div class="menu-grid">
        <div class="menu-item" @click="$parent.goNav('/transRecord')">
          <div class="menu-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="24" height="24">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </div>
          <span>交易记录</span>
        </div>
        <div class="menu-item" @click="$parent.goNav('/betRecord')">
          <div class="menu-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="24" height="24">
              <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
              <line x1="16" y1="13" x2="8" y2="13"/>
              <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
          </div>
          <span>投注记录</span>
        </div>
        <div class="menu-item" @click="$parent.goNav('/fanshui')">
          <div class="menu-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="24" height="24">
              <circle cx="12" cy="12" r="10"/>
              <path d="M12 6v6l4 2"/>
            </svg>
          </div>
          <span>实时返水</span>
        </div>
        <div class="menu-item" @click="$parent.goNav('/userCent')">
          <div class="menu-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="24" height="24">
              <circle cx="12" cy="7" r="4"/>
              <path d="M5.5 21a8.38 8.38 0 0113 0"/>
            </svg>
          </div>
          <span>账户管理</span>
        </div>
        <div class="menu-item" @click="$parent.goNav('/applyagent')">
          <div class="menu-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="24" height="24">
              <circle cx="18" cy="5" r="3"/>
              <circle cx="6" cy="12" r="3"/>
              <circle cx="18" cy="19" r="3"/>
              <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
              <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
            </svg>
          </div>
          <span>分享赚钱</span>
        </div>
        <div class="menu-item" @click="$parent.openKefu()">
          <div class="menu-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="24" height="24">
              <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
            </svg>
          </div>
          <span>意见反馈</span>
        </div>
        <div class="menu-item" @click="$parent.goNav('/boutBallBet')">
          <div class="menu-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="24" height="24">
              <circle cx="12" cy="12" r="10"/>
              <path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/>
              <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
          </div>
          <span>帮助中心</span>
        </div>
        <div class="menu-item" @click="$parent.goNav('/applyagent')">
          <div class="menu-icon highlight">
            <svg viewBox="0 0 24 24" fill="none" stroke="#4a8cca" stroke-width="1.5" width="24" height="24">
              <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 00-3-3.87"/>
              <path d="M16 3.13a4 4 0 010 7.75"/>
            </svg>
          </div>
          <span class="text-highlight">加入我们</span>
        </div>
      </div>

      <!-- 邀请好友Banner -->
      <div class="invite-banner" @click="$parent.goNav('/applyagent')">
        <div class="invite-content">
          <div class="invite-title">邀请好友 共享盛宴</div>
        </div>
        <div class="invite-image">
          <img src="/static/image/invite_banner.png" onerror="this.parentElement.innerHTML='<div class=\'placeholder-img\'></div>'" />
        </div>
      </div>

      <!-- 底部列表 -->
      <div class="bottom-list">
        <div class="list-item" @click="$parent.goNav('/abouts')">
          <div class="item-left">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="20" height="20">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="16" x2="12" y2="12"/>
              <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <span>关于星乐</span>
          </div>
          <svg viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" width="16" height="16">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </div>
        <div class="list-item" @click="$parent.openKefu()">
          <div class="item-left">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="20" height="20">
              <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>
            </svg>
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
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="20" height="20">
              <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
              <line x1="12" y1="18" x2="12.01" y2="18"/>
            </svg>
            <span>打开星乐APP</span>
          </div>
          <svg viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2" width="16" height="16">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </div>
      </div>

      <!-- 退出登录 -->
      <div class="logout-section" v-if="$store.state.token">
        <div class="logout-btn" @click="$parent.outLogin">退出登录</div>
      </div>
    </div>

    <!-- 底部占位 -->
    <div style="height: 80px;"></div>
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
  created() {
    this.uservip();
    this.calcJoinDays();
  },
  activated() {
    // 页面从缓存激活时，重新检查登录状态和数据
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
  padding: 20px 15px 25px;

  .user-info-row {
    display: flex;
    align-items: center;
  }

  .user-avatar {
    position: relative;
    width: 60px;
    height: 60px;

    img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
    margin-left: 12px;

    .user-name {
      font-size: 18px;
      font-weight: 600;
      color: #333;
    }

    .user-days {
      font-size: 12px;
      color: #666;
      margin-top: 4px;

      &.not-login {
        color: #999;
      }
    }
  }

  .header-actions {
    display: flex;
    gap: 15px;

    .action-icon {
      cursor: pointer;
    }
  }
}

// 内容区域
.content-area {
  padding: 0 15px;
}

// VIP卡片
.vip-card {
  background: #fff;
  border-radius: 12px;
  padding: 15px;
  margin-bottom: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);

  .vip-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .vip-slider {
    display: flex;
    align-items: center;
    flex: 1;
    margin-right: 15px;

    .vip-level-box {
      background: #f0f0f0;
      padding: 4px 10px;
      border-radius: 4px;
      font-size: 11px;
      color: #666;
      border: 1px solid #e0e0e0;

      &.active {
        background: linear-gradient(90deg, #8b7355 0%, #c4a574 100%);
        color: #fff;
        border-color: transparent;
      }
    }

    .vip-progress-bar {
      flex: 1;
      height: 4px;
      background: #e0e0e0;
      margin: 0 8px;
      border-radius: 2px;
      overflow: hidden;

      .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #8b7355 0%, #c4a574 100%);
        border-radius: 2px;
        transition: width 0.3s;
      }
    }
  }

  .vip-more {
    display: flex;
    align-items: center;
    font-size: 12px;
    color: #999;

    svg {
      margin-left: 3px;
    }
  }

  .vip-progress-info {
    margin-top: 12px;
    font-size: 12px;
    color: #999;

    .progress-value {
      margin-left: 5px;
    }
  }

  .vip-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 12px;

    .vip-tag {
      font-size: 11px;
      color: #666;
      display: flex;
      align-items: center;

      .tag-check {
        color: #52c41a;
        margin-right: 3px;
        font-size: 10px;
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
  border-radius: 12px;
  padding: 15px;
  margin-bottom: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);

  .wallet-left {
    .wallet-title {
      display: flex;
      align-items: center;
      font-size: 14px;
      color: #333;

      svg {
        margin-left: 8px;
        cursor: pointer;
      }
    }

    .wallet-balance {
      display: flex;
      align-items: center;
      font-size: 28px;
      font-weight: 700;
      color: #333;
      margin-top: 5px;

      .currency {
        font-size: 18px;
        margin-right: 2px;
      }

      svg {
        margin-left: 8px;
        cursor: pointer;
      }
    }
  }

  .wallet-actions {
    display: flex;
    gap: 12px;

    .wallet-btn {
      display: flex;
      flex-direction: column;
      align-items: center;

      .btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 5px;

        &.dark {
          background: #333;
        }
      }

      span {
        font-size: 11px;
        color: #666;
      }
    }
  }
}

// 福利中心
.welfare-card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: linear-gradient(90deg, #4a8cca 0%, #6ba3d6 100%);
  border-radius: 12px;
  padding: 18px 20px;
  margin-bottom: 10px;

  .welfare-title {
    font-size: 16px;
    font-weight: 600;
    color: #fff;
  }

  .welfare-btn {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.2);
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 12px;
    color: #fff;

    svg {
      margin-left: 3px;
    }
  }
}

// 功能菜单
.menu-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  background: #fff;
  border-radius: 12px;
  padding: 15px 0;
  margin-bottom: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);

  .menu-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px 0;

    .menu-icon {
      width: 45px;
      height: 45px;
      border-radius: 10px;
      background: #f5f5f5;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 8px;

      &.highlight {
        background: #e8f4fd;
      }
    }

    span {
      font-size: 12px;
      color: #666;

      &.text-highlight {
        color: #4a8cca;
      }
    }
  }
}

// 邀请Banner
.invite-banner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #fff;
  border-radius: 12px;
  padding: 15px 20px;
  margin-bottom: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);

  .invite-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
  }

  .invite-image {
    img {
      width: 70px;
      height: 50px;
      object-fit: contain;
    }

    .placeholder-img {
      width: 70px;
      height: 50px;
      background: #f0f0f0;
      border-radius: 5px;
    }
  }
}

// 底部列表
.bottom-list {
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  margin-bottom: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);

  .list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px;
    border-bottom: 1px solid #f5f5f5;

    &:last-child {
      border-bottom: none;
    }

    .item-left {
      display: flex;
      align-items: center;

      svg {
        margin-right: 10px;
      }

      span {
        font-size: 14px;
        color: #333;
      }
    }

    .item-right {
      display: flex;
      align-items: center;

      .item-desc {
        font-size: 12px;
        color: #999;
        margin-right: 5px;
      }
    }
  }
}

// 退出登录
.logout-section {
  margin: 15px 0;
  text-align: center;

  .logout-btn {
    font-size: 14px;
    color: #4a8cca;
    cursor: pointer;
  }
}
</style>
