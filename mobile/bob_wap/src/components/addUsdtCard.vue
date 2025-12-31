<template>
  <div style="width: 100%; min-height: 100vh; background: rgb(237, 241, 255)">
    <van-nav-bar style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ede9e7" title="新增USDT地址" left-arrow @click-left="$router.back()" />
    <div style="height: 46px"></div>
    <!-- 头部显示 -->
    <div class="tipsh">
      <div class="tops">USDT价格稳定 流通性高 不受监管 <span @click="$parent.goNav('/usdtmore')">了解更多 ></span></div>
      <div class="tsg">
        <div class="tsgs">绑定协议地址</div>
        <div class="tsgs">交易所划转</div>
        <div class="tsgs">完成取款</div>
      </div>
    </div>
    <div class="usrse">
      <div class="hgs">
        <div class="nams sc">
          钱包协议
          <div :class="usdtInfo.bank_owner == 'TRC20' ? ' ssa acti' : 'ssa'" @click="changXie('TRC20')">TRC20</div>
          <div :class="usdtInfo.bank_owner == 'ERC20' ? ' ssa acti' : 'ssa'" style="margin-left: 0.5rem" @click="changXie('ERC20')">ERC20</div>
        </div>
        <div style="border-bottom: 1px solid #f2f2f2"></div>
      </div>
      <div class="hgs">
        <div class="nams">USDT地址</div>
        <div style="border-bottom: 1px solid #f2f2f2">

          <div data-v-a12ec382="" class="van-cell-group van-hairline--top-bottom">
            <div data-v-a12ec382="" class="van-cell van-field">
              <div class="van-cell__value van-cell__value--alone van-field__value">
                <div class="van-field__body"><input type="text" readonly onfocus="this.removeAttribute('readonly');" auto-complete="off" onblur="this.setAttribute('readonly',true);"  v-model="usdtInfo.bank_no" placeholder="请输入USDT地址" class="van-field__control" /></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="hgs">
        <div class="nams">支付密码</div>
        <div style="border-bottom: 1px solid #f2f2f2">
          <van-cell-group>
            <van-field v-model="usdtInfo.pay_pass" type="password" placeholder="请输入支付密码" />
          </van-cell-group>
        </div>
      </div>
      <van-button type="info" style="margin-top: 20px; width: 100%" @click="bindUsdss">确认添加</van-button>
    </div>
  </div>
</template>
<script>
export default {
  name: 'addUsdtCard',
  data() {
    return {
      usdtInfo: { bank_owner: 'TRC20' },
    };
  },
  created() {
    let that = this;
  },
  methods: {
    changXie(name) {
      this.usdtInfo.bank_owner = name;
    },
    bindUsdss() {
      let that = this;
      let usdtInfo = that.usdtInfo;
      usdtInfo.bank = 'USDT';
      if (usdtInfo.bank_no == null || usdtInfo.bank_no == '') {
        that.$parent.showTost(0, '请输入USDT地址');
        return;
      }
      if (!usdtInfo.bank_owner || usdtInfo.bank_owner == null) {
        that.$parent.showTost(0, '请选择钱包协议');
        return;
      }
      if (!usdtInfo.pay_pass) {
        that.$parent.showTost(0, '请输人支付密码');
        return;
      }
      that.$parent.showLoading();
      that.$apiFun
        .post('/api/bindcard', usdtInfo)
        .then(res => {
          if (res.code != 200) {
            that.$parent.showTost(0, res.message);
          }
          if (res.code == 200) {
            that.$parent.showTost(1, res.message);
            that.$router.back();
          }
          that.$parent.hideLoading();
        })
        .catch(res => {
          that.$parent.hideLoading();
        });
    },
  },
  mounted() {
    let that = this;
  },
  updated() {
    let that = this;
  },
};
</script>

