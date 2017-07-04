<?php

/* 默认 入口*/
Route::any('/', "IndexController@index");

/* index - start  开始定时任务的守护进程 */
Route::any('index/start', "IndexController@start");

/* index - stop  停止定时任务的守护进程 */
Route::any('index/stop', "IndexController@stop");

/* index - task  停止定时任务 */
Route::any('index/task', "IndexController@task");