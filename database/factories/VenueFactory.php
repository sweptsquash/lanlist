<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venue>
 */
class VenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $coordinates = [
            [51.5074, -0.1278],  // London
            [53.4808, -2.2426],  // Manchester
            [55.9533, -3.1883],  // Edinburgh
            [52.4862, -1.8904],  // Birmingham
            [51.4545, -2.5879],  // Bristol
            [53.8008, -1.5491],  // Leeds
            [52.2053, 0.1218],   // Cambridge
            [50.8225, -0.1372],  // Brighton
            [51.7520, -1.2577],  // Oxford
            [54.9784, -1.6174],  // Newcastle
            [53.4084, -2.9916],  // Liverpool
            [52.6309, 1.2974],   // Norwich
            [50.3755, -4.1427],  // Plymouth
            [51.6214, -3.9436],  // Swansea
            [51.4816, -3.1791],  // Cardiff
        ];

        $venueCoordinates = fake()->randomElement($coordinates);

        return [
            'title' => fake()->sentence(3),
            'country_id' => Country::inRandomOrder()->limit(1)->first()->id,
            'lat' => $venueCoordinates[0],
            'lng' => $venueCoordinates[1],
        ];
    }
}
