<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasUuids;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $uuid
 * @property int $organisation_id
 * @property int $user_id
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Organisation|null $organisation
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationRequest whereOrganisationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationRequest whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationRequest whereUuid($value)
 *
 * @mixin Model
 */
#[Fillable([
    'uuid',
    'organisation_id',
    'user_id',
])]
class OrganisationRequest extends Model
{
    use HasUuids;

    /** @return BelongsTo<Organisation, $this> */
    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
