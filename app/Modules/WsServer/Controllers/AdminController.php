<?php

namespace App\Modules\WsServer\Controllers;

use App\Common\Code;
use App\Common\Msg;
use App\Common\Visitor;
use App\Models\AdminMember;
use App\Models\ShakeActivity;
use App\Models\ShakeItem;
use App\Models\WsToken;
use App\Modules\WsServer\Auth\Auth;
use App\Modules\WsServer\Controllers\Base\BaseController;
use App\Modules\WsServer\Service\TokenService;
use GatewayWorker\Lib\Gateway as WsSender;
use Illuminate\Support\Facades\Cache;

class AdminController extends BaseController
{
    const WS_GROUP_ADMIN = 'SHAKE_ITEM_ADMIN_';

    const WS_ITEM_DOING = 'WS_ITEM_DOING_';

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
            $isNeedLogin = false;
        }

        /* 2 检查用户是否已登录-系统账号登录 */
        $memberResult = Auth::auth()->checkLoginAdminMember();
        if ($isNeedLogin == false || $memberResult['code'] == Auth::LOGIN_YES) {
            // 设置框架user信息，默认为unLogin
            Visitor::adminMember()->load($memberResult['data']);
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

    /**
     * getShakeActivity
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function getShakeActivityAction()
    {
        //获取参数
        $activityId = $this->requestData['activity_id'];
        $memberId   = Visitor::adminMember()->id;

        //验证参数
        if (empty($activityId)) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'activity_id');
            return $result;
        }

        //获取活动信息
        $activity = ShakeActivity::model()->findById($activityId);
        if (empty($activity)) {
            $result["code"] = Code::SYSTEM_ERROR;
            $result["msg"]  = "activity 不存在";
            return $result;
        }

        //获取当前轮次信息
        $item = ShakeItem::model()->curForAdmin($activityId);

        //绑定分组
        WsSender::joinGroup($this->clientId, static::WS_GROUP_ADMIN . $item->id);

        //返回结果
        $result["code"]             = Code::SYSTEM_OK;
        $result["msg"]              = Msg::SYSTEM_OK;
        $result["data"]['activity'] = $activity;
        $result["data"]['item']     = $item;
        return $result;
    }

    /**
     * preStartItem - 倒数计时开始
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function preStartItemAction()
    {
        // 获取参数,活动项目id:itemId, 次数:shakeLimit,中奖人数:winLimit
        $data['id']          = $this->requestData['itemId'];
        $data['shake_limit'] = $this->requestData['shakeLimit'];
        $data['win_limit']   = $this->requestData['winLimit'];

        //编辑
        ShakeItem::model()->edit($data);

        //通知客户端 - 开始倒计时
        if ($data['id']) {
            $param           = [];
            $param['action'] = 'server/shake_pre_start';
            $param["code"]   = Code::SYSTEM_OK;
            $param["msg"]    = Msg::SYSTEM_OK;
            WsSender::sendToGroup(ServerController::WS_GROUP_CLIENT . $data['id'], json_encode($param, JSON_UNESCAPED_UNICODE));
        }

        //返回
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        return $result;
    }

    /**
     * startItem - 游戏开始
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function startItemAction()
    {
        // 获取参数,活动项目id:itemId
        $data['id'] = $this->requestData['itemId'];

        //通知客户端 - 开始倒计时
        if ($data['id']) {
            $item = ShakeItem::model()->where('id', $data['id'])->first();
            Cache::add(static::WS_ITEM_DOING . $data['id'], $item->shake_limit, 30);

            $param           = [];
            $param['action'] = 'server/shake_start';
            $param["code"]   = Code::SYSTEM_OK;
            $param["msg"]    = Msg::SYSTEM_OK;
            WsSender::sendToGroup(ServerController::WS_GROUP_CLIENT . $data['id'], json_encode($param, JSON_UNESCAPED_UNICODE));
        }

        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        return $result;
    }

    /**
     * stopItem - 游戏结束
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function stopItemAction()
    {
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        return $result;
    }

    /**
     * stopItem - 获取在线人员
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return  array
     */
    public function getItemUsersAction()
    {
        $itemId   = $this->requestData['item_id'];
        $sessions = WsSender::getClientSessionsByGroup(ServerController::WS_GROUP_CLIENT . $itemId);
        $dataList = [];
        foreach ($sessions as $s) {
            $data           = [];
            $data['id']     = $s['WX_INFO']['id'];
            $data['avatar'] = $s['WX_INFO']['avatar'];
            $data['name']   = $s['WX_INFO']['name'];
            array_push($dataList, $data);
        }
        $result["code"]         = Code::SYSTEM_OK;
        $result["msg"]          = Msg::SYSTEM_OK;
        $result["data"]['list'] = $dataList;
        return $result;
    }

}
