<?php

namespace App\Repositories;

use Datatables;
use App\Models\Ktv;
use Illuminate\Http\Request;
use App\Transformers\KtvTransformer;
use App\Contracts\Repositories\KtvRepository as Contract;

class KtvRepository implements Contract
{
    use HasActionColumn;

    public function getDatatables(Request $request)
    {
        $ktvs = Ktv::join('users', 'ktvs.user_id', '=', 'users.id');

        return Datatables::of($ktvs)
             ->filter(function ($query) use ($request) {
                 if ($request->has('name')) {
                     $param = '%'.$request->name.'%';
                     $query->where('name', 'like', $param);
                 }
                 if ($request->has('phone')) {
                     $query->where('phone', 'like', '%'.$request->phone.'%');
                 }
                 if ($request->has('email')) {
                     $query->where('users.email', 'like', '%'.$request->email.'%');
                 }

                 if ($request->has('province')) {
                     $query->where('province_id', $request->province);
                 }

                 if ($request->has('district')) {
                     $query->where('district_id', $request->district);
                 }
             })
//            ->filter(function ($query) {
//                if (request()->has('name')) {
//                    $query->where('name', 'like', "%{request('name')}%");
//                }
//
//                if ($request->has('province')) {
//                    $query->where('province_id', $request->province);
//                }
//            })
//             ->addColumn('actions', function ($song) {
//                 return $this->generateActionColumn($song);
//             })
             ->setTransformer(new KtvTransformer)
            ->make(true);
    }

}