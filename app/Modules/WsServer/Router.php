<?php

namespace App\Modules\WsServer;

use App\Common\Code;
use App\Modules\WsServer\Controllers\Admin\AdminController;
use App\Modules\WsServer\Controllers\ChatController;
use App\Modules\WsServer\Controllers\Server\ServerController;
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

            /* chat 部分 聊天室示例 */
            case 'chat/adminLogin':
                /*登录 - 使用管理员帐号（后台帐号登录）*/
                $result = ChatController::model($client_id, $data)->adminLogin();
                break;
            case 'chat/userLogin':
                /*登录 - 前台用户帐号*/
                $result = ChatController::model($client_id, $data)->userLogin();
                break;
            case 'chat/send':
                /*发送消息*/
                $result = ChatController::model($client_id, $data)->send();
                break;
            case 'chat/online':
                /*获取在线人员*/
                $result = ChatController::model($client_id, $data)->online();
                break;

            /* admin 部分 为管理端提供服务 */
            case 'admin/login':
                /*登录*/
                $result = AdminController::model($client_id, $data)->login();
                break;

            /* server 部分 为用户客户端提供服务 */
            case 'server/login':
                /*结束*/
                $result = ServerController::model($client_id, $data)->login();
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

    //连接关闭
    static public function close($client_id)
    {
        $group = $_SESSION['ws_client_group'];
        if ($group == ChatController::WS_GROUP_CHAT) {
            $result = ChatController::model($client_id, [])->offline();
        }
    }
}