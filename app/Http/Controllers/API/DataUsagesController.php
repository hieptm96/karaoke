<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DataUsage;
use App\Models\Ktv;
use Carbon\Carbon;

class DataUsagesController extends Controller
{
    public function store(DataUsage $request)
    {
        $ktvId = Ktv::findKtvByCode($request->partner);

        $data = array_map(function ($value) use ($ktvId) {
            $now = Carbon::now()->toDateTimeString();
            $value['ktv_id'] = $ktvId;
            $value['created_at'] = $now;
            $value['updated_at'] = $now;
            
            if (! isset($value['date'])) {
                $value['date'] = Carbon::today()->toDateString();
            }

            return $value;
        }, $request->data);

        \DB::table('imported_data_usages')->insert($data);

        return response()->json([
            'status' => 1,
            'message' => 'Success',
        ]);
    }
}