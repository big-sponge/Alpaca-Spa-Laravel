<?php

namespace Crontab\Library\Crontab;
class AlpacaWorker
{        
    private static $instance;

    private $accessToken = '';
    
    public static function worker()
    {
        return self::getInstance();
    }
    
    private static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
            self::$instance->accessToken= 'VyKfohBbwlkTOqp2jvIWPW92';
        }
        return self::$instance;
    }
        
    public function action(array $worker = null)
    {
        //获取参数
        $ip   = empty($worker['SERVER_ADDR']) ? $_SERVER['SERVER_NAME'] : $worker['SERVER_ADDR'];     //服务器IP地址
        $port = empty($worker['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : $worker['SERVER_PORT'];     //服务器端口
        $url  = empty($worker['REQUEST_URI']) ? '/' :$worker['REQUEST_URI'];                          //服务器URL
        $data = empty($worker['REQUEST_DATA']) ? '' :$worker['REQUEST_DATA'];                         //请求参数

        //格式化请求参数
        $postData = "";
        $needChar = false;
        if(is_array($data)){
            foreach($data as $key => $val) {
                $postData .= ($needChar ? "&" : "") . urlencode($key) . "=" . urlencode($val);
                $needChar = true;
            }
        }else{
            $postData = $data;
        }

        $url=$url."?accessToken=".$this->accessToken;

        try{
            //使用fsockopen方式异步调用action
            $fp = fsockopen("$ip", $port, $errno, $errstr,1);
            if (!$fp) {
                return 'worker error:'."$errstr ($errno)<br />\n";
            } else {
                $out = "POST $url HTTP/1.1\r\n";
                $out .= "Host: $ip\r\n";
                $out .= "Content-Type:application/x-www-form-urlencoded; charset=UTF-8\r\n";
                $out .= "Content-Length: " . strlen($postData) . "\r\n";
                $out .= "Connection: close\r\n";
                $out .="\r\n";
                $out .=$postData;
                fputs($fp, $out);
                fclose($fp);
            }
        }catch(\Exception $e){

        }

        return 'worker success!';
    }
}