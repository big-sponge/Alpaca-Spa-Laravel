/**********************websocket*********************************/
//连接websocket
function createWebSocket(url) {
    try {
        ws = new WebSocket(url);
        initEventHandle();
    } catch (e) {
        reconnect(url);
        console.log(e.message);
    }
}

//websocket事件
function initEventHandle() {
    ws.onclose = function () {
        reconnect(wsUrl);
    };
    ws.onerror = function () {
        reconnect(wsUrl);
    };
    ws.onopen = function () {
        if (!clientId) {
            content = '{"cmd":0,"data":{"token":"' + token + '"}}';
        } else {
            content = '{"cmd":0,"data":{"token":"' + token + '","client_id":"' + clientId + '"}}';
        }
        ws.send(content);
    };
    ws.onmessage = function (event) {
        var acceptData = JSON.parse(event.data);
        console.log(acceptData);
        var cmd = acceptData.cmd;
        switch (cmd) {
            case 0:
                //token换公钥
                publicKey = base64Decode(acceptData.public_key);
                if (!publicKey) {
                    openPop('数据为空,请刷新后重试');
                }
                clientId = acceptData.client_id;
                bindClient();
                break;
            case 1:
                //心跳监测
                content = '{"cmd":1,"data":"1"}';
                ws.send(content);
                break;
            case 10:
                //绑定大屏
                if (acceptData.code != 200) {
                    window.location.reload();
                }
                break;
            case 20:
                //绑定移动端
                //如果有重复的先去重
                var isRepeat = false;
                $('.page1 .user-list .item').each(function () {
                    if ($(this).attr('class') == 'item user-' + acceptData.user_id) {
                        isRepeat = true;
                    }

                });
                if (isRepeat == false) {
                    var html = '<li class="item user-' + acceptData.user_id + '"><img width="135" height="135" src="' + acceptData.avatar + '" /></li>';
                    $('.page1 .user-list').prepend(html);
                    $('.page1 .user-list .item:last').remove();
                    var num = $('.page1 .con-left .num').text();
                    $('.page1 .con-left .num').text(parseInt(num) + 1);
                }
                break;

            case 30:
                //PC点击开始
                if (acceptData.code == 200) {
                    changePage(2);
                }
                break;
            case 40:
                //每摇一次+1
                if (acceptData.code == 6000) {
                    //已有人达到最大值
                    changePage(4);
                } else {
                    window.location.reload();
                }
                break;
        }
    }
}

//重连
function reconnect(url) {
    if (lockReconnect) return;
    lockReconnect = true;
    //没连接上会一直重连，设置延迟避免请求过多
    setTimeout(function () {
        createWebSocket(url);
        initEventHandle();
        lockReconnect = false;
    }, 2000);
}

//绑定客户端
function bindClient() {
    var encrypt = new JSEncrypt();
    encrypt.setPublicKey(publicKey);
    var senddata = '{"activity_id":"' + activityId + '","device":"' + device + '"}';
    senddata = encrypt.encrypt(senddata);

    content = '{"cmd":10,"data":"' + senddata + '"}';
    ws.send(content);
}

//倒计时开始
$(".page1 .button").click(function () {
    var shakeLimit = $('#01middle').text();
    var winLimit = $('#02middle').text();
    $.ajax({
        url: setShakeItemUrl,
        type: 'POST',
        dataType: 'json',
        data: {'activity_id': activityId, 'shake_limit': shakeLimit, 'win_limit': winLimit},
        success: function (data) {
            if (data.code == 200) {
                var encrypt = new JSEncrypt();
                encrypt.setPublicKey(publicKey);
                var senddata = '{"activity_id":"' + activityId + '","device":"' + device + '"}';
                senddata = encrypt.encrypt(senddata);

                content = '{"cmd":30,"data":"' + senddata + '"}';
                ws.send(content);
            } else {
                openPop(data.msg);
            }
        },
        error: function () {
            openPop('网络错误，请刷新后重试');
            return false;
        }
    });
});
//判断浏览器
var bm = browserMatch();
if (bm.browser && bm.browser == "IE") {
    openPop('请使用chrome或QQ浏览器！');
} else {
    //开始websocket
    //createWebSocket(wsUrl);
}

