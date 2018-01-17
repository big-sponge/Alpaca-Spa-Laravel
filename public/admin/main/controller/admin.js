var com_data={};

/* 1 定义AdminController，用户管理（后台用户） */
Alpaca.MainModule.AdminController = {

    //member-list, 管理员列表 - 视图
    memberListViewAction: function () {
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {
            var display = function (param) {
                getDisplayList({
                    place:"#member-list-view",
                    param: param,
                    url: API['admin_member_list'],
                    callback: function (data) {
                        Alpaca.to('#/main/admin/memberListDisplay', data);
                    }
                });
            };

            $('#table-page-search').click(function () {
                var request = {};
                request.key = $('#table-page-key').val() ? $('#table-page-key').val() : undefined;
                display(request);
            });

            display();
        });
        return view;
    },

    //member-list, 管理员列表 - 视图 - 显示表格
    memberListDisplayAction: function (data) {
        var view = new Alpaca.View({to: '.page-table-body', data: data});
        view.ready(function () {

            //查找条件
            if (data.request.key) {
                $('#table-page-key').val(data.request.key);
            }

            // 表格 - 可以折叠
            $('.table-togglable').footable();

            // 显示分页参数信息，并且关联相关事件
            tablePageDisplay(data);

        });
        return view;
    },

    //member-edit, 添加,编辑用户
    memberEditViewAction: function (data) {

        var id = Alpaca.Router.getParams(0);
        if (id) {
            data.id = id;
        }

        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {
            var group  = {};
            var member = {};

            //获取所有分组
            AlpacaAjax({
                url: g_url + API['admin_group_list'],
                data: {pageNum: 1, pageSize: 0},
                async: false,
                success: function (data) {
                    group = data.data.list;
                },
            });

            //获取用户信息，如果指定了id，
            if (data.id) {
                AlpacaAjax({
                    url: g_url + API['admin_member_list'],
                    data: {id: data.id, pageNum: 1, pageSize: 1},
                    async: false,
                    success: function (data) {
                        if (data.code == 9900 && data.data.list.length > 0) {
                            member = data.data.list[0];
                            $('#member-edit input[name ="id"]').val(member.id);
                            $('#member-edit input[name ="name"]').val(member.name);
                            $('#member-edit input[name ="email"]').val(member.email);
                            $('#member-edit input[name ="mobile"]').val(member.mobile);
                            for (var index in group) {
                                var is_check = false;
                                for (var i in member.group) {
                                    if (member.group[i]['id'] == group[index]['id']) {
                                        is_check = true;
                                        break;
                                    }
                                }
                                if (is_check) {
                                    $('#member-edit [name ="group"]').append('<option selected="selected" value=' + group[index]["id"] + '>' + group[index]["name"] + '</option>');
                                } else {
                                    $('#member-edit [name ="group"]').append('<option value=' + group[index]["id"] + '>' + group[index]["name"] + '</option>');
                                }
                            }
                        }
                    },
                });
            } else {
                $('#member-edit input[name ="id"]').parent('.form-group').hide();
                for (var index in group) {
                    $('#member-edit [name ="group"]').append('<option value=' + group[index]["id"] + '>' + group[index]["name"] + '</option>');
                }
            }

            // 格式化 选择分组控件
            $('.select').select2({
                minimumResultsForSearch: Infinity
            });


        });
        return view;
    },

    //admin-delete, 删除用户
    memberDeleteAction: function (data) {

        var id = Alpaca.Router.getParams(0);
        if (id) {
            data.id = id;
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
                        url: g_url + API['admin_member_delete'],
                        data: {id: data.id},
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
                                    Alpaca.to("#/main/admin/memberListView");
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

    //group-list, 管理员列表 - 视图
    groupListViewAction: function () {
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {
            var display = function (param) {
                getDisplayList({
                    place:"#group-list-view",
                    param: param,
                    url: API['admin_group_list'],
                    callback: function (data) {
                        Alpaca.to('#/main/admin/groupListDisplay', data);
                    }
                });
            };

            $('#table-page-search').click(function () {
                var request = {};
                request.key = $('#table-page-key').val() ? $('#table-page-key').val() : undefined;
                display(request);
            });

            display();
        });
        return view;
    },

    //group-list, 管理员列表 - 视图 - 显示表格
    groupListDisplayAction: function (data) {
        var view = new Alpaca.View({to: '.page-table-body', data: data});
        view.ready(function () {

            // 表格 - 可以折叠
            $('.table-togglable').footable();

            // 显示分页参数信息，并且关联相关事件
            tablePageDisplay(data);

        });
        return view;
    },

    //group-add, 添加用户分组
    groupEditViewAction: function (data) {

        //获取id
        var id  = Alpaca.Router.getParams(0);
        data.id = id ? id : data.id;

        //创建视图
        var view = new Alpaca.MainModule.pageView();
        view.ready(function () {
            var auths     = {};
            var group     = {};
            var selectIds = [];
            //获取用户信息，如果指定了id，
            if (data.id) {
                AlpacaAjax({
                    url: g_url + API['admin_group_list'],
                    data: {id: data.id, pageNum: 1, pageSize: 1},
                    async: false,
                    success: function (data) {
                        if (data.code == 9900 && data.data.list.length > 0) {
                            group = data.data.list[0];
                            if (group.auth) {
                                for (var i in group.auth) {
                                    selectIds.push(group.auth[i].id);
                                }
                            }
                            $('#group-edit input[name ="id"]').val(group.id);
                            $('#group-edit input[name ="name"]').val(group.name);
                            $('#group-edit input[name ="desc"]').val(group.desc);
                        }
                    },
                });
            } else {
                $('#group-edit input[name ="id"]').parent('.form-group').hide();
            }

            //获取所有权限
            AlpacaAjax({
                url: g_url + API['admin_auth_list'],
                data: {pageNum: 1, pageSize: 0},
                async: false,
                success: function (data) {
                    auths         = data.data.list;
                    var authsList = [];
                    //获取一级
                    for (var i in auths) {
                        if (auths[i].type == 1) {
                            var temp      = auths[i];
                            temp.title    = temp.name;
                            temp.children = [];
                            temp.key      = temp.id;
                            temp.folder   = true;
                            authsList.push(temp);
                        }
                    }
                    //获取二级
                    for (var j in auths) {
                        if (auths[j].type == 2) {
                            if (selectIds && selectIds.indexOf(auths[j].id) != -1) {
                                auths[j].selected = "selected";
                            }
                            auths[j].title = auths[j].name;
                            auths[j].key   = auths[j].id;
                            for (var k in authsList) {
                                if (authsList[k].id == auths[j].parent_id) {
                                    authsList[k]['children'].push(auths[j]);
                                    if (auths[j].selected == "selected") {
                                        authsList[k].expanded = true;
                                    }
                                    break;
                                }
                            }
                        }
                    }

                    $(".tree-checkbox-hierarchical").fancytree({
                        source: [{
                            title: "全部权限",
                            key: "-1",
                            folder: true,
                            expanded: true,
                            children: authsList
                        }],
                        checkbox: true,
                        selectMode: 3
                    });
                },
            });
        });
        return view;
    },

    //group-delete, 添加,编辑用户
    groupDeleteAction: function (data) {

        var id = Alpaca.Router.getParams(0);
        if (id) {
            data.id = id;
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
                        url: g_url + API['admin_group_delete'],
                        data: {id: data.id},
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
                                    Alpaca.to("#/main/admin/groupListView");
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