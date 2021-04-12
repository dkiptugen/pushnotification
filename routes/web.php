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
    return view('/stories/display');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::post('/push', [App\Http\Controllers\PushController::class, 'store']);

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

