/*
 * 公用模块控制器，弹出框等
 * ChengCheng
 * 20161226
 * */
Alpaca.MainModule.CommonController = {

    //删除任务 - 调用服务端接口
    deleteViewAction: function (request) {
        var data = request;
        var view = new Alpaca.MainModule.alertView({data:data});
        view.ready(function(){
            $("#page-alert-content").modal("show");
            $("#delete-confirm").click(function(){
                data.callback();
            });
        });
        return view;
    },
};
