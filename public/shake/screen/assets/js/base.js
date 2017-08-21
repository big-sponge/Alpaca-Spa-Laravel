/**
 * 初始化公共js逻辑
 */
var initBase = function () {
    //设置屏幕
    setupHW();
    window.onresize = function () {
        setupHW();
    };

    //全屏按钮
    var isfullscreen = false;
    $(".bottomBar .fsbtn").click(function () {
        if (isfullscreen) {
            exitFullscreen();
            isfullscreen = false;
        } else {
            fullscreen();
            isfullscreen = true;
        }
    });
};

var setupHW = function () {
    //宽高比
    var hw = 1920 / 1024;
    //高宽比
    var wh = 1024 / 1920;
    //当前屏幕宽
    var pw = $(window).width();
    //当前屏幕高
    var ph = $(window).height();
    //当前屏幕高比
    var phw = pw / ph;
    //console.log("宽高比：" + 　hw);
    //console.log("屏幕宽高比：" + phw);
    //console.log("屏幕宽：" + 　pw + " ,屏幕高：" + ph);

    //设置背景
    if (phw < hw) {
        //已高为准
        //console.log("+++++++++++++++++");
        var bgw1 = pw;
        var bgh1 = bgw1 * wh;

        var offbgh = ph / bgh1;

        var bgh = bgh1 * offbgh;
        var bgw = bgh * hw;

        //console.log("背景宽高：" + bgw1 + " ,: " + bgh1);
        //console.log("背景宽高：" + bgw + " ,: " + bgh);
        $('.bg').css("height", bgh + "px");
        $(".bg").css("background-size", bgw + "px " + bgh + "px");
    } else {
        //已宽为准
        //console.log("---------------------");
        var bgw = pw;
        var bgh = bgw * wh;

        //console.log("背景宽高：" + bgw + " ,: " + bgh);
        $('.bg').css("height", bgh + "px");
        $(".bg").css("background-size", bgw + "px " + bgh + "px");
    }


    //设置缩放
    $(".main").css("zoom", $(".bg").width() / 1920);
};

//切换页面
var changePage = function (pageNum) {

    $(".page1").hide();
    $(".page2").hide();
    $(".page3").hide();
    $(".page4").hide();

    if (pageNum == 1) {
        $(".page1").show();
    } else if (pageNum == 2) {
        $(".page2").show();
        initPage2();
    } else if (pageNum == 3) {
        $(".page3").show();
        initPage3();
    } else if (pageNum == 4) {
        $(".page4").show();
        initPage4();
    }
};

var fullscreen = function () {
    var elem = document.body;
    if (elem.webkitRequestFullScreen) {
        elem.webkitRequestFullScreen();
    } else if (elem.mozRequestFullScreen) {
        elem.mozRequestFullScreen();
    } else if (elem.requestFullScreen) {
        elem.requestFullscreen();
    } else {
        //浏览器不支持全屏API或已被禁用
        alert("浏览器不支持全屏API或已被禁用");
    }
};
var exitFullscreen = function () {
    var elem = document;
    if (elem.webkitCancelFullScreen) {
        elem.webkitCancelFullScreen();
    } else if (elem.mozCancelFullScreen) {
        elem.mozCancelFullScreen();
    } else if (elem.cancelFullScreen) {
        elem.cancelFullScreen();
    } else if (elem.exitFullscreen) {
        elem.exitFullscreen();
    } else {
        //浏览器不支持全屏API或已被禁用
        alert("浏览器不支持全屏API或已被禁用");
    }
};