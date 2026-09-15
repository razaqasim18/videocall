<?php

namespace App\Livewire\Agent\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth', ['title' => 'Login'])]
class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function login()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('agent')->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {

            session()->regenerate();

            return redirect()->route('agent.dashboard');
        }

        $this->addError('email', 'Invalid credentials.');
    }

    public function render()
    {
        return view('livewire.agent.auth.login');
    }
}
