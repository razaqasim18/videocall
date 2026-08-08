<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $token,
        public string $email,
    ) {
    }

    public function build(): self
    {
        return $this->subject('Reset your admin password')
            ->view('emails.admin.password-reset')
            ->with([
                'url' => route('admin.reset-password', ['token' => $this->token, 'email' => $this->email], true),
            ]);
    }
}
