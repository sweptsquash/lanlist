<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventReview extends Model
{
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
