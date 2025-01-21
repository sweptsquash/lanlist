<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperOrganiser
 */
class Organiser extends Model
{
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

    /** @return HasMany<User, $this> */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function joinRequests(): HasMany
    {
        return $this->hasMany(OrganiserJoinRequest::class);
    }
}
