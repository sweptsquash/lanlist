<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperOrganiser
 */
class Organiser extends Model
{
    /** @use HasFactory<\Database\Factories\OrganiserFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'website',
        'stream_group_url',
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

    public function joinRequests(): HasMany
    {
        return $this->hasMany(OrganiserJoinRequest::class);
    }
}
