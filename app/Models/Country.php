<?php

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

    public static function findCode(Country|string $country): ?self
    {
        if ($country instanceof static) {
            return $country;
        }

        return self::firstWhere('code', $country);
    }
}
