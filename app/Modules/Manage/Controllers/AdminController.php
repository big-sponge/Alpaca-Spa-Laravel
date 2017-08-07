<?php

namespace App\Modules\Manage\Controllers;

use App\Common\Lib\Validate;
use App\Models\AdminAuth;
use App\Models\AdminGroup;
use App\Modules\Manage\Controllers\Base\BaseController;
use App\Common\Code;
use App\Common\Msg;
use App\Models\AdminMember;
use App\Modules\Manage\Service\AdminService;

/**
 * 用户
 * @author Chengcheng
 * @date 2016-10-19 15:50:00
 */
class AdminController extends BaseController
{
    /**
     * 设置不需要登录的的Action,不加Action前缀
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noLogin()
    {
        // 以下Action不需要登录权限
        return [];
    }

    /**
     * 设置不需要权限验证的Action,不加Action前缀
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noAuth()
    {
        // 以下Action不需要角色权限
        return [];
    }

    /**
     * 用户 - 列表
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function getMemberList()
    {
        /*
         * 1 获取输入参数
         * pageNum              页码
         * pageSize             页面大小
         * orderBy              排序字段
         * orderDir             排序方向
         * id                   分组ID
         * name                 用户name(可选-查询条件)
         * groupId              分组Id(可选-查询条件)
         * departmentId         部门Id(可选-查询条件)
         * */
        $this->requestData['pageNum']       = $this->input('pageNum', '1');
        $this->requestData['pageSize']      = $this->input('pageSize', '20');
        $this->requestData['orders']        = $this->input('orders', null);
        $this->requestData['id']            = $this->input('id', null);
        $this->requestData['name']          = $this->input('name', null);
        $this->requestData['group_id']      = $this->input('groupId', null);
        $this->requestData['department_id'] = $this->input('departmentId', null);
        $this->requestData['key']           = $this->input('key', null);

        //2.1 查找用户信息
        $data = AdminMember::model()->getPageList($this->requestData);

        //3 返回结果
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;

