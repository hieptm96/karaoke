<?php

namespace App\Models;

use App\Models\Song;
use Illuminate\Database\Eloquent\Model;

class ContentOwnerSong extends Model
{
    protected $table = 'content_owner_song';

    public function song()
    {
        return $this->belongsTo(Song::class, 'song_id', 'id');
    }
}
