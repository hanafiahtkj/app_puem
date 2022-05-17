<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komoditas extends Model
{
    use HasFactory;

    protected $table = 'komoditas';

    protected $fillable = [
        'id_kategori_komoditas',
        'nama_komoditas'
    ];

    protected $appends = ['nama_kategori_komoditas'];

    public function kategoriKomoditas()
    {
        return $this->belongsTo(KategoriKomoditas::class, 'id_kategori_komoditas', 'id');
    }

    public function getNamaKategoriKomoditasAttribute()
    {
        return @$this->kategoriKomoditas()->first()->nama_kategori_komoditas;
    }


}
