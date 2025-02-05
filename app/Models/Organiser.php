<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @mixin IdeHelperOrganiser
 */
class Organiser extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\OrganiserFactory> */
    use HasFactory, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'website',
        'steam_group_url',
        'blurb',
        'is_published',
        'use_favicon',
        'assumed_stale_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'use_favicon' => 'boolean',
            'assumed_stale_at' => 'datetime',
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
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('favicon')->singleFile();
    }

    /** @return HasMany<Event, $this> */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /** @return BelongsToMany<User, $this> */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organiser_users');
    }

    /** @return HasMany<OrganiserJoinRequest, $this> */
    public function joinRequests(): HasMany
    {
        return $this->hasMany(OrganiserJoinRequest::class);
    }

    public function scopeCountUpcomingEvents(Builder $query)
    {
        $query->withCount([
            'events' => fn ($query) => $query->where('events.is_published', true)->upcoming(),
        ]);
    }
}
