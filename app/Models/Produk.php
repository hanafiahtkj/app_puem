<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'id_kategori_komoditas',
        'id_komoditas',
        'id_sub_komoditas',
        'nama_produk'
    ];

    protected $appends = ['nama_komoditas', 'nama_sub_komoditas'];

    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class, 'id_komoditas', 'id');
    }

    public function subKomoditas()
    {
        return $this->belongsTo(SubKomoditas::class, 'id_sub_komoditas', 'id');
    }

    public function getNamaKomoditasAttribute()
    {
        return @$this->komoditas()->first()->nama_komoditas;
    }

    public function getNamaSubKomoditasAttribute()
    {
        return @$this->subKomoditas()->first()->nama_sub_komoditas;
    }


}
