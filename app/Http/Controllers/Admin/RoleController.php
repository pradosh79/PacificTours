<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    public function __construct()
    {
        // Only a super admin may reshape who can do what.
        $this->middleware(function ($request, $next) {
            abort_unless(auth()->user()->isSuperAdmin(), 403);

            return $next($request);
        });
    }

    public function index()
    {
        return view('admin.users.roles', [
            'roles'       => Role::with('permissions')->withCount('users')->get(),
            'permissions' => Permission::all()->groupBy(fn ($p) => explode('.', $p->name)[0]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:60', 'unique:roles,name'],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        Role::create(['name' => $data['name'], 'guard_name' => 'web'])
            ->syncPermissions($data['permissions'] ?? []);

        return back()->with('success', 'Role created.');
    }

    public function update(Request $request, Role $role)
    {
        abort_if(
            $role->name === RoleName::SuperAdmin->value,
            403,
            'The super admin role always holds every permission and cannot be edited.'
        );

        $data = $request->validate([
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $role->syncPermissions($data['permissions'] ?? []);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return back()->with('success', "Permissions updated for {$role->name}.");
    }

    public function destroy(Role $role)
    {
        abort_if(
            in_array($role->name, [RoleName::SuperAdmin->value, RoleName::Customer->value], true),
            403,
            'Built-in roles cannot be deleted.'
        );

        abort_if($role->users()->exists(), 409, 'Reassign the users on this role first.');

        $role->delete();

        return back()->with('success', 'Role deleted.');
    }
}
