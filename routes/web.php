<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'processLogin'])->name('login.post');
});

Route::middleware('auth')->group(function () {

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    
    Route::get('/', function () {
        return view('dashboard');
    });
});