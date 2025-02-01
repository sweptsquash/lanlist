<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organiser>
 */
class OrganiserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'slug' => fake()->slug,
            'website' => fake()->url,
            'steam_group_url' => fake()->url,
            'blurb' => fake()->sentence(10),
            'is_published' => fake()->boolean,
            'use_favicon' => fake()->boolean,
            'assumed_stale_at' => fake()->dateTime(),
        ];
    }
}
