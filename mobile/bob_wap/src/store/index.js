import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)
let userInfo = JSON.parse(localStorage.getItem('userInfo')) || {};
let token = sessionStorage.getItem("token") || '';

let appInfo = JSON.parse(localStorage.getItem('appInfo')) || {};
let messageNum = token ? localStorage.getItem("messageNum") || 0 : 0;

// 初始化时从 localStorage 加载游戏列表（按 category_id 组织的对象）
let gameListByCategory = localStorage.getItem('gameListByCategory') ? JSON.parse(localStorage.getItem('gameListByCategory')) : {};

// 兼容旧数据：如果存在旧的分类数据，迁移到新格式
if (Object.keys(gameListByCategory).length === 0) {
  let realbetList = localStorage.getItem('realbetList') ? JSON.parse(localStorage.getItem('realbetList')) : [];
  let jokerList = localStorage.getItem('jokerList') ? JSON.parse(localStorage.getItem('jokerList')) : [];
  let gamingList = localStorage.getItem('gamingList') ? JSON.parse(localStorage.getItem('gamingList')) : [];
  let sportList = localStorage.getItem('sportList') ? JSON.parse(localStorage.getItem('sportList')) : [];
  let lotteryList = localStorage.getItem('lotteryList') ? JSON.parse(localStorage.getItem('lotteryList')) : [];
  let conciseList = localStorage.getItem('conciseList') ? JSON.parse(localStorage.getItem('conciseList')) : [];
  
  if (realbetList.length > 0 || jokerList.length > 0 || gamingList.length > 0 || 
      sportList.length > 0 || lotteryList.length > 0 || conciseList.length > 0) {
    gameListByCategory = {
      realbet: realbetList,
      joker: jokerList,
      gaming: gamingList,
      sport: sportList,
      lottery: lotteryList,
      concise: conciseList
    };
    localStorage.setItem('gameListByCategory', JSON.stringify(gameListByCategory));
  }
}

export default new Vuex.Store({
  //state存放状态,
  state: {
    userInfo,
    token,
    messageNum,
    appInfo,
    bannerList: [],
    gameListByCategory, // 按 category_id 组织的游戏列表对象
  },
  //getter为state的计算属性
  getters: {
    // 兼容旧代码，提供 getter 方法获取各个分类的游戏列表
    realbetList: (state) => state.gameListByCategory.realbet || [],
    jokerList: (state) => state.gameListByCategory.joker || [],
    gamingList: (state) => state.gameListByCategory.gaming || [],
    sportList: (state) => state.gameListByCategory.sport || [],
    lotteryList: (state) => state.gameListByCategory.lottery || [],
    conciseList: (state) => state.gameListByCategory.concise || [],
    // 根据 category_id 获取游戏列表
    getGameListByCategory: (state) => (categoryId) => {
      return state.gameListByCategory[categoryId] || [];
    }
  },
  //mutations可更改状态的逻辑，同步操作
  mutations: {
    changGameList(state) {
      let bannerList = localStorage.getItem('bannerList') ? JSON.parse(localStorage.getItem('bannerList')) : [];
      state.bannerList = bannerList;
      
      // 从 localStorage 加载按 category_id 组织的游戏列表
      let gameListByCategory = localStorage.getItem('gameListByCategory') ? JSON.parse(localStorage.getItem('gameListByCategory')) : {};
      state.gameListByCategory = gameListByCategory;
    },
    changUserInfo(state) {
      let userInfo = localStorage.getItem('userInfo') ? JSON.parse(localStorage.getItem('userInfo')) : {};
      state.userInfo = userInfo;
    },
    changToken(state) {
      state.token = sessionStorage.getItem('token') || '';
    }
    , changMessageNum(state) {
      let show = localStorage.getItem('show');
      state.messageNum = show ? 0 : localStorage.getItem('messageNum');
    }
    , changappInfo(state) {
      let appInfo = JSON.parse(localStorage.getItem('appInfo'))
      state.appInfo = appInfo;
    },
  },
  //提交mutation，异步操作
  actions: {

  },
  // 将store模块化
  modules: {
  }
})
