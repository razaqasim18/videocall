<?php

namespace App\Livewire\Admin\Agent;

use App\Models\Agent;
use App\Notifications\AgentRegistrationNotification;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads; // Import Hash facade

#[Layout('layouts.dashboard')]
class Create extends Component
{
    use WithFileUploads;

    public $name;

    public $email;

    public $password;

    public $profile_image;

    public $wallet = 0;

    public $is_blocked = false;

    public function saveAgent()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:6', // Increased to 6 for better security
            'email' => 'required|email|unique:agents,email|max:255',
            'profile_image' => 'nullable|image|max:2048',
            'wallet' => 'required|numeric|min:0',
            'is_blocked' => 'boolean',
        ]);

        $path = null;
        if ($this->profile_image) {
            $path = $this->profile_image->store('uploads/agents', 'public');
        }

        // 1. Create the agent with a HASHED password
        $agent = Agent::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password), // <--- IMPORTANT: Secure hashing
            'profile_image' => $path,
            'wallet' => $this->wallet,
            'is_blocked' => $this->is_blocked,
        ]);

        // 2. Send the notification using the plain text password
        // (Since we can't "un-hash" the password from the database)
        $agent->notify(new AgentRegistrationNotification($this->email, $this->password));

        session()->flash('success', 'Agent created successfully!');

        return redirect()->route('admin.agent.list');
    }

    public function render()
    {
        return view('livewire.admin.agent.create');
    }
}
