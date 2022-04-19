<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseSettingController;
use App\Http\Controllers\BumdesController;
use App\Http\Controllers\EkonomiDesaController;
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
Route::post('/getdesabyidkecamatan', [BumdesController::class, 'getDesaByIdKecamatan']);
Route::get('/bumdes-json', [BumdesController::class, 'data_json'])->name('bumdes-json');
Route::post('/format1-json', [EkonomiDesaController::class, 'json_format_1'])->name('format1-json');
Route::post('/format2-json', [EkonomiDesaController::class, 'json_format_2'])->name('format2-json');