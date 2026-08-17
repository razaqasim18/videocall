<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use App\Models\UserWalletTransaction;
// Assuming you have this model
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Detail extends Component
{
    use WithPagination;

    #[Layout('layouts.dashboard')]
    public User $user;

    // Editable properties
    public $name;

    public $email;

    public $gender;

    public $coins;

    public $is_blocked;

    public function mount(int $id)
    {
        $this->user = User::with(['subscription'])->findOrFail($id);

        // Sync initial values
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->gender = $this->user->gender;
        // $this->coins = $this->user->coins;
        $this->is_blocked = $this->user->is_blocked ? 1 : 0;
    }

    public function saveAdminSettings()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'gender' => 'required',
            'coins' => 'required|integer|min:0',
            'is_blocked' => 'required',
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'coins' => $this->coins,
            'is_blocked' => $this->is_blocked,
        ]);

        session()->flash('success', 'User profile and wallet updated successfully.');
        $this->user->refresh();
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.user.detail', [
            // Fetch transactions for this specific user
            'transactions' => UserWalletTransaction::where('user_id', $this->user->id)
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }
}
