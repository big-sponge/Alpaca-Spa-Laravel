<?php

namespace App\Common;
/**
 * Code
 * @author Chengcheng
 * @date 2016-10-20 15:50:00
 */
class Code
{
    /**
     * 系统 99
     */
    const SYSTEM_OK                     = 9900;    //正确返回
    const SYSTEM_ACTION_NOT_FOUND       = 9901;    //ACTION没有找到
    const SYSTEM_CONTROLLER_NOT_FOUND   = 9902;    //CONTROLLER没有找到
    const SYSTEM_OK_WITH_NO_DATA        = 9903;    //正确返回, 但数据未找到
    const SYSTEM_KO                     = 9904;    //操作失败
    const SYSTEM_PARAMETER_NULL         = 9905;    //请求参数为空
    const SYSTEM_PARAMETER_FORMAT_ERROR = 9906;    //请求参数格式错误
    const SYSTEM_ERROR_FIND_NULL        = 9907;    //数据未找到
    const SYSTEM_ERROR_USER_DENY        = 9908;    //当前用户没有操作权限
    const SYSTEM_IMAGE_OVER_SIZE        = 9909;    //上传图片尺寸超出最大值
    const SYSTEM_NOT_ENOUGH             = 9910;    //条件不足
    const SYSTEM_ERROR                  = 9999;    //系统错误

    /**
     * 用户 1
     */
    const USER                      = 100;     //用户
    const USER_MOBILE_EXIT          = 101;     //手机号码已经注册
    const USER_MOBILE_ERROR         = 102;     //手机号码不存在
    const USER_PASSWORD_ERROR       = 103;     //密码不正确
    const USER_LOGIN_OK             = 104;     //登录成功
    const USER_REGISTER_OK          = 105;     //注册成功
    const USER_LOGOUT_OK            = 106;     //注销成功
    const USER_GET_INFO_OK          = 107;     //获取用户信息成功
    const USER_GET_INFO_NULL        = 108;     //没有找到用户信息
    const USER_MOBILE_FORMAT_ERROR  = 109;     //手机号码格式不正确
    const USER_MOBILE_FORMAT_NULL   = 110;     //手机号不能为空
    const USER_PASSWORD_FORMAT_NULL = 111;     //密码不能为空
    const USER_LOGIN_NULL           = 112;     //用户没有登录
    const USER_AUTH_CODE_ERROR      = 113;     //手机验证码错误
    const USER_AUTH_CODE_OVERTIME   = 114;     //手机验证码超时
    const USER_AUTH_CODE_NULL       = 115;     //手机验证码为空
    const USER_CORPORATION_OK       = 116;     //获取用户所属福利企业成功
    const USER_CORPORATION_NULL     = 117;     //用户所属福利企业成功为空
    const USER_AUTH_CODE_SEND_ERROR = 118;     //发送验证码失败
    const USER_NOT_IN_CORP          = 119;     //用户不属于指定福利企业
    const WX_LOGIN_OPENID_NULL      = 120;     //用户没有登录，用户来自微信客户端，可以使用微信登录
    const WX_LOGIN_USER_NULL        = 121;     //微信已经授权登录，但是没有注册、或者绑定系统账号！
    const WX_LOGIN_USER_ERROR       = 122;     //系统错误没有找到，微信绑定的系统用户，检查系统用户是否可用！
    const WX_LOGIN_USER_OK          = 123;     //找到微信用户绑定的系统账号！
    const WX_MEMBER_BIND_NO         = 124;     //微信账号未绑定系统账号（未绑定）;
    const WX_MEMBER_BIND_YES        = 125;     //微信账号已经绑定系统账号（已绑定）;
    const WX_LOGIN_FIRST_USER_NULL  = 126;     //微信用户首次访问系统，还没有注册、或者绑定系统账号;
    const WX_MEMBER_NULL            = 127;     //没有找到系统账号信息;
    const WX_NOT_FROM_WX            = 128;     //请从微信客户端访问;
    const WX_LOGIN_NULL             = 129;     //微信账号未登录';
    const WX_BIND_OTHER             = 130;     //当前的登录微信账号已经绑定其他账号，请注销微信登录，或者解除绑定其他账号，';
    const USER_LOGIN_EXIST          = 131;     //当前系统已经有系统账号登录，请注销后再登录';
    const WX_MEMBER_WECHAT_NULL     = 132;     //没有找到微信账号信息;
    const WX_BIND_LOGIN_EXIST       = 133;     //当前系统已经有系统账号登录，请注销后再绑定';
    const USER_LOGIN_ERROR          = 134;     //用户名或者密码错误';
    const USER_EMAIL_EXIT           = 135;     //E-MAIL已经注册
    const USER_EMAIL_ERROR          = 136;     //E-MAIL不存在
    const USER_EMAIL_CODE_ERROR     = 137;     //E-MAIL验证码错误
    const USER_EMAIL_CODE_OVERTIME  = 138;     //E-MAIL验证码超时
    const USER_POWER_ERROR          = 139;     //用户没aa有权限
    const DEPART_NAME_EXIT          = 140;     //部门名已经注册

    /**
     *  分组2
     */
    const GROUP           = 200;     //分组
    const GROUP_NAME_EXIT = 201;     //分组已经存在

    /**
     * 工作信息3
     */
    const  JT                = 300;   //'';
    const  JT_NO_WORK_DAY    = 301;   //'不是工作日';
    const  JT_NO_LESS_MEMBER = 302;   //'人数不足';
    const  JT_NO_EXIST       = 303;   //'当前日期已经排班';

}
