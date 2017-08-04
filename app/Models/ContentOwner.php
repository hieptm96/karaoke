<?php

namespace App\Models;

use App\Models\Song;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentOwner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'district_id',
        'province_id',
        'code',
        'user_id',
    ];

    protected $guarded = ['created_by', 'updated_by'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
}
