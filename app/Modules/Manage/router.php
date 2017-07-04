<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* 默认 入口*/
Route::any('/', "IndexController@index");

/* index - Index */
Route::any('index/index', "IndexController@index");

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

/* auth - getMemberList */
Route::any('auth/loginByEmail', "AuthController@loginByEmail");

/* auth - resetPwdByOld */
Route::any('auth/resetPwdByOld', "AuthController@resetPwdByOld");

/* auth - logout */
Route::any('auth/logout', "AuthController@logout");

/* auth - logout */
Route::any('auth/info', "AuthController@info");

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

/* admin - getMemberList */
Route::any('admin/getMemberList', "AdminController@getMemberList");

/* admin - editMember */
Route::any('admin/editMember', "AdminController@editMember");

/* admin - deleteMember */
Route::any('admin/deleteMember', "AdminController@deleteMember");

/* admin - getGroupList */
Route::any('admin/getGroupList', "AdminController@getGroupList");

/* admin - editGroup */
Route::any('admin/editGroup', "AdminController@editGroup");

/* admin - deleteGroup */
Route::any('admin/deleteGroup', "AdminController@deleteGroup");

/* admin - getAuthList */
Route::any('admin/getAuthList', "AdminController@getAuthList");

/*
|--------------------------------------------------------------------------
| Crontab
|--------------------------------------------------------------------------
*/

/* crontab - status 查看定时任务守护进程状态 */
Route::any('crontab/status', "CrontabController@status");

/* crontab - start 开始定时任务 */
Route::any('crontab/start', "CrontabController@start");

/* crontab - stop  停止定时任务守护进程*/
Route::any('crontab/stop', "CrontabController@stop");

/* crontab - editTask  添加,或者编辑定时任务*/
Route::any('crontab/editTask', "CrontabController@editTask");

/* crontab - changeTaskStatus  设置定时任务状态 */
Route::any('crontab/changeTaskStatus', "CrontabController@changeTaskStatus");

/* crontab - getIndexTask  获取指定定时任务 */
Route::any('crontab/getIndexTask', "CrontabController@getIndexTask");

/* crontab - removeTask  删除定时任务 */
Route::any('crontab/removeTask', "CrontabController@removeTask");

/* crontab - listTask  获取定时任务列表 */
Route::any('crontab/listTask', "CrontabController@listTask");