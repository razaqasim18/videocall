<?php

namespace App\Livewire;

use App\Models\Admin;
use App\Models\Agent;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth', ['title' => 'Reset Password'])]
class ResetPassword extends Component
{
    public string $email = '';

    public string $token = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function mount()
    {
        $this->token = request()->query('token');
        $this->email = request()->query('email');
    }

    public function updatePassword()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        // Get reset token record
        $record = DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->first();

        if (! $record) {
            session()->flash('error', 'Invalid request');

            return;
        }

        // Verify token
        if (! Hash::check($this->token, $record->token)) {
            session()->flash('error', 'Invalid or expired token');

            return;
        }

        // Find user OR partner
        $account = User::where('email', $this->email)->first();

        $redirectRoute = route('success.page', [
            'status' => 1,
            'message' => 'Password updated successfully',
        ]);

        if (! $account) {
            $account = Agent::where('email', $this->email)->first();
            $redirectRoute = route('agent.login');
        }

        if (! $account) {
            $account = Admin::where('email', $this->email)->first();
            $redirectRoute = route('admin.login');
        }

        if (! $account) {
            session()->flash('error', 'User not found');

            return;
        }

        // Update password
        $account->update([
            'password' => Hash::make($this->password),
        ]);

        // Delete token
        DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->delete();

        return redirect($redirectRoute);
    }

    public function render()
    {
        return view('livewire.reset-password');
    }
}
