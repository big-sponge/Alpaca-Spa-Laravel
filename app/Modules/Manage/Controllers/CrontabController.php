<?php

namespace App\Modules\Manage\Controllers;

use Crontab\Library\Crontab\AlpacaCrontab;
use Crontab\Library\Crontab\AlpacaDaemon;
use Crontab\Library\Crontab\AlpacaWorker;
use App\Modules\Manage\Controllers\Base\BaseController;
use App\Common\Code;
use App\Common\Msg;
use Illuminate\Support\Facades\Input;

/**
 * 定时任务管理控制器
 * @author Chengcheng
 * @date 2016-10-19 15:50:00
 */
class CrontabController extends BaseController
{
    /**
     * 设置不需要登录的的Action,不加Action前缀
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function withoutLoginActions()
    {
        return [];
    }

    /**
     * 设置不需要权限验证的Action,不加Action前缀
     * @author Chengcheng
     * @date   2016年10月23日 20:39:25
     * @return array
     */
    protected function withoutAuthActions()
    {
        // 以下Action不需要角色权限
        return [];
    }

    /**
     * 查看定时任务守护进程状态
     * @author Chengcheng
     * @date 2016-10-23 20:34:00
     */
    public function status()
    {
        //查看守护进程状态
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = AlpacaDaemon::daemon()->status();

        //返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 开始定时任务
     * @author Chengcheng
     * @date 2016-10-23 20:34:00
     */
    public function start()
    {
        //异步开启守护进程
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = AlpacaWorker::worker()->action(['REQUEST_URI' => "/crontab/index/start"]);

        //返回结果
        return $this->ajaxReturn($result);
    }

    /**
     * 停止定时任务守护进程
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
     * 添加,或者编辑定时任务
     * @author Chengcheng
     * @date 2016-10-23 20:34:00
     */
    public function editTask()
    {
        /*
         * 1 获取输入参数
         * BEGIN_TIME        开始时间
         * END_TIME          结束时间
         * INTERVAL          时间间隔
         * NAME              名称
         * STATUS            状态 1-ENABLED,   2-DISABLE
         * TASK_TYPE         类型 1-ONCE,      2-LOOP
         * ACTION            要执行的Action
         * INDEX             索引，null或者0时候，表示新建
         * */
        $this->requestData['NAME']       = $this->input('NAME', null);
        $this->requestData['BEGIN_TIME'] = $this->input('BEGIN_TIME', null);
        $this->requestData['END_TIME']   = $this->input('END_TIME', null);
        $this->requestData['INTERVAL']   = $this->input('INTERVAL', null);
        $this->requestData['TASK_TYPE']  = $this->input('TASK_TYPE', '1');
        $this->requestData['ACTION']     = $this->input('ACTION', null);
        $this->requestData['STATUS']     = $this->input('STATUS', '2');
        $this->requestData['INDEX']      = $this->input('INDEX', null);
        $this->requestData['LAST_TIME']  = $this->input('LAST_TIME', null);

        //2 检查参数
        if (empty($this->requestData['BEGIN_TIME'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'BEGIN_TIME');
            return $this->ajaxReturn($result);
        }
        if ($this->requestData['TASK_TYPE'] == 2 && empty($this->requestData['END_TIME'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'END_TIME');
            return $this->ajaxReturn($result);
        }
        if (empty($this->requestData['ACTION'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'ACTION');
            return $this->ajaxReturn($result);
        }
        if ($this->requestData['TASK_TYPE'] == 2 && empty($this->requestData['INTERVAL'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'INTERVAL');
            return $this->ajaxReturn($result);
        }

        //3 设置结束时间
        $now      = date('Y-m-d H:i:s', time());
        $nextTime = date('Y-m-d H:i:s', strtotime($this->requestData['INTERVAL'], strtotime($this->requestData['BEGIN_TIME'])));
        if ($this->requestData['TASK_TYPE'] == "1" || strtotime($now) < strtotime($this->requestData['BEGIN_TIME'])) {
            $nextTime = $this->requestData['BEGIN_TIME'];
        }

        //4 创建任务
        $task = array(
            'NAME'       => $this->requestData['NAME'],           //NAME
            'STATUS'     => $this->requestData['STATUS'],         // 1-ENABLED,   2-DISABLE
            'TYPE'       => $this->requestData['TASK_TYPE'],      // 1-ONCE,      2-LOOP
            'INTERVAL'   => $this->requestData['INTERVAL'],       //year（年），month（月），hour（小时）minute（分），second（秒）
            'BEGIN_TIME' => $this->requestData['BEGIN_TIME'],     //开始时间
            'NEXT_TIME'  => $nextTime,                            //下次执行时间
            'LAST_TIME'  => $this->requestData['LAST_TIME'],      //上次执行时间
            'ACTION'     => $this->requestData['ACTION'],         //执行的ACTION
            'END_TIME'   => $this->requestData['END_TIME'],       //截止时间2
        );

        //5 判断是新建还是修改
        if (empty($this->requestData['INDEX'])) {
            //新建
            $info = AlpacaCrontab::crontab()->addTask($task);
        } else {
            $this->requestData['INDEX'] -= 1;
            $info = AlpacaCrontab::crontab()->editTask($this->requestData['INDEX'], $task);
        }

        //5 返回结果
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $info;
        return $this->ajaxReturn($result);
    }

    /**
     * 设置定时任务状态
     * @author Chengcheng
     * @date 2016-10-23 20:34:00
     */
    public function changeTaskStatus()
    {
        /*
         * 1 获取输入参数
         * STATUS            状态 1-ENABLED,   2-DISABLE
         * INDEX             索引
         * */
        $this->requestData['STATUS'] = $this->input('STATUS', '2');
        $this->requestData['INDEX']  = $this->input('INDEX', null);

        //2 检查参数
        if (empty($this->requestData['STATUS'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'STATUS');
            return $this->ajaxReturn($result);
        }
        if (empty($this->requestData['INDEX'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'INDEX');
            return $this->ajaxReturn($result);
        }

        //3 修改状态
        $this->requestData['INDEX'] -= 1;
        $data = AlpacaCrontab::crontab()->editTaskStatus($this->requestData['INDEX'], $this->requestData['STATUS']);

        //4 返回结果
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;
        return $this->ajaxReturn($result);
    }

    /**
     * 查找单条定时任务
     * @author Chengcheng
     * @date 2016-10-23 20:34:00
     */
    public function getIndexTask()
    {
        /*
         * 1 获取输入参数
         * INDEX             索引
         * */
        $this->requestData['INDEX'] = $this->input('INDEX', null);

        //2 检查参数
        if (empty($this->requestData['INDEX'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'INDEX');
            return $this->ajaxReturn($result);
        }

        //3 删除
        $this->requestData['INDEX'] -= 1;
        $data = AlpacaCrontab::crontab()->getIndexTask($this->requestData['INDEX']);

        //4 返回结果
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;
        return $this->ajaxReturn($result);
    }

    /**
     * 删除定时任务
     * @author Chengcheng
     * @date 2016-10-23 20:34:00
     */
    public function removeTask()
    {
        /*
         * 1 获取输入参数
         * INDEX             索引
         * */
        $this->requestData['INDEX'] = $this->input('INDEX', null);

        //2 检查参数
        if (empty($this->requestData['INDEX'])) {
            $result["code"] = Code::SYSTEM_PARAMETER_NULL;
            $result["msg"]  = sprintf(Msg::SYSTEM_PARAMETER_NULL, 'INDEX');
            return $this->ajaxReturn($result);
        }

        //3 删除
        $this->requestData['INDEX'] -= 1;
        $data = AlpacaCrontab::crontab()->removeTask($this->requestData['INDEX']);

        //4 返回结果
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;
        return $this->ajaxReturn($result);
    }

    /**
     * 查看定时任务列表
     * @author Chengcheng
     * @date 2016-10-23 20:34:00
     */
    public function listTask()
    {
        //查找
        $data['task']   = AlpacaCrontab::crontab()->listTask();
        $data['total']  = count($data['task']);
        $data['status'] = AlpacaDaemon::daemon()->status();

        //返回结果
        $result['code'] = Code::SYSTEM_OK;
        $result['msg']  = Msg::SYSTEM_OK;
        $result['data'] = $data;
        return $this->ajaxReturn($result);
    }
}

