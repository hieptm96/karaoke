<?php

namespace App\Repositories;

use DB;
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
        // $ktvs = Ktv::with('boxesCount')
        //             ->select(['id', 'name', 'representative', 'phone', 'email', 'address', 'province_id', 'district_id', 'created_at', 'updated_at'])->get();
        // dd($ktvs);

        $ktvs = DB::table('ktvs')
            ->leftJoin('boxes', 'boxes.ktv_id', '=', 'ktvs.id')
            ->groupBy('ktvs.id')
            ->selectRaw('ktvs.id, name, phone, email, address, province_id, district_id, representative, count(boxes.id) as n_boxes');


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
                     $query->where('email', 'like', '%'.$request->email.'%');
                 }

                 if ($request->has('province')) {
                     $query->where('province_id', $request->province);
                 }

                 if ($request->has('district')) {
                     $query->where('district_id', $request->district);
                 }
             })
            ->setTransformer(new KtvTransformer)
            ->make(true);
    }

}
