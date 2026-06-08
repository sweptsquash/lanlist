<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasCreator;
use App\Concerns\HasUuids;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int $id
 * @property string $uuid
 * @property int|null $country_id
 * @property int|null $creator_id
 * @property string $title
 * @property string $slug
 * @property float|null $lat The latitiude of the postcode
 * @property float|null $lng The longitude of the postcode
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Country|null $country
 * @property-read User|null $creator
 * @property-read Collection<int, Event> $events
 * @property-read int|null $events_count
 *
 * @method static Builder<static>|Venue countUpcomingEvents()
 * @method static Builder<static>|Venue newModelQuery()
 * @method static Builder<static>|Venue newQuery()
 * @method static Builder<static>|Venue query()
 * @method static Builder<static>|Venue whereCountryId($value)
 * @method static Builder<static>|Venue whereCreatedAt($value)
 * @method static Builder<static>|Venue whereCreatorId($value)
 * @method static Builder<static>|Venue whereId($value)
 * @method static Builder<static>|Venue whereLat($value)
 * @method static Builder<static>|Venue whereLng($value)
 * @method static Builder<static>|Venue whereSlug($value)
 * @method static Builder<static>|Venue whereTitle($value)
 * @method static Builder<static>|Venue whereUpdatedAt($value)
 * @method static Builder<static>|Venue whereUuid($value)
 *
 * @mixin Model
 */
#[Fillable([
    'uuid',
    'country_id',
    'creator_id',
    'title',
    'slug',
    'lat',
    'lng',
])]
class Venue extends Model
{
    use HasCreator;
    use HasSlug;
    use HasUuids;

    protected $with = ['country'];

    protected function casts(): array
    {
        return [
            'lat' => 'double',
            'lng' => 'double',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /** @return HasMany<\Illuminate\Support\Facades\Event, $this> */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /** @return BelongsTo<Country, $this> */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    protected function scopeCountUpcomingEvents(Builder $query): void
    {
        $query->withCount([
            'events' => fn (Builder $query) => $query->where('events.is_published', true)->upcoming(),
        ]);
    }
}
