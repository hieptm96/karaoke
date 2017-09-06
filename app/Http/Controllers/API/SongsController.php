<?php

namespace App\Http\Controllers\API;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SongsController extends Controller
{
    public function importDataUsage(Request $request)
    {
    	$data = json_decode($request->data, true);
    	DB::table('imported_data_usages')->insert($data);
    	
    	return response()->json(['response' => 'success'], 200);
    }
}
