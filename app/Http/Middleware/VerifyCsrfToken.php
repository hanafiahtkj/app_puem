<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'bumdes/*/delete',
        'ekonomi-desa/format1/*/delete',
        'ekonomi-desa/format1/delete/*',
        'ekonomi-desa/format2/*/delete',
        'ekonomi-desa/format2/delete/*',
        'ekonomi-desa/format3/*/delete',
        'ekonomi-desa/format3/delete/*',
    ];
}
