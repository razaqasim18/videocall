<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;

    protected ?string $token;

    // FIX: Accept the token when the notification is created
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // $notifiable is the User model instance
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->email, // Get email from the user model
        ], false));

         return (new MailMessage)
            ->subject('Reset Your Password')
            ->view('mails.forgot-password', [
                'url' => $url,
                'count' => config('auth.passwords.users.expire')
            ]);
    }
}
