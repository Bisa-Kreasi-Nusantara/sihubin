<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\Role;
use App\Models\Permission;

class RolePermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:role_permission.view');
    }

    public function index()
    {
        $roles = Role::all();
        return view('role-permission.index', compact('roles'));
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();

        return view('role-permission.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Update nama role
        $role->name = $request->input('name');
        $role->save();

        // Update permission yang dipilih
        $permissions = $request->input('permissions', []); // array of permission IDs
        $role->permissions()->sync($permissions);

        return redirect()->route('role-permission.edit', $role->id)
                        ->with('success', 'Role permissions updated successfully.');
    }

}
