<?php

namespace App\Models;

use App\Enums\AlcoholEnum;
use App\Enums\ShowersEnum;
use App\Enums\SmokingEnum;
use App\Models\Scopes\EventPublishedScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @mixin IdeHelperEvent
 */
#[ScopedBy(EventPublishedScope::class)]
class Event extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'creator_id',
        'organiser_id',
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
        'alcohol',
        'smoking',
        'showers',
        'seats',
        'network_mbps',
        'internet_mbps',
        'is_published',
    ];

    /**
     * @return array{start_date: 'datetime', end_date: 'datetime', alcohol: 'App\Enums\AlcoholEnum', smoking: 'App\Enums\SmokingEnum', showers: 'App\Enums\ShowersEnum', is_published: 'boolean'}
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'alcohol' => AlcoholEnum::class,
            'smoking' => SmokingEnum::class,
            'showers' => ShowersEnum::class,
            'is_published' => 'boolean',
        ];
    }

    public function getRouteKeyName()
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

    /** @return BelongsTo<User, $this> */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Organiser, $this> */
    public function organiser(): BelongsTo
    {
        return $this->belongsTo(Organiser::class);
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

    public function scopeWithUnpublished(Builder $query): void
    {
        $query->withoutGlobalScope(EventPublishedScope::class);
    }

    public function scopeUpcoming(Builder $query): void
    {
        $query->whereDate('events.start_date', '>=', today())
            ->orderBy('events.start_date');
    }

    public function scopeStartBetween(Builder $query, string $start, string $end): void
    {
        $query->whereBetween('events.start_date', [$start, $end]);
    }
}
