<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionsController extends Controller
{
    public function index($roleId)
    {
        $role = Role::findOrFail($roleId);

        $permissions = Permission::get();

        return view('rolePermissions.index', compact('role', 'permissions'));
    }

    public function update(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);

        $role->perms()->sync(array_keys($request->get('permissions', [])));

        flash()->success('Success!', 'Role Permissions successfully updated.');

        return redirect()->route('rolePermissions.index', $roleId);
    }
}