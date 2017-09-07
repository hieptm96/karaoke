<?php

namespace App\Transformers;

use App\Models\ImportedDataUsage;
use League\Fractal\TransformerAbstract;

class SongReportTransformer extends TransformerAbstract
{
    public $config;

    public function __construct()
    {
        $this->config = json_decode(\App\Models\Config::orderBy('updated_at')->first()->config, true);
    }

    public function transform($songReport)
    {
        return [
         'id' => $songReport['id'],
         'name' => $songReport['name'],
         'has_fee' => $this->getHasFeeColumn($songReport['has_fee']),
         'total_money' => $this->getTotalMoney($songReport),
         'total_times' => $songReport['total_times'],
         'actions' => '<a href="' . route('song-reports.show', ['file-name' => $songReport['id']])
            . '" class="btn btn-xs btn-primary waves-effect waves-light song-detail"><i class="fa fa-edit"></i> Chi tiết</a>'
        ];
    }

    protected function getTotalMoney($songReport)
    {
        return number_format($songReport['total_money'] * intval($this->config['price']), 0, '.', '.') . ' VNĐ';
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
