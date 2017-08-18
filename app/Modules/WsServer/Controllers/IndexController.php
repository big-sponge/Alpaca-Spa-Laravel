<?php

namespace App\Modules\WsServer\Controllers;

use App\Common\Code;
use App\Common\Msg;
use App\Models\AdminMember;
use App\Modules\WsServer\Controllers\Base\BaseController;
use GatewayWorker\Lib\Gateway as WsSender;

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
        return ['index', 'login'];
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
        return ['index'];
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
        $result         = [];
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        WsSender::sendToCurrentClient($this->toJson($result));
    }

    /**
     * test
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     */
    public function testAction()
    {
        WsSender::sendToCurrentClient('login ok :' . $this->requestData['name']);
    }
}
