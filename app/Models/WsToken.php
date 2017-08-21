<?php
namespace App\Models;

use App\Models\Base\BaseModel;

/**
 *
 * @author ChengCheng
 * @date 2017-08-19 15:09:07
 * @property int(11)     id 'id''
 * @property char(50)    member_id '用户id''
 * @property tinyint(2)  member_type '用户类型，枚举|1-用户-USER|2-管理员-ADMIN''
 * @property varchar(65) token 'TOKEN''
 * @property datetime    available_time '有效截至时间''
 */
class WsToken extends BaseModel
{
    // 数据表名字
    protected $table = "tb_ws_token";

    // 枚举字段
    const MEMBER_TYPE_USER    = 1;    //用户类型:用户
    const MEMBER_TYPE_ADMIN   = 2;    //用户类型:管理员
    const MEMBER_TYPE_USER_WX = 3;    //用户类型:用户-微信

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2017-08-19 15:09:07
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
     * @date 2017-08-19 15:09:07
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
        $model->member_id      = $data['member_id'];
        $model->member_type    = $data['member_type'];
        $model->token          = $data['token'];
        $model->available_time = $data['available_time'];

        // 保存信息
        $model->save();

        // 返回结果
        return $model;
    }

    /**
     * 生成token
     * @author ChengCheng
     * @date 2017-08-19 15:09:07
     * @param string $memberId
     * @param string $type
     * @param string $token
     * @return string
     */
    public function generate($memberId, $type, $token = null)
    {
        // 判断参数
        if (empty($token)) {
            $token = md5(rand() . uniqid(time(), true));
        }
        if ($type != static::MEMBER_TYPE_USER) {
            $type = static::MEMBER_TYPE_ADMIN;
        }

        //保存数据
        $model                 = new self;
        $model->member_id      = $memberId;
        $model->member_type    = $type;
        $model->token          = $token;
        $model->available_time = date('Y-m-d H:i:s', strtotime("+5 minute"));
        $model->save();

        //返回token
        return $token;
    }

    /**
     * 根据token查找用户Id
     * @author ChengCheng
     * @date 2017-08-19 15:09:07
     * @param string $token
     * @param string $type
     * @return string
     */
    public function check($token, $type)
    {
        // 判断参数
        if (empty($token)) {
            return null;
        }
        if ($type != static::MEMBER_TYPE_USER) {
            $type = static::MEMBER_TYPE_ADMIN;
        }

        // 查找token
        $wsToken = $this->where('token', $token)->where('member_type', $type)->first();
        if (empty($wsToken) || strtotime($wsToken->available_time) < time()) {
            return null;
        }
        // 保存信息
        $this->where('id', $wsToken->id)->forceDelete();

        // 返回结果
        return $wsToken->member_id;
    }
}
