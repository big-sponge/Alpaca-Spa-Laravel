<?php
namespace App\Modules\Serve\Service;

use App\Common\Wechat\WeChat;
use App\Models\AdminMember;
use App\Common\Msg;
use App\Common\Code;

/**
 * Wechat
 * @author Chengcheng
 * @date 2016-10-19 15:50:00
 */
class WechatService
{
    /**
     * 微信授权登录
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @param string $code
     * @return array
     */
    public function wxLogin($code)
    {
        $result         = array();
        $result["code"] = Code::SYSTEM_ERROR;
        $result["msg"]  = Msg::SYSTEM_ERROR;
        $result["data"] = null;

        //获取openId
        $openId = WeChat::user()->getOpenId($code);

        //获取openId失败，系统错误，
        if (empty($openId)) {
            $result["code"] = Code::WX_LOGIN_OPENID_NULL;
            $result["msg"]  = Msg::WX_LOGIN_OPENID_NULL;
            return $result;
        }

        //根据openId获取用户信息
        $memberWechat = MemberWechat::model()->find('FWechatOpenId =:openId and FDisabled = 0', ['openId' => $openId]);
        if (!$memberWechat) {
            //微信用户首次访问系统，保存用户微信openId。
            $memberWechat                = new MemberWechat();
            $memberWechat->FWechatOpenId = $openId;
            $memberWechat->save();

            //设置返回结果
            $result["code"]                  = Code::WX_LOGIN_FIRST_USER_NULL;
            $result["msg"]                   = MsgTable::WX_LOGIN_FIRST_USER_NULL;
            $result["data"]["member_wechat"] = MemberWechat::convertModelObjToArray($memberWechat);
            return $result;
        } elseif (empty($memberWechat->FMemberId)) {
            //系统中存在用户微信openId，但是微信账号没有绑定系统账号，
            //设置返回结果
            $result["code"]                  = CodeTable::WX_LOGIN_USER_NULL;
            $result["msg"]                   = MsgTable::WX_LOGIN_USER_NULL;
            $result["data"]["member_wechat"] = MemberWechat::convertModelObjToArray($memberWechat);
            return $result;
        } else {
            $result["data"]["member_wechat"] = MemberWechat::convertModelObjToArray($memberWechat);
            //获取用户系统账号信息
            $member = Member::getMemberInfo($memberWechat->FMemberId);
            //没有找到用户信息
            if (!$member) {
                $result["code"] = CodeTable::WX_LOGIN_USER_ERROR;
                $result["msg"]  = MsgTable::WX_LOGIN_USER_ERROR;
                return $result;
            }
            //判断用户是否被冻结
            if ($member['FState'] == Member::MEMBER_STATUS_FREEZE) {
                $result["code"] = CodeTable::USER_STATUS_FREEZE;      //账号冻结
                $result["msg"]  = MsgTable::USER_STATUS_FREEZE;
                return $result;
            }

            //返回结果
            $result["code"]           = CodeTable::WX_LOGIN_USER_OK;
            $result["msg"]            = MsgTable::WX_LOGIN_USER_OK;
            $result["data"]["member"] = $member;
            return $result;
        }
    }
}
