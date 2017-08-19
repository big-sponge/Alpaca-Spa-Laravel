<?php
namespace App\Modules\WsServer\Service;

use App\Common\Msg;
use App\Common\Code;
use App\Models\AdminMember;
use App\Models\UserMember;
use App\Models\WsToken;

/**
 * Token
 * @author Chengcheng
 * @date 2016-10-19 15:50:00
 */
class TokenService
{

    /**
     * 微信授权登录
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @param array $data
     * @return array
     */
    public static function wsLogin($data)
    {
        //查找id
        $memberId = WsToken::model()->check($data['token'],$data['type']);
        if (empty($memberId)) {
            $result         = array();
            $result["code"] = Code::SYSTEM_ERROR;
            $result["msg"]  = Msg::SYSTEM_ERROR;
            return $result;
        }

        //查找用户信息
        if($data['type'] == WsToken::MEMBER_TYPE_ADMIN){
            $memberLoginResult = AdminMember::model()->login($memberId);
        }else{
            $memberLoginResult = UserMember::model()->login($memberId);
        }

        //返回结果
        $result["code"]           = Code::SYSTEM_OK;
        $result["msg"]            = Msg::SYSTEM_OK;
        $result["data"]["member"] = $memberLoginResult['data'];
        return $result;
    }
}
