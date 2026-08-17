<?php

namespace App\Livewire\Admin\Setting;

use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PrivacyPolicySetting extends Component
{
    #[Layout('layouts.dashboard')]
    public ?string $privacy_policy = null;

    public function mount()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $this->privacy_policy = $settings['privacy_policy'] ?? '';
    }

    public function saveSettings()
    {
        $this->validate([
            'privacy_policy' => 'required|string',
        ]);
        $response = Setting::updateOrCreate(['key' => 'privacy_policy'], ['key' => 'privacy_policy', 'value' => $this->privacy_policy]);
        if ($response) {
            session()->flash('success', 'Privacy policy updated successfully.');
        } else {
            session()->flash('error', 'Something went wrong.');
        }
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.setting.privacy-policy-setting');
    }
}
