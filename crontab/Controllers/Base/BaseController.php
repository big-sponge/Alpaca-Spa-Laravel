<?php

namespace Crontab\Controllers\Base;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Crontab\Common\Code;
use Crontab\Common\Msg;

/**
 * 模块控制器父类
 * 登录验证，微信登录等验证，权限验证
 * @author Chengcheng
 * @date 2016年10月21日 17:04:44
 */
class BaseController extends Controller
{

    /**
     * 请求参数
     * @author Chengcheng
     * @date 2016年10月21日 17:04:44
     */
    protected $requestData = [];

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
    protected function withoutLoginActions()
    {
        return [];
    }

    /**
     * 设置不需要权限的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function withoutAuthActions()
    {
        return [];
    }

    /**
     * 获取当前的action,[controller,method]
     *
     * @return array
     */
    protected function getCurrentAction()
    {
        $action = Route::current()->getActionName();
        list($class, $method) = explode('@', $action);
        $class = substr(strrchr($class, '\\'), 1);
        $class = str_replace("Controller", "", $class);
        return ['controller' => $class, 'method' => $method];
    }

    /**
     * Execute an action on the controller.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        //检查登录权限
        $authResult = $this->auth();
        if ($authResult !== true) {
            //return $authResult;
            return $this->ajaxReturn($authResult);
        }
        return parent::callAction($method, $parameters);
    }

    /**
     * 登录验证
     * @author Chengcheng
     * @date 2016年10月21日 17:04:44
     * @return bool
     * */
    protected function auth()
    {
        /* 1.0 获取当前执行的action */
        $action   = $this->getCurrentAction();
        $actionID = $action['method'];

        // [0] 设置系统相关的参数,访问者客户端, 访问者IP,访问时间
        $this->requestData['visitUserAgent'] = empty($_SERVER['HTTP_USER_AGENT']) ? 'unknown' : $_SERVER['HTTP_USER_AGENT'];
        $this->requestData['visitIP']        = $_SERVER["REMOTE_ADDR"];
        $this->requestData['visitTime']      = date('Y-m-d H:i:s');

        // [1] 检查访问Action动作权限要求，检查访问用户登录情况，
        /* 1 判断Action动作是否需要登录，默认需要登录 */
        $isNeedLogin = true;
        //判断当前控制器是否设置了所有Action动作不需要登录，或者，当前Action动作在不需要登录列表中
        $withoutLoginActions = $this->withoutLoginActions();
        $withoutLoginActions = !empty($withoutLoginActions) ? $withoutLoginActions : [];
        if (in_array($actionID, $withoutLoginActions) || $this->isNoLogin) {
            //不需要登录
            $isNeedLogin = false;
        }

        // [2] 下面分析执行的动作和用户登录行为
        /* 1. 执行动作不需要用户登录,*/
        if ($isNeedLogin == false) {
            //返回结果，容许访问
            return true;
        }

        // [3] 当前动作需要登录，返回 false,用户未登录，不容许访问
        $result["code"] = Code::USER_LOGIN_NULL;
        $result["msg"]  = Msg::USER_LOGIN_NULL;
        return $result;
    }

    /**
     * 获取输入参数
     * @author Chengcheng
     * @param string $key 参数名称
     * @param string $value 默认值
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function input($key, $value = null)
    {
        $value = Input::get($key, $value);
        if (isset($value)) {
            clean_xss($value);
        }
        return $value;
    }

    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed  $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @return mixed
     */
    protected function ajaxReturn($data, $type = '')
    {
        if (empty($type)) $type = 'JSON';
        switch (strtoupper($type)) {
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                return response()->json($data,200,[],JSON_UNESCAPED_UNICODE);
            case 'XML'  :
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                return (xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                return response()->json($data,200,[],JSON_UNESCAPED_UNICODE)->withCallback($this->input('callback'));
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                return ($data);
        }
        die();
    }
}