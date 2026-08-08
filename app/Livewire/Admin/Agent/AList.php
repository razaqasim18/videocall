<?php

namespace App\Livewire\Admin\Agent;

use App\Models\Agent;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class AList extends Component
{
    public $search = '';
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
        $user = Agent::find($this->userIdToDelete);
        if ($user) {
            $user->delete();
            session()->flash('success', 'Agent deleted successfully.');
        }
        $this->dispatch('close-delete-modal');
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.agent.a-list',[
            'users' => Agent::when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10)->withPath(route('admin.agent.list')),
        ]);
    }


}
