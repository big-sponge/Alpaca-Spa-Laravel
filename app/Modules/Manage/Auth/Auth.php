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

    //Label是否登录
    const LOGIN_MEMBER = "IS_LOGIN_MEMBER";   //系统账号是否登录
    const LOGIN_WX     = "IS_LOGIN_WX";       //微信账号是否登录

    //Label登录信息
    const LOGIN_INFO_MEMBER = "INFO_MEMBER";   //系统账号信息
    const LOGIN_INFO_WX     = "INFO_WX";       //微信账号信息

    //用户是否登录
    const LOGIN_YES = 1;  //登录用户
    const LOGIN_NO  = 2;  //未登录用户

    //单例
    private static $instance = null;

    /**
     * 单例
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
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
            ini_set('session.name', 'SERVE_MEMBER_ID');

            //设置session.save_path
            ini_set('session.save_path', base_path('storage') . '/Session/Serve');

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
    public function login($data)
    {
        $_SESSION[self::LOGIN_MEMBER]      = true;
        $_SESSION[self::LOGIN_INFO_MEMBER] = $data;
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $_SESSION['HTTP_USER_AGENT'] = "Unknow";
        }
        $_SESSION['REMOTE_ADDR'] = $_SERVER["REMOTE_ADDR"];

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
        $_SESSION[self::LOGIN_WX]      = true;
        $_SESSION[self::LOGIN_INFO_WX] = $data;
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $_SESSION['HTTP_USER_AGENT'] = "Unknow";
        }
        $_SESSION['REMOTE_ADDR'] = $_SERVER["REMOTE_ADDR"];

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
        $_SESSION[self::LOGIN_MEMBER]      = false;
        $_SESSION[self::LOGIN_INFO_MEMBER] = null;

        //清空微信账号登录信息
        $_SESSION[self::LOGIN_WX]      = false;
        $_SESSION[self::LOGIN_INFO_WX] = null;

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
     * 判断当前用户是否登录 - 注册用户系统账号登录
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
            if (empty($_SESSION[self::LOGIN_MEMBER])) {
                $result["code"] = self::LOGIN_NO;
                $result["msg"]  = "没有登录！";
                return $result;
            }

            //系统账号-登录用户访问，返回用户信息
            if (!empty($_SESSION[self::LOGIN_INFO_MEMBER])) {
                $result["data"] = $_SESSION[self::LOGIN_INFO_MEMBER];
            }

        } catch (\Exception $e) {
            $result["code"] = "0";
            $result["msg"]  = $e->getMessage();
        }

        return $result;
    }

    /**
     * 判断当前用户是否登录 - 微信登录
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
            if (empty($_SESSION[self::LOGIN_WX])) {
                $result["code"] = self::LOGIN_NO;
                $result["msg"]  = "没有登录！";
                return $result;
            }

            //微信授权登录，用户访问，返回用户微信账号信息
            if (!empty($_SESSION[self::LOGIN_INFO_WX])) {
                $result["data"] = $_SESSION[self::LOGIN_INFO_WX];
            }

        } catch (\Exception $e) {
            $result["code"] = "0";
            $result["msg"]  = $e->getMessage();
        }

        return $result;
    }

    /**
     * 判断其他三方登录
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     * @return boolean
     */
    public function checkThirdLogin()
    {
        //如果用户来自微信客户端，
        if ($this->isFromWx() == true) {
            //调用微信登录
            $result = null;
            $wxLogin = self::auth()->checkLoginWx();
            if ($wxLogin['code'] == self::LOGIN_YES) {
                $result['third'] = $wxLogin["data"];
            }
            return $result;
        }

        return null;
    }

    /**
     * 判断当前用户来自微信客户端
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     * @return boolean
     */
    public function isFromWx()
    {
        if (strpos($_SERVER["HTTP_USER_AGENT"], "MicroMessenger") !== false /*&&
            /*strpos($_SERVER["HTTP_USER_AGENT"], "WindowsWechat") === false*/
        ) {
            return true;
        }
        return false;
    }

    /**
     * 获取用户登录信息
     * @author Chengcheng
     * @date 2016-10-20 15:50:00
     * @return boolean
     */
    public function getLoginInfo(){

        //1 获取用户信息
        $info['member']        = empty($_SESSION[self::LOGIN_INFO_MEMBER])? [] : $_SESSION[self::LOGIN_INFO_MEMBER];
        $info['memberWechat']  = empty($_SESSION[self::LOGIN_INFO_WX]) ? [] : $_SESSION[self::LOGIN_INFO_WX];
        $info['isMemberLogin'] = $_SESSION[self::LOGIN_MEMBER] ? 1 : 0;
        $info['isWxLogin']     = !empty($_SESSION[self::LOGIN_WX]) ? 1 : 0;

        //3 过滤掉openId,密码Passwd信息等
        unset($info['memberWechat']['wechatOpenId']);
        unset($info['member']['memberWechat']['mechatOpenId']);
        unset($info['member']['passwd']);

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
        if ($_SESSION[self::LOGIN_MEMBER] && (empty($loginType) || $loginType = self::LOGIN_INFO_MEMBER)) {

            //查找用户信息
            $memberId = $_SESSION[self::LOGIN_INFO_MEMBER]['id'];
            $data     = AdminMember::model()->getMemberInfo($memberId);

            //更新用户信息到session中
            $_SESSION[self::LOGIN_INFO_MEMBER] = $data;
        } else {
            $_SESSION[self::LOGIN_INFO_MEMBER] = null;
        }

        //2.更新微信账号信息
        if (!empty($_SESSION[self::LOGIN_WX]) && (empty($loginType) || $loginType = self::LOGIN_INFO_MEMBER)) {
            //查找微信用户信息
            $memberWechatId = $_SESSION[self::LOGIN_INFO_WX]['FId'];
            $data           = MemberWechat::getMemberWechatInfo($memberWechatId);

            //更新微信用户信息到session中
            $_SESSION[self::LOGIN_INFO_WX] = $data;
        } else {
            $_SESSION[self::LOGIN_INFO_WX] = null;
        }
    }
}