<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Singer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'sex',
        'language',
        'abbr',
        'file_name',
        'star',
        'name_raw',
        'freq',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    protected $dates = ['deleted_at'];
}