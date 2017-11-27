<?php
namespace App\Models;

use App\Models\Base\BaseModel;

/**
 *
 * @author ChengCheng
 * @date 2017-11-24 14:39:33
 * @property int(11)      id 'id''
 * @property varchar(50)  sn '订单编号''
 * @property tinyint(4)   type '订单类型，0 普通订单 1 父订单 2 子订单''
 * @property int(11)      parent_id '父订单Id''
 * @property datetime     deliver_time '发货时间''
 * @property datetime     pay_time '付款时间''
 * @property datetime     finnish_time '订单完成时间''
 * @property datetime     shipping_time '配送时间''
 * @property datetime     evaluation_time '评价时间''
 * @property int(11)      store_id '卖家店铺id''
 * @property varchar(50)  store_name '卖家店铺名称''
 * @property int(11)      buyer_id '买家id''
 * @property varchar(50)  buyer_name '买家姓名''
 * @property varchar(80)  buyer_email '买家电子邮箱''
 * @property tinyint(2)   buyer_type '用户类型，枚举|1-用户-USER|2-微信用户-USER_WX''
 * @property int(10,2)    order_amount '订单总价格''
 * @property int(10,2)    goods_amount '商品总价格''
 * @property int(10,2)    shipping_fee '运费''
 * @property tinyint(4)   order_state '订单状态，枚举|0-已取消-CANCEL|1-创建成功-CREATED|2-已付款-PAYED|3-已发货-DELAYED|40-已收货-DONE''
 * @property tinyint(4)   evaluation_state '评价状态，枚举|0-未评价-no|1-已评价-YES|2-已过期未评价-OVER''
 * @property tinyint(1)   refund_state '退款状态，枚举|0-无退款-NONE|1-部分退款-PART|2-全部-ALL''
 * @property tinyint(4)   store_del_state '商家删除状态, 枚举|0-未删除-NO|1-回收站-REC|2-永久删除-DEL''
 * @property tinyint(4)   buyer_del_state '买家删除状态, 枚举|0-未删除-NO|1-回收站-REC|2-永久删除-DEL''
 * @property tinyint(1)   is_lock '锁定状态，枚举|0-正常-NO|1-锁定-YES''
 * @property tinyint(1)   shipping_express_id '配送公司ID''
 * @property varchar(500) deliver_explain '发货备注''
 * @property varchar(300) order_message '订单留言''
 * @property varchar(500) invoice_info '发票信息''
 * @property mediumint(9) store_address_id '发货地址ID''
 * @property varchar(500) store_address '发货地址''
 * @property varchar(50)  reciver_name '收货人姓名''
 * @property varchar(50)  reciver_phone '收货人电话''
 * @property mediumint(8) reciver_province_id '收货人省级ID''
 * @property mediumint(8) reciver_city_id '收货人市级ID''
 * @property mediumint(8) reciver_area_id '收货人区级ID''
 * @property varchar(500) reciver_info '收货人其它信息''
 */
class TicketOrder extends BaseModel
{
    // 数据表名字
    protected $table = "tb_ticket_order";

    // 枚举字段
    const BUYER_TYPE_USER    = 1;    //用户类型:用户
    const BUYER_TYPE_USER_WX = 2;    //用户类型:微信用户

    const ORDER_STATE_CANCEL  = 0;    //订单状态:已取消
    const ORDER_STATE_CREATED = 1;    //订单状态:创建成功
    const ORDER_STATE_PAYED   = 2;    //订单状态:已付款
    const ORDER_STATE_DELAYED = 3;    //订单状态:已发货
    const ORDER_STATE_DONE    = 40;    //订单状态:已收货

    const EVALUATION_STATE_NO   = 0;    //评价状态:未评价
    const EVALUATION_STATE_YES  = 1;    //评价状态:已评价
    const EVALUATION_STATE_OVER = 2;    //评价状态:已过期未评价

    const REFUND_STATE_NONE = 0;    //退款状态:无退款
    const REFUND_STATE_PART = 1;    //退款状态:部分退款
    const REFUND_STATE_ALL  = 2;    //退款状态:全部

    const STORE_DEL_STATE_NO  = 0;    //商家删除状态:未删除
    const STORE_DEL_STATE_REC = 1;    //商家删除状态:回收站
    const STORE_DEL_STATE_DEL = 2;    //商家删除状态:永久删除

    const BUYER_DEL_STATE_NO  = 0;    //买家删除状态:未删除
    const BUYER_DEL_STATE_REC = 1;    //买家删除状态:回收站
    const BUYER_DEL_STATE_DEL = 2;    //买家删除状态:永久删除

    const IS_LOCK_NO  = 0;    //锁定状态:正常
    const IS_LOCK_YES = 1;    //锁定状态:锁定

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2017-11-24 14:39:33
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
        $query = $this->initPaged($query, $data);

        //排序参数
        $query = $this->initOrdered($query, $data);

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
     * @date 2017-11-24 14:39:33
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
        $model->sn                  = $data['sn'];
        $model->type                = $data['type'];
        $model->parent_id           = $data['parent_id'];
        $model->deliver_time        = $data['deliver_time'];
        $model->pay_time            = $data['pay_time'];
        $model->finnish_time        = $data['finnish_time'];
        $model->shipping_time       = $data['shipping_time'];
        $model->evaluation_time     = $data['evaluation_time'];
        $model->store_id            = $data['store_id'];
        $model->store_name          = $data['store_name'];
        $model->buyer_id            = $data['buyer_id'];
        $model->buyer_name          = $data['buyer_name'];
        $model->buyer_email         = $data['buyer_email'];
        $model->buyer_type          = $data['buyer_type'];
        $model->order_amount        = $data['order_amount'];
        $model->goods_amount        = $data['goods_amount'];
        $model->shipping_fee        = $data['shipping_fee'];
        $model->order_state         = $data['order_state'];
        $model->evaluation_state    = $data['evaluation_state'];
        $model->refund_state        = $data['refund_state'];
        $model->store_del_state     = $data['store_del_state'];
        $model->buyer_del_state     = $data['buyer_del_state'];
        $model->is_lock             = $data['is_lock'];
        $model->shipping_express_id = $data['shipping_express_id'];
        $model->deliver_explain     = $data['deliver_explain'];
        $model->order_message       = $data['order_message'];
        $model->invoice_info        = $data['invoice_info'];
        $model->store_address_id    = $data['store_address_id'];
        $model->store_address       = $data['store_address'];
        $model->reciver_name        = $data['reciver_name'];
        $model->reciver_phone       = $data['reciver_phone'];
        $model->reciver_province_id = $data['reciver_province_id'];
        $model->reciver_city_id     = $data['reciver_city_id'];
        $model->reciver_area_id     = $data['reciver_area_id'];
        $model->reciver_info        = $data['reciver_info'];

        // 保存信息
        $model->save();

        // 返回结果
        return $model;
    }
}
