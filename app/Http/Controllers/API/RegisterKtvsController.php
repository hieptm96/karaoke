<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Ktv;
use App\Models\Box;
use App\Models\RegisterCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterKtv;

class RegisterKtvsController extends Controller
{
    public function store(RegisterKtv $request)
    {
        $box = Box::create([
            'code' => $request->m_type,
            'ktv_id' => Ktv::findKtvByCode($request->ktv_id),
            'mac' => $request->box_id
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Success',
        ]);
    }

    public function cancel(RegisterKtv $request)
    {
        $box = Box::where('mac', '=', $request->box_id)->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Success',
        ]);
    }

    public function validateCode(Request $request)
    {
        if (! $request->code) {
            return response()->json([
                'status' => 0,
                'message' => 'Code field is required',
            ]);
        }

        if (RegisterCode::where('code', $request->code)->first() != null) {
            return response()->json([
                'status' => 1,
                'message' => 'Success',
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Failed',
            ]);
        }
    }
}
