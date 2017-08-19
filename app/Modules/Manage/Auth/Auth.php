<?php

namespace App\Modules\Manage\Auth;
use App\Models\AdminMember;

/**
 * Auth
 * @author Chengcheng
 * @date 2016-10-20 15:50:00
 */
class Auth
{
    //返回信息
    const SYSTEM_ERROR = 0;                   //系统错误

    //系统用户
    const MEMBER_IS_LOGIN = "MEMBER_IS_LOGIN";   //系统账号是否登录
    const MEMBER_INFO     = "MEMBER_INFO";       //系统账号数据

    //微信用户
    const WX_IS_LOGIN = "WX_IS_LOGIN";   //系统账号是否登录
    const WX_INFO     = "WX_INFO";       //系统账号数据

    //用户是否登录
    const LOGIN_YES = 1;  //登录用户
    const LOGIN_NO  = 2;  //未登录用户

    //单例
    private static $instance = null;

    /**
     * 单例
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     * @return static
     */
    public static function auth()
    {
        return self::getInstance();
    }

    /**
     * 创建单例
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     */
    private static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;

            $config = array(
                'name'              => 'PHPSESSID',
                'use_trans_sid'     => '1',
                'save_handler'      => 'files',
                'save_path'         => '/session/',
                'use_only_cookies'  => '0',
                'use_cookies'       => '1',
                'cookie_path'       => '/',
                'cookie_domain'     => '',
                'cookie_life_time'  => '14000',
                'gc_max_life_time'  => '14000',
                'gc_divisor'        => '1',
                'gc_probability'    => '1',
                'serialize_handler' => 'php_serialize',
            );

            //设置session.nam
            ini_set('session.name', 'MANAGE_MEMBER_ID');

            //设置session.save_path
            ini_set('session.save_path', base_path('storage') . '/Session/Manage');

            //创建session
            self::$instance->initSession();
        }

        return self::$instance;
    }

    /**
     * 启动session
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     */
    public function initSession()
    {
        session_start();
    }

    /**
     * 登录-系统账号
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     * @param array $data
     * @return boolean
     */
    public function loginMember($data)
    {
        $_SESSION[self::MEMBER_IS_LOGIN] = true;
        $_SESSION[self::MEMBER_INFO]     = $data;
        return true;
    }

    /**
     * 登录-微信账号
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     * @param array $data
     * @return boolean
     */
    public function loginWx($data)
    {
        $_SESSION[self::WX_IS_LOGIN] = true;
        $_SESSION[self::WX_INFO]     = $data;
        return true;
    }

    /**
     * 清除登录信息-不删除session
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     * @return boolean
     */
    public function logClear()
    {
        //清空系统账号信息
        $_SESSION[self::MEMBER_IS_LOGIN] = false;
        $_SESSION[self::MEMBER_INFO]     = null;

        //清空微信账号登录信息
        $_SESSION[self::WX_IS_LOGIN] = false;
        $_SESSION[self::WX_INFO]     = null;

        return true;
    }

    /**
     * 注销
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     * @return boolean
     */
    public function logout()
    {
        session_unset();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 4200, ' / ');
        }
        session_destroy();
        return true;
    }

    /**
     * 判断当前用户是否登录 - 系统账号
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     */
    public function checkLoginMember()
    {
        $result         = array();
        $result["code"] = self::LOGIN_YES;
        $result["msg"]  = "登录状态！";
        $result["data"] = null;

        try {
            //检查用户是否登录-系统账号
            if (empty($_SESSION[self::MEMBER_IS_LOGIN])) {
                $result["code"] = self::LOGIN_NO;
                $result["msg"]  = "没有登录！";
                return $result;
            }

            //系统账号-登录用户访问，返回用户信息
            if (!empty($_SESSION[self::MEMBER_INFO])) {
                $result["data"] = $_SESSION[self::MEMBER_INFO];
            }

        } catch (\Exception $e) {
            $result["code"] = "0";
            $result["msg"]  = $e->getMessage();
        }

        return $result;
    }

    /**
     * 判断当前用户是否登录 - 微信账号
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     */
    public function checkLoginWx()
    {
        $result         = array();
        $result["code"] = self::LOGIN_YES;
        $result["msg"]  = "登录状态！";
        $result["data"] = null;

        try {
            //检查用户是否登录-微信授权
            if (empty($_SESSION[self::WX_IS_LOGIN])) {
                $result["code"] = self::LOGIN_NO;
                $result["msg"]  = "没有登录！";
                return $result;
            }

            //微信授权登录，用户访问，返回用户微信账号信息
            if (!empty($_SESSION[self::WX_INFO])) {
                $result["data"] = $_SESSION[self::WX_INFO];
            }

        } catch (\Exception $e) {
            $result["code"] = "0";
            $result["msg"]  = $e->getMessage();
        }

        return $result;
    }

    /**
     * 获取用户登录信息
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     * @return boolean
     */
    public function getLoginInfo()
    {
        //1 获取用户信息
        $info['member']        = empty($_SESSION[self::MEMBER_INFO]) ? [] : $_SESSION[self::MEMBER_INFO];
        $info['wx']            = empty($_SESSION[self::WX_INFO]) ? [] : $_SESSION[self::WX_INFO];
        $info['isMemberLogin'] = !empty($_SESSION[self::MEMBER_IS_LOGIN]) ? 1 : 0;
        $info['isWxLogin']     = !empty($_SESSION[self::WX_IS_LOGIN]) ? 1 : 0;

        //2 过滤掉openId,密码Passwd信息等
        unset($info['wx']['open_id']);
        unset($info['member']['passwd']);

        //3 返回结果
        return $info;
    }

    /**
     * 更新用户登录信息到session
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     * @param string $loginType
     * @return boolean
     */
    public function updateLoginInfo($loginType = null)
    {
        //1.更新系统账号信息
        if (isset($_SESSION[self::MEMBER_INFO]) && (empty($loginType) || $loginType = self::MEMBER_INFO)) {
            //查找用户信息
            $memberId = $_SESSION[self::MEMBER_INFO]['id'];
            $data     = AdminMember::model()->info($memberId);

            //更新用户信息到session中
            $_SESSION[self::MEMBER_INFO] = $data;
        } else {
            $_SESSION[self::MEMBER_INFO] = null;
        }

        //2.更新微信账号信息
        if (!empty($_SESSION[self::WX_INFO]) && (empty($loginType) || $loginType = self::WX_INFO)) {
            //查找微信用户信息
            $userWxId = $_SESSION[self::WX_INFO]['id'];
            //$data     = UserWx::model()->info($userWxId);
            //更新微信用户信息到session中
            $_SESSION[self::WX_INFO] = $data;
        } else {
            $_SESSION[self::WX_INFO] = null;
        }
    }
}
