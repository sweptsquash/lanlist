<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    public function creating(User $user): void
    {
        $user->username = Str::slug($user->username);
    }

    public function updating(User $user): void
    {
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;

            $user->sendEmailVerificationNotification();
        }

        if ($user->isDirty('password')) {
            $user->password_changed_at = now();
        }
    }
}