/*********************page1*********************************/
var initPage1 = function () {
    //初始化页面1
    changePage(1);
    $(".page1 .winnum").text($("#02middle").text());

    $("#01right").click(function () {
        //获取到的节点的值转为int型；
        var num = parseInt($("#01middle").text());
        //如果小于100   则改变节点的值
        if (num < 100) {
            $("#01middle").text(num + 10);
        }

    });
    $("#01left").click(function () {
        var num = parseInt($("#01middle").text());
        if (num > 10) {
            $("#01middle").text(num - 10);
        }
    });

    $("#02left").click(function () {
        var num = parseInt($("#02middle").text());
        if (num > 1) {
            $("#02middle").text(num - 1);
            $(".page1 .winnum").text($("#02middle").text());
        }
    });

    $("#02right").click(function () {
        var num = parseInt($("#02middle").text());
        if (num < 10) {
            $("#02middle").text(num + 1);
            $(".page1 .winnum").text($("#02middle").text());
        }
    });
};
/*********************page1*********************************/
/*********************page2*********************************/
var initPage2 = function () {
    var tipsList = ["开摇吧！企鹅君", "拼腕力的时刻到了！", "幅度大？！呵呵~频率才是王道！", "摇速！中奖的终极必杀技"]
    //初始化倒计时
    var timeCount = 3;
    $(".page2 .counttime").text(timeCount);
    $(".page2 .tips").text(tipsList[timeCount]);


    var sint = setInterval(function () {
        timeCount -= 1;
        if (timeCount >= 0) {
            if (timeCount == 0) {
                $(".page2 .counttime").text("GO");
            } else {
                $(".page2 .counttime").text(timeCount);
            }

            $(".page2 .tips").text(tipsList[timeCount]);
        } else {
            window.clearInterval(sint);
            changePage(3);
        }

    }, 1000);
};
/*********************page2*********************************/
/*********************page3*********************************/
var initPage3 = function () {
    intervalPage3Id = setInterval(function () {
        $.ajax({
            url: shakeRankUrl,
            type: 'POST',
            dataType: 'json',
            data: {'activity_id': activityId},
            success: function (data) {
                if (data.data) {
                    shakeRankHtml(data.data);
                }
            },
            error: function () {
                openPop('网络错误，请刷新后重试');
                return false;
            }
        });
    }, 1000);
};
//获取页面HTML
function shakeRankHtml(data) {
    var html = '';
    var widthRate = 0;
    var num = $("#01middle").text();
    for (var i = 0; i < data.length; i++) {
        widthRate = (data[i].shake_count / num) * 100;

        html += '<li class="item">';
        html += '<a class="rank front">' + (i + 1) + '</a>';
        html += '<div class="img">';
        html += '<img src="' + data[i].avatar + '" width="100" height="100"/>';
        html += '</div>';
        html += '<div class="con-right">';
        html += '<p class="username">' + data[i].nickname + '</p>';
        html += '<div class="line">';
        html += '<div class="line-ass" style="width: ' + widthRate + '%;">';
        html += '<p class="widthP"><span class="num">' + data[i].shake_count + '</span>次</p>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="clear"></div>';
        html += '</li>';
    }
    $('.page3 .content-ul').html(html);
}

/*********************page3*********************************/

