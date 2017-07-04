<?php

namespace Crontab\Common;
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
    const SYSTEM_ERROR                  = 9999;    //系统错误

    const USER_LOGIN_NULL           = 112;     //用户没有登录
}
