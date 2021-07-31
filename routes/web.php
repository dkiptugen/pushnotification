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



//Authentication routes
Auth::routes(['register' => false]);
Route::get('/',[\App\Http\Controllers\Auth\LoginController::class,'showLoginForm']);


Route::prefix('backend')->middleware(['middleware' => 'auth'])->group( function () {

    Route::get('/',[\App\Http\Controllers\DashboardController::class,'index'])->name('dashboard');
    //Display stories on the root
    Route::prefix('notification')->group(function(){
        Route::resource('/',\App\Http\Controllers\NotificationController::class);
        Route::get('/push',[App\Http\Controllers\NotificationController::class, 'push'])->name('push');
        Route::post('/get',[App\Http\Controllers\NotificationController::class, 'get'])->name('get notification');
    });

    Route::prefix('products')->group(function(){
        Route::resource('/',\App\Http\Controllers\ProductsController::class,['as'=>'product']);
        Route::post('/get',[\App\Http\Controllers\ProductsController::class,'get'])->name('get products');
        Route::get('/export',[\App\Http\Controllers\ProductsController::class,'export_view'])->name('export view products');
        Route::post('/export',[\App\Http\Controllers\ProductsController::class,'export'])->name('export products');
    });

    Route::prefix('subscribers')->group(function(){
        Route::resource('/',\App\Http\Controllers\SubcribersController::class,['as'=>'subscriber']);
        Route::post('/get',[\App\Http\Controllers\SubcribersController::class,'get'])->name('get subscribers');
        Route::get('/export',[\App\Http\Controllers\SubcribersController::class,'export_view'])->name('export view subscribers');
        Route::post('/export',[\App\Http\Controllers\SubcribersController::class,'export'])->name('export subscribers');
    });

    Route::prefix('user')->group(function(){
        Route::resource('/',\App\Http\Controllers\UserController::class,['as'=>'user']);
        Route::post('/get',[\App\Http\Controllers\UserController::class,'get'])->name('get users');
        Route::get('/export',[\App\Http\Controllers\UserController::class,'export_view'])->name('export view users');
        Route::post('/export',[\App\Http\Controllers\UserController::class,'export'])->name('export users');

        Route::prefix('roles')->group(function(){
            Route::resource('/',\App\Http\Controllers\RolesController::class,['as'=>'role']);
            Route::post('/get',[\App\Http\Controllers\RolesController::class,'get'])->name('get roles');
            Route::get('/export',[\App\Http\Controllers\RolesController::class,'export_view'])->name('export view roles');
            Route::post('/export',[\App\Http\Controllers\RolesController::class,'export'])->name('export roles');
        });

        Route::prefix('permissions')->group(function(){
            Route::resource('/',\App\Http\Controllers\PermissionsController::class,['as'=>'permission']);
            Route::post('/get',[\App\Http\Controllers\PermissionsController::class,'get'])->name('get permissions');
            Route::get('/export',[\App\Http\Controllers\PermissionsController::class,'export_view'])->name('export view permissions');
            Route::post('/export',[\App\Http\Controllers\PermissionsController::class,'export'])->name('export permissions');
        });
    });

    Route::prefix('jobs')->group(function(){
        Route::get('/failed',[\App\Http\Controllers\JobsController::class,'failed'])->name('Failed jobs');
        Route::post('/failed/get',[\App\Http\Controllers\JobsController::class,'get_failed']);

        Route::get('/queued',[\App\Http\Controllers\JobsController::class,'queued'])->name('Queued jobs');
        Route::post('/queued/get',[\App\Http\Controllers\JobsController::class,'get_queued']);
    });

    Route::prefix('logs')->group(function(){
        Route::resource('/',\App\Http\Controllers\LogsController::class,['as'=>'log']);
        Route::post('/get',[\App\Http\Controllers\LogsController::class,'get'])->name('get logs');
        Route::get('/export',[\App\Http\Controllers\LogsController::class,'export_view'])->name('export view logs');
        Route::post('/export',[\App\Http\Controllers\LogsController::class,'export'])->name('export logs');
    });
});
