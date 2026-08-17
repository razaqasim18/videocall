<?php

namespace App\Livewire\Admin\Setting;

use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class TermConditionSetting extends Component
{
    #[Layout('layouts.dashboard')]
    public ?string $term_condition_policy = null;

    public function mount()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $this->term_condition_policy = $settings['term_condition_policy'] ?? '';
    }

    public function saveSettings()
    {
        $this->validate([
            'term_condition_policy' => 'required|string',
        ]);
        $response = Setting::updateOrCreate(['key' => 'term_condition_policy'], ['key' => 'term_condition_policy', 'value' => $this->term_condition_policy]);
        if ($response) {
            session()->flash('success', 'Term & Condition policy updated successfully.');
        } else {
            session()->flash('error', 'Something went wrong.');
        }
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.setting.term-condition-setting');
    }
}
