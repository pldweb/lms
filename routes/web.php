<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;

Route::middleware('guest')->group(function () {

    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'getIndex')->name('login');
        Route::get('/user/login', 'getIndex');
        Route::post('/login', 'postLoginAction');
    });

    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'getIndex');
        Route::get('/daftar', 'getIndex');
        Route::get('/user/daftar', 'getIndex');
    });

});