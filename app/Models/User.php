<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasOrganisations;
use App\Concerns\HasUuids;
use App\Observers\UserObserver;
use Carbon\CarbonImmutable;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Passkeys\Passkey;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\HasActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $uuid
 * @property string $username
 * @property string $email
 * @property CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property CarbonImmutable|null $password_changed_at
 * @property string|null $remember_token
 * @property int|null $country_id
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property CarbonImmutable|null $two_factor_confirmed_at
 * @property string|null $steam_username
 * @property int|null $discord_id
 * @property string $date_format
 * @property string $timezone
 * @property string $moderator_newsletter_frequency
 * @property string $event_update_emails
 * @property string|null $ip
 * @property CarbonImmutable|null $last_active_at
 * @property string|null $last_low_priority_email_sent_at
 * @property string|null $last_event_renminder_email_sent_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Activity> $activitiesAsCauser
 * @property-read int|null $activities_as_causer_count
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read string|null $avatar_url
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Membership> $organisationMemberships
 * @property-read int|null $organisation_memberships_count
 * @property-read Membership|null $pivot
 * @property-read Collection<int, Organisation> $organisations
 * @property-read int|null $organisations_count
 * @property-read Collection<int, Organisation> $ownedOrganisations
 * @property-read int|null $owned_organisations_count
 * @property-read Collection<int, Passkey> $passkeys
 * @property-read int|null $passkeys_count
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read Collection<int, Organisation> $teams
 * @property-read int|null $teams_count
 *
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDiscordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEventUpdateEmails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastActiveAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastEventRenminderEmailSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLowPriorityEmailSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereModeratorNewsletterFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePasswordChangedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSteamUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTeam($teams)
 *
 * @mixin Model
 */
#[ObservedBy(UserObserver::class)]
#[Fillable([
    'uuid',
    'username',
    'email',
    'email_verified_at',
    'password',
    'password_changed_at',
    'remember_token',
    'country_id',
    'two_factor_secret',
    'two_factor_recovery_codes',
    'two_factor_confirmed_at',
    'steam_username',
    'discord_id',
    'date_format',
    'timezone',
    'moderator_newsletter_frequency',
    'event_update_emails',
    'ip',
    'last_active_at',
    'last_low_priority_email_sent_at',
    'last_event_renminder_email_sent_at',
])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
#[UseFactory(UserFactory::class)]
class User extends Authenticatable implements HasMedia, MustVerifyEmail, PasskeyUser
{
    use HasActivity;
    use HasFactory;
    use HasOrganisations;
    use HasPermissions;
    use HasRoles;
    use HasUuids;
    use InteractsWithMedia;
    use Notifiable;
    use PasskeyAuthenticatable;
    use TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array{email_verified_at: 'datetime', password: 'hashed',  password_changed_at: 'datetime', last_active_at: 'datetime',  two_factor_confirmed_at: 'datetime'}
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'password_changed_at' => 'datetime',
            'last_active_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logExcept([
                'password',
                'remember_token',
                'two_factor_secret',
                'two_factor_recovery_codes',
                'invite_token_hash',
            ]);
    }

    public function registerMediaCollections(): void
    {
        $hash = md5((string) str($this->email)->trim()->lower());

        $this->addMediaCollection('avatar')
            ->singleFile()
            ->useFallbackUrl(sprintf('https://www.gravatar.com/avatar/%s?d=mp', $hash));
    }

    /** @return Attribute<string|null, never> */
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => in_array($this->getFirstMediaUrl('avatar', 'thumb'), ['', '0'], true) ? null : $this->getFirstMediaUrl('avatar', 'thumb'),
        );
    }

    public function organisations(): BelongsToMany
    {
        return $this->belongsToMany(Organisation::class, 'organisation_members', 'user_id', 'organisation_id')
            ->using(Membership::class)
            ->withPivot(['role'])
            ->withTimestamps();
    }
}
