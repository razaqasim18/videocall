<?php

namespace App\Livewire\Admin\AgentSubscription;

use App\Models\AgentSubscription;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SubscriptionCreate extends Component
{
    #[Layout('layouts.dashboard')]
    public ?string $name = '';
    public ?float $price = null;
    public ?int $coins = null;
    public ?string $description = '';
    public bool $is_active = false;

    public function saveSubscription()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'coins' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        AgentSubscription::create([
            'name' => $this->name,
            'price' => $this->price,
            'coins' => $this->coins,
            'description' => $this->description,
            'is_active' => $this->is_active ? 1 : 0, // Consistency: cast to 1/0
       ]);

        session()->flash('success', 'Agent Subscription created successfully!');

        $this->reset([
            'name',
            'price',
            'coins',
            'description',
            'is_active',
        ]);

        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.agent-subscription.subscription-create');
    }
}
