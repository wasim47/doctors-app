<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Module;

class RolePermissionController extends Controller
{
    public function assignPermissions()
    {
        $roles = Role::all();
        $modules = Module::all();

        return view('admin.roles_permission.assign', compact('roles', 'modules'));
    }

    public function getPermissionsByModule(Module $module)
    {
        $permissions = $module->permissions;
        return response()->json($permissions);
    }

    public function saveAssignedPermissions(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findById($request->role_id);

        $permissions = Permission::whereIn('id', $request->permissions)->get();

        $role->syncPermissions($permissions);

        return redirect()->back()->with('success', 'Permissions assigned successfully.');
    }
}
