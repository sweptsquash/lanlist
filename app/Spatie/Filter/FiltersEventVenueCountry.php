<?php

namespace App\Spatie\Filter;

use Spatie\QueryBuilder\Filters\Filter;

class FiltersEventVenueCountry implements Filter
{
    public function __invoke($query, $value, string $property): void
    {
        $query->whereHas('venue', function ($query) use ($value) {
            $query->whereHas('country', function ($query) use ($value) {
                $query->where('code', $value);
            });
        });
    }
}
