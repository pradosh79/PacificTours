<?php

declare(strict_types=1);

namespace Tests;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Roles and permissions are infrastructure for almost every test.
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\RolePermissionSeeder']);
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\SettingSeeder']);
    }

    protected function asRole(RoleName $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role->value);

        $this->actingAs($user);

        return $user;
    }

    protected function asCustomer(): User
    {
        return $this->asRole(RoleName::Customer);
    }
}
