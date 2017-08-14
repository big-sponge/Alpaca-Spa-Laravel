<?php 
namespace App\Models; 

use App\Models\Base\BaseModel; 

/** 
 * 
 * @author ChengCheng 
 * @date 2017-08-14 13:56:37 
 * @property int(11) id 'id'' 
 * @property char(50) open_id 'openid'' 
 * @property char(50) name '昵称'' 
 * @property char(255) avatar '头像URL'' 
 * @property int(11) member_id '用户ID'' 
 */ 
class UserWx extends BaseModel 
{ 
    // 数据表名字
    protected $table = "tb_user_wx"; 

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2017-08-14 13:56:37 
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
     * @date 2017-08-14 13:56:37 
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
        $model->open_id               = $data['open_id'];
        $model->name                  = $data['name'];
        $model->avatar                = $data['avatar'];
        $model->member_id             = $data['member_id'];
        
        // 保存信息
        $model->save();
        
        // 返回结果
        return $model;
    }

    /**
     * 获取用户信息
     * @author ChengCheng
     * @date 2016年10月20日 16:12:06
     * @param string $userWxId
     * @return array
     */
    public function info($userWxId = null)
    {
        // 是否指定了userWxId
        if (!empty($userWxId)) {
            $this->id = $userWxId;
        }

        // 关联分组查询member信息,auth信息
        $userWx = self::model()->where('id', $this->id)->first()->toArray();

        // 返回结果
        return $userWx;
    }
}
