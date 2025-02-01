<?php

namespace Database\Factories;

use App\Enums\AlcoholEnum;
use App\Enums\ShowersEnum;
use App\Enums\SmokingEnum;
use App\Models\Organiser;
use App\Models\User;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventDate = Carbon::parse(fake()->dateTimeBetween('now', '+1 year'))->toImmutable();

        return [
            'creator_id' => User::factory()->create()->id,
            'organiser_id' => Organiser::factory()->create()->id,
            'venue_id' => Venue::factory()->create()->id,
            'title' => fake()->words(2, true),
            'start_date' => $eventDate,
            'end_date' => $eventDate->addDays(2),
            'blurb' => fake()->sentence(10),
            'website' => fake()->url,
            'image_url' => fake()->imageUrl(),
            'price_on_door' => fake()->randomFloat(2, 0, 100),
            'price_in_adv' => fake()->randomFloat(2, 0, 100),
            'currency' => fake()->currencyCode,
            'alcohol' => fake()->randomElement(AlcoholEnum::cases()),
            'smoking' => fake()->randomElement(SmokingEnum::cases()),
            'showers' => fake()->randomElement(ShowersEnum::cases()),
            'seats' => fake()->numberBetween(1, 100),
            'network_mbps' => fake()->numberBetween(1, 1000),
            'internet_mbps' => fake()->numberBetween(1, 1000),
            'is_published' => fake()->boolean,
        ];
    }
}
