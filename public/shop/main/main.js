//设置全局资源地址
var g_interval = {};

//后台接口列表
var API = {
    //登录、注册权限相关
    wx_Login: '/server/auth/wxLogin',                      //登录-微信
    email_login: '/server/auth/loginByEmail',              //登录-邮箱密码
    get_wxLogin_url: '/server/index/index',                //获取微信授权url
    auth_info: '/server/auth/info',                        //获取当前登录用户信息
    auth_wxInfo: '/server/auth/wxInfo',                    //获取当前登录用户微信信息
    auth_logout: '/server/auth/logout',                    //注销

    // web-socket
    server_test_Login: '/server/shake/testLogin',             //* 测试登录登录 */
    server_wx_Login: '/server/shake/wxLogin',                 //* 微信登录 */
    user_shake_token: '/server/shake/getWsToken',             //* 获取token接口 */
    ws_chat_user_login: 'chat/userLogin',                     //* WS 管理员账号登录（后台帐号） */
    ws_chat_send: 'chat/send',                                //* WS 发送消息 */
    ws_chat_online: 'chat/online',                            //* WS 获取在线人员 */
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

//弹出提示
Notific = function (param) {
    //默认设置
    var setting = {
        title: '操作提示',
        text: '提示信息',
        addclass: 'bg-primary',
        delay: 2000,
        hide: true,
        buttons: {
            closer: true,
            sticker: false
        }
    };

    //自定义设置
    if (typeof param == 'string') {
        setting['text'] = param;
    } else if (param) {
        for (var index in param) {
            setting[index] = param[index];
        }
    }

    alert(setting.text);
};

//封装Ajax
AlpacaAjax = function (param) {

    var success = function (data) {
        //没有登录
        if (data.code == "112") {
            var redirect = encodeURIComponent(window.location.href);
            Alpaca.to("#/main/auth/loginView",{redirect:redirect});
            return false;
        }
        //没有权限
        if (data.code == "139") {
            setTimeout(function () {
                Notific({text: data.msg});
            }, 200);
            return false;
        }
        //系统错误
        if (data.code == "9999") {
            Notific({text: data.msg});
        }
    };

    var successFunc = [];

    successFunc.push(success);

    var ajaxParam = {
        type: "post",
        url: g_url + "",
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
            Notific({heading: "访问远程服务提示", content: '访问出错了'});
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

//
Alpaca.addHashChangeEvent(function () {

    $('.close').click();

    $('.fancybox-close').click();

    //清除定时任务
    for (var i in g_interval) {
        clearInterval(g_interval[i]);
    }
});

/* 1 定义模块 */
Alpaca.MainModule = {

    //进入模块时执行
    init: function () {
        Alpaca.ViewModel.DefaultLayoutCaptureTo = ".page-group";
        Alpaca.ViewModel.DefaultViewCaptureTo   = ".page-group";
    },

    View: function (data) {
        var view = new Alpaca.View(data);
        view.ready(function () {
            $('.back').click(function () {
                history.go(-1);
            });
        });
        return view;
    },

    //获取用户信息
    getUserInfo: function (nocache) {

        var userInfo = AlpacaCache.get("userInfo");
        if (userInfo && userInfo['member'] && userInfo['member'].length != 0 && !nocache) {
            return userInfo;
        }
        AlpacaAjax({
            url: g_url + API['admin_auth_info'],
            data: {},
            async: false,
            success: function (data) {
                userInfo = data.data;
                AlpacaCache.set("userInfo", userInfo, 900);
            },
            beforeSend: function () {
            },
            complete: function () {
            },
        });
        return userInfo;
    },

    //页面公用布局-页脚
    pageFooter: function () {
        var footer = new Alpaca.Part({name: "pageFooter", to: "#page-content-footer"});
        return footer;
    },

    //页面公用布局
    pageView: function (data) {

        //获取用户信息
        // var userInfo = Alpaca.MainModule.getUserInfo();

        //Nav
        var nav = new Alpaca.Part({name: "footerNav", to: "#ap-page-nav"});

        //布局
        var layout = new Alpaca.Layout({name: "pageLayout", to: "body"});
        layout.addChild(nav);
        layout.ready(function () {
            $("title").html('后台管理DEMO');
            $('body').removeAttr('class');
            $('body').removeAttr('style');
        });

        //主视图
        var view = new Alpaca.View(data);
        view.setCaptureTo("#page-content");
        view.setLayout(layout);
        view.ready(function () {

            $.init();

            $('.page-title .position-left').click(function () {
                history.go(-1);
            });
        });
        return view;
    },

    //弹出页面公用布局
    alertView: function (data) {

        var view = new Alpaca.View(data);

        var layout = new Alpaca.Layout({name: "alertLayout", to: "#ap-page-alert"});

        layout.ready(function () {

        });

        view.setCaptureTo("#page-alert-content");

        view.setLayout(layout);

        return view;
    },

};

var WX_APP_ID = 'wx030ea3d763b7c9fb';

var getWxAuthUrl = function (redirect, scope) {

    if (!redirect) {
        redirect = '/app';
    }
    var reurl   = "http://" + window.location.host + '' + redirect;
    var baseUrl = encodeURIComponent(reurl);

    var urlObj              = {};
    urlObj["appid"]         = WX_APP_ID;
    urlObj["redirect_uri"]  = baseUrl;
    urlObj["response_type"] = "code";

    if (scope == 'base') {
        urlObj["scope"] = "snsapi_base";
    } else {
        urlObj["scope"] = "snsapi_userinfo";
    }
    urlObj["state"] = "STATE" + "#wechat_redirect";

    var toUrlParams = function (urlObj) {
        var buff = "";
        for (var k  in urlObj) {
            var v = urlObj[k];
            if (k != "sign") {
                buff += k + "=" + v + "&";
            }
        }

        if (buff.substr(0,1)=='&') {
            buff=buff.substr(1);
        }
        var reg=/&$/gi;

        buff=buff.replace(reg,"");

        return buff;
    };

    var bizString = toUrlParams(urlObj);

    var url = "https://open.weixin.qq.com/connect/oauth2/authorize?" + bizString;
    return url;
};
