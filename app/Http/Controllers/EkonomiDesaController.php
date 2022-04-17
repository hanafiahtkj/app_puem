<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Kecamatan;
use App\Models\Desa;
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

        return redirect()->route('ekonomi-desa-format1')->with('sukses_sess', 'Berhasil update data Format 1');
    }

    public function delete_format_1($uuid)
    {
        $data = Format1::where('uuid', $uuid)->first();
        $data->delete();

        return redirect()->route('ekonomi-desa-format1')->with('sukses_sess', 'Berhasil hapus data Format 1');
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
   
}
