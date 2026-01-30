<template>
  <div class="sdg" style="width: 100%; min-height: 100vh; background: rgb(237, 241, 255); padding-bottom: 50px" v-if="pay_way">
    <div style="width: 100%; background: #fff">
      <van-nav-bar style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ede9e7" title="存款" left-arrow @click-left="handleBack" />
      <div style="height: 46px"></div>
      <!-- 存款方式选择 -->
      <div class="typelis">
        <!-- 动态展示支付方式 -->
        <div 
          v-for="(payment, index) in paymentList" 
          :key="payment.id"
          :class="pay_way == payment.mch_id ? ' tyls atc' : 'tyls'" 
          @click="changPayway(payment.mch_id, payment)"
        >
          <img v-if="payment.payimg" :src="payment.payimg" :alt="payment.content" />
          <img v-else :src="getDefaultPayImg(payment.mch_id)" :alt="payment.content" />
          <span>{{ payment.content }}</span>
        </div>
        <!-- 兼容旧的方式（如果新接口没有数据时显示） -->
        <div :class="pay_way == 'bank' ? ' tyls atc' : 'tyls'" @click="changPayway('bank')" v-if="paymentList.length === 0 && payWayList.card == 1"><img src="/static/image/icoOnlineTransfer2@3x.png" alt="" />网银转账</div>
        <div :class="pay_way == 'usdt' ? ' tyls atc' : 'tyls'" @click="changPayway('usdt')" v-if="paymentList.length === 0 && payWayList.usdt == 1"><img src="/static/image/1595237922936176.png" alt="" />USDT</div>
        <div :class="pay_way == 'wechat' ? ' tyls atc' : 'tyls'" @click="changPayway('wechat')" v-if="paymentList.length === 0 && payWayList.wechat == 1"><img src="/static/image/QuickWechat.png" alt="" />微信</div>
        <div :class="pay_way == 'alipay' ? ' tyls atc' : 'tyls'" @click="changPayway('alipay')" v-if="paymentList.length === 0 && payWayList.alipay == 1"><img src="/static/image/icoAlipay2@3x.png" alt="" />支付宝</div>
      </div>
      <div v-if="pay_way == 'bank'">
        <div class="usrse">
          <div class="bans" style="" v-for="(item, index) in cardLis" :key="index">
            <p>
              <span class="frists"> 收款账号 </span><span class="sdsw">{{ item.bank_no }}</span
              ><span class="copy" @click="doCopy(item.bank_no)"> 复制 </span>
            </p>
            <p>
              <span class="frists"> 银行户名 </span><span class="sdsw">{{ item.bank_owner }}</span
              ><span class="copy" @click="doCopy(item.bank_owner)"> 复制 </span>
            </p>
            <p>
              <span class="frists"> 开户行 </span><span class="sdsw">{{ item.bank_data.bank_name }}</span
              ><span class="copy" @click="doCopy(item.bank_data.bank_name)"> 复制 </span>
            </p>
            <p>
              <span class="frists"> 银行地址 </span><span class="sdsw">{{ item.bank_address }}</span
              ><span class="copy" @click="doCopy(item.bank_address)"> 复制 </span>
            </p>
          </div>
          <div class="hgs" @click="changShow">
            <div class="nams">开户银行</div>
            <div style="border-bottom: 1px solid #f2f2f2">
              <van-cell-group>
                <van-field v-model="bankBox.bank" type="text" placeholder="选择开户银行" disabled> </van-field>
              </van-cell-group>
            </div>
          </div>
          <div style="height: 0.2rem; background: #f8f8f8; width: 100wh"></div>
          <div class="hgs">
            <div class="nams">存款人姓名</div>
            <div style="border-bottom: 1px solid #f2f2f2">
              <van-cell-group>
                <van-field v-model="bankBox.bank_owner" type="text" placeholder="请输入存款人姓名"> </van-field>
              </van-cell-group>
            </div>
            <div class="lasthg">为及时到账，请务必输入正确的存款人姓名</div>
          </div>

          <div style="height: 0.2rem; background: #f8f8f8; width: 100wh"></div>
          <div class="hgs">
            <div class="nams">银行卡号</div>
            <div style="border-bottom: 1px solid #f2f2f2">
              <van-cell-group>
                <van-field v-model="bankBox.bank_no" type="text" placeholder="请输入银行卡号"> </van-field>
              </van-cell-group>
            </div>
          </div>
          <div style="height: 0.2rem; background: #f8f8f8; width: 100wh"></div>
          <div class="hgs">
            <div class="nams">开户行地址</div>
            <div style="border-bottom: 1px solid #f2f2f2">
              <van-cell-group>
                <van-field v-model="bankBox.bank_address" type="text" placeholder="请输入开户行地址"> </van-field>
              </van-cell-group>
            </div>
          </div>
          <div style="height: 0.2rem; background: #f8f8f8; width: 100wh"></div>
          <div class="hgs">
            <div class="nams">存款金额</div>
            <div style="border-bottom: 1px solid #f2f2f2">
              <van-cell-group>
                <van-field label="￥" v-model="amount" type="text" :placeholder="`请输入取款金额 ${min_price} - ${max_price}`">
                  <template #button> <span style="color: #000"> 元</span> </template>
                </van-field>
              </van-cell-group>
            </div>
            <div class="lasthg" style="color: red; font-size: 0.4rem; padding: 0.2rem 0;">为了避免风控，请使用金额个位数为3,4,5,6,7等数字!</div>
            <div class="lasthg exchange-info">
              <div class="exchange-rate">
                <span class="rate-label">参考汇率</span>
                <span class="rate-value">{{ exchange_rate }}</span>
              </div>
              <div class="expected-amount">
                <span class="amount-label">预计到账</span>
                <span class="amount-value">{{ amount ? Math.floor((amount / exchange_rate) * 100) / 100 : '0.00' }} USDT</span>
              </div>
            </div>
          </div>
          <div style="height: 0.2rem; background: #f8f8f8; width: 100wh"></div>
        </div>
      </div>
      <div v-if="pay_way == 'usdt'">
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
              <div :class="meyXi == 'TRC20' ? ' ssa acti' : 'ssa'" @click="changXiyi('TRC20')">TRC20</div>
              <div :class="meyXi == 'ERC20' ? ' ssa acti' : 'ssa'" style="margin-left: 0.5rem" @click="changXiyi('ERC20')">ERC20</div>
            </div>
            <div style="border-bottom: 1px solid #f2f2f2"></div>
          </div>
          <div style="height: 0.2rem; background: #f8f8f8; width: 100wh"></div>
          <!-- <div class="hgs">
            <div class="nams">USDT地址</div>
            <div style="border-bottom: 1px solid #f2f2f2">
              <div data-v-a12ec382="" class="van-cell-group van-hairline--top-bottom">
                <div data-v-a12ec382="" class="van-cell van-field">
                  <div class="van-cell__value van-cell__value--alone van-field__value">
                    <div class="van-field__body"><input type="text" readonly onfocus="this.removeAttribute('readonly');" auto-complete="off" onblur="this.setAttribute('readonly',true);" placeholder="请输入USDT地址" class="van-field__control" /></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div style="height: 0.2rem; background: #f8f8f8; width: 100wh"></div> -->
          <div class="hgs">
            <div class="nams">存款金额</div>
            <div style="border-bottom: 1px solid #f2f2f2">
              <van-cell-group>
                <van-field label="￥" v-model="amount" type="text" :placeholder="`请输入存款金额 ${min_price} - ${max_price}`">
                  <template #button> <span style="color: #000"> 元</span> </template>
                </van-field>
              </van-cell-group>
            </div>
            <div class="lasthg" style="color: red; font-size: 0.4rem; padding: 0.2rem 0;">为了避免风控，请使用金额个位数为3,4,5,6,7等数字!</div>
            <div class="lasthg"><span style="color: red; font-size: 0.43rem; margin-right: 10px">≈ </span> {{ amount ? Math.floor((amount / $store.state.userInfo.usdtrate) * 100) / 100 : '0.00' }}USDT ; 参考汇率：{{ $store.state.userInfo.usdtrate }}</div>
          </div>
          <div style="height: 0.2rem; background: #f8f8f8; width: 100wh"></div>
          <div class="hgs">
            <div class="nams">温馨提示</div>
            <div class="lasthg" style="border-top: 1px solid #eee; margin-top: 10px">请选择正确的USDT协议付款，若您选择错误的协议付款，平台将无法收到您的付款，为此我们不承担任何负责！</div>
          </div>
          <div style="height: 0.2rem; background: #f8f8f8; width: 100wh"></div>
        </div>
      </div>
      <!-- 通用支付方式输入区域（非bank和usdt的其他支付方式） -->
      <div v-if="pay_way && pay_way != 'bank' && pay_way != 'usdt'">
        <div style="height: 0.2rem; background: #f8f8f8; width: 100wh"></div>

        <div class="usrse">
          <div class="hgs">
            <div class="nams">存款金额</div>
            <div style="border-bottom: 1px solid #f2f2f2">
              <van-cell-group>
                <van-field label="￥" v-model="amount" type="text" :placeholder="`请输入存款金额 ${min_price} - ${max_price}`">
                  <template #button> <span style="color: #000"> 元</span> </template>
                </van-field>
              </van-cell-group>
            </div>
            <div class="lasthg" style="color: red; font-size: 0.4rem; padding: 0.2rem 0;">为了避免风控，请使用金额个位数为3,4,5,6,7等数字!</div>
            <!-- 非USDT支付方式显示汇率和预计到账 -->
            <div class="lasthg exchange-info">
              <div class="exchange-rate">
                <span class="rate-label">参考汇率</span>
                <span class="rate-value">{{ exchange_rate }}</span>
              </div>
              <div class="expected-amount">
                <span class="amount-label">预计到账</span>
                <span class="amount-value">{{ amount ? Math.floor((amount / exchange_rate) * 100) / 100 : '0.00' }} USDT</span>
              </div>
            </div>
          </div>
          <div style="height: 0.2rem; background: #f8f8f8; width: 100wh"></div>
        </div>
      </div>
      <div style="margin: 0 auto; width: 86%">
        <van-button type="info" style="margin-top: 20px; width: 100%" @click="payTest">立即存款</van-button>
        <div class="textcns" style="text-align: center; color: #999; padding: 10px 0">存款遇到问题？联系 <span @click="$parent.openKefu" style="color: #cf866b; display: inline-block; margin: 0 6px">人工客服</span> 解决</div>
      </div>
    </div>
    <div v-if="show" style="position: fixed; width: 100%; height: 100%; top: 0; z-index: 999; background: rgba(0, 0, 0, 0.39)">
      <van-picker style="position: absolute; bottom: 0; left: 0; width: 100%" title="银行类型" show-toolbar :columns="banklist" @confirm="onConfirm" @cancel="onCancel" @change="onChange" value-key="bank_name" />
    </div>
    <!-- 返回确认对话框 -->
    <van-dialog
      v-model="showBackDialog"
      title="提示"
      message="您是否已经完成支付？"
      show-cancel-button
      confirm-button-text="已完成支付"
      cancel-button-text="继续支付"
      @confirm="confirmBack"
      @cancel="cancelBack"
    />
  </div>
