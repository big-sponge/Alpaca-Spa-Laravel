/*
 * 定时任务模块控制器
 * ChengCheng
 * 20170131
 * */

Alpaca.MainModule.CrontabController = {

    //任务列表-获取请求参数
    taskListGetRequest: function () {
        var request = {};
        var num     = $("#page-num").val();
        if (!num) {
            num = 1;
        }
        request.num = num;

        var size = $("#page-size").val();
        if (!size) {
            size = 20;
        }
        request.size = size;


        return request;
    },

    //任务列表
    indexAction: function () {
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {

            //加载任务列表
            var display = function () {
                getDisplayList({
                    getParam: function () {
                        var request = {};
                        request.key = $('#table-page-key').val() ? $('#table-page-key').val() : undefined;
                        return request;
                    },
                    url: API['crontab_list'],
                    callback: function (data) {
                        Alpaca.to('#/main/crontab/taskListDisplay', data);
                    }
                });
            };

            //切换定时任务守护进程状态
            var changeStatus = function (status, message) {
                //判断状态
                if (status == 1000) {
                    //开启状态
                    $('#task-state').removeClass('task-stop');
                    $('#task-state').addClass('task-start');
                    $('#system_switch').html('停止');
                    $('#id_light_tip').html('运行中' + "  【" + message + "】");
                } else {
                    //关闭状态
                    $('#task-state').removeClass('task-start');
                    $('#task-state').addClass('task-stop');
                    $('#system_switch').html('开启');
                    $('#id_light_tip').html('已停止' + "  【" + message + "】");
                }
                $('#task-state-value').val(status);
            };

            //获取定时任务守护进程状态
            var getStatus = function () {
                AlpacaAjax({
                    url: g_url + API['crontab_status'],
                    data: {},
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (data) {
                        if (data.code == "9900") {
                            changeStatus(data.data.code, data.data.message);
                        }
                    },
                });
            };

            //定时任务守护进程开关
            $('#system_switch').click(function () {
                var status = $('#task-state-value').val();

                if (status == 1001) {
                    //开启进程
                    AlpacaAjax({
                        url: g_url + API['crontab_start'],
                        data: {},
                        success: function (data) {
                            if (data.code == "9900") {
                                setTimeout(function () {
                                    getStatus();
                                }, 400);
                            }
                        },
                    });
                } else {
                    //停止进程
                    AlpacaAjax({
                        url: g_url + API['crontab_stop'],
                        data: {},
                        success: function (data) {
                            if (data.code == "9900") {
                                setTimeout(function () {
                                    getStatus();
                                }, 400);
                            }
                        },
                    });
                }

            });

            display();
            getStatus();

        });
        return view;
    },

    //任务列表-调用服务端接口
    taskListGetAction: function () {

        //请求参数
        var request = {};

        AlpacaAjax({
            url: g_url + API['crontab_list'],
            data: request,
            success: function (data) {
                if (data.code == "9900") {
                    g_response.data.size = request.FPageSize;
                    var tempSize         = g_response.data.size;
                    if (g_response.data.size < 1) {
                        g_response.data.size = g_response.data.total;
                    }
                    g_response.data.totalNum = Math.ceil(g_response.data.total / g_response.data.size);
                    g_response.data.num      = request.FPageNum;
                    if (g_response.data.num > g_response.data.totalNum) {
                        g_response.data.num = g_response.data.totalNum;
                    }

                    g_response.data.size = tempSize;
                    Alpaca.forward("#/sche/crontab/taskListDisplay");
                }
            },
            beforeSend: function () {
            },
            complete: function () {
            },
        });
    },

    //任务列表-渲染数据
    taskListDisplayAction: function (data) {

        var view = new Alpaca.View({to: '.page-table-body', data: data});
        view.ready(function () {

            // 表格 - 可以折叠
            $('.table-togglable').footable();

            // 显示分页参数信息，并且关联相关事件
            tablePageDisplay(data);

            //调用服务接口
            var setTaskStatus = function (index, status,dom) {
                AlpacaAjax({
                    url: g_url + API['crontab_change'],
                    data: {INDEX: index, STATUS: status},
                    async: false,
                    success: function (data) {
                        if (data.code == "9900") {
                            if (status == 2) {
                                dom.nextElementSibling.classList.remove("bg_checkbox", "change", "move");
                                $(dom).prev('.task-status').val(2);
                            } else {
                                dom.nextElementSibling.classList.add("bg_checkbox", "change", "move");
                                $(dom).prev('.task-status').val(1);
                            }
                        }
                    },
                });
            };

            //开关
            $(".chooser").change(function () {
                var index  = $(this).parent('td').parent('tr').attr('name');
                var status = $(this).prev('.task-status').val();
                var newStatus = (status==2) ? 1:2;
                setTaskStatus(index, newStatus, this);
            });

            //初始化按钮状态
            $(".task-status").each(function () {
                var status  = $(this).val();
                var chooser = $(this).next('.chooser')[0];
                if (status == 1) {
                    chooser.nextElementSibling.classList.add("bg_checkbox", "change", "move");

                } else {
                    chooser.nextElementSibling.classList.remove("bg_checkbox", "change", "move");
                }
            });

        });
        return view;
    },

    //添加,编辑任务-视图
    editViewAction: function (data) {

        console.log(data);

        var view = new Alpaca.View({to: "#modal_form_vertical", data: data});
        view.ready(function () {
            $('#modal_form_vertical').modal();

            $('.datetime-picker').datetimepicker({
                format: 'yyyy-mm-dd hh:ii:ss',
                orientation: "left",
                language:'zh-CN',
                autoclose: true,
            });

            if(data.INDEX){
                var interval = data.INTERVAL;
                var iType    = '';
                var iNum     = '';
                if (interval != null && interval != "") {
                    var temp     = interval.split(" ");
                    var iNumTemp = temp[0];
                    iType        = temp[1];
                    iNum         = iNumTemp.replace("+", "");
                }
                $('#edit-task-form input[name="task-index"]').val(data.INDEX);
                $('#edit-task-form input[name="task-name"]').val(data.NAME);
                $('#edit-task-form select[name="run-type"]').val(data.TYPE);
                $('#edit-task-form input[name="begin-time"]').val(data.BEGIN_TIME);
                $('#edit-task-form input[name="end-time"]').val(data.END_TIME);
                $('#edit-task-form select[name="task-status"]').val(data.STATUS);
                $('#edit-task-form input[name="task-action"]').val(data.ACTION);
                $('#edit-task-form input[name="task-time"]').val(iNum);
                $('#edit-task-form select[name="task-time-unit"]').val(iType);
            }else{
                $('#edit-task-form-id').hide();
            }

        });
        return view;
    },

    //删除任务 - 后台接口
    removeTaskAction: function (data) {
        if (!data.id) {
            return ;
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
                        url: g_url + API['crontab_remove'],
                        data: {INDEX: data.id},
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
                                    Alpaca.to("#/main/crontab/index");
                                });
                            } else {
                                swal({
                                    title: "删除失败",
                                    text: data.msg,
                                    confirmButtonColor: "#2196F3",
                                    type: "error",
                                    closeOnConfirm: true
                                });
                            }
                        },
                    });
                }
            });
    },
};

