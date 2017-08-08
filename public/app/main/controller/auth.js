/* 1 定义模块中的AuthController ,并且定义两个action方法 */
Alpaca.MainModule.AuthController = {

    //loginView,  登录页面
    loginViewAction: function () {
        //视图默认渲染到#content位置，可以通过to对象改变渲染位置
        var view   = new Alpaca.View();
        view.ready(function () {
            $.init();
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
        var view = new Alpaca.MainModule.pageView({data:userInfo['member']});
        return view;
    },

    //重置密码 - 页面
    resetPasswordViewAction: function () {
        var view = new Alpaca.MainModule.pageView();
        return view;
    },

};