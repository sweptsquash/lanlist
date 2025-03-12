<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Http\Resources\OrganiserResource;
use App\Models\Country;
use App\Models\Organiser;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Spatie\QueryBuilder\QueryBuilder;

class OrganiserController extends FrontendController
{
    public function index(): Response
    {
        $organisers = QueryBuilder::for(Organiser::query()->countUpcomingEvents())
            ->allowedFilters([
                'title',
            ])
            ->allowedSorts(['title', 'events_count'])
            ->defaultSort('title')
            ->paginate(32)
            ->appends(request()->query());

        return inertia('Organisers/index', [
            'organisers' => OrganiserResource::collection($organisers),
            'countries' => CountryResource::collection(Country::all()),
        ]);
    }

    public function show(Organiser $organiser): Response
    {
        $organiser->load(['media', 'events' => fn (Builder $query) => $query->with('venue')->upcoming()]);

        return inertia('Organisers/show', [
            'organiser' => OrganiserResource::make($organiser),
        ]);
    }
}
