<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['domain'])->group(function(){
    //Subscribe a user
    Route::post('/subscribe', [App\Http\Controllers\NotificationController::class, 'subscribe']);
    //make a push notification.
    Route::get('/subscribers/fetch',[App\Http\Controllers\NotificationController::class, 'subscribers']);
    //Create a dynamic story
    Route::middleware(['AppKey',])->post('/dynamic/push', [App\Http\Controllers\NotificationController::class, 'store']);
});
