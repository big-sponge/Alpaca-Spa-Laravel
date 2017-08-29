/* 1 定义模块中的AuthController ,并且定义两个action方法 */
Alpaca.WappModule.AuthController = {

    //loginView,  登录页面
    loginViewAction: function (data) {
        var redirect = Alpaca.Router.getParams(0);
        Alpaca.to('#/wapp/auth/getWxCode/' + redirect, data);
    },

    //注销-调用服务器接口
    logoutAction: function () {
        AlpacaAjax({
            url: g_url + API['admin_auth_logout'],
            newSuccess: function (data) {
                if (data.code == 9900) {
                    AlpacaCache.clear();
                    Alpaca.to("#/main/auth/loginView");
                } else {
                    AlpacaCache.clear();
                    alert(data.msg);
                }
            },
        });
    },

    //获取用户个人信息 - 页面
    myInfoViewAction: function () {
        var userInfo = Alpaca.MainModule.getUserInfo(true);
        var view     = new Alpaca.MainModule.pageView({data: userInfo['member']});
        return view;
    },

    //重置密码 - 页面
    resetPasswordViewAction: function () {
        var view = new Alpaca.MainModule.pageView();
        return view;
    },

    //获取微信登录授权地址
    getWxCodeAction: function (param) {
        var redirect = Alpaca.Router.getParams(0);
        var back_uri = "/shake/wapp.html#/wapp/auth/wxLogin/" + redirect;
        var str      = getWxAuthUrl(back_uri);
        window.location.replace(str);
    },

    //发送code给后台，微信openid登录
    wxLoginAction: function () {
        function GetQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r   = window.location.search.substr(1).match(reg);
            if (r != null) {
                return (r[2]);
            }
            return null;
        }

        var code = GetQueryString('code');
        AlpacaAjax({
            url: G_URL + API['server_wx_Login'],
            data: {code: code},
            newSuccess: function (data) {
                if (data.code == 9900) {
                    console.log(data);
                    var redirect = Alpaca.Router.getParams(0);
                    if (redirect) {
                        window.location.replace(decodeURIComponent(redirect));
                    }
                }
            },
        });
    },

    //获取Ws-token
    getWsTokenAction: function () {
        //拉去后台数据 - 获取活动详情
        AlpacaAjax({
            url: G_URL + API['server_shake_token'],
            data: {},
            success: function (data) {
                //请求正确
                if (data.code == 9900) {
                    console.log(data);
                    //开启webSocket

                    WS = new WebSocket(WS_URL);

                    WS.onopen = function () {
                        console.log('连接成功');
                        //登录  webSocket
                        var request    = {};
                        request.action = API['ws_server_login'];
                        request.data   = {
                            token: data.data
                        };
                        WS.send(JSON.stringify(request));
                    };

                    WS.onmessage = function (event) {
                        Alpaca.to('#/wapp/index/router',event);
                    }

                }
            },
        });
    },
};