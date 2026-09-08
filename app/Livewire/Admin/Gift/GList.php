<?php

namespace App\Livewire\Admin\Gift;

use App\Models\Gift;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class GList extends Component
{
    use WithPagination;

    public $search = '';

    public int $giftIdToDelete;

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
        $gift = Gift::find($this->giftIdToDelete);
        if ($gift) {
            $gift->delete();
            session()->flash('success', 'Gift deleted successfully.');
        }
        $this->dispatch('close-delete-modal');
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.gift.g-list', [
            'gifts' => Gift::when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
                ->orderBy('id', 'desc')
                ->paginate(10)->withPath(route('admin.gift.list')),
        ]);
    }
}
