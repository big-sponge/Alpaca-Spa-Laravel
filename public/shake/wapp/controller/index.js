Alpaca.IndexModule = {
    IndexController: {

        init: function () {
            Alpaca.ViewModel.DefaultLayoutCaptureTo = "#page-current";
            Alpaca.ViewModel.DefaultViewCaptureTo   = "#content";
        },

        onDisplay: function (view) {
            var layout = new ViewLayout();
            view.setLayout(layout);
            view.setCaptureTo("#content");
            console.log(view);
            return view;
        },

        indexAction: function () {
            return undefined;
            var view   = new View();
            view.ready = function () {
                $.init();
            };
            return view;
        },
        pullAction: function () {
            var view = new View();
            view.setCaptureTo("#page-current");
            view.setFinal(true);
            view.ready = function () {

                $.init();

                // 添加'refresh'监听器
                $(document).on('refresh', '.pull-to-refresh-content', function (e) {
                    // 模拟2s的加载过程
                    setTimeout(function () {
                        var cardNumber = $(e.target).find('.card').length + 1;
                        var cardHTML   = '<div class="card">' +
                            '<div class="card-header">card' + cardNumber + '</div>' +
                            '<div class="card-content">' +
                            '<div class="card-content-inner">' +
                            '这里是第' + cardNumber + '个card，下拉刷新会出现第' + (cardNumber + 1) + '个card。' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                        $(e.target).find('.card-container').prepend(cardHTML);
                        // 加载完毕需要重置
                        $.pullToRefreshDone('.pull-to-refresh-content');
                    }, 2000);
                });
            };
            return view;
        },

        srcollAction: function () {
            var view = new View();
            view.setCaptureTo("#page-current");
            view.setFinal(true);
            view.ready = function () {

                $.init();

                // 加载flag
                var loading  = false;
                // 最多可加载的条目
                var maxItems = 100;

                // 每次加载添加多少条目
                var itemsPerLoad = 20;

                function addItems(number, lastIndex) {
                    // 生成新条目的HTML
                    var html = '';
                    for (var i = lastIndex + 1; i <= lastIndex + number; i++) {
                        html += '<li class="item-content"><div class="item-inner"><div class="item-title">Item ' + i + '</div></div></li>';
                    }
                    // 添加新条目
                    $('.infinite-scroll-bottom .list-container').append(html);

                }

                //预先加载20条
                addItems(itemsPerLoad, 0);

                // 上次加载的序号

                var lastIndex = 20;

                // 注册'infinite'事件处理函数
                $(document).on('infinite', '.infinite-scroll-bottom', function () {

                    // 如果正在加载，则退出
                    if (loading) return;

                    // 设置flag
                    loading = true;

                    // 模拟1s的加载过程
                    setTimeout(function () {
                        // 重置加载flag
                        loading = false;

                        if (lastIndex >= maxItems) {
                            // 加载完毕，则注销无限加载事件，以防不必要的加载
                            $.detachInfiniteScroll($('.infinite-scroll'));
                            // 删除加载提示符
                            $('.infinite-scroll-preloader').remove();
                            return;
                        }

                        // 添加新条目
                        addItems(itemsPerLoad, lastIndex);
                        // 更新最后加载的序号
                        lastIndex = $('.list-container li').length;
                        //容器发生改变,如果是js滚动，需要刷新滚动
                        $.refreshScroller();
                    }, 1000);
                });
            };
            return view;
        },

    },
};
