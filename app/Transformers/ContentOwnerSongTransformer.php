<?php

namespace App\Transformers;

use App\Models\Song;
use League\Fractal\TransformerAbstract;
use Barryvdh\Debugbar\Facade as Debugbar;

class ContentOwnerSongTransformer extends TransformerAbstract
{
    private static $ownerTypes = ['singer' => 'Ca sĩ', 'musican' => 'Nhạc sĩ',
                                    'film' => 'Quay phim', 'title' => 'Lời'];

    public function transform(array $song)
    {
        return [
            'name' => $song['name'],
            'file_name' => $song['file_name'],
            'has_fee' => $song['has_fee'] ? 'Có': 'Không',
            'owner_type' => $this->getOwnerTypes($song),
            'id' => $song,
        ];
    }

    protected function getOwnerTypes($song)
    {
        $ownerTypes = [];

        foreach ($song['content_owner_songs'] as $owner) {
            $ownerTypes[] = static::$ownerTypes[$owner['type']];
        }

        return implode(', ', $ownerTypes);
    }
}
