<?php

namespace App\Livewire\Admin\Reward;

use App\Models\MissionReward;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class RewardList extends Component
{
    use WithPagination;

    public $search = '';

    public $statusFilter = '';

    public $rewardIdToDelete = null; // To store the ID of the ticket being deleted

    protected string $paginationTheme = 'tailwind';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetMe()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function delete()
    {
        if ($this->rewardIdToDelete) {
            MissionReward::findOrFail($this->rewardIdToDelete)->delete();
            $this->rewardIdToDelete = null;
            session()->flash('success', 'Reward deleted successfully.');
        }
        $this->dispatch('close-delete-modal');
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        // Eager load 'creator' to prevent N+1 query issues
        $query = new MissionReward;

        if ($this->search) {
            $query->where('subject', 'like', '%'.$this->search.'%');
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.admin.reward.reward-list', [
            'rewards' => $query->paginate(10)->withPath(route('admin.ticket.list')),
        ]);
    }

    public function paginationView()
    {
        return 'vendor.pagination.tailwind';
    }
}
