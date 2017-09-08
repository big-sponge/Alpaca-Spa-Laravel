/* 1 定义Metro模块中的WsController*/
Alpaca.MainModule.WsController = {

    //webServer配置
    webServer: {
        ws: null,                                               //* web-socket 连接对象 */
        url: "ws://full.tkc8.com:8082",          //* web-socket 地址 */
    },

    //onlineList 在线人员数据
    onlineList: {},

    //index-动作
    indexAction: function () {
        var view = new Alpaca.MainModule.pageView();

        view.Layout.ready(function () {
            $('body').addClass('has-detached-right');
        });

        view.ready(function () {

            if (Alpaca.MainModule.WsController.webServer.ws) {
                var onlineList = Alpaca.MainModule.WsController.onlineList;
                for (var i in onlineList) {
                    Alpaca.to('#/main/ws/addOnline', onlineList[i]);
                }
                return;
            }
            AlpacaAjax({
                url: g_url + API['admin_shake_token'],
                data: {},
                success: function (data) {
                    if (data.code != 9900) {
                        return;
                    }

                    //请求正确,开启webSocket
                    var ws_url = Alpaca.MainModule.WsController.webServer.url;
                    var ws     = new WebSocket(ws_url);

                    //onOpen
                    ws.onopen = function () {
                        // 连接成功,登录webSocket
                        var request    = {};
                        request.action = API['ws_chat_admin_login'];
                        request.data   = {token: data.data};
                        ws.send(JSON.stringify(request));
                    };

                    //onMessage
                    ws.onmessage = function (event) {
                        Alpaca.to('#/main/ws/router', event);
                    };

                    //设置ws
                    Alpaca.MainModule.WsController.webServer.ws = ws;
                },
            });

        });
        return view;
    },

    // 处理 ws 路由
    routerAction: function (event) {
        var acceptData = JSON.parse(event.data);
        console.log(acceptData);
        var action = acceptData.action;
        switch (action) {
            case 'chat/adminLogin':
                Alpaca.to('#/main/ws/loginBack', acceptData);
                break;
            case 'chat/notifyOnline':
                Alpaca.to('#/main/ws/notifyOnline', acceptData);
                break;
            case 'chat/notifyOffline':
                Alpaca.to('#/main/ws/notifyOffline', acceptData);
                break;
            case 'chat/online':
                Alpaca.to('#/main/ws/onlineBack', acceptData);
                break;
            case 'chat/notifyMsg':
                Alpaca.to('#/main/ws/notifyMsg', acceptData);
                break;
        }
    },

    // 用户上线
    loginBackAction: function (data) {

        if (data.code != 9900) {
            return;
        }

        //获取在线人员
        var ws         = Alpaca.MainModule.WsController.webServer.ws;
        var request    = {};
        request.action = API['ws_chat_online'];
        request.data   = {msg: data.msg};
        ws.send(JSON.stringify(request));
    },

    // 在线用户
    onlineBackAction: function (data) {

        for (var i in data.data) {
            var uid = data.data[i].type + '_' + data.data[i].id;
            if (Alpaca.MainModule.WsController.onlineList[uid]) {
                continue;
            }
            Alpaca.MainModule.WsController.onlineList[uid] = data.data[i];
            Alpaca.to('#/main/ws/addOnline', data.data[i]);
        }
    },

    // 用户上线
    notifyOnlineAction: function (data) {
        var uid = data.data.member.type + '_' + data.data.member.id;
        if (Alpaca.MainModule.WsController.onlineList[uid]) {
            return;
        }
        Alpaca.MainModule.WsController.onlineList[uid] = data.data.member;
        Alpaca.to('#/main/ws/addOnline', data.data.member);
    },

    // 用户下线
    notifyOfflineAction: function (data) {
        var uid = data.data.member.type + '_' + data.data.member.id;
        delete Alpaca.MainModule.WsController.onlineList[uid];
        var itemClass = ".user-list-item-" + uid;
        $(itemClass).remove();
    },

    // 收到消息
    notifyMsgAction: function (data) {
        Alpaca.to('#/main/ws/addChat', data.data);
    },

    // 发送消息
    sendAction: function (data) {
        var ws         = Alpaca.MainModule.WsController.webServer.ws;
        var request    = {};
        request.action = API['ws_chat_send'];
        request.data   = {msg: data.msg};
        ws.send(JSON.stringify(request));
    },

    // 收到消息
    addOnlineAction: function (data) {

        if (!data.avatar) {
            data.avatar = g_baseUrl + 'main/assets/images/placeholder.jpg"';
        }

        var view  = Alpaca.View({data: data, to: "#online-user-list"});
        view.show = function (to, html) {
            var that = this;
            $(to).append(html);
            that.onLoad();
        };
        view.display();
    },

    // 收到消息
    addChatAction: function (data) {
        if (!data.member.avatar) {
            data.member.avatar = g_baseUrl + 'main/assets/images/placeholder.jpg"';
        }
        var view  = Alpaca.View({data: data, to: "#ws-chat-list"});
        view.show = function (to, html) {
            var that = this;
            $(to).append(html);
            that.onLoad();
        };
        view.display();
    },

};