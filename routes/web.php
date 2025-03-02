<?php

use App\Http\Controllers\Oms\{OmsController, OmsProductController, OmsOrderController, OmsCustomerController};
use App\Http\Controllers\Oms\Auth\{AuthController};
use Illuminate\Support\Facades\Route;

// auth
Route::name('auth.')->middleware("guest")->controller(AuthController::class)->group(function () {
Route::any('/login', 'login')->name('login');
Route::any('/forget-password', 'forgetPassword')->name('foget_password');
});



Route::get('/', [OmsController::class, 'index'])->name('oms.dashboard')->middleware('auth'); // Example route
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth'); // Example route

Route::prefix('oms')->name('oms.')->middleware('auth')->controller(OmsController::class)->group(function () {
    Route::get('/', 'index')->name('index'); // Example route
    Route::get('/create', 'create')->name('create'); // Example route

    /** Product Routes **/
    Route::prefix('product')->name('product.')->controller(OmsProductController::class)->group(function () {
        Route::get('/list', 'list')->name('list'); // Example route
    });

    /** Order Routes **/
    Route::prefix('order')->name('order.')->controller(OmsOrderController::class)->group(function () {
        Route::get('/list', 'list')->name('list'); // Example route
    });

    /** Customer Routes **/
    Route::prefix('customer')->name('customer.')->controller(OmsCustomerController::class)->group(function () {
        Route::get('/list', 'list')->name('list'); // Example route
    });
});


