//连接websocket
function createWebSocket(url) {
    try {
        ws = new WebSocket(url);
        initEventHandle();
    } catch (e) {
        reconnect(url);
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
        if(!clientId){
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
                    openPop('网络错误，请刷新后重试');
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
                break;
            case 20:
                //绑定移动端
                if(acceptData.code != 200){
                    openPop('绑定用户失败，请刷新后重试');
                }
                break;
            case 30:
                //PC点击开始
                if(acceptData.code == 200){
                    start();
                } else {
                    openPop('网络错误，请刷新后重试');
                }

                break;
            case 40:
                //每摇一次+1
                if(acceptData.code == 6000){
                    //已有人达到最大摇奖次数
                    location.replace(userResultUrl+acceptData.item_id);
                } else if(acceptData.code == 9002){
                    //活动未开始
                    location.reload();
                } else if(acceptData.code == 9003){
                    location.replace(userResultUrl+acceptData.item_id);
                }

                break;
        }
    }
}

//重连
function reconnect(url) {
    createWebSocket(url);
    initEventHandle();
}
//绑定客户端
function bindClient() {
    var encrypt = new JSEncrypt();
    encrypt.setPublicKey(publicKey);
    var senddata = '{"activity_id":"' + activityId + '","user_id":"'+userId+'","device":"' + device + '"}';
    senddata = encrypt.encrypt(senddata);

    content = '{"cmd":20,"data":"' + senddata + '"}';
    ws.send(content);
}
//统计数
function shakeCount() {
    var encrypt = new JSEncrypt();
    encrypt.setPublicKey(publicKey);
    var senddata = '{"activity_id":"' + activityId + '","user_id":"'+userId+'","device":"' + device + '"}';
    senddata = encrypt.encrypt(senddata);

    content = '{"cmd":40,"data":"' + senddata + '"}';
    ws.send(content);
}
//开始websocket
createWebSocket(wsUrl);
if(shakeStatus == 2){
    start();
}

// 打开提示框
function openPop(text){
    $(".popup .text").text(text);
    $(".popup").css("display","block").one("click", ".close", function(){
        $(".popup").css("display","none");
    })
}

// 倒计时代码
function startCount(cb){
    $(".tips-text").text("摇速！中奖的终极必杀技");
    $(".start-phone").hide();
    $(".count").css("display","block");
    $(".step3").addClass("on");
    setTimeout(function(){
        $(".tips-text").text("幅度大？！呵呵~频率才是王道！");
        $(".step3").removeClass("on");
        $(".step2").addClass("on");
        setTimeout(function(){
            $(".tips-text").text("拼腕力的时刻到了！");
            $(".step2").removeClass("on");
            $(".step1").addClass("on");
            setTimeout(function(){
                $(".tips-text").text("开摇吧！企鹅君");
                $(".step1").removeClass("on");
                $(".stepgo").addClass("on");
                setTimeout(function(){
                    $(".stepgo").removeClass("on");
                    cb && cb();
                },1000);
            },1000);
        },1000);
    },1000);
}

function shakeAnimate(){
    audioAutoPlay('shake_audio');
    $(".shake-phone").addClass("on");
    setTimeout(function() {
        $(".shake-phone").removeClass("on");
    }, 500);
}

var myShakeEvent = new Shake({
    threshold: 10, // optional shake strength threshold
    timeout: 300 // optional, determines the frequency of event generation
});

window.addEventListener('shake', shakeEventDidOccur, false);
//摇一摇回调函数
function shakeEventDidOccur () {
    shakeCount();
    shakeAnimate();
}

function start(){
    // 开始倒计时
    startCount(function(){
        // 倒计时完成，显示摇一摇
        $(".shake-box").css("display","block");
        myShakeEvent.start();
    });
}

function end(){
    window.removeEventListener('shake', shakeEventDidOccur, false);
    myShakeEvent.stop();
}

function audioAutoPlay(id){
    var audio = document.getElementById(id);
    audio.play();
    if (typeof WeixinJSBridge == "object" && typeof WeixinJSBridge.invoke == "function") {
        WeixinJSBridge.invoke('getNetworkType', {}, function (res) {
            audio.play();
        });
    }
}