//引入刚才的http.js文件
import https from './http.js';
	
	//设置个对象，就不用一个个暴露了，直接暴露对象
	let apiFun = {};
	
	/* 获取列表 */
	//查询列表，详情就是get
	/* /api/getlist是请求接口地址，有http.js里面的Ip加上，如：http:192.168.0.1:9090//api/getlist  */
	apiFun.get = function(url,params) {
		return https.get(url, params)
	}
	
    apiFun.post = function(url,params) {
		return https.post(url, params)
	}
    apiFun.login = function(params) {
		return https.post('/api/login_pc', params)
		// return https.post('/api/login', params)
	}
	apiFun.register = function(params) {
		return https.post('/api/register', params)
	}
	//暴露出这个对象
	export default apiFun;

// 天美社区源码网 timibbs.net timibbs.com timibbs.vip