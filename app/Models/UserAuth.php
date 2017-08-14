<?php 
namespace App\Models; 

use App\Models\Base\BaseModel; 

/** 
 * 
 * @author ChengCheng 
 * @date 2017-08-14 10:34:42 
 * @property int(11) id '权限id'' 
 * @property varchar(50) name '名称'' 
 * @property varchar(255) desc '描述'' 
 * @property varchar(50) controller '控制器'' 
 * @property varchar(50) action '动作'' 
 * @property varchar(50) menu_id '菜单ID'' 
 * @property tinyint(2) menu_status '菜单状态，默认1-跳转显示，2-高亮，3-无效'' 
 * @property int(11) parent_id '父ID'' 
 * @property tinyint(2) type '状态 1为一级，2为二级 '' 
 */ 
class UserAuth extends BaseModel 
{ 
    // 数据表名字
    protected $table = "tb_user_auth"; 

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2017-08-14 10:34:42 
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
     * @date 2017-08-14 10:34:42 
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
        $model->name                  = $data['name'];
        $model->desc                  = $data['desc'];
        $model->controller            = $data['controller'];
        $model->action                = $data['action'];
        $model->menu_id               = $data['menu_id'];
        $model->menu_status           = $data['menu_status'];
        $model->parent_id             = $data['parent_id'];
        $model->type                  = $data['type'];
        
        // 保存信息
        $model->save();
        
        // 返回结果
        return $model;
    }
}
