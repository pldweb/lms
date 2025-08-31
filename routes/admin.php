<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;

Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    // Menu routes
    Route::controller(MenuController::class)->prefix('menu')->group(function () {
        Route::get('/', 'getIndex');
        Route::get('/create', 'getCreate');
        Route::post('/store', 'postStore');
        Route::get('/edit/{id}', 'getEdit');
        Route::post('/update/{id}', 'postUpdate');
        Route::get('/delete/{id}', 'getDelete');
        Route::post('/update-order', 'postUpdateOrder');
    });
});