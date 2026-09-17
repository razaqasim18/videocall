<?php

namespace App\Livewire\Admin\AgentPackage;

use App\Models\AgentPackage;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    #[Layout('layouts.dashboard')]

    // Route parameter
    public int $id;

    // Form fields - Using nullable types to prevent TypeErrors if inputs are cleared
    public ?string $name = '';

    public ?float $price = null;

    public ?int $coins = null;

    public ?string $description = '';

  
    public bool $is_active = false;

  
    public function mount($id)
    {
        $this->id = $id;

        // Fetch the subscription and fill the form
        $subscription = AgentPackage::findOrFail($id);

        $this->name = $subscription->name;
        $this->price = $subscription->price;
        $this->coins = $subscription->coins;
        $this->description = $subscription->description ?? '';
        $this->is_active = (bool) $subscription->is_active;
    }

    public function saveSubscription()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'coins' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        // Find the model instance and update it
        $subscription = AgentPackage::findOrFail($this->id);

        $subscription->update([
            'name' => $this->name,
            'price' => $this->price,
            'coins' => $this->coins,
            'description' => $this->description,
            'is_active' => $this->is_active ? 1 : 0,
        ]);

        session()->flash('success', 'Agent Package updated successfully!');
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.agent-package.edit');
    }
}
