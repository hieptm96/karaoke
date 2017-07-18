<?php

namespace App\Transformers;

use App\Models\Singer;
use League\Fractal\TransformerAbstract;

class SingerTransformer extends TransformerAbstract
{
    public function transform(Singer $singer)
    {
        return [
            'id' => $singer->id,
            'name' => $singer->name,
            'language' => config('ktv.languages.'.$singer->language, ''),
            'created_by' => $singer->createdBy->name,
            'created_at' => $singer->created_at->toDateTimeString(),
            'updated_at' => $singer->updated_at->toDateTimeString(),
        ];
    }
}
