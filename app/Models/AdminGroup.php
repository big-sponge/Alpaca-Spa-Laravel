<?php
namespace App\Models;

use App\Models\Base\BaseModel;

/**
 *
 * @author ChengCheng
 * @date 2017-04-12 09:41:46
 * @property int(11)      id '分组id''
 * @property varchar(50)  name '分组名称''
 * @property varchar(255) desc '分组描述''
 * @property tinyint(2)   is_del '0可用 1不可用''
 * @property datetime     update_time '更新时间''
 * @property datetime     audit_time '审核时间''
 * @property datetime     create_time '创建时间''
 * @property datetime     delete_time '删除时间''
 * @property varchar(64)  creator '创建人信息''
 * @property varchar(64)  updater '更新人信息''
 * @property varchar(16)  ip '加入IP''
 * @property tinyint(4)   level '排序字段 0-9权值''
 */
class AdminGroup extends BaseModel
{
    // 重定向数据表名字
    protected $table = "tb_admin_group";

    // 默认管理员分组ID
    const GROUP_ADMIN = 1;    //管理分组Id，对应为Group表中 Id =1

    /**
     * 用户所有权限
     */
    public function auth()
    {
        return $this->belongsToMany('App\Models\AdminAuth','tb_admin_group_auth','group_id','auth_id')->whereNull('tb_admin_group_auth.delete_time');
    }

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2016年10月20日 16:12:06
     * @param string $data
     * @return array
     */
    public function getPageList($data)
    {
        //查询条件
        $query = $this;

        //根据id查询
        if (isset($data['id'])) {
            $query = $query->where('id', $data['id']);
        }
        if (isset($data['key'])) {
            $query = $query->where('name', 'like', "%".$data['key']."%");
        }

        //总数
        $total = $query->count();

        //分页参数
        $pageSize = isset($data['pageSize']) ? $data['pageSize'] : 0;
        $pageNum  = isset($data['pageNum']) ? $data['pageNum'] : 1;
        if(!empty($pageSize)){
            $query = $query->limit($pageSize);
        }

        if(!empty($pageSize) && !empty($pageNum)){
            $query = $query->offset(($pageNum-1)*$pageSize);
        }

        //排序参数
        if(!empty($data['orders'])){
            foreach($data['orders'] as $order){
                $query = $query->orderBy($order[0],$order[1]);
            }
        }else{
            $query = $query->orderBy('id','desc');
        }

        //分页查找
        $info = $query->with('auth')->get();

        //返回结果，查找数据列表，总数
        $result          = array();
        $result['list']  = $info->toArray();
        $result['total'] = $total;
        return $result;
    }
} 
