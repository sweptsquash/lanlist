<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/** @mixin Model */
trait HasUuids
{
    public static function bootHasUuids(): void
    {
        static::creating(function ($model): void {
            if (in_array('uuid', $model->getFillable()) && empty($model->getAttribute('uuid'))) {
                $model->setAttribute('uuid', (string) Str::orderedUuid());
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public static function findByUuid(string $uuid): ?Model
    {
        return static::where('uuid', $uuid)->first();
    }
}
