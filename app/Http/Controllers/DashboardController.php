<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Usaha;
use App\Models\PasarDesa;
use App\Models\Kecamatan;
use App\Models\Desa;
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
        $kecamatan = Kecamatan::all();
        $data = [
            'kecamatan' => Kecamatan::all(),
            'desa' => Desa::all(),
        ];
        return view('landing-page.index', compact('kecamatan', 'data'));
    }
}
