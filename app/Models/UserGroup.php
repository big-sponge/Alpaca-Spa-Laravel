<?php
namespace App\Models;

use App\Models\Base\BaseModel;

/**
 *
 * @author ChengCheng
 * @date 2017-08-14 10:34:51
 * @property int(11)      id '分组id''
 * @property varchar(50)  name '分组名称''
 * @property varchar(255) desc '分组描述''
 */
class UserGroup extends BaseModel
{
    // 数据表名字
    protected $table = "tb_user_group";

    // 默认管理员分组ID
    const GROUP_ADMIN = 1;    //管理分组Id，对应为Group表中 Id =1

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2017-08-14 10:34:51
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
     * @date 2017-08-14 10:34:51
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
        $model->name = $data['name'];
        $model->desc = $data['desc'];

        // 保存信息
        $model->save();

        // 返回结果
        return $model;
    }
}
