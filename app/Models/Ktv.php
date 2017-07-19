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
        'user_id',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
