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
            'name' => $song->name,
            'language' => config('ktv.languages.'.$song->language, ''),
            'singers' => $this->getSingers($song),
            'created_by' => $song->createdBy->name,
            'created_at' => $song->created_at->toDateTimeString(),
            'updated_at' => $song->updated_at->toDateTimeString(),
        ];
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