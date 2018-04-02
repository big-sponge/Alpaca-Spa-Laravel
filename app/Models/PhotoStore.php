<?php
namespace App\Models;

use App\Models\Base\BaseModel;

/**
 *
 * @author ChengCheng
 * @date 2018-01-24 09:32:27
 * @property int(11)     id 'id''
 * @property varchar(50) name '名称''
 * @property int(11)     size '大小''
 * @property char(255)   path '原图地址URL''
 * @property int(11)     member_id '用户ID''
 * @property tinyint(2)  member_type '用户类型，枚举|1-用户-USER|2-管理员-ADMIN''
 */
class PhotoStore extends BaseModel
{
    // 数据表名字
    protected $table = "tb_photo_store";

    // 枚举字段
    const MEMBER_TYPE_USER  = 1;    //用户类型:用户
    const MEMBER_TYPE_ADMIN = 2;    //用户类型:管理员

    /**
     * 用户
     */
    public function member()
    {
        return $this->hasOne('App\Models\AdminMember', 'id', 'member_id');
    }

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2018-01-24 09:32:27
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

        if (isset($data['page'])) {
            $query = $query->where('pageSize', $data['id']);
        }

        //总数
        $total = $query->count();

        //分页参数
        $query = $this->initPaged($query, $data);

        //排序参数
        $query = $this->initOrdered($query, $data);

        //关联
        $query = $query->with(['member' => function ($query) {
            $query->select('id','name');
        }]);

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
     * @date 2018-01-24 09:32:27
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
        $model->name        = $data['name'];
        $model->size        = $data['size'];
        $model->path        = $data['path'];
        $model->member_id   = $data['member_id'];
        $model->member_type = $data['member_type'];


        // 保存信息
        $model->save();

        // 返回结果
        return $model;
    }
}
