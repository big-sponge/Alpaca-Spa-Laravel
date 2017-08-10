/* 1 定义Metro模块中的IndexController ,并且定义两个action方法，test3，test4*/
Alpaca.MainModule.IndexController = {
    //test,  默认渲染到
    testAction: function () {
        var view = new Alpaca.MainModule.pageView();

        var header = new Alpaca.Part({name: "headerNav", to: "#ap-header-nav"});

        view.Layout.addChild(header);

        view.ready(function () {
        });
        return view;
    },
    //index,  默认渲染到
    indexAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //bar,  默认渲染到
    barAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //btns,  默认渲染到
    btnsAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //form,  默认渲染到
    formAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //searchbar,  默认渲染到
    searchbarAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //list,  默认渲染到
    listAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //tabs,  默认渲染到
    tabsAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //card,  默认渲染到
    cardAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //grid,  默认渲染到
    gridAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //modal,  默认渲染到
    modalAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //preloader,  默认渲染到
    preloaderAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //actions,  默认渲染到
    actionsAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //calendar,  默认渲染到
    calendarAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //picker,  默认渲染到
    pickerAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //datetime-picker,  默认渲染到
    datetimePickerAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //city-picker,  默认渲染到
    cityPickerAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //swiper,  默认渲染到
    swiperAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //photo-browser,  默认渲染到
    photoBrowserAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //pull-to-refresh,  默认渲染到
    pullToRefreshAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //infinite-scroll,  默认渲染到
    infiniteScrollAction: function () {
        var view = new Alpaca.View();
        return view;
    },

    //icons,  默认渲染到
    iconsAction: function () {
        var view = new Alpaca.View();
        return view;
    },
};