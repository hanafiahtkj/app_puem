<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriKomoditas;
use App\Models\Kecamatan;
use App\Models\Pendidikan;
use App\Models\Usaha;
use App\Models\InstansiPembina;
use App\Models\Perizinan;
use App\Models\DetailInstansiUsaha;
use App\Models\DetailPerizinanUsaha;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use DB;

class UsahaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        return view('usaha.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'kecamatan'          => Kecamatan::all(),
            'pendidikan'         => Pendidikan::all(),
            'perizinan'          => Perizinan::all(),
            'instansi_pembina'   => InstansiPembina::all(),
            'kategori_komoditas' => KategoriKomoditas::all(),
        ];
        return view('usaha.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = [];

        $validator = Validator::make($request->all(), $validasi);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        
        try{
            DB::beginTransaction();

            $input = $request->all();
            $usaha = Usaha::create($input);

            if ($instansi_pembina = $request->input('instansi_pembina')) 
            {
                foreach ($instansi_pembina as $key => $value) 
                {
                    DetailInstansiUsaha::create([
                        'id_usaha' => $usaha->id,
                        'id_instansi_pembina' => $value,
                    ]);
                }
            }

            if ($perizinan = $request->input('perizinan')) 
            {
                foreach ($perizinan as $key => $value) 
                {
                    DetailPerizinanUsaha::create([
                        'id_usaha'     => $usaha->id,
                        'id_perizinan' => $value['id_perizinan'],
                        'nomor'        => $value['no_izin'],
                    ]);
                }
            }

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();

            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'usaha'                  => Usaha::find($id),
            'kecamatan'              => Kecamatan::all(),
            'pendidikan'             => Pendidikan::all(),
            'perizinan'              => Perizinan::all(),
            'instansi_pembina'       => InstansiPembina::all(),
            'kategori_komoditas'     => KategoriKomoditas::all(),
            'detail_perizinan_usaha' => DetailPerizinanUsaha::where('id_usaha', $id)->get(),
        ];
        return view('usaha.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validasi = [
            'nama_pemilik'          => 'required',
            'nik'                   => 'required',
            'jenis_kelamin'         => 'required',
            'no_hp'                 => 'required',
            'nama_usaha'            => 'required',
            'alamat_usaha'          => 'required',
            'id_kecamatan'          => 'required',
            'id_desa'               => 'required',
            'id_kategori_komoditas' => 'required',
            'id_komoditas'          => 'required',
            'id_sub_komoditas'      => 'required',
            'id_pendidikan'         => 'required',
            'tahun_berdiri'         => 'required',
            'status'                => 'required',
            'tanggal_simpan'        => 'required',
        ];

        $validator = Validator::make($request->all(), $validasi);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        
        try{
            DB::beginTransaction();

            $individu = Usaha::find($id);
            $input = $request->all();
            $individu->update($input);

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();

            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Usaha::find($id)->delete();
        return response()->json([
            'status' => true,
        ]);
    }

    public function getDataTables(Request $request)
    {
        $usaha = Usaha::with('individu')->orderBy('id','DESC');
        return Datatables::of($usaha)
            ->addColumn('no_izin',function(Usaha $usaha){
                $no_izin = DetailPerizinanUsaha::where('id_usaha', $usaha->id)->pluck('nomor')->toArray();
                return implode(',', $no_izin);
            })
            ->make(true);
    }
}
