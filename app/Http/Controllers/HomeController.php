<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Http\Resources\OrganiserResource;
use App\Models\Event;
use App\Models\Organiser;
use Inertia\Response;

class HomeController extends FrontendController
{
    public function __invoke(): Response
    {
        $events = Event::upcoming()
            ->with(['venue', 'organiser.media'])
            ->limit(6)
            ->get()
            ->groupBy(function ($event) {
                return $event->start_date->format('n');
            })
            ->map(function ($events) {
                return $events->map(fn (Event $event) => EventResource::make($event));
            })
            ->take(3)
            ->values();

        $featuredOrganisers = Organiser::with('media')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return inertia('index', [
            'events' => $events,
            'featured' => OrganiserResource::collection($featuredOrganisers),
        ]);
    }
}
