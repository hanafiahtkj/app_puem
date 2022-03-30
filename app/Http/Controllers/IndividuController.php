<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriKomoditas;
use App\Models\Kecamatan;
use App\Models\Pendidikan;
use App\Models\Individu;
use App\Models\BadanUsaha;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use DB;

class IndividuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        return view('individu.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'kecamatan'   => Kecamatan::all(),
            'pendidikan'  => Pendidikan::all(),
            'badan_usaha' => BadanUsaha::all(),
            'kategori_komoditas' => KategoriKomoditas::all(),
        ];
        return view('individu.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            'id_badan_usaha'        => 'required',
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

            $input = $request->all();
            Individu::create($input);

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
            'individu'    => Individu::find($id),
            'kecamatan'   => Kecamatan::all(),
            'pendidikan'  => Pendidikan::all(),
            'badan_usaha' => BadanUsaha::all(),
            'kategori_komoditas' => KategoriKomoditas::all(),
        ];
        return view('individu.form', $data);
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
            'id_badan_usaha'        => 'required',
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

            $individu = Individu::find($id);
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
        Individu::find($id)->delete();
        return response()->json([
            'status' => true,
        ]);
    }

    public function ajaxSearch(Request $request)
    {
        $data = [];
        if ($id_desa = $request->input('id_desa')) {
            $query = Individu::where('id_desa', $id_desa);

            if ($search = $request->input('search')) {
                $query->where('nama_pemilik','LIKE','%'.$search.'%');
            }

            $data = $query->get();
        }
        return response()->json($data);
    }

    public function getDataTables(Request $request)
    {
        $individu = Individu::orderBy('id','DESC');
        return Datatables::of($individu)
            ->make(true);
    }
}
