<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends ModelTracking
{
    use SoftDeletes;

    protected $fillable = [
        'file_name',
        'name',
        'name_raw',
        'abbr',
        'word_num',
        'has_fee',
        'singer_id_1',
        'singer_id_2',
        'language',
        'is_new_song',
        'freq',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    protected function beforeCreating()
    {
        $this->abbr = str_abbr($this->name);
        $this->name_raw = Str::ascii($this->name);
        $this->word_num = count(explode(' ', $this->name));
    }

    public function singers()
    {
        return $this->belongsToMany(Singer::class)->withTimestamps();
    }

    public function contentOwnerSongs()
    {
        return $this->hasMany(ContentOwnerSong::class);
    }

    public function contentOwners()
    {
        return $this->belongsToMany(ContentOwner::class)
                    ->withPivot('type', 'percentage')
                    ->withTimestamps();
    }
}
