/* 1 定义Metro模块中的IndexController ,并且定义两个action方法，test3，test4*/
Alpaca.MainModule.IndexController = {
    //index,  默认渲染到
    indexAction: function () {
        var view = new Alpaca.MainModule.pageView();

        var header = new Alpaca.Part({name: "headerNav", to: "#ap-header-nav"});

        view.Layout.addChild(header);

        view.ready(function () {
        });
        return view;
    },
};