<?php
namespace App\Models;

use App\Models\Base\BaseModel;

/**
 *
 * @author ChengCheng
 * @date 2017-04-12 09:40:38
 * @property int(11)     id 'id''
 * @property int(11)     group_id '分组ID''
 * @property int(11)     auth_id '权限ID''
 * @property tinyint(1)  status '状态 1为正常 0为冻结''
 * @property tinyint(2)  is_del '0可用 1不可用''
 * @property datetime    update_time '更新时间''
 * @property datetime    audit_time '审核时间''
 * @property datetime    create_time '创建时间''
 * @property datetime    delete_time '删除时间''
 * @property varchar(64) creator '创建人信息''
 * @property varchar(64) updater '更新人信息''
 * @property varchar(16) ip '加入IP''
 * @property tinyint(4)  level '排序字段 0-9权值''
 */
class AdminGroupAuth extends BaseModel
{
    // 重定向数据表名字
    protected $table = "tb_admin_group_auth";

    /**
     * 编辑用户组权限
     * @author Chengcheng
     * @date 2016-11-06 09:00:00
     * @param string $groupId
     * @param array  $authIds
     * @return array
     */
    public static function editGroupAuth($groupId, $authIds)
    {
        //1 查找权限表，验证权限是否存在,找出存在的权限
        $authArray = AdminAuth::whereIn('id', $authIds)->get()->toArray();

        //2 提取合法分组id
        $authIds = array_column($authArray, 'id');

        //3 查找group-auth表，查找出已经建立关系的数据
        $groupAuthArray    = AdminGroupAuth::where('group_id', $groupId)->whereIn('id', $authIds)->get()->toArray();

        //4 提取已经建立关系的id
        $authOldIds = array_column($groupAuthArray, 'auth_id');

        //5 获取要新建关系的id
        $authNewIds = array_diff($authIds, $authOldIds);

        //6 修改分组权限表，建立分组与用户的关系
        foreach ($authNewIds as $authId) {
            $groupAuth           = new AdminGroupAuth();
            $groupAuth->group_id = $groupId;
            $groupAuth->auth_id  = $authId;
            $groupAuth->save();
        }

        //7 移除分组被取消的权限
        AdminGroupAuth::where('group_id', $groupId)->whereNotIn('auth_id', $authIds)->delete();

        //返回true
        return true;
    }

} 
