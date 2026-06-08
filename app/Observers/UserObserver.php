<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function updating(User $user): void
    {
        if ($user->isDirty('password')) {
            $user->password_changed_at = now();
        }
    }
}
