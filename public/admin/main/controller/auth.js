/* 1 定义模块中的AuthController ,并且定义两个action方法 */
Alpaca.MainModule.AuthController = {

    //loginView,  登录页面
    loginViewAction: function () {

        var redirect = Alpaca.Router.getParams(0);

        //视图默认渲染到#content位置，可以通过to对象改变渲染位置
        var view   = new Alpaca.View();
        var footer = Alpaca.MainModule.pageFooter();
        view.addChild(footer);
        view.setCaptureTo('body');
        view.ready(function () {
            $('body').addClass('login-container');

            //格式化页面
            LayoutInit();

            //登录按钮 - 调用后台登录接口
            $('.btn-sub-login').click(function () {
                var request       = {};
                request.email = $('.login-form input[name="login_name"]').val();
                request.passwd  = hex_md5($('.login-form input[name="password"]').val());
                AlpacaAjax({
                    url: g_url + API['admin_auth_login'],
                    data: request,
                    success: function (data) {
                        Notific(data.msg);
                        if(data.code == 9900){
                            console.log(redirect);
                            if(redirect){
                                window.location.replace(decodeURIComponent(redirect));
                                return;
                            }

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
                    window.location.href="/admin/#/main/auth/loginView";
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
        var view = new Alpaca.MainModule.pageView({data:userInfo['member']});
        return view;
    },

    //重置密码 - 页面
    resetPasswordViewAction: function () {
        var view = new Alpaca.MainModule.pageView();
        return view;
    },

};