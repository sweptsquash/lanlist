<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Http\Requests\UpdateAccountPasswordRequest;
use App\Models\User;
use App\Notifications\User\PasswordChangedNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class UpdateUserPasswordAction
{
    public function execute(UpdateAccountPasswordRequest $request): User
    {
        user()->update([
            'password' => Hash::make($request->input('new_password')),
            'password_changed_at' => now(),
        ]);

        Notification::send(user(), new PasswordChangedNotification($request->ip()));

        return user();
    }
}
