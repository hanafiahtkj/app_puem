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

    protected $appends = ['nama_kecamatan', 'nama_desa', 'skala_usaha', 'skala_asset'];

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
        return $this->belongsTo(Individu::class, 'id_ukm', 'id');
    }

    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class, 'id_komoditas', 'id');
    }

    public function subKomoditas()
    {
        return $this->belongsTo(SubKomoditas::class, 'id_sub_komoditas', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }

    public function getNamaKecamatanAttribute()
    {
        return @$this->kecamatan()->first()->nama_kecamatan;
    }

    public function getNamaDesaAttribute()
    {
        return @$this->desa()->first()->nama_desa;
    }

    public function getNamaKomoditasAttribute()
    {
        return @$this->komoditas()->first()->nama_komoditas;
    }

    public function getNamaSubKomoditasAttribute()
    {
        return @$this->subKomoditas()->first()->nama_sub_komoditas;
    }

    public function getNamaProdukAttribute()
    {
        return @$this->produk()->first()->nama_produk;
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

    public function getSkalaUsahaAttribute()
    {
        $total = $this->omzet_perhari * 365;
        // mikro : <= 300 jt
        // kecil : >300 jt & <2,5 milyar
        // menengah : >=2,5 milyar & <50 milyar
        switch ($total) {
            case $total <= 300000000:
                return 'Mikro';
                break;
            case $total > 300000000 && $total < 2500000000:
                return 'Kecil';
                break;
            case $total >= 2500000000 && $total < 50000000000:
                return 'Menengah';
                break;
            default:
                return '-';
                break;
        }
        return $total;
    }
}
