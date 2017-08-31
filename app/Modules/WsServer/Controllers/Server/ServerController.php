<?php

namespace App\Modules\WsServer\Controllers\Server;

use App\Common\Code;
use App\Common\Msg;
use App\Common\Visitor;
use App\Models\AdminMember;
use App\Models\ShakeActivity;
use App\Models\ShakeItem;
use App\Models\ShakeRecord;
use App\Models\WsToken;
use App\Modules\WsServer\Auth\Auth;
use App\Modules\WsServer\Controllers\Base\BaseController;
use App\Modules\WsServer\Service\TokenService;
use GatewayWorker\Lib\Gateway as WsSender;
use Illuminate\Support\Facades\Cache;

class ServerController extends BaseController
{
    const WS_GROUP_CLIENT = 'SHAKE_ITEM_CLIENT_';

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
        $memberResult = Auth::auth()->checkLoginWx();
        if ($isNeedLogin == false || $memberResult['code'] == Auth::LOGIN_YES) {
            // 设置框架user信息，默认为unLogin
            Visitor::userWx()->load($memberResult['data']);
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
        $param['type']  = WsToken::MEMBER_TYPE_USER_WX;

        //验证token
        $login = TokenService::wsLogin($param);
        if ($login['code'] != Code::SYSTEM_OK) {
            return $login;
        }

        //保存登录信息
        Auth::auth()->loginWx($login['data']['member']);

        //返回结果
        $result         = [];
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = Auth::auth()->getWxInfo();
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
        $memberId   = Visitor::userWx()->id;

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
        $item = ShakeItem::model()->cur($activityId);

        //绑定分组
        if ($item) {
            WsSender::joinGroup($this->clientId, static::WS_GROUP_CLIENT . $item->id);

            //保存摇一摇信息
            $myItem                   = [];
            $myItem['id']             = $item->id;
            $myItem['my_shake_count'] = 0;
            $_SESSION['shake_item']   = $myItem;

            //通知服务端口
            $data                   = [];
            $data['action']         = 'admin/user_join';
            $data["code"]           = Code::SYSTEM_OK;
            $data["msg"]            = Msg::SYSTEM_OK;
            $data["data"]['member'] = Visitor::userWx()->toArray();
            WsSender::sendToGroup(AdminController::WS_GROUP_ADMIN . $item->id, json_encode($data, JSON_UNESCAPED_UNICODE));
        }

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

        ShakeItem::model()->edit($data);

        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        return $result;
    }