        //4 返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 用户 - 编辑
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function editMember()
    {
        /*
        * 1 获取输入参数
        * name             名字
        * passwd           密码
        * email            邮箱
        * mobile           手机
        * groups           分组Id数组
        * id               id
        * */
        $this->requestData['name']   = $this->input('name', '未命名');
        $this->requestData['passwd'] = $this->input('passwd', null);
        $this->requestData['email']  = $this->input('email', null);
        $this->requestData['mobile'] = $this->input('mobile', null);
        $this->requestData['groups'] = $this->input('groups', null);
        $this->requestData['id']     = $this->input('id', null);

        //默认给予新添加用户【发布需求分组】的分组权限

        //2 检查参数
        if (empty($this->requestData['passwd']) && empty($this->requestData['id'])) {
            //新增状态验证passwd是否为空
            $result['code'] = Code::SYSTEM_PARAMETER_NULL;
            $result['msg']  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'passwd');
            return $this->ajaxReturn($result);
        }
        if (empty($this->requestData['email'])) {
            $result['code'] = Code::SYSTEM_PARAMETER_NULL;
            $result['msg']  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'email');
            return $this->ajaxReturn($result);
        }

        if (!empty($this->requestData['groups']) && !is_array($this->requestData['groups'])) {
            $result['code'] = Code::SYSTEM_PARAMETER_FORMAT_ERROR;
            $result['msg']  = sprintf(Msg::SYSTEM_PARAMETER_FORMAT_ERROR, 'groups');
            return $this->ajaxReturn($result);
        }
        if (!Validate::isEmail($this->requestData['email'])) {
            $result['code'] = Code::SYSTEM_PARAMETER_FORMAT_ERROR;
            $result['msg']  = sprintf(Msg::SYSTEM_PARAMETER_FORMAT_ERROR, 'email');
            return $this->ajaxReturn($result);
        }

        //格式化groups
        if (empty($this->requestData['groups'])) {
            $this->requestData['groups'] = [];
        }

        //2 添加用户信息
        $result = AdminService::editMemberWithGroups($this->requestData);

        //3 返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 用户 - 删除
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function deleteMember()
    {
        //1 获取输入参数 id
        $this->requestData['id'] = $this->input('id', null);

        //2 检查参数
        if (empty($this->requestData['id'])) {
            $result['code'] = Code::SYSTEM_PARAMETER_FORMAT_ERROR;
            $result['msg']  = sprintf(Msg::SYSTEM_PARAMETER_FORMAT_ERROR, 'id');
            return $this->ajaxReturn($result);
        }

        //3 id =1是内置管理员，不可以删除
        if ($this->requestData['id'] == 1) {
            $result['code'] = Code::SYSTEM_PARAMETER_FORMAT_ERROR;
            $result['msg']  = "内置默认管理员不可以被删除！";
            return $this->ajaxReturn($result);
        }

        //4 删除
        $data           = AdminMember::model()->where('id', $this->requestData['id'])->delete();
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;

        //5 返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 分组 - 列表
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function getGroupList()
    {
        /*
         * 1 获取输入参数
         * pageNum              页码
         * pageSize             页面大小
         * orders               排序字段
         * id                   分组ID
         * */
        $this->requestData['pageNum']  = $this->input('pageNum', '1');
        $this->requestData['pageSize'] = $this->input('pageSize', '20');
        $this->requestData['orders']   = $this->input('orders', null);
        $this->requestData['id']       = $this->input('id', null);
        $this->requestData['key']      = $this->input('key', null);

        //2 查找用户信息
        $data = AdminGroup::model()->getPageList($this->requestData);

        //3 设置返回结果
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;

        //4 返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 分组 - 编辑
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function editGroup()
    {

        //1 获取输入参数,name 分组名称，desc 分组描述, powers 权限id数组
        $this->requestData['name']   = $this->input('name', null);
        $this->requestData['desc']   = $this->input('desc', null);
        $this->requestData['powers'] = $this->input('powers', null);
        $this->requestData['id']     = $this->input('id', null);

        //2.1 验证FName，FDesc是否为空
        if (empty($this->requestData['name'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, '姓名');
            return $this->ajaxReturn($result);
        }

        //2.2 验证手机号码是否为空
        if (empty($this->requestData['desc'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, '描述');
            return $this->ajaxReturn($result);
        }

        //2.3 权限id数组格式
        if (!is_array($this->requestData['powers']) && $this->requestData['powers'] != null) {
            $result["code"] = Code::SYSTEM_PARAMETER_FORMAT_ERROR;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_FORMAT_ERROR, 'powers');
            return $this->ajaxReturn($result);
        }

        //格式化groups
        if (empty($this->requestData['powers'])) {
            $this->requestData['powers'] = [];
        }

        //3 添加分组
        $result = AdminService::editGroupWithAuth($this->requestData);

        //4 返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 分组 - 删除
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function deleteGroup()
    {
        //1 获取输入参数 id
        $this->requestData['id'] = $this->input('id', null);

        //2 检查参数
        if (empty($this->requestData['id'])) {
            $result['code'] = Code::SYSTEM_PARAMETER_FORMAT_ERROR;
            $result['msg']  = sprintf(Msg::SYSTEM_PARAMETER_FORMAT_ERROR, 'id');
            return $this->ajaxReturn($result);
        }

        //3 id =1是内置管理员，不可以删除
        if ($this->requestData['id'] == 1) {
            $result['code'] = Code::SYSTEM_PARAMETER_FORMAT_ERROR;
            $result['msg']  = "内置默认管理员分组不可以被删除！";
            return $this->ajaxReturn($result);
        }

        //4 删除
        $data           = AdminGroup::model()->where('id', $this->requestData['id'])->delete();
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;

        //5 返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 权限 - 列表
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function getAuthList()
    {
        /*
         * 1 获取输入参数
         * pageNum              页码
         * pageSize             页面大小
         * orderBy              排序字段
         * orderDir             排序方向
         * id                   分组ID
         * */
        $this->requestData['pageNum']  = $this->input('pageNum', '1');
        $this->requestData['pageSize'] = $this->input('pageSize', '20');
        $this->requestData['orders']   = $this->input('orders', null);
        $this->requestData['id']       = $this->input('id', null);

        //2 查找信息
        $data = AdminAuth::model()->getPageList($this->requestData);

        //3 设置返回结果
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;

        //4 返回结果
        return $this->ajaxReturn($result);
    }
}
 