<?php

namespace App\Modules\Server\Controllers;

use App\Common\Code;
use App\Common\Lib\Base64Image;
use App\Common\Msg;
use App\Common\Visitor;
use App\Common\WsServer\Client;
use App\Common\Youtu\YouTu;
use App\Modules\Server\Auth\Auth;
use App\Modules\Server\Controllers\Base\BaseController;
use App\Modules\Server\Service\WxService;
use Endroid\QrCode\QrCode;

class OcrController extends BaseController
{
    /**
     * 设置不需要登录的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noLogin()
    {
        return ['qrCode'];
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
     * 获取token
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function getDeviceId()
    {
        //获取参数

        $deviceId = isset($_SESSION['ocr_device_id']) ? $_SESSION['ocr_device_id'] : null;
        if (empty($deviceId)) {
            $deviceId                  = rand(100000, 999999);
            $_SESSION['ocr_device_id'] = $deviceId;
        }

        $token = request()->get("token");

        if (!empty($token)) {
            $notify           = [];
            $notify['code']   = Code::SYSTEM_OK;
            $notify['msg']    = Msg::SYSTEM_OK;
            $notify['data']   = $deviceId;
            $notify['action'] = 'index/ocr_token';
            Client::sendToGroup('ocr_token_' . $token, json_encode($notify));
        }

        //返回结果
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        $result["data"] = $deviceId;
        return $this->ajaxReturn($result);
    }

    /**
     * youTu- 调用 优图 ocr 接口
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    public function youTu()
    {
        $image = request()->get("image");

        $path = 'http://full.tkc8.com' . Base64Image::up(['img' => $image]);
        $data = YouTu::generalocr($path);

        $result           = [];
        $result['code']   = Code::SYSTEM_OK;
        $result['msg']    = Msg::SYSTEM_OK;
        $result['data']   = $data;
        $result['action'] = 'index/ocr';

        $deviceId = isset($_SESSION['ocr_device_id']) ? $_SESSION['ocr_device_id'] : null;
        if (!empty($deviceId)) {
            Client::sendToGroup('ocr_' . $deviceId, json_encode($result));
        }

        return $this->ajaxReturn($result);
    }

    /**
     * 二维码
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    public function qrCode()
    {
        $token = request()->get("token");

        $qrCode = new QrCode('http://full.tkc8.com/app/#/main/test/ocr/' . $token);

        header('Content-Type: ' . $qrCode->getContentType());
        echo $qrCode->writeString();
    }

}
