<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Event;
use App\Models\Organisation;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

#[UseModel(Event::class)]
class EventFactory extends Factory
{
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-1 years', 'now');
        $endDate = $startDate->modify('+1 week');

        return [
            'creator_id' => User::factory()->create()->id,
            'organisation_id' => Organisation::factory()->create()->id,
            'venue_id' => Venue::factory()->create()->id,
            'title' => 'Event: '.fake()->word(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'blurb' => fake()->word(),
            'website' => fake()->word(),
            'image_url' => fake()->imageUrl(),
            'price_on_door' => fake()->randomFloat(),
            'price_in_adv' => fake()->randomFloat(),
            'currency' => fake()->randomElement(['GBP', 'EUR', 'USD']),
            'age_restrictions' => fake()->word(),
            'alcohol' => fake()->boolean(),
            'sleeping' => fake()->boolean(),
            'smoking' => fake()->boolean(),
            'showers' => fake()->boolean(),
            'seats' => fake()->randomNumber(2, true),
            'network_mbps' => fake()->randomNumber(3),
            'internet_mbps' => fake()->randomNumber(3),
            'is_published' => fake()->boolean(),
            'tickets_release_at' => fake()->randomElement([null, $startDate->modify('-1 week')]),
            'reminder_sent_at' => null,
        ];
    }
}
