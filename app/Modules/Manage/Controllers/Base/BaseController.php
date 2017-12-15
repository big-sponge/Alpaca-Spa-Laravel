<?php

namespace App\Modules\Manage\Controllers\Base;

use App\Common\Visitor;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Modules\Manage\Auth\Auth;
use App\Common\Code;
use App\Common\Msg;

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
    protected function noLogin()
    {
        return [];
    }

    /**
     * 设置不需要权限的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noAuth()
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

        //验证访问权限权限，精确到Controller与Action
        $powerResult = $this->power();

        if ($powerResult !== true) {
            return $this->ajaxReturn($powerResult);
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

        // [1] 检查访问Action动作权限要求，检查访问用户登录情况，

        /* 1 判断Action动作是否需要登录，默认需要登录 */
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
            Visitor::adminMember()->load($memberResult['data']);
        }

        //* 3.1 检查用户是否登录-微信openid登录 */
        $wxResult = Auth::auth()->checkLoginWx();
        //如果用户已经微信授权登录，保存用户微信信息，
        if ($wxResult['code'] == Auth::LOGIN_YES) {
            //如果用户已经微信授权登录，设置用户memberWechat信息
            Visitor::userWx()->load($memberResult['data']);
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
     * 权限验证
     * @author Chengcheng
     * @date 2016年10月21日 17:04:44
     * @return bool
     * */
    protected function power()
    {
        /* 1.0 获取当前执行的action */
        $action       = $this->getCurrentAction();
        $actionID     = $action['method'];
        $controllerID = $action['controller'];

        /* 1.1 判断Action动作是否需要验证权限，默认需要验证 */
        //判断当前控制器是否设置了所有Action动作不需要登录，或者，当前Action动作在不需要登录列表中
        $noAuth = $this->noAuth();
        $noAuth = !empty($noAuth) ? $noAuth : [];
        if (in_array($actionID, $noAuth) || $this->isNoAuth) {
            //不需要权限
            return true;
        }

        /* 2 判断用户是否有操作当前Action的权限 */
        $userInfo = Visitor::adminMember()->toArray();

        /* 3 用户是不是管理员 */
        if ((!empty($userInfo['isAdmin'])) && $userInfo['isAdmin'] == true) {
            return true;
        }

        /* 4.1 检查用户Auth */
        $powerCheck = false;
        $power      = strtoupper($controllerID . "_" . $actionID);
        if (!empty($userInfo) && !empty($userInfo['group']) && !empty($userInfo['auth']) ){
            foreach ($userInfo['auth'] as $item) {
                if (strtoupper($item['controller'] . "_" . $item['action']) == $power) {
                    $powerCheck = true;
                    break;
                }
            }
        }

        /* 4.2 检查自定义权限 */
        if (!empty($noAuth[$actionID])) {
            $auth=[];
            if(!empty($userInfo)&&!empty($userInfo['auth'])){
                $auth = $userInfo['auth'];
            }
            $powerCheck = $noAuth[$actionID]($powerCheck, $auth);
        }

        if ($powerCheck) {
            return true;
        }

        /* 5 返回结果*/
        $result["code"] = Code::USER_POWER_ERROR;
        $result["msg"]  = Msg::USER_POWER_ERROR;
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
            clean_xss($value, true);
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
                $origin = request()->header("Origin");
                header("Access-Control-Allow-Origin: {$origin}"); // 允许任意域名发起的跨域请求
                header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');
                header("Access-Control-Allow-Credentials: true");
                header('Content-type:application/json; charset=utf-8');
                return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
            case 'XML'  :
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                return (xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE)->withCallback($this->input('callback'));
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                return ($data);
        }
        die();
    }
}
