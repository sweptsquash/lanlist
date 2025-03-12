<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventReview>
 */
class EventReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'rating_venue' => fake()->numberBetween(1, 5),
            'rating_vfm' => fake()->numberBetween(1, 5),
            'rating_activities' => fake()->numberBetween(1, 5),
        ];
    }
}
