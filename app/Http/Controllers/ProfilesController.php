<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index()
    {
        return view('profiles.index');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    }
}
