<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);



/* 设置环境变量 */
$app->useEnvironmentPath(base_path().'/config');

$mode = strtoupper(getenv('MOD_ENV'));
if($mode == "PRODUCTION"){
    /*生产环境*/
    $app->loadEnvironmentFrom('.env.production');
}elseif($mode == "TEST"){
    /*测试环境*/
    $app->loadEnvironmentFrom('.env.test');
}elseif($mode == "DEVELOPMENT"){
    /*开发环境*/
    $app->loadEnvironmentFrom('.env.development');
}else{
    /*默认环境-加载 .env*/
}
/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    Illuminate\Foundation\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\ExceptionHandler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
