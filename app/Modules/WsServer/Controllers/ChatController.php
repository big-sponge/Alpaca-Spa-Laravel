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
use Illuminate\Support\Facades\Cache;

class ChatController extends BaseController
{

    const WS_GROUP_CHAT = 'WS_GROUP_CHAT';

    /**
     * 设置不需要登录的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noLogin()
    {
        return ['adminLogin', 'userLogin'];
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
            $isNeedLogin = false;
        }

        /* 2 检查用户是否已登录-系统账号登录 */
        $memberResult = Auth::auth()->checkLoginUserMember();
        if ($isNeedLogin == false || $memberResult['code'] == Auth::LOGIN_YES) {
            // 设置框架user信息，默认为unLogin
            Visitor::userMember()->load($memberResult['data']);
            return true;
        }

        /* 3 当前动作需要登录，返回 false,用户未登录，不容许访问 */
        $result["code"] = Code::USER_LOGIN_NULL;
        $result["msg"]  = Msg::USER_LOGIN_NULL;
        return $result;
    }

    /**
     * login - admin
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function adminLoginAction()
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
        Auth::auth()->loginUser($login['data']['member']);
        Visitor::userMember()->load($login['data']['member']);
        Visitor::userMember()->type = 'admin';

        //保存登录信息到gateway的session
        $member                = [];
        $member['id']          = Visitor::userMember()->id;
        $member['name']        = Visitor::userMember()->name;
        $member['type']        = Visitor::userMember()->type;
        $member['avatar']      = Visitor::userMember()->avatar;
        $_SESSION['ws_member'] = $member;

        //加入分组
        $_SESSION['ws_client_group'] = static::WS_GROUP_CHAT;
        WsSender::joinGroup($this->clientId, static::WS_GROUP_CHAT);

        //通知上线
        $this->notifyOnline();

        //返回结果
        $result         = [];
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data']['member'] = $member;
        return $result;
    }

    /**
     * login - user
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function userLoginAction()
    {
        //查询参数
        $param['token'] = $this->requestData['token'];
        $param['type']  = WsToken::MEMBER_TYPE_USER_WX;

        //验证token
        $login = TokenService::wsLogin($param);
        if ($login['code'] != Code::SYSTEM_OK) {
            return $login;
        }

        //保存登录信息
        Auth::auth()->loginUser($login['data']['member']);
        Visitor::userMember()->load($login['data']['member']);
        Visitor::userMember()->type = 'user_wx';

        //保存登录信息到gateway的session
        $member                = [];
        $member['id']          = Visitor::userMember()->id;
        $member['name']        = Visitor::userMember()->name;
        $member['type']        = Visitor::userMember()->type;
        $member['avatar']      = Visitor::userMember()->avatar;
        $_SESSION['ws_member'] = $member;

        //加入分组
        $_SESSION['ws_client_group'] = static::WS_GROUP_CHAT;
        WsSender::joinGroup($this->clientId, static::WS_GROUP_CHAT);

        //通知上线
        $this->notifyOnline();

        //返回结果
        $result                   = [];
        $result['code']           = Code::SYSTEM_OK;
        $result['msg']            = Msg::SYSTEM_OK;
        $result['data']['member'] = $member;
        return $result;
    }

    /**
     * 收到客户端发送来的消息 - 发送给所有在线人员
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function sendAction()
    {
        //通知上线
        $this->notifyMsg();

        //返回结果
        $result         = [];
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        return $result;
    }

    /**
     * 获取在线人员
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function onlineAction()
    {
        $sessions       = WsSender::getAllClientSessions(static::WS_GROUP_CHAT);
        $result         = [];
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = array_column($sessions, 'ws_member');
        return $result;
    }

    /**
     * 人员下线
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function offlineAction()
    {
        //通知上线
        $this->notifyOffline();

        $result         = [];
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        return $result;
    }

    /**
     * 通知上线
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function notifyOnline()
    {
        //上线人信息
        $member           = [];
        $member['id']     = Visitor::userMember()->id;
        $member['name']   = Visitor::userMember()->name;
        $member['type']   = Visitor::userMember()->type;
        $member['avatar'] = Visitor::userMember()->avatar;

        //返回结果
        $data                   = [];
        $data['action']         = 'chat/notifyOnline';
        $data["code"]           = Code::SYSTEM_OK;
        $data["msg"]            = Msg::SYSTEM_OK;
        $data["data"]['member'] = $member;
        WsSender::sendToGroup(static::WS_GROUP_CHAT, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 通知下线
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function notifyOffline()
    {
        //上线人信息
        $member           = [];
        $member['id']     = Visitor::userMember()->id;
        $member['name']   = Visitor::userMember()->name;
        $member['type']   = Visitor::userMember()->type;
        $member['avatar'] = Visitor::userMember()->avatar;

        //返回结果
        $data                   = [];
        $data['action']         = 'chat/notifyOffline';
        $data["code"]           = Code::SYSTEM_OK;
        $data["msg"]            = Msg::SYSTEM_OK;
        $data["data"]['member'] = $member;
        WsSender::sendToGroup(static::WS_GROUP_CHAT, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 通知新消息
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function notifyMsg()
    {
        //发送人信息
        $member           = [];
        $member['id']     = Visitor::userMember()->id;
        $member['name']   = Visitor::userMember()->name;
        $member['type']   = Visitor::userMember()->type;
        $member['avatar'] = Visitor::userMember()->avatar;

        //发送内容
        $data                   = [];
        $data['action']         = 'chat/notifyMsg';
        $data["code"]           = Code::SYSTEM_OK;
        $data["msg"]            = Msg::SYSTEM_OK;
        $data["data"]['member'] = $member;
        $data["data"]['msg']    = $this->requestData['msg'];
        $data["data"]['time']   = Visitor::userMember()->time;
        WsSender::sendToGroup(static::WS_GROUP_CHAT, json_encode($data, JSON_UNESCAPED_UNICODE));
    }
}
