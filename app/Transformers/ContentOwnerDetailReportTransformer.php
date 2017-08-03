<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ContentOwnerDetailReportTransformer extends TransformerAbstract
{
    public function transform($detail)
    {
         return [
             'id' => $detail['id'],
             'name' => $detail['name'],
             'detail' => $detail,
             'total_times' => $detail['total_times'],
             'song_file_name' => $detail['song_file_name'],
             'total_money' => $this->getTotalMoney($detail['total_times']),
             'discount' => $this->getTotalMoney($detail['discount']),
         ];
    }

    protected function getTotalMoney($total_times)
    {
        $config = json_decode(\App\Models\Config::orderBy('updated_at')->first()->config, true);
        return number_format($total_times * intval($config['price']), 0, '.', '.') . ' VNĐ';
    }

}
