<?php

namespace App\Exports;

use App\Models\Individu;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Setting;
use App\Models\PasarDesa;
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

class PasarDesaExport implements FromView, WithEvents, WithColumnWidths, ShouldAutoSize, WithDrawings
{
    public function __construct($id_kecamatan, $id_desa, $type) 
    {
        $this->rowCount  = 10;
        $this->id_kecamatan  = $id_kecamatan;
        $this->id_desa       = $id_desa;
        $this->type          = $type;
    }

    public function view(): View
    {
        $report = PasarDesa::where('id_kecamatan', $this->id_kecamatan);

        if($this->type == 'rekap_desa'){
            $report->where('id_desa', $this->id_desa);
        }

        $this->rowCount += $report->count();

        $data = [
            'kecamatan' => Kecamatan::find($this->id_kecamatan),
            'desa'      => Desa::find($this->id_desa),
            'data'      => $report->get(),
            'setting'   => Setting::first(),
            'tgl_sekarang' => Carbon::now()->isoFormat('Do MMMM YYYY'),
        ];
        // echo view('individu.excel.rekap', $data); die();
        return view('pasar-desa.excel.rekap', $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:S8';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(12)
                    ->setBold(true);

                $cellRange = 'A1:S8';
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle('A10:S'.$this->rowCount)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A4:S4')->applyFromArray([
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ]
                    ],
                ]);
            },
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/logo.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('I2');

        return $drawing;
    }

    public function columnWidths(): array
    {
        return [];
    }
}
