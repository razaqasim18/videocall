<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserWelcomeAPINotifcation extends Notification
{
    use Queueable;

    public User $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $subject = 'Welcome Aboard! Your Account has been Registered on '.config('app.name');

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.user_welcome_api', [
                'user' => $this->user, // Now passing the full object
                'appName' => config('app.name'),
                'iosLink' => config('app.APP_LINK_IOSSTORE'),
                'androidLink' => config('app.APP_LINK_PLAYSTORE'),
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
