<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriKomoditas;
use App\Models\Kecamatan;
use App\Models\Individu;
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
            'kecamatan' => Kecamatan::all(),
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
            'nama_individu'         => 'required',
            'id_kategori_komoditas' => 'required',
            'id_komoditas'          => 'required',
            'id_sub_komoditas'      => 'required',
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

            Individu::create([
                'nama_individu'           => $request->input('nama_individu'),
                'id_kategori_komoditas' => $request->input('id_kategori_komoditas'),
                'id_komoditas'          => $request->input('id_komoditas'),
                'id_sub_komoditas'      => $request->input('id_sub_komoditas'),
            ]);

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
        //
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
            'nama_individu'           => 'required',
            'id_kategori_komoditas' => 'required',
            'id_komoditas'          => 'required',
            'id_sub_komoditas'      => 'required',
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
            $individu->update([
                'nama_individu'           => $request->input('nama_individu'),
                'id_kategori_komoditas' => $request->input('id_kategori_komoditas'),
                'id_komoditas'          => $request->input('id_komoditas'),
                'id_sub_komoditas'      => $request->input('id_sub_komoditas'),
            ]);

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

    public function getDataTables(Request $request)
    {
        $individu = Individu::orderBy('id','DESC');
        return Datatables::of($individu)
            ->make(true);
    }
}