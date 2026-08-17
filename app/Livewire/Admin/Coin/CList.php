<?php

namespace App\Livewire\Admin\Coin;

use App\Models\Coin;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class CList extends Component
{
    use WithPagination;

    public $search = '';

    public $coinIdToDelete;

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
        $coin = Coin::find($this->coinIdToDelete);
        if ($coin) {
            $coin->delete();
            session()->flash('success', 'Coin deleted successfully.');
        }
        $this->dispatch('close-delete-modal');
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.coin.c-list', [
            'coins' => Coin::when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('coins', 'like', '%'.$this->search.'%')
                        ->orWhere('price', 'like', '%'.$this->search.'%');
                });
            })
                ->orderBy('id', 'desc')
                ->paginate(10)->withPath(route('admin.coin.list')),
        ]);
    }
}
