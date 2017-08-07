/* 1 <?php echo $this->className; ?>Controller */
Alpaca.MainModule.<?php echo $this->className; ?>Controller = {
    //list, 列表 - 视图
    <?php echo $this->classNameLc; ?>ListViewAction: function () {
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {
            var display = function (param) {
                getDisplayList({
                    place:"#<?php echo $this->classNameLc; ?>-list-view",
                    param: param,
                    url: API['<?php echo $this->classNameLc; ?>_list'],
                    callback: function (data) {
                        Alpaca.to('#/main/<?php echo $this->moduleNameLc; ?>/<?php echo $this->classNameLc; ?>ListDisplay', data);
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
    <?php echo $this->classNameLc; ?>ListDisplayAction: function (data) {
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
    <?php echo $this->classNameLc; ?>EditViewAction: function (data) {
        var id = Alpaca.Router.getParams(0);
        if (id) {
            data.id = id;
        }
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {
            //获取用户信息，如果指定了id，
            if (data.id) {
                AlpacaAjax({
                    url: g_url + API['<?php echo $this->classNameLc; ?>_list'],
                    data: {id: data.id, pageNum: 1, pageSize: 1},
                    async: false,
                    success: function (data) {
                        if (data.code == 9900 && data.data.list.length > 0) {
                            fill<?php echo $this->className; ?>(data.data.list[0]);
                        }
                    },
                });
            } else {
                $('#<?php echo $this->classNameLc; ?>-edit input[name ="id"]').parent('.form-group').hide();
            }
        });
        return view;
    },
};