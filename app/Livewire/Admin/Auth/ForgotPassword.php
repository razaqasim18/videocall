<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth', ['title' => 'Forgot Password'])]
class ForgotPassword extends Component
{
    public string $email = '';
    public bool $emailSent = false;

    public function sendResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'email', 'exists:admins,email'],
        ]);

        $status = Password::broker('admins')->sendResetLink([
            'email' => $this->email,
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->emailSent = true;
            $this->reset('email');
            return;
        }

        $this->addError('email', __($status));
    }

    public function render()
    {
        return view('livewire.admin.auth.forgot-password');
    }
}
