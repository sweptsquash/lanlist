<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperVenue
 */
class Venue extends Model
{
    protected $fillable = [
        'title',
        'country',
        'lat',
        'lng',
    ];

    protected function casts(): array
    {
        return [
            'lat' => 'double',
            'lng' => 'double',
        ];
    }

    /** @return HasMany<Event, $this> */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
