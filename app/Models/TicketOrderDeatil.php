<?php 
namespace App\Models; 

use App\Models\Base\BaseModel; 

/** 
 * 
 * @author ChengCheng 
 * @date 2017-11-24 15:13:12 
 * @property int(11) id 'id'' 
 * @property int(11) order_id '订单Id'' 
 * @property int(11) ticket_id '票Id'' 
 * @property varchar(50) ticket_name '名称'' 
 * @property varchar(50) ticket_label '标签信息'' 
 * @property varchar(50) ticket_code '识别码'' 
 * @property varchar(10) area '区域'' 
 * @property varchar(10) row '排'' 
 * @property varchar(10) column '列'' 
 * @property datetime buy_time '购买时间'' 
 * @property datetime valid_time '有效时间'' 
 */ 
class TicketOrderDeatil extends BaseModel 
{ 
    // 数据表名字
    protected $table = "tb_ticket_order_deatil"; 

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2017-11-24 15:13:12 
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
     * @date 2017-11-24 15:13:12 
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
        $model->order_id              = $data['order_id'];
        $model->ticket_id             = $data['ticket_id'];
        $model->ticket_name           = $data['ticket_name'];
        $model->ticket_label          = $data['ticket_label'];
        $model->ticket_code           = $data['ticket_code'];
        $model->area                  = $data['area'];
        $model->row                   = $data['row'];
        $model->column                = $data['column'];
        $model->buy_time              = $data['buy_time'];
        $model->valid_time            = $data['valid_time'];
        
        // 保存信息
        $model->save();
        
        // 返回结果
        return $model;
    }
}
