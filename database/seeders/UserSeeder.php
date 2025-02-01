<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@lanlist.info',
        ]);

        $adminUser->assignRole('admin');

        $users = User::factory(10)->create();

        $users->each(function (User $user) {
            $user->assignRole('user');
        });
    }
}
