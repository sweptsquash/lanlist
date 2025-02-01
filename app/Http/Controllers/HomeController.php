<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;
use Inertia\Response;

class HomeController extends FrontendController
{
    public function __invoke(): Response
    {
        $events = Event::upcoming()
            ->with(['venue'])
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

        return inertia('index', ['events' => $events]);
    }
}
