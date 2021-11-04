<?php

use Illuminate\Support\Facades\Auth;
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


Route::get('/test',[\App\Http\Controllers\TestController::class,'telegram']);
//Authentication routes
Auth::routes(['register' => false]);
Route::prefix('prime')->group(static function(){
//    domain('www.kenyans.co.ke')->
    Route::get('/',[\App\Http\Controllers\PrimeController::class,'index']);
    Route::get('/subscription',[\App\Http\Controllers\PrimeController::class,'subscription_page']);
    Route::get('/time',[\App\Http\Controllers\PrimeController::class,'time']);
});
Route::get('/',[\App\Http\Controllers\Auth\LoginController::class,'showLoginForm']);
// 'domain'=>'localhost',
Route::group([ 'role'=>['admin','audit'],'middleware'=>['auth','domain', 'auth.role'],'prefix'=>'backend'], function () {

    Route::get('/',[\App\Http\Controllers\DashboardController::class,'index'])->name('dashboard');

    Route::resource('product.notification',\App\Http\Controllers\NotificationController::class);
    Route::get('/product/{product}/notification/push',[App\Http\Controllers\NotificationController::class, 'push'])->name('product.notification.push');
    Route::post('/product/{product}/notification/get',[App\Http\Controllers\NotificationController::class, 'get'])->name('product.notification.datatable');
    Route::post('/product/{product}/notification/{notification}/redo',[App\Http\Controllers\NotificationController::class, 'redo'])->name('product.notification.redo');

    Route::resource('product',\App\Http\Controllers\ProductsController::class);
    Route::post('/products/get',[\App\Http\Controllers\ProductsController::class,'get'])->name('product.datatable');
    Route::get('/products/export',[\App\Http\Controllers\ProductsController::class,'export_view'])->name('product.export_view');
    Route::post('/products/export',[\App\Http\Controllers\ProductsController::class,'export'])->name('product.export');

    Route::resource('product.subscribers',\App\Http\Controllers\SubcribersController::class);
    Route::post('/product/{product}/subscribers/get',[\App\Http\Controllers\SubcribersController::class,'get'])->name('product.subscribers.datatable');
    Route::get('/product/{product}/subscribers/export',[\App\Http\Controllers\SubcribersController::class,'export_view'])->name('product.subscribers.export_view');
    Route::post('/product/{product}/subscribers/export',[\App\Http\Controllers\SubcribersController::class,'export'])->name('product.subscribers.export');

    Route::resource('user',\App\Http\Controllers\UserController::class);
    Route::post('/user/get',[\App\Http\Controllers\UserController::class,'get'])->name('user.datatable');
    Route::get('/user/export',[\App\Http\Controllers\UserController::class,'export_view'])->name('user.export_view');
    Route::post('/user/export',[\App\Http\Controllers\UserController::class,'export'])->name('user.export');

    Route::resource('user.roles',\App\Http\Controllers\RolesController::class);
    Route::post('/user/{user}/roles/get',[\App\Http\Controllers\RolesController::class,'get'])->name('user.roles.datatable');
    Route::get('/user/{user}/roles/export',[\App\Http\Controllers\RolesController::class,'export_view'])->name('user.roles.export_view');
    Route::post('/user/{user}/roles/export',[\App\Http\Controllers\RolesController::class,'export'])->name('user.roles.export');

    Route::resource('user.permissions',\App\Http\Controllers\PermissionsController::class);
    Route::post('/user/{user}/permissions/get',[\App\Http\Controllers\PermissionsController::class,'get'])->name('user.permissions.datatable');
    Route::get('/user/{user}/permissions/export',[\App\Http\Controllers\PermissionsController::class,'export_view'])->name('user.permissions.export_view');
    Route::post('/user/{user}/permissions/export',[\App\Http\Controllers\PermissionsController::class,'export'])->name('user.permissions.export');

    Route::resource('logs',\App\Http\Controllers\LogsController::class);
    Route::post('/logs/get',[\App\Http\Controllers\LogsController::class,'get'])->name('logs.datatable');
    Route::get('/logs/export',[\App\Http\Controllers\LogsController::class,'export_view'])->name('logs.export_view');
    Route::post('/logs/export',[\App\Http\Controllers\LogsController::class,'export'])->name('logs.export');

    Route::prefix('jobs')->group(function(){
        Route::get('/failed',[\App\Http\Controllers\JobsController::class,'failed'])->name('jobs.failed');
        Route::post('/failed/get',[\App\Http\Controllers\JobsController::class,'get_failed'])->name('jobs.failed_datatable');
        Route::get('/queued',[\App\Http\Controllers\JobsController::class,'queued'])->name('jobs.queued');
        Route::post('/queued/get',[\App\Http\Controllers\JobsController::class,'get_queued'])->name('jobs.queued_datatable');
    });

    Route::prefix('prime')->group(function(){
        Route::resource('prime-content', \App\Http\Controllers\Prime\ContentController::class);
        Route::post('prime-content/get',[\App\Http\Controllers\Prime\ContentController::class,'get'])->name('prime-content.datatable');
        Route::resource('prime-subscribers',\App\Http\Controllers\Prime\SubscriptionController::class);
        Route::post('prime-subscribers/get',[\App\Http\Controllers\Prime\SubscriptionController::class,'get'])->name('prime-subscribers.datatable');
        Route::resource('prime-transactions',\App\Http\Controllers\Prime\TransactionController::class);
        Route::post('prime-transactions/get',[\App\Http\Controllers\Prime\TransactionController::class,'get'])->name('prime-transactions.datatable');
    });
});
