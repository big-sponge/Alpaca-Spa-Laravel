<?php 
namespace App\Models; 

use App\Models\Base\BaseModel; 

/** 
 * 
 * @author ChengCheng 
 * @date 2017-08-14 10:35:27 
 * @property int(11) id '用户分组id'' 
 * @property int(11) member_id '用户ID'' 
 * @property int(11) group_id '用户组ID'' 
 * @property tinyint(2) role '角色, 默认0-普通，1-组管理员'' 
 */ 
class UserMemberGroup extends BaseModel 
{ 
    // 数据表名字
    protected $table = "tb_user_member_group"; 

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2017-08-14 10:35:27 
     * @param string $data
     * @return array
     */
    public function lists($data)
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
        $query = $this->initPaged($query,$data);
        
        //排序参数
        $query = $this->initOrdered($query,$data);
        
        //分页查找
        $info = $query->get();
        
        //返回结果，查找数据列表，总数
        $result          = array();
        $result['list']  = $info->toArray();
        $result['total'] = $total;
        return $result;
    }
    
    /**
     * 编辑
     * @author ChengCheng
     * @date 2017-08-14 10:35:27 
     * @param string $data
     * @return array
     */
    public function edit($data)
    {
        // 判断是否是修改
        if (empty($data['id'])) {
            $model = new self;
        } else {
            $model = self::model()->find($data['id']);
            if (empty($model)) {
                return null;
            }
        }
        
        // 填充字段
        $model->member_id             = $data['member_id'];
        $model->group_id              = $data['group_id'];
        $model->role                  = $data['role'];
        
        // 保存信息
        $model->save();
        
        // 返回结果
        return $model;
    }
}
