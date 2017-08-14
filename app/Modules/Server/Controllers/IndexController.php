<?php

namespace App\Modules\Server\Controllers;

use App\Common\Code;
use App\Common\Msg;
use App\Common\Wechat\WeChat;
use App\Modules\Server\Controllers\Base\BaseController;

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
        //1 获取输入参数
        $redirect = $this->input('redirect_uri');
        $scope    = $this->input('scope', 'base');

        //2 生成url
        $str = WeChat::user()->getWxAuthUrl($redirect, $scope);

        //3 返回结果
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        $result['data'] = $str;
        return $this->ajaxReturn($result);
    }

    public function index2()
    {
        die('sss - index2');
    }
}
