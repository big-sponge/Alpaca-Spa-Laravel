/* 1 定义Metro模块中的IndexController ,并且定义两个action方法，test3，test4*/
Alpaca.MainModule.IndexController = {

    //index,  默认渲染到
    indexAction: function () {
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {

        });
        return view;
    },

    //删除
    deleteAction: function (data) {

        var id       = Alpaca.Router.getParams(0);
        var url      = '';
        var callback = function () {
            location.reload()
        };

        if (data.id) {
            id = data.id;
        }
        if (data.url) {
            url = g_url + data.url;
        }
        if (data.callback) {
            callback = data.callback;
        }

        swal({
                title: "确认删除?",
                text: "删除后数据无法恢复!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#EF5350",
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    AlpacaAjax({
                        url: url,
                        data: {id: id},
                        async: false,
                        success: function (data) {
                            if (data.code == 9900) {
                                swal({
                                    title: "删除成功",
                                    text: "数据已经被删除",
                                    confirmButtonColor: "#66BB6A",
                                    type: "success",
                                    confirmButtonText: "确认",
                                }, function () {
                                    callback();
                                });
                            } else {
                                swal({
                                    title: "删除失败",
                                    text: data.msg,
                                    confirmButtonColor: "#2196F3",
                                    type: "error",
                                    confirmButtonText: "确认",
                                    closeOnConfirm: true
                                });
                            }
                        },
                    });
                }
            });
        return;
    },


    index2Action: function () {
        var view = new Alpaca.MainModule.pageView({data:{name:'cheng'}});
        return view;
    }
};