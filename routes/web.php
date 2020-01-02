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
  Route::get('tag', 'PortalController@tag');
  Route::get('check', 'PortalController@check');
  Route::get('register', 'PortalController@register');
  Route::get('start', 'PortalController@start');
  Route::get('stop', 'PortalController@stop');
});

Route::view('{any1?}/{any2?}/{any3?}', 'pages/spa');
