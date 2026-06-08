<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class TestingSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->isProduction()) {
            $users = [
                [
                    'username' => 'admin',
                    'role' => Roles::Administrator->value,
                ],
                [
                    'username' => 'moderator',
                    'role' => Roles::Moderator->value,
                ],
                [
                    'username' => 'user',
                    'role' => Roles::User->value,
                ],
            ];

            foreach ($users as $user) {
                $user = User::factory()->create([
                    'username' => $user['username'],
                    'email' => $user['username'].'@lanlist.info',
                ]);

                $role = Role::query()
                    ->where('name', $user['role'])
                    ->whereNull('team_id')
                    ->first();

                $user->assignRole($role);
            }
        }
    }
}
