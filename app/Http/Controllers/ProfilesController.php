<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use App\Models\User;
use App\Http\Requests\ProfileRequest;

class ProfilesController extends Controller
{
    public function index()
    {
        return view('profiles.index');
    }

    public function update(ProfileRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->new_password && (Hash::check($request->password, $user->password))) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->new_password
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        flash()->success('Success!', 'Cập nhật tài khoản thành công.');

        return redirect()->back();
    }
}
