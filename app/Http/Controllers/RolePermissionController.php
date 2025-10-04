<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function getRoles()
    {
        return response()->json(Role::all());
    }

    public function createRole(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:roles,name']);
        $role = Role::create(['name' => $request->name]);
        return response()->json($role);
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(['message' => 'Role deleted']);
    }

    public function getPermissions()
    {
        return response()->json(Permission::all());
    }

    public function createPermission(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:permissions,name']);
        $permission = Permission::create(['name' => $request->name]);
        return response()->json($permission);
    }

    public function deletePermission($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json(['message' => 'Permission deleted']);
    }
}
