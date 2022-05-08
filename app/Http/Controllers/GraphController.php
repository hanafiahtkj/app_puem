<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Kecamatan;
use App\Models\Usaha;
use App\Models\Produk;
use Illuminate\Http\Request;

class GraphController extends Controller
{
    public function grafik_panel()
    {
        $kecamatan = Kecamatan::all();
        return view('graph.panel', compact('kecamatan'));
    }

    public function show_grafik(Request $request)
    {

        $arr = [];

        try {
            
            if ($request->jenis_data == 'jumlah_usaha') {
                
                $total_usaha = Usaha::where(DB::raw('YEAR(created_at)'), $request->tahun)
                ->where('id_kecamatan', $request->kec)
                ->where('id_desa', $request->des)
                ->count();
        
                $produk = Produk::all();
        
                foreach ($produk as $key => $value) {
        
                    $new_array = [
                        'nama_produk'   => $value->nama_produk,
                        'total_produk'  => Usaha::where('id_produk', $value->id)->count(),
                        'persentase'    => round(( Usaha::where('id_produk', $value->id)->count() / $total_usaha) * 100, 2),
                        'random_color'  => '#' . substr(md5(rand()), 0, 6) 
                    ];
        
                    $arr[] = $new_array;
        
                }
        
                $new_array = collect($arr)->filter(function ($value, $key) {
                    return $value['total_produk'] > 0;
                });
        
                return response()->json([
                    'status' => 'success',
                    'data' => $new_array
                ]);


            }else if ($request->jenis_data == 'skala_usaha') {

                $mikro = 0;

                $data_usaha = Usaha::where(DB::raw('YEAR(created_at)'), $request->tahun)
                ->where('id_kecamatan', $request->kec)
                ->where('id_desa', $request->des)
                ->get();

                foreach ($data_usaha as $key => $value) {
                    
                    $new_array = [
                        'mikro' => ((int)str_replace(".", "", $value->omzet_perhari) * 365) <= 300000000 ? 1 : 0,
                        'kecil' => ((int)str_replace(".", "", $value->omzet_perhari) * 365) > 300000000 && ((int)str_replace(".", "", $value->omzet_perhari) * 365) < 2500000000 ? 1 : 0,
                        'menengah' => ((int)str_replace(".", "", $value->omzet_perhari) * 365) > 2500000000 && ((int)str_replace(".", "", $value->omzet_perhari) * 365) < 50000000000 ? 1 : 0,

                    ];

                    $arr[] = $new_array;

                }

                $mikro = array_sum(array_column($arr, 'mikro'));
                $kecil = array_sum(array_column($arr, 'kecil'));
                $menengah = array_sum(array_column($arr, 'menengah'));


                $new_arrays = [
                    'mikro' => $mikro,
                    'kecil' => $kecil,
                    'menengah' => $menengah,
                    'total' => $mikro + $kecil + $menengah,
                    'random_color'  => '#' . substr(md5(rand()), 0, 6),
                ];

                return response()->json([
                    'status' => 'success',
                    'data' => $new_arrays
                ]);

            }
            
           

        } catch (\Throwable $th) {
            
           dd($th);

        }
  
        
    }
}
