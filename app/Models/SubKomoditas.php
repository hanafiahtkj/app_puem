<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKomoditas extends Model
{
    use HasFactory;

    protected $table = 'sub_komoditas';

    protected $guarded = [];

    protected $appends = ['nama_komoditas'];

    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class, 'id_komoditas', 'id');
    }

    public function getNamaKomoditasAttribute()
    {
        return @$this->komoditas()->first()->nama_komoditas;
    }


}
