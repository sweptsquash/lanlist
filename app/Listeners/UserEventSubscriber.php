<?php

namespace App\Listeners;

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
        /** @var \App\Models\User $user */
        $user = $event->user;

        $user
            ->forceFill([
                'ip' => request()->ip(),
                'last_active_at' => now(),
            ])
            ->save();
    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout(Logout $event): void
    {
        // ...
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
