<?php
namespace App\Models;

use App\Models\Base\BaseModel;

/**
 *
 * @author ChengCheng
 * @date 2017-08-20 02:45:18
 * @property int(11)    id '活动id''
 * @property int(11)    merchant_id '所属商家ID''
 * @property tinyint(1) type '活动类型,枚举|1-微摇奖-YAO|2-微夺宝-DUO''
 * @property char(60)   name '名称''
 * @property int(11)    province_id '所属省''
 * @property int(11)    city_id '所属城市''
 * @property datetime   start_time '开始时间''
 * @property datetime   end_time '结束时间''
 * @property char(60)   business_name '举办商家''
 * @property char(200)  business_logo '商家LOGO''
 * @property char(100)  prize_address '兑奖地址''
 * @property char(200)  background_img '大屏背景图片''
 * @property char(200)  wechat_qrcode '手机端公众号二维码''
 * @property char(100)  wechat_qrcode_text '手机端公众号引导文案''
 */
class ShakeActivity extends BaseModel
{
    // 数据表名字
    protected $table = "tb_shake_activity";

    // 枚举字段
    const TYPE_YAO = 1;    //活动类型:微摇奖
    const TYPE_DUO = 2;    //活动类型:微夺宝

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2017-08-20 02:45:18
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
     * @date 2017-08-20 02:45:18
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
        $model->merchant_id        = $data['merchant_id'];
        $model->type               = $data['type'];
        $model->name               = $data['name'];
        $model->province_id        = $data['province_id'];
        $model->city_id            = $data['city_id'];
        $model->start_time         = $data['start_time'];
        $model->end_time           = $data['end_time'];
        $model->business_name      = $data['business_name'];
        $model->business_logo      = $data['business_logo'];
        $model->prize_address      = $data['prize_address'];
        $model->background_img     = $data['background_img'];
        $model->wechat_qrcode      = $data['wechat_qrcode'];
        $model->wechat_qrcode_text = $data['wechat_qrcode_text'];

        // 保存信息
        $model->save();

        // 返回结果
        return $model;
    }
}
