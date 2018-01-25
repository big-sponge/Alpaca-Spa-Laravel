var enum_member_type = function (value) {
    if (value == '1') {
        return "用户";
    }
    if (value == '2') {
        return "管理员";
    }
};


/* 1 PhotoStoreController */
Alpaca.MainModule.PhotoController = {
    //list, 列表 - 视图
    storeListViewAction: function () {
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {
            var display = function (param) {
                getDisplayList({
                    place: "#photoStore-list-view",
                    param: param,
                    url: API['photoStore_list'],
                    callback: function (data) {
                        Alpaca.to('#/main/photo/storeListDisplay', data);
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
    storeListDisplayAction: function (data) {
        var view = new Alpaca.View({to: '.page-table-body', data: data});
        view.ready(function () {

            // 表格 - 可以折叠
            $('.table-togglable').footable();

            // 显示分页参数信息，并且关联相关事件
            tablePageDisplay(data);

            if (!jQuery.fancybox) {
                return;
            }

            if ($(".fancybox-button").size() > 0) {
                $(".fancybox-button").fancybox({
                    groupAttr: 'data-rel',
                    prevEffect: 'none',
                    nextEffect: 'none',
                    closeBtn: true,
                    helpers: {
                        title: {
                            type: 'inside'
                        }
                    }
                });
            }

        });
        return view;
    },

    //edit,,编辑
    storeEditViewAction: function (data) {
        var id = Alpaca.Router.getParams(0);
        if (id) {
            data.id = id;
        }
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {
            //获取用户信息，如果指定了id，
            if (data.id) {
                AlpacaAjax({
                    url: g_url + API['photoStore_list'],
                    data: {id: data.id, pageNum: 1, pageSize: 1},
                    async: false,
                    success: function (data) {
                        if (data.code == 9900 && data.data.list.length > 0) {
                            fillPhotoStore(data.data.list[0]);
                        }
                    },
                });
            } else {
                $('#photoStore-edit input[name ="id"]').parent('.form-group').hide();
            }
        });
        return view;
    },

    //add, 上传图片
    storeAddViewAction: function () {
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {

        });
        return view;
    },
};