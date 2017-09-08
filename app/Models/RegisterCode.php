<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegisterCode extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'ktv_id'
    ];

    protected $dates = ['deleted_at'];
}
