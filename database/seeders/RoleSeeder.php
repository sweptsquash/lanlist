<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Roles::cases() as $role) {
            $dbRole = Role::create([
                'name' => $role,
                'guard_name' => 'web',
            ]);

            foreach ($role->permissions() as $permission) {
                $permission = Permission::query()->firstOrCreate([
                    'name' => $permission->value,
                    'guard_name' => 'web',
                ]);

                $dbRole->permissions()->attach($permission);
            }
        }
    }
}
