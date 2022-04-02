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
