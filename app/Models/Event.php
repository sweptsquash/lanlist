<?php

namespace App\Models;

use App\Enums\AlcoholEnum;
use App\Enums\ShowersEnum;
use App\Enums\SmokingEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperEvent
 */
class Event extends Model
{
    protected $fillable = [
        'creator_id',
        'organiser_id',
        'venue_id',
        'title',
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
}
