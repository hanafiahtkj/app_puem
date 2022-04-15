<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Kecamatan;
use App\Models\Produk;
use App\Models\Format1;
use App\Models\KategoriKomoditas;
use App\Models\SubKomoditas;
use App\Models\Komoditas;

class EkonomiDesaController extends Controller
{
    public function format_1()
    {
        $kecamatan = Kecamatan::all();
        return view('ekonomi-desa.format1.index', compact('kecamatan'));
    }

    public function create_format_1()
    {
        $kecamatan = Kecamatan::all();
        $produk = Produk::where('id_kategori_komoditas', 1)->get();
        return view('ekonomi-desa.format1.create', compact('kecamatan', 'produk'));
    }

    public function store_format_1(Request $request)
    {
        try {
            
            Format1::create([
                'uuid'              => (string) Str::uuid(),
                'id_kecamatan'      => $request->kecamatan,
                'id_desa'           => $request->desa,
                'id_produk'         => $request->produk,
                'jenis_komoditas'   => $request->jenis_komoditas,
                'luas_lahan'        => $request->lahan,
                'swasta_luas'       => $request->swasta_luas,
                'swasta_ton'        => $request->swasta_ton,
                'rakyat_luas'       => $request->rakyat_luas,
                'rakyat_hasil'      => $request->rakyat_hasil,
                'nilai_produk'      => $request->nilai_produk,
                'pemasaran_hasil'   => $request->pemasaran_hasil,
                'tahun'             => $request->tahun
            ]);

            return redirect()->route('ekonomi-desa-format1')->with('sukses_sess', 'Berhasil menambahkan data Format 1');

        } catch (\Throwable $th) {
            
            dd($th);

        }
    }

    public function json_format_1(Request $request)
    {

        $html = '';

       try {
        
        $komoditas = Komoditas::all();

        foreach ($komoditas as $key1 => $value1) {

            $sub_komoditas = SubKomoditas::leftJoin('format1', function($join) use ($request){
                $join->on('sub_komoditas.id', '=', 'format1.id_sub_komoditas')
                    ->where('format1.id_kecamatan', '=', $request->kec)
                    ->where('format1.id_desa', '=', $request->des)
                    ->where('format1.tahun', '=', $request->tahun);
            })
            ->leftJoin('produk', function($join) {
                $join->on('format1.id_produk', '=', 'produk.id');
            })
            ->where('sub_komoditas.id_komoditas', $value1->id)
            ->get();

            foreach ($sub_komoditas as $key2 => $value2) {
                
                $html .= '<tr>';
                $html .= '<td>'.($key1 + 1).'</td>';
                $html .= '<td>'.$value1->nama_komoditas.'</td>';
                $html .= '<tr>';
                    $html .= '<td></td>';
                    $html .= '<td>'.$value2->nama_sub_komoditas.'</td>';
                    $html .= '<td class="text-center">'. ($value2->nama_produk ? $value2->nama_produk : '-') .'</td>';
                    $html .= '<td class="text-center">'. ($value2->jenis_komoditas ? $value2->jenis_komoditas : '-') .'</td>';
                    $html .= '<td class="text-center">'. ($value2->luas_lahan ? $value2->luas_lahan : '-') .'</td>';
                    $html .= '<td class="text-center">'. ($value2->swasta_luas ? $value2->swasta_luas : '-') .'</td>';
                    $html .= '<td class="text-center">'. ($value2->swasta_ton ? $value2->swasta_ton : '-') .'</td>';
                    $html .= '<td class="text-center">'. ($value2->rakyat_luas ? $value2->rakyat_luas : '-') .'</td>';
                    $html .= '<td class="text-center">'. ($value2->rakyat_hasil ? $value2->rakyat_hasil : '-') .'</td>';
                    $html .= '<td class="text-center">'. ($value2->nilai_produk ? $value2->nilai_produk : '-') .'</td>';
                    $html .= '<td class="text-center">'. ($value2->pemasaran_hasil ? $value2->pemasaran_hasil : '-') .'</td>';
                  if (!$value2->jenis_komoditas) {
                    $html .= '<td class="text-center">';
                    $html .= '<a href="" class="btn btn-primary btn-md"><i class="fa fa-plus"></i></a>';
                    $html .= '</td>';   
                  }else{
                    $html .= '<td class="text-center">';
                    $html .= '<div class="btn btn-group">';
                    $html .= '<a href="" class="btn btn-warning btn-md"><i class="fa fa-edit"></i></a>';
                    $html .= '<a href="" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></a>';
                    $html .= '</div>';
                    $html .= '</td>'; 
                  }
                $html .= '</tr>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '<td></td>';
                $html .= '</tr>';
    

            }

          

        }

       } catch (\Throwable $th) {
        
            dd($th);

       }
      

        return response()->json(['html' => $html]);

    }
}
