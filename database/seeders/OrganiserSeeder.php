<?php

namespace Database\Seeders;

use App\Models\Organiser;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrganiserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organisers = Organiser::factory(10)->create();

        $organisers->each(function (Organiser $organiser) {
            $organiser
                ->addMedia(base_path('public/android-icon-48x48.png'))
                ->preservingOriginal()
                ->toMediaCollection('favicon');

            $organiser
                ->addMedia(resource_path('images/lanlist.png'))
                ->preservingOriginal()
                ->toMediaCollection('logo');

            $users = $organiser->users()->saveMany(User::factory(5)->make());

            $users->each(function (User $user, int $index) {
                if ($index === 0) {
                    $user->assignRole('organiser-admin');
                } else {
                    $user->assignRole('organiser-user');
                }
            });
        });
    }
}
