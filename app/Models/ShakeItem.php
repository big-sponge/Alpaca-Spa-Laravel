<?php
namespace App\Models;

use App\Models\Base\BaseModel;

/**
 *
 * @author ChengCheng
 * @date 2017-08-20 10:34:45
 * @property int(11)      id '活动轮次ID''
 * @property int(11)      activity_id '对应活动表ID''
 * @property int(11)      item_index '轮次数''
 * @property mediumint(8) shake_limit '摇一摇次数(达到次数,活动结束)''
 * @property mediumint(8) win_limit '中奖人数限制''
 * @property int(11)      part_count '参与人数''
 * @property int(11)      subscribe_count '关注公众号人数''
 * @property datetime     start_time '活动开始时间.用来标识具活动3分钟未达到限制次数自动结束游戏''
 * @property int(11)      time_slot '时段''
 * @property int(11)      time_slot_sign '时段标记(页面点击结束时+1)''
 * @property tinyint(1)   status '状态,枚举|1-未开始-WAIT|2-进行中-DOING|3-已结束-DONE',
 */
class ShakeItem extends BaseModel
{
    // 数据表名字
    protected $table = "tb_shake_item";

    // 枚举字段
    const STATUS_WAIT  = 1;    //状态:未开始
    const STATUS_DOING = 2;    //状态:进行中
    const STATUS_DONE  = 3;    //状态:结束

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2017-08-20 10:34:45
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
     * @date 2017-08-20 10:34:45
     * @param array $data
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
        if (isset($data['activity_id'])) {
            $model->activity_id = $data['activity_id'];
        }
        if (isset($data['shake_limit'])) {
            $model->shake_limit = $data['shake_limit'];
        }
        if (isset($data['win_limit'])) {
            $model->win_limit = $data['win_limit'];
        }
        if (isset($data['start_time'])) {
            $model->start_time = $data['start_time'];
        }
        if (isset($data['status'])) {
            $model->status = $data['status'];
        }

        // 保存信息
        $model->save();

        // 返回结果
        return $model;
    }

    /**
     * 获取当前活动 - 没有可进行的活动时候，创建新活动
     * @author ChengCheng
     * @date 2017-08-20 10:34:45
     * @param string $activityId
     * @return static
     */
    public function curForAdmin($activityId)
    {
        // 查找信息
        $query = $this;
        $query = $query->where('activity_id', $activityId);
        $query = $query->whereIn('status', [static::STATUS_WAIT, static::STATUS_DOING]);
        $model = $query->first();

        // 找到信息 - 返回结果
        if (!empty($model)) {
            return $model;
        }

        // 没有找到 - 创建新的
        $model              = new self;
        $model->activity_id = $activityId;
        $model->item_index  = $this->where('activity_id', $activityId)->count() + 1;
        $model->shake_limit = 30;
        $model->win_limit   = 3;
        $model->save();

        // 返回结果
        return $model;
    }

    /**
     * 获取当前活动
     * @author ChengCheng
     * @date 2017-08-20 10:34:45
     * @param string $activityId
     * @return static
     */
    public function cur($activityId)
    {
        // 查找信息
        $query = $this;
        $model = $query->where('activity_id', $activityId)->orderBy('create_time','desc')->first();
        // 返回结果
        return $model;
    }
}
