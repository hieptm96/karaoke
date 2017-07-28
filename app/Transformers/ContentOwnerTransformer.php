<?php

namespace App\Transformers;

use App\Models\ContentOwner;
use League\Fractal\TransformerAbstract;

class ContentOwnerTransformer extends TransformerAbstract
{
    public function transform(ContentOwner $content_owner)
    {
         return [
             'id' => $content_owner->id,
             'name' => $content_owner->name,
             'phone' => $content_owner->phone,
             'email' => $content_owner->email,
             'address' => $content_owner->address,
             'province' => $this->getProvince($content_owner->province_id),
             'district' => $this->getDistrict($content_owner->district_id),
//                'created_by' => $song->createdBy->name,
             'code' => $content_owner->code,
             'created_at' => $content_owner->created_at->toDateTimeString(),
             'updated_at' => $content_owner->updated_at->toDateTimeString(),
             'actions' => '<a href="' . route('contentowners.edit', ['id' => $content_owner->id]) . '" class="btn btn-xs btn-primary waves-effect waves-light"><i class="fa fa-edit"></i> Sửa</a>
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
