<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriKomoditas;
use App\Models\Kecamatan;
use App\Models\Pendidikan;
use App\Models\Usaha;
use App\Models\InstansiPembina;
use App\Models\Perizinan;
use App\Models\BadanUsaha;
use App\Models\Produk;
use App\Models\DetailInstansiUsaha;
use App\Models\DetailPerizinanUsaha;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Exports\UsahaExport;
use Maatwebsite\Excel\Facades\Excel;
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
        $data = [
            'kecamatan' => Kecamatan::all(),
            'badan_usaha' => BadanUsaha::all(),
        ];
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
            'badan_usaha'        => BadanUsaha::all(),
            'produk'             => Produk::all(),
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
            'kecamatan'              => Kecamatan::all(),
            'pendidikan'             => Pendidikan::all(),
            'perizinan'              => Perizinan::all(),
            'instansi_pembina'       => InstansiPembina::all(),
            'kategori_komoditas'     => KategoriKomoditas::all(),
            'usaha'                  => Usaha::find($id),
            'badan_usaha'            => BadanUsaha::all(),
            'produk'                 => Produk::all(),
            'detail_perizinan_usaha' => DetailPerizinanUsaha::where('id_usaha', $id)->get(),
            'detail_instansi_usaha'  => DetailInstansiUsaha::where('id_usaha', $id)->pluck('id_instansi_pembina')->toArray(),
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

            $individu = Usaha::find($id);
            $input = $request->all();
            $individu->update($input);

            DetailInstansiUsaha::where('id_usaha', $id)->delete();
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

            DetailPerizinanUsaha::where('id_usaha', $id)->delete();
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
        $type         = $request->get('type');;
        return Excel::download(
            new UsahaExport($id_kecamatan, $id_desa, $type), 
            $type.'.xlsx'
        );
    }

    public function getDataTables(Request $request)
    {
        $query = Usaha::with('individu');

        if ($id_kecamatan = $request->get('id_kecamatan')) {
            $query->where('usaha.id_kecamatan', $id_kecamatan);
        }

        if ($id_desa = $request->get('id_desa')) {
            $query->where('usaha.id_desa', $id_desa);
        }

        if ($tahun = $request->get('tahun')) {
            $query->whereYear('created_at', $tahun);
        }

        $query = $query->orderBy('usaha.id','DESC')->get();

        return Datatables::of($query)
            ->addColumn('no_izin',function(Usaha $query){
                $no_izin = DetailPerizinanUsaha::where('id_usaha', $query->id)->pluck('nomor')->toArray();
                return implode(',', $no_izin);
            })
            ->make(true);
    }
}
