<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasCreator;
use App\Concerns\HasUuids;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $uuid
 * @property int $event_id
 * @property int $creator_id
 * @property int|null $rating_venue
 * @property int|null $rating_vfm
 * @property int|null $rating_activities
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read User $creator
 * @property-read \Illuminate\Support\Facades\Event $event
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventReview query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventReview whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventReview whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventReview whereRatingActivities($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventReview whereRatingVenue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventReview whereRatingVfm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventReview whereUuid($value)
 *
 * @mixin Model
 */
#[Fillable([
    'uuid',
    'event_id',
    'creator_id',
    'rating_venue',
    'rating_vfm',
    'rating_activities',
])]
class EventReview extends Model
{
    use HasCreator;
    use HasUuids;

    protected function casts(): array
    {
        return [
            'rating_venue' => 'integer',
            'rating_vfm' => 'integer',
            'rating_activities' => 'integer',
        ];
    }

    /** @return BelongsTo<\Illuminate\Support\Facades\Event, $this> */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
