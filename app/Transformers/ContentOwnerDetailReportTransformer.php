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
            //  'detail' => $detail,
             'has_fee' => $this->getHasFeeColumn($detail['has_fee']),
             'total_times' => $detail['total_times'],
             'song_file_name' => $detail['song_file_name'],
             'total_money' => $this->getTotalMoney($detail['total_money']),
             'discount' => $this->getTotalMoney($detail['discount']),
         ];
    }

    protected function getTotalMoney($total_times)
    {
        $config = json_decode(\App\Models\Config::orderBy('updated_at')->first()->config, true);
        return number_format($total_times * intval($config['price']), 0, '.', '.') . ' VNĐ';
    }

    protected function getHasFeeColumn($hasFee)
    {
        if ($hasFee != 0) {
            return '<span class="label label-success">Có phí</label>';
        } else {
            return '<span class="label label-primary">Không phí</label>';
        }
    }

}
