/* 1 定义Metro模块中的IndexController ,并且定义两个action方法，test3，test4*/
Alpaca.MainModule.TabsController = {

    tabAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },
    fixedTabAction: function () {
        var view = new Alpaca.MainModule.View();
        return view;
    },
};