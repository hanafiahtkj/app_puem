<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstansiPembina extends Model
{
    use HasFactory;

    protected $table = 'instansi_pembina';

    protected $fillable = [
        'nama_instansi_pembina',
        'singkatan'
    ];
}
