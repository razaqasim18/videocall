<?php

namespace App\Livewire\Admin\Reward;

use App\Models\MissionReward;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class RewardForm extends Component
{
    public $isEdit = false;

    public $rewardId;

    // Form Properties
    public $mission;

    public $coin;

    public $task = '';

    public $is_active = true;

    /**
     * Mount method handles the initialization of the component.
     */
    public function mount($id = null)
    {
        if ($id) {
            $this->isEdit = true;
            $this->rewardId = $id;

            $reward = MissionReward::findOrFail($id);

            $this->mission = $reward->mission;
            $this->coin = $reward->coin;
            $this->task = $reward->task;
            $this->is_active = (bool) $reward->is_active;
        }
    }

    /**
     * Validation rules for the reward form.
     */
    protected function rules()
    {
        return [
            'mission' => 'required|string|max:255',
            'coin' => 'required|integer|min:1',
            'task' => 'required|string|max:255',
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

        MissionReward::updateOrCreate(
            ['id' => $this->rewardId],
            [
                'mission' => $this->mission,
                'coin' => $this->coin,
                'task' => $this->task,
                'is_active' => $this->is_active,
            ]
        );

        // 2. Success Message
        session()->flash('success', $this->isEdit
            ? 'Reward value updated successfully!'
            : 'New reward value created successfully!');

        // 3. Reset fields only if we are creating a new record
        if (! $this->rewardId) {
            $this->reset(['mission', 'coin', 'task', 'is_active']);
        }

        // 4. Trigger UI events
        $this->dispatch('scroll-to-top');

    }

    public function render()
    {
        return view('livewire.admin.reward.reward-form');
    }
}