<style lang="scss" scoped>
.tipsh {
  width: 95%;
  margin: 6px auto;
  border-radius: 10px;
  background: #f8f8f8;
  box-sizing: border-box;
  padding: 6px;

  .tops {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.4rem;
    font-weight: 700;
    color: #333;
    height: 1rem;
    span {
      font-size: 0.29rem;
      font-weight: 400;
    }
  }
  .tsg {
    display: flex;
    align-items: center;
    justify-content: space-between;
    .tsgs {
      height: 0.56rem;
      line-height: 0.56rem;
      color: #a5a9b3;
      font-size: 0.2rem;
      text-align: center;
      padding: 4px 8px;
      flex: 1;
      background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAAA0CAYAAADPCHf8AAAACXBIWXMAABYlAAAWJQFJUiTwAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAALCSURBVHgB7d0hcNtAEIXhtWh4y8vDixseXHPz4ibYKW2Kw1UsHt7g8vCWB7u7mYsnss7S3elmam3+b8bjxM6Evaz1tFJWu91uKyLnAixbt1qt7qSyRh+3Aizfpf6xv5TKGk3dX31uBVi+jYak6qehJjx3+ngSYPmuNCTvpZLngOgUsXBU//wG/Adn+thqSM6kgpcJYiG516ffAizfO31cSQXNwfc/BfDhXKfIRmbqBUSniE2QewF8sGZrLTM0kdfsWIQDdnix1pB8lEKDgIQD9k4AP75oSD5IgdgEsZDYeZE/AvhgjVZR/duMvPdDAD+s2fqaW/8eDUg4YKf2hSf2MSur2Wom3mdPC95c5DRbowFhTwtOWbN1kfKDUxPEsKcFjzYpzdZkQNjTglNJzVbKBGFPC15NNltJAQnY04JHo81WckDY04JjR5utnAli2NOCV+vYJbtZAWFPC84Nmq3cCWIsIOxpwavt62YrOyBhirCnBa96l+yWTBD2tODd/pLdlRTShNkv4QQiPOuKJgjwRjzNCcisa32BE/dgFw4WBSRsQiZtQwILZFvs3+2L0gnyWQCfLBzXoa3ND0g4JV/t1o7AibnRcOzP82UFJDRX1e+gDZyIOw3H4+sXcieITY8q9zwFTkyr4RisUSUHJEwPDszh0UO41dVAzgTZCuDPvrGKSQpIqHU5MIc3vcYqZjIg4aMVtS68sVD0GquYlAlirRXTA960h41VzGhAqHXhVLSxipmaIOxbwZvuWGMVczQg7FvBocfc/6U+NkE4MIcn1lh9k0zRgLBvBWessbqeaqxiBgEJB+afBPDjtiQcJjZBmB7wxBqrX1KoFxD2reBMVmMVczhB2LeCF9mNVcw+IOxbwZGixirmOSDsW8GR4sYq5mWCMD3gxU2tcJgmTA9WSuBBG+76WY1NEMIBD9q5jVXMPzyG0oj5jr9QAAAAAElFTkSuQmCC);
      background-size: cover;
    }
  }
}
.usrse {
  background: #fff;
  box-sizing: border-box;
  padding: 20px;
  .nams {
    font-size: 0.38rem;
    color: #000;
    vertical-align: middle;
    margin-top: 10px;
    font-weight: 700;
  }
  .imgsa {
    position: relative;
    height: 2rem;
    border-bottom: 1px solid #f2f2f2;
    padding-bottom: 0.2rem;
    .bisn {
      width: 0.8rem;
      position: absolute;
      bottom: 0.3rem;
      left: 1.4rem;
    }
    img {
      width: 2rem;
      border-radius: 50%;
    }
  }
}
[class*='van-hairline']:after {
  border: none;
}
.sc {
  display: flex;
  align-items: center;
  padding-bottom: 20px;
  .ssa {
    border-radius: 5px;
    border: 1px solid #f1f1f1;
    width: 2rem;
    height: 1rem;
    line-height: 1rem;
    font-size: 0.4rem;
    font-weight: 700;
    text-align: center;
    margin-left: 1rem;
  }
  .acti {
    color: #ede9e7 !important;
    border: 1px solid #ede9e7 !important;
  }
}
</style>
