<?php

namespace App\Repositories;

use Datatables;
use App\Models\ContentOwner;
use Illuminate\Http\Request;
use App\Transformers\ContentOwnerTransformer;
use App\Contracts\Repositories\ContentOwnerRepository as Contract;

class ContentOwnerRepository implements Contract
{
    use HasActionColumn;

    public function getDatatables(Request $request)
    {
        $content_owner = ContentOwner::select(['id', 'name', 'phone', 'email', 'address', 'province_id', 'district_id', 'code', 'created_at', 'updated_at']);

        return Datatables::of($content_owner)
             ->filter(function ($query) use ($request) {
                 if ($request->has('name')) {
                     $param = '%'.$request->name.'%';
                     $query->where('name', 'like', $param);
                 }
                 if ($request->has('phone')) {
                     $query->where('phone', 'like', '%'.$request->phone.'%');
                 }
                 if ($request->has('email')) {
                     $query->where('email', 'like', '%'.$request->email.'%');
                 }

                 if ($request->has('province')) {
                     $query->where('province_id', $request->province);
                 }

                 if ($request->has('district')) {
                     $query->where('district_id', $request->district);
                 }
             })
            ->setTransformer(new ContentOwnerTransformer)
            ->make(true);
    }

}
