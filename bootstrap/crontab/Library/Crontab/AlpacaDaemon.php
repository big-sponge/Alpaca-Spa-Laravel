<?php

namespace Crontab\Library\Crontab;
/**
 * 守护进程
 * 登录验证，微信登录在这里
 * @author Chengcheng
 * @date 2016年10月21日 17:04:44
 */
class AlpacaDaemon
{
    private $daemon_json = __DIR__ . '/deamon.json';
    
    private static $instance;
    
    private $events = [];
    
    public static function daemon()
    {
        return self::getInstance();
    }
    
    private static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
            self::$instance->daemon_json = base_path('storage') . '/crontab/deamon.json';
        }
        return self::$instance;
    }

    public function setDaemon($daemon_json)
    {
        $this->daemon_json = $daemon_json;
        return $this;
    }
    
    public function setEvents(array $events)
    {
        $this->events = $events;
        return $this;
    }

    public function status()
    {
        $data = json_decode(file_get_contents($this->daemon_json),true);
        if(empty($data)){
            $data = array();
        }
        return $data;
    }
           
    public function stop()
    {
        $data =new \stdClass();
        $data->code="1001";
        $data->message="Stop at:".date("Y-m-d H:i:s" ,time());
        file_put_contents($this->daemon_json,json_encode($data),LOCK_EX);
        
        $result["result_code"] = "1";
        $result["result_message"] = "操作成功";
        return $result;
    }
        
    public function start()
    {
        $data = json_decode(file_get_contents($this->daemon_json) , true);
        if(empty($data)){
            $data['code']="1001";
        }
        
        if($data['code'] == "1000" ){
            //die("Error - exit,   Already running !");
            return;
        }

        $data['code']="1000";
        $data['message']="Start";
        file_put_contents($this->daemon_json,json_encode($data),LOCK_EX);

        while(true){
            $data = json_decode(file_get_contents($this->daemon_json) , true);
            if(empty($data) || empty($data['code']) || $data['code'] == "1001" ){
                break;
            }

            if(!empty($this->events)){
                foreach ($this->events as $e){
                    $e();
                }
            }
                        
            $data['message'] = date("Y-m-d H:i:s" ,time())." : Working ...";
            file_put_contents($this->daemon_json, json_encode($data), LOCK_EX);
            sleep(1);
        }
        $this->stop();
    }
}