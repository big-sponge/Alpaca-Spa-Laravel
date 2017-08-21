<?php
namespace App\Models;

use App\Models\Base\BaseModel;

/**
 *
 * @author ChengCheng
 * @date 2017-08-20 10:34:28
 * @property int(11)    id '摇一摇参与ID''
 * @property int(11)    activity_id '活动ID''
 * @property int(11)    item_id '摇一摇ID''
 * @property int(11)    item_index '参与轮次''
 * @property int(11)    user_id '用户ID''
 * @property char(64)   nickname '用户昵称''
 * @property char(150)  avatar '头像''
 * @property tinyint(1) is_subscribe '是否关注公众号.0否,1是''
 * @property int(11)    shake_count '摇一摇次数''
 * @property int(11)    user_rank '用户名次''
 * @property char(50)   ticket '票根''
 * @property tinyint(1) ticket_status '状态,枚举|0-未获取-NONE|1-未使用-UNUSED|2-已使用-DONE''
 * @property timestamp  ticket_time '兑奖时间''
 */
class ShakeRecord extends BaseModel
{
    // 数据表名字
    protected $table = "tb_shake_record";

    // 枚举字段
    const TICKET_STATUS_NONE   = 0;    //状态:未获取
    const TICKET_STATUS_UNUSED = 1;    //状态:未使用
    const TICKET_STATUS_DONE   = 2;    //状态:已使用

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2017-08-20 10:34:28
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
     * @date 2017-08-20 10:34:28
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
        $model->activity_id   = $data['activity_id'];
        $model->item_id       = $data['item_id'];
        $model->item_index    = $data['item_index'];
        $model->user_id       = $data['user_id'];
        $model->nickname      = $data['nickname'];
        $model->avatar        = $data['avatar'];
        $model->is_subscribe  = $data['is_subscribe'];
        $model->shake_count   = $data['shake_count'];
        $model->user_rank     = $data['user_rank'];
        $model->ticket        = $data['ticket'];
        $model->ticket_status = $data['ticket_status'];
        $model->ticket_time   = $data['ticket_time'];

        // 保存信息
        $model->save();

        // 返回结果
        return $model;
    }

    /**
     * 添加一条记录
     * @author ChengCheng
     * @date 2017-08-20 10:34:28
     * @return array|null
     */
    public function record()
    {
        $model = self::model()->where('item_id', $this->item_id)->where('user_id', $this->user_id)->first();
        if (empty($model)) {
            $this->save();
            return true;
        }

        // 填充字段
        $model->activity_id   = $this->activity_id;
        $model->item_id       = $this->item_id;
        $model->item_index    = $this->item_index;
        $model->user_id       = $this->user_id;
        $model->nickname      = $this->nickname;
        $model->avatar        = $this->avatar;
        $model->shake_count   = $this->shake_count;
        $model->user_rank     = $this->user_rank;
        $model->ticket_status = $this->ticket_status;

        // 保存信息
        $model->save();

        // 返回结果
        return true;
    }
}
