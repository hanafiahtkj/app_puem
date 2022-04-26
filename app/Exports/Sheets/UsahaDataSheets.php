<?php

namespace App\Exports\Sheets;

use App\Models\Usaha;
use App\Models\Kecamatan;
use App\Models\Desa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Carbon\Carbon;
use DB;

class UsahaDataSheets implements FromView, WithEvents, WithColumnWidths, ShouldAutoSize
{
    public function __construct($id_kecamatan, $id_desa, $type, $tahun, $berdasarkan, $filter) 
    {
        $this->rowCount  = 6;
        $this->id_kecamatan = $id_kecamatan;
        $this->id_desa      = $id_desa;
        $this->type         = $type;
        $this->tahun        = $tahun;
        $this->berdasarkan  = $berdasarkan;
        $this->filter       = $filter;
    }

    public function view(): View
    {
        $report = db::table('usaha')
        ->join('desa', 'usaha.id_desa', '=', 'desa.id')
        ->join('kecamatan', 'desa.id_kecamatan', '=', 'kecamatan.id')
        ->join('individu', 'usaha.id_ukm', '=', 'individu.id')
        ->join('pendidikan', 'individu.id_pendidikan', '=', 'pendidikan.id')
        ->join('komoditas', 'usaha.id_komoditas', '=', 'komoditas.id')
        ->join('sub_komoditas', 'usaha.id_sub_komoditas', '=', 'sub_komoditas.id')
        ->join('produk', 'usaha.id_produk', '=', 'produk.id')
        ->where('usaha.id_kecamatan', $this->id_kecamatan);

        if($this->type == 'rekap_desa'){
            $report->where('usaha.id_desa', $this->id_desa);
        }

        if ($this->tahun) 
        {
            $report->whereYear('usaha.tanggal_simpan', $this->tahun);
        }

        if ($this->berdasarkan) 
        {
            if ($this->filter) 
            {   
                switch ($this->berdasarkan) {
                    case 'Jenis UEM':
                        $report->where('usaha.jenis_uem', $this->filter);
                        break;
                    case 'Skala Usaha':
                        //
                        break;
                    case 'Jenis Kelamin':
                        $report->where('individu.jenis_kelamin', $this->filter);
                        break;
                }
            }
        }

        $report->select('usaha.*', 'individu.nama_pemilik', 'individu.nik', 'pendidikan.nama_pendidikan', 'individu.jenis_kelamin', 'komoditas.nama_komoditas', 'sub_komoditas.nama_sub_komoditas', 'produk.nama_produk', 'desa.nama_desa', 'kecamatan.nama_kecamatan')
            ->orderBy('individu.nama_pemilik','ASC')
            ->orderBy('individu.id','ASC');

        $this->rowCount += $report->count();

        $data = [
            'kecamatan' => Kecamatan::find($this->id_kecamatan),
            'desa'      => Desa::find($this->id_desa),
            'data'      => $report->get(),
        ];
        // echo view('usaha.excel.data-sheets', $data); die();
        return view('usaha.excel.data-sheets', $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:R6';
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $event->sheet->getStyle('A5:R'.$this->rowCount)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

    public function columnWidths(): array
    {
        return [];
    }
}
