<?php

namespace Console\Commands;

use App\Modules\WsServer\Router;
use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Illuminate\Console\Command;
use Workerman\Worker;
use GatewayWorker\Lib\Gateway as WsSender;

class Daemon extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'daemon test';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daemon {action} {--d}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $command = [];

    /**
     * 容许的命令动作
     *
     * @var string
     */
    protected $actions = ['start', 'stop', 'restart', 'reload', 'status'];

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 检查运行依赖环境
     * @return mixed
     */
    public function checkEnv()
    {
        // 检查OS
        if (strpos(strtolower(PHP_OS), 'win') === 0) {
            $this->error("Sorry, not support for windows.\n");
            exit;
        }
        // 检查扩展-pcntl
        if (!extension_loaded('pcntl')) {
            $this->error("Please install pcntl extension.\n");
            exit;
        }
        // 检查扩展-posix
        if (!extension_loaded('posix')) {
            $this->error("Please install posix extension.\n");
            exit;
        }
        // 只允许在cli下面运行
        if (php_sapi_name() != "cli") {
            $this->error("only run in command line mode.\n");
            exit;
        }

        //检查命令格式
        $action = $this->argument('action');
        if (!in_array($action, $this->actions)) {
            $this->error("Usage: php yourfile.php {start|stop|restart|reload|status}\n");
            exit;
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //检查运行环境、参数等
        $this->checkEnv();

        //装载命令
        $command[0]    = 'daemon';
        $command[1]    = $this->argument('action');
        $command[2]    = $this->option('d') ? '-d' : '';
        $this->command = $command;

        //设置保存进程id的文件
        $pid_file = base_path('storage/daemon/') . 'pid_daemon.pid';

        // 获取主进程id
        $master_pid      = @file_get_contents($pid_file);
        $master_is_alive = $master_pid && @posix_kill($master_pid, 0);

        // 判断进程是否还在执行
        if ($master_is_alive && ($command[1] === 'start' && posix_getpid() != $master_pid)) {
            $this->info("Daemon already running!");
            exit;
        }

        if (!$master_is_alive && $command[1] === 'stop') {
            $this->info("Daemon not run!");
            exit;
        }

        // 执行命令
        switch ($command[1]) {
            case 'start':
                break;
            case 'stop':
                $this->info("Daemon is stopping ...");
                $master_pid && posix_kill($master_pid, SIGINT);
                $timeout    = 5;
                $start_time = time();
                while (1) {
                    $master_is_alive = $master_pid && posix_kill($master_pid, 0);
                    if ($master_is_alive) {
                        if (time() - $start_time >= $timeout) {
                            $this->error("Timeout,stopped error!");
                            exit;
                        }
                        usleep(10000);
                        continue;
                    }
                    $this->info("Daemon has stopped!");
                    exit;
                }
                break;
            default :
                exit;
        }

        //把文件掩码清0
        umask(0);

        //进入平行世界。主进程退出，为避免挂起控制终端将Daemon放入后台执行
        if (pcntl_fork() != 0) {
            exit;
        }

        //下面是子进程，设置新的会话组长，与控制终端脱离
        if (posix_setsid() === -1) {
            $this->error("setsid fail");
            exit;
        }

        //通过使进程不再成为会话组长来禁止进程重新打开控制终端,结束第一子进程，第二子进程继续（第二子进程不再是会话组长
        if (pcntl_fork() != 0) {
            exit;
        }

        //关闭打开的文件描述符


        //保存主进程id
        $master_pid = posix_getpid();
        if (!@file_put_contents($pid_file, $master_pid)) {
            $this->error("save pid essor");
            exit;
        }

        sleep(10);
        echo "asd \n";
        exit();
    }
}
