<?php

namespace App\Livewire\Admin\Subscription;

use App\Models\Subscription;
use App\Models\SubscriptionCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SubscriptionCreate extends Component
{
    #[Layout('layouts.dashboard')]

    // Use nullable types or defaults to prevent TypeErrors on empty form submissions
    public ?string $name = '';

    public ?float $price = null;

    public ?int $days = null;

    public ?string $description = '';

    public ?int $subscription_category_id = null;

    public bool $is_active = false;

    public bool $is_feature = false;

    public function saveSubscription()
    {
        $this->validate([
            'subscription_category_id' => 'required|exists:subscription_categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'days' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Subscription::create([
            'subscription_category_id' => $this->subscription_category_id,
            'name' => $this->name,
            'price' => $this->price,
            'duration_days' => $this->days,
            'description' => $this->description,
            'is_active' => $this->is_active ? 1 : 0, // Consistency: cast to 1/0
            'is_feature' => $this->is_feature ? 1 : 0,
        ]);

        session()->flash('success', 'Subscription created successfully!');

        $this->reset([
            'name',
            'price',
            'days',
            'description',
            'subscription_category_id',
            'is_active',
            'is_feature',
        ]);

        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.subscription.subscription-create', [
            'subscriptionCategories' => SubscriptionCategory::active()->get(),
        ]);
    }
}
