<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Events\Dispatcher;

class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function handleUserLogin(Login $event): void
    {
        /** @var User $user */
        $user = $event->user;

        activity('auth')
            ->by($user)
            ->performedOn($user)
            ->withProperties([
                'attributes' => [
                    'id' => $user->id,
                    'username' => $user->username,
                ],
            ])
            ->log('login');

        $user
            ->forceFill([
                'ip' => request()->ip(),
                'last_active_at' => now(),
            ])
            ->saveQuietly();
    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout(Logout $event): void
    {
        /** @var ?User $user */
        $user = $event->user;

        if (! $user) {
            return;
        }

        activity('auth')
            ->by($user)
            ->performedOn($user)
            ->withProperties([
                'attributes' => [
                    'id' => $user->id,
                    'username' => $user->username,
                ],
            ])
            ->log('logout');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @return array<string, string>
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            Login::class => 'handleUserLogin',
            Logout::class => 'handleUserLogout',
        ];
    }
}
