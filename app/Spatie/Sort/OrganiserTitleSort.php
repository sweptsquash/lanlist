<?php

namespace App\Spatie\Sort;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class OrganiserTitleSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        $query->join('organisers', 'organisers.id', '=', 'events.organiser_id')->orderByRaw("LENGTH(`organisers`.`{$property}`) {$direction}");
    }
}
