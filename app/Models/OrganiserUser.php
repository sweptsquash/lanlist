<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrganiserUser extends Pivot
{
    protected $table = 'organiser_users';

    protected $fillable = [
        'organiser_id',
        'user_id',
    ];

    /** @return BelongsTo<Organiser, $this> */
    public function organiser(): BelongsTo
    {
        return $this->belongsTo(Organiser::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
