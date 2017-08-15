<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ktv extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'representative',
        'phone',
        'email',
        'address',
        'district_id',
        'province_id',
        'user_id'
    ];

    protected $guarded = ['created_by', 'updated_by'];

    protected $dates = ['deleted_at'];

    protected static function boot() {
        parent::boot();

        static::deleting(function ($ktv) {
            $ktv->boxes()->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function boxes()
    {
        return $this->hasMany(Box::class);
    }

    public function boxesCount()
    {
        return $this->hasOne(Box::class)
                ->selectRaw('ktv_id, count(*) as n_boxes')
                ->groupBy('ktv_id');
    }
}
