<?php

namespace App\Modules\WsServer\Controllers\Base;

use App\Common\Code;
use App\Common\Msg;
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
            WsSender::sendToCurrentClient($this->toJson($authResult));
            return;
        }

        //调用action
        $method = $name . "Action";
        $this->$method();
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

        //* 1 判断Action动作是否需要登录，默认需要登录 */
        $isNeedLogin = true;
        //判断当前控制器是否设置了所有Action动作不需要登录，或者，当前Action动作在不需要登录列表中
        $noLogin = $this->noLogin();
        $noLogin = !empty($noLogin) ? $noLogin : [];
        if (in_array($actionID, $noLogin) || $this->isNoLogin) {
            //不需要登录
            $isNeedLogin = false;
        }

        /* 2 检查用户是否已登录-系统账号登录 */
        $memberResult = Auth::auth()->checkLoginMember();
        //如果用户已经登录，保存用户信息，
        if ($memberResult['code'] == Auth::LOGIN_YES) {
            //如果用户已经登录，设置用户member信息
            $this->requestData['visitor']['member'] = $memberResult['data'];
        }

        //* 3.1 检查用户是否登录-微信openid登录 */
        $wxResult = Auth::auth()->checkLoginWx();
        //如果用户已经微信授权登录，保存用户微信信息，
        if ($wxResult['code'] == Auth::LOGIN_YES) {
            //如果用户已经微信授权登录，设置用户memberWechat信息
            $this->requestData['visitor']['wx'] = $wxResult['data'];
        }

        // [2] 下面分析执行的动作和用户登录行为
        /* 1. 执行动作不需要用户登录,*/
        if ($isNeedLogin == false) {
            /* 设置框架user信息，默认为unLogin */
            //返回结果，容许访问
            return true;
        }

        /* 2.1 执行动作需要登录，用户使用系统账号登录，容许访问*/
        if ($memberResult['code'] == Auth::LOGIN_YES) {
            /* 设置框架user信息 */
            return true;
        }

        /* 3. 当前动作需要登录，系统账号未登录，微信已登录 */
        if ($wxResult['code'] == Auth::LOGIN_YES) {
            //不容许访问动作，返回结果，提示用户已经获取openId登录，但是需要注册系统账号才能执行当前动作，
            $result["code"] = Code::WX_LOGIN_USER_NULL;
            $result["msg"]  = Msg::WX_LOGIN_USER_NULL;
            return $result;
        }

        // [3] 当前动作需要登录，返回 false,用户未登录，不容许访问
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
