<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Detail extends Component
{
    #[Layout('layouts.dashboard')]
    public User $user;

    // Editable properties
    public $is_blocked;
    public $gender;
    public $coins;

    public function mount(int $id)
    {

        $this->user = User::with('subscription')->findOrFail($id);

        // Sync initial values from database to properties
        $this->is_blocked = $this->user->is_blocked ? 1 : 0;
        $this->gender = $this->user->gender ? 1 : 0;
        $this->coins = $this->user->coins;
    }

    public function updatedIsBlocked($property, $value)
    {
        if ($property === 'is_blocked') {
            $this->is_blocked = $value ? 1 : 0;
        }
    }

    public function saveAdminSettings()
    {
         $this->user->is_blocked = $this->is_blocked;
         $this->user->update([
            'is_blocked' => $this->is_blocked,
            'gender' => $this->gender,
            'coins' => $this->coins,
        ]);


        session()->flash('success', 'User profile updated successfully.');
        $this->user->refresh();
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.user.detail');
    }
}
