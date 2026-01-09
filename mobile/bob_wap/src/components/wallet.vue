<template>
  <div class="wallet-page">
    <!-- 顶部导航 -->
    <div class="page-header">
      <div class="back-btn" @click="$router.back()">
        <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" width="20" height="20">
          <polyline points="15 18 9 12 15 6"/>
        </svg>
      </div>
      <span class="header-title">我的钱包</span>
      <span class="header-right" @click="$parent.goNav('/transRecord')">交易记录</span>
    </div>

    <!-- 余额卡片 -->
    <div class="balance-section">
      <div class="balance-label">总金额（元）</div>
      <div class="balance-amount">
        <span class="currency">¥</span>
        <span class="amount">{{ $store.state.token ? $store.state.userInfo.balance : '0.00' }}</span>
        <div class="refresh-icon" @click="refreshBalance">
          <svg viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" width="18" height="18">
            <path d="M23 4v6h-6M1 20v-6h6"/>
            <path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>
          </svg>
        </div>
      </div>

      <!-- 操作按钮 -->
      <div class="action-buttons">
        <div class="action-btn" @click="$parent.goNav('/recharge')">
          <div class="btn-icon">
            <img src="/static/image/wallet_deposit.png" onerror="this.style.display='none'" />
          </div>
          <span>存款</span>
        </div>
        <div class="action-btn" @click="$parent.goNav('/transfer')">
          <div class="btn-icon">
            <img src="/static/image/wallet_transfer.png" onerror="this.style.display='none'" />
          </div>
          <span>转账</span>
        </div>
        <div class="action-btn" @click="$parent.goNav('/withdrawal')">
          <div class="btn-icon">
            <img src="/static/image/wallet_withdraw.png" onerror="this.style.display='none'" />
          </div>
          <span>取款</span>
        </div>
        <div class="action-btn" @click="$parent.goNav('/userCent')">
          <div class="btn-icon">
            <img src="/static/image/wallet_account.png" onerror="this.style.display='none'" />
          </div>
          <span>账户管理</span>
        </div>
      </div>
    </div>

    <!-- 钱包明细 -->
    <div class="wallet-detail">
      <span class="detail-title">钱包明细</span>
      <div class="detail-link" @click="showVenueBalance = !showVenueBalance">
        <span>点击查看全部场馆余额</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="#4a8cca" stroke-width="2" width="16" height="16">
          <line x1="12" y1="5" x2="12" y2="19"/>
          <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
      </div>
    </div>

    <!-- 存款送豪礼 -->
    <div class="deposit-gifts">
      <div class="gifts-title">存款送豪礼</div>
      <div class="gifts-grid">
        <div class="gift-item" @click="$parent.goNav('/vip')">
          <div class="gift-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="28" height="28">
              <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
            </svg>
          </div>
          <span>会员成长</span>
        </div>
        <div class="gift-item" @click="$parent.goNav('/fanshui')">
          <div class="gift-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="28" height="28">
              <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
              <line x1="3" y1="9" x2="21" y2="9"/>
              <line x1="9" y1="21" x2="9" y2="9"/>
            </svg>
          </div>
          <span>高额返水</span>
        </div>
        <div class="gift-item" @click="$parent.goNav('/activity')">
          <div class="gift-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="28" height="28">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </div>
          <span>新人首存</span>
        </div>
        <div class="gift-item" @click="$parent.goNav('/activity')">
          <div class="gift-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="28" height="28">
              <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
              <line x1="3" y1="6" x2="21" y2="6"/>
              <path d="M16 10a4 4 0 01-8 0"/>
            </svg>
          </div>
          <span>豪礼盛宴</span>
        </div>
      </div>
    </div>

    <!-- 活动Banner -->
    <div class="promo-banner" @click="$parent.goNav('/activity')">
      <div class="banner-content">
        <div class="banner-title">首存豪礼 流水盛宴</div>
        <div class="banner-subtitle">万元<span class="highlight">红包</span>等着您!</div>
      </div>
      <div class="banner-image">
        <img src="/static/image/promo_banner.png" onerror="this.parentElement.innerHTML='<div style=\'width:80px;height:80px;background:#ddd;border-radius:50%\'></div>'" />
      </div>
    </div>

    <!-- 投注记录 -->
    <div class="bet-record">
      <div class="record-header">
        <span class="record-title">投注记录</span>
        <div class="record-more" @click="$parent.goNav('/betRecord')">
          <span>查看更多</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2" width="14" height="14">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </div>
      </div>
      <div class="record-empty">
        <span>还没有任何投注记录</span>
      </div>
    </div>

    <!-- 底部占位 -->
    <div style="height: 20px;"></div>
  </div>
