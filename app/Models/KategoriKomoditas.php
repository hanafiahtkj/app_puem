<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKomoditas extends Model
{
    use HasFactory;

    protected $table = 'kategori_komoditas';

    protected $fillable = [
        'nama_kategori_komoditas',
        'format_ekonomi_desa',
        'alias'
    ];
}
