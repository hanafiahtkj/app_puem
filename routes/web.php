<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseSettingController;

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


// susun kan aja kna route nya fi

Route::get('/database-setting', [DatabaseSettingController::class, 'index'])->name('database-setting');


require __DIR__.'/auth.php';
require __DIR__.'/hanafi.php';
