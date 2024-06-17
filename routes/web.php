<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'init'])->name('dashboard');
    Route::get('/register', [AuthController::class, 'getRegister'])->name('getRegister');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/api/getOrders', [DashboardController::class, 'getOrders']);
    Route::get('/api/getCategories', [DashboardController::class, 'getCategories']);
    Route::get('/api/getOrder', [DashboardController::class, 'getOrder']);
    Route::put('/api/updateOrder', [DashboardController::class, 'updateOrder']);
    Route::post('/api/addOrder', [DashboardController::class, 'addOrder']);
});



Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'getLogin'])->name('getLogin');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});


