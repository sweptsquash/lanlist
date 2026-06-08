<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\GeneratesUniqueOrganisationSlugs;
use App\Concerns\HasUuids;
use App\Enums\OrganisationRole;
use App\Models\Scopes\OrganisationPublishedScope;
use App\Observers\OrganisationObserver;
use Carbon\CarbonImmutable;
use Database\Factories\OrganisationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $slug
 * @property string|null $website
 * @property string|null $steam_group_url
 * @property string|null $blurb
 * @property bool $is_published
 * @property bool $use_favicon
 * @property bool $refetch_favicon
 * @property bool $valid_banner
 * @property CarbonImmutable|null $assumed_stale_at
 * @property string|null $lpps_url
 * @property CarbonImmutable|null $lpps_last_fetched_at
 * @property bool|null $lpps_crawl_successful
 * @property bool|null $lpps_crawl_result
 * @property bool $lpps_disabled
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 * @property-read Collection<int, OrganisationInvitation> $invitations
 * @property-read int|null $invitations_count
 * @property-read Membership|null $pivot
 * @property-read Collection<int, User> $members
 * @property-read int|null $members_count
 * @property-read Collection<int, Membership> $memberships
 * @property-read int|null $memberships_count
 *
 * @method static \Database\Factories\OrganisationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereAssumedStaleAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereBlurb($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereLppsCrawlResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereLppsCrawlSuccessful($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereLppsDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereLppsLastFetchedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereLppsUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereRefetchFavicon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereSteamGroupUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereUseFavicon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereValidBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation withoutTrashed()
 *
 * @mixin Model
 */
#[Fillable([
    'uuid',
    'name',
    'slug',
    'website',
    'steam_group_url',
    'blurb',
    'is_published',
    'use_favicon',
    'refetch_favicon',
    'valid_banner',
    'assumed_stale_at',
    'lpps_url',
    'lpps_last_fetched_at',
    'lpps_crawl_successful',
    'lpps_crawl_result',
    'lpps_disabled',
])]
#[UseFactory(OrganisationFactory::class)]
#[ScopedBy(OrganisationPublishedScope::class)]
#[ObservedBy([OrganisationObserver::class])]
class Organisation extends Model
{
    use GeneratesUniqueOrganisationSlugs;
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Organisation $organisation): void {
            if (empty($organisation->slug)) {
                $organisation->slug = static::generateUniqueOrganisationSlug($organisation->name);
            }
        });

        static::updating(function (Organisation $organisation): void {
            if ($organisation->isDirty('name')) {
                $organisation->slug = static::generateUniqueOrganisationSlug($organisation->name, $organisation->id);
            }
        });
    }

    /**
     * Get the organisation owner.
     */
    public function owner(): ?Model
    {
        return $this->members()
            ->wherePivot('role', OrganisationRole::Owner->value)
            ->first();
    }

    /**
     * Get all members of this organisation.
     *
     * @return BelongsToMany<Model, $this>
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organisation_members', 'organisation_id', 'user_id')
            ->using(Membership::class)
            ->withPivot(['role'])
            ->withTimestamps();
    }

    /**
     * Get all memberships for this organisation.
     *
     * @return HasMany<Membership, $this>
     */
    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    /**
     * Get all invitations for this organisation.
     *
     * @return HasMany<OrganisationInvitation, $this>
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(OrganisationInvitation::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'use_favicon' => 'boolean',
            'refetch_favicon' => 'boolean',
            'valid_banner' => 'boolean',
            'assumed_stale_at' => 'datetime',
            'lpps_last_fetched_at' => 'datetime',
            'lpps_crawl_successful' => 'boolean',
            'lpps_crawl_result' => 'boolean',
            'lpps_disabled' => 'boolean',
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
