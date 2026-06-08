<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\OrganisationRole;
use App\Models\Organisation;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class OrganisationObserver
{
    public function created(Organisation $organisation): void
    {
        foreach (OrganisationRole::cases() as $role) {
            $dbRole = Role::create([
                'team_id' => $organisation->id,
                'name' => $role->value,
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

    public function deleting(Organisation $organisation): void
    {
        Role::query()->where('team_id', $organisation->id)
            ->get()
            ->each(function (Role $role): void {
                $role->permissions()->delete();

                $role->delete();
            });
    }
}
