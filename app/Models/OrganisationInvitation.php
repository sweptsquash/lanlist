<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasUuids;
use App\Enums\OrganisationRole;
use Carbon\CarbonImmutable;
use Database\Factories\OrganisationInvitationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property string $code
 * @property int $organisation_id
 * @property string $email
 * @property OrganisationRole $role
 * @property int $invited_by
 * @property CarbonImmutable|null $expires_at
 * @property CarbonImmutable|null $accepted_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User $inviter
 * @property-read Organisation|null $organisation
 *
 * @method static \Database\Factories\OrganisationInvitationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereInvitedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereOrganisationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereUuid($value)
 *
 * @mixin Model
 */
#[Fillable([
    'uuid',
    'organisation_id',
    'email',
    'role',
    'invited_by',
    'expires_at',
    'accepted_at',
])]
#[UseFactory(OrganisationInvitationFactory::class)]
class OrganisationInvitation extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (OrganisationInvitation $invitation): void {
            if (empty($invitation->code)) {
                $invitation->code = Str::random(64);
            }
        });
    }

    /**
     * Get the organisation that the invitation belongs to.
     *
     * @return BelongsTo<Organisation, $this>
     */
    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    /**
     * Get the user who sent the invitation.
     *
     * @return BelongsTo<User, $this>
     */
    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    /**
     * Determine if the invitation has been accepted.
     */
    public function isAccepted(): bool
    {
        return $this->accepted_at !== null;
    }

    /**
     * Determine if the invitation is pending.
     */
    public function isPending(): bool
    {
        return $this->accepted_at === null && ! $this->isExpired();
    }

    /**
     * Determine if the invitation has expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => OrganisationRole::class,
            'expires_at' => 'datetime',
            'accepted_at' => 'datetime',
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
