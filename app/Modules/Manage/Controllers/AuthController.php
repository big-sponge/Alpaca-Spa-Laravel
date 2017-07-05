<?php
namespace App\Modules\Manage\Controllers;

use App\Modules\Manage\Controllers\Base\BaseController;
use App\Common\Code;
use App\Common\Msg;
use App\Modules\Manage\Auth\Auth;
use App\Common\Lib\Validate;
use App\Modules\Manage\Service\EmailService;

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
    protected function withoutLoginActions()
    {
        return [
            'loginByEmail',
            'logout',
        ];
    }

    /**
     * 设置不需要权限的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function withoutAuthActions()
    {
        return [
            'loginByEmail',
            'logout',
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
        //0 判断是否已经有账号登录，
        if (!empty($_SESSION[Auth::LOGIN_MEMBER])) {
            //注销当前账号
            Auth::auth()->logClear();
        }

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

        //3 检查其他三方登录
        $thirdLogin = Auth::auth()->checkThirdLogin();

        //4 系统账号登录
        $memberLogin = EmailService::loginEmail($this->requestData);

        //5 判断登录结果

        /* 5.1 系统账号登录失败*/
        if ($memberLogin['code'] != Code::SYSTEM_OK) {
            $result["code"] = $memberLogin['code'];
            $result["msg"]  = $memberLogin['msg'];
            return $this->ajaxReturn($result);
        }

        /* 5.2 系统账号登录【成功】并且【没有第三方登录信息】,或者三方登录中的，用户信息与系统账号【一致】,*/
        if (empty($thirdLogin['third']) || $thirdLogin['third']['member_id'] == $memberLogin['data']['id']) {
            //登录成功，保存系统账号的登录信息
            Auth::auth()->login($memberLogin['data']);
            $result["code"] = Code::SYSTEM_OK;
            $result["msg"]  = Msg::USER_LOGIN_OK;
            return $this->ajaxReturn($result);
        }

        // 5.3  三方账号没有绑定系统账号，
        if (empty($thirdLogin['third']['member'])) {
            //登录成功，提示用户可以绑定三方账号
            Auth::auth()->login($memberLogin['data']);
            $result["code"]           = Code::SYSTEM_OK;
            $result["msg"]            = Msg::USER_LOGIN_OK;
            $result["data"]['exCode'] = Code::WX_MEMBER_BIND_NO;
            $result["data"]['exMsg']  = '微信账号与系统账号未绑定,推荐绑定';
            return $this->ajaxReturn($result);
        }

        // 5.4  三方登录中账号信息与系统账号登录信息【不一致】，并且不为空，【说明已绑定其他账号】，
        if (!empty($thirdLogin['third']['member'])) {
            //登录失败
            $result["code"] = Code::WX_BIND_OTHER;
            $result["msg"]  = Msg::WX_BIND_OTHER;
            return $this->ajaxReturn($result);
        }

        //6 返回结果
        $result["code"] = Code::SYSTEM_ERROR;
        $result["msg"]  = Msg::SYSTEM_ERROR;
        return $this->ajaxReturn($result);
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
        $this->requestData['member_id'] = $this->requestData['visitUser']['member']['id'];

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
}