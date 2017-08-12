<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Box extends ModelTracking
{
    use SoftDeletes;

    protected $table = 'boxes';

    protected $fillable = [
        'id',
        'code',
        'ktv_id',
        'info',
    ];

    public function ktv()
    {
        $this->belongsTo(Ktv::class);
    }
}
