<?php

namespace App;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteProvider extends ServiceProvider
{

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        $this->mapCrontabRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::get('/', function () {
            return redirect('/admin');
        });

        if(App::environment() == 'local'){
            Route::prefix('builder')->namespace('Builder') ->group(base_path('bootstrap/builder/router.php'));
        }
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix('manage')->namespace('App\Modules\Manage\Controllers') ->group(base_path('app/Modules/Manage/router.php'));
    }

    /**
     * Define the "crontab" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapCrontabRoutes()
    {
        Route::prefix('crontab')->namespace('Crontab\Controllers') ->group(base_path('bootstrap/crontab/router.php'));
    }
}
