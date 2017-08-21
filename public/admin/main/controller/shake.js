
var enum_type = function(value){
    if(value == '1'){
        return "微摇奖";
    }
    if(value == '2'){
        return "微夺宝";
    }
};

/* 1 ShakeActivityController */
Alpaca.MainModule.ShakeController = {
    //list, 列表 - 视图
    shakeActivityListViewAction: function () {
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {
            var display = function (param) {
                getDisplayList({
                    place:"#shakeActivity-list-view",
                    param: param,
                    url: API['shakeActivity_list'],
                    callback: function (data) {
                        Alpaca.to('#/main/shake/shakeActivityListDisplay', data);
                    }
            });
        };

        $('#table-page-search').click(function () {
            display();
        });

        display();
        });
        return view;
    },

    //display, 列表 - 视图 - 显示表格
    shakeActivityListDisplayAction: function (data) {
        var view = new Alpaca.View({to: '.page-table-body', data: data});
        view.ready(function () {

        // 表格 - 可以折叠
        $('.table-togglable').footable();

        // 显示分页参数信息，并且关联相关事件
        tablePageDisplay(data);

        });
        return view;
    },

    //edit, 添加,编辑
    shakeActivityEditViewAction: function (data) {
        var id = Alpaca.Router.getParams(0);
        if (id) {
            data.id = id;
        }
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {
            //获取用户信息，如果指定了id，
            if (data.id) {
                AlpacaAjax({
                    url: g_url + API['shakeActivity_list'],
                    data: {id: data.id, pageNum: 1, pageSize: 1},
                    async: false,
                    success: function (data) {
                        if (data.code == 9900 && data.data.list.length > 0) {
                            fillShakeActivity(data.data.list[0]);
                        }
                    },
                });
            } else {
                $('#shakeActivity-edit input[name ="id"]').parent('.form-group').hide();
            }
        });
        return view;
    },
};