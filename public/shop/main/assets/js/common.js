// 定义推荐图片高度
function imgHeight(cName) {
	$(cName).height($(cName).width());
	// 当窗口发生改变时
	window.onresize = function() {
		$(cName).height($(cName).width());
	}
}
// 拨打客服电话
function call_phone(number) {
	$.confirm(number,
		function() {
			window.location.href = 'tel:' + number
		}
	);
	$('.modal-button-bold').text('呼叫');
}
// 自定义图片高度
function img_height(name) {
	$('.' + name).css('height', $('.' + name).children('img').css('width'))
}

// 判断是否是微信打开
//var useragent = navigator.userAgent;
//if (useragent.match(/MicroMessenger/i) != 'MicroMessenger') {
//	$('body').empty().html('<div class="wechat">请在微信上打开此网站</div>')
//}