<?php

namespace App\Modules\Server\Controllers;

use App\Common\Code;
use App\Common\Lib\Base64Image;
use App\Common\Msg;
use App\Common\Visitor;
use App\Models\WsToken;
use App\Modules\Server\Auth\Auth;
use App\Modules\Server\Controllers\Base\BaseController;
use App\Modules\Server\Service\TicketsService;
use App\Modules\Server\Service\WxService;

class TicketController extends BaseController
{
    /**
     * 设置不需要登录的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noLogin()
    {
        return ['index', 'wxLogin', 'testLogin', 'logout', 'buy'];
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

    /**
     * 用户注销
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function logout()
    {
        //注销，清除session
        Auth::auth()->logout();
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::USER_LOGOUT_OK;
        return $this->ajaxReturn($result);
    }

    /**
     * 登录验证
     * @author Chengcheng
     * @date 2016年10月21日 17:04:44
     * @return bool
     * */
    protected function auth()
    {
        /* 1 获取当前执行的action */
        $action   = $this->getCurrentAction();
        $actionID = $action['method'];

        /* 2 判断Action动作是否需要登录，默认需要登录 */
        $isNeedLogin = true;
        //判断当前控制器是否设置了所有Action动作不需要登录，或者，当前Action动作在不需要登录列表中
        $noLogin = $this->noLogin();
        $noLogin = !empty($noLogin) ? $noLogin : [];
        if (in_array($actionID, $noLogin) || $this->isNoLogin) {
            //不需要登录
            $isNeedLogin = false;
        }

        //* 3 检查用户是否登录-微信openid登录 */
        $wxResult = Auth::auth()->checkLoginWx();
        //如果用户已经微信授权登录，保存用户微信信息，
        if ($wxResult['code'] == Auth::LOGIN_YES) {
            //如果用户已经微信授权登录，设置用wx信息
            Visitor::userWx()->load($wxResult['data']);
        }

        $memberResult = Auth::auth()->checkLoginMember();
        //如果用户已经微信授权登录，保存用户微信信息，
        if ($memberResult['code'] == Auth::LOGIN_YES) {
            //如果用户已经微信授权登录，设置用wx信息
            Visitor::userMember()->load($memberResult['data']);
        }

        // 4 下面分析执行的动作和用户登录行为
        /* 1. 执行动作不需要用户登录,*/
        if ($isNeedLogin == false || $wxResult['code'] == Auth::LOGIN_YES || $memberResult['code'] == Auth::LOGIN_YES) {
            return true;
        }

        // [3] 当前动作需要登录，返回 false,用户未登录，不容许访问
        $result["code"] = Code::USER_LOGIN_NULL;
        $result["msg"]  = Msg::USER_LOGIN_NULL;
        return $result;
    }

    /**
     * 微信登录
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function wxLogin()
    {
        //1 获取code
        $this->requestData['code'] = $this->input('code', 0);

        //2 检查code
        if (empty($this->requestData['code'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'code');
            return $this->ajaxReturn($result);
        }

        //3 获取信息
        $wxLoginResult = WxService::wxLogin($this->requestData);

        //4 保存登录信息
        if (!empty($wxLoginResult['data']['wx'])) {
            Auth::auth()->loginWx($wxLoginResult['data']['wx']);
            $result["code"] = Code::SYSTEM_OK;
            $result["msg"]  = Msg::SYSTEM_OK;
            return $this->ajaxReturn($result);
        }

        //5 返回结果
        return $this->ajaxReturn($wxLoginResult);
    }

    /**
     * 微信登录
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function testLogin()
    {
        //1 获取code
        $this->requestData['name'] = $this->input('testName');

        //2 检查code
        if (empty($this->requestData['name'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'test_name');
            return $this->ajaxReturn($result);
        }

        //3 获取信息
        $testLoginResult = WxService::testLogin($this->requestData);

        //4 保存登录信息
        if (!empty($testLoginResult['data'])) {
            Auth::auth()->loginWx($testLoginResult['data']);
            $result["code"] = Code::SYSTEM_OK;
            $result["msg"]  = Msg::SYSTEM_OK;
            return $this->ajaxReturn($result);
        }

        //5 返回结果
        return $this->ajaxReturn($testLoginResult);
    }

    /**
     * 获取token
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function buy()
    {
        //1 获取参数 memberId , 用户联系手机号码 mobile, 购票信息
        $this->requestData['member_id'] = Visitor::user()->id;
        $this->requestData['mobile']    = $this->input('mobile', '');
        $this->requestData['tickets']   = $this->input('tickets', '');

        //2 检查参数
        if (empty($this->requestData['mobile'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'mobile');
            return $this->ajaxReturn($result);
        }
        if (empty($this->requestData['tickets'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'tickets');
            return $this->ajaxReturn($result);
        }

        //3 生成订单
        $result = TicketsService::createOrder($this->requestData);
        if(empty($result) || $result["code"] !=Code::SYSTEM_OK){
            return $this->ajaxReturn($result);
        }

        die;
        //4 保存图片
        $ticketsData = [];
        foreach ($tickets as $ticket) {
            $upFile             = [];
            $upFile['img']      = $ticket['file'];
            $upFile['fileName'] = $ticket['mobile'];
            Base64Image::up($upFile);
            $ticketData         = [];
            $ticketData['name'] = $ticket['name'];
        }

        //生成token
        $token = '111';

        //返回结果
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        $result["data"] = $token;
        return $this->ajaxReturn($result);
    }

}
