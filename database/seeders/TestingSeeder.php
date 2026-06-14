<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\OrganisationRole;
use App\Enums\Roles;
use App\Models\Organisation;
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
                    'organisation' => [
                        'name' => 'LanList',
                        'role' => OrganisationRole::Owner->value,
                    ],
                ],
                [
                    'username' => 'moderator',
                    'role' => Roles::Moderator->value,
                    'organisation' => [
                        'name' => 'LanList',
                        'role' => OrganisationRole::Admin->value,
                    ],
                ],
                // Normal Platform User
                [
                    'username' => 'user',
                    'role' => Roles::User->value,
                    'organisation' => [
                        'name' => 'LanList',
                        'role' => OrganisationRole::Member->value,
                    ],
                ],
                // Users with an Org
                [
                    'username' => 'org-owner',
                    'role' => Roles::User->value,
                    'organisation' => [
                        'name' => 'Test Organisation',
                        'role' => OrganisationRole::Owner->value,
                    ],
                ],
                [
                    'username' => 'org-admin',
                    'role' => Roles::User->value,
                    'organisation' => [
                        'name' => 'Test Organisation',
                        'role' => OrganisationRole::Admin->value,
                    ],
                ],
                [
                    'username' => 'org-member',
                    'role' => Roles::User->value,
                    'organisation' => [
                        'name' => 'Test Organisation',
                        'role' => OrganisationRole::Member->value,
                    ],
                ],
            ];

            foreach ($users as $user) {
                $orgQuery = Organisation::query()
                    ->where('slug', str($user['organisation']['name'])->slug())
                    ->withoutGlobalScopes();

                if ($orgQuery->doesntExist()) {
                    $organisation = Organisation::factory()->create([
                        'name' => $user['organisation']['name'],
                        'slug' => str($user['organisation']['name'])->slug(),
                        'is_published' => true,
                    ]);
                } else {
                    $organisation = $orgQuery->first();
                }

                setPermissionsTeamId($organisation);

                $dbUser = User::factory()->create([
                    'username' => $user['username'],
                    'email' => $user['username'].'@lanlist.info',
                ]);

                $role = Role::query()
                    ->where('name', $user['role'])
                    ->whereNull('team_id')
                    ->first();

                $organisation->members()->attach($dbUser);

                $dbUser->assignRole($role);

                $orgRole = Role::query()
                    ->where('name', $user['organisation']['role'])
                    ->where('team_id', $organisation->id)
                    ->first();

                $dbUser->assignRole($orgRole);
            }
        }
    }
}
