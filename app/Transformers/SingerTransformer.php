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
            'name' => '<a href="'.route('singers.show', $singer->id).'">'.$singer->name.'</a>',
            'sex' => config('ktv.sexes.'.$singer->sex, ''),
            'language' => config('ktv.languages.'.$singer->language, ''),
            'created_by' => $singer->createdBy->name,
            'created_at' => $singer->created_at->toDateTimeString(),
            'updated_at' => $singer->updated_at->toDateTimeString(),
        ];
    }

    public static function transformWithoutLink(Singer $singer)
    {
        return [
            'id' => $singer->id,
            'name' => $singer->name,
            'sex' => $singer->sex,
            'language' => $singer->language,
            'created_by' => $singer->createdBy->name,
            'created_at' => $singer->created_at->toDateTimeString(),
            'updated_at' => $singer->updated_at->toDateTimeString(),
        ];
    }
}
