<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Enums\OrganisationRole;
use App\Models\Membership;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Query\Builder;
use Spatie\Permission\Models\Role;

trait HasOrganisations
{
    /**
     * Get all of the teams the user belongs to.
     *
     * @return BelongsToMany<Organisation, $this>
     */
    public function organisations(): BelongsToMany
    {
        return $this->belongsToMany(Organisation::class, 'team_members', 'user_id', 'team_id')
            ->withTimestamps();
    }

    /**
     * Get all of the teams the user owns.
     *
     * @return HasManyThrough<Organisation, Membership, $this>
     */
    public function ownedOrganisations(): HasManyThrough
    {
        return $this->hasManyThrough(
            Organisation::class,
            Membership::class,
            'user_id',
            'id',
            'id',
            'organisation_id',
        )->where('organisation_members.roles', function (Builder $query): void {
            $query->where('team_id', 'organisation_id')
                ->where('name', OrganisationRole::Owner->value);
        });
    }

    /**
     * Get all of the memberships for the user.
     *
     * @return HasMany<Membership, $this>
     */
    public function organisationMemberships(): HasMany
    {
        return $this->hasMany(Membership::class, 'user_id');
    }

    /**
     * Determine if the user belongs to the given team.
     */
    public function belongsToOrganisation(Organisation $organisation): bool
    {
        return $this->organisations()->where('organisations.id', $organisation->id)->exists();
    }

    /**
     * Determine if the user is the owner of the given team.
     */
    public function ownsOrganisation(Organisation $organisation): bool
    {
        return $this->organisationRole($organisation) === OrganisationRole::Owner;
    }

    /**
     * Get the user's role on the given team.
     */
    public function organisationRole(Organisation $organisation): ?Role
    {
        /** @var ?Membership $membership */
        $membership = $this->organisationMemberships()->where('organisation_id', $organisation->id)->first();

        return $membership?->role;
    }
}
