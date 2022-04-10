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
Route::group([
    'middleware' => ['auth']], function () {
        Route::get('bumdes', [BumdesController::class, 'index'])->name('bumdes-index');
        Route::get('bumdes/create', [BumdesController::class, 'create'])->name('bumdes-create');
        Route::post('bumdes/store', [BumdesController::class, 'store'])->name('bumdes-store');
        Route::get('bumdes/{uuid}/edit', [BumdesController::class, 'edit'])->name('bumdes-edit');
        Route::put('bumdes/{uuid}/update', [BumdesController::class, 'update'])->name('bumdes-update');
        Route::delete('bumdes/{uuid}/delete', [BumdesController::class, 'destroy'])->name('bumdes-delete');
});


require __DIR__.'/auth.php';
require __DIR__.'/hanafi.php';
