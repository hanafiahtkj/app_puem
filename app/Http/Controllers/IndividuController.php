<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komoditas;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Pendidikan;
use App\Models\Individu;
use App\Models\Usaha;
use App\Models\BadanUsaha;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Exports\IndividuExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
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
        $data = [
            'kecamatan' => Kecamatan::all(),
        ];
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
            'komoditas'   => Komoditas::all(),
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
            new IndividuExport($id_kecamatan, $id_desa, $type), 
            $type.'.xlsx'
        );
    }

    function _rekap_pdf(Request $request)
	{
        $report = db::table('individu')
            ->leftJoin('kecamatan', 'individu.id_kecamatan', '=', 'kecamatan.id')
            ->leftJoin('desa', 'individu.id_desa', '=', 'desa.id')
            ->leftJoin('usaha', 'usaha.id_ukm', '=', 'individu.id')
            ->leftJoin('sub_komoditas', 'usaha.id_sub_komoditas', '=', 'sub_komoditas.id')
            ->where('individu.id_kecamatan', $request->get('id_kecamatan'));

        if($request->get('type') == 'rekap_desa'){
            $report->where('individu.id_desa', $request->get('id_desa'));
        }

        $report->select('individu.nama_pemilik', 'kecamatan.nama_kecamatan', 'desa.nama_desa', 'usaha.nama_usaha', 'usaha.alamat_usaha', 'sub_komoditas.nama_sub_komoditas', 'usaha.produk_dihasilkan', 'usaha.jumlah_tenaga_kerja', 'usaha.tahun_berdiri')
            ->orderBy('individu.nama_pemilik', 'asc')
            ->orderBy('individu.id', 'asc');

        $data = [
            'kecamatan' => Kecamatan::find($request->get('id_kecamatan')),
            'desa'      => Desa::find($request->get('id_desa')),
            'data'      => $report->get(),
            'setting'   => Setting::first(),
            'tgl_sekarang' => Carbon::now()->isoFormat('Do MMMM YYYY'),
        ];
        // return view('individu.pdf.rekap', $data); die;
        $pdf = PDF::loadView('individu.pdf.rekap', $data)->setPaper('F4', 'landscape');
        return $pdf->stream($request->get('type').'.pdf');
    }

    public function getDataTables(Request $request)
    {
        $query = Individu::query();

        if (($id_kecamatan = Auth::user()->id_kecamatan) || ($id_kecamatan = $request->get('id_kecamatan'))) {
            $query->where('id_kecamatan', $id_kecamatan);
        }

        if (($id_desa = Auth::user()->id_desa) || ($id_desa = $request->get('id_desa'))) {
            $query->where('id_desa', $id_desa);
        }

        $query = $query->orderBy('id','DESC')->get();

        return Datatables::of($query)
            ->make(true);
    }
}
