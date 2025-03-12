<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperOrganiserJoinRequest
 */
class OrganiserJoinRequest extends Model
{
    /** @use HasFactory<\Database\Factories\OrganiserJoinRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'organiser_id',
        'user_id',
        'comments',
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
