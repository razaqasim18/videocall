<?php

namespace App\Livewire\Admin;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('layouts.dashboard', ['title' => 'Profile Dashboard'])]
class Profile extends Component
{
    use WithFileUploads;
    public string $name;
    public string $email;
    public ?string $password = '';
    public ?object $temprofile = null;
    public ?string $profile = '';
    public function mount()
    {
        $user = Auth::guard('admin')->user();
        $this->email = $user->email;
        $this->name = $user->name;
        $this->profile = $user->profile_image;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:8',
            'temprofile' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Auth::guard('admin')->user();

        $data = [
            'name' => $this->name,
        ];

        if (!empty($this->password)) {
            $data['password'] = bcrypt($this->password);
        }

        if ($this->temprofile) {
            $data['profile_image'] = $this->temprofile->store('admin-profiles', 'public');
        }

        $user->update($data);

        session()->flash('success', 'Profile updated successfully.');

        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.profile');
    }
}
