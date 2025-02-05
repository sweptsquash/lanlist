<?php

namespace App\Http\Controllers;

use App\Http\Resources\VenueResource;
use App\Models\Venue;
use App\Spatie\Filter\FiltersVenueCountry;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class VenueController extends FrontendController
{
    public function index()
    {
        $venues = QueryBuilder::for(Venue::class)
            ->allowedFilters([
                'title',
                AllowedFilter::custom('country', new FiltersVenueCountry),
            ])
            ->allowedSorts([])
            ->defaultSort('title')
            ->paginate(32)
            ->appends(request()->query());

        return inertia('Venues/index', [
            'venues' => VenueResource::collection($venues),
        ]);
    }

    public function show(Venue $venue)
    {
        // TODO
    }
}
