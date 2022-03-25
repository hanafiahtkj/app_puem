<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use DB;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'kecamatan' => Kecamatan::all(),
        ];
        return view('desa.index', $data);
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
            'id_kecamatan'   => 'required',
            'nama_desa'      => 'required',
            'status'         => 'required',
            'geojson'        => 'required',
            'warna'          => 'required',
            'garis'          => 'required',
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

            $geojson = '';
            if($request->hasFile('geojson')) {
                $upload_path = 'public/geojson';
                $filename = time().'_'.$request->file('geojson')->getClientOriginalName();
                $geojson  = $request->file('geojson')->storeAs(
                    $upload_path, $filename
                );
            }

            Desa::create([
                'id_kecamatan'   => $request->input('id_kecamatan'),
                'nama_desa'      => $request->input('nama_desa'),
                'status'         => $request->input('status'),
                'geojson'        => $geojson,
                'warna'          => $request->input('warna'),
                'garis'          => $request->input('garis'),
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
            'id_kecamatan'   => 'required',
            'nama_desa'      => 'required',
            'status'         => 'required',
            'warna'          => 'required',
            'garis'          => 'required',
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

            $data = [
                'id_kecamatan'   => $request->input('id_kecamatan'),
                'nama_desa'      => $request->input('nama_desa'),
                'status'         => $request->input('status'),
                'warna'          => $request->input('warna'),
                'garis'          => $request->input('garis'),
            ];

            $geojson = '';
            if($request->hasFile('geojson')) {
                $upload_path = 'public/geojson';
                $filename = time().'_'.$request->file('geojson')->getClientOriginalName();
                $geojson  = $request->file('geojson')->storeAs(
                    $upload_path, $filename
                );
                $data['geojson'] = $geojson;
            }

            $desa = Desa::find($id);
            $desa->update($data);

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
        Desa::find($id)->delete();
        return response()->json([
            'status' => true,
        ]);
    }

    public function getDataTables(Request $request)
    {
        $desa = Desa::orderBy('id','DESC');
        return Datatables::of($desa)
            ->make(true);
    }
}
