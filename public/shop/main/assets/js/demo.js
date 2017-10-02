var zhichiJson = {
	zcdomain: location.protocol + "//www.sobot.com"
};
var compJson = {};
var attr = document.getElementById("zhichiload").src;
var oLen = attr.indexOf("?");
attr = attr.substring(oLen + 1, attr.length);
zhichiJson.urlAttr = attr;
var oArr = attr.split("&");
for (var i = 0; i < oArr.length; i++) {
	zhichiJson[oArr[i].split("=")[0]] = oArr[i].split("=")[1]
}

function getPos() {
	var a = new Date().getTime();
	var d = "getback" + a;
	var c = zhichiJson.zcdomain + "/chat/user/load.action?sysNum=" + zhichiJson.sysNum + "&source=1&callback=getback" + a;
	var b = document.createElement("script");
	b.id = "zhichiJsonp";
	b.setAttribute("src", c);
	document.body.appendChild(b);
	window[d] = function(f) {
		for (var e in f) {
			compJson[e] = f[e]
		}
		window[d] = null;
		document.body.removeChild(zhichi$("zhichiJsonp"));
		setDom()
	}
}
getPos();

function setDom() {
	var a = document.createElement("div");
	a.id = "zhichioBtnBox";
	a.innerHTML = '<a href="javascript:;" id="zhichiBtn" style="text-decoration: none;font-family:Microsoft Yahei,Arial,Helvetica;color: #fff;line-height: 50px;font-size: 18px;display: block;"><img src="' + zhichiJson.zcdomain + '/chat/h5/images/zhichichatBtnBg.png" style="vertical-align: middle;width:31px;  margin: -4px 15px 0 0px;border:none;"><span id="zhichiText" style="margin:0;padding:0;font-size: 16px;color: #fff;">' + compJson.title + '</span><img src="' + zhichiJson.zcdomain + '/chat/h5/images/btnrr.png" style="width:12px;  margin-left: 10px;  vertical-align: middle;margin-top: -3px;"></a>';
	document.body.appendChild(a);
	a.setAttribute("style", "position:fixed;bottom:0px;left:0px;width:100%;height:50px;background:" + compJson.color + ";text-align: center;");
	zhichi$("zhichiBtn").onclick = function() {
		window.location.href = zhichiJson.zcdomain + "/chat/h5/index.html?" + zhichiJson.urlAttr
	}
}

function zhichi$(a) {
	return document.getElementById(a)
};