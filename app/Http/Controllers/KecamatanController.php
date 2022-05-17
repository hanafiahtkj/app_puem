<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use DB;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        return view('kecamatan.index', $data);
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
            'nama_kecamatan' => 'required',
            'kouta'          => 'required',
            // 'geojson'        => 'required',
            // 'warna'          => 'required',
            // 'garis'          => 'required',
            // 'latitude'       => 'required',
            // 'langtitude'     => 'required',
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
                
                // $upload_path = 'public/geojson';
                // $filename = time().'_'.$request->file('geojson')->getClientOriginalName();
                // $geojson  = $request->file('geojson')->storeAs(
                //     $upload_path, $filename
                // );

                $file           = $request->file('geojson');
                $fileName       = time().'_'.$request->file('geojson')->getClientOriginalName();
                $pathToStore    = "/geojsonKecamatan/$fileName";
                $file->move(public_path('storage/geojsonKecamatan'), $fileName);

            }

            Kecamatan::create([
                'nama_kecamatan' => $request->input('nama_kecamatan'),
                'kouta'          => $request->input('kouta'),
                'geojson'        => $pathToStore,
                'warna'          => $request->input('warna'),
                'garis'          => $request->input('garis'),
                'latitude'       => $request->input('latitude'),
                'langtitude'     => $request->input('langtitude'),
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
            'nama_kecamatan' => 'required',
            'kouta'          => 'required',
            // 'warna'          => 'required',
            // 'garis'          => 'required',
            // 'latitude'       => 'required',
            // 'langtitude'     => 'required',
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
                'nama_kecamatan' => $request->input('nama_kecamatan'),
                'kouta'          => $request->input('kouta'),
                'warna'          => $request->input('warna'),
                'garis'          => $request->input('garis'),
                'latitude'       => $request->input('latitude'),
                'langtitude'     => $request->input('langtitude'),
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

            $kecamatan = Kecamatan::find($id);
            $kecamatan->update($data);

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
        Kecamatan::find($id)->delete();
        return response()->json([
            'status' => true,
        ]);
    }

    public function getDataTables(Request $request)
    {
        $kecamatan = Kecamatan::orderBy('id','DESC');
        return Datatables::of($kecamatan)
            ->make(true);
    }
}
