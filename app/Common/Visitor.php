<?php

namespace App\Common;

/**
 * Visitor
 * @author Chengcheng
 * @date 2016-10-20 15:50:00
 */
class Visitor
{

    //用户id
    public $id = '0';

    //用户name
    public $name = 'gust';

    //用户type
    public $type = 'member';

    //用户ip
    public $ip = '127.0.0.1';

    //用户agent
    public $agent = 'unknown';

    //用户访问时间
    public $time = '0000-00-00 00:00:00';

    /**
     * 单例
     */
    public static $instance = null;

    /**
     * 单例模式
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return static
     */
    public static function user()
    {
        if (!static::$instance) {
            $visitor          = new static();
            $visitor->agent   = empty($_SERVER['HTTP_USER_AGENT']) ? 'unknown' : $_SERVER['HTTP_USER_AGENT'];
            $visitor->ip      = $_SERVER["REMOTE_ADDR"];
            $visitor->time    = date('Y-m-d H:i:s');
            static::$instance = $visitor;
        }
        return static::$instance;
    }
}
