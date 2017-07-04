<?php

namespace Crontab\Common;

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

    const USER_LOGIN_NULL           = '用户没有登录';
}
