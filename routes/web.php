<?php

// $proxy_url    = getenv('PROXY_URL');
// $proxy_schema = getenv('PROXY_SCHEMA');

// if (!empty($proxy_url)) {
//    URL::forceRootUrl($proxy_url);
// }

// if (!empty($proxy_schema)) {
//    URL::forceSchema($proxy_schema);
// }

// URL::forceRootUrl(getenv('PROXY_URL'));

$app_url = config("app.url");
if (!empty($app_url)) {
    URL::forceRootUrl($app_url);
    $schema = explode(':', $app_url)[0];
    URL::forceScheme($schema);
}


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseSettingController;
use App\Http\Controllers\BumdesController;
use App\Http\Controllers\EkonomiDesaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\GisController;

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

Route::get('/', [DashboardController::class, 'landing_page'])->name('landing-page');
Route::get('gis/loadmap', [GisController::class, 'loadmap'])->name('gis.loadmap');

Route::get('/database-setting', [DatabaseSettingController::class, 'index'])->name('database-setting');
Route::group([
    'middleware' => ['auth']], function () {
        Route::get('bumdes', [BumdesController::class, 'index'])->name('bumdes-index');
        Route::get('bumdes/create', [BumdesController::class, 'create'])->name('bumdes-create');
        Route::post('bumdes/store', [BumdesController::class, 'store'])->name('bumdes-store');
        Route::get('bumdes/{uuid}/edit', [BumdesController::class, 'edit'])->name('bumdes-edit');
        Route::put('bumdes/{uuid}/update', [BumdesController::class, 'update'])->name('bumdes-update');
        Route::delete('bumdes/{uuid}/delete', [BumdesController::class, 'destroy'])->name('bumdes-delete');

        Route::get('grafik/panel', [GraphController::class, 'grafik_panel'])->name('grafik-panel');
});

Route::group([
    'prefix'     => 'ekonomi-desa',
    'middleware' => ['auth']], function () {
        Route::get('format1', [EkonomiDesaController::class, 'format_1'])->name('ekonomi-desa-format1');
        Route::get('format1/create/{id_sub_komoditas}/{id_kec}/{id_des}', [EkonomiDesaController::class, 'create_format_1'])->name('ekonomi-desa-format1-create');
        Route::get('format1/edit/{uuid}/{id_sub_komoditas}/{id_kec}/{id_des}', [EkonomiDesaController::class, 'edit_format_1'])->name('ekonomi-desa-format1-edit');
        Route::post('format1/store', [EkonomiDesaController::class, 'store_format_1'])->name('ekonomi-desa-format1-store');
        Route::put('format1/update/{uuid}', [EkonomiDesaController::class, 'update_format_1'])->name('ekonomi-desa-format1-update');
        Route::delete('format1/{uuid}/delete', [EkonomiDesaController::class, 'delete_format_1'])->name('ekonomi-desa-format1-delete');

        Route::get('format2', [EkonomiDesaController::class, 'format_2'])->name('ekonomi-desa-format2');
        Route::get('format2/create/{id_sub_komoditas}/{id_kec}/{id_des}', [EkonomiDesaController::class, 'create_format_2'])->name('ekonomi-desa-format2-create');
        Route::get('format2/edit/{uuid}/{id_sub_komoditas}/{id_kec}/{id_des}', [EkonomiDesaController::class, 'edit_format_2'])->name('ekonomi-desa-format2-edit');
        Route::post('format2/store', [EkonomiDesaController::class, 'store_format_2'])->name('ekonomi-desa-format2-store');
        Route::put('format2/update/{uuid}', [EkonomiDesaController::class, 'update_format_2'])->name('ekonomi-desa-format2-update');
        Route::delete('format2/{uuid}/delete', [EkonomiDesaController::class, 'delete_format_2'])->name('ekonomi-desa-format2-delete');

        Route::get('format3', [EkonomiDesaController::class, 'format_3'])->name('ekonomi-desa-format3');
        Route::get('format3/create/{id_sub_komoditas}/{id_kec}/{id_des}', [EkonomiDesaController::class, 'create_format_3'])->name('ekonomi-desa-format3-create');
        Route::post('format3/store', [EkonomiDesaController::class, 'store_format_3'])->name('ekonomi-desa-format3-store');
        Route::get('format3/edit/{uuid}/{id_sub_komoditas}/{id_kec}/{id_des}', [EkonomiDesaController::class, 'edit_format_3'])->name('ekonomi-desa-format3-edit');
        Route::put('format3/update/{uuid}', [EkonomiDesaController::class, 'update_format_3'])->name('ekonomi-desa-format3-update');
        Route::delete('format3/{uuid}/delete', [EkonomiDesaController::class, 'delete_format_3'])->name('ekonomi-desa-format3-delete');


});


require __DIR__.'/auth.php';
require __DIR__.'/hanafi.php';
