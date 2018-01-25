<?php

namespace App\Modules\Manage\Controllers;

use App\Common\QCos\QCos;
use App\Common\Visitor;
use App\Models\PhotoStore;
use App\Modules\Manage\Controllers\Base\BaseController;
use App\Common\Code;
use App\Common\Msg;

/**
 * PhotoStore
 * @author Chengcheng
 * @date 2018-01-24 09:32:27
 */
class PhotoController extends BaseController
{
    /**
     * 设置不需要登录的的Action,不加Action前缀
     * @author Chengcheng
     * @date 2018-01-24 09:32:27
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
     * @date 2018-01-24 09:32:27
     * @return array
     */
    protected function noAuth()
    {
        // 自定义角色权限
        $auth=[];

        //qCos权限
        $auth['qCos'] = function($result,$auth){
            if(!empty($auth[23])){
                return true;
            }
            return $result;
        };

        return $auth;
    }

    /**
     * qCos - 获取腾讯cos签名
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    public function qCos()
    {
        $method   = $this->input('method', 'POST');
        $pathname = $this->input('pathname', '/');

        $data = QCos::getAuthorization($method, $pathname);

        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;

        return $this->ajaxReturn($result);
    }

    /**
     * 列表
     * @author ChengCheng
     * @date 2018-01-24 09:32:27
     * @return array
     */
    public function getStoreList()
    {
        /*
         * 1 获取输入参数
         * pageNum              页码
         * pageSize             页面大小
         * orders               排序，数组结构，支持多维度排序
         * id                   ID
         * */
        $this->requestData['pageNum']  = $this->input('pageNum', null);
        $this->requestData['pageSize'] = $this->input('pageSize', null);
        $this->requestData['orders']   = $this->input('orders', null);
        $this->requestData['id']       = $this->input('id', null);

        //2 查找信息
        $data = PhotoStore::model()->lists($this->requestData);

        //3 设置返回结果
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;

        //4 返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 编辑
     * @author ChengCheng
     * @date 2018-01-24 09:32:27
     * @return array
     */
    public function editStore()
    {
        /*
         * 1 获取输入参数
         * id                  id
         * name                名称
         * size                大小
         * path                 原图地址URL
         * */
        $this->requestData['id']          = $this->input('id', null);
        $this->requestData['name']        = $this->input('name', '');
        $this->requestData['size']        = $this->input('size', '');
        $this->requestData['path']        = $this->input('path', null);
        $this->requestData['member_id']   = Visitor::user()->id;
        $this->requestData['member_type'] = 2;

        //1.2验证参数
        if (empty($this->requestData['path'])) {
            $result['code'] = Code::SYSTEM_PARAMETER_NULL;
            $result['msg']  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'path');
            return $this->ajaxReturn($result);
        }

        //2 编辑信息
        $data = PhotoStore::model()->edit($this->requestData);

        //3 设置结果
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;

        //4 返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 删除
     * @author ChengCheng
     * @date 2018-01-24 09:32:27
     * @return array
     */
    public function deleteStore()
    {
        //1 获取输入参数 id
        $id = $this->input('id', null);

        //2 检查参数
        if (empty($id)) {
            $result['code'] = Code::SYSTEM_PARAMETER_FORMAT_ERROR;
            $result['msg']  = sprintf(Msg::SYSTEM_PARAMETER_FORMAT_ERROR, 'id');
            return $this->ajaxReturn($result);
        }

        //3 删除
        $data           = PhotoStore::model()->where('id', $id)->delete();
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;
        //3 返回结果
        return $this->ajaxReturn($result);
    }
}
