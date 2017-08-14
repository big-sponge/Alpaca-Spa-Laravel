/* 1 定义Metro模块中的IndexController ,并且定义两个action方法，test3，test4*/
Alpaca.MainModule.IndexController = {
    //test,  默认渲染到
    testAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },
    //index,  默认渲染到
    indexAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },

    //bar,  默认渲染到
    barAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },

    //btns,  默认渲染到
    btnsAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },

    //form,  默认渲染到
    formAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },

    //searchbar,  默认渲染到
    searchbarAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },

    //list,  默认渲染到
    listAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },

    //tabs,  默认渲染到
    tabsAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },

    //card,  默认渲染到
    cardAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },

    //grid,  默认渲染到
    gridAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },

    //modal,  默认渲染到
    modalAction: function () {
        var view = new Alpaca.MainModule.View();
        view.ready(function () {
            //对话框
            var $content = $('.content');
            $content.on('click', '.alert-text', function () {
                $.alert('这是一段提示消息');
            });
            $content.on('click', '.alert-text-title', function () {
                $.alert('这是一段提示消息', '这是自定义的标题!');
            });
            $content.on('click', '.alert-text-title-callback', function () {
                $.alert('这是自定义的文案', '这是自定义的标题!', function () {
                    $.alert('你点击了确定按钮!')
                });
            });
            $content.on('click', '.confirm-ok', function () {
                $.confirm('你确定吗?', function () {
                    $.alert('你点击了确定按钮!');
                });
            });
            $content.on('click', '.prompt-ok', function () {
                $.prompt('你叫什么问题?', function (value) {
                    $.alert('你输入的名字是"' + value + '"');
                });
            });
        });
        return view;
    },

    //preloader,  默认渲染到
    preloaderAction: function () {
        var view = new Alpaca.MainModule.View();
        view.ready(function () {
            $('.content').on('click', '.open-preloader-title', function () {
                $.showPreloader('加载中...')
                setTimeout(function () {
                    $.hidePreloader();
                }, 2000);
            });
            $('.content').on('click', '.open-indicator', function () {
                $.showIndicator();
                setTimeout(function () {
                    $.hideIndicator();
                }, 2000);
            });
        });
        return view;
    },

    //actions,  默认渲染到
    actionsAction: function () {
        var view = new Alpaca.MainModule.View();
        view.ready(function () {
            //操作表
            $('.content').on('click', '.create-actions', function () {
                var buttons1 = [
                    {
                        text: '请选择',
                        label: true
                    },
                    {
                        text: '卖出',
                        bold: true,
                        color: 'danger',
                        onClick: function () {
                            $.alert("你选择了“卖出“");
                        }
                    },
                    {
                        text: '买入',
                        onClick: function () {
                            $.alert("你选择了“买入“");
                        }
                    }
                ];
                var buttons2 = [
                    {
                        text: '取消',
                        bg: 'danger'
                    }
                ];
                var groups   = [buttons1, buttons2];
                $.actions(groups);
            });
        });
        return view;
    },

    //calendar,  默认渲染到
    calendarAction: function () {
        var view = new Alpaca.MainModule.View();
        view.ready(function () {
            $.init();
        });
        return view;
    },

    //picker,  默认渲染到
    pickerAction: function () {
        var view = new Alpaca.MainModule.View();
        view.ready(function () {
            $("#picker").picker({
                toolbarTemplate: '<header class="bar bar-nav">\
                                        <button class="button button-link pull-left">\
                                        按钮\
                        </button>\
      <button class="button button-link pull-right close-picker">\
      确定\
      </button>\
      <h1 class="title">标题</h1>\
      </header>',
                cols: [
                    {
                        textAlign: 'center',
                        values: ['iPhone 4', 'iPhone 4S', 'iPhone 5', 'iPhone 5S', 'iPhone 6', 'iPhone 6 Plus', 'iPad 2', 'iPad Retina', 'iPad Air', 'iPad mini', 'iPad mini 2', 'iPad mini 3'],
                        cssClass: 'picker-items-col-normal'
                    }
                ]
            });
            $("#picker-name").picker({
                toolbarTemplate: '<header class="bar bar-nav">\
      <button class="button button-link pull-right close-picker">确定</button>\
      <h1 class="title">请选择称呼</h1>\
      </header>',
                cols: [
                    {
                        textAlign: 'center',
                        values: ['赵', '钱', '孙', '李', '周', '吴', '郑', '王']
                    },
                    {
                        textAlign: 'center',
                        values: ['杰伦', '磊', '明', '小鹏', '燕姿', '菲菲', 'Baby']
                    },
                    {
                        textAlign: 'center',
                        values: ['先生', '小姐']
                    }
                ]
            });
            $.init();
        });
        return view;
    },

    //datetime-picker,  默认渲染到
    datetimePickerAction: function () {
        var view = new Alpaca.MainModule.View();
        view.ready(function () {
            $(document).on("pageInit", "#page-datetime-picker", function (e) {
                $("#datetime-picker").datetimePicker({
                    toolbarTemplate: '<header class="bar bar-nav">\
      <button class="button button-link pull-right close-picker">确定</button>\
      <h1 class="title">选择日期和时间</h1>\
      </header>'
                });
            });
            $.init();
        });
        return view;
    },

    //city-picker,  默认渲染到
    cityPickerAction: function () {
        var view = new Alpaca.MainModule.View();
        view.ready(function () {
            $("#city-picker").cityPicker({
                value: ['天津', '河东区']
                //value: ['四川', '内江', '东兴区']
            });
        });
        return view;
    },

    //swiper,  默认渲染到
    swiperAction: function () {
        var view = new Alpaca.MainModule.View();
        view.ready(function () {
            $.init();
        });
        return view;
    },

    //photo-browser,  默认渲染到
    photoBrowserAction: function () {
        var view = new Alpaca.MainModule.View();
        view.ready(function () {
            var myPhotoBrowserStandalone = $.photoBrowser({
                photos: [
                    '//img.alicdn.com/tps/i3/TB1kt4wHVXXXXb_XVXX0HY8HXXX-1024-1024.jpeg',
                    '//img.alicdn.com/tps/i1/TB1SKhUHVXXXXb7XXXX0HY8HXXX-1024-1024.jpeg',
                    '//img.alicdn.com/tps/i4/TB1AdxNHVXXXXasXpXX0HY8HXXX-1024-1024.jpeg',
                ]
            });
            //点击时打开图片浏览器
            $('.content').on('click', '.pb-standalone', function () {
                myPhotoBrowserStandalone.open();
            });
            /*=== Popup ===*/
            var myPhotoBrowserPopup = $.photoBrowser({
                photos: [
                    '//img.alicdn.com/tps/i3/TB1kt4wHVXXXXb_XVXX0HY8HXXX-1024-1024.jpeg',
                    '//img.alicdn.com/tps/i1/TB1SKhUHVXXXXb7XXXX0HY8HXXX-1024-1024.jpeg',
                    '//img.alicdn.com/tps/i4/TB1AdxNHVXXXXasXpXX0HY8HXXX-1024-1024.jpeg',
                ],
                type: 'popup'
            });
            $('.content').on('click', '.pb-popup', function () {
                myPhotoBrowserPopup.open();
            });
            /*=== 有标题 ===*/
            var myPhotoBrowserCaptions = $.photoBrowser({
                photos: [
                    {
                        url: '//img.alicdn.com/tps/i3/TB1kt4wHVXXXXb_XVXX0HY8HXXX-1024-1024.jpeg',
                        caption: 'Caption 1 Text'
                    },
                    {
                        url: '//img.alicdn.com/tps/i1/TB1SKhUHVXXXXb7XXXX0HY8HXXX-1024-1024.jpeg',
                        caption: 'Second Caption Text'
                    },
                    // 这个没有标题
                    {
                        url: '//img.alicdn.com/tps/i4/TB1AdxNHVXXXXasXpXX0HY8HXXX-1024-1024.jpeg',
                    },
                ],
                theme: 'dark',
                type: 'standalone'
            });
            $('.content').on('click', '.pb-standalone-captions', function () {
                myPhotoBrowserCaptions.open();
            });

        });
        return view;
    },

    //pull-to-refresh,  默认渲染到
    pullToRefreshAction: function () {
        var view = new Alpaca.MainModule.View();
        view.ready(function () {
            //下拉刷新页面
            var $content = $(".content").on('refresh', function (e) {
                // 模拟2s的加载过程
                setTimeout(function () {
                    var cardHTML = '<div class="card">' +
                        '<div class="card-header">标题</div>' +
                        '<div class="card-content">' +
                        '<div class="card-content-inner">内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    $content.find('.card-container').prepend(cardHTML);
                    // $(window).scrollTop(0);
                    // 加载完毕需要重置
                    $.pullToRefreshDone($content);
                }, 2000);
            });
            $.init();
        });
        return view;
    },

    //infinite-scroll,  默认渲染到
    infiniteScrollAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },

    //icons,  默认渲染到
    iconsAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },
};