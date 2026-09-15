<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $token,
        public string $email,
        public string $role,
    ) {}

    public function build(): self
    {
        $url = '';
        if ($this->role == 'admin') {
            $url = 'admin.reset-password';
        } elseif ($this->role == 'agent') {
            $url = 'agent.reset-password';
        } else {
            $url = 'reset-password';
        }

        return $this->subject('Reset your admin password')
            ->view('emails.password-reset')
            ->with([
                'url' => route($url, ['token' => $this->token, 'email' => $this->email, 'role' => $this->role], true),
            ]);
    }
}
