<?php

declare(strict_types=1);

namespace App\Enums;

enum Roles: string
{
    case Administrator = 'administrator';
    case Moderator = 'moderator';
    case User = 'user';

    /**
     * Get the display label for the role.
     */
    public function label(): string
    {
        return ucfirst($this->value);
    }

    /**
     * Get the roles that can be assigned to platform members.
     *
     * @return array<array{value: string, label: string}>
     */
    public static function assignable(): array
    {
        return collect(self::cases())
            ->map(fn (self $role): array => ['value' => $role->value, 'label' => $role->label()])
            ->values()
            ->all();
    }

    /**
     * Get the permissions associated with the role.
     */
    public function permissions(): array
    {
        return []; // TODO
    }
}
