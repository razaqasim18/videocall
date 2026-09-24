<?php

namespace App\Livewire\Agent\Package;

use App\Models\AgentPackageTransaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard', ['title' => 'Agent Packages'])]
class PList extends Component
{
    use WithPagination;

    public $search = '';

    public int $packageIdToDelete;

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
        $package = AgentPackageTransaction::find($this->packageIdToDelete);
        if ($package) {
            $package->delete();
            session()->flash('success', 'Purchase request deleted successfully.');
        }
        $this->dispatch('close-delete-modal');
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.agent.package.p-list', [
            'packages' => AgentPackageTransaction::query()
                ->where(function ($query) {
                    $query->where('coins', 'like', '%'.$this->search.'%')
                        ->orWhere('price', 'like', '%'.$this->search.'%')
                        ->orWhere('status', 'like', '%'.$this->search.'%')
                        ->orWhereHas('package', function ($packageQuery) {
                            $packageQuery->where('name', 'like', '%'.$this->search.'%');
                        });
                })
                ->where('agent_id', Auth::guard('agent')->id())
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withPath(route('agent.packages.report')),
        ]);
    }
}
