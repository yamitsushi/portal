<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RateController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\CoinLogController;
use \Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::view('/', 'spa');

Route::get('rates', RateController::class);
Route::get('client', [ClientController::class, 'index']);
Route::get('update', [ClientController::class, 'update']);

Route::get('start', [CoinLogController::class, 'index']);
Route::post('submit', [CoinLogController::class, 'update']);