<?php

namespace App\Transformers;

use App\Models\Ktv;
use League\Fractal\TransformerAbstract;

class KtvTransformer extends TransformerAbstract
{
    public function transform($ktv)
    {
        //dd($ktv);
         return [
             'id' => $ktv['id'],
             'name' => $ktv['name'],
             'representative' => $ktv['representative'],
             'phone' => $ktv['phone'],
             'email' => $ktv['email'],
             'address' => $ktv['address'],
             'province' => $this->getProvince($ktv['province_id']),
             'district' => $this->getDistrict($ktv['district_id']),
//                'created_by' => $song->createdBy->name,
             // 'created_at' => $ktv['created_at'],
             // 'updated_at' => $ktv['updated_at'],
             'n_boxes' => $ktv['n_boxes'],
             'actions' => '<a href="' . route('ktvs.edit', ['id' => $ktv['id']]) . '" class="btn btn-xs btn-primary waves-effect waves-light"><i class="fa fa-edit"></i> Sửa</a>
                           <a href="#" class="btn btn-xs btn-primary waves-effect waves-light ktv-delete" data-id="' . $ktv['id'] . '"><i class="fa fa-trash"></i> Xóa</a>
                            '
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
