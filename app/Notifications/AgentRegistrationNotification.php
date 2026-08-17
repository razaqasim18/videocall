<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// Remove "implements ShouldQueue" if you don't want to run 'php artisan queue:work'
class AgentRegistrationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $email;

    public $password;

    public function __construct($email = null, $password = null)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // Use a clean variable for the subject
        $subject = 'Welcome Aboard! Your Account has been Registered on '.config('app.name');

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.agent_registration', [ // Fixed spelling: registraion -> registration
                'email' => $this->email,
                'password' => $this->password,
                'appName' => config('app.name'),
                'appCreatedLink' => config('app.created_by_link'),
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