</template>

<script>
export default {
  name: 'wallet',
  data() {
    return {
      showVenueBalance: false,
    };
  },
  created() {},
  methods: {
    refreshBalance() {
      this.$parent.getUserInfoShowLoding();
    },
  },
  mounted() {},
};
</script>

<style lang="scss" scoped>
.wallet-page {
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
  background: linear-gradient(90deg, #2d5016 0%, #4a7c23 100%);

  .back-btn {
    width: 30px;
    display: flex;
    align-items: center;
  }

  .header-title {
    font-size: 17px;
    font-weight: 600;
    color: #fff;
  }

  .header-right {
    font-size: 14px;
    color: #fff;
  }
}

// 余额区域
.balance-section {
  background: #fff;
  padding: 20px 15px;
  margin-bottom: 10px;

  .balance-label {
    font-size: 13px;
    color: #e74c3c;
  }

  .balance-amount {
    display: flex;
    align-items: center;
    margin-top: 8px;

    .currency {
      font-size: 18px;
      color: #333;
      margin-right: 2px;
    }

    .amount {
      font-size: 28px;
      font-weight: 700;
      color: #333;
    }

    .refresh-icon {
      margin-left: 10px;
      cursor: pointer;
    }
  }
}

// 操作按钮
.action-buttons {
  display: flex;
  justify-content: space-around;
  margin-top: 20px;
  padding-top: 15px;
  border-top: 1px solid #f0f0f0;

  .action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;

    .btn-icon {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: linear-gradient(180deg, #e8e8e8 0%, #c8c8c8 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 8px;

      img {
        width: 28px;
        height: 28px;
      }
    }

    span {
      font-size: 12px;
      color: #666;
    }
  }
}

// 钱包明细
.wallet-detail {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #fff;
  padding: 15px;
  margin-bottom: 10px;

  .detail-title {
    font-size: 15px;
    font-weight: 600;
    color: #333;
  }

  .detail-link {
    display: flex;
    align-items: center;
    font-size: 12px;
    color: #4a8cca;

    svg {
      margin-left: 5px;
    }
  }
}

// 存款送豪礼
.deposit-gifts {
  background: #fff;
  padding: 15px;
  margin-bottom: 10px;

  .gifts-title {
    font-size: 15px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
  }

  .gifts-grid {
    display: flex;
    justify-content: space-around;

    .gift-item {
      display: flex;
      flex-direction: column;
      align-items: center;

      .gift-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
      }

      span {
        font-size: 12px;
        color: #666;
      }
    }
  }
}

// 活动Banner
.promo-banner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: linear-gradient(90deg, #1a237e 0%, #3949ab 100%);
  margin: 0 15px 10px;
  padding: 15px 20px;
  border-radius: 10px;

  .banner-content {
    .banner-title {
      font-size: 18px;
      font-weight: 700;
      color: #fff;
    }

    .banner-subtitle {
      font-size: 14px;
      color: #ffd700;
      margin-top: 5px;

      .highlight {
        color: #ff4444;
      }
    }
  }

  .banner-image {
    img {
      width: 80px;
      height: 80px;
      object-fit: contain;
    }
  }
}

// 投注记录
.bet-record {
  background: #fff;
  padding: 15px;
  margin: 0 15px;
  border-radius: 10px;

  .record-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;

    .record-title {
      font-size: 15px;
      font-weight: 600;
      color: #333;
    }

    .record-more {
      display: flex;
      align-items: center;
      font-size: 12px;
      color: #999;

      svg {
        margin-left: 3px;
      }
    }
  }

  .record-empty {
    text-align: center;
    padding: 30px 0;
    font-size: 14px;
    color: #999;
  }
}
</style>
