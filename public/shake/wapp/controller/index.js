var shake_doing = null;

var shakeEventDidOccur = function () {

    var audio = document.getElementById('shake_audio');
    audio.play();
    if (typeof WeixinJSBridge == "object" && typeof WeixinJSBridge.invoke == "function") {
        WeixinJSBridge.invoke('getNetworkType', {}, function (res) {
            audio.currentTime = 0;
            audio.play();
        });
    }

    Alpaca.to('#/wapp/index/upShake');
};

Alpaca.WappModule.IndexController = {

    // 处理 ws 路由
    routerAction: function (event) {
        var acceptData = JSON.parse(event.data);
        console.log(acceptData);
        var action = acceptData.action;
        switch (action) {
            case 'server/login':
                Alpaca.to('#/wapp/index/index', acceptData);
                break;
            case 'server/shake_activity':
                Alpaca.to('#/wapp/index/shake', acceptData);
                break;
            case 'server/shake_pre_start':
                Alpaca.to('#/wapp/index/preStart', acceptData);
                break;
            case 'server/shake_start':
                Alpaca.to('#/wapp/index/start', acceptData);
                break;
            case 'server/shake_end':
                Alpaca.to('#/wapp/index/end', acceptData);
                break;
            case 'server/shake_result':
                Alpaca.to('#/wapp/index/result', acceptData);
                break;
            case 10:
                break;
        }

    },

    // index - 登录成功后
    indexAction: function (data) {
        if (data.code == 9900) {
            //获取活动信息
            var request    = {};
            request.action = API['ws_server_shake_activity'];
            request.data   = {
                activity_id: ACTIVITY_ID
            };
            WS.send(JSON.stringify(request));
        }
    },

    // 倒计时开始-开始游戏
    preStartAction: function (data) {
        $(".tips-text").text("摇速！中奖的终极必杀技");
        $(".start-phone").hide();
        $(".count").css("display", "block");
        $(".step3").addClass("on");
        setTimeout(function () {
            $(".tips-text").text("幅度大？！呵呵~频率才是王道！");
            $(".step3").removeClass("on");
            $(".step2").addClass("on");
            setTimeout(function () {
                $(".tips-text").text("拼腕力的时刻到了！");
                $(".step2").removeClass("on");
                $(".step1").addClass("on");
                setTimeout(function () {
                    $(".tips-text").text("开摇吧！企鹅君");
                    $(".step1").removeClass("on");
                    $(".stepgo").addClass("on");
                }, 1000);
            }, 1000);
        }, 1000);
    },

    // 开始游戏
    startAction: function (data) {
        $(".stepgo").removeClass("on");
        $(".shake-box").css("display", "block");
        shake_doing = setInterval(function () {
            $(".shake-phone").addClass("on");
            setTimeout(function () {
                $(".shake-phone").removeClass("on");
            }, 500)
        }, 800);

        var myShakeEvent = new Shake({
            threshold: 10, // optional shake strength threshold
            timeout: 100 // optional, determines the frequency of event generation
        });

        window.addEventListener('shake', shakeEventDidOccur, false);
        myShakeEvent.start();

    },

    //上传摇一摇数据
    upShakeAction: function (data) {
        //获取活动信息
        var request    = {};
        request.action = API['ws_server_shake_up'];
        request.data   = {};
        WS.send(JSON.stringify(request));
    },

    // 结束游戏
    endAction: function (data) {
        if (shake_doing) {
            clearInterval(shake_doing);
        }

        window.removeEventListener('shake', shakeEventDidOccur, false);
        myShakeEvent.stop();

        //获取结果
        var request    = {};
        request.action = API['ws_server_shake_result'];
        request.data   = {
            item_id: ITEM_ID
        };
        WS.send(JSON.stringify(request));
    },

    // 结果页面
    resultAction: function (data) {
        var view = Alpaca.View({data: data.data, to: '#main-content'});
        view.ready(function () {
        });
        return view;
    },

    // 摇一摇页面
    shakeAction: function (data) {
        ITEM_ID  = data.data.item.id;
        var view = Alpaca.View({data: data.data, to: '#main-content'});
        view.ready(function () {
        });
        return view;
    },
};
