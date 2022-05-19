<?php

namespace App\Exports\Sheets;

use App\Models\Usaha;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\Setting;
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
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;
use DB;

class UsahaProdukSheets implements FromView, WithEvents, WithColumnWidths, ShouldAutoSize, WithTitle, WithDrawings
{
    public function __construct($id_kecamatan, $id_desa, $type, $tahun, $berdasarkan, $filter) 
    {
        $this->rowCount = 11;
        $this->id_kecamatan = $id_kecamatan;
        $this->id_desa      = $id_desa;
        $this->type         = $type;
        $this->tahun        = $tahun;
        $this->berdasarkan  = $berdasarkan;
        $this->filter       = $filter;
    }

    public function view(): View
    {
        $report = db::table('produk')
            ->join('usaha', 'usaha.id_produk', '=', 'produk.id')
            ->join('individu', 'usaha.id_ukm', '=', 'individu.id')
            ->where('usaha.id_kecamatan', $this->id_kecamatan);

        if($this->type == 'rekap_desa'){
            $report = $report->where('usaha.id_desa', $this->id_desa);
        }

        if ($this->tahun) 
        {
            $report = $report->whereYear('usaha.tanggal_simpan', $this->tahun);
        }

        if ($this->berdasarkan) 
        {
            if ($this->filter) 
            {   
                switch ($this->berdasarkan) {
                    case 'Jenis UEM':
                        $report = $report->where('usaha.jenis_uem', $this->filter);
                        break;
                    case 'Skala Usaha':
                        //
                        break;
                    case 'Jenis Kelamin':
                        $report = $report->where('individu.jenis_kelamin', $this->filter);
                        break;
                }
            }
        }

        $report = $report->selectRaw('produk.nama_produk, count(usaha.id) as total')
            ->groupBy('produk.nama_produk')
            ->orderBy('produk.nama_produk', 'ASC')
            ->get()->toArray();

        // $this->rowCount += $report->count();

        $size = count($report) / 3;
        $size = ($size <= 0) ? 1 : ceil($size);
        $data = array_chunk($report, $size);
        //dd($data); die;
        $data = [
            'tgl_sekarang' => Carbon::now()->isoFormat('Do MMMM YYYY'),
            'kecamatan'    => Kecamatan::find($this->id_kecamatan),
            'desa'         => Desa::find($this->id_desa),
            'data'         => $data,
            'size'         => $size,
            'setting'      => Setting::first(),
            'tahun'        => $this->tahun,
        ];
        // echo view('usaha.excel.produk-sheets', $data); die();
        return view('usaha.excel.produk-sheets', $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:Q10';
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            
                $event->sheet->getStyle('A4:Q4')->applyFromArray([
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

    public function columnWidths(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Produk Usaha';
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/logo.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('B2');

        return $drawing;
    }
}
