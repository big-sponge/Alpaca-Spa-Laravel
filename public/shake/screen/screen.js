//设置全局资源地址
var g_interval = {};

//后台接口列表
var API = {
    admin_shake_token: '/manage/shake/getWsToken',             //* 获取token接口 */

    ws_admin_login: 'admin/login',                            //* WS 管理员登录 */

    ws_admin_shake_activity: 'admin/shake_activity',          //* WS 获取活动信息，（下一轮） */

    ws_admin_shake_pre_start: 'admin/shake_pre_start',         //* WS 开始倒计时 */

    ws_admin_shake_start: 'admin/shake_start',                 //* WS 开始游戏 */

    ws_admin_shake_stop: 'admin/shake_stop',                   //* WS 结束游戏 */

    ws_admin_shake_users: 'admin/shake_users',                 //* WS 在线人员 */
};

Date.prototype.format = function (fmt) { //author: meizz
    var o = {
        "M+": this.getMonth() + 1, //月份
        "d+": this.getDate(), //日
        "h+": this.getHours(), //小时
        "m+": this.getMinutes(), //分
        "s+": this.getSeconds(), //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds() //毫秒
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
};

var openPop = function (text) {
    $(".error-box").toggle();
    $(".error").toggle();
    $(".error").animate({"top": "50%", "margin-top": "-270px"}, 500);
    $(".error .close").click(function () {
        $(".error").hide();
        $(".error").css("top", "-540px");
        $(".error-box").hide();
    });
    $(".error .err-bottom").html(text);
}

//封装Ajax
AlpacaAjax = function (param) {

    var success = function (data) {
        //没有登录
        if (data.code == "112") {
            var redirect = encodeURIComponent(window.location.href);
            var url      = G_URL + '/admin/#/main/auth/loginView/' + redirect;
            window.location.replace(url);
            return false;
        }
        //没有权限
        if (data.code == "139") {
            alert(data.msg);
            return false;
        }
        //系统错误
        if (data.code == "9999") {
            alert(data.msg);
            return false;
        }
    };

    var successFunc = [];

    successFunc.push(success);

    var ajaxParam = {
        type: "post",
        url: G_URL + "",
        data: {},
        dataType: "json",
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true,
        async: true,
        beforeSend: function () {
        },
        success: function (data) {
            for (var index in successFunc) {
                if (successFunc[index](data) === false) {
                    break;
                }
            }
        },
        complete: function () {

        },
        error: function () {

        }
    };

    for (var p in param) { // 方法
        if (p == "success") {
            successFunc.push(param[p]);
        } else if (p == "newSuccess") {
            ajaxParam["success"] = param[p];
        } else {
            ajaxParam[p] = param[p];
        }
    }

    $.ajax(ajaxParam);
};

//前端缓存
AlpacaCache = (function () {

    //默认缓存时间，30秒
    var defaultTime = 30;

    //缓存对象
    var cache = {
        //读取数据数据
        get: function (key) {
            //使用H5缓存
            if (window.sessionStorage) {
                //读取数据
                var info = sessionStorage.getItem(key);
                if (!info || info == "undefined") {
                    return null;
                }
                var infoData = JSON.parse(info);

                //判断是否超时
                if (infoData['time'] > new Date().getTime()) {
                    return infoData.data;
                }
                return null;
            }
            return null;
        },
        //保存数据
        set: function (key, value, time) {

            //time默认时间
            if (!time) {
                time = defaultTime;
            }

            //有效时间
            var exTime = new Date().getTime() + (time * 1000);
            var data   = {
                data: value,
                time: exTime,
            };

            //使用H5保存
            if (window.sessionStorage) {
                sessionStorage.setItem(key, JSON.stringify(data));
            }
        },
        //保存数据
        delete: function (key) {
            if (window.sessionStorage) {
                sessionStorage.removeItem(key);
            }
        },
        //保存数据
        clear: function () {
            if (window.sessionStorage) {
                sessionStorage.clear();
            }
        }
    };
    return cache;
})();

// hash改变
Alpaca.addHashChangeEvent(function () {

    $('.close').click();

    $('.fancybox-close').click();

    //清除定时任务
    for (var i in g_interval) {
        clearInterval(g_interval[i]);
    }
});

/* 1 定义模块 */
Alpaca.ScreenModule = {

    //进入模块时执行
    init: function () {
        Alpaca.ViewModel.DefaultLayoutCaptureTo = "body";
        Alpaca.ViewModel.DefaultViewCaptureTo   = "#page-content";
    },

};
