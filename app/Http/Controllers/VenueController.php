<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Http\Resources\VenueResource;
use App\Models\Country;
use App\Models\Venue;
use App\Spatie\Filter\FiltersVenueCountry;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class VenueController extends FrontendController
{
    public function index(): Response
    {
        $venues = QueryBuilder::for(Venue::query()->countUpcomingEvents())
            ->allowedFilters([
                'title',
                AllowedFilter::custom('country', new FiltersVenueCountry),
            ])
            ->allowedSorts(['title', 'events_count'])
            ->defaultSort('title')
            ->paginate(32)
            ->appends(request()->query());

        return inertia('Venues/index', [
            'venues' => VenueResource::collection($venues),
            'countries' => CountryResource::collection(Country::all()),
        ]);
    }

    public function show(Venue $venue): Response
    {
        $venue
            ->load(['events' => fn ($query) => $query->with('organiser')->upcoming()->limit(10)])
            ->loadCount(['events' => fn ($query) => $query->upcoming()]);

        return inertia('Venues/show', [
            'venue' => VenueResource::make($venue),
        ]);
    }
}
