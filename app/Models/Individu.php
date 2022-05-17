<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Individu extends Model
{
    use HasFactory;

    protected $table = 'individu';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['nama_kecamatan', 'nama_desa', 'nama_pendidikan'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id');
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'id_pendidikan', 'id');
    }

    public function getNamaKecamatanAttribute()
    {
        return @$this->kecamatan()->first()->nama_kecamatan;
    }

    public function getNamaDesaAttribute()
    {
        return @$this->desa()->first()->nama_desa;
    }

    public function getNamaPendidikanAttribute()
    {
        return @$this->pendidikan()->first()->nama_pendidikan;
    }
}
