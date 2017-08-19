<?php

namespace App\Modules\WsServer;

use App\Common\Code;
use App\Modules\WsServer\Controllers\AdminController;
use App\Modules\WsServer\Controllers\IndexController;

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
            case 'test':
                $result = IndexController::model($client_id, $data)->test();
                break;
            case 'login':
                $result = IndexController::model($client_id, $data)->login();
                break;
            case 'index':
                $result = IndexController::model($client_id, $data)->index();
                break;
            case 'admin/test':
                $result = AdminController::model($client_id, $data)->test();
                break;
            case 'admin/login':
                $result = AdminController::model($client_id, $data)->login();
                break;
            default:
                $result = ['code' => Code::SYSTEM_ERROR, 'msg' => 'request format error.'];
        }

        //输出结果
        if (!empty($result)) {
            WsSender::sendToCurrentClient(json_encode($result, JSON_UNESCAPED_UNICODE));
        }
    }
}