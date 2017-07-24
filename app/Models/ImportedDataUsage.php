<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportedDataUsage extends Model
{
    //use SoftDeletes;

    protected $fillable = [
        'id',
        'imported_file_id',
        'ktv_id',
        'song_file_name',
        'times',
        'date',
    ];

    protected $table = 'imported_data_usage';

    public $timestamps = false;
}
