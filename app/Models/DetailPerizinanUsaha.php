<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DetailPerizinanUsaha extends Model
{
    use HasFactory;

    protected $table = 'detail_perizinan_usaha';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
