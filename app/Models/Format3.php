<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Format3 extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'format3';

    protected $guarded = [];
}
