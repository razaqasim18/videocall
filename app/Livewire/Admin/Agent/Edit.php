<?php

namespace App\Livewire\Admin\Agent;

use App\Models\Agent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class Edit extends Component
{
    use WithFileUploads;

    public $agentId;

    public $name;

    public $email;

    public $password;

    public $profile_image;

    public $existing_image;

    public $wallet;

    public $is_blocked;

    public function mount($id)
    {
        $agent = Agent::findOrFail($id);
        $this->agentId = $id;
        $this->name = $agent->name;
        $this->email = $agent->email;
        $this->existing_image = $agent->profile_image;
        $this->wallet = $agent->wallet;
        $this->is_blocked = $agent->is_blocked;
    }

    public function updateAgent()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,'.$this->agentId,
            'password' => 'nullable|min:4',
            'profile_image' => 'nullable|image|max:2048',
            'wallet' => 'required|numeric|min:0.00',
            'is_blocked' => 'boolean',
        ]);

        $path = $this->existing_image;
        if ($this->profile_image) {
            if ($this->existing_image) {
                Storage::disk('public')->delete($this->existing_image);
            }
            $path = $this->profile_image->store('uploads/agents', 'public');
        }
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'profile_image' => $path,
            'wallet' => $this->wallet,
            'is_blocked' => $this->is_blocked,
        ];
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        Agent::find($this->agentId)->update($data);

        session()->flash('success', 'Agent updated successfully!');

    }

    public function render()
    {
        return view('livewire.admin.agent.edit');
    }
}
