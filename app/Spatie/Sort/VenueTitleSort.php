<?php

declare(strict_types=1);

namespace App\Spatie\Sort;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class VenueTitleSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        $query->join('venues', 'venues.id', '=', 'events.venue_id')->orderByRaw("LENGTH(`venues`.`{$property}`) {$direction}");
    }
}
