<?php
namespace App\Models;

use App\Common\Code;
use App\Common\Msg;
use App\Common\Visitor;
use App\Models\Base\BaseModel;

/**
 *
 * @author ChengCheng
 * @date 2017-08-14 10:34:11
 * @property int(11)      id '用户id''
 * @property varchar(50)  name '用户名称''
 * @property varchar(20)  real_name '真实姓名''
 * @property tinyint(4)   id_type '枚举-证件种类, 1=身份证''
 * @property varchar(250) id_no '证件号码''
 * @property tinyint(4)   checking_status '枚举-认证状态,0=未认证=no，1=认证''
 * @property datetime     checking_time '认证时间''
 * @property varchar(200) avatar '会员头像''
 * @property tinyint(1)   sex '性别 1男 2女''
 * @property date         birthday '生日''
 * @property varchar(100) passwd '密码''
 * @property tinyint(4)   member_level '用户级别 0 普通 1 VIP''
 * @property varchar(15)  mobile '手机号''
 * @property varchar(100) email '邮箱''
 * @property tinyint(4)   mobile_bind '0未绑定1已绑定''
 * @property tinyint(4)   email_bind '0未绑定1已绑定''
 * @property int(11)      login_times '登录次数''
 * @property datetime     reg_time '会员注册时间''
 * @property datetime     login_time '当前登录时间''
 * @property varchar(20)  login_ip '登录ip''
 * @property datetime     last_login_time '上次登录时间''
 * @property varchar(20)  last_login_ip '上次登录ip''
 * @property int(11)      score '会员积分''
 */
class UserMember extends BaseModel
{
    // 数据表名字
    protected $table = "tb_user_member";

    /**
     * 内置管理员 ID
     */
    const MEMBER_ADMIN = 1;

    /**
     * 用户所有分组
     */
    public function group()
    {
        return $this->belongsToMany('App\Models\UserGroup', 'tb_user_member_group', 'member_id', 'group_id')->whereNull('tb_user_member_group.delete_time');
    }

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2017-08-14 10:34:11
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
     * @date 2017-08-14 10:34:11
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
        $model->name            = $data['name'];
        $model->real_name       = $data['real_name'];
        $model->id_type         = $data['id_type'];
        $model->id_no           = $data['id_no'];
        $model->checking_status = $data['checking_status'];
        $model->checking_time   = $data['checking_time'];
        $model->avatar          = $data['avatar'];
        $model->sex             = $data['sex'];
        $model->birthday        = $data['birthday'];
        $model->passwd          = $data['passwd'];
        $model->member_level    = $data['member_level'];
        $model->mobile          = $data['mobile'];
        $model->email           = $data['email'];
        $model->mobile_bind     = $data['mobile_bind'];
        $model->email_bind      = $data['email_bind'];
        $model->login_times     = $data['login_times'];
        $model->reg_time        = $data['reg_time'];
        $model->login_time      = $data['login_time'];
        $model->login_ip        = $data['login_ip'];
        $model->last_login_time = $data['last_login_time'];
        $model->last_login_ip   = $data['last_login_ip'];
        $model->score           = $data['score'];

        // 保存信息
        $model->save();

        // 返回结果
        return $model;
    }

    /**
     * 登录,并且返回用户信息
     * @author ChengCheng
     * @date 2016年10月20日 16:12:06
     * @param string $memberId
     * @return array
     */
    public function login($memberId = null)
    {
        $model = $this;
        // 是否指定了memberId
        if (!empty($memberId)) {
            $model = self::findById($memberId);
        }

        // 记录登录信息
        $model->login_times     = $model->login_times + 1;      // 登录次数+1
        $model->last_login_time = $model->login_time;           // 上次登录时间
        $model->last_login_ip   = $model->login_ip;             // 登录IP
        $model->login_time      = Visitor::user()->time;       // 登录时间
        $model->login_ip        = Visitor::user()->ip;         // 登录IP

        // 保存用户信息
        $model->save();

        // 获取用户信息
        $info = $model->info();

        // 返回结果
        $result         = [];
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $info;
        return $result;
    }

    /**
     * 获取用户信息
     * @author ChengCheng
     * @date 2016年10月20日 16:12:06
     * @param string $memberId
     * @return array
     */
    public function info($memberId = null)
    {
        // 是否指定了memberId
        if (!empty($memberId)) {
            $this->id = $memberId;
        }

        // 关联分组查询member信息,auth信息
        $member = self::model()->with('group.auth')->where('id', $this->id)->first()->makeHidden('passwd')->toArray();

        //判断是否是管理员
        if ($this->id == self::MEMBER_ADMIN) {
            $member['isAdmin'] = true;
        } else {
            foreach ($member['group'] as $group) {
                if ($group['id'] == UserGroup::GROUP_ADMIN) {
                    $member['isAdmin'] = true;
                }
            }
        }

        // 根据分组获取权限信息,合并权限
        $auth      = [];
        $groupAuth = array_column($member['group'], 'auth');
        foreach ($groupAuth as $value) {
            foreach ($value as $authValue) {
                $auth[$authValue['id']] = $authValue;
            }
        }
        $member['auth'] = $auth;

        // 返回结果
        return $member;
    }
}
