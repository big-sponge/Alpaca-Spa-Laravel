<?php
namespace App\Modules\Server\Service;

use App\Common\Wechat\WeChat;
use App\Common\Msg;
use App\Common\Code;
use App\Models\UserMember;
use App\Models\UserWx;

/**
 * Wechat
 * @author Chengcheng
 * @date 2016-10-19 15:50:00
 */
class WxService
{
    /**
     * 微信授权登录
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @param array $data
     * @return array
     */
    public static function wxLogin($data)
    {
        $result         = array();
        $result["code"] = Code::SYSTEM_ERROR;
        $result["msg"]  = Msg::SYSTEM_ERROR;
        $result["data"] = null;

        //获取openId
        $auth   = WeChat::user()->auth($data['code']);
        $openId = $auth['openid'];
        //获取openId失败，系统错误，
        if (empty($openId)) {
            $result["code"] = Code::WX_LOGIN_OPENID_NULL;
            $result["msg"]  = Msg::WX_LOGIN_OPENID_NULL;
            return $result;
        }

        $weInfo = WeChat::user()->getUserInfo($openId, $auth['access_token']);

        //根据openId获取用户信息
        $userWx = UserWx::model()->where('open_id', $openId)->first();
        if (!$userWx) {
            //微信用户首次访问系统，保存用户微信openId。
            $userWx          = new UserWx();
            $userWx->open_id = $openId;
            $userWx->avatar  = $weInfo['headimgurl'];
            $userWx->name    = $weInfo['nickname'];
            $userWx->save();

            //设置返回结果
            $result["code"]       = Code::WX_LOGIN_FIRST_USER_NULL;
            $result["msg"]        = Msg::WX_LOGIN_FIRST_USER_NULL;
            $result["data"]["wx"] = $userWx->makeHidden('open_id')->toArray();
            return $result;
        } elseif (empty($userWx->member_id)) {

            $userWx->avatar = $weInfo['headimgurl'];
            $userWx->name   = $weInfo['nickname'];
            $userWx->save();

            //系统中存在用户微信openId，但是微信账号没有绑定系统账号，
            //设置返回结果
            $result["code"]           = Code::WX_LOGIN_USER_NULL;
            $result["msg"]            = Msg::WX_LOGIN_USER_NULL;
            $result["data"]["wx"] = $userWx->makeHidden('open_id')->toArray();
            return $result;
        } else {

            $userWx->avatar = $weInfo['headimgurl'];
            $userWx->name   = $weInfo['nickname'];
            $userWx->save();

            //获取用户系统账号信息
            $memberLoginResult = UserMember::model()->login($userWx->member_id);
            if ($memberLoginResult['code'] != Code::SYSTEM_OK) {
                return $memberLoginResult;
            }

            //返回结果
            $result["code"]           = Code::WX_LOGIN_USER_OK;
            $result["msg"]            = Msg::WX_LOGIN_USER_OK;
            $result["data"]["wx"]     = $userWx->makeHidden('open_id')->toArray();
            $result["data"]["member"] = $memberLoginResult['data'];
            return $result;
        }
    }

    /**
     * 测试登录
     * @author Chengcheng
     * @param array $requestData
     * @return array
     */
    public static function testLogin($requestData)
    {
        //1 判断邮箱是否存在
        $member       = new UserWx();
        $member->name = $requestData['name'];
        $member->open_id='-';
        $member->save();

        //3 保存用户登录信息，并且返回用户详细信息
        $result = $member->login();

        //4 返回结果
        return $result;
    }
}
