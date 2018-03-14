<?php
namespace App\Modules\Manage\Service;

use App\Models\AdminMember;
use App\Common\Msg;
use App\Common\Code;
use App\Models\EmailCode;
use App\Common\Visitor;
use Illuminate\Support\Facades\DB;
use App\Models\AdminMemberGroup;

/**
 * Email
 * @author Chengcheng
 * @date 2016-10-19 15:50:00
 */
class EmailService
{
    /**
     * 用户注册
     * @author Chengcheng
     * @param array $data
     * @return array
     */
    public static function register($data)
    {
        //0 预制返回结果
        $result         = array();
        $result["code"] = Code::SYSTEM_ERROR;
        $result["msg"]  = Msg::SYSTEM_ERROR;
        $result["data"] = "";

        //1 判断邮箱是否存在
        $member = AdminMember::model()->where('email', $data['email'])->first();
        if (!empty($member)) {
            $result["code"] = Code::USER_EMAIL_EXIT;     //手机号码不存在
            $result["msg"]  = Msg::USER_EMAIL_EXIT;
            return $result;
        }

        //2 判断手机是否存在
        if (!empty($data['phone'])) {
            $member = AdminMember::model()->where('email', $data['phone'])->first();
            if (!empty($member)) {
                $result["code"] = Code::USER_MOBILE_EXIT;     //手机号码不存在
                $result["msg"]  = Msg::USER_MOBILE_EXIT;
                return $result;
            }
        }

        //3 判断验证码
        $emailCode = EmailCode::model()->where([['code', $data['code']], ['email', $data['email']]])->first();

        if (empty($emailCode) || strtotime($emailCode->available_time) < strtotime(Visitor::user()->time) || $emailCode->code != $data['code']) {
            $result["code"] = Code::USER_EMAIL_CODE_ERROR;     //手机号码不存在
            $result["msg"]  = Msg::USER_EMAIL_CODE_ERROR;
            return $result;
        }

        //4 保存用户登录信息
        $member         = new AdminMember();
        $member->email  = $data['email'];
        $member->mobile = $data['phone'];
        $member->name   = $data['name'];
        if (!empty($data['passwd'])) {
            $member->passwd = password_hash($data['passwd'], PASSWORD_DEFAULT);
        }
        //5 开始事务
        DB::beginTransaction();
        $member->save();
        //6 更新用户分组
        AdminMemberGroup::editMemberGroup($member->id, [2]);
        //7 提交事务
        DB::commit();

        //8 登录成功，返回结果
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::USER_REGISTER_OK;
        return $result;
    }

    /**
     * 用户登录-通过Email-Password
     * @author Chengcheng
     * @param array $requestData
     * @return array
     */
    public static function loginEmail($requestData)
    {
        //0 预制返回结果
        $result         = array();
        $result["code"] = Code::SYSTEM_ERROR;
        $result["msg"]  = Msg::SYSTEM_ERROR;
        $result["data"] = "";

        //1 判断邮箱是否存在
        $member = AdminMember::model()->where('email', $requestData['email'])->first();
        if (!$member) {
            $result["code"] = Code::USER_EMAIL_ERROR;     //手机号码不存在
            $result["msg"]  = Msg::USER_EMAIL_ERROR;
            return $result;
        }

        //2 验证密码是否正确
        if (!password_verify($requestData['passwd'], $member->passwd)) {
            $result["code"] = Code::USER_PASSWORD_ERROR;
            $result["msg"]  = Msg::USER_PASSWORD_ERROR;
            return $result;
        }

        //3 保存用户登录信息

        //获取用户系统账号信息
        $memberLoginResult = AdminMember::model()->login($member->id);
        if ($memberLoginResult['code'] != Code::SYSTEM_OK) {
            return $memberLoginResult;
        }

        //5 登录成功，返回结果
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::USER_LOGIN_OK;
        $result["data"] = $memberLoginResult['data'];
        return $result;
    }

    /**
     * 重置密码-token方式
     * @author Chengcheng
     * @date 2016-10-19 15:50:00
     * @param array $requestData
     * @return array
     */
    public static function resetPasswordByOld($requestData)
    {
        //0 预制返回结果
        $result         = array();
        $result["code"] = Code::SYSTEM_ERROR;
        $result["msg"]  = Msg::SYSTEM_ERROR;

        //1 验证旧密码是否正确
        $member = AdminMember::find($requestData['member_id']);
        if (empty($member) || !password_verify($requestData['old_passwd'], $member->passwd)) {
            $result["code"] = Code::USER_PASSWORD_ERROR;
            $result["msg"]  = Msg::USER_PASSWORD_ERROR;
            return $result;
        }

        //2 修改密码
        $member->passwd = password_hash($requestData['new_passwd'], PASSWORD_DEFAULT);
        $member->save();

        //3 修改成功
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        return $result;
    }

    /**
     * 重置密码-code方式
     * @author Chengcheng
     * @date 2016-10-19 15:50:00
     * @param array $data
     * @return array
     */
    public static function resetPasswordByCode($data)
    {
        //0 预制返回结果
        $result         = array();
        $result["code"] = Code::SYSTEM_ERROR;
        $result["msg"]  = Msg::SYSTEM_ERROR;

        //3 判断验证码
        $emailCode = EmailCode::model()->where([['code', $data['code']], ['email', $data['email']]])->first();

        if (empty($emailCode) || strtotime($emailCode->available_time) < strtotime(Visitor::user()->time) || $emailCode->code != $data['code']) {
            $result["code"] = Code::USER_EMAIL_CODE_ERROR;     //手机号码不存在
            $result["msg"]  = Msg::USER_EMAIL_CODE_ERROR;
            return $result;
        }

        //1 验证旧密码是否正确
        $member = AdminMember::model()->where('email', $data['email'])->first();
        if (empty($member)) {
            $result["code"] = Code::USER_EMAIL_ERROR;
            $result["msg"]  = Msg::USER_EMAIL_ERROR;
            return $result;
        }

        //2 修改密码
        $member->passwd = password_hash($data['passwd'], PASSWORD_DEFAULT);
        $member->save();

        //3 修改成功
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        return $result;
    }

}
