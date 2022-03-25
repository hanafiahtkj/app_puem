<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriKomoditasController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\SubKomoditasController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\InstansiPembinaController;
use App\Http\Controllers\PerizinanController;
use App\Http\Controllers\BadanUsahaController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\UserController;

Route::group(['middleware' => ['auth']], function () 
{    
    Route::get('/', DashboardController::class);

    Route::get('dashboard', DashboardController::class)->name('dashboard');
});

Route::group([
    'prefix'     => 'master',
    'as'         => 'master.',
    'middleware' => ['auth']], function () {

    Route::get('kategori-komoditas/getDataTables', [KategoriKomoditasController::class, 'getDataTables'])->name('kategori-komoditas.getDataTables');

    Route::resource('kategori-komoditas', KategoriKomoditasController::class);

    Route::get('komoditas/get-komoditas/{id}', [KomoditasController::class, 'getKomoditas'])->name('komoditas.get-komoditas');

    Route::get('komoditas/getDataTables', [KomoditasController::class, 'getDataTables'])->name('komoditas.getDataTables');

    Route::resource('komoditas', KomoditasController::class);

    Route::get('sub-komoditas/get-sub-komoditas/{id}', [SubKomoditasController::class, 'getSubKomoditas'])->name('sub-komoditas.get-sub-komoditas');

    Route::get('sub-komoditas/getDataTables', [SubKomoditasController::class, 'getDataTables'])->name('sub-komoditas.getDataTables');

    Route::resource('sub-komoditas', SubKomoditasController::class);

    Route::get('produk/getDataTables', [ProdukController::class, 'getDataTables'])->name('produk.getDataTables');

    Route::resource('produk', ProdukController::class);

    Route::get('instansi-pembina/getDataTables', [InstansiPembinaController::class, 'getDataTables'])->name('instansi-pembina.getDataTables');

    Route::resource('instansi-pembina', InstansiPembinaController::class);

    Route::get('perizinan/getDataTables', [PerizinanController::class, 'getDataTables'])->name('perizinan.getDataTables');

    Route::resource('perizinan', PerizinanController::class);

    Route::get('badan-usaha/getDataTables', [BadanUsahaController::class, 'getDataTables'])->name('badan-usaha.getDataTables');

    Route::resource('badan-usaha', BadanUsahaController::class);

    Route::get('pendidikan/getDataTables', [PendidikanController::class, 'getDataTables'])->name('pendidikan.getDataTables');

    Route::resource('pendidikan', PendidikanController::class);

    Route::get('pengguna/getDataTables', [UserController::class, 'getDataTables'])->name('pengguna.getDataTables');

    Route::resource('pengguna', UserController::class);
});