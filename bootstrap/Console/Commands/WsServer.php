<?php

namespace Console\Commands;

use App\Modules\WsServer\Router;
use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Illuminate\Console\Command;
use Workerman\Worker;
use GatewayWorker\Lib\Gateway as WsSender;

class WsServer extends Command
{
    protected $webSocket;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws {action} {--d}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'workerman server';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 检查OS
        if (strpos(strtolower(PHP_OS), 'win') === 0) {
            $this->error("Sorry, not support for windows.\n");
            exit;
        }

        // 检查扩展
        if (!extension_loaded('pcntl')) {
            $this->error("Please install pcntl extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
            exit;
        }
        if (!extension_loaded('posix')) {
            $this->error("Please install posix extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
            exit;
        }

        //因为workerman需要带参数 所以得强制修改
        global $argv;
        $action = $this->argument('action');
        if (!in_array($action, ['start', 'stop', 'status'])) {
            $this->error('Error Arguments');
            exit;
        }
        $argv[0] = 'ws';
        $argv[1] = $action;
        $argv[2] = $this->option('d') ? '-d' : '';

        // BusinessWorker -- 必须是text协议
        new Register('text://0.0.0.0:' . config('gateway.register.port'));

        // BusinessWorker
        $worker                  = new BusinessWorker();
        $worker->name            = config('gateway.worker.name');
        $worker->count           = config('gateway.worker.count');
        $worker->registerAddress = config('gateway.register.host') . ':' . config('gateway.register.port');
        $worker->eventHandler    = 'Console\Commands\WsServer';

        // Gateway
        $gateway                  = new Gateway("websocket://0.0.0.0:" . config('gateway.port'));
        $gateway->name            = config('gateway.gateway.name');
        $gateway->count           = config('gateway.gateway.count');
        $gateway->lanIp           = config('gateway.gateway.lan_ip');
        $gateway->startPort       = config('gateway.gateway.startPort');
        $gateway->registerAddress = config('gateway.register.host') . ':' . config('gateway.register.port');
        $gateway->pingInterval    = 10;
        $gateway->pingData        = '{"action":"sys/ping","data":"0"}';

        Worker::runAll();
    }

    /**
     * 当客户端发来消息时触发
     * @param int   $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $message)
    {
        Router::init($client_id, $message);
    }

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     */
    public static function onConnect()
    {
        $result           = [];
        $result['action'] = "sys/connect";
        $result['msg']    = '连接成功！';
        $result['code']   = 9900;
        WsSender::sendToCurrentClient(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 进程启动后初始化数据库连接
     */
    public static function onWorkerStart()
    {

    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {

    }
}
