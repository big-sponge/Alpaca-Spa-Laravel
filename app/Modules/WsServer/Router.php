<?php

namespace App\Modules\WsServer;

use App\Common\Code;
use App\Modules\WsServer\Controllers\AdminController;
use App\Modules\WsServer\Controllers\IndexController;

use App\Modules\WsServer\Controllers\ServerController;
use GatewayWorker\Lib\Gateway as WsSender;

class Router
{
    //初始化
    static public function init($client_id, $message)
    {
        //格式化输入
        $message = json_decode($message, true);
        $action  = $message['action'];
        $data    = $message['data'];

        //路由
        switch ($action) {
            case 'admin/login':
                /*登录*/
                $result = AdminController::model($client_id, $data)->login();
                break;
            case 'admin/shake_activity':
                /*获取活动信息*/
                $result = AdminController::model($client_id, $data)->getShakeActivity();
                break;
            case 'admin/shake_pre_start':
                /*倒计时开始*/
                $result = AdminController::model($client_id, $data)->preStartItem();
                break;
            case 'admin/shake_start':
                /*开始*/
                $result = AdminController::model($client_id, $data)->startItem();
                break;
            case 'admin/shake_stop':
                /*结束*/
                $result = AdminController::model($client_id, $data)->stopItem();
                break;
            case 'admin/shake_users':
                /*结束*/
                $result = AdminController::model($client_id, $data)->getItemUsers();
                break;
            case 'server/login':
                /*结束*/
                $result = ServerController::model($client_id, $data)->login();
                break;
            case 'server/shake_activity':
                /*结束*/
                $result = ServerController::model($client_id, $data)->getShakeActivity();
                break;
            case 'server/shake_up':
                /*结束*/
                $result = ServerController::model($client_id, $data)->shakeUp();
                break;
            case 'server/shake_result':
                /*结束*/
                $result = ServerController::model($client_id, $data)->shakeResult();
                break;
            default:
                $result = ['code' => Code::SYSTEM_ERROR, 'msg' => 'request format error.'];
        }

        $result['action'] = $action;
        //输出结果
        if (!empty($result)) {
            WsSender::sendToCurrentClient(json_encode($result, JSON_UNESCAPED_UNICODE));
        }
    }
}