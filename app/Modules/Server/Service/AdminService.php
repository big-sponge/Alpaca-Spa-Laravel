<?php
namespace App\Modules\Serve\Service;
use App\Models\AdminGroup;
use App\Models\AdminGroupAuth;
use App\Models\AdminMemberGroup;
use App\Models\AdminMember;
use App\Common\Code;
use App\Common\Msg;
use Illuminate\Support\Facades\DB;

/**
 * 用户
 * @author Chengcheng
 * @date 2016-10-19 15:50:00
 */
class AdminService
{
    /**
     * 编辑用户信息
     * @author Chengcheng
     * @date 2016-11-06 09:00:00
     * @param array $requestData
     * @return array
     */
    public static function editMemberWithGroups($requestData)
    {
        //0 预制返回结果
        $result         = array();
        $result["code"] = Code::USER_GET_INFO_NULL;
        $result["msg"]  = Msg::USER_GET_INFO_NULL;

        //1 判读email是否已经使用
        $memberExist = AdminMember::model()->where('email',$requestData['email'])->first();

        if(empty($requestData['id']) && !empty($memberExist)){
            //添加状态，id没有指定, 判断FEmail是否存在
            $result["code"] = Code::USER_EMAIL_EXIT;     //Email存在
            $result["msg"]  = Msg::USER_EMAIL_EXIT;
            return $result;

        }elseif(!empty($memberExist) && $memberExist->id !=$requestData['id']){
            //编辑状态状态，id没有指定, 判断FEmail是否存在
            $result["code"] = Code::USER_EMAIL_EXIT;     //Email存在
            $result["msg"]  = Msg::USER_EMAIL_EXIT;
            return $result;
        }

        //2 开始事务
        DB::beginTransaction();

        //3 查找用户信息
        if(empty($requestData['id'])){
            $member = new AdminMember();
        }else{
            $member = AdminMember::model()->find($requestData['id']);
            if (empty($member)) {
                DB::rollback();
                $result["code"] = Code::USER_GET_INFO_NULL;
                $result["msg"]  = Msg::USER_GET_INFO_NULL;
                return $result;
            }
        }

        //4 更新用户信息
        $member->email  = $requestData['email'];
        $member->name   = $requestData['name'];
        $member->mobile = $requestData['mobile'];
        if (!empty($requestData['passwd'])) {
            $member->passwd = password_hash($requestData['passwd'], PASSWORD_DEFAULT);
        }

        //保存用户信息
        $member->save();
        //6 更新用户分组
        AdminMemberGroup::editMemberGroup($member->id, $requestData['groups']);

        //7 提交事务
        DB::commit();

        //8 返回结果
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        return $result;
    }

    /**
     * 编辑分组，分组权限信息
     * @author Chengcheng
     * @date 2016-11-06 09:00:00
     * @param array $requestData
     * @return array
     */
    public static function editGroupWithAuth($requestData)
    {
        //0 返回结果
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;

        //判断是新增还是编辑
        if (empty($requestData['id'])) {
            //没有传递id，新增
            $group = new AdminGroup();
        } else {
            //传递id，编辑
            $group = AdminGroup::find($requestData['id']);
            if (empty($group)) {
                $result["code"] = Code::SYSTEM_ERROR_FIND_NULL;
                $result["msg"]  = Msg::SYSTEM_ERROR_FIND_NULL;
                return $result;
            }
        }

        //分组信息
        $group->name = $requestData['name'];
        $group->desc = $requestData['desc'];

        //开始事务
        DB::beginTransaction();

        //保存分组信息
        $group->save();

        //6 更新用户分组
        AdminGroupAuth::editGroupAuth($group->id, $requestData['powers']);

        //提交事务
        DB::commit();

        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        return $result;
    }

}
 