<?php

use App\Http\Controllers\Oms\{OmsController, OmsProductController, OmsOrderController, OmsCustomerController};
use Illuminate\Support\Facades\Route;

Route::get('/', [OmsController::class, 'index'])->name('oms.dashboard'); // Example route

Route::prefix('oms')->name('oms.')->controller(OmsController::class)->group(function () {
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


