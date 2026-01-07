import Vue from 'vue'
import Router from 'vue-router'
import Main from '@/components/Main'
import Login from '@/components/Login'
import agent from '@/components/agent'
import userredpacket from '@/components/userredpacket'

import PayInfo from '@/components/PayInfo'
import Register from '@/components/Register'
import index from '@/components/mode/index'
import help from '@/components/mode/help'
import vipInfo from '@/components/mode/vipInfo'
import discount from '@/components/mode/discount'
import sports from '@/components/mode/sports'
import lottery from '@/components/mode/lottery'
import electronic from '@/components/mode/electronic'
import people from '@/components/mode/people'
import cards from '@/components/mode/cards'
import app from '@/components/mode/app'
import amusement from '@/components/mode/amusement'
import amusementList from '@/components/mode/amusementList'

import game from '@/components/mine/game'//新开发组件
import discountInfo from '@/components/mode/discountInfo'
import mine from '@/components/mine/mine'
import deposit from '@/components/mine/deposit'
import withdrawal from '@/components/mine/withdrawal'
import transfer from '@/components/mine/transfer'
import transRecord from '@/components/mine/transRecord'
import betRecord from '@/components/mine/betRecord'
import bankCard from '@/components/mine/bankCard'
import myVip from '@/components/mine/myVip'
import boonCenter from '@/components/mine/boonCenter'
import mail from '@/components/mine/mail'
import apply from '@/components/mine/apply'
import applyList from '@/components/mine/applyList'
import userInfo from '@/components/mine/userInfo'
import password from '@/components/mine/password'
import contacts from '@/components/mine/contacts'
import welfare from '@/components/mine/welfare'

import perfunds from '@/components/mine/perfunds'
import zhanzhu01 from '@/components/zanzhu/zhanzhu01'
import zhanzhu02 from '@/components/zanzhu/zhanzhu02'
import zhanzhu03 from '@/components/zanzhu/zhanzhu03'
import zhanzhu04 from '@/components/zanzhu/zhanzhu04'
import zhanzhu05 from '@/components/zanzhu/zhanzhu05'

Vue.use(Router)

