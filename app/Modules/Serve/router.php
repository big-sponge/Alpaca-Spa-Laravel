<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
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


