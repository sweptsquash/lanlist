<?php

declare(strict_types=1);

namespace App\Actions\User\Organisation;

use App\Models\Organiser;
use App\Models\User;

class OrganisationJoinAction
{
    public function execute(User $user, Organiser $organiser): void
    {
        // $user->organiser()->syncWithoutDetaching($organiser);

        // TODO: Implement store organisation
    }
}
