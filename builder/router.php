<?php

/*
|--------------------------------------------------------------------------
| Builder Routes
|--------------------------------------------------------------------------|
*/
Route::get('/', 'Controller@index');
Route::get('/create', 'Controller@index');
Route::get('/create/builder', 'Controller@builder');

