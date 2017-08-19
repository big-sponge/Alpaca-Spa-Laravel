<?php

namespace App\Modules\WsServer\Controllers;

use App\Common\Code;
use App\Common\Msg;
use App\Common\Visitor;
use App\Models\AdminMember;
use App\Models\WsToken;
use App\Modules\WsServer\Auth\Auth;
use App\Modules\WsServer\Controllers\Base\BaseController;
use App\Modules\WsServer\Service\TokenService;
use GatewayWorker\Lib\Gateway as WsSender;

class AdminController extends BaseController
{
    /**
     * 设置不需要登录的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noLogin()
    {
        return ['login'];
    }

    /**
     * 登录验证
     * @author Chengcheng
     * @date 2016年10月21日 17:04:44
     * @param string $actionID
     * @return bool
     * */
    protected function auth($actionID)
    {
        /* 1 判断Action动作是否需要登录，默认需要登录 */
        $isNeedLogin = true;
        $noLogin     = $this->noLogin();
        $noLogin     = !empty($noLogin) ? $noLogin : [];
        if (in_array($actionID, $noLogin) || $this->isNoLogin) {
            //不需要登录
            $isNeedLogin = false;
        }

        /* 2 检查用户是否已登录-系统账号登录 */
        $memberResult = Auth::auth()->checkLoginAdminMember();
        if ($isNeedLogin == false || $memberResult['code'] == Auth::LOGIN_YES) {
            // 设置框架user信息，默认为unLogin
            Visitor::adminMember()->load($memberResult['data']);
            //返回结果，容许访问
            return true;
        }

        /* 3 当前动作需要登录，返回 false,用户未登录，不容许访问 */
        $result["code"] = Code::USER_LOGIN_NULL;
        $result["msg"]  = Msg::USER_LOGIN_NULL;
        return $result;
    }

    /**
     * index
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function indexAction()
    {
        $result         = [];
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = AdminMember::model()->get()->toArray();

        WsSender::sendToCurrentClient($this->toJson($result));
    }

    /**
     * login
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function loginAction()
    {
        //查询参数
        $param['token'] = $this->requestData['token'];
        $param['type']  = WsToken::MEMBER_TYPE_ADMIN;

        //验证token
        $login = TokenService::wsLogin($param);
        if ($login['code'] != Code::SYSTEM_OK) {
            return $login;
        }

        //保存登录信息
        Auth::auth()->loginAdmin($login['data']['member']);

        //返回结果
        $result         = [];
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        return $result;
    }

    /**
     * test
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function testAction()
    {
        $result         = [];
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = Visitor::adminMember()->toArray();
        return $result;
    }
}
