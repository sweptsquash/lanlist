<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            'admin' => [],
            'user' => [],
            'organiser-admin' => [],
            'organiser-user' => [],
        ])->each(function ($permissions, $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            collect($permissions)
                ->each(function ($permission) use ($role) {
                    $permission = Permission::firstOrCreate(['name' => $permission]);

                    $role->givePermissionTo($permission);
                });
        });
    }
}
