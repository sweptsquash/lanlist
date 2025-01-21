<?php

namespace Database\Factories;

use App\Models\Organiser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrganiserJoinRequest>
 */
class OrganiserJoinRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organiser_id' => Organiser::factory()->create()->id,
            'user_id' => User::factory()->create()->id,
            'comments' => $this->faker->sentence(10),
        ];
    }
}
