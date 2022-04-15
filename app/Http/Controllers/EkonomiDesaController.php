<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Produk;

class EkonomiDesaController extends Controller
{
    public function format_1()
    {
        return view('ekonomi-desa.format1.index');
    }

    public function create_format_1()
    {
        $kecamatan = Kecamatan::all();
        $produk = Produk::where('id_kategori_komoditas', 1)->get();
        return view('ekonomi-desa.format1.create', compact('kecamatan', 'produk'));
    }
}
