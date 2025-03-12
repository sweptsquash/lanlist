<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Events\Dispatcher;

class UserRegisterSubscriber
{
    /**
     * Handle user registered events.
     */
    public function handleUserRegistered(Registered $event): void
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
            $event->user->sendEmailVerificationNotification();
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @return array<string, string>
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            Registered::class => 'handleUserRegistered',
        ];
    }
}
