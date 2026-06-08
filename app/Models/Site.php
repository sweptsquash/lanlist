<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasCreator;
use App\Concerns\HasUuids;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $uuid
 * @property int|null $country_id
 * @property int|null $creator_id
 * @property string $name
 * @property string|null $url
 * @property string|null $description
 * @property int|null $order_id
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Country|null $country
 * @property-read User|null $creator
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Site whereUuid($value)
 *
 * @mixin Model
 */
class Site extends Model
{
    use HasCreator;
    use HasUuids;

    protected function casts()
    {
        return [
            'order_id' => 'integer',
        ];
    }

    /** @return BelongsTo<Country, $this> */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
