//设置全局资源地址
var g_interval = {};

//后台接口列表
var API = {

    //登录、注册权限相关
    admin_auth_info: '/manage/auth/info',                  //用户信息
    admin_auth_get_token: '/manage/auth/GetToken',         //获取token
    admin_auth_login: '/manage/auth/loginByEmail',         //登录-邮箱密码
    admin_auth_login_token: '/manage/auth/loginByToken',   //登录-token
    admin_auth_logout: '/manage/auth/logout',              //注销
    admin_auth_pwd: '/manage/auth/resetPwdByOld',          //重置密码

    //管用员用户（后台）
    admin_member_list: '/manage/admin/getMemberList',        //用户信息
    admin_member_edit: '/manage/admin/editMember',           //编辑
    admin_member_delete: '/manage/admin/deleteMember',       //删除
    admin_group_list: '/manage/admin/getGroupList',          //分组列表
    admin_group_edit: '/manage/admin/editGroup',             //添加分组
    admin_group_delete: '/manage/admin/deleteGroup',         //删除
    admin_auth_list: '/manage/admin/getAuthList',            //获取权限列表

    //管用员用户（前台）
    user_member_list: '/home/user/getUserList',             //用户信息
    user_member_edit: '/home/user/editUser',                //编辑
    user_member_delete: '/home/user/deleteUser',            //删除

    // 定时任务
    crontab_list: '/manage/crontab/listTask',            // 获取定时任务列表
    crontab_start: '/manage/crontab/start',              // 开启定时任务进程
    crontab_stop: '/manage/crontab/stop',                // 停止定时任务进程
    crontab_status: '/manage/crontab/status',            // 获取状态
    crontab_change: '/manage/crontab/changeTaskStatus',  // 改变任务状态
    crontab_info: '/manage/crontab/getIndexTask',        // 获取单条任务信息
    crontab_remove: '/manage/crontab/removeTask',        // 删除任务
    crontab_edit: '/manage/crontab/editTask',            // 编辑任务

    // web-socket
    admin_shake_token: '/manage/shake/getWsToken',            //* 获取token接口 */
    ws_chat_admin_login: 'chat/adminLogin',                   //* WS 管理员账号登录（后台帐号） */
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

    var notice = new PNotify(setting);
    notice.get().click(function () {
        notice.remove();
    });
};

