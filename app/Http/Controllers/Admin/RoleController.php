<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    private $role;
    public function __construct()
    {
        $this->middleware('permission:roles-create')->only('create', 'store');
        $this->middleware('permission:roles-read')->only('index', 'show');
        $this->middleware('permission:roles-update')->only('edit', 'update');
        $this->middleware('permission:roles-delete')->only('destroy');
    }

    public function index()
    {
        $roles = Role::with('users')->whereNotIn('name', ['Super Admin', 'superadmin', 'super admin'])->withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $groups = [];
        foreach (Permission::all() as $index => $permission) {
            $groups[ucwords(str($permission->name)->remove(['-create','-read','-update','-delete'])->replace('-', ' '))][] = $permission;
        }

        return view('admin.roles.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name'],
            'permissions' => ['required','array'],
            'permissions.*' => ['required', 'exists:permissions,id']
        ]);

        DB::transaction(function ()use ($request){
            $this->role = Role::create([
                'name' => $request->input('name')
            ]);

            $this->role->permissions()->sync($request->input('permissions'));
        });

        return response()->json([
            'message' => __('Role created successfully'),
            'redirect' => route('admin.roles.index')
        ]);
    }

    public function edit(Role $role)
    {
        abort_if(in_array($role->name, ['Super Admin', 'superadmin', 'super admin']), 403, __("You are not allowed to mess with Super Admin"));
        $role->load('permissions');
        $groups = [];
        foreach (Permission::all() as $index => $permission) {
            $groups[ucwords(str($permission->name)->remove(['-', 'create','read','update','delete','status','list','folder']))][] = $permission;
        }

        return view('admin.roles.edit', compact('role', 'groups'));
    }

    public function update(Request $request, Role $role)
    {
        abort_if(in_array($role->name, ['Super Admin', 'superadmin', 'super admin']), 403, __("You are not allowed to mess with Super Admin"));
        $request->validate([
            'name' => ['required', 'string', Rule::unique('roles')->ignore($role->id)],
            'permissions' => ['required','array'],
            'permissions.*' => ['required', 'exists:permissions,id']
        ]);

        $role->update([
            'name' => $request->input('name')
        ]);

        $role->permissions()->sync($request->input('permissions'));

        return response()->json([
            'message' => __('Role update successfully'),
            'redirect' => route('admin.roles.index')
        ]);
    }

    public function destroy(Role $role)
    {
        abort_if(in_array($role->name, ['Super Admin', 'superadmin', 'super admin']), 403, __("You are not allowed to mess with Super Admin"));
        $role->delete();

        return response()->json([
            'message' => __('Role deleted successfully'),
            'redirect' => route('admin.roles.index')
        ]);
    }
}
