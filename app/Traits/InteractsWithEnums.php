<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ValueError;

/**
 * Provides utility methods for working with enums.
 */
trait InteractsWithEnums
{
    /**
     * Returns all enum case names as an array.
     *
     * @return array<array-key, string>
     */
    public static function names(bool $humanName = false): array
    {
        return array_map(
            fn ($item) => $humanName ? Str::of($item->name)
                ->lower()
                ->replace('_', ' ')
                ->title()->value() : $item->name,
            static::cases()
        );
    }

    /**
     * Returns all enum case values as an array.
     *
     * @return array<array-key, string|int>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Combines all enum case values with their corresponding names into an associative array.
     *
     * @return array<string, string|int> An associative array where keys are enum case names and values are enum case values.
     */
    public static function array(): array
    {
        /** @var array<string, string|int> */
        return array_combine(self::names(), self::values());
    }

    /**
     * Combines all enum case values with their corresponding names into an associative array,
     * then converts to a Laravel collection.
     *
     * @return Collection<string, string|int>
     */
    public static function collect(): Collection
    {
        return collect(self::array());
    }

    /**
     * Returns an enum case value from its name.
     */
    public static function getValueFromName(string $name): string|int
    {
        return collect(self::cases())
            ->firstWhere('name', $name)
            ->value ?? throw new ValueError($name.' is not a valid backing value for enum '.self::class.'.');
    }

    /**
     * Returns an array of key-value pairs where each pair consists of an enum case name and its corresponding value.
     *
     * @return list<array{key: string, value: string|int}>
     */
    public static function keyValues(bool $humanName = false): array
    {
        return array_map(
            fn (string $key, mixed $value): array => ['key' => $key, 'value' => $value],
            static::names($humanName), static::values()
        );
    }
}
