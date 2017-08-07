<?php

/**
 * WxUser
 * @author Chengcheng
 * @date 2016-10-31 15:50:00
 */
class WxJs
{
    private $appId;
    private $appSecret;
    private $jsapi_ticket_json;
    private $access_token_json;

    public function __construct($appId, $appSecret)
    {
        $this->appId             = $appId;
        $this->appSecret         = $appSecret;
        $this->jsapi_ticket_json = __DIR__ . '\jssdk\jsapi_ticket.json';
        $this->access_token_json = __DIR__ . '\jssdk\access_token.json';
    }

    public function getSignPackage($inputUrl = null)
    {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url      = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if($inputUrl){
            $url = htmlspecialchars_decode($inputUrl);
        }

        $timestamp = time();
        $nonceStr  = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            //"rawString" => $string,
            "jsApiList" => [
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'onMenuShareQZone',
                'startRecord',
                'stopRecord',
                'onVoiceRecordEnd',
                'playVoice',
                'pauseVoice',
                'stopVoice',
                'onVoicePlayEnd',
                'uploadVoice',
                'downloadVoice',
                'chooseImage',
                'previewImage',
                'uploadImage',
                'downloadImage',
                'translateVoice',
                'getNetworkType',
                'openLocation',
                'getLocation',
                'hideOptionMenu',
                'showOptionMenu',
                'hideMenuItems',
                'showMenuItems',
                'hideAllNonBaseMenuItem',
                'showAllNonBaseMenuItem',
                'closeWindow',
                'scanQRCode',
                'chooseWXPay',
                'openProductSpecificView',
                'addCard',
                'chooseCard',
                'openCard',
            ]
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str   = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket($notRefresh = true)
    {
        $cache_key = WiiCache::createCacheKey('FW_WEIXIN_JS_TICKET');
        if ($notRefresh) {
            $data = Mod::app()->cache->get($cache_key);
            if ($data) {
                return $data;
            }
        }

        $token  = $this->getAccessToken();
        $url    = "/cgi-bin/ticket/getticket?access_token={$token}&type=jsapi";
        $result = Mod::app()->api->fw($url, []);
        $result = json_decode($result, true);
        if ($result['errcode'] == 0) {
            // 写入缓存
            Mod::app()->cache->set($cache_key, $result['ticket'], $result['expires_in']);
            return $result['ticket'];
        }

        $token  = $this->getAccessToken(false);
        $url    = "/cgi-bin/ticket/getticket?access_token={$token}&type=jsapi";
        $result = Mod::app()->api->fw($url, []);
        $result = json_decode($result, true);
        if ($result['errcode'] == 0) {
            // 写入缓存
            Mod::app()->cache->set($cache_key, $result['ticket'], $result['expires_in']);
            return $result['ticket'];
        }
        return false;
    }

    private function getAccessToken($notRefresh = true)
    {
        //读取缓存中的数据
        $cache_key = WiiCache::createCacheKey('FW_WEIXIN_TOKEN');

        if ($notRefresh) {
            $data = Mod::app()->cache->get($cache_key);
            if ($data) {
                return $data;
            }
        }

        //请求服务器获取数据
        $url    = "/cgi-bin/token?grant_type=client_credential&appid={$this->appId}&secret={$this->appSecret}";
        $result = Mod::app()->api->fw($url, []);
        $result = json_decode($result, true);

        // 写入缓存
        Mod::app()->cache->set($cache_key, $result['access_token'], $result['expires_in']);
        return $result['access_token'];
    }
}
