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

class OcrController extends BaseController
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
        return ['adminLogin', 'userLogin','setDeviceId'];
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
     * 人员下线
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function setDeviceIdAction()
    {
        //通知上线
        $deviceId = $this->requestData['device_id'];
        if($deviceId){
            WsSender::joinGroup($this->clientId, 'ocr_'.$deviceId);
        }

        $result         = [];
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        return $result;
    }
}
