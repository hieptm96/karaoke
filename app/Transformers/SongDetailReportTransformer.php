<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class SongDetailReportTransformer extends TransformerAbstract
{
    public function transform($detail)
    {
         return [
             'id' => $detail['id'],
             'name' => $detail['name'],
             'total_times' => $detail['total_times'],
             'province' => $detail['province'],
             'district' => $detail['district'],
             'phone' => $detail['phone'],
         ];
    }
}
