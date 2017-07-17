<?php

namespace App\Models;

use Illuminate\Support\Str;
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
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->abbr = str_abbr($model->name);
            $model->name_raw = Str::ascii($model->name);
        });
    }
}