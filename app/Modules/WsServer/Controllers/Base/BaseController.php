<?php

namespace App\Modules\WsServer\Controllers\Base;

use App\Common\Code;
use App\Common\Msg;
use App\Common\Visitor;
use GatewayWorker\Lib\Gateway as WsSender;
use App\Modules\WsServer\Auth\Auth;

class BaseController
{

    /**
     * 请求参数
     * @author Chengcheng
     * @date 2016年10月21日 17:04:44
     */
    protected $requestData = [];

    /**
     * 客户端连接id
     * @author Chengcheng
     * @date 2016年10月21日 17:04:44
     */
    protected $clientId = '';

    /**
     * 标示为-是否当前控制器里面的所有Action都不需要登录权限
     * true-不需要登录，false-需要登录
     * @author Chengcheng
     * @date 2016年10月21日 17:04:44
     */
    protected $isNoLogin = false;

    /**
     * 标示为-是否当前控制器里面的所有Action都不需要权限验证
     * true-不需要登录，false-需要登录
     * @author Chengcheng
     * @date 2016年10月21日 17:04:44
     */
    protected $isNoAuth = false;

    /**
     * 设置不需要登录的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noLogin()
    {
        return [];
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
        return [''];
    }

    /**
     * 魔术方法连接action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @param string $name
     * @param array  $args
     * @return array
     */
    function __call($name, $args)
    {
        //检查登录权限
        $authResult = $this->auth($name);
        if ($authResult !== true) {
            return $authResult;
        }

        //调用action
        $method = $name . "Action";
        return $this->$method();
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
            //不需要登录
            $isNeedLogin = false;
        }

        /* 2 检查用户是否已登录-系统账号登录 */
        $memberResult = Auth::auth()->checkLoginUserMember();
        if ($isNeedLogin == false || $memberResult['code'] == Auth::LOGIN_YES) {
            // 设置框架user信息，默认为unLogin
            Visitor::userMember()->load($memberResult['data']);
            //返回结果，容许访问
            return true;
        }

        /* 3 当前动作需要登录，返回 false,用户未登录，不容许访问 */
        $result["code"] = Code::USER_LOGIN_NULL;
        $result["msg"]  = Msg::USER_LOGIN_NULL;
        return $result;
    }

    /**
     * 单例模式
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @param string $id
     * @param array  $data
     * @return static
     */
    public static function model($id, $data)
    {
        //创建自己
        $model = new static();

        //填充数据
        $model->requestData = $data;
        $model->clientId    = $id;

        //返回
        return $model;
    }

    /**
     * 转换成json
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @param $data
     * @return string
     */
    protected function toJson($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

}
