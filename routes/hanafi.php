<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

Route::group(['middleware' => ['auth']], function () 
{    
    Route::get('/', DashboardController::class);

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('users/getDataTables', [UserController::class, 'getDataTables'])->name('users.getDataTables');

    Route::resource('users', UserController::class);
});