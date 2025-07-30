<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;

Route::controller(LoginController::class)->group(function () {
    Route::get('/user/login', 'getIndex');
    Route::get('login', 'getIndex');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'getIndex');
    Route::get('/user/daftar', 'getIndex');
});