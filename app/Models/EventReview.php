<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperEventReview
 */
class EventReview extends Model
{
    /** @use HasFactory<\Database\Factories\EventReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'rating_venue',
        'rating_vfm',
        'rating_activities',
    ];

    protected function casts(): array
    {
        return [
            'rating_venue' => 'integer',
            'rating_vfm' => 'integer',
            'rating_activities' => 'integer',
        ];
    }

    /** @return BelongsTo<Event, $this> */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
