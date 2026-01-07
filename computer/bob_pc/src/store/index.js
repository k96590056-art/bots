import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)
let userInfo = JSON.parse(localStorage.getItem('userInfo'))?JSON.parse(localStorage.getItem('userInfo')) :{};
let appInfo = JSON.parse(localStorage.getItem('appInfo'))?JSON.parse(localStorage.getItem('appInfo')) :{};
let messageNum = localStorage.getItem("messageNum") || 0 ;
// 优先从localStorage读取token（记住密码），如果没有则从sessionStorage读取
let token = localStorage.getItem("token") || sessionStorage.getItem("token") || '';

export default new Vuex.Store({
  //state存放状态,
  state: {
    userInfo,
    token,
    game_content : "",
    messageNum,
    appInfo
  },
  //getter为state的计算属性
  getters: {
    getGameContent: state => state.game_content
  },
  //mutations可更改状态的逻辑，同步操作
  mutations: {
      setGameContent(state, content) {
      state.game_content = content
    },
    changToken(state){
      // 优先从localStorage读取token（记住密码），如果没有则从sessionStorage读取
      state.token = localStorage.getItem('token') || sessionStorage.getItem('token') || ''; 
    },
    changUserInfo(state){
        let userInfo = JSON.parse(localStorage.getItem('userInfo'))
        state.userInfo = userInfo ;
    },
    changappInfo(state){
      let appInfo = JSON.parse(localStorage.getItem('appInfo'))
      state.appInfo = appInfo ;
  }
    ,changMessageNum(state){
      let show = localStorage.getItem('show');
      state.messageNum = show ? 0 : localStorage.getItem('messageNum'); 
    }
  },
  //提交mutation，异步操作
  actions: {
    updateGameContent({ commit }, content) {
      commit('setGameContent', content)
    }
  },
  // 将store模块化
  modules: {
  }
})
