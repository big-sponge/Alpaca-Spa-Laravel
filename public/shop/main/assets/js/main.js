//页面跳转
function href(a,b) {
	
		mui.openWindow({
			url: a,
			id: b,
			show: {
				aniShow: 'pop-in'
			}
		})

	}


/*跳转页面出现雪花*/
function clicklist (where) { //list点击item后的事件
              plus.nativeUI.showWaiting();//显示原生等待框
              webviewContent= plus.webview.create(where);//后台创建webview并打开show.html
              webviewContent.addEventListener("loaded", function() { //注册新webview的载入完成事件
              
              webviewContent.show("slide-in-right",200); //把新webview窗体显示出来，显示动画效果为速度200毫秒的右侧移入动画
              plus.nativeUI.closeWaiting();
               }, false);
                //新webview的载入完毕后关闭等待框
            }



/*避免出现二次点击事件方法*/
var tap_first = null;
function unsafe_tap() {
			 console.log(2222);
			 if(!tap_first) {//怎么知道不为空
				tap_first = new Date().getTime();
				setTimeout(function() {
					tap_first = null;
				}, 1500);
			 } else {
				return true;
			 }
		}






