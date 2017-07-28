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

        static::updating(function ($model) {
            $model->abbr = str_abbr($model->name);
            $model->name_raw = Str::ascii($model->name);
        });
    }

    /**
     * Get the user that created the singer.
     */
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    /**
     * Get the user that updated the singer last.
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

    public function songs()
    {
        return $this->hasMany(Song::class)->withTimestamps();
    }
}
