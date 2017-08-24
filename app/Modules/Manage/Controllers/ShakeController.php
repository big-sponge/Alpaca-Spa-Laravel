<?php

namespace App\Modules\Manage\Controllers;

use App\Common\Msg;
use App\Common\Visitor;
use App\Common\WsServer\Client;
use App\Models\ShakeActivity;
use App\Models\ShakeItem;
use App\Models\WsToken;
use App\Modules\Manage\Controllers\Base\BaseController;
use App\Common\Code;
use Endroid\QrCode\QrCode;

class ShakeController extends BaseController
{
    /**
     * 设置不需要登录的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noLogin()
    {
        return ['index','getQrCode'];
    }

    /**
     * 设置不需要权限的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noAuth()
    {
        // 当前控制器所有方法均不需要权限
        return ['index','getQrCode','getWsToken','getActivity','getItemList'];
    }

    /**
     * 获取token
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function getWsToken()
    {
        //获取参数
        $memberId = Visitor::adminMember()->id;

        //生成token
        $token = WsToken::model()->generate($memberId, WsToken::MEMBER_TYPE_ADMIN);

        //返回结果
        $result["code"] = Code::SYSTEM_OK;
        $result["msg"]  = Msg::SYSTEM_OK;
        $result["data"] = $token;
        return $this->ajaxReturn($result);
    }

    /**
     * 生成二维码
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function getQrCode()
    {
        $activityId = $this->input('activity_id');
        $url    = 'http://' . $_SERVER['HTTP_HOST'] . '/shake/wapp.html?activity_id='.$activityId;
        $logo   = base_path('public') . '/shake/screen/assets/img/qrcode_logo.png';
        $qrCode = new QrCode();
        $qrCode->setText($url)->setSize(300)->setMargin(10)->setBackgroundColor(array("r" => 255, "g" => 255, "b" => 255));
        if ($logo) {
            $qrCode->setLogoPath($logo)->setLogoWidth(60);
        }

        header('Content-Type:' . $qrCode->getContentType()); //image/png
        echo $qrCode->writeString();
        exit();
    }

    /**
     * 列表
     * @author ChengCheng
     * @date 2017-08-20 15:19:53
     * @return array
     */
    public function getActivityList()
    {
        /*
         * 1 获取输入参数
         * pageNum              页码
         * pageSize             页面大小
         * orders               排序，数组结构，支持多维度排序
         * id                   ID
         * */
        $this->requestData['pageNum']   = $this->input('pageNum', null);
        $this->requestData['pageSize']  = $this->input('pageSize', null);
        $this->requestData['orders']    = $this->input('orders', null);
        $this->requestData['id']        = $this->input('id', null);

        //2 查找信息
        $data = ShakeActivity::model()->lists($this->requestData);

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
     * @date 2017-08-20 15:19:53
     * @return array
     */
    public function editActivity()
    {
        /*
         * 1 获取输入参数
         * id                  活动id
         * merchant_id         所属商家ID
         * type                活动类型,枚举|1-微摇奖-YAO|2-微夺宝-DUO
         * name                名称
         * province_id         所属省
         * city_id             所属城市
         * start_time          开始时间
         * end_time            结束时间
         * business_name       举办商家
         * business_logo       商家LOGO
         * prize_address       兑奖地址
         * background_img      大屏背景图片
         * wechat_qrcode       手机端公众号二维码
         * wechat_qrcode_text  手机端公众号引导文案
         * */
        $this->requestData['id']                = $this->input('id', null);
        $this->requestData['merchant_id']       = $this->input('merchant_id', null);
        $this->requestData['type']              = $this->input('type', null);
        $this->requestData['name']              = $this->input('name', null);
        $this->requestData['province_id']       = $this->input('province_id', null);
        $this->requestData['city_id']           = $this->input('city_id', null);
        $this->requestData['start_time']        = $this->input('start_time', null);
        $this->requestData['end_time']          = $this->input('end_time', null);
        $this->requestData['business_name']     = $this->input('business_name', null);
        $this->requestData['business_logo']     = $this->input('business_logo', null);
        $this->requestData['prize_address']     = $this->input('prize_address', null);
        $this->requestData['background_img']    = $this->input('background_img', null);
        $this->requestData['wechat_qrcode']     = $this->input('wechat_qrcode', null);
        $this->requestData['wechat_qrcode_text']= $this->input('wechat_qrcode_text', null);

        //2 编辑信息
        $data = ShakeActivity::model()->edit($this->requestData);

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
     * @date 2017-08-20 15:19:53
     * @return array
     */
    public function deleteActivity()
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
        $data           = ShakeActivity::model()->where('id', $id)->delete();
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;
        //3 返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 获取指定activity信息
     * @author Chengcheng
     * @date 2016-10-21 09:00:00
     * @return string
     */
    public function getActivity()
    {
        //获取参数
        $activityId = $this->input('activity_id');
        $memberId   = Visitor::adminMember()->id;

        //验证参数
        if (empty($activityId)) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'activity_id');
            return $this->ajaxReturn($result);
        }

        //获取活动信息
        $activity = ShakeActivity::model()->findById($activityId);
        if (empty($activity)) {
            $result["code"] = Code::SYSTEM_ERROR;
            $result["msg"]  = "activity 不存在";
            return $this->ajaxReturn($result);
        }

        //获取当前轮次信息
        $item = ShakeItem::model()->curForAdmin($activityId);

        //生成token - 连接web-socket
        $token = WsToken::model()->generate($memberId, WsToken::MEMBER_TYPE_ADMIN);

        //返回结果
        $result["code"]             = Code::SYSTEM_OK;
        $result["msg"]              = Msg::SYSTEM_OK;
        $result["data"]['token']    = $token;
        $result["data"]['activity'] = $activity;
        $result["data"]['item']     = $item;
        return $this->ajaxReturn($result);
    }

    /**
     * 列表
     * @author ChengCheng
     * @date 2017-08-20 15:42:01
     * @return array
     */
    public function getItemList()
    {
        /*
         * 1 获取输入参数
         * pageNum              页码
         * pageSize             页面大小
         * orders               排序，数组结构，支持多维度排序
         * id                   ID
         * */
        $this->requestData['pageNum']   = $this->input('pageNum', null);
        $this->requestData['pageSize']  = $this->input('pageSize', null);
        $this->requestData['orders']    = $this->input('orders', null);
        $this->requestData['id']        = $this->input('id', null);

        //2 查找信息
        $data = ShakeItem::model()->lists($this->requestData);

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
     * @date 2017-08-20 15:42:01
     * @return array
     */
    public function editItem()
    {
        /*
         * 1 获取输入参数
         * id                  活动轮次ID
         * shake_limit         摇一摇次数(达到次数,活动结束)
         * win_limit           中奖人数限制
         * */
        $this->requestData['id']                = $this->input('id', null);
        $this->requestData['shake_limit']       = $this->input('shake_limit', null);
        $this->requestData['win_limit']         = $this->input('win_limit', null);

        //2 编辑信息
        $data = ShakeItem::model()->edit($this->requestData);

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
     * @date 2017-08-20 15:42:01
     * @return array
     */
    public function deleteItem()
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
        $data           = ShakeItem::model()->where('id', $id)->delete();
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;
        //3 返回结果
        return $this->ajaxReturn($result);
    }

}
