<?php

namespace App\Common\WsServer;

use GatewayClient\Gateway;
/**
 * Client
 * @author Chengcheng
 * @date 2016-10-20 15:50:00
 */
class Client extends  Gateway
{
    public static function getRegisterAddress()
    {
        return config('gateway.register.host').':'.config('gateway.register.port');
    }
}
