<?php

namespace App\Livewire\Admin\Subscription;

use App\Models\Subscription;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class SubscriptionList extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $subscriptionIdToDelete = null;

    // Modal Visibility State
    public bool $showDeleteModal = false;

    public function paginationView()
    {
        return 'vendor.pagination.tailwind';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->reset('search');
    }

    // Helper to close modals (consistent with your other components)
    public function closeModals()
    {
        $this->showDeleteModal = false;
        $this->subscriptionIdToDelete = null;
    }

    public function delete()
    {
        if ($this->subscriptionIdToDelete) {
            Subscription::find($this->subscriptionIdToDelete)->delete();

            session()->flash('success', 'Subscription deleted successfully.');

            $this->dispatch('close-delete-modal');
            $this->dispatch('scroll-to-top');
        }
    }

    public function render()
    {
        return view('livewire.admin.subscription.subscription-list', [
            'subscriptions' => Subscription::when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('price', 'like', '%'.$this->search.'%')
                        ->orWhere('duration_days', 'like', '%'.$this->search.'%');
                });
            })
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withPath(route('admin.subscriptions.list')),
        ]);
    }
}
