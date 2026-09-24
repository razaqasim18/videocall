<?php

namespace App\Livewire\Admin\DailyReward;

use App\Models\DailyReward;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Form extends Component
{
    public $isEdit = false;

    public $rewardId;

    public $days;

    public $coins;

    public $is_active = true;

    /**
     * Mount method handles the initialization of the component.
     */
    public function mount($id = null)
    {
        if ($id) {
            $this->isEdit = true;
            $this->rewardId = $id;
            $reward = DailyReward::findOrFail($id);
            $this->days = $reward->days;
            $this->coins = $reward->coins;
            $this->is_active = (bool) $reward->is_active;
        }
    }

    /**
     * Validation rules for the reward form.
     */
    protected function rules()
    {
        return [
            'days' => 'required|integer|max:255|unique:daily_rewards,days,'.$this->rewardId,
            'coins' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Handle the saving of the reward.
     */
    public function saveReward()
    {
        // 1. Validate the input
        $this->validate();
        DailyReward::updateOrCreate(
            ['id' => $this->rewardId],
            [
                'days' => $this->days,
                'coins' => $this->coins,
                'is_active' => $this->is_active,
            ],
        );
        // 2. Success Message
        session()->flash('success', $this->isEdit ? 'Daily Reward value updated successfully!' : 'Daily New reward value created successfully!');
        // 3. Reset fields only if we are creating a new record
        if (! $this->rewardId) {
            $this->reset(['days', 'coins', 'is_active']);
        }
        // 4. Trigger UI events
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.daily-reward.form');
    }
}
