<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Produk;
use App\Models\Format1;
use App\Models\Format2;
use App\Models\Format3;
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

    public function create_format_1($id_sub_komoditas, $id_kec_en, $id_des_en)
    {
        $id_sub = $this->_decrypt($id_sub_komoditas);
        $id_kec = $this->_decrypt($id_kec_en);
        $id_des = $this->_decrypt($id_des_en);

        SubKomoditas::findOrFail($id_sub);
        Kecamatan::findOrFail($id_kec);
        Desa::findOrFail($id_des);
        
        $kecamatan = Kecamatan::all();
        $produk = Produk::where('id_kategori_komoditas', 1)->get();
        return view('ekonomi-desa.format1.create', compact('kecamatan', 'produk', 'id_sub_komoditas', 'id_kec_en', 'id_des_en'));
    }

    public function store_format_1(Request $request)
    {

        $id_sub = $this->_decrypt($request->id_sub_komoditas);
        $id_kec = $this->_decrypt($request->id_kec_en);
        $id_des = $this->_decrypt($request->id_des_en);

        SubKomoditas::findOrFail($id_sub);
        Kecamatan::findOrFail($id_kec);
        Desa::findOrFail($id_des);

        try {
            
            Format1::create([
                'id_sub_komoditas'  => $id_sub,
                'uuid'              => (string) Str::uuid(),
                'id_kecamatan'      => $id_kec,
                'id_desa'           => $id_des,
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

            // return redirect()->route('ekonomi-desa-format1')->with('sukses_sess', 'Berhasil menambahkan data Format 1');
            return redirect()->back()->with('sukses_sess', 'Berhasil menambah Data Sumber Daya Alam'); 

        } catch (\Throwable $th) {
            
            dd($th);

        }
    }

    public function json_format_1(Request $request)
    {

        $html = '';

       try {
        
        $komoditas = Komoditas::where('id_kategori_komoditas', 1)->get();

        foreach ($komoditas as $key1 => $value1) {

            $sub_komoditas = SubKomoditas::where('id_komoditas', $value1->id)->groupBy('id_komoditas')->get();

            foreach ($sub_komoditas as $key2 => $value2) {

                $sub = SubKomoditas::leftJoin('format1', function($join) use ($request){
                        $join->on('sub_komoditas.id', '=', 'format1.id_sub_komoditas')
                                ->where('format1.id_kecamatan', '=', $request->kec)
                                ->where('format1.id_desa', '=', $request->des)
                                ->where('format1.tahun', '=', $request->tahun)
                                ->where('format1.deleted_at', null);
                        })
                        ->leftJoin('produk', function($join) {
                            $join->on('format1.id_produk', '=', 'produk.id');
                        })
                        ->where('sub_komoditas.id_komoditas', $value1->id)
                        
                        ->select('sub_komoditas.id AS id_sub', 'sub_komoditas.nama_sub_komoditas', 'produk.nama_produk', 'format1.*')
                        ->get();
                // dd($sub);

                $html .= '<tr>';
                $html .= '<td>'.($key1 + 1).'</td>';
                $html .= '<td>'.$value1->nama_komoditas.'</td>';
                
                foreach ($sub as $key3 => $value3) {
                        $html .= '<tr>';
                        $html .= '<td></td>';
                        $html .= '<td>'.$value3->nama_sub_komoditas.'</td>';
                        $html .= '<td class="text-center">'. ($value3->nama_produk ? $value3->nama_produk : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->jenis_komoditas ? $value3->jenis_komoditas : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->luas_lahan ? $value3->luas_lahan : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->swasta_luas ? $value3->swasta_luas : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->swasta_ton ? $value3->swasta_ton : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->rakyat_luas ? $value3->rakyat_luas : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->rakyat_hasil ? $value3->rakyat_hasil : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->nilai_produk ? $value3->nilai_produk : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->pemasaran_hasil ? $value3->pemasaran_hasil : '-') .'</td>';
                    if (!$value3->jenis_komoditas) {
                        $html .= '<td class="text-center">';
                        $html .= '<a href="'.route('ekonomi-desa-format1-create', ['id_sub_komoditas' => $this->_encrypt($value3->id_sub), 'id_kec' => $this->_encrypt($request->kec), 'id_des' => $this->_encrypt($request->des)] ).'" class="btn btn-primary btn-md"><i class="fa fa-plus"></i></a>';
                        $html .= '</td>';   
                    }else{
                        $html .= '<td class="text-center">';
                        $html .= '<div class="btn btn-group" role="group">';
                        $html .= '<a href="'.route('ekonomi-desa-format1-edit', ['uuid' => $value3->uuid, 'id_sub_komoditas' => $this->_encrypt($value3->id_sub), 'id_kec' => $this->_encrypt($request->kec), 'id_des' => $this->_encrypt($request->des)] ).'" class="btn btn-warning btn-md"><i class="fa fa-edit"></i></a>';
                        $html .= '<form method="POST" action="'.route('ekonomi-desa-format1-delete', $value3->uuid).'">';
                        $html .= '<input type="hidden" name="_method" value="DELETE">';
                        $html .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
                        $html .= '<button type="submit" onclick="return confirm(\'Hapus data ?\')" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></button>';
                        $html .= '</form>';
                        $html .= '</div>';
                        $html .= '</td>'; 
                    }
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

    public function edit_format_1($uuid, $id_sub_komoditas, $id_kec_en ,$id_des_en)
    {
        $id_sub = $this->_decrypt($id_sub_komoditas);
        $id_kec = $this->_decrypt($id_kec_en);
        $id_des = $this->_decrypt($id_des_en);

        SubKomoditas::findOrFail($id_sub);
        Kecamatan::findOrFail($id_kec);
        Desa::findOrFail($id_des);

        $data = Format1::where('uuid', $uuid)->first();
        $produk = Produk::where('id_kategori_komoditas', 1)->get();

        return view('ekonomi-desa.format1.edit', compact('data', 'id_sub_komoditas', 'id_kec_en', 'id_des_en', 'produk'));
    }

    public function update_format_1(Request $request, $uuid)
    {
        $id_sub = $this->_decrypt($request->id_sub_komoditas);
        $id_kec = $this->_decrypt($request->id_kec_en);
        $id_des = $this->_decrypt($request->id_des_en);

        SubKomoditas::findOrFail($id_sub);
        Kecamatan::findOrFail($id_kec);
        Desa::findOrFail($id_des);

        $data = Format1::where('uuid', $uuid)->first();

        $data->update([
            'id_sub_komoditas'  => $id_sub,
            'id_kecamatan'      => $id_kec,
            'id_desa'           => $id_des,
            'id_produk'         => $request->produk,
            'jenis_komoditas'   => $request->jenis_komoditas,
            'luas_lahan'        => $request->lahan,
            'swasta_luas'       => $request->swasta_luas,
            'swasta_ton'        => $request->swasta_ton,
            'rakyat_luas'       => $request->rakyat_luas,
            'rakyat_hasil'      => $request->rakyat_hasil,
            'nilai_produk'      => $request->nilai_produk,
            'pemasaran_hasil'   => $request->pemasaran_hasil
        ]);

        // return redirect()->route('ekonomi-desa-format1')->with('sukses_sess', 'Berhasil update data Format 1');
        return redirect()->back()->with('sukses_sess', 'Berhasil update Data Sumber Daya Alam');   
    }

    public function delete_format_1($uuid)
    {
        $data = Format1::where('uuid', $uuid)->first();
        $data->delete();
        return view('ekonomi-desa.del');
    }

    public function format_2()
    {
        $kecamatan = Kecamatan::all();
        return view('ekonomi-desa.format2.index', compact('kecamatan'));
    }

    public function create_format_2($id_sub_komoditas, $id_kec_en, $id_des_en)
    {
        $id_sub = $this->_decrypt($id_sub_komoditas);
        $id_kec = $this->_decrypt($id_kec_en);
        $id_des = $this->_decrypt($id_des_en);

        SubKomoditas::findOrFail($id_sub);
        Kecamatan::findOrFail($id_kec);
        Desa::findOrFail($id_des);
        
        $kecamatan = Kecamatan::all();
        $produk = Produk::where('id_kategori_komoditas', 2)->get();
        return view('ekonomi-desa.format2.create', compact('kecamatan', 'produk', 'id_sub_komoditas', 'id_kec_en', 'id_des_en'));
    }

    public function store_format_2(Request $request)
    {

        $id_sub = $this->_decrypt($request->id_sub_komoditas);
        $id_kec = $this->_decrypt($request->id_kec_en);
        $id_des = $this->_decrypt($request->id_des_en);

        SubKomoditas::findOrFail($id_sub);
        Kecamatan::findOrFail($id_kec);
        Desa::findOrFail($id_des);

        try {
            
            Format2::create([
                'id_sub_komoditas'      => $id_sub,
                'uuid'                  => (string) Str::uuid(),
                'id_kecamatan'          => $id_kec,
                'id_desa'               => $id_des,
                'id_produk'             => $request->produk,
                'jenis_usaha'           => $request->jenis_usaha,
                'jumlah_orang'          => $request->jumlah_orang,
                'jumlah_kegiatan'       => $request->jumlah_kegiatan,
                'jumlah_pemilik'        => $request->jumlah_pemilik,
                'jumlah_tenaga_kerja'   => $request->jumlah_tenaga_kerja,
                'tahun'                 => $request->tahun
            ]);

            // return redirect()->route('ekonomi-desa-format2')->with('sukses_sess', 'Berhasil menambahkan data Format 2');
            return redirect()->back()->with('sukses_sess', 'Berhasil menambah Data Sumber Daya Alam');

        } catch (\Throwable $th) {
            
            dd($th);

        }
    }

    public function json_format_2(Request $request)
    {
        $html = '';

        try {
            
            $komoditas = Komoditas::where('id_kategori_komoditas', 2)->get();

            foreach ($komoditas as $key1 => $value1) {
              
                $sub_komoditas = SubKomoditas::where('id_komoditas', $value1->id)->groupBy('id_komoditas')->get();

                foreach ($sub_komoditas as $key2 => $value2) {
                    
                    $sub = SubKomoditas::leftJoin('format2', function($join) use ($request){
                        $join->on('sub_komoditas.id', '=', 'format2.id_sub_komoditas')
                                ->where('format2.id_kecamatan', '=', $request->kec)
                                ->where('format2.id_desa', '=', $request->des)
                                ->where('format2.tahun', '=', $request->tahun)
                                ->where('format2.deleted_at', null);
                        })
                        ->leftJoin('produk', function($join) {
                            $join->on('format2.id_produk', '=', 'produk.id');
                        })
                        ->where('sub_komoditas.id_komoditas', $value1->id)
                        
                        ->select('sub_komoditas.id AS id_sub', 'sub_komoditas.nama_sub_komoditas', 'produk.nama_produk', 'format2.*')
                        ->get();

                    $html .= '<tr>';
                    $html .= '<td>'.($key1 + 1).'</td>';
                    $html .= '<td>'.$value1->nama_komoditas.'</td>';

                    foreach ($sub as $key3 => $value3) {
                        
                        $html .= '<tr>';
                        $html .= '<td></td>';
                        $html .= '<td class="text-center">'.($value3->nama_sub_komoditas ? $value3->nama_sub_komoditas : '-').'</td>';
                        $html .= '<td class="text-center">'.($value3->nama_produk ? $value3->nama_produk : '-').'</td>';
                        $html .= '<td class="text-center">'.($value3->jumlah_orang ? $value3->jumlah_orang : '-').'</td>';
                        $html .= '<td class="text-center">'.($value3->jumlah_kegiatan ? $value3->jumlah_kegiatan : '-').'</td>';
                        $html .= '<td class="text-center">'.($value3->jumlah_pemilik ? $value3->jumlah_pemilik : '-').'</td>';
                        $html .= '<td class="text-center">'.($value3->jenis_usaha ? $value3->jenis_usaha : '-').'</td>';
                        $html .= '<td class="text-center">'.($value3->jumlah_tenaga_kerja ? $value3->jumlah_tenaga_kerja : '-').'</td>';

                    if (!$value3->id_produk) {
                        $html .= '<td class="text-center">';
                        $html .= '<a href="'.route('ekonomi-desa-format2-create', ['id_sub_komoditas' => $this->_encrypt($value3->id_sub), 'id_kec' => $this->_encrypt($request->kec), 'id_des' => $this->_encrypt($request->des)] ).'" class="btn btn-primary btn-md"><i class="fa fa-plus"></i></a>';
                        $html .= '</td>';   
                    }else{
                        $html .= '<td class="text-center">';
                        $html .= '<div class="btn btn-group" role="group">';
                        $html .= '<a href="'.route('ekonomi-desa-format2-edit', ['uuid' => $value3->uuid, 'id_sub_komoditas' => $this->_encrypt($value3->id_sub), 'id_kec' => $this->_encrypt($request->kec), 'id_des' => $this->_encrypt($request->des)] ).'" class="btn btn-warning btn-md"><i class="fa fa-edit"></i></a>';
                        $html .= '<form method="POST" action="'.route('ekonomi-desa-format2-delete', $value3->uuid).'">';
                        $html .= '<input type="hidden" name="_method" value="DELETE">';
                        $html .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
                        $html .= '<button type="submit" onclick="return confirm(\'Hapus data ?\')" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></button>';
                        $html .= '</form>';
                        $html .= '</div>';
                        $html .= '</td>'; 
                    }
                      
                    }

                $html .= '</tr>';
                $html .= '</tr>';
                    
                    
                }

            }            


        } catch (\Throwable $th) {
            
            dd($th);

        }

        return response()->json(['html' => $html]);
    }

    public function edit_format_2($uuid, $id_sub_komoditas, $id_kec_en ,$id_des_en)
    {
        $id_sub = $this->_decrypt($id_sub_komoditas);
        $id_kec = $this->_decrypt($id_kec_en);
        $id_des = $this->_decrypt($id_des_en);

        SubKomoditas::findOrFail($id_sub);
        Kecamatan::findOrFail($id_kec);
        Desa::findOrFail($id_des);

        $data = Format2::where('uuid', $uuid)->first();
        $produk = Produk::where('id_kategori_komoditas', 2)->get();

        return view('ekonomi-desa.format2.edit', compact('data', 'id_sub_komoditas', 'id_kec_en', 'id_des_en', 'produk'));
    }

    public function update_format_2(Request $request, $uuid)
    {
        $id_sub = $this->_decrypt($request->id_sub_komoditas);
        $id_kec = $this->_decrypt($request->id_kec_en);
        $id_des = $this->_decrypt($request->id_des_en);

        SubKomoditas::findOrFail($id_sub);
        Kecamatan::findOrFail($id_kec);
        Desa::findOrFail($id_des);

        $data = Format2::where('uuid', $uuid)->first();

        $data->update([
            'id_sub_komoditas'      => $id_sub,
            'id_kecamatan'          => $id_kec,
            'id_desa'               => $id_des,
            'id_produk'             => $request->produk,
            'jenis_usaha'           => $request->jenis_usaha,
            'jumlah_orang'          => $request->jumlah_orang,
            'jumlah_kegiatan'       => $request->jumlah_kegiatan,
            'jumlah_pemilik'        => $request->jumlah_pemilik,
            'jumlah_tenaga_kerja'   => $request->jumlah_tenaga_kerja,
        ]);

        // return redirect()->route('ekonomi-desa-format2')->with('sukses_sess', 'Berhasil update data Format 2');
        return redirect()->back()->with('sukses_sess', 'Berhasil update Data Sumber Daya Alam');  
    }

    public function delete_format_2($uuid)
    {
        $data = Format2::where('uuid', $uuid)->first();
        $data->delete();

        // return redirect()->route('ekonomi-desa-format2')->with('sukses_sess', 'Berhasil hapus data Format 2');
        return view('ekonomi-desa.del');
    }

    public function format_3()
    {
        $kecamatan = Kecamatan::all();
        return view('ekonomi-desa.format3.index', compact('kecamatan'));
    }

    public function json_format_3(Request $request)
    {

        $html = '';

       try {
        
        $komoditas = Komoditas::where('id_kategori_komoditas', 3)->get();

        foreach ($komoditas as $key1 => $value1) {

            $sub_komoditas = SubKomoditas::where('id_komoditas', $value1->id)->groupBy('id_komoditas')->get();

            foreach ($sub_komoditas as $key2 => $value2) {

                $sub = SubKomoditas::leftJoin('format3', function($join) use ($request){
                        $join->on('sub_komoditas.id', '=', 'format3.id_sub_komoditas')
                                ->where('format3.id_kecamatan', '=', $request->kec)
                                ->where('format3.id_desa', '=', $request->des)
                                ->where('format3.tahun', '=', $request->tahun)
                                ->where('format3.deleted_at', null);
                        })
                        ->where('sub_komoditas.id_komoditas', $value1->id)
                        
                        ->select('sub_komoditas.id AS id_sub', 'sub_komoditas.nama_sub_komoditas', 'format3.*')
                        ->get();
                // dd($sub);

                $html .= '<tr>';
                $html .= '<td>'.($key1 + 1).'</td>';
                $html .= '<td>'.$value1->nama_komoditas.'</td>';
                
                foreach ($sub as $key3 => $value3) {
                        $html .= '<tr>';
                        $html .= '<td></td>';
                        $html .= '<td>'.$value3->nama_sub_komoditas.'</td>';
                        $html .= '<td class="text-center">'. ($value3->keberadaan ? $this->_booleanToString($value3->keberadaan) : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->produksi_besar ? $this->_booleanToString($value3->produksi_besar) : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->produksi_sedang ? $this->_booleanToString($value3->produksi_sedang) : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->produksi_kecil ? $this->_booleanToString($value3->produksi_kecil) : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->kepemilikan_pemerintah ? $this->_booleanToString($value3->kepemilikan_pemerintah) : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->kepemilikan_swasta ? $this->_booleanToString($value3->kepemilikan_swasta) : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->kepemilikan_perorangan ? $this->_booleanToString($value3->kepemilikan_perorangan) : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->kepemilikan_adat ? $this->_booleanToString($value3->kepemilikan_adat) : '-') .'</td>';
                        $html .= '<td class="text-center">'. ($value3->kepemilikan_lainlain ? $this->_booleanToString($value3->kepemilikan_lainlain) : '-') .'</td>';
                    if (!$value3->keberadaan) {
                        $html .= '<td class="text-center">';
                        $html .= '<a href="'.route('ekonomi-desa-format3-create', ['id_sub_komoditas' => $this->_encrypt($value3->id_sub), 'id_kec' => $this->_encrypt($request->kec), 'id_des' => $this->_encrypt($request->des)] ).'" class="btn btn-primary btn-md"><i class="fa fa-plus"></i></a>';
                        $html .= '</td>';   
                    }else{
                        $html .= '<td class="text-center">';
                        $html .= '<div class="btn btn-group" role="group">';
                        $html .= '<a href="'.route('ekonomi-desa-format3-edit', ['uuid' => $value3->uuid, 'id_sub_komoditas' => $this->_encrypt($value3->id_sub), 'id_kec' => $this->_encrypt($request->kec), 'id_des' => $this->_encrypt($request->des)] ).'" class="btn btn-warning btn-md"><i class="fa fa-edit"></i></a>';
                        $html .= '<form method="POST" action="'.route('ekonomi-desa-format3-delete', $value3->uuid).'">';
                        $html .= '<input type="hidden" name="_method" value="DELETE">';
                        $html .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
                        $html .= '<button type="submit" onclick="return confirm(\'Hapus data ?\')" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></button>';
                        $html .= '</form>';
                        $html .= '</div>';
                        $html .= '</td>'; 
                    }
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

    public function create_format_3($id_sub_komoditas, $id_kec_en, $id_des_en)
    {
        $id_sub = $this->_decrypt($id_sub_komoditas);
        $id_kec = $this->_decrypt($id_kec_en);
        $id_des = $this->_decrypt($id_des_en);

        SubKomoditas::findOrFail($id_sub);
        Kecamatan::findOrFail($id_kec);
        Desa::findOrFail($id_des);
        
        $kecamatan = Kecamatan::all();
        $option = [true => "ya", false => "tidak"];
        return view('ekonomi-desa.format3.create', compact('kecamatan', 'id_sub_komoditas', 'id_kec_en', 'id_des_en', 'option'));
    }

    public function store_format_3(Request $request)
    {

        $id_sub = $this->_decrypt($request->id_sub_komoditas);
        $id_kec = $this->_decrypt($request->id_kec_en);
        $id_des = $this->_decrypt($request->id_des_en);

        SubKomoditas::findOrFail($id_sub);
        Kecamatan::findOrFail($id_kec);
        Desa::findOrFail($id_des);

        try {
            
            Format3::create([
                'id_sub_komoditas'          => $id_sub,
                'uuid'                      => (string) Str::uuid(),
                'id_kecamatan'              => $id_kec,
                'id_desa'                   => $id_des,
                'keberadaan'                => $request->keberadaan,
                'produksi_besar'            => $request->produksi_besar,
                'produksi_sedang'           => $request->produksi_sedang,
                'produksi_kecil'            => $request->produksi_kecil,
                'kepemilikan_pemerintah'    => $request->kepemilikan_pemerintah,
                'kepemilikan_swasta'        => $request->kepemilikan_swasta,
                'kepemilikan_perorangan'    => $request->kepemilikan_perorangan,
                'kepemilikan_adat'          => $request->kepemilikan_adat,
                'kepemilikan_lainlain'      => $request->kepemilikan_lainlain,
                'tahun'                     => $request->tahun
            ]);

            // return redirect()->route('ekonomi-desa-format3')->with('sukses_sess', 'Berhasil menambahkan data Format 3');
            return redirect()->back()->with('sukses_sess', 'Berhasil menambah Data Sumber Daya Alam');

        } catch (\Throwable $th) {
            
            dd($th);

        }
    }

    public function edit_format_3($uuid, $id_sub_komoditas, $id_kec_en ,$id_des_en)
    {
        $id_sub = $this->_decrypt($id_sub_komoditas);
        $id_kec = $this->_decrypt($id_kec_en);
        $id_des = $this->_decrypt($id_des_en);

        SubKomoditas::findOrFail($id_sub);
        Kecamatan::findOrFail($id_kec);
        Desa::findOrFail($id_des);

        $data = Format3::where('uuid', $uuid)->firstorFail();
        $option = [true => "ya", false => "tidak"];
        return view('ekonomi-desa.format3.edit', compact('data', 'id_sub_komoditas', 'id_kec_en', 'id_des_en', 'option'));
    }

    public function update_format_3(Request $request, $uuid)
    {
        $id_sub = $this->_decrypt($request->id_sub_komoditas);
        $id_kec = $this->_decrypt($request->id_kec_en);
        $id_des = $this->_decrypt($request->id_des_en);

        SubKomoditas::findOrFail($id_sub);
        Kecamatan::findOrFail($id_kec);
        Desa::findOrFail($id_des);

        $data = Format3::where('uuid', $uuid)->firstOrFail();

        $data->update([
            'id_sub_komoditas'          => $id_sub,
            'id_kecamatan'              => $id_kec,
            'id_desa'                   => $id_des,
            'keberadaan'                => $request->keberadaan,
            'produksi_besar'            => $request->produksi_besar,
            'produksi_sedang'           => $request->produksi_sedang,
            'produksi_kecil'            => $request->produksi_kecil,
            'kepemilikan_pemerintah'    => $request->kepemilikan_pemerintah,
            'kepemilikan_swasta'        => $request->kepemilikan_swasta,
            'kepemilikan_perorangan'    => $request->kepemilikan_perorangan,
            'kepemilikan_adat'          => $request->kepemilikan_adat,
            'kepemilikan_lainlain'      => $request->kepemilikan_lainlain,
            'tahun'                     => $request->tahun
        ]);

        // return redirect()->route('ekonomi-desa-format3')->with('sukses_sess', 'Berhasil update data Format 3');
        return redirect()->back()->with('sukses_sess', 'Berhasil update Data Sumber Daya Alam');  
    }

    public function delete_format_3($uuid)
    {
        $data = Format3::where('uuid', $uuid)->first();
        $data->delete();

        // return redirect()->route('ekonomi-desa-format3')->with('sukses_sess', 'Berhasil hapus data Format 3');
        return view('ekonomi-desa.del');
    }

    private function _encrypt($string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 's3cr3t@pp';
        $secret_iv = 's3cr3t@pp';
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    private function _decrypt($string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 's3cr3t@pp';
        $secret_iv = 's3cr3t@pp';
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }

    private function _booleanToString($value)
    {
        if ($value == true) {
            return "ya";
        } else {
            return "tidak";
        }
    }
   
}
