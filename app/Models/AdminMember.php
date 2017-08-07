<?php
namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

/**
 *
 * @author ChengCheng
 * @date 2017-04-12 15:13:28
 * @property int(11)      id '用户id''
 * @property varchar(50)  name '用户名称''
 * @property varchar(20)  real_name '真实姓名''
 * @property tinyint(4)   id_type '证件种类 1身份证''
 * @property varchar(250) id_no '证件号码''
 * @property tinyint(4)   checking_status '认证状态 0未认证,1认证''
 * @property datetime     checking_time '认证时间''
 * @property varchar(200) avatar '会员头像''
 * @property tinyint(1)   sex '性别 1男 2女''
 * @property date         birthday '生日''k
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
 * @property tinyint(1)   status '状态 1为正常 0为冻结''
 * @property tinyint(2)   is_del '0可用 1不可用''
 * @property datetime     update_time '更新时间''
 * @property datetime     audit_time '审核时间''
 * @property datetime     create_time '创建时间''
 * @property datetime     delete_time '删除时间''
 * @property varchar(64)  creator '创建人id''
 * @property varchar(64)  updater '更新人id''
 * @property varchar(16)  ip '加入IP''
 * @property tinyint(4)   level '排序字段 0-9权值''
 */
class AdminMember extends BaseModel
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'tb_admin_member';

    /**
     * 内置管理员 ID
     */
    const MEMBER_ADMIN = 1;

    /**
     * 用户所有分组
     */
    public function group()
    {
        return $this->belongsToMany('App\Models\AdminGroup','tb_admin_member_group','member_id','group_id')->whereNull('tb_admin_member_group.delete_time');
    }

    /**
     * 分页查询
     * @author ChengCheng
     * @date 2016年10月20日 16:12:06
     * @param string $data
     * @return array
     */
    public function getPageList($data)
    {
        //查询条件
        $query = $this;

        //根据id查询
        if (isset($data['id'])) {
            $query = $query->where('id', $data['id']);
        }
        if (isset($data['key'])) {
            $query = $query->where('name', 'like', "%".$data['key']."%");
        }

        //总数
        $total = $query->count();

        //分页参数
        $pageSize = isset($data['pageSize']) ? $data['pageSize'] : 0;
        $pageNum  = isset($data['pageNum']) ? $data['pageNum'] : 1;
        if(!empty($pageSize)){
            $query = $query->limit($pageSize);
        }

        if(!empty($pageSize) && !empty($pageNum)){
            $query = $query->offset(($pageNum-1)*$pageSize);
        }

        //排序参数
        if(!empty($data['orders'])){
            foreach($data['orders'] as $order){
                $query = $query->orderBy($order[0],$order[1]);
            }
        }else{
            $query = $query->orderBy('id','desc');
        }

        //分页查找
        $info = $query->with('group')->get()->makeHidden('passwd');

        //返回结果，查找数据列表，总数
        $result          = array();
        $result['list']  = $info->toArray();
        $result['total'] = $total;
        return $result;
    }

    /**
     * 保存用户登录信息
     * @author ChengCheng
     * @date 2016年10月20日 16:12:06
     * @param string $visitIP 登录IP
     * @param string $visitTime 登录时间
     */
    public function login($visitIP, $visitTime)
    {
        //记录登录信息
        $this->login_times     = $this->login_times + 1;      // 登录次数+1
        $this->last_login_time = $this->login_time;           // 上次登录时间
        $this->last_login_ip   = $this->login_ip;             // 登录IP
        $this->login_time      = $visitTime;                  // 登录时间
        $this->login_ip        = $visitIP;                    // 登录IP

        // 保存用户信息
        $this->save();
    }

    /**
     * 获取用户信息
     * @author ChengCheng
     * @date 2016年10月20日 16:12:06
     * @param string $memberId
     * @return array
     */
    public function getMemberInfo($memberId = null)
    {
        //是否指定了memberId
        if (!empty($memberId)) {
            $this->id = $memberId;
        }

        //关联分组查询member信息,auth信息
        $member = self::model()->with('group.auth')->where('id', $this->id)->first()->toArray();
        //判断是否是管理员
        if ($this->id == self::MEMBER_ADMIN) {
            $member['isAdmin'] = true;
        } else {
            foreach ($member['group'] as $group) {
                if ($group['id'] == AdminGroup::GROUP_ADMIN) {
                    $member['isAdmin'] = true;
                }
            }
        }

        //根据分组获取权限信息,合并权限
        $auth      = [];
        $groupAuth = array_column($member['group'], 'auth');
        foreach ($groupAuth as $value) {
            foreach ($value as $authValue) {
                $auth[$authValue['id']] = $authValue;
            }
        }
        $member['auth'] = $auth;

        //返回结果
        return $member;
    }
}