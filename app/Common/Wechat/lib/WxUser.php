<?php

namespace App\Common\Wechat\Lib;

/**
 * WxUser
 * @author Chengcheng
 * @date 2016-10-31 15:50:00
 */
class WxUser
{

    public $config = [];


    /**
     * 获取微信用户openId
     * @author Chengcheng
     * @date 2016年11月5日 14:47:40
     * @param string $code
     * @return string;
     */
    public function auth($code)
    {
        //判断是否存在code
        if (!isset($code)) {
            //不存在code，返回null
            return null;
        } else {
            //设置请求参数
            $urlObj["appid"]      = $this->config['appid'];
            $urlObj["secret"]     = $this->config['secret'];
            $urlObj["code"]       = $code;
            $urlObj["grant_type"] = "authorization_code";
            $bizString            = $this->toUrlParams($urlObj);
            $url                  = "https://api.weixin.qq.com/sns/oauth2/access_token?" . $bizString;

            //初始化curl
            $ch = curl_init();
            //设置超时
            curl_setopt($ch, CURLOPT_TIMEOUT, 600);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //运行curl，结果以jason形式返回
            $res = curl_exec($ch);
            curl_close($ch);
            //取出openid
            if (empty($res)) {
                return null;
            }
            $data = json_decode($res, true);
            //返回结果
            return $data;
        }
    }

    /**
     * 获取微信用户openId
     * @author Chengcheng
     * @date 2016年11月5日 14:47:40
     * @param string $code
     * @return string;
     */
    public function getOpenId($code)
    {
        //判断是否存在code
        if (!isset($code)) {
            //不存在code，返回null
            return null;
        } else {
            //设置请求参数
            $urlObj["appid"]      = $this->config['appid'];
            $urlObj["secret"]     = $this->config['secret'];
            $urlObj["code"]       = $code;
            $urlObj["grant_type"] = "authorization_code";
            $bizString            = $this->toUrlParams($urlObj);
            $url                  = "https://api.weixin.qq.com/sns/oauth2/access_token?" . $bizString;

            //初始化curl
            $ch = curl_init();
            //设置超时
            curl_setopt($ch, CURLOPT_TIMEOUT, 600);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //运行curl，结果以jason形式返回
            $res = curl_exec($ch);
            curl_close($ch);
            //取出openid
            if (empty($res)) {
                return null;
            }
            $data = json_decode($res, true);

            if (empty($data) || empty($data['openid'])) {
                return null;
            }
            $openId = $data['openid'];
            //返回结果
            return $openId;
        }
    }

    /**
     * 获取微信授权url
     * @author Chengcheng
     * @date 2016年11月5日 14:47:40
     * @param string $redirect
     * @param string $scope
     * @return string 返回结果
     */
    public function getWxAuthUrl($redirect = null, $scope = 'base')
    {
        if (empty($redirect)) {
            $redirect = '/';
        }
        $reurl  = 'http://' . $_SERVER['HTTP_HOST'] . $redirect;
        $baseUrl = urlencode($reurl);

        $urlObj["appid"] = $this->config['appid'];

        $urlObj["redirect_uri"]  = "$baseUrl";
        $urlObj["response_type"] = "code";

        if ($scope == 'base') {
            $urlObj["scope"] = "snsapi_base";
        } else {
            $urlObj["scope"] = "snsapi_userinfo";
        }
        $urlObj["state"] = "STATE" . "#wechat_redirect";

        $bizString = $this->toUrlParams($urlObj);
        $url       = "https://open.weixin.qq.com/connect/oauth2/authorize?" . $bizString;
        return $url;
    }

    /**
     * 获取AccessToken
     * @author Chengcheng
     * @date 2016年11月5日 14:47:40
     * @return object 返回结果
     */
    public function getAccessToken()
    {
        $urlObj["appid"]  = $this->config['appid'];
        $urlObj["secret"] = $this->config['secret'];
        $url              = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $urlObj["appid"] . '&secret=' . $urlObj["secret"];
        $html             = file_get_contents($url);
        $gets             = json_decode($html);
        return $gets->access_token;
    }

    /**
     * 获取AccessToken
     * @author Chengcheng
     * @date 2016年11月5日 14:47:40
     * @param string $accessToken
     * @param string $openId
     * @return object 返回结果
     */
    public function getUserInfo($openId, $accessToken = null)
    {
        if (empty($accessToken)) {
            $accessToken = $this->getAccessToken();
            $url  = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $accessToken . '&openid=' . $openId . '&lang=zh_CN';
        }else{
            $url  = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $accessToken . '&openid=' . $openId . '&lang=zh_CN';
        }
        $html = file_get_contents($url);
        $gets = json_decode($html, true);
        return $gets;
    }

    /**
     *
     * 拼接签名字符串
     * @param array $urlObj
     * @return string 返回已经拼接好的字符串
     */
    public function toUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v) {
            if ($k != "sign") {
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }
}
