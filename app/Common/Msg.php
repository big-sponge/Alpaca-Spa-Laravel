<?php

namespace App\Common;

/**
 * Msg
 * @author Chengcheng
 * @date 2016-10-20 15:50:00
 */
class Msg
{
    /**
     * 系统 99
     */
    const SYSTEM_OK                     = '正确返回';
    const SYSTEM_OK_WITH_NO_MORE_DATA   = '未找到更多数据';
    const SYSTEM_OK_WITH_NO_DATA        = '数据未找到';
    const SYSTEM_KO                     = '操作失败，请重试';
    const SYSTEM_ACTION_NOT_FOUND       = 'Action没有找到:[%s0]';
    const SYSTEM_CONTROLLER_NOT_FOUND   = 'Controller没有找到';
    const SYSTEM_PARAMETER_NULL         = '请求参数:[%s]不能为空';
    const SYSTEM_PARAMETER_FORMAT_ERROR = '请求参数:[%s]格式错误';
    const SYSTEM_ERROR_FIND_NULL        = '没有找到要修改或者删除的数据';
    const SYSTEM_ERROR_USER_DENY        = '当前用户没有操作权限';
    const SYSTEM_IMAGE_OVER_SIZE        = '上传图片尺寸超出最大值[%s]';
    const SYSTEM_ERROR                  = '系统错误';

    /**
     * 用户 1
     */
    const USER                      = '用户';
    const USER_MOBILE_EXIT          = '手机号码已经注册';
    const USER_MOBILE_ERROR         = '手机号码不存在';
    const USER_PASSWORD_ERROR       = '密码不正确';
    const USER_LOGIN_OK             = '登录成功';
    const USER_REGISTER_OK          = '注册成功';
    const USER_LOGOUT_OK            = '注销成功';
    const USER_GET_INFO_OK          = '获取用户信息成功';
    const USER_GET_INFO_NULL        = '没有找到用户信息';
    const USER_MOBILE_FORMAT_ERROR  = '手机号码格式不正确';
    const USER_MOBILE_FORMAT_NULL   = '手机号不能为空';
    const USER_PASSWORD_FORMAT_NULL = '密码不能为空';
    const USER_LOGIN_NULL           = '用户没有登录';
    const USER_AUTH_CODE_ERROR      = '手机验证码错误';
    const USER_AUTH_CODE_OVERTIME   = '手机验证码超时';
    const USER_AUTH_CODE_NULL       = '手机验证码为空';
    const USER_CORPORATION_OK       = '获取用户所属福利企业成功';
    const USER_CORPORATION_NULL     = '用户所属福利企业成功为空';
    const USER_AUTH_CODE_SEND_ERROR = '发送验证码失败,请联系系统管理员';
    const USER_NOT_IN_CORP          = '用户不属于指定福利企业，ID:[%s0]';
    const WX_LOGIN_OPENID_NULL      = '没有获取到用户的openId';
    const WX_LOGIN_USER_NULL        = '微信账号登录成功，但是用户没有注册或者绑定系统账号';
    const WX_LOGIN_USER_ERROR       = '微信账号登录成功，但是获取系统账号时发生系统错误，请检查系统账号状态';
    const WX_LOGIN_USER_OK          = '微信账号登录成功，并且通过openId找到了微信用户绑定的系统账号';
    const WX_MEMBER_BIND_NO         = '微信账号绑定系统账号（未绑定）';
    const WX_MEMBER_BIND_YES        = '微信账号绑定系统账号（已绑定）';
    const WX_LOGIN_FIRST_USER_NULL  = '微信用户首次访问系统，还没有注册、或者绑定系统账号';
    const WX_MEMBER_NULL            = '没有找到系统账号信息';
    const WX_NOT_FROM_WX            = '请从微信客户端访问';
    const WX_LOGIN_NULL             = '微信账号未登录';
    const WX_BIND_OTHER             = '当前的登录微信账号已经绑定其他账号，请注销微信登录，或者解除绑定其他账号，';
    const USER_LOGIN_EXIST          = '您已经试用其他账号登录了系统，已经为您注销，请重新登录';
    const WX_MEMBER_WECHAT_NULL     = '没有找到微信账号信息';
    const WX_BIND_LOGIN_EXIST       = '当前系统已经有系统账号登录，请注销后再绑定';
    const USER_LOGIN_ERROR          = '用户名或者密码错误';
    const USER_EMAIL_EXIT           = 'E-MAIL已经注册';
    const USER_EMAIL_ERROR          = 'E-MAIL不存在';
    const USER_EMAIL_CODE_ERROR     = 'E-MAIL验证码错误';
    const USER_EMAIL_CODE_OVERTIME  = 'E-MAIL验证码超时';
    const USER_POWER_ERROR          = '用户没有权限';
    const DEPART_NAME_EXIT          = '部门已经存在';
    /**
     * 分组2
     */
    const GROUP           = '用户';
    const GROUP_NAME_EXIT = '分组已经存在';
    /**
     * 工作信息3
     */
    const WORKER           = '工作信息';
    const WORKER_INFO_EXIT = '所选用户已经添加了员工信息';

    /**
     * 报名信息
     */
    const SIGN_FIND_NULL   = '没有找到报名信息';
    const SIGN_NOT_BEGIN   = '报名时间没有开始';
    const SIGN_END         = '报名时间已经结束';
    const SIGN_BOT_PUBLISH = '报名没有发布';
    const SIGN_SUBMIT_OK   = '报名成功';

}
