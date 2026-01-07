import axios from 'axios'     //引入
import store from '../store' // 引入store

// 从 config/index.js 中读取 API 地址（通过 webpack DefinePlugin 注入）
let baseURL = process.env.API_BASE_URL || 'https://botapi.leyu666.lol'

sessionStorage.setItem("baseURL",baseURL)
//这一步的目的是判断出当前是开发环境还是生成环境，方法不止一种，达到目的就行
if(process.env.NODE_ENV=="development"){
  baseURL=''
}

let config = {
    baseURL: baseURL,
    timeout: 30000       //设置最大请求时间
}
const _axios = axios.create(config)

/* 请求拦截器（请求之前的操作） */
_axios.interceptors.request.use(
    config => {
        //如果有需要在这里开启请求时的loading动画效果
        // Authorization:Bearer hPxf6a8TQnCkExTYxceujYgXoW9GXB9909zsZtpvabw6yO9ngcMVKgLx4mzD
        let token = sessionStorage.getItem('token') ? sessionStorage.getItem('token') : ''
        config.headers.Authorization = 'Bearer ' + token;  //添加token,需要结合自己的实际情况添加，

        return config;
    },
    err => Promise.reject(err)
);
// 天美社区源码网 timibbs.net timibbs.com timibbs.vip
/* 请求之后的操作 */
_axios.interceptors.response.use(
    res => {
        //在这里关闭请求时的loading动画效果
        //这里用于处理返回的结果，比如如果是返回401无权限，可能会是跳回到登录页的操作，结合自己的业务逻辑写
        if (res.data.code === 1000) {
            // console.log(12)

        }
        
        // 全局处理401登录过期
        if (res.data.code === 401) {
             sessionStorage.removeItem('token');
             localStorage.removeItem('token');
             localStorage.removeItem('userInfo');
             
             store.commit('changToken');
             store.commit('changUserInfo');
             
             // 使用hash模式跳转
             window.location.hash = '#/login';
        }

        // if (res.data.code === 400) {
        //     Toast("请求网络失败")
        // }
        // if (res.data.code === 404) {
        //     Toast("请求网络失败")
        // }
        return res;
    },
    err => {
        if (err) {
            //在这里关闭请求时的loading动画效果
            // Toast("请求网络失败")
        }
        return Promise.reject(err);
    }
);

//封装post,get方法
const http = {
    get(url = '', params = {}) {
        return new Promise((resolve, reject) => {
            // 'Content-Type': 'application/json'
            _axios({
                url,
                params,
                headers: { 'Content-Type': 'application/json;charset=UTF-8' },
                method: 'GET'
            }).then(res => {
                resolve(res.data)
                return res
            }).catch(error => {
                reject(error)
            })
        })
    },
    post(url = '', params = {}) {
        if (url == '/api/register' || url == '/api/login_pc') {
            sessionStorage.setItem("baseURL", baseURL)
        }
        return new Promise((resolve, reject) => {
            _axios({
                url,
                data: params,
                headers: { 'Content-Type': 'application/json;charset=UTF-8' },
                method: 'POST'
            }).then(res => {
                resolve(res.data)
                return res
            }).catch(error => {
                reject(error)
            })
        })
    }
}


export default http
