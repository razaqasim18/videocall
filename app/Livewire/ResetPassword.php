<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth', ['title' => 'Reset Password'])]
class ResetPassword extends Component
{
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    public function resetPassword(): void
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required'],
        ]);

        $status = Password::broker('users')->reset(
    [
        'token' => $this->token,
        'email' => $this->email,
        'password' => $this->password,
        'password_confirmation' => $this->password_confirmation,
    ],
    function (User $user, string $password) {
        $user->forceFill([
            'password' => Hash::make($password),
        ])->setRememberToken(Str::random(60));

        $user->save();
    }
);
 
        
        if ($status === Password::PASSWORD_RESET) {
           
            $this->redirect(route('success.message', [
                'status' => 'success',
                'message' => 'Password has been reset successfully.',
            ]));


            return;
        }

        $this->addError('email', __($status));
    }

    public function render()
    {
        return view('livewire.reset-password');
    }
}