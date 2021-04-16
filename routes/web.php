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



//Authentication routes
Auth::routes(['register' => false]);

Route::post('/login',[App\Http\Controllers\AuthenticationController::class, 'login'])->name('login');
Route::post('/reset',[App\Http\Controllers\AuthenticationController::class, 'resetPassword'])->name('reset');
Route::get('/logout',[App\Http\Controllers\AuthenticationController::class, 'logout'])->name('logout');

//Airtime test route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => 'auth'], function () { 

    //Display stories on the root
    Route::get('/', [App\Http\Controllers\PushController::class, 'displayStories']);

    //make a push notification.
    Route::get('/push',[App\Http\Controllers\PushController::class, 'push'])->name('push');

    //view subscribers.
    Route::get('/subscribers/view',[App\Http\Controllers\GuestController::class, 'index'])->name('subscribers_view');

    //make a push notification story.
    Route::get('/stories',[App\Http\Controllers\PushController::class, 'index'])->name('stories');

    //view failed jobs.
    Route::get('/failed_jobs',[App\Http\Controllers\PushController::class, 'failedJobs'])->name('failed_jobs');

    //view queued jobs.
    Route::get('/queued_jobs',[App\Http\Controllers\PushController::class, 'queuedJobs'])->name('queued_jobs');
    
    //view stories
    Route::get('/stories/display',[App\Http\Controllers\PushController::class, 'displayStories'])->name('display_stories');

    //view epaper
    Route::get('/epaper/display',[App\Http\Controllers\PushController::class, 'displayEpaper'])->name('display_epaper');

});
