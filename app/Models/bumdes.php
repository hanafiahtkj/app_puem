<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class bumdes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bumdes';

    protected $guarded = [];
}
