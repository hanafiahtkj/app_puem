<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasarDesa extends Model
{
    use HasFactory;

    protected $table = 'pasar_desa';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['nama_kecamatan', 'nama_desa'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id');
    }

    public function getNamaKecamatanAttribute()
    {
        return $this->kecamatan()->first()->nama_kecamatan;
    }

    public function getNamaDesaAttribute()
    {
        return $this->desa()->first()->nama_desa;
    }
}
