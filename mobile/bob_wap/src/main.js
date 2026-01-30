// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import apiFun from "@/http/api.js";
// 引入 我们准备好的 store
import store from '@/store/index.js'
// import ElementUI from 'element-ui';
// import 'element-ui/lib/theme-chalk/index.css'
// Vue.use(ElementUI);
import  "amfe-flexible";
import Vant from 'vant';
import 'vant/lib/index.css';
import './assets/dark-mode.css';
Vue.use(Vant);

// 全局注册
Vue.prototype.$apiFun = apiFun;//请求接口api

Vue.config.productionTip = false

// 全局夜晚模式：根据 localStorage.nightMode 给 body 打标
try {
  const nightMode = localStorage.getItem('nightMode') === 'true';
  document.body.classList.toggle('dark', nightMode);
} catch (e) {}

// 初始化 Token：从 localStorage 恢复或清除过期 Token
try {
  let localToken = localStorage.getItem('token');
  let expireTime = localStorage.getItem('token_expire_time');
  let now = new Date().getTime();
  
  if (localToken) {
    if (expireTime && now > parseInt(expireTime)) {
      // 已过期
      localStorage.removeItem('token');
      localStorage.removeItem('token_expire_time');
      localStorage.removeItem('userInfo');
      sessionStorage.removeItem('token');
    } else {
      // 未过期，同步到 sessionStorage
      if (!sessionStorage.getItem('token')) {
        sessionStorage.setItem('token', localToken);
      }
    }
  }
  // 同步 Vuex 状态
  store.commit('changToken');
} catch (e) {}

router.afterEach((to, from, next) => {
  
  window.scrollTo(0, 0);//每到一个新的页面 就自动回顶
  if(document.querySelector(".index-page")){
    document.querySelector(".index-page").scrollTo(0, 0) ;//

  }
});
router.beforeEach((to, from, next) => {
  // 路由跳转时再次检查 Token 有效性
  let localToken = localStorage.getItem('token');
  let expireTime = localStorage.getItem('token_expire_time');
  let now = new Date().getTime();
  let isExpired = false;
  
  if (localToken && expireTime && now > parseInt(expireTime)) {
    // 已过期，清除所有相关信息
    localStorage.removeItem('token');
    localStorage.removeItem('token_expire_time');
    localStorage.removeItem('userInfo');
    sessionStorage.removeItem('token');
    store.commit('changToken'); // 同步 Vuex
    isExpired = true;
  }

  let token = sessionStorage.getItem('token') ? sessionStorage.getItem('token') : '';
  if (to.matched.some(res => res.meta.requireAuth)) { // 验证是否需要登陆
    if (sessionStorage.getItem('token')) { // 查询本地存储信息是否已经登陆
      next();
    } else {
      next({
        path: '/login', // 未登录则跳转至login页面
        query: { 
          redirect: to.fullPath,
          msg: isExpired ? 'expired' : undefined
        } // 登陆成功后回到当前页面，这里传值给login页面，to.fullPath为当前点击的页面
      });
    }
  } else {
    next();
  }


});
/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,//使用store
  router,
  components: { App },
  template: '<App/>'
})
