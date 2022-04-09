<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use DB;

class GisController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = [
            'kecamatan' => Kecamatan::all(),
        ];
        return view('gis.index', $data);
    }

    // data Rtlh
    public function map1(Request $request)
    {
        $rtlh = DB::table('rtlh')
            ->join('rtlh_kondisi_rumah', 'rtlh_kondisi_rumah.id_rtlh', '=', 'rtlh.id')
            ->select('rtlh.*', 
                'rtlh_kondisi_rumah.koordinat_rumah'
            )
            ->where('rtlh.stts_verif', 1)
            ->where('rtlh.stts_realisasi', null)
            ->get();

        $json = array(
            "type" => "FeatureCollection"
        );

        foreach ($rtlh as $key => $value) {
			$string  = $value->koordinat_rumah;
			$pos 	 = strpos($string, ',');
			if ($pos) 
			{
                $loc  = explode(",", $string);
                $value->map_popup_content = '<div class="my-2"><strong>Nama Lengkap:</strong><br>'.$value->nama_lengkap.'</div><div><strong>Alamat Lengkap:</strong><br> '.$value->alamat_lengkap.'</div><div class="my-2"><strong>Koordinat:</strong><br>'.$loc[0].', '.$loc[1].'</div><div><a href="'. url('/admin/report/view-rtlh/'.$value->id).'" target="_blank" title="Lihat detail RTLH">Lihat detail.....</a></div>';
                $json['features'][] = array(
                    'type'       => 'Feature',
                    'id'         => $value->id,
                    'properties' => $value,
                    "geometry"   => array(
                        "type" => "Point",
                        "coordinates" => [$loc[1],$loc[0]]
                    )
                );
			}
        }

        return response()->json([
            'status' => true,
            'data' => $json,
        ]);
    }

    // data Penerima Bantuan
    public function map2(Request $request)
    {
        $rtlh = DB::table('rtlh')
            ->join('rtlh_kondisi_rumah', 'rtlh_kondisi_rumah.id_rtlh', '=', 'rtlh.id')
            ->select('rtlh.*', 
                'rtlh_kondisi_rumah.koordinat_rumah'
            )
            ->where('rtlh.stts_realisasi', 1)
            ->get();

        $json = array(
            "type" => "FeatureCollection"
        );

        foreach ($rtlh as $key => $value) {
			$string  = $value->koordinat_rumah;
			$pos 	 = strpos($string, ',');
			if ($pos) 
			{
                $loc  = explode(",", $string);
                $value->map_popup_content = '<div class="my-2"><strong>Nama Lengkap:</strong><br>'.$value->nama_lengkap.'</div><div><strong>Alamat Lengkap:</strong><br> '.$value->alamat_lengkap.'</div><div class="my-2"><strong>Koordinat:</strong><br>'.$loc[0].', '.$loc[1].'</div><div><a href="'. url('/admin/report/view-rtlh/'.$value->id).'" target="_blank" title="Lihat detail RTLH">Lihat detail.....</a></div>';
                $json['features'][] = array(
                    'type'       => 'Feature',
                    'id'         => $value->id,
                    'properties' => $value,
                    "geometry"   => array(
                        "type" => "Point",
                        "coordinates" => [$loc[1],$loc[0]]
                    )
                );
			}
        }

        return response()->json([
            'status' => true,
            'data' => $json,
        ]);
    }

    public function geojsonKelurahan(Request $request)
    {
        $jsonString = file_get_contents(public_path('geojson/Kelurahan.geojson'));

        // $data = json_decode($jsonString, true);

        // dd($data);

        return response()->json([
            'status' => true,
            'data'   => json_decode($jsonString),
        ]);
    }

    public function geojsonKecamatan(Request $request)
    {
        $jsonString = file_get_contents(public_path('geojson/Kecamatan.geojson'));

        // $data = json_decode($jsonString, true);

        // dd($data);

        return response()->json([
            'status' => true,
            'data'   => json_decode($jsonString),
        ]);
    }

    public function geojsonKumuh(Request $request)
    {
        $jsonString = file_get_contents(public_path('geojson/kumuh.geojson'));

        // $data = json_decode($jsonString, true);

        // dd($data);

        return response()->json([
            'status' => true,
            'data'   => json_decode($jsonString),
        ]);
    }
}
