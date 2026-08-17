<?php

namespace App\Livewire\Admin\Setting;

use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class GeneralSetting extends Component
{
    use WithFileUploads;

    // Form Fields
    public ?string $site_name = null;

    public ?string $short_description = null;

    public ?string $email = null;

    public ?string $phone = null;

    public ?string $address = null;

    // Saved Image Paths (Strings)
    public ?string $logo = null;

    public ?string $favicon = null;

    // Temporary Uploads (Objects)
    public ?object $temlogo = null;

    public ?object $temfavicon = null;

    public ?string $agent_commission_amount = null;

    public ?string $agent_commission_type = null;

    public function mount()
    {
        // Fetch all settings at once to avoid 7 different database queries
        $settings = Setting::all()->pluck('value', 'key');

        $this->site_name = $settings['site_name'] ?? '';
        $this->short_description = $settings['short_description'] ?? '';
        $this->email = $settings['email'] ?? '';
        $this->phone = $settings['phone'] ?? '';
        $this->address = $settings['address'] ?? '';
        $this->logo = $settings['logo'] ?? null;
        $this->favicon = $settings['favicon'] ?? null;
        $this->agent_commission_type = $settings['agent_commission_type'] ?? null;
        $this->agent_commission_amount = $settings['agent_commission_amount'] ?? null;
    }

    public function saveSettings()
    {
        // 1. Validation
        $this->validate([
            'site_name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'temlogo' => 'nullable|image|max:1024', // Max 1MB
            'temfavicon' => 'nullable|image|max:512', // Max 512KB
            'agent_commission_type' => 'required',
            'agent_commission_amount' => 'required|min:1',
        ]);

        // 2. Handle Logo Upload
        if ($this->temlogo) {
            // Delete old logo if it exists
            if ($this->logo) {
                Storage::disk('public')->delete($this->logo);
            }
            // Store new logo in 'settings' folder
            $this->logo = $this->temlogo->store('uploads/settings', 'public');
        }

        // 3. Handle Favicon Upload
        if ($this->temfavicon) {
            // Delete old favicon
            if ($this->favicon) {
                Storage::disk('public')->delete($this->favicon);
            }
            $this->favicon = $this->temfavicon->store('uploads/settings', 'public');
        }

        // 4. Save all to Database using updateOrCreate
        $dataToSave = [
            'site_name' => $this->site_name,
            'short_description' => $this->short_description,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'logo' => $this->logo,
            'favicon' => $this->favicon,
            'agent_commission_type' => $this->agent_commission_type,
            'agent_commission_amount' => $this->agent_commission_amount,
        ];

        foreach ($dataToSave as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Reset temporary upload properties so they don't try to upload again
        $this->temlogo = null;
        $this->temfavicon = null;
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');
        session()->flash('success', 'Website settings updated successfully!');
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.setting.general-setting');
    }
}
