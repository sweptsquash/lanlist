<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperVenue
 */
class Venue extends Model
{
    /** @use HasFactory<\Database\Factories\VenueFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'country',
        'lat',
        'lng',
    ];

    protected $with = ['country'];

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

    /** @return BelongsTo<Country, $this> */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
