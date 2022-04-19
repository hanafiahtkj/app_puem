<?php

namespace App\Exports;

use App\Models\Individu;
use App\Models\Kecamatan;
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

class IndividuExport implements FromView, WithEvents, WithColumnWidths, ShouldAutoSize
{
    public function __construct($id_kecamatan, $id_desa, $type) 
    {
        $this->rowCount  = 4;
        $this->id_kecamatan  = $id_kecamatan;
        $this->id_desa       = $id_desa;
        $this->type          = $type;
    }

    public function view(): View
    {
        $report = Individu::query()
            ->leftJoin('kecamatan', 'individu.id_kecamatan', '=', 'kecamatan.id')
            ->leftJoin('desa', 'individu.id_desa', '=', 'desa.id')
            ->leftJoin('sub_komoditas', 'individu.id_sub_komoditas', '=', 'sub_komoditas.id')
            ->leftJoin('usaha', 'usaha.id_ukm', '=', 'individu.id')
            ->where('individu.id_kecamatan', $this->id_kecamatan);

        if($this->type == 'rekap_desa'){
            $report->where('individu.id_desa', $this->id_desa);
        }

        $report->select('individu.*', 'kecamatan.nama_kecamatan', 'desa.nama_desa', 'sub_komoditas.nama_sub_komoditas', 'usaha.produk_dihasilkan', 'usaha.jumlah_tenaga_kerja')
            ->orderBy('individu.nama_pemilik', 'asc')
            ->orderBy('individu.id', 'asc');

        $this->rowCount += $report->count();

        $data = [
            'kecamatan' => Kecamatan::find($this->id_kecamatan),
            'data'      => $report->get(),
        ];
        // echo view('individu.excel.rekap', $data); die();
        return view('individu.excel.rekap', $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:J2';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(12)
                    ->setBold(true);

                $cellRange = 'A1:J4';
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $event->sheet->getStyle('A4:J'.$this->rowCount)->applyFromArray([
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
