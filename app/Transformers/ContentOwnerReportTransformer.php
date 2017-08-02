<?php

namespace App\Transformers;

use App\Models\ImportedDataUsage;
use League\Fractal\TransformerAbstract;

class ContentOwnerReportTransformer extends TransformerAbstract
{
    public function transform($contentOwner)
    {
         return [
             'id' => $contentOwner['id'],
             'name' => $contentOwner['name'],
             'province' => $this->getProvince($contentOwner['province_id']),
             'district' => $this->getDistrict($contentOwner['district_id']),
             'phone' => $contentOwner['phone'],
             'total_money' => $this->getTotalMoney($contentOwner['total_money']),
         ];
    }

    protected function getProvince($id)
    {
        $province = \App\Models\Province::where('id', $id)->first();
        return $province->name;
    }

    protected function getDistrict($id)
    {
        $district = \App\Models\District::where('id', $id)->first();
        return $district->name;
    }

    protected function getTotalMoney($total_times)
    {
        $config = json_decode(\App\Models\Config::orderBy('updated_at')->first()->config, true);
        return number_format($total_times * intval($config['price']), 0, '.', '.') . ' VNĐ';
    }

}
