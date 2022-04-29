<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Usaha;
use App\Models\PasarDesa;
use DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = [
            'total_uem'   => Usaha::count(),
            'total_pasar' => PasarDesa::count(),
        ];
        return view('dashboard', $data);
    }

    public function landing_page()
    {
        return view('landing-page.index');
    }
}
