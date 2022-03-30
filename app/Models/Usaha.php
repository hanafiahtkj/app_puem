<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Usaha extends Model
{
    use HasFactory;

    protected $table = 'usaha';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['nama_kecamatan', 'nama_desa'];

    public function individu()
    {
        return $this->belongsTo(Individu::class, 'id_ukm', 'id');
    }

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
