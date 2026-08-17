<?php

namespace App\Livewire\Admin\Setting;

use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AboutApplicationSetting extends Component
{
    #[Layout('layouts.dashboard')]
    public ?string $about_application = null;

    public function mount()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $this->about_application = $settings['about_application'] ?? '';
    }

    public function saveSettings()
    {
        $this->validate([
            'about_application' => 'required|string',
        ]);
        $response = Setting::updateOrCreate(['key' => 'about_application'], ['key' => 'about_application', 'value' => $this->about_application]);
        if ($response) {
            session()->flash('success', 'About Application policy updated successfully.');
        } else {
            session()->flash('error', 'Something went wrong.');
        }
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.setting.about-application-setting');
    }
}
