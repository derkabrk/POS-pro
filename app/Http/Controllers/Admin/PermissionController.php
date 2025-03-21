<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permissions-read')->only('index','search');
        $this->middleware('permission:permissions-create')->only('store');
    }

    public function index(Request $request)
    {
        $users = User::whereNotIn('role', ['shop-owner', 'staff', 'superadmin'])->get();
        $roles = Role::where('name', '!=', 'superadmin')->get();
        return view('admin.permissions.index', compact('roles', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user' => ['required', 'exists:users,id'],
            'roles' => ['required', 'exists:roles,id']
        ]);

        $user = User::findOrFail($request->input('user'));
        $user->roles()->sync($request->input('roles'));

        return response()->json([
            'message' => __('Role permissions assigned successfully.'),
            'redirect' => route('admin.permissions.index')
        ]);
    }
}
