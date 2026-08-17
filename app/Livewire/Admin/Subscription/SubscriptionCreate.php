<?php

namespace App\Livewire\Admin\Subscription;

use App\Models\Subscription;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SubscriptionCreate extends Component
{
    #[Layout('layouts.dashboard')]
    public string $name;

    public float $price;

    public int $days;

    public string $description;

    public bool $is_active = false;

    public bool $is_feature = false;

    public function saveSubscription()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'days' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        Subscription::create([
            'name' => $this->name,
            'price' => $this->price,
            'duration_days' => $this->days,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_feature' => $this->is_feature ? 1 : 0,
        ]);

        session()->flash('success', 'Subscription created successfully!');
        $this->reset(['name', 'is_active', 'is_feature', 'description', 'days', 'price']);
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.subscription.subscription-create');
    }
}
