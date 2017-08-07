<?php

namespace App\Common\Wechat;

use App\Common\Wechat\Lib\WxUser;
use EasyWeChat\Foundation\Application;

/**
 * WeChat
 * @author Chengcheng
 * @date 2016-11-08 15:50:00
 */
class WeChat
{

    //微信easyWechat单例
    private static $instance = null;

    //用户单例
    private static $instanceWxUser = null;


    /**
     * 微信相关配置信息
     * @author Chengcheng
     * @date 2016年11月5日 14:47:40
     * @param array
     */
    public static function config()
    {
        $result['appid']  = config("wechat.app_id");
        $result["secret"] = config("wechat.secret");

        return $result;
    }

    /**
     * 微信单例
     * @author Chengcheng
     * @date 2016年11月5日 14:47:40
     * @return object
     */
    public static function app()
    {
        if (!self::$instance) {
            self::$instance = new Application(config('wechat'));
        }
        return self::$instance;
    }

    /**
     * 微信用户单例，用于微信用户相关操作
     * @author Chengcheng
     * @date 2016年11月5日 14:47:40
     * @return WxUser
     */
    public static function user()
    {
        if (!self::$instanceWxUser) {
            self::$instanceWxUser = new WxUser();
            self::$instanceWxUser->config = self::config();
        }
        return self::$instanceWxUser;
    }
}
