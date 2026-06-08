<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @mixin Model */
trait HasCreator
{
    public static function bootHasCreator(): void
    {
        static::creating(function ($model): void {
            if (in_array('creator_id', $model->getFillable()) && blank($model->creator_id) && user() instanceof User) {
                $model->creator_id = user()->id;
            }
        });
    }

    public static function findByCreator(string $uuid): ?Model
    {
        return static::whereHas('creator', fn (Builder $query) => $query->where('uuid', $uuid))->first();
    }

    /** @return BelongsTo<User, $this> */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
