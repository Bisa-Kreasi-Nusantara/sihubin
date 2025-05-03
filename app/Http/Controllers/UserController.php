<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;

use Hash;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query()->with('role')->whereNot('roles_id', 3);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $users->where(function($query) use ($search) {
                $query->where('fullname', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $users = $users->get();
        return view('users-management.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::whereNot('id', 3)->get();
        return view('users-management.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->merge([
                'password' => Hash::make($request->password),
                'created_by' => Auth::user()->id,
            ]);

            User::create($request->all());

            return redirect()->route('users-management.index')->withSuccess("Success create new user");

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('role')->find($id);
        $roles = Role::whereNot('id', 3)->get();
        return view('users-management.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::with('role')->find($id);

            if ($request->has('password')) {
                $request->merge(['password' => Hash::make($request->password)]);
            }
    
            $request->merge(['updated_by' => Auth::user()->id]);
            $user->update($request->all());

            return redirect()->route('users-management.edit', $id)->withSuccess("Success update user");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id)->delete();
            return redirect()->route('users-management.index')->withSuccess("Success delete user");
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
