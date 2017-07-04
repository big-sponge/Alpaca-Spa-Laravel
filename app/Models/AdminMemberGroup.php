<?php
namespace App\Models;

use App\Models\Base\BaseModel;

/**
 *
 * @author ChengCheng
 * @date 2017-04-12 15:33:33
 * @property int(11)     id '用户分组id''
 * @property int(11)     member_id '用户ID''
 * @property int(11)     group_id '用户组ID''
 * @property tinyint(2)  role '角色, 默认0-普通，1-组管理员''
 * @property tinyint(1)  status '状态 1为正常 0为冻结''
 * @property tinyint(2)  is_del '0可用 1不可用''
 * @property datetime    update_time '更新时间''
 * @property datetime    audit_time '审核时间''
 * @property datetime    create_time '创建时间''
 * @property datetime    delete_time '删除时间''
 * @property varchar(64) creator '创建人id''
 * @property varchar(64) updater '更新人id''
 * @property varchar(16) ip '加入IP''
 * @property tinyint(4)  level '排序字段 0-9权值''
 */
class AdminMemberGroup extends BaseModel
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'tb_admin_member_group';

    /**
     * 添加、编辑用户分组信息
     * @author ChengCheng
     * @date 2016-11-19
     * @param string $memberId 用户ID
     * @param array  $groupIds 分组ID
     * @return array|mixed
     */
    public static function editMemberGroup($memberId, $groupIds)
    {
        //查找分组表表，验证分组是否存在，找出存在的分组
        $groupArray = AdminGroup::model()->whereIn('id', $groupIds)->get()->toArray();

        //提取合法分组id
        $groupIds = array_column($groupArray, 'id');

        //查找member-group表，查找出已经建立关系的数据
        $query            = AdminMemberGroup::model();
        $query            = $query->where('member_id', $memberId);
        $query            = $query->whereIn('group_id', $groupIds);
        $memberGroupArray = $query->get()->toArray();

        //提取已经建立关系的分组id
        $groupOldIds = array_column($memberGroupArray, 'group_id');

        //获取要新建关系的分组id
        $groupNewIds = array_diff($groupIds, $groupOldIds);

        //4 修改分组权限表，建立分组与用户的关系
        foreach ($groupNewIds as $groupId) {
            $memberGroup            = new AdminMemberGroup();
            $memberGroup->member_id = $memberId;
            $memberGroup->group_id  = $groupId;
            $memberGroup->save();
        }

        //5 移除分组被取消的权限
        $query = AdminMemberGroup::model();
        $query = $query->where('member_id', $memberId);
        $query = $query->whereNotIn('group_id', $groupIds);
        $query->delete();

        //返回true
        return true;
    }

}
