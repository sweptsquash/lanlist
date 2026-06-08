<?php

declare(strict_types=1);

namespace App\Enums;

use Exception;

enum OrganisationRole: string
{
    case Owner = 'owner';
    case Admin = 'admin';
    case Member = 'member';

    /**
     * Get the display label for the role.
     */
    public function label(): string
    {
        return ucfirst($this->value);
    }

    /**
     * Get the roles that can be assigned to organisation members (excludes Owner).
     *
     * @return array<array{value: string, label: string}>
     */
    public static function assignable(): array
    {
        return collect(self::cases())
            ->filter(fn (self $role): bool => $role !== self::Owner)
            ->map(fn (self $role): array => ['value' => $role->value, 'label' => $role->label()])
            ->values()
            ->all();
    }

    /**
     * Get the permissions associated with the role.
     *
     * @throws Exception
     */
    public function permissions(): array
    {
        return match ($this->value) {
            self::Owner->value => OrganisationPermission::cases(),
            self::Admin->value => [
                OrganisationPermission::AddMember,
                OrganisationPermission::UpdateMember,
                OrganisationPermission::RemoveMember,
                OrganisationPermission::CreateInvitation,
                OrganisationPermission::CancelInvitation,
            ],
            self::Member->value => [],
            default => throw new Exception('Unexpected match value'),
        };
    }
}
