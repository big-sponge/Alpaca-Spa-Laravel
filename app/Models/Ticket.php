<?php 
namespace App\Models; 

use App\Models\Base\BaseModel; 

/** 
 * 
 * @author ChengCheng 
 * @date 2017-11-24 15:22:07 
 * @property int(11) id 'id'' 
 * @property int(11) room_id '房间Id'' 
 * @property int(11) round_id '场次Id'' 
 * @property varchar(50) name '名称'' 
 * @property varchar(50) label '标签信息'' 
 * @property varchar(50) code '识别码'' 
 * @property varchar(10) area '区域'' 
 * @property varchar(10) row '排'' 
 * @property varchar(10) column '列'' 
 * @property datetime valid_time '有效时间'' 
 * @property tinyint(4) state '状态，枚举|0-未使用-NORMAL|1-已经出售-USED'' 
 */ 
class Ticket extends BaseModel 
{ 
    // 数据表名字
    protected $table = "tb_ticket"; 

    // 枚举字段
    const STATE_NORMAL = 0;    //状态:未使用
    const STATE_USED = 1;    //状态:已经出售

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2017-11-24 15:22:07 
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
     * @date 2017-11-24 15:22:07 
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
        $model->room_id               = $data['room_id'];
        $model->round_id              = $data['round_id'];
        $model->name                  = $data['name'];
        $model->label                 = $data['label'];
        $model->code                  = $data['code'];
        $model->area                  = $data['area'];
        $model->row                   = $data['row'];
        $model->column                = $data['column'];
        $model->valid_time            = $data['valid_time'];
        $model->state                 = $data['state'];
        
        // 保存信息
        $model->save();
        
        // 返回结果
        return $model;
    }
}
