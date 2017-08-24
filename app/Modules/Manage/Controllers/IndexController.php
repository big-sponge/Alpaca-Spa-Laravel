<?php

namespace App\Modules\Manage\Controllers;

use App\Common\Wechat\WeChat;
use App\Common\WsServer\Client;
use App\Modules\Manage\Controllers\Base\BaseController;
use App\Modules\WsServer\Controllers\ServerController;
use Illuminate\Support\Facades\Cache;

class IndexController extends BaseController
{
    /**
     * 设置不需要登录的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noLogin()
    {
        return ['index'];
    }

    /**
     * 设置不需要权限的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noAuth()
    {
        // 当前控制器所有方法均不需要权限
        $this->isNoAuth = true;
    }

    public function index()
    {

        Client::sendToGroup(ServerController::WS_GROUP_CLIENT . '7', json_encode(['code' => '2222', 'msg' => 'asdasdasd', 'action' => '111111']));

        die('sssss2');
        $app = WeChat::app();

        $str = WeChat::user()->getWxAuthUrl();

        //$id =  WeChat::user()->getOpenId('ssss');

        var_dump($str);

        die;
        //$index = AdminMember::findById(4);
        //var_dump($index->toArray());

        /*  die('sss');
            return $this->ajaxReturn($index); */

        echo date('Y-m-d H:i:s', time());
        die();
    }

    public function index2()
    {
        die('sss - index2');
    }
}
