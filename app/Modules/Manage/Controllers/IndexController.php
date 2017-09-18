<?php

namespace App\Modules\Manage\Controllers;

use App\Common\Wechat\WeChat;
use App\Common\WsServer\Client;
use App\Modules\Manage\Controllers\Base\BaseController;
use Illuminate\Support\Facades\Storage;

class IndexController extends BaseController
{
    /**
     * 设置不需要登录的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function noLogin()
    {
        return ['index'];
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
        $this->isNoAuth = true;
    }

    /**
     * 文件上传 ForCkEditor
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function uploadForCk()
    {
        $file     = request()->file('upload');
        $callback = request()->get("CKEditorFuncNum");

        // 文件是否上传成功
        if (!$file->isValid()) {
            die;
        }
        // 获取文件相关信息
        $originalName = $file->getClientOriginalName(); // 文件原名
        $type         = $file->getClientMimeType();     // image/jpeg
        $ext          = $file->getClientOriginalExtension();     // 扩展名
        $realPath     = $file->getRealPath();   //临时文件的绝对路径

        // 上传文件
        $filename = date('YmdHis') . '-' . uniqid() . '.' . $ext;
        Storage::disk('uploads')->put($filename, file_get_contents($realPath));

        echo "<script type=\"text/javascript\">";
        echo "window.parent.CKEDITOR.tools.callFunction(" . $callback . ",'" . "/uploads/" . $filename . "','')";
        echo "</script>";
        die;
    }

    public function index()
    {

        Client::sendToGroup(ServerController::WS_GROUP_CLIENT . '7', json_encode(['code' => '2222', 'msg' => 'asdasdasd', 'action' => '111111']));

        die('sssss2');
        $app = WeChat::app();

        $str = WeChat::user()->getWxAuthUrl();

        //$id =  WeChat::user()->getOpenId('ssss');

        var_dump($str);

        die;
        //$index = AdminMember::findById(4);
        //var_dump($index->toArray());

        /*  die('sss');
            return $this->ajaxReturn($index); */

        echo date('Y-m-d H:i:s', time());
        die();
    }

    public function index2()
    {
        die('sss - index2');
    }
}