/*********************page4*********************************/
var page4 = function () {
    //开始按钮
    $(".page4 .button .btn1").click(function () {
        $.ajax({
            url: createShakeItemUrl,
            type: 'POST',
            dataType: 'json',
            data: {'activity_id': activityId},
            success: function (data) {
                if (data.code == 200) {
                    //还原初始状态
                    $('.page1 .con-left .num').text(0);
                    $('.page1 .con-left .winnum').text(3);
                    $('.page1 .item-index').text(data.data['item_index']);
                    $('.page3 .content-ul').text('');
                    $('.page4 .first-ul').text('');
                    $('.page4 .two-ul').text('');
                    $('.page4 .three-ul').text('');
                    $('.page1 .con-left .user-list .item').each(function(){
                        $(this).attr('class','item');
                        $(this).text('');
                    });
                    $('#01middle').text(30);
                    $('#02middle').text(10);
                    changePage(1);
                } else {
                    openPop('未创建成功，请重试');
                    return false;
                }
            },
            error: function () {
                openPop('网络错误，请刷新后重试');
                return false;
            }
        });
    });

    //结束按钮
    $(".page4 .button .btn2").click(function () {
        $.ajax({
            url: setTimeSlot,
            type: 'POST',
            dataType: 'json',
            data: {'activity_id': activityId},
            success: function (data) {
                if (data.code == 200) {
                    openPop('该场次活动已结束');
                } else {
                    openPop('操作失败，请重试');
                }
            },
            error: function () {
                openPop('网络错误，请刷新后重试');
                return false;
            }
        });
    });
};
var initPage4 = function () {
    //清除定时器
    window.clearInterval(intervalPage3Id);
    //ajax 获取前十名
    $.ajax({
        url: shakeEndListUrl,
        type: 'POST',
        dataType: 'json',
        data: {'activity_id': activityId},
        success: function (data) {
            if (data.data) {
                shakeEndHtml(data.data);
            }
        },
        error: function () {
            openPop('网络错误，请刷新后重试');
            return false;
        }
    });
    page4();
};
//最后结果页-显示信息
function shakeEndHtml(data) {
    var htmlFirst1 = '';
    var htmlFirst2 = '<li></li>';
    var htmlFirst3 = '';
    var htmlTwo = '';
    var htmlThree = '';
    for (var i = 0; i < data.length; i++) {
        //第一
        if (i == 0) {
            htmlFirst1 = '<li>';
            htmlFirst1 += '<div class="bgimg01"></div>';
            htmlFirst1 += '<div class="img"><img src="' + data[i].avatar + '" width="100%" height="100%"/></div>';
            if (data[i].ticket_status != 0) {
                htmlFirst1 += '<div class="award show"></div>';
            }
            htmlFirst1 += '<p class="username">' + data[i].nickname + '</p>';
            htmlFirst1 += '</li>';
        }
        //第二
        if (i == 1) {
            htmlFirst2 = '<li>';
            htmlFirst2 += '<div class="bgimg02"></div>';
            htmlFirst2 += '<div class="img"><img src="' + data[i].avatar + '" width="100%" height="100%"/></div>';
            if (data[i].ticket_status != 0) {
                htmlFirst2 += '<div class="award show"></div>';
            }
            htmlFirst2 += '<p class="username">' + data[i].nickname + '</p>';
            htmlFirst2 += '</li>';
        }
        //第三
        if (i == 2) {
            htmlFirst3 = '<li>';
            htmlFirst3 += '<div class="bgimg03"></div>';
            htmlFirst3 += '<div class="img"><img src="' + data[i].avatar + '" width="100%" height="100%"/></div>';
            if (data[i].ticket_status != 0) {
                htmlFirst3 += '<div class="award show"></div>';
            }
            htmlFirst3 += '<p class="username">' + data[i].nickname + '</p>';
            htmlFirst3 += '</li>';
        }
        //四 五 六
        if (i > 2 && i < 6) {
            htmlTwo += '<li>';
            htmlTwo += '<div class="img"><img src="' + data[i].avatar + '" width="100%" height="100%" /></div>';
            htmlTwo += '<div class="ranking">' + (i + 1) + '</div>';
            if (data[i].ticket_status != 0) {
                htmlTwo += '<div class="award new_award show"></div>';
            }
            htmlTwo += '<p class="username">' + data[i].nickname + '</p>';
            htmlTwo += '</li>';
        }

        //七 八 九 十
        if (i >= 6) {
            htmlThree += '<li>';
            htmlThree += '<div class="img"><img src="' + data[i].avatar + '" width="100%" height="100%" /></div>';
            htmlThree += '<div class="ranking">' + (i + 1) + '</div>';
            if (data[i].ticket_status != 0) {
                htmlThree += '<div class="award new_award show"></div>';
            }
            htmlThree += '<p class="username">' + data[i].nickname + '</p>';
            htmlThree += '</li>';
        }
    }
    $('.page4 .first .first-ul').html(htmlFirst2 + htmlFirst1 + htmlFirst3);
    $('.page4 .two .two-ul').html(htmlTwo);
    $('.page4 .three .three-ul').html(htmlThree);

}
/*********************page4*********************************/
//错误弹窗
function openPop(text){
    $(".error-box").toggle();
    $(".error").toggle();
    $(".error").animate({"top":"50%","margin-top":"-270px"},500);
    $(".error .close").click(function(){
        $(".error").hide();
        $(".error").css("top","-540px");
        $(".error-box").hide();
    });
    $(".error .err-bottom").html(text);
}


//判断浏览器
function browserMatch() {
    var userAgent = navigator.userAgent,
        rMsie = /(msie\s|trident.*rv:)([\w.]+)/,
        rFirefox = /(firefox)\/([\w.]+)/,
        rOpera = /(opera).+version\/([\w.]+)/,
        rChrome = /(chrome)\/([\w.]+)/,
        rSafari = /version\/([\w.]+).*(safari)/;
    var browser;
    var version;
    var ua = userAgent.toLowerCase();

    function uaMatch(ua) {
        var match = rMsie.exec(ua);
        if (match != null) {
            return {
                browser: "IE",
                version: match[2] || "0"
            };
        }
        var match = rFirefox.exec(ua);
        if (match != null) {
            return {
                browser: match[1] || "",
                version: match[2] || "0"
            };
        }
        var match = rOpera.exec(ua);
        if (match != null) {
            return {
                browser: match[1] || "",
                version: match[2] || "0"
            };
        }
        var match = rChrome.exec(ua);
        if (match != null) {
            return {
                browser: match[1] || "",
                version: match[2] || "0"
            };
        }
        var match = rSafari.exec(ua);
        if (match != null) {
            return {
                browser: match[2] || "",
                version: match[1] || "0"
            };
        }
        if (match != null) {
            return {
                browser: "",
                version: "0"
            };
        }
    }

    return uaMatch(userAgent.toLowerCase());
}