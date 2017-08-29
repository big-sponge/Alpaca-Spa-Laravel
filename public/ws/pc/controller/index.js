Alpaca.ScreenModule.IndexController = {

    // 登录
    loginAction: function () {
        //基础逻辑
        initBase();

        //拉去后台数据 - 获取活动详情
        AlpacaAjax({
            url: G_URL + API['admin_shake_token'],
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
                        request.action = API['ws_admin_login'];
                        request.data   = {
                            token: data.data
                        };
                        console.log(request);
                        WS.send(JSON.stringify(request));
                    };

                    WS.onmessage = function (event) {
                        Alpaca.to('#/screen/index/router', event);
                    }
                }
            },
        });
    },

    // 处理 ws 路由
    routerAction: function (event) {
        var acceptData = JSON.parse(event.data);
        console.log(acceptData);
        var action = acceptData.action;
        switch (action) {
            case 'admin/login':
                Alpaca.to('#/screen/index/index', acceptData);
                break;
            case 'admin/shake_activity':
                Alpaca.to('#/screen/index/activityBack', acceptData);
                break;
            case 'admin/shake_pre_start':
                Alpaca.to('#/screen/index/preStart', acceptData);
                break;
            case 'admin/shake_start':
                Alpaca.to('#/screen/index/start', acceptData);
                break;
            case 'admin/shake_end':
                Alpaca.to('#/screen/index/page4', acceptData);
                break;
            case 'admin/user_join':
                Alpaca.to('#/screen/index/playerJoin', acceptData);
                break;
            case 'admin/user_shake_up':
                Alpaca.to('#/screen/index/shakeUp', acceptData);
                break;
            case 'admin/shake_users':
                Alpaca.to('#/screen/index/shakeUsers', acceptData);
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
            request.action = API['ws_admin_shake_activity'];
            request.data   = {
                activity_id: ACTIVITY_ID
            };
            WS.send(JSON.stringify(request));
        }
    },

    // activity - 获取信息成功
    activityBackAction: function (data) {
        if (data.code == 9900) {

            ITEM_ID    = data.data.item.id;
            ITEM_COUNT = data.data.item.shake_limit;
            if (data.data.item.status == 1) {
                Alpaca.to('#/screen/index/page1', data.data);
            }

            //进行中
            if (data.data.item.status == 2) {
                Alpaca.to('#/screen/index/page3', data.data);
            }
        }
    },

    // 倒计时开始-开始游戏
    preStartAction: function (data) {
        Alpaca.to('#/screen/index/page2', data);
    },

    // 开始游戏
    startAction: function (data) {
        Alpaca.to('#/screen/index/page3', data);
    },

    // 下一轮游戏
    nextAction: function (data) {
        var request    = {};
        request.action = API['ws_admin_shake_activity'];
        request.data   = {
            activity_id: ACTIVITY_ID
        };
        WS.send(JSON.stringify(request));
    },

    // 有玩家加入游戏
    playerJoinAction: function (data) {
        var user     = data.data.member;
        var isRepeat = false;
        $('.page1 .user-list .item').each(function () {
            if ($(this).attr('class') == 'item user-' + user.id) {
                isRepeat = true;
            }

        });
        if (isRepeat == false) {
            var html = '<li class="item user-' + user.id + '"><img width="135" height="135" src="' + user.avatar + '" /></li>';
            $('.page1 .user-list').prepend(html);
            $('.page1 .user-list .item:last').remove();
            var num = $('.page1 .con-left .num').text();
            $('.page1 .con-left .num').text(parseInt(num) + 1);
        }
    },

    // 游戏实时数据
    shakeUpAction: function (data) {

        var userList  = data.data;
        var html      = '';
        var widthRate = 0;
        var num       = ITEM_COUNT;
        for (var i = 0; i < userList.length; i++) {

            if (i >= 5) {
                break;
            }

            widthRate = (userList[i].shake_count / num) * 100;

            html += '<li class="item">';
            html += '<a class="rank front">' + (i + 1) + '</a>';
            html += '<div class="img">';
            html += '<img src="' + userList[i].avatar + '" width="100" height="100"/>';
            html += '</div>';
            html += '<div class="con-right">';
            html += '<p class="username">' + userList[i].name + '</p>';
            html += '<div class="line">';
            html += '<div class="line-ass" style="width: ' + widthRate + '%;">';
            html += '<p class="widthP"><span class="num">' + userList[i].shake_count + '</span>次</p>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="clear"></div>';
            html += '</li>';
        }
        $('.page3 .content-ul').html(html);

    },

    // 游戏结果
    gameResultAction: function (data) {

    },

    //填充在线人员
    shakeUsersAction: function (data) {
        for (var i in data.data.list) {
            var member    = {};
            member.id     = data.data.list[i].id;
            member.avatar = data.data.list[i].avatar;
            var param     = {
                data: {
                    member: member
                }
            };
            Alpaca.to("#/screen/index/playerJoin", param);
        }
    },

    // 扫码页面   - page1
    page1Action: function (data) {
        var view = Alpaca.View({data: data});
        view.ready(function () {

            //次数限制
            $("#01middle").text(data.item.shake_limit);
            $("#01right").click(function () {
                //获取到的节点的值转为int型；
                var num = parseInt($("#01middle").text());
                //如果小于100   则改变节点的值
                if (num < 100) {
                    $("#01middle").text(num + 10);
                }

            });
            $("#01left").click(function () {
                var num = parseInt($("#01middle").text());
                if (num > 10) {
                    $("#01middle").text(num - 10);
                }
            });

            //中奖人数
            $("#02middle").text(data.item.win_limit);
            $("#02left").click(function () {
                var num = parseInt($("#02middle").text());
                if (num > 1) {
                    $("#02middle").text(num - 1);
                    $(".page1 .winnum").text($("#02middle").text());
                }
            });
            $("#02right").click(function () {
                var num = parseInt($("#02middle").text());
                if (num < 10) {
                    $("#02middle").text(num + 1);
                    $(".page1 .winnum").text($("#02middle").text());
                }
            });
            $(".page1 .winnum").text($("#02middle").text());

            //点击开始按钮 - 倒计时开始 - 发送web-socket 通知服务端开始游戏倒计时
            $(".page1 .button").click(function () {

                //参数
                var request    = {};
                request.action = API['ws_admin_shake_pre_start'];
                request.data   = {
                    itemId: ITEM_ID,
                    shakeLimit: $('#01middle').text(),
                    winLimit: $('#02middle').text()
                };

                ITEM_COUNT =  $('#01middle').text();

                //发送
                WS.send(JSON.stringify(request));

            });

            var request    = {}
            request.action = API['ws_admin_shake_users'];
            request.data   = {
                item_id: ITEM_ID
            };
            WS.send(JSON.stringify(request));

        });
        return view;
    },

    // 倒计时页面 - page2
    page2Action: function (data) {
        var view = Alpaca.View({data: data});
        view.ready(function () {
            var tipsList  = ["开摇吧！企鹅君", "拼腕力的时刻到了！", "幅度大？！呵呵~频率才是王道！", "摇速！中奖的终极必杀技"];
            //初始化倒计时
            var timeCount = 3;
            $(".page2 .counttime").text(timeCount);
            $(".page2 .tips").text(tipsList[timeCount]);

            var sint = setInterval(function () {
                timeCount -= 1;
                if (timeCount >= 0) {
                    if (timeCount == 0) {
                        $(".page2 .counttime").text("GO");
                    } else {
                        $(".page2 .counttime").text(timeCount);
                    }

                    $(".page2 .tips").text(tipsList[timeCount]);
                } else {
                    window.clearInterval(sint);

                    //开始游戏
                    var request    = {};
                    request.action = API['ws_admin_shake_start'];
                    request.data   = {
                        itemId: ITEM_ID,
                    };

                    //发送
                    WS.send(JSON.stringify(request));
                }

            }, 1000);
        });
        return view;
    },

    // 游戏中页面 - page3
    page3Action: function (data) {
        var view = Alpaca.View({data: data});
        view.ready(function () {
        });
        return view;
    },

    // 结果页面   - page4
    page4Action: function (data) {
        var view = Alpaca.View({data: data});
        view.ready(function () {
            var userList = data.data;

            var htmlFirst1 = '';
            var htmlFirst2 = '<li></li>';
            var htmlFirst3 = '';
            var htmlTwo    = '';
            var htmlThree  = '';
            for (var i = 0; i < userList.length; i++) {

                if (i >= 10) {
                    break
                }

                //第一
                if (i == 0) {
                    htmlFirst1 = '<li>';
                    htmlFirst1 += '<div class="bgimg01"></div>';
                    htmlFirst1 += '<div class="img"><img src="' + userList[i].avatar + '" width="100%" height="100%"/></div>';
                    if (userList[i].ticket_status != 0) {
                        htmlFirst1 += '<div class="award show"></div>';
                    }
                    htmlFirst1 += '<p class="username">' + userList[i].name + '</p>';
                    htmlFirst1 += '</li>';
                }
                //第二
                if (i == 1) {
                    htmlFirst2 = '<li>';
                    htmlFirst2 += '<div class="bgimg02"></div>';
                    htmlFirst2 += '<div class="img"><img src="' + userList[i].avatar + '" width="100%" height="100%"/></div>';
                    if (userList[i].ticket_status != 0) {
                        htmlFirst2 += '<div class="award show"></div>';
                    }
                    htmlFirst2 += '<p class="username">' + userList[i].name + '</p>';
                    htmlFirst2 += '</li>';
                }
                //第三
                if (i == 2) {
                    htmlFirst3 = '<li>';
                    htmlFirst3 += '<div class="bgimg03"></div>';
                    htmlFirst3 += '<div class="img"><img src="' + userList[i].avatar + '" width="100%" height="100%"/></div>';
                    if (userList[i].ticket_status != 0) {
                        htmlFirst3 += '<div class="award show"></div>';
                    }
                    htmlFirst3 += '<p class="username">' + userList[i].name + '</p>';
                    htmlFirst3 += '</li>';
                }
                //四 五 六
                if (i > 2 && i < 6) {
                    htmlTwo += '<li>';
                    htmlTwo += '<div class="img"><img src="' + userList[i].avatar + '" width="100%" height="100%" /></div>';
                    htmlTwo += '<div class="ranking">' + (i + 1) + '</div>';
                    if (userList[i].ticket_status != 0) {
                        htmlTwo += '<div class="award new_award show"></div>';
                    }
                    htmlTwo += '<p class="username">' + userList[i].name + '</p>';
                    htmlTwo += '</li>';
                }

                //七 八 九 十
                if (i >= 6) {
                    htmlThree += '<li>';
                    htmlThree += '<div class="img"><img src="' + userList[i].avatar + '" width="100%" height="100%" /></div>';
                    htmlThree += '<div class="ranking">' + (i + 1) + '</div>';
                    if (userList[i].ticket_status != 0) {
                        htmlThree += '<div class="award new_award show"></div>';
                    }
                    htmlThree += '<p class="username">' + userList[i].name + '</p>';
                    htmlThree += '</li>';
                }

            }
            $('.page4 .first .first-ul').html(htmlFirst2 + htmlFirst1 + htmlFirst3);
            $('.page4 .two .two-ul').html(htmlTwo);
            $('.page4 .three .three-ul').html(htmlThree);


            //开始按钮
            $(".page4 .button .btn1").click(function () {
                var request    = {};
                request.action = API['ws_admin_shake_activity'];
                request.data   = {
                    activity_id: ACTIVITY_ID
                };
                WS.send(JSON.stringify(request));
            });

            //结束按钮
            $(".page4 .button .btn2").click(function () {
                openPop('结束按钮');
            });
        });
        return view;
    },
};
