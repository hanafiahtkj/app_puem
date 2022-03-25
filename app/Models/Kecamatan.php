<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';

    protected $fillable = [
        'nama_kecamatan',
        'kouta',
        'geojson',
        'warna',
        'garis',
        'latitude',
        'langtitude',
    ];

    protected $appends = ['storage_geojson'];

    public function getStorageGeojsonAttribute()
    {
        $url = ($this->geojson != '') ? url(Storage::url($this->geojson)) : '';
        return $url;
    }
}
