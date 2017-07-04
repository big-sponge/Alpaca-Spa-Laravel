<?php

namespace App\Modules\Manage\Controllers;

use App\Modules\Manage\Controllers\Base\BaseController;

class IndexController extends BaseController
{
    /**
     * 设置不需要登录的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function withoutLoginActions()
    {
        return [];
    }

    /**
     * 设置不需要权限的的Action
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function withoutAuthActions()
    {
        // 当前控制器所有方法均不需要权限
        $this->isNoAuth = true;
    }

    public function index()
    {
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
