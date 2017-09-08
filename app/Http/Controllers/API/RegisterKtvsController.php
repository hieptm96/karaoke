<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Ktv;
use App\Models\Box;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterKtv;

class RegisterKtvsController extends Controller
{
    public function store(RegisterKtv $request)
    {
        $box = Box::create([
            'code' => $request->m_type,
            'ktv_id' => Ktv::findKtvByCode($request->ktv_id),
//            'mac' => $request->box_id
            // chua co Mac
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Success',
        ]);
    }

    public function cancel(RegisterKtv $request)
    {
        $box = Box::where('code', '=', $request->box_id)->where('ktv_id', '=', $request->ktv_id)->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Success',
        ]);
    }
}
