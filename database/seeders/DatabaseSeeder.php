<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Commented out so we can make use of the HasUuids trait in the models.
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,

            // For Local/Testing only
            TestingSeeder::class,
        ]);
    }
}
