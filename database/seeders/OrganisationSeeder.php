<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Organisation;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    /**
     * Creates the LanList Organisation for the platform.
     * This is the default organisation that all users will be a part of.
     * This organisation will be used to manage the platform and its users.
     */
    public function run(): void
    {
        Organisation::query()->create([
            'name' => 'LanList',
            'is_published' => true,
        ]);
    }
}
