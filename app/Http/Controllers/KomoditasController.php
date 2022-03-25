<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriKomoditas;
use App\Models\Komoditas;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use DB;

class KomoditasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'kategori_komoditas' => KategoriKomoditas::all(),
        ];
        return view('komoditas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nama_komoditas'        => 'required',
            'id_kategori_komoditas' => 'required',
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

            Komoditas::create([
                'nama_komoditas'        => $request->input('nama_komoditas'),
                'id_kategori_komoditas' => $request->input('id_kategori_komoditas'),
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
            'nama_komoditas'        => 'required',
            'id_kategori_komoditas' => 'required',
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

            $komoditas = Komoditas::find($id);
            $komoditas->update([
                'nama_komoditas'        => $request->input('nama_komoditas'),
                'id_kategori_komoditas' => $request->input('id_kategori_komoditas'),
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
        Komoditas::find($id)->delete();
        return response()->json([
            'status' => true,
        ]);
    }

    public function getKomoditas($id)
    {
        $komoditas = [];
        if ($id) {
            $komoditas = Komoditas::where('id_kategori_komoditas', $id)->get();
        }
        return response()->json(['data' => $komoditas]);
    }

    public function getDataTables(Request $request)
    {
        $komoditas = Komoditas::orderBy('id','DESC');
        return Datatables::of($komoditas)
            ->make(true);
    }
}
