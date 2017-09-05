<?php

namespace App\Models;

use App\Models\Ktv;
use App\Models\Song;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportedDataUsage extends Model
{
    //use SoftDeletes;

    protected $fillable = [
        'id',
        'imported_file_id',
        'ktv_id',
        'box_code',
        'song_file_name',
        'times',
        'date',
    ];

    protected $table = 'imported_data_usages';

    public $timestamps = false;

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function ktv()
    {
        return $this->belongsTo(Ktv::class, 'ktv_id', 'id');
    }
}
