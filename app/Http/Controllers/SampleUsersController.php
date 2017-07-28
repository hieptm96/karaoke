<?php

namespace App\Http\Controllers;

use Response;
use App\Models\User;
use Illuminate\Http\Request;

class SampleUsersController extends Controller
{
    public function index()
    {
    	$sample_users = User::all()->take(8);
    	return Response::json($sample_users);
    }
}
