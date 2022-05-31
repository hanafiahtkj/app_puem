<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstansiPembina;
use App\Models\DetailInstansiPasarDesa;
use App\Models\Kecamatan;
use App\Models\PasarDesa;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Exports\PasarDesaExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class PasarDesaController extends Controller
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
        return view('pasar-desa.index', $data);
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
            'instansi_pembina' => InstansiPembina::all(),
        ];
        return view('pasar-desa.form', $data);
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
            $pasardesa = PasarDesa::create($input);

            if ($instansi_pembina = $request->input('instansi_pembina')) 
            {
                foreach ($instansi_pembina as $key => $value) 
                {
                    DetailInstansiPasarDesa::create([
                        'id_pasar_desa' => $pasardesa->id,
                        'id_instansi_pembina' => $value,
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
            'pasardesa'   => PasarDesa::find($id),
            'kecamatan'   => Kecamatan::all(),
            'instansi_pembina' => InstansiPembina::all(),
            'detail_instansi_pasar_desa'  => DetailInstansiPasarDesa::where('id_pasar_desa', $id)->pluck('id_instansi_pembina')->toArray(),
        ];
        return view('pasar-desa.form', $data);
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

            $pasardesa = PasarDesa::find($id);
            $input = $request->all();
            $pasardesa->update($input);
            
            DetailInstansiPasarDesa::where('id_pasar_desa', $id)->delete();
            if ($instansi_pembina = $request->input('instansi_pembina')) 
            {
                foreach ($instansi_pembina as $key => $value) 
                {
                    DetailInstansiPasarDesa::create([
                        'id_pasar_desa' => $pasardesa->id,
                        'id_instansi_pembina' => $value,
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DetailInstansiPasarDesa::where('id_pasar_desa', $id)->delete();
        PasarDesa::find($id)->delete();
        return response()->json([
            'status' => true,
        ]);
    }

    public function getDataTables(Request $request)
    {
        $query = PasarDesa::query();
        $query = $query->orderBy('id','DESC')->get();

        return Datatables::of($query)
            ->make(true);
    }

    public function export(Request $request)
	{
        $type = $request->get('type');
        $extension = $request->get('extension');
        $function  = '_rekap_'.$request->get('extension');
        return $this->{$function}($request);
    }

    function _rekap_excel(Request $request)
	{
        $id_kecamatan = $request->get('id_kecamatan');
        $id_desa      = $request->get('id_desa');
        $type         = $request->get('type');
        return Excel::download(
            new PasarDesaExport($id_kecamatan, $id_desa, $type), 
            $type.'.xlsx'
        );
    }
}
