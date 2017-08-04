<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Contracts\Repositories\UserRepository;

class UsersController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return view('users.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->has('password')) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
        }

        $user->roles()->sync([$request->role_id]);

        flash()->success('Success!', 'Chỉnh sửa thành viên thành công.');

        return redirect()->back();
    }

    public function datatables(Request $request)
    {
        return $this->userRepository->getDatatables($request);
    }
}
