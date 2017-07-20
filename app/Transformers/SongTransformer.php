<?php

namespace App\Transformers;

use App\Models\Song;
use League\Fractal\TransformerAbstract;

class SongTransformer extends TransformerAbstract
{
    public function transform(Song $song)
    {
        return [
            'id' => $song->id,
            'name' => '<a href="'.route('songs.show', $song->id).'">'.$song->name.'</a>',
            'language' => config('ktv.languages.'.$song->language, ''),
            'singers' => $this->getSingers($song),
            'created_by' => $song->createdBy->name,
            'created_at' => $song->created_at->toDateTimeString(),
            'updated_at' => $song->updated_at->toDateTimeString(),
        ];
    }

    public function transformWithoutLink(Song $song)
    {
        return [
            'id' => $song->id,
            'name' => $song->name,
            'language' => $song->language,
            'singers' => $this->getSingerUrls($song),
            'created_by' => $song->createdBy->name,
            'created_at' => $song->created_at->toDateTimeString(),
            'updated_at' => $song->updated_at->toDateTimeString(),
        ];
    }

    protected function getSingerUrls($song)
    {
        $singers = [];

        foreach ($song->singers as $singer) {
            $singer->name = '<a href="'.route('singers.show', $singer->id).'">'.$singer->name.'</a>';
        }

        return $song->singers;
    }

    protected function getSingers($song)
    {
        $singers = [];

        foreach ($song->singers as $singer) {
            $singers[] = '<a href="'.route('singers.show', $singer->id).'">'.$singer->name.'</a>';
        }

        return implode(', ', $singers);
    }
}
