<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Observers\UserObserver;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
#[ObservedBy(UserObserver::class)]
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, InteractsWithMedia, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'password_changed_at',
        'date_format',
        'timezone',
        'twitch_id',
        'discord_id',
        'ip',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'password_changed_at' => 'datetime',
            'last_active_at' => 'datetime',
        ];
    }

    public function registerMediaCollections(): void
    {
        $hash = md5(
            Str::of($this->email)->trim()->lower()
        );

        $thumbnailSize = config('media-library.thumbnail_size');

        $this->addMediaCollection('avatar')
            ->useFallbackUrl("https://www.gravatar.com/avatar/$hash?s=$thumbnailSize&d=mp")
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $thumbnailSize = config('media-library.thumbnail_size');

        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, $thumbnailSize, $thumbnailSize);
    }

    /** @return BelongsTo<Organiser, $this> */
    public function organiser(): BelongsTo
    {
        return $this->belongsTo(Organiser::class);
    }

    /** @return HasMany<Event, $this> */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /** @return HasMany<EventReview, $this> */
    public function eventReviews(): HasMany
    {
        return $this->hasMany(EventReview::class);
    }

    /** @return BelongsTo<Country, $this> */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
