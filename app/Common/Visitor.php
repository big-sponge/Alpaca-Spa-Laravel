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

    //存放魔术方法变量
    protected $_data = [];

    /**
     * 魔术方法 get
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @param string $name
     * @return mixed
     */
    function __get($name)
    {
        if (!isset($this->_data[$name])) {
            return null;
        }
        return $this->_data[$name];
    }

    /**
     * 魔术方法 set
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @param string $name
     * @param mixed  $value
     * @return mixed
     */
    function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    /**
     * 单例
     */
    public static $instance = null;

    public static $instance_admin_member = null;

    public static $instance_user_member = null;

    public static $instance_user_wx = null;

    /**
     * 装载数据
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @param array $data
     * @return static
     */
    public function load($data)
    {
        // id
        if (isset($data['id'])) {
            $this->id          = $data['id'];
            static::user()->id = $data['id'];
        }
        // name
        if (isset($data['name'])) {
            $this->name          = $data['name'];
            static::user()->name = $data['name'];
        }

        // agent ip time
        $this->agent = empty($_SERVER['HTTP_USER_AGENT']) ? 'unknown' : $_SERVER['HTTP_USER_AGENT'];
        $this->ip    = $_SERVER["REMOTE_ADDR"];
        $this->time  = date('Y-m-d H:i:s');

        //data
        $this->_data = $data;

        return $this;
    }

    /**
     * 返回数组
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return static
     */
    public function toArray()
    {
        return $this->_data;
    }

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

    /**
     * 单例模式
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return static
     */
    public static function adminMember()
    {
        if (!static::$instance_admin_member) {
            $visitor                       = new static();
            static::$instance_admin_member = $visitor;
        }
        return static::$instance_admin_member;
    }

    /**
     * 单例模式
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return static
     */
    public static function userMember()
    {
        if (!static::$instance_user_member) {
            $visitor                      = new static();
            static::$instance_user_member = $visitor;
        }
        return static::$instance_user_member;
    }

    /**
     * 单例模式
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return static
     */
    public static function userWx()
    {
        if (!static::$instance_user_wx) {
            $visitor                  = new static();
            static::$instance_user_wx = $visitor;
        }
        return static::$instance_user_wx;
    }

}
