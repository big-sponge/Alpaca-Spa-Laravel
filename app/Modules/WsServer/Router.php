<?php

namespace App\Modules\WsServer;

use App\Modules\WsServer\Controllers\IndexController;

use GatewayWorker\Lib\Gateway as WsSender;

class Router
{
    //初始化
    static public function init($client_id, $message)
    {
        $message = json_decode($message, true);
        $action  = $message['action'];
        $data    = $message['data'];
        switch ($action) {
            case 'test':
                IndexController::model($client_id, $data)->test();
                break;
            case 'login':
                IndexController::model($client_id, $data)->login();
                break;
            case 'index':
                IndexController::model($client_id, $data)->index();
                break;
            default:
                WsSender::sendToCurrentClient('request format error.');
        }
    }
}