<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class UList extends Component
{
      use WithPagination;

    // Properties for search and filtering
    #[Layout('layouts.dashboard')]
    public string $search = '';
    public ?int $subscriptionIdToDelete = null;
    public ?int $userIdForDelete;
    public $showUserModal = false;
    public $showDeleteModal = false; // Controls if modal is visible
    public ?int $userIdToDelete = null;   // Stores the ID of the user to delete

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

    public function delete()
    {
        $user = User::find($this->userIdToDelete);
        if ($user) {
            $user->delete();
            session()->flash('success', 'User deleted successfully.');
        }
        $this->dispatch('close-delete-modal');
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.user.u-list',[
            'users' => User::with('subscription')
                    ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%')
                            ->orWhereHas('subscription', function ($sbquery) {
                                $sbquery->where('name', 'like', '%' . $this->search . '%');
                            });
                    });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10)->withPath(route('admin.user.list')),
        ]);
    }
}
