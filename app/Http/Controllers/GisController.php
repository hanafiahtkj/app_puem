<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Desa;
use DB;

class GisController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = [
            'kecamatan' => Kecamatan::all(),
            'desa' => Desa::all(),
        ];
        return view('gis.index', $data);
    }

    // data Rtlh
    public function loadmap(Request $request)
    {
        $desa = Desa::query();
        if ($id_kecamatan = $request->get('id_kecamatan')) {
            $desa->where('id_kecamatan', $id_kecamatan);
        }

        $data = [
            'kecamatan' => Kecamatan::all(),
            'desa' => $desa->get(),
        ];
        return view('gis.map', $data);
    }
}
