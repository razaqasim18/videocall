<?php

namespace App\Livewire\Admin\Subscription;

use App\Models\Subscription;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SubscriptionEdit extends Component
{
    #[Layout('layouts.dashboard')]

    // Route parameter
    public int $id;

    // Form fields
    public string $name;

    public float $price;

    public int $days;

    public string $description;

    public bool $is_active;

    public bool $is_feature;

    public function mount($id)
    {
        $this->id = $id;

        // Fetch the subscription and fill the form
        $subscription = Subscription::findOrFail($id);

        $this->name = $subscription->name;
        $this->price = $subscription->price;
        $this->days = $subscription->duration_days;
        $this->description = $subscription->description ?? '';
        $this->is_active = $subscription->is_active;
        $this->is_feature = $subscription->is_feature;
    }

    public function saveSubscription()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'days' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        // Update the existing record
        Subscription::where('id', $this->id)->update([
            'name' => $this->name,
            'price' => $this->price,
            'duration_days' => $this->days,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_feature' => $this->is_feature ? 1 : 0,
        ]);

        session()->flash('success', 'Subscription updated successfully!');
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.subscription.subscription-edit');
    }
}
