<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        Role::create($request->all());

        flash()->success('Thành công', 'Đã tạo mới role thành công');

        return redirect()->route('roles.index');
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);

        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, ['name' => 'required']);

        $role = Role::findOrFail($id);

        $role->fill($request->all())->save();

        flash()->success('Thành công', 'Đã cập nhật role thành công');

        return redirect()->route('roles.show', $id);
    }
}
