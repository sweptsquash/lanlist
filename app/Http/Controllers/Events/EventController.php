<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\FrontendController;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Inertia\Response;
use Spatie\QueryBuilder\QueryBuilder;

class EventController extends FrontendController
{
    public function index(): Response
    {
        $events = QueryBuilder::for(Event::class)
            ->where('is_published', true)
            ->with([
                'organiser:id,title,slug',
                'venue',
            ])
            ->allowedFilters([
                'title',
                'organiser.title',
                'venue.title',
                'start_date',
                'seats',
            ])
            ->defaultSort('-start_date')
            ->allowedSorts('title', 'organiser.title', 'start_date', 'venue.title')
            ->paginate(32)
            ->appends(request()->query());

        return inertia('Events/index', ['events' => EventResource::collection($events)]);
    }

    public function show(Event $event): Response
    {
        return inertia('Events/view', [
            'event' => $event,
        ]);
    }
}
