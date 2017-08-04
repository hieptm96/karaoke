<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Models\Permission;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();

        return view('permissions.index', compact('permissions'));
    }

    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, ['name' => 'required']);

        $permission = Permission::findOrFail($id);

        $permission->fill($request->all())->save();

        flash()->success('Thành công', 'Đã cập nhật thành công');

        return redirect()->route('permissions.show', $id);
    }

    public function sync()
    {
        Permission::syncFromRouting();

        flash()->success('Thành công', '');

        return back();
    }
}
