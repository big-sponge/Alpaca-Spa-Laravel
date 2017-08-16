/* 1 定义模块中的AuthController ,并且定义两个action方法 */
Alpaca.MainModule.AuthController = {

    //loginView,  登录页面
    loginViewAction: function () {
        //视图默认渲染到#content位置，可以通过to对象改变渲染位置
        var view = new Alpaca.View();
        view.ready(function () {
            $.init();
            //登录按钮 - 调用后台登录接口
            $('.btn-sub-login').click(function () {
                var request    = {};
                request.email  = $('.login-form input[name="email"]').val();
                request.passwd = hex_md5($('.login-form input[name="password"]').val());
                AlpacaAjax({
                    url: g_url + API['email_login'],
                    data: request,
                    success: function (data) {
                        console.log(data);
                        if (data.code == 9900) {
                            Alpaca.to("#/main/index/index");
                        }
                    },
                });
            });
        });
        return view;
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

    //从后台获取微信登录授权地址
    getWxCodeAction: function (param) {

        var backData  = {};
        backData.url  = window.location.hash;
        backData.data = {};
        if (param.url) {
            backData.url = param.url;
        }
        if (param.data) {
            backData.url = param.data;
        }
        AlpacaCache.set('backData', backData);

        var back_uri = "/app/#/main/auth/wxLogin";
        var str = getWxAuthUrl(back_uri);
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
            url: g_url + API['wx_Login'],
            data: {code: code},
            newSuccess: function (data) {
                if (data.code == 9900) {
                    var redirect_uri = "/app/#/main/auth/wxLoginSuccess";
                    window.location.replace(redirect_uri);
                } else {
                    $.alert(data.msg, '', function () {
                        var redirect_uri = "/app/#/main/auth/wxLoginSuccess";
                        window.location.replace(redirect_uri);
                    });
                }
            },
        });
    },

    //微信openid登录成功
    wxLoginSuccessAction: function () {
        var backData = AlpacaCache.get('backData');
        var url      = "#/main/index/index";
        var data     = {};
        if (backData) {
            url  = backData.url;
            data = backData.data;
        }
        console.log(backData);
        Alpaca.to(url, data);
    },
};