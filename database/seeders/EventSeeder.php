<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventReview;
use App\Models\Organiser;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venues = Venue::all();

        $venues->each(function (Venue $venue) {
            $organiser = Organiser::whereHas('users')->inRandomOrder()->limit(1)->first();

            $events = Event::factory(5)->create([
                'venue_id' => $venue->id,
                'organiser_id' => $organiser->id,
                'creator_id' => $organiser->users()->whereHas('roles', function ($query) {
                    $query->where('name', 'organiser-admin');
                })->first()->id,
            ]);

            $events->each(fn (Event $event) => $event->reviews()->createMany(EventReview::factory(5)->make()->toArray()));
        });
    }
}
