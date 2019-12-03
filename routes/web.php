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

Route::prefix('/')->group(function () {
  Route::post('login', function () {return response('', 204);});
  Route::get('mac', function () {dd(shell_exec('getmac'));});
});

Route::view('{any1?}/{any2?}/{any3?}', 'pages/spa');
