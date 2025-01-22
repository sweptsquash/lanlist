<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([RoleSeeder::class]);

        if (! app()->isProduction()) {
            $this->call([
                UserSeeder::class,
                OrganiserSeeder::class,
                VenueSeeder::class,
                EventSeeder::class,
            ]);
        }
    }
}
