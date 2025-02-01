<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Http\Resources\EventResource;
use App\Models\Country;
use App\Models\Event;
use App\Spatie\Filter\FiltersEventVenueCountry;
use App\Spatie\Sort\OrganiserTitleSort;
use App\Spatie\Sort\VenueTitleSort;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Enums\FilterOperator;
use Spatie\QueryBuilder\QueryBuilder;

class EventController extends FrontendController
{
    public function index(): Response
    {
        $events = QueryBuilder::for(Event::class)
            ->allowedFilters([
                AllowedFilter::partial('event_title', 'title'),
                AllowedFilter::partial('organiser_title', 'organiser.title'),
                AllowedFilter::partial('venue_title', 'venue.title'),
                AllowedFilter::scope('start_between'),
                AllowedFilter::custom('country', new FiltersEventVenueCountry),
                AllowedFilter::operator('seats', FilterOperator::GREATER_THAN_OR_EQUAL),
            ])
            ->allowedSorts([
                'title',
                AllowedSort::custom('organiser.title', new OrganiserTitleSort, 'title'),
                AllowedSort::custom('venue.title', new VenueTitleSort, 'title'),
                'start_date',
            ])
            ->defaultSort('-start_date')
            ->with([
                'organiser:id,title,slug',
                'venue',
            ])
            ->paginate(32)
            ->appends(request()->query());

        return inertia('Events/index', [
            'events' => EventResource::collection($events),
            'countries' => CountryResource::collection(Country::all()),
        ]);
    }

    public function show(Event $event): Response
    {
        $event->load(['organiser', 'venue', 'reviews']);

        return inertia('Events/view', [
            'event' => $event,
        ]);
    }
}
