<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCountry
 */
class Country extends Model
{
    protected $fillable = [
        'code',
        'name',
        'prefix',
    ];

    public static function findCode(self|string $country): ?self
    {
        if ($country instanceof static) {
            return $country;
        }

        return self::firstWhere('code', $country);
    }
}
