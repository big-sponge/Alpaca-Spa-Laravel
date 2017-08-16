<?php

namespace Crontab\Controllers;

use Crontab\Common\Code;
use Crontab\Common\Msg;
use Crontab\Controllers\Base\BaseController;
use Crontab\Library\Crontab\AlpacaCrontab;
use Crontab\Library\Crontab\AlpacaDaemon;
use Crontab\Library\Crontab\AlpacaWorker;

/**
 * index
 * @author Chengcheng
 * @date 2017-02-22 15:50:00
 */
class IndexController extends BaseController
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
     * 开始定时任务的守护进程
     * @author Chengcheng
     * @date 2016-10-23 20:34:00
     */
    public function start()
    {

        //开始守护进程
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;

        //在守护进程中注入定时任务
        $events = ['0'=>function(){
            AlpacaWorker::worker()->action(['REQUEST_URI'=>"/crontab/index/task"]);
        }];
        AlpacaDaemon::daemon()->setEvents($events);
        AlpacaDaemon::daemon()->start();

        //返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 停止定时任务的守护进程
     * @author Chengcheng
     * @date 2016-10-23 20:34:00
     */
    public function stop()
    {
        //停止守护进程
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = AlpacaDaemon::daemon()->stop();

        //返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 执行定时任务
     * @author Chengcheng
     * @date 2016-10-23 20:34:00
     */
    public function task()
    {
        //执行定时任务
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = AlpacaCrontab::crontab()->doTask();

        //返回结果
        return $this->ajaxReturn($result);
    }
}
 