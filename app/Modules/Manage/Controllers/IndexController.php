<?php

namespace App\Modules\Manage\Controllers;

use App\Common\Code;
use App\Common\Msg;
use App\Common\UEditor\UEditorServer;
use App\Common\Wechat\WeChat;
use App\Common\WsServer\Client;
use App\Modules\Manage\Controllers\Base\BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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
        return ['index', 'wxBack', 'index3'];
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
     * index
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    public function index()
    {

        $userId     = 'otUf91eXE58FXeWLC8ycZ84TT_Eo';
        $templateId = 'R_eVqey3i_QnfWG7wbJmiQyWeHTVgXncN65AT8KyHjE';
        $url        = 'http://full.tkc8.com/app';
        $data       = array(
            "first"  => "恭喜你购买成功！",
            "name"   => "巧克力",
            "price"  => "39.8元",
            "remark" => "欢迎再次购买！",
        );

        $result = WeChat::app()->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        var_dump($result);
        die('hello world');
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

    /**
     * 微信回调
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    public function wxBack()
    {
        WeChat::app()->server->setMessageHandler(function ($message) {
            // $message['FromUserName'] // 用户的 openid
            // $message['MsgType'] // 消息类型：event, text....
            switch ($message->MsgType) {
                case 'event':
                    return '收到事件消息';
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
        });

        $response = WeChat::app()->server->serve();

        return $response;
    }
}
