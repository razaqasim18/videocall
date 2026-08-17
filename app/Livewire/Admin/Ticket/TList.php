<?php

namespace App\Livewire\Admin\Ticket;

use App\Models\Ticket;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class TList extends Component
{
    use WithPagination;

    public $search = '';

    public $statusFilter = '';

    public $ticketIdToDelete = null; // To store the ID of the ticket being deleted

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

    // --- NEW: Change Ticket Status ---
    public function updateStatus($id, $status)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update(['status' => $status]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Ticket status updated successfully!',
        ]);
    }

    public function delete()
    {
        if ($this->ticketIdToDelete) {
            Ticket::findOrFail($this->ticketIdToDelete)->delete();
            $this->ticketIdToDelete = null;
            session()->flash('success', 'Ticket deleted successfully.');
        }
        $this->dispatch('close-delete-modal');
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        // Eager load 'creator' to prevent N+1 query issues
        $query = Ticket::with('creator')
            ->withCount('replies')
            ->latest();

        if ($this->search) {
            $query->where('subject', 'like', '%'.$this->search.'%');
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.admin.ticket.list', [
            'tickets' => $query->paginate(10)->withPath(route('admin.ticket.list')),
        ]);
    }

    public function paginationView()
    {
        return 'vendor.pagination.tailwind';
    }
}
