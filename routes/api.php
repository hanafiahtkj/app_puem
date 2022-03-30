<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseSettingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/database-backup', [DatabaseSettingController::class, 'backupDatabase']);
Route::post('/database-restore', [DatabaseSettingController::class, 'restoreDatabase']);
Route::get('/database-json', [DatabaseSettingController::class, 'data_json'])->name('database-json');
Route::get('/database-download/{sqlfile}', [DatabaseSettingController::class, 'downloadSqlFile'])->name('database-download');