<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'config',
    ];

    protected $guarded = ['created_by', 'updated_by'];

    protected $dates = ['deleted_at'];
}