    /**
     * stopItem - 上传摇一摇次数
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function shakeUpAction()
    {
        //获取输入参数
        $myItem = $_SESSION['shake_item'];

        //没有找到活动信息
        if (!$myItem) {
            $result["code"] = Code::SYSTEM_OK;
            $result["msg"]  = Msg::SYSTEM_OK;
            return $result;
        }

        $shakeLimit = Cache::get(AdminController::WS_ITEM_DOING . $myItem['id']);
        if (!$shakeLimit) {
            //返回结果
            $result["code"] = Code::SYSTEM_OK;
            $result["msg"]  = Msg::SYSTEM_OK;
            return $result;
        }

        //更新次数
        $total = $myItem['my_shake_count'] + 1;
        if ($total > $shakeLimit) {
            $total = $shakeLimit;
        }

        //达到次数 - 活动结束
        if ($total == $shakeLimit) {
            $_SESSION['shake_item']['my_shake_count'] = $total;
            $this->shakeUpToAdmin($myItem['id']);

            Cache::forget(AdminController::WS_ITEM_DOING . $myItem['id']);

            $this->shakeEnd($myItem['id']);
            //返回结果
            $result["code"] = Code::SYSTEM_OK;
            $result["msg"]  = Msg::SYSTEM_OK;
            return $result;
        }

        //没有达到次数
        if ($total < $shakeLimit) {
            $_SESSION['shake_item']['my_shake_count'] = $total;
            $this->shakeUpToAdmin($myItem['id']);
        }

        //返回结果
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        return $result;
    }

    /**
     * stopItem - 游戏结果
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function shakeResultAction()
    {
        //获取输入参数
        $userId = Visitor::userWx()->id;
        $itemId = $this->requestData['item_id'];

        //获取结果
        $record = ShakeRecord::model()->where('user_id', $userId)->where('item_id', $itemId)->first();
        $item   = ShakeItem::model()->where('id', $itemId)->first();

        $_SESSION['shake_item'] = null;
        //返回结果
        $result["code"]           = Code::SYSTEM_OK;
        $result["msg"]            = Msg::SYSTEM_OK;
        $result["data"]['record'] = $record;
        $result["data"]['item']  = $item;
        return $result;
    }

    /**
     * stopItem - 发送实时数据到大屏幕
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @param $itemId
     */
    protected function shakeUpToAdmin($itemId)
    {
        //发送到admin-检查是否正在发送
        $key     = 'is_doing_shake_up_' . $itemId;
        $isDoing = Cache::get($key . $itemId);
        if ($isDoing) {
            return;
        }
        Cache::add($key, 'doing', 10);

        $sessions = WsSender::getClientSessionsByGroup(static::WS_GROUP_CLIENT . $itemId);
        $dataList = [];
        foreach ($sessions as $s) {
            $data                = [];
            $data['id']          = $s['WX_INFO']['id'];
            $data['avatar']      = $s['WX_INFO']['avatar'];
            $data['name']        = $s['WX_INFO']['name'];
            $data['shake_count'] = $s['shake_item']['my_shake_count'];
            array_push($dataList, $data);
        }

        array_multisort(array_column($dataList, 'shake_count'), SORT_DESC, $dataList);

        //通知服务端口
        $data           = [];
        $data['action'] = 'admin/user_shake_up';
        $data["code"]   = Code::SYSTEM_OK;
        $data["msg"]    = Msg::SYSTEM_OK;
        $data["data"]   = $dataList;
        WsSender::sendToGroup(AdminController::WS_GROUP_ADMIN . $itemId, json_encode($data, JSON_UNESCAPED_UNICODE));
        Cache::forget($key);
    }

    /**
     * stopItem - 游戏结束
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @param $itemId
     */
    protected function shakeEnd($itemId)
    {

        //通知客户端
        $data           = [];
        $data['action'] = 'server/shake_end';
        $data["code"]   = Code::SYSTEM_OK;
        $data["msg"]    = Msg::SYSTEM_OK;
        WsSender::sendToGroup(ServerController::WS_GROUP_CLIENT . $itemId, json_encode($data, JSON_UNESCAPED_UNICODE));

        //通知服务端口
        $sessions = WsSender::getClientSessionsByGroup(static::WS_GROUP_CLIENT . $itemId);

        $dataList = [];
        foreach ($sessions as $index => $s) {
            $data                = [];
            $data['id']          = $s['WX_INFO']['id'];
            $data['avatar']      = $s['WX_INFO']['avatar'];
            $data['name']        = $s['WX_INFO']['name'];
            $data['shake_count'] = $s['shake_item']['my_shake_count'];
            array_push($dataList, $data);

            echo $index;
            WsSender::leaveGroup($index,static::WS_GROUP_CLIENT . $itemId);
        }

        array_multisort(array_column($dataList, 'shake_count'), SORT_DESC, $dataList);

        $item = ShakeItem::model()->where('id', $itemId)->first();
        foreach ($dataList as $index => &$value) {

            $data                = new ShakeRecord();
            $data->activity_id   = $item->activity_id;
            $data->item_id       = $item->id;
            $data->item_index    = $item->item_index;
            $data->user_id       = $value['id'];
            $data->nickname      = $value['name'];
            $data->avatar        = $value['avatar'];
            $data->shake_count   = $value['shake_count'];
            $data->user_rank     = $index + 1;
            $data->ticket_status = ShakeRecord::TICKET_STATUS_NONE;
            if ($data->user_rank <= $item->win_limit) {
                $data->ticket_status = ShakeRecord::TICKET_STATUS_UNUSED;
            }
            $value['ticket_status'] = $data->ticket_status;
            $data->record();
        }

        $data           = [];
        $data['action'] = 'admin/shake_end';
        $data["code"]   = Code::SYSTEM_OK;
        $data["msg"]    = Msg::SYSTEM_OK;
        $data["data"]   = $dataList;
        WsSender::sendToGroup(AdminController::WS_GROUP_ADMIN . $itemId, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

}
