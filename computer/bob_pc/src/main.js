// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import apiFun from "@/http/api.js";



// 引入 我们准备好的 store
import store from '@/store/index.js'

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(ElementUI);

Vue.prototype.$apiFun = apiFun;//请求接口api

Vue.config.productionTip = false

router.afterEach((to, from, next) => {

  window.scrollTo(0, 0);//没到一个新的页面 就自动回顶

});
router.beforeEach((to, from, next) => {
  let token = sessionStorage.getItem('token');
  
  if (token) {
    // 已登录
    next();
  } else {
    // 未登录
    if (to.matched.some(record => record.meta.requireAuth)) {
      // 需要登录的页面，跳转到登录页
      next({
        path: '/login',
        query: { redirect: to.fullPath }
      });
    } else {
      // 不需要登录的页面，放行
      next();
    }
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
