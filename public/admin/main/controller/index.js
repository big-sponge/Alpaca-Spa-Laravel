/* 1 定义Metro模块中的IndexController ,并且定义两个action方法，test3，test4*/
Alpaca.MainModule.IndexController = {

	//index,  默认渲染到
	indexAction : function (){
		//视图默认渲染到#content位置，可以通过to对象改变渲染位置
		var view = new Alpaca.MainModule.pageView();
		view.ready(function(){

		});
		return view;
	},
};