//封装Ajax
AlpacaAjax = function (param) {

    var success = function (data) {
        //没有登录
        if (data.code == "112") {
            setTimeout(function () {
                Alpaca.to("#/main/auth/loginView");
            }, 200);
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

            if (param['loadingTo'] && param['loadingTo'] === false) {
                return;
            }

            var block = $('body');
            if (param['loadingTo']) {
                block = $(param['loadingTo']);
            }
            $(block).block({
                message: '<i class="icon-spinner4 spinner"></i><span style="vertical-align:middle"> 正在加载，请稍后......</span>',
                overlayCSS: {
                    backgroundColor: '#666',
                    opacity: 0.8,
                    cursor: 'wait',
                    'z-index': 3000,
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent',
                    'z-index': 3000,
                }
            });
        },
        success: function (data) {
            for (var index in successFunc) {
                if (successFunc[index](data) === false) {
                    break;
                }
            }
        },
        complete: function () {

            if (param['loadingTo'] && param['loadingTo'] === false) {
                return;
            }

            setTimeout(function () {
                if (param['loadingTo']) {
                    $(param['loadingTo']).unblock();
                } else {
                    $('body').unblock();
                }
            }, 1);
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

//hash改变时事件
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
        Alpaca.ViewModel.DefaultLayoutCaptureTo = "body";
        Alpaca.ViewModel.DefaultViewCaptureTo   = "body";
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
        var userInfo = Alpaca.MainModule.getUserInfo();

        //页头区域
        var header = new Alpaca.Part({name: "pageHeader", to: "#ap-page-header"});
        header.setData(userInfo);

        //边栏
        var sidebar = new Alpaca.Part({name: "pageSidebar", to: "#ap-page-sidebar"});
        sidebar.ready(function () {

            //1 菜单中的a标签,绑定alpaca-router
            $('.navigation a').click(function () {
                var href = $(this).attr('href');
                if (href && href.indexOf('#/') >= 0 && !$(this).hasClass('ignore-alpaca-router')) {
                    Alpaca.to(href);
                    return false;
                }
            });

            //2 设置选中菜单
            var mName = Alpaca.Router.Module;
            var cName = Alpaca.Router.Controller;
            var aName = Alpaca.Router.Action;
            $('.navigation a').each(function () {
                var href = $(this).attr('href');
                if (href && href.indexOf('#/' + mName + '/' + cName + '/' + aName) >= 0) {
                    $(this).parent('li').addClass("active");
                }
            });
            $('.' + mName + '-' + cName + '-' + aName).addClass("active");


            //3 获取用户权限
            var userInfo = Alpaca.MainModule.getUserInfo();

            //4 设置显示菜单
            if (!userInfo || !userInfo['member'] || !userInfo['member']['group']) {
                return;
            }
            var groups = userInfo['member']['group'];
            for (var i in groups) {
                if (groups[i]['id'] == 1) {
                    return;
                }
            }
            if (userInfo['member']['id'] == 1) {
                return;
            }


            //根据权限 - 隐藏，显示菜单
            var auth = userInfo['member']['auth'];

            // 活动管理-活动列表
            if (!auth[24]) {
                $('.power-menu-24').addClass("hidden");
            }


            // 控制 父级菜单以及菜单标题 显示状态
            $('.navigation-header').each(function () {
                var pheader = this;
                $(pheader).addClass("hidden");
                $(pheader).next().addClass("hidden");
                var s = $(this).next().find('a');
                s.each(function () {
                    if ($(this).attr('href') && !$(this).hasClass('hidden')) {
                        $(pheader).removeClass("hidden");
                        $(pheader).next().removeClass("hidden");
                        return false;
                    }
                });
            });
        });

        //布局
        var layout = new Alpaca.Layout({name: "pageLayout", to: "body"});
        layout.addChild(header);
        layout.addChild(sidebar);
        layout.ready(function () {
            $("title").html('后台管理DEMO');
            $('body').removeAttr('class');
            $('body').removeAttr('style');
            LayoutInit();
        });

        //页脚
        var footer = Alpaca.MainModule.pageFooter();

        //主视图
        var view = new Alpaca.View(data);
        view.setCaptureTo("#page-content");
        view.addChild(footer);
        view.setLayout(layout);
        view.ready(function () {
            $('.page-title .position-left').click(function () {
                history.go(-1);
            });
        });
        view.show = function (to, html) {
            var that = this;
            $(to).html(html);
            $(to).fadeIn("fast", function () {
                that.onLoad();
            });
        };
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

//获取后台数据-ajax请求
var getDisplayList = function (setting) {

    var place    = setting.place;
    var param    = setting.param ? setting.param : {};
    var url      = setting.url;
    var callback = setting.callback;

    //var cache_data = AlpacaCache.get(url);
    //cache_data     = cache_data ? cache_data : {};

    var request = {};
    if (JSON.stringify(param) == '{}') {
        //request = cache_data;
    }
    request.pageNum  = request.pageNum ? request.pageNum : 1;
    request.pageSize = request.pageSize ? request.pageSize : ($(place + ' [name ="table-page-size" ]').val() ? $(place + ' [name ="table-page-size" ]').val() : 10);

    for (var index in param) {
        request[index] = param[index];
    }
    //AlpacaCache.set(url, request, 60);

    AlpacaAjax({
        url: g_url + url,
        data: request,
        success: function (data) {
            if (data.code == 9900) {
                data.data.request           = request;
                data.data.request._param    = param;
                data.data.place             = place;
                data.data.request._callback = function (param, newParam) {
                    for (var index in newParam) {
                        param[index] = newParam[index];
                    }
                    getDisplayList({
                        place: place,
                        param: param,
                        url: url,
                        callback: callback
                    });
                };
                callback(data.data);
            }
        },
    });
};

//表格 - 分页 - 数据渲染
var tablePageDisplay = function (data) {
    /* 计算 size页面大小， totalNum总页数，num当前页码 */
    data.size    = data.request.pageSize;
    var tempSize = data.size;
    if (data.size < 1) {
        data.size = data.total;
    }

    data.totalNum = Math.ceil(data.total / data.size);
    data.num      = data.request.pageNum;

    if (data.totalNum < data.num) {
        data.num = data.totalNum;
    }

    if (!data.num) {
        data.num = 1;
    }

    data.size = tempSize;

    data.from = (data.num - 1) * data.size + 1;
    if (data.from > data.total) {
        data.from = data.total;
    }

    data.to = (data.num ) * data.size;
    if (data.to > data.total) {
        data.to = data.total;
    }


    var place = data.place;

    //设置当前页码
    $(place + ' [name ="table-page-num" ]').val(data.num);

    //设置页面
    $(place + ' [name ="table-page-info" ]').text("显示 " + data.from + " 到 " + data.to + " 共 " + data.total + " 行");

    //设置页面大小
    $(place + ' [name ="table-page-size" ]' + " option[value='" + data.size + "']").attr("selected", true);

    // Set number of visible pages
    $(place + ' .table-pagination').empty();
    $(place + ' .table-pagination').removeData("twbs-pagination");
    $(place + ' .table-pagination').unbind("page");
    if (!data.totalNum) {
        data.totalNum = 1;
    }
    $(place + ' .table-pagination').twbsPagination({
        totalPages: data.totalNum,
        visiblePages: 5,
        startPage: parseInt(data.num),
        prev: '&larr;',
        next: '&rarr;',
        first: '&#8676;',
        last: '&#8677;',
        initiateStartPageClick: false,
        onPageClick: function (event, page) {
            data.request._callback(data.request._param, {pageNum: page, pageSize: $(place + ' [name ="table-page-size" ]').val()});
        }
    });

    $(place + ' [name ="table-page-size" ]').unbind();
    $(place + ' [name ="table-page-size" ]').change(function () {
        data.request._callback(data.request._param, {pageSize: $(place + ' [name ="table-page-size" ]').val(), pageNum: 1});
    });
};