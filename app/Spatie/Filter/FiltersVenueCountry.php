<?php

namespace App\Spatie\Filter;

use Spatie\QueryBuilder\Filters\Filter;

class FiltersVenueCountry implements Filter
{
    public function __invoke($query, $value, string $property): void
    {
        $query->whereHas('country', function ($query) use ($value) {
            $query->where('code', $value);
        });
    }
}
