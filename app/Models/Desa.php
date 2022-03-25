<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Desa extends Model
{
    use HasFactory;

    protected $table = 'desa';

    protected $fillable = [
        'id_kecamatan',
        'nama_desa',
        'status',
        'geojson',
        'warna',
        'garis',
    ];

    protected $appends = ['nama_kecamatan', 'storage_geojson'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }

    public function getNamaKecamatanAttribute()
    {
        return $this->kecamatan()->first()->nama_kecamatan;
    }

    public function getStorageGeojsonAttribute()
    {
        $url = ($this->geojson != '') ? url(Storage::url($this->geojson)) : '';
        return $url;
    }
}
