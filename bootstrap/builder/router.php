<?php

/*
|--------------------------------------------------------------------------
| Builder Routes
|--------------------------------------------------------------------------|
*/
Route::get('/', 'Controller@index');
Route::get('/create', 'Controller@view');
Route::get('/create/builder', 'Controller@builder');

