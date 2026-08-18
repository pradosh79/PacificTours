<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $map = config('permission_map');

        // 1. Permissions ------------------------------------------------------
        $all = [];

        foreach ($map['permissions'] as $group => $abilities) {
            foreach ($abilities as $ability) {
                $name  = "{$group}.{$ability}";
                $all[] = $name;
                Permission::findOrCreate($name, 'web');
            }
        }

        // 2. Roles ------------------------------------------------------------
        foreach ($map['roles'] as $roleName => $patterns) {
            $role = Role::findOrCreate($roleName, 'web');

            $granted = $patterns === '*'
                ? $all
                : collect($patterns)->flatMap(fn (string $pattern) => str_ends_with($pattern, '.*')
                    ? array_filter($all, fn ($p) => str_starts_with($p, rtrim($pattern, '*')))
                    : [$pattern])->unique()->values()->all();

            $role->syncPermissions($granted);
        }

        // 3. Founding super admin --------------------------------------------
        $admin = User::firstOrCreate(
            ['email' => 'admin@pacifictours.ca'],
            [
                'uuid'              => Str::uuid(),
                'first_name'        => 'Pacific',
                'last_name'         => 'Admin',
                'password'          => Hash::make('ChangeMe!2026'),
                'status'            => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        $admin->syncRoles([RoleName::SuperAdmin->value]);

        $this->command->warn('Super admin: admin@pacifictours.ca / ChangeMe!2026 — change this before going live.');
    }
}
