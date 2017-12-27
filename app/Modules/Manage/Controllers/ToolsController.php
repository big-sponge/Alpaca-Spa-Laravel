<?php

namespace App\Modules\Manage\Controllers;

use App\Common\UEditor\UEditorServer;
use App\Modules\Manage\Controllers\Base\BaseController;
use Illuminate\Http\Request;

class ToolsController extends BaseController
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
     * ueditor 富文本编辑器
     * @author Chengcheng
     * @param Request $request
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    public function ueditor(Request $request)
    {
        return UEditorServer::process($request);
    }
}
