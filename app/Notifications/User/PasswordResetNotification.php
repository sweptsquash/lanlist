<?php

declare(strict_types=1);

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $token) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Password reset')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', route('auth.password.reset', $this->token))
            ->line('If you did not request a password reset, you may ignore this email and no action is required.');
    }
}
