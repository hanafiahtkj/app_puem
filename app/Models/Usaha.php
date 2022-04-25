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

    public function ukm()
    {
        return $this->belongsTo(individu::class, 'id_ukm', 'id');
    }

    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class, 'id_komoditas', 'id');
    }

    public function subKomoditas()
    {
        return $this->belongsTo(SubKomoditas::class, 'id_sub_komoditas', 'id');
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

    public function getHargaJualProdukAttribute($value)
    {
        $arrvalue = explode(".",$value);
        $decimals = ($arrvalue[1] > 0) ? 2 : 0;
        return number_format($value, $decimals, ",", ".");
    }

    public function setHargaJualProdukAttribute($value)
    {
        $this->attributes['harga_jual_produk'] = str_replace(",", ".", str_replace(".", "", $value));
    }

    public function getNilaiInvestasiAttribute($value)
    {
        $arrvalue = explode(".",$value);
        $decimals = ($arrvalue[1] > 0) ? 2 : 0;
        return number_format($value, $decimals, ",", ".");
    }

    public function setNilaiInvestasiAttribute($value)
    {
        $this->attributes['nilai_investasi'] = str_replace(",", ".", str_replace(".", "", $value));
    }

    public function getNilaiAssetAttribute($value)
    {
        $arrvalue = explode(".",$value);
        $decimals = ($arrvalue[1] > 0) ? 2 : 0;
        return number_format($value, $decimals, ",", ".");
    }

    public function setNilaiAssetAttribute($value)
    {
        $this->attributes['nilai_asset'] = str_replace(",", ".", str_replace(".", "", $value));
    }

    public function getOmzetPerhariAttribute($value)
    {
        $arrvalue = explode(".",$value);
        $decimals = ($arrvalue[1] > 0) ? 2 : 0;
        return number_format($value, $decimals, ",", ".");
    }

    public function setOmzetPerhariAttribute($value)
    {
        $this->attributes['omzet_perhari'] = str_replace(",", ".", str_replace(".", "", $value));
    }
}
