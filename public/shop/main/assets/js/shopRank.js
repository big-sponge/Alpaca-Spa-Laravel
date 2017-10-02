/**
 ** 作者：陈锦川
 ** 时间：2016/05/27
 ** 描述：公共库
 **
 **/

// 数据地址
var server_ip = 'https://service.zhidianlife.com/'; // 正式url
//var server_ip = 'http://119.147.171.111:8081/zhidian_java/'; // 仿真url
//var server_ip = 'http://192.168.199.167:8080/';
// 图片地址
var storage_ip = 'https://img.zhidianlife.com/';
// 用户ID
var sessionId = '';
var app_key = 'android';
var secret_key = '7E41CE7E78F0C5C9CF811D9058A7FB28';
var myDate = new Date();
var timestamp = myDate.getFullYear() + '-' + (myDate.getMonth() + 1) + '-' + myDate.getDate() + ' ' + myDate.getHours() + ':' + myDate.getMinutes() + ':' + myDate.getSeconds();

var userId = '';

// Url解析
function getJsUrl() {
	var pos, str, para, parastr;
	var array = []
	str = location.href;
	parastr = str.split("?")[1];
	var arr = parastr.split("&");
	for (var i = 0; i < arr.length; i++) {
		array[arr[i].split("=")[0]] = arr[i].split("=")[1];
	}
	return array;
}