export default new Router({
  // mode: 'history',
  mode: 'hash',
  routes: [
    {
      path: '/',
      name: 'Main',
      component: Main,
      children: [
        {
          path: '/',
          name: 'index',
          component: index,
          meta: {
            keepAlive: true,//是否缓存组件
            useCatch: false//是否用缓存
          }
        }, {
          path: '/vipInfo',
          name: 'vipInfo',
          // meta: {
          //   requireAuth: true,
          // },
          component: vipInfo,

        }, {
          path: '/help',
          name: 'help',
          meta: {
            // requireAuth: true,
            keepAlive: true,//是否缓存组件
            useCatch: false//是否用缓存
          },
          component: help,

        }, {
          path: '/discount',
          name: 'discount',
          // meta: {
          //   requireAuth: true,
          // },
          component: discount,

        }, {
          path: '/discountInfo',
          name: 'discountInfo',
          // meta: {
          //   requireAuth: true,
          // },
          component: discountInfo,

        }, {
          path: '/zhanzhu01',
          name: 'zhanzhu01',
          // meta: {
          //   requireAuth: true,
          // },
          component: zhanzhu01,
        }, {
          path: '/zhanzhu02',
          name: 'zhanzhu02',
          // meta: {
          //   requireAuth: true,
          // },
          component: zhanzhu02,
        }, {
          path: '/zhanzhu03',
          name: 'zhanzhu03',
          // meta: {
          //   requireAuth: true,
          // },
          component: zhanzhu03,
        }, {
          path: '/zhanzhu04',
          name: 'zhanzhu04',
          // meta: {
          //   requireAuth: true,
          // },
          component: zhanzhu04,
        }, {
          path: '/zhanzhu05',
          name: 'zhanzhu05',
          // meta: {
          //   requireAuth: true,
          // },
          component: zhanzhu05,
        }, {
          path: '/sports',
          name: 'sports',

          component: sports,
          meta: {
            keepAlive: true,//是否缓存组件
            useCatch: false//是否用缓存
          }
        }, {
          path: '/game',
          name: 'game',

          component: game,
          meta: {
            keepAlive: true,//是否缓存组件
            useCatch: false//是否用缓存
          }
        }
        , {
          path: '/lottery',
          name: 'lottery',

          component: lottery, meta: {
            keepAlive: true,//是否缓存组件
            useCatch: false//是否用缓存
          }
        }, {
          path: '/electronic',
          name: 'electronic',

          component: electronic,
          meta: {
            keepAlive: true,//是否缓存组件
            useCatch: false//是否用缓存
          }
        }, {
          path: '/people',
          name: 'people',

          component: people, meta: {
            keepAlive: true,//是否缓存组件
            useCatch: false//是否用缓存
          }
        }, {
          path: '/cards',
          name: 'cards',

          component: cards,
          meta: {
            keepAlive: true,//是否缓存组件
            useCatch: false//是否用缓存
          }
        }, {
          path: '/app',
          name: 'app',
          // meta: {
          //   requireAuth: true,
          // },
          component: app,
        }, {
          path: '/amusement',
          name: 'amusement',

          component: amusement,
          meta: {
            keepAlive: true,//是否缓存组件
            useCatch: false//是否用缓存
          }
        }, {
          path: '/amusementList',
          name: 'amusementList',
          // meta: {
          //   requireAuth: true,
          // },
          component: amusementList,
          meta: {
            keepAlive: true,//是否缓存组件
            useCatch: false//是否用缓存
          }
        }


      ]
    }
    ,
    {
      path: '/login',
      name: 'login',
      component: Login,
    }, {
      path: '/agent',
      name: 'agent',
      // meta: {
      //   requireAuth: true,
      // },
      component: agent,
    }, {
      path: '/userredpacket',
      name: 'userredpacket',
      // meta: {
      //   requireAuth: true,
      // },
      component: userredpacket,
    },
    {
      path: '/payInfo',
      name: 'payInfo',
      meta: {
        requireAuth: true,
      },
      component: PayInfo,
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
    },
    {
      path: '/mine',
      name: 'mine',
      title: '个人中心',
      component: Main,
      children: [{
        path: '/mine/mine',
        name: 'mine',
        title: '个人中心父',
        meta: {
          requireAuth: true,
        },
        component: mine,
        children: [{
          path: '/mine/deposit',
          name: 'deposit',
          title: '存款',
          meta: {
            requireAuth: true,
            keepAlive: true,//是否缓存组件
            useCatch: false//是否用缓存
          },
          component: deposit,
        }, {
          path: '/mine/withdrawal',
          name: 'withdrawal',
          title: '取款',
          meta: {
            requireAuth: true,
          },
          component: withdrawal,
        }, {
          path: '/mine/transfer',
          name: 'transfer',
          title: '转账',
          meta: {
            requireAuth: true,
          },
          component: transfer,
        }, {
          path: '/mine/transRecord',
          name: 'transRecord',
          title: '交易记录',
          meta: {
            requireAuth: true,
          },
          component: transRecord,
        }, {
          path: '/mine/betRecord',
          name: 'betRecord',
          title: '投注记录',
          meta: {
            requireAuth: true,
          },
          component: betRecord,
        }, {
          path: '/mine/bankCard',
          name: 'bankCard',
          title: '银行卡',
          meta: {
            requireAuth: true,
          },
          component: bankCard,
        }, {
          path: '/mine/myVip',
          name: 'myVip',
          title: '账户中心',
          meta: {
            requireAuth: true,
          },
          component: myVip,
        }, {
          path: '/mine/boonCenter',
          name: 'boonCenter',
          title: '返水中心',
          meta: {
            requireAuth: true,
          },
          component: boonCenter,
        }, {
          path: '/mine/mail',
          name: 'mail',
          title: '消息公告',
          meta: {
            requireAuth: true,
          },
          component: mail,
        }, {
          path: '/mine/userInfo',
          name: 'userInfo',
          title: '个人资料',
          meta: {
            requireAuth: true,
          },
          component: userInfo,
        }, {
          path: '/mine/password',
          name: 'password',
          title: '密码修改',
          meta: {
            requireAuth: true,
          },
          component: password,
        }, {
          path: '/mine/contacts',
          name: 'contacts',
          title: '手机邮箱',
          meta: {
            requireAuth: true,
          },
          component: contacts,
        }, {
          path: '/mine/welfare',
          name: 'welfare',
          title: '红包',
          meta: {
            requireAuth: true,
          },
          component: welfare,
        }, {
          path: '/mine/perfunds',
          name: 'perfunds',
          title: '资金明细',
          meta: {
            requireAuth: true,
          },
          component: perfunds,
        }, {
          path: '/mine/apply',
          name: 'apply',
          title: '申请代理',
          meta: {
            requireAuth: true,
          },
          component: apply,
        }, {
          path: '/mine/applyList',
          name: 'applyList',
          title: '活动申请记录',
          meta: {
            requireAuth: true,
          },
          component: applyList,
        }
        ]
      }]
    }
  ]
})
