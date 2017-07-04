<?php
namespace App\Models;

use App\Models\Base\BaseModel;

/**
 *
 * @author ChengCheng
 * @date 2017-04-12 08:55:39
 * @property int(11)      id '权限id''
 * @property varchar(50)  name '名称''
 * @property varchar(255) desc '描述''
 * @property varchar(50)  controller '控制器''
 * @property varchar(50)  action '动作''
 * @property varchar(50)  menu_id '菜单ID''
 * @property tinyint(2)   menu_status '菜单状态，默认1-跳转显示，2-高亮，3-无效''
 * @property int(11)      parent_id '父ID''
 * @property tinyint(2)   type '状态 1为一级，2为二级 ''
 * @property tinyint(1)   status '状态 1为正常 0为冻结''
 * @property tinyint(2)   is_del '0可用 1不可用''
 * @property datetime     update_time '更新时间''
 * @property datetime     audit_time '审核时间''
 * @property datetime     create_time '创建时间''
 * @property datetime     delete_time '删除时间''
 * @property varchar(64)  creator '创建人id''
 * @property varchar(64)  updater '更新人id''
 * @property varchar(16)  ip '加入IP''
 * @property tinyint(4)   level '排序字段 0-9权值''
 */
class AdminAuth extends BaseModel
{

    protected $table = 'tb_admin_auth';

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
        $info = $query->get();

        //返回结果，查找数据列表，总数
        $result          = array();
        $result['list']  = $info->toArray();
        $result['total'] = $total;
        return $result;
    }
}