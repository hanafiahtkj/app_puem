<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Bumdes;
use App\Models\Setting;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BumdesExport;

class BumdesController extends Controller
{
    public function index()
    {
        $kecamatan = Kecamatan::all();
        return view('bumdes.index', compact('kecamatan'));
    }

    public function data_json()
    {
        $data = Bumdes::leftjoin('desa', 'bumdes.desa', '=', 'desa.id')
            ->leftjoin('kecamatan', 'bumdes.kecamatan', '=', 'kecamatan.id')
            ->select('bumdes.*', 'desa.nama_desa', 'kecamatan.nama_kecamatan')
            ->get()
            ->map(function($item, $key){
                return [
                    'no'            => $key + 1,
                    'uuid'          => $item->uuid,
                    'kecamatan'     => $item->nama_kecamatan,
                    'desa'          => $item->nama_desa,
                    'nama_bumdes'   => $item->nama_bumdes,
                    'nama_direktur' => $item->nama_direktur,
                    'no_perdes'     => $item->no_perdes,
                    'tahun'         => $item->tahun_bumdes
                ];
            });

        return Datatables::of($data)
                        ->addColumn('action', function ($row) {      

                            $csrf = csrf_token();

                            $action = '';
                            $action .= '<div class="btn-group" role="group" aria-label="Basic example">';
                            $action .= '<a href="'.route('bumdes-edit', $row['uuid']).'" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';
                            $action .= '&nbsp;&nbsp;';
                            $action .= '<form method="POST" action="'.route('bumdes-delete', $row['uuid']).'">';
                            $action .= '<input type="hidden" name="_method" value="DELETE">';
                            $action .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
                            $action .= '<button type="submit" onclick="return confirm(\'Hapus data ?\')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                            $action .= '</form>';
                            $action .= '</div>';
                            
                            return $action;
                                
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }

    public function getDesaByIdKecamatan(Request $request)
    {
        $desa = Desa::where('id_kecamatan', $request->id_kecamatan)->get();

        return response()->json(['success' => 'get desa', 'data' => $desa]);
    }

    public function create()
    {
        $kecamatan = Kecamatan::all();

        return view('bumdes.create', compact('kecamatan'));
    }

    public function edit($uuid)
    {

        $data = Bumdes::where('uuid', $uuid)->firstOrFail();
        $kecamatan = Kecamatan::all();

        return view('bumdes.edit', compact('data', 'kecamatan'));

    }

    public function update(Request $request, $uuid)
    {

        $data = Bumdes::where('uuid', $uuid)->firstOrFail();
       
        try {
            
            $data->kecamatan             = $request->kecamatan;
            $data->desa                  = $request->desa;
            $data->nama_bumdes           = $request->nama_bumdes;
            $data->alamat_bumdes         = $request->alamat_bumdes;
            $data->tahun_bumdes          = $request->tahun_bumdes;
            $data->ket_bumdes            = $request->ket_bumdes;
            $data->karyawan_bumdes       = $request->karyawan_bumdes;
            $data->tglsimpan_bumdes      = $request->tglsimpan_bumdes;
            $data->nama_direktur         = $request->direktur;
            $data->tlp_direktur          = $request->tlp_direktur;
            $data->nama_sek              = $request->sekretaris;
            $data->tlp_sek               = $request->tlp_sekretaris;
            $data->nama_bend             = $request->bendahara;
            $data->tlp_bend              = $request->tlp_bendahara;
            $data->namaketua_peng        = $request->ketuapengawas;
            $data->tlpketua_peng         = $request->tlp_ketuapengawas;
            $data->nama_sekpengawas      = $request->sekretaris_pengawas;
            $data->anggota_sekpengawas   = $request->anggota_pengawas;
            $data->no_perdes             = $request->no_perdes;
            $data->no_adart              = $request->no_adart;
            $data->no_sk                 = $request->no_sk;
            $data->rev_noperdes          = $request->rev_noperdes;
            $data->rev_noadart           = $request->rev_noadart;
            $data->rev_nosk              = $request->rev_nosk;
            $data->unit_usahasatu        = $request->usaha_1;
            $data->unit_usahadua         = $request->usaha_2;
            $data->unit_usahatiga        = $request->usaha_3;
            $data->unit_usahaempat       = $request->usaha_4;
            $data->unit_usahalima        = $request->usaha_5;
            $data->update();

            return redirect()->route('bumdes-index')->with('bumdes_sess', 'Berhasil update data bumdes');

        } catch (\Throwable $th) {
            
            dd($th);

        }

    }

    public function store(Request $request)
    {
        try {
            
            Bumdes::create([
                
                'uuid'                  => (string) Str::uuid(),
                'kecamatan'             => $request->kecamatan,
                'desa'                  => $request->desa,
                'nama_bumdes'           => $request->nama_bumdes,
                'alamat_bumdes'         => $request->alamat_bumdes,
                'tahun_bumdes'          => $request->tahun_bumdes,
                'ket_bumdes'            => $request->ket_bumdes,
                'karyawan_bumdes'       => $request->karyawan_bumdes,
                'tglsimpan_bumdes'      => $request->tglsimpan_bumdes,
                'nama_direktur'         => $request->direktur,
                'tlp_direktur'          => $request->tlp_direktur,
                'nama_sek'              => $request->sekretaris,
                'tlp_sek'               => $request->tlp_sekretaris,
                'nama_bend'             => $request->bendahara,
                'tlp_bend'              => $request->tlp_bendahara,
                'namaketua_peng'        => $request->ketuapengawas,
                'tlpketua_peng'         => $request->tlp_ketuapengawas,
                'nama_sekpengawas'      => $request->sekretaris_pengawas,
                'anggota_sekpengawas'   => $request->anggota_pengawas,
                'no_perdes'             => $request->no_perdes,
                'no_adart'              => $request->no_adart,
                'no_sk'                 => $request->no_sk,
                'rev_noperdes'          => $request->rev_noperdes,
                'rev_noadart'           => $request->rev_noadart,
                'rev_nosk'              => $request->rev_nosk,
                'unit_usahasatu'        => $request->usaha_1,
                'unit_usahadua'         => $request->usaha_2,
                'unit_usahatiga'        => $request->usaha_3,
                'unit_usahaempat'       => $request->usaha_4,
                'unit_usahalima'        => $request->usaha_5,
            ]);

            return redirect()->route('bumdes-index')->with('bumdes_sess', 'Berhasil menambahkan data bumdes');

        } catch (\Throwable $th) {
            
            dd($th);

        }
    }

    public function destroy($uuid)
    {
        $data = Bumdes::where('uuid', $uuid)->firstOrFail();
        $data->delete();

        return redirect()->route('bumdes-index')->with('bumdes_sess', 'Berhasil menghapus data bumdes');
    }

    public function export_excel(Request $request)
    {
        if ($request->kecamatan == "all") {
            $nama_kecamatan = (string) "Semua Kecamatan";
        }else{
            $get_kecamatan = Kecamatan::where('id', $request->kecamatan)->firstOrFail();
            $nama_kecamatan = strtolower($get_kecamatan->nama_kecamatan);
        }
        return Excel::download(new BumdesExport($request->kecamatan), "rekap bumdes $nama_kecamatan.xlsx");
    }
 
}
