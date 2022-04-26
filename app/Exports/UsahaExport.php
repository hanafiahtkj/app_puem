<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\UsahaDataSheets;
use App\Exports\Sheets\UsahaProdukSheets;

class UsahaExport implements WithMultipleSheets
{
    use Exportable;
    
    public function __construct($id_kecamatan, $id_desa, $type, $tahun, $berdasarkan, $filter) 
    {
        $this->id_kecamatan = $id_kecamatan;
        $this->id_desa      = $id_desa;
        $this->type         = $type;
        $this->tahun        = $tahun;
        $this->berdasarkan  = $berdasarkan;
        $this->filter       = $filter;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets[] = new UsahaDataSheets($this->id_kecamatan, $this->id_desa, $this->type, $this->tahun, $this->berdasarkan, $this->filter);
        $sheets[] = new UsahaProdukSheets($this->id_kecamatan, $this->id_desa, $this->type, $this->tahun, $this->berdasarkan, $this->filter);

        return $sheets;
    }
}
