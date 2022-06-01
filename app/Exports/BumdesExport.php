<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Bumdes;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
Use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class BumdesExport implements FromView, WithEvents, WithDrawings
{
    use Exportable;

    public $id_kecamatan;

    public function __construct($id_kecamatan)
    {
        $this->rowCount  = 10;
        $this->id_kecamatan = $id_kecamatan;
    }

    // public function collection()
    // {
    //     $data = Bumdes::leftjoin('kecamatan', 'bumdes.kecamatan', '=', 'kecamatan.id')
    //         ->leftjoin('desa', 'bumdes.desa', '=', 'desa.id')
    //         ->select('bumdes.*', 'kecamatan.nama_kecamatan', 'desa.nama_desa')
    //         ->where('bumdes.kecamatan', $this->id_kecamatan)
    //         ->get();

    //     return $data->map(function($item, $key){
    //         return [
    //             'no'            => $key + 1,
    //             'kecamatan'     => $item->nama_kecamatan,
    //             'desa'          => $item->nama_desa,
    //             'nama_bumdes'   => $item->nama_bumdes,
    //             'nama_direktur' => $item->nama_direktur,
    //             'no_perdes'     => $item->no_perdes,
    //             'tahun'         => $item->tahun_bumdes
    //         ];
    //     });
    // }

    public function view(): View
    {

        $data = Bumdes::leftjoin('kecamatan', 'bumdes.kecamatan', '=', 'kecamatan.id')
            ->leftjoin('desa', 'bumdes.desa', '=', 'desa.id')
            ->select('bumdes.*', 'kecamatan.nama_kecamatan', 'desa.nama_desa')
            ->where('bumdes.kecamatan', $this->id_kecamatan)
            ->get();

        $newArr = $data->map(function($item, $key){
            return [
                'no'            => $key + 1,
                'kecamatan'     => $item->nama_kecamatan,
                'desa'          => $item->nama_desa,
                'nama_bumdes'   => $item->nama_bumdes,
                'nama_direktur' => $item->nama_direktur,
                'no_perdes'     => $item->no_perdes,
                'tahun'         => $item->tahun_bumdes
            ];
        });

        $data = [
            'kecamatan' => Kecamatan::find($this->id_kecamatan),
            'data'      => $newArr,
            'setting'   => Setting::first(),
            'tgl_sekarang' => Carbon::now()->isoFormat('Do MMMM YYYY'),
        ];

        return view('bumdes.excel.rekap', $data);

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:J8';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->setSize(12)
                    ->setBold(true);

                $cellRange = 'A1:J8';
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle('A10:J'.$this->rowCount)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A4:J4')->applyFromArray([
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
        $drawing->setCoordinates('A2');

        return $drawing;
    }
    

}