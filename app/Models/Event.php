<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasCreator;
use App\Concerns\HasUuids;
use App\Enums\Alcohol;
use App\Enums\Showers;
use App\Enums\Sleeping;
use App\Enums\Smoking;
use App\Models\Scopes\EventPublishedScope;
use Carbon\CarbonImmutable;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int $id
 * @property string $uuid
 * @property int|null $creator_id
 * @property int $organisation_id
 * @property int $venue_id
 * @property string $title
 * @property string $slug
 * @property CarbonImmutable $start_date
 * @property CarbonImmutable $end_date
 * @property string|null $blurb
 * @property string|null $website
 * @property string|null $image_url
 * @property float|null $price_on_door
 * @property float|null $price_in_adv
 * @property string|null $currency
 * @property string|null $age_restrictions
 * @property Alcohol|null $alcohol
 * @property Sleeping|null $sleeping
 * @property Smoking|null $smoking
 * @property Showers|null $showers
 * @property int|null $seats
 * @property int|null $network_mbps
 * @property int|null $internet_mbps
 * @property bool $is_published
 * @property CarbonImmutable|null $tickets_release_at
 * @property CarbonImmutable|null $reminder_sent_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User|null $creator
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Organisation|null $organisation
 * @property-read Collection<int, EventReview> $reviews
 * @property-read int|null $reviews_count
 * @property-read Venue $venue
 *
 * @method static \Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static Builder<static>|Event newModelQuery()
 * @method static Builder<static>|Event newQuery()
 * @method static Builder<static>|Event query()
 * @method static Builder<static>|Event startBetween(string $start, string $end)
 * @method static Builder<static>|Event upcoming()
 * @method static Builder<static>|Event whereAgeRestrictions($value)
 * @method static Builder<static>|Event whereAlcohol($value)
 * @method static Builder<static>|Event whereBlurb($value)
 * @method static Builder<static>|Event whereCreatedAt($value)
 * @method static Builder<static>|Event whereCreatorId($value)
 * @method static Builder<static>|Event whereCurrency($value)
 * @method static Builder<static>|Event whereEndDate($value)
 * @method static Builder<static>|Event whereId($value)
 * @method static Builder<static>|Event whereImageUrl($value)
 * @method static Builder<static>|Event whereInternetMbps($value)
 * @method static Builder<static>|Event whereIsPublished($value)
 * @method static Builder<static>|Event whereNetworkMbps($value)
 * @method static Builder<static>|Event whereOrganisationId($value)
 * @method static Builder<static>|Event wherePriceInAdv($value)
 * @method static Builder<static>|Event wherePriceOnDoor($value)
 * @method static Builder<static>|Event whereReminderSentAt($value)
 * @method static Builder<static>|Event whereSeats($value)
 * @method static Builder<static>|Event whereShowers($value)
 * @method static Builder<static>|Event whereSleeping($value)
 * @method static Builder<static>|Event whereSlug($value)
 * @method static Builder<static>|Event whereSmoking($value)
 * @method static Builder<static>|Event whereStartDate($value)
 * @method static Builder<static>|Event whereTicketsReleaseAt($value)
 * @method static Builder<static>|Event whereTitle($value)
 * @method static Builder<static>|Event whereUpdatedAt($value)
 * @method static Builder<static>|Event whereUuid($value)
 * @method static Builder<static>|Event whereVenueId($value)
 * @method static Builder<static>|Event whereWebsite($value)
 * @method static Builder<static>|Event withUnpublished()
 *
 * @mixin Model
 */
#[UseFactory(EventFactory::class)]
#[Fillable([
    'uuid',
    'creator_id',
    'organisation_id',
    'venue_id',
    'title',
    'slug',
    'start_date',
    'end_date',
    'blurb',
    'website',
    'image_url',
    'price_on_door',
    'price_in_adv',
    'currency',
    'age_restrictions',
    'alcohol',
    'sleeping',
    'smoking',
    'showers',
    'seats',
    'network_mbps',
    'internet_mbps',
    'is_published',
    'tickets_release_at',
    'reminder_sent_at',
])]
#[ScopedBy(EventPublishedScope::class)]
class Event extends Model implements HasMedia
{
    use HasCreator;
    use HasFactory;
    use HasSlug;
    use HasUuids;
    use InteractsWithMedia;

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'sleeping' => Sleeping::class,
            'alcohol' => Alcohol::class,
            'smoking' => Smoking::class,
            'showers' => Showers::class,
            'seats' => 'integer',
            'is_published' => 'boolean',
            'tickets_release_at' => 'datetime',
            'reminder_sent_at' => 'datetime',
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner')->singleFile();
    }

    /** @return BelongsTo<Organisation, $this> */
    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    /** @return BelongsTo<Venue, $this> */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    /** @return HasMany<EventReview, $this> */
    public function reviews(): HasMany
    {
        return $this->hasMany(EventReview::class);
    }

    #[Scope]
    protected function withUnpublished(Builder $query): void
    {
        $query->withoutGlobalScope(EventPublishedScope::class);
    }

    #[Scope]
    protected function upcoming(Builder $query): void
    {
        $query->whereDate('events.start_date', '>=', today())
            ->oldest('events.start_date');
    }

    #[Scope]
    protected function startBetween(Builder $query, string $start, string $end): void
    {
        $query->whereBetween('events.start_date', [$start, $end]);
    }
}
