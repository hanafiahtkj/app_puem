<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DetailInstansiPasarDesa extends Model
{
    use HasFactory;

    protected $table = 'detail_instansi_pasar_desa';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
