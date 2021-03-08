<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::post('/push', [App\Http\Controllers\PushController::class, 'store']);

//make a push notification.
Route::get('/push',[App\Http\Controllers\PushController::class, 'push'])->name('push');

//view subscribers.
Route::get('/subscribers/view',[App\Http\Controllers\GuestController::class, 'index'])->name('subscribers_view');

//make a push notification story.
Route::get('/stories',[App\Http\Controllers\PushController::class, 'index'])->name('stories');

