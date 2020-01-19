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
  Route::post('tag', 'PortalController@tag');
  Route::post('check', 'PortalController@check');
  Route::post('register', 'PortalController@register');
  Route::post('start', 'PortalController@start');
  Route::post('stop', 'PortalController@stop');
});

Route::view('{any1?}/{any2?}/{any3?}', 'pages/spa');
