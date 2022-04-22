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
        'id_badan_usaha',
        'tahun_berdiri',
        'status',
        'tanggal_simpan',
    ];

    protected $appends = ['nama_kecamatan', 'nama_desa', 'nama_komoditas', 'nama_sub_komoditas', 'nama_badan_usaha', 'nama_pendidikan'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id');
    }

    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class, 'id_komoditas', 'id');
    }

    public function subKomoditas()
    {
        return $this->belongsTo(SubKomoditas::class, 'id_sub_komoditas', 'id');
    }

    public function badanUsaha()
    {
        return $this->belongsTo(BadanUsaha::class, 'id_badan_usaha', 'id');
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'id_pendidikan', 'id');
    }

    public function getNamaKecamatanAttribute()
    {
        return $this->kecamatan()->first()->nama_kecamatan;
    }

    public function getNamaDesaAttribute()
    {
        return $this->desa()->first()->nama_desa;
    }

    public function getNamaKomoditasAttribute()
    {
        return $this->komoditas()->first()->nama_komoditas;
    }

    public function getNamaSubKomoditasAttribute()
    {
        return $this->subKomoditas()->first()->nama_sub_komoditas;
    }

    public function getNamaBadanUsahaAttribute()
    {
        return $this->badanUsaha()->first()->nama_badan_usaha;
    }

    public function getNamaPendidikanAttribute()
    {
        return $this->pendidikan()->first()->nama_pendidikan;
    }
}
