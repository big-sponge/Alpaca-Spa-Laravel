<?php

namespace Crontab\Controllers;

use Crontab\Controllers\Base\BaseController;
use Illuminate\Support\Facades\Log;

use App\Common\Code;
use App\Common\Msg;


/**
 * index
 * @author Chengcheng
 * @date 2017-02-22 15:50:00
 */
class TaskController extends BaseController
{
    /**
     * 设置不需要登录的的Action,不加Action前缀
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function withoutLoginActions()
    {

    }

    /**
     * 测试任务
     * @author Chengcheng
     * @date 2016-10-23 20:34:00
     */
    public function test()
    {
        //执行定时任务
        Log::info('task  ---  run --- :'.date('Y-m-d H:i:s'));

        //返回结果
        return $this->ajaxReturn('ok');
    }
}
 