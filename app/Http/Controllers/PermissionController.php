<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view('permissions.index', compact('permissions', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create(['name' => strtolower(trim($request->name))]);

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permission created successfully');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permission deleted successfully');
    }

    public function assignToRole(Request $request, Permission $permission)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        Role::findByName($request->role)->givePermissionTo($permission);

        return redirect()
            ->route('permissions.index')
            ->with('success', "Permission assigned to {$request->role}");
    }
}
