/* 1 定义Metro模块中的IndexController ,并且定义两个action方法，test3，test4*/
Alpaca.MainModule.TestController = {

    //pull-to-refresh,  默认渲染到
    postsAction: function () {
        var view = new Alpaca.MainModule.View();
        view.ready(function () {
            //下拉刷新页面
            var $content = $(".content2").on('refresh', function (e) {
                // 模拟2s的加载过程
                setTimeout(function () {
                    var cardHTML = '<div class="card-content-inner">下拉屏幕试试，会出现更多的卡片' + '</div>';
                    $content.find('.card-content').prepend(cardHTML);
                    // $(window).scrollTop(0);
                    // 加载完毕需要重置
                    $.pullToRefreshDone($content);
                }, 100);
            });
            $.init();
        });
        return view;
    },

    ocrAction: function () {
        var view = new Alpaca.MainModule.View();
        view.ready(function () {
            /* 获取设备号*/
            var token = Alpaca.Router.getParams(0);

            AlpacaAjax({
                url: g_url + API['user_ocr_getDeviceId'],
                data: {token:token},
                newSuccess: function (data) {
                    if (data.code == "112") {
                        var redirect = encodeURIComponent(window.location.href);
                        Alpaca.to("#/main/auth/testLoginView/" + redirect);
                        return false;
                    }
                    if (data.code != 9900) {
                        return;
                    }

                    $('#device-id').html(data.data);

                },
            });
        });
        return view;
    },

};