<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Individu extends Model
{
    use HasFactory;

    protected $table = 'individu';

    protected $fillable = [
        'nama_pemilik',
        'nik',
        'jenis_kelamin',
        'no_hp',
        'nama_usaha',
        'alamat_usaha',
        'id_kecamatan',
        'id_desa',
        'id_kategori_komoditas',
        'id_komoditas',
        'id_sub_komoditas',
        'id_pendidikan',
        'tahun_berdiri',
        'status',
        'tanggal_simpan',
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
        return $this->komoditas()->first()->nama_komoditas;
    }

    public function getNamaSubKomoditasAttribute()
    {
        return $this->subKomoditas()->first()->nama_sub_komoditas;
    }
}
