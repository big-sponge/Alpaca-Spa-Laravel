<?php
namespace App\Modules\Manage\Controllers;

use App\Common\Visitor;
use App\Common\Wechat\WeChat;
use App\Models\WsToken;
use App\Modules\Manage\Controllers\Base\BaseController;
use App\Common\Code;
use App\Common\Msg;
use App\Modules\Manage\Auth\Auth;
use App\Common\Lib\Validate;
use App\Modules\Manage\Service\EmailService;
use Console\Commands\WsServer;

/**
 * 权限控制器
 * @author Chengcheng
 * @date 2016年10月21日 17:04:44
 */
class AuthController extends BaseController
{

    /**
     * 设置不需要登录的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noLogin()
    {
        return [
            'loginByEmail',
            'logout',
            'wxLogin',
        ];
    }

    /**
     * 设置不需要权限的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noAuth()
    {
        return [
            'loginByEmail',
            'logout',
            'wxLogin',
            'getWsToken',
        ];
    }

    /**
     * 用户登录
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function loginByEmail()
    {

        //1 获取输入参数,email 手机号码,passwd 密码
        $this->requestData['email']  = $this->input('email', '');
        $this->requestData['passwd'] = $this->input('passwd', '');

        //2.1 验证手机号码是否为空
        if (empty($this->requestData['email'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'email');
            return $this->ajaxReturn($result);
        }

        //2.2 验证手机号码格式
        if (!Validate::isEmail($this->requestData['email'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_FORMAT_ERROR;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_FORMAT_ERROR, 'email');
            return $this->ajaxReturn($result);
        }

        //2.3 验证密码
        if (empty($this->requestData['passwd'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'passwd');
            return $this->ajaxReturn($result);
        }

        //3 系统账号登录
        $memberLogin = EmailService::loginEmail($this->requestData);

        //4 登录失败
        if ($memberLogin['code'] != Code::SYSTEM_OK) {
            $result["code"] = Code::SYSTEM_OK;
            $result["msg"]  = Msg::USER_LOGIN_OK;
            return $result;
        }

        //5 登录成功，保存信息到session
        Auth::auth()->loginMember($memberLogin['data']);

        //6 返回结果
        return $this->ajaxReturn($memberLogin);
    }

    /**
     * 用户注销
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function logout()
    {
        //注销，清除session
        Auth::auth()->logout();
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::USER_LOGOUT_OK;
        return $this->ajaxReturn($result);
    }

    /**
     * 重置密码 - 通过原来的密码
     * @author Chengcheng
     */
    public function resetPwdByOld()
    {
        //1 获取输入参数,email 邮箱,passwd 用户密码，token 手机验证码，
        $this->requestData['old_passwd'] = $this->input('oldPasswd', '');
        $this->requestData['new_passwd'] = $this->input('newPasswd', '');
        $this->requestData['member_id']  = Visitor::adminMember()->id;

        //2.1 验证FEmail是否为空
        if (empty($this->requestData['old_passwd'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'old_passwd');
            return $this->ajaxReturn($result);
        }
        if (empty($this->requestData['new_passwd'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'new_passwd');
            return $this->ajaxReturn($result);
        }

        //3 重置密码
        $result = EmailService::resetPasswordByOld($this->requestData);

        //4 返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 获取用户信息
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function info()
    {
        //更新用户信息（读取数据库）
        Auth::auth()->updateLoginInfo();
        // 返回结果
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        $result["data"] = Auth::auth()->getLoginInfo();
        return $this->ajaxReturn($result);
    }

    /**
     * 获取token
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function getWsToken()
    {
        //获取参数
        $memberId = Visitor::adminMember()->id;

        //生成token
        $token = WsToken::model()->generate($memberId, WsToken::MEMBER_TYPE_ADMIN);

        //返回结果
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        $result["data"] = $token;
        return $this->ajaxReturn($result);
    }

}