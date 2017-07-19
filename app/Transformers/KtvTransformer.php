<?php

namespace App\Transformers;

use App\Models\Ktv;
use League\Fractal\TransformerAbstract;

class KtvTransformer extends TransformerAbstract
{
    public function transform(Ktv $ktv)
    {
         return [
             'id' => $ktv->id,
             'name' => $ktv->name,
             'representative' => $ktv->representative,
             'phone' => $ktv->phone,
             'email' => $ktv->email,
             'address' => $ktv->address,
             'province' => $this->getProvince($ktv->province_id),
             'district' => $this->getDistrict($ktv->district_id),
//                'created_by' => $song->createdBy->name,
             'created_at' => $ktv->created_at->toDateTimeString(),
             'updated_at' => $ktv->updated_at->toDateTimeString(),
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

}