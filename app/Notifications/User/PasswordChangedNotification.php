<?php

namespace App\Notifications\User;

use App\Mail\User\PasswordChangedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $ip) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable): Mailable
    {
        return (new PasswordChangedMail($this->ip, $notifiable))->to($notifiable->email);
    }
}
