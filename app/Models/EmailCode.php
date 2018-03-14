<?php 
namespace App\Models; 

use App\Models\Base\BaseModel; 

/** 
 * 
 * @author ChengCheng 
 * @date 2018-02-04 16:08:15 
 * @property int(11) id 'id'' 
 * @property char(50) member_id '用户id'' 
 * @property tinyint(2) member_type '用户类型，枚举|1-用户-USER|2-管理员-ADMIN'' 
 * @property varchar(15) mobile '手机号'' 
 * @property varchar(100) email '邮箱'' 
 * @property string|varchar(65) code 'code''
 * @property datetime available_time '有效截至时间'' 
 */ 
class EmailCode extends BaseModel 
{ 
    // 数据表名字
    protected $table = "tb_email_code"; 

    // 枚举字段
    const MEMBER_TYPE_USER = 1;    //用户类型:用户
    const MEMBER_TYPE_ADMIN = 2;    //用户类型:管理员

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2018-02-04 16:08:15 
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
     * @date 2018-02-04 16:08:15 
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
        $model->member_type           = $data['member_type'];
        $model->mobile                = $data['mobile'];
        $model->email                 = $data['email'];
        $model->code                  = $data['code'];
        $model->available_time        = $data['available_time'];
        
        // 保存信息
        $model->save();
        
        // 返回结果
        return $model;
    }
}
