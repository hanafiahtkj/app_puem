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
            // 'geojson'        => 'required',
            // 'warna'          => 'required',
            // 'garis'          => 'required',
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
            $pathToStore = '';
            if($request->hasFile('geojson')) {
                
                // $upload_path = 'public/geojson';
                // $filename = time().'_'.$request->file('geojson')->getClientOriginalName();
                // $geojson  = $request->file('geojson')->storeAs(
                //     $upload_path, $filename
                // );

                $file           = $request->file('geojson');
                $fileName       = time().'_'.$request->file('geojson')->getClientOriginalName();
                $pathToStore    = "/geojsonDesa/$fileName";
                $file->move(public_path('storage/geojsonDesa'), $fileName);



            }

            Desa::create([
                'id_kecamatan'   => $request->input('id_kecamatan'),
                'nama_desa'      => $request->input('nama_desa'),
                'status'         => $request->input('status'),
                'geojson'        => $pathToStore,
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
            // 'warna'          => 'required',
            // 'garis'          => 'required',
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

    public function getDesa($id)
    {
        $desa = [];
        if ($id) {
            $desa = Desa::where('desa.id_kecamatan', $id)
            ->leftJoin('individu', 'desa.id', '=', 'individu.id_desa')
            ->select('desa.*', DB::raw('count(individu.id) as jumlah'))
            ->get();
        }
        return response()->json(['data' => $desa]);
    }

    public function getDataTables(Request $request)
    {
        $query = Desa::query();

        if ($id_kecamatan = $request->get('id_kecamatan')) {
            $query->where('id_kecamatan', $id_kecamatan);
        }

        $query->get();

        return Datatables::of($query)
            ->make(true);
    }
}