</template>
<script>
export default {
  name: 'recharge',
  data() {
    return {
      pay_way: '',
      bankBox: {},
      payInfo: {},
      amount: null,
      cardLis: [],
      banklist: [],
      bankBox: {},
      meyXi: 'TRC20',
      payWayList: {},
      show: false,
      min_price: 100,
      max_price: 10000,
      paymentList: [], // 支付方式列表
      currentPayment: null, // 当前选中的支付方式
      showBackDialog: false, // 显示返回确认对话框
      hasSubmittedPay: false, // 是否已提交支付（有支付链接）
    };
  },
  computed: {
    // 汇率（除USDT外的支付方式使用），从 store 获取
    exchange_rate() {
      return (this.$store.state.userInfo && this.$store.state.userInfo.usdtrate) || 7.1;
    }
  },
  created() {
    let that = this;
    that.getPayments(); // 获取支付方式列表
    that.getPayWay();
    that.getBanklist();
    that.getcard();
  },
  beforeRouteLeave(to, from, next) {
    // 如果已提交支付且有支付链接，显示确认对话框
    if (this.hasSubmittedPay) {
      this.showBackDialog = true;
      // 阻止路由跳转，等待用户确认
      next(false);
    } else {
      next();
    }
  },
  methods: {
    getPayRange() {
      let that = this;
      let type = null;

      if (that.pay_way == 'bank') {
        type = 'bank';
      }
      if (that.pay_way == 'wechat') {
        type = 'wechat';
      }
      if (that.pay_way == 'alipay') {
        type = 'alipay';
      }
      if (that.pay_way == 'alipay') {
        type = 'alipay';
      }
      if (that.pay_way == 'usdt') {
        if (that.meyXi == 'ERC20') {
          type = 'usdt-erc20';
        }
        if (that.meyXi == 'TRC20') {
          type = 'usdt-trc20';
        }
      }
      // bank/wechat/alipay/usdt-erc20/usdt-trc20/ebpay    min_price max_price
      that.showLoading();

      that.$apiFun
        .post('/api/getPayRange', { type })
        .then(res => {
          if (res.code == 200) {
            that.min_price = res.data.min_price;
            that.max_price = res.data.max_price;
          }
          that.hideLoading();
        })
        .catch(res => {
          that.hideLoading();
        });
    },
    changShow() {
      this.show = !this.show;
    },
    onConfirm(value, index) {
      this.bankBox.bank = value.bank_name;
      this.show = false;
    },
    onChange(picker, value, index) {},
    onCancel() {
      this.show = false;
    },
    changXiyi(val) {
      if (this.meyXi == val) {
        return;
      }
      this.meyXi = val;
      this.getPayRange();
    },
    getPayments() {
      let that = this;
      that.$apiFun
        .get('/api/get_payments', {})
        .then(res => {
          if (res.code == 200 && res.data && res.data.length > 0) {
            that.paymentList = res.data;
            // 默认选择第一个支付方式
            if (!that.pay_way && res.data.length > 0) {
              that.changPayway(res.data[0].mch_id, res.data[0]);
            }
          }
        })
        .catch(res => {
          console.error('获取支付方式列表失败', res);
        });
    },
    getDefaultPayImg(mch_id) {
      // 根据 mch_id 返回默认图片
      const defaultImgs = {
        'weixin': '/static/image/QuickWechat.png',
        'wechat': '/static/image/QuickWechat.png',
        'alipay': '/static/image/icoAlipay2@3x.png',
        'usdt': '/static/image/1595237922936176.png',
        'bank': '/static/image/icoOnlineTransfer2@3x.png',
      };
      return defaultImgs[mch_id] || '/static/image/icoOnlineTransfer2@3x.png';
    },
    getPayWay() {
      let that = this;
      that.showLoading();

      that.$apiFun
        .get('/api/get_pay_way', {})
        .then(res => {
          if (res.code == 200) {
            that.payWayList = res.data;
            that.payWayList.rengong = 1;
            // 如果新接口没有数据，使用旧的方式
            if (that.paymentList.length === 0) {
              let obj = that.payWayList;
              for (let i in obj) {
                if (obj[i] == 1) {
                  that.pay_way = i == 'card' ? 'bank' : i;
                  that.hideLoading();
                  that.getPayRange();
                  return;
                }
              }
            }
          }
          that.hideLoading();
        })
        .catch(res => {
          that.hideLoading();
        });
    },
    payTest() {
      let that = this;
      let info = {};

      // 确定 paytype（优先使用当前选中的支付方式）
      let paytype = that.pay_way;
      if (that.currentPayment && that.currentPayment.mch_id) {
        paytype = that.mapMchIdToPaytype(that.currentPayment.mch_id);
      } else if (that.pay_way == 'wechat') {
        paytype = 'wxpay';
      }
      
      // bank 情况下  bank  bank_address  bank_no  bank_owner
      if (paytype == 'bank' || that.pay_way == 'bank') {
        info = {
          paytype: paytype,
          amount: that.amount * 1,
          bank: that.bankBox.bank,
          bank_address: that.bankBox.bank_address,
          bank_no: that.bankBox.bank_no,
          bank_owner: that.bankBox.bank_owner,
        };
        console.log(info);
        // 银行卡信息内容的限制
        if (!info.bank_owner) {
          that.showTost(0, '请输入存款人姓名');
          return;
        }
        if (!info.bank) {
          that.showTost(0, '请输入银行类型');
          return;
        }

        if (!info.bank_no) {
          that.showTost(0, '请输入银行卡号');
          return;
        }
        if (!info.bank_address) {
          that.showTost(0, '请输入银行开户行地址');
          return;
        }
      } else {
        info = {
          paytype: paytype,
          amount: that.amount * 1,
        };
      }
      if (paytype == 'usdt' || that.pay_way == 'usdt') {
        info.catepay = that.meyXi;
      }
      // usdt 情况下  catepay 必填

      // 支付的金额判断
      if (info.amount < that.min_price || info.amount > that.max_price) {
        that.showTost(0, `请输入金额在${that.min_price}-${that.max_price}之间！`);
        return;
      }
      that.showLoading();

      that.$apiFun
        .post('/api/recharge', info)
        .then(res => {
          if (res.code != 200) {
            // 失败立即关闭加载，避免一直转圈
            that.hideLoading();
            that.showTost(0, res.message);
            return;
          }
          if (res.code == 200) {
            if(res.data.pay_url){
              // 成功拿到支付链接也要先关闭加载，避免一直转圈
              that.hideLoading();
              that.amount = null;
              that.bankBox = {};
              // 标记已提交支付
              that.hasSubmittedPay = true;
              
              // 使用webview打开支付链接
              that.$router.push({
                path: '/webview',
                query: { 
                  url: encodeURIComponent(res.data.pay_url), 
                  title: '支付页面' 
                }
              });
              return;
            }
            that.amount = null;
            if (that.pay_way == 'bank') {
              that.showTost(1, '提交成功，等待后台审核');
              that.bankBox = {};
              that.amount = null;
              // 成功提交立即关闭加载，避免路由跳转后一直转圈
              that.hideLoading();
              that.$router.push({ path: '/transRecord' });
              return;
            }
            that.bankBox = {};
            that.amount = null;
            // 成功提交立即关闭加载，避免路由跳转后一直转圈
            that.hideLoading();
            that.$router.push({ path: `/payInfo?deposit_no=${res.message}` });
          }
          that.hideLoading();
        })
        .catch(res => {
          that.hideLoading();
        });
    },
    changMey(val) {
      this.amount = val * 1;
    },
    getBanklist() {
      let that = this;
      that.$apiFun
        .post('/api/banklist', {})
        .then(res => {
          if (res.code != 200) {
            that.showTost(0, res.message);
          }
          if (res.code == 200) {
            that.banklist = res.data;
          }
          that.hideLoading();
        })
        .catch(res => {
          that.hideLoading();
        });
    },
    getcard() {
      let that = this;
      that.showLoading();
      that.$apiFun
        .post('/api/getpaybank', {})
        .then(res => {
          if (res.code != 200) {
            that.showTost(0, res.message);
          }
          if (res.code == 200) {
            that.cardLis = res.data;

            that.hideLoading();
          }
        })
        .catch(res => {
          that.hideLoading();
        });
    },
    changPayway(val, payment = null) {
      let that = this;
      if (val == that.pay_way) {
        return;
      }
      that.pay_way = val;
      that.currentPayment = payment;
      that.bankBox = {};
      that.payInfo = {};
      that.amount = null;
      
      // 如果传入了支付方式对象，使用其 min_price 和 max_price
      if (payment && payment.min_price && payment.max_price) {
        that.min_price = payment.min_price;
        that.max_price = payment.max_price;
      } else {
        that.getPayRange();
      }
    },
    // 将 mch_id 映射为 paytype（用于充值接口）
    mapMchIdToPaytype(mch_id) {
      // mch_id 到 paytype 的映射
      const mchIdMap = {
        'weixin': 'wxpay',
        'wechat': 'wxpay',
        'alipay': 'alipay',
        'usdt': 'usdt',
        'bank': 'bank',
      };
      return mchIdMap[mch_id] || mch_id;
    },
    goNav(url) {
      let that = this;
      that.$parent.goNav(url);
    },
    doCopy(msg) {
      let cInput = document.createElement('input');
      cInput.style.opacity = '0';
      cInput.value = msg;
      document.body.appendChild(cInput);
      // 选取文本框内容
      cInput.select();

      // 执行浏览器复制命令
      // 复制命令会将当前选中的内容复制到剪切板中（这里就是创建的input标签）
      // Input要在正常的编辑状态下原生复制方法才会生效
      document.execCommand('copy');

      // 复制成功后再将构造的标签 移除
      this.showTost(1, '复制成功！');
    },
    getUserInfo() {
      let that = this;
      that.$parent.getUserInfo();
    },
    showLoading() {
      this.$parent.showLoading();
    },
    hideLoading() {
      this.$parent.hideLoading();
    },
    openKefu() {
      this.$parent.openKefu();
    },
    showTost(type, title) {
      this.$parent.showTost(type, title);
    },
    // 处理返回按钮点击
    handleBack() {
      // 如果已提交支付，显示确认对话框
      if (this.hasSubmittedPay) {
        this.showBackDialog = true;
      } else {
        // 未提交支付，直接返回
        this.$router.back();
      }
    },
    // 确认已完成支付，允许返回
    confirmBack() {
      this.showBackDialog = false;
      this.hasSubmittedPay = false; // 重置状态
      this.$router.back();
    },
    // 取消返回，继续支付
    cancelBack() {
      this.showBackDialog = false;
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
@import '../../static/css/2d87bbdbffeb4734e5c7.css';

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
  padding-top: 5px;
  border-radius: 12px;
  margin: 0.3rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  
  .hgs {
    width: calc(100% - 40px);
    margin: 0 auto;
    padding: 0.2rem 0;
  }
  .nams {
    font-size: 0.38rem;
    color: #333;
    vertical-align: middle;
    margin-top: 10px;
    margin-bottom: 8px;
    font-weight: 700;
    letter-spacing: 0.5px;
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
    color: #cf866b !important;
    border: 1px solid #cf866b !important;
  }
}
.typelis {
  width: 95%;
  margin: 12px auto;
  border-radius: 12px;
  box-sizing: border-box;
  padding: 8px;
  display: flex;
  flex-wrap: wrap;
  align-items: flex-start;
  justify-content: flex-start;
  gap: 0.3rem;
  background: #fff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  
  .tyls {
    border-radius: 10px;
    border: 1.5px solid #eee;
    text-align: center;
    width: calc(25% - 0.225rem);
    min-width: calc(25% - 0.225rem);
    max-width: calc(25% - 0.225rem);
    padding: 0.3rem 0.2rem;
    font-size: 0.3rem;
    transition: all 0.3s ease;
    background: #fafafa;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    
    &:active {
      transform: scale(0.95);
    }
    
    img {
      width: 0.75rem;
      height: 0.75rem;
      object-fit: contain;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.25rem;
      transition: transform 0.3s ease;
    }
    
    span {
      display: block;
      word-break: break-all;
      line-height: 1.2;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      width: 100%;
    }
    
    &:hover img {
      transform: scale(1.1);
    }
  }
  .tyls.atc {
    border: 1.5px solid #cf866b;
    color: #cf866b;
    background: linear-gradient(135deg, #fff5f0 0%, #ffe8e0 100%);
    box-shadow: 0 2px 6px rgba(207, 134, 107, 0.2);
    font-weight: 600;
  }
}
.lasthg {
  display: flex;
  align-items: center;
  font-size: 0.33rem;
  color: #a5a9b3;
  padding: 0.2rem 0;
  
  &.exchange-info {
    flex-direction: column;
    align-items: flex-start;
    padding: 0.4rem 0;
    gap: 0.3rem;
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
    border-radius: 8px;
    padding: 0.5rem;
    margin-top: 0.3rem;
    
    .exchange-rate,
    .expected-amount {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      padding: 0.2rem 0;
      
      .rate-label,
      .amount-label {
        font-size: 0.32rem;
        color: #666;
        font-weight: 500;
      }
      
      .rate-value {
        font-size: 0.36rem;
        color: #333;
        font-weight: 600;
      }
      
      .amount-value {
        font-size: 0.42rem;
        color: #cf866b;
        font-weight: 700;
        background: linear-gradient(135deg, #cf866b 0%, #e8a082 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }
    }
    
    .expected-amount {
      border-top: 1px solid #e8e8e8;
      padding-top: 0.4rem;
      margin-top: 0.2rem;
      
      .amount-value {
        font-size: 0.46rem;
      }
    }
  }
}

.bans {
  background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);
  width: 90%;
  margin: 0 auto;
  padding: 20px;
  border-radius: 16px;
  box-sizing: border-box;
  margin-bottom: 20px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
  border: 1px solid #e8f0fe;
  
  p {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.4rem 0;
    border-bottom: 1px solid #f0f0f0;
    
    &:last-child {
      border-bottom: none;
    }
    
    .frists {
      width: 70px;
      font-size: 0.32rem;
      color: #666;
      font-weight: 500;
    }
    .sdsw {
      flex: 1;
      font-size: 0.34rem;
      color: #333;
      font-weight: 600;
      text-align: right;
      margin-right: 0.3rem;
      word-break: break-all;
    }
    .copy {
      color: #069b71;
      font-size: 0.3rem;
      padding: 0.15rem 0.4rem;
      background: #e6f7f2;
      border-radius: 4px;
      font-weight: 600;
      transition: all 0.3s ease;
      
      &:active {
        background: #069b71;
        color: #fff;
        transform: scale(0.95);
      }
    }
  }
}
</style>
