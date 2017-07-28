<?php

namespace App\Transformers;

use App\Models\Song;
use League\Fractal\TransformerAbstract;

class SongUsageTransformer extends TransformerAbstract
{
    public function transform(ImportedDataUsage $importedDataUsage)
    {
        return [
            'song_file_name' => $importedDataUsage->song_file_name,
            'song_name' => $importedDataUsage->song->name,
            'times' => $importedDataUsage->times,
        ];
    }
}
