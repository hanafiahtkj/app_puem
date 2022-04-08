<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Bumdes;

class BumdesController extends Controller
{
    public function index()
    {
        return view('bumdes.index');
    }

    public function getDesaByIdKecamatan(Request $request)
    {
        $desa = Desa::where('id_kecamatan', $request->id_kecamatan)->get();

        return response()->json(['success' => 'get desa', 'data' => $desa]);
    }

    public function create()
    {
        $kecamatan = Kecamatan::all();

        return view('bumdes.create', compact('kecamatan'));
    }

    public function store(Request $request)
    {
        try {
            
            Bumdes::create([
                
                'uuid' => (string) Str::uuid(),
                'kecamatan' => $request->kecamatan,
                'desa' => $request->desa,
                'nama_bumdes' => $request->nama_bumdes,
                'alamat_bumdes' => $request->alamat_bumdes,
                'tahun_bumdes' => $request->tahun_bumdes,
                'ket_bumdes'    => $request->ket_bumdes,
                'karyawan_bumdes' => $request->karyawan_bumdes,
                'tglsimpan_bumdes' => $request->tglsimpan_bumdes,


            ]);

        } catch (\Throwable $th) {
            
            dd($th);

        }
    }
    
}
