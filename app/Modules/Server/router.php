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
Route::any('shake/logout', "ShakeController@logout");

/* auth - info */
Route::any('auth/info', "AuthController@info");

/* auth - wxLogin */
Route::any('auth/wxLogin', "AuthController@wxLogin");

/* auth - wxInfo */
Route::any('auth/wxInfo', "AuthController@wxInfo");

/* shake - getWsToken */
Route::any('shake/getWsToken', "ShakeController@getWsToken");

/* shake - wxLogin */
Route::any('shake/wxLogin', "ShakeController@wxLogin");

/* shake - testLogin */
Route::any('shake/testLogin', "ShakeController@testLogin");


/* ticket - wxLogin */
Route::any('ticket/wxLogin', "TicketController@wxLogin");

/* ticket - testLogin */
Route::any('ticket/testLogin', "TicketController@testLogin");

/* ticket - buy */
Route::any('ticket/buy', "TicketController@buy");


/* ocr - getDeviceId */
Route::any('ocr/getDeviceId', "OcrController@getDeviceId");
/* ocr - getDeviceId */
Route::any('ocr/youTu', "OcrController@youTu");
/* ocr - getDeviceId */
Route::any('ocr/qrCode', "OcrController@qrCode");

Route::any('ocr/qrCodeCreate', "OcrController@qrCodeCreate");
