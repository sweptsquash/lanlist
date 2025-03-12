<?php

declare(strict_types=1);

namespace App\Spatie\Filter;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FiltersEventVenueCountry implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $query->whereHas('venue', function (Builder $query) use ($value) {
            $query->whereHas('country', function (Builder $query) use ($value) {
                $query->where('code', $value);
            });
        });
    }
}
