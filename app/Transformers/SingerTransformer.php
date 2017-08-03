<?php

namespace App\Transformers;

use App\Models\Singer;
use League\Fractal\TransformerAbstract;

class SingerTransformer extends TransformerAbstract
{
    public function transform(array $singer)
    {
        return [
            'id' => $singer['id'],
            'name' => '<a href="'.route('singers.show', $singer['id']).'">'.$singer['name'].'</a>',
            'sex' => config('ktv.sexes.'.$singer['sex'], ''),
            'language' => config('ktv.languages.'.$singer['language'], ''),
            'created_by' => $singer['created_by']['name'],
            'created_at' =>  $singer['created_at'],
            'updated_at' =>  $singer['updated_at'],
            'actions' => $this->generateActions($singer),
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

    private function generateActions($singer)
    {
        $actions = '<a class="btn btn-primary btn-xs waves-effect waves-light" href="' . route('singers.edit', $singer['id'])
                    . '"><i class="fa fa-edit"></i> Sửa</a>';
        $actions .= ' <a class="btn btn-default delete-singer btn-xs waves-effect waves-light" data-toggle="modal" data-target="#delete-singer-modal"><i class="fa fa-trash"></i> Xóa</a>';

        return $actions;
    }


}
