<?php

namespace App\Livewire\Admin\Ticket;

use App\Models\Admin;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Chat extends Component
{
    public int $ticketId;

    public string $ticketmessage = ''; // This is the property name for Livewire

    public function mount(int $id)
    {
        $this->ticketId = $id;
    }

    public function sendReply()
    {
        $this->validate(['ticketmessage' => 'required']);

        // FIXED: Corrected the mapping between property and database column
        TicketReply::create([
            'ticket_id' => $this->ticketId,
            'senderable_type' => Admin::class,             // Use the morphMap string 'admin'
            'senderable_id' => Auth::guard('admin')->id(),
            'message' => $this->ticketmessage, // DB column is 'message', value is $this->ticketmessage
        ]);

        session()->flash('success', 'Ticket Replyed successfully!');
        $this->dispatch('clear-summernote');
        $this->dispatch('scroll-to-top'); // Custom event to scroll chat

    }

    public function render()
    {
        // Eager load replies and the creator (Partner) of the ticket
        $ticket = Ticket::with(['creator', 'replies' => function ($query) {
            $query->latest();
        }])->findOrFail($this->ticketId);

        return view('livewire.admin.ticket.chat', compact('ticket'));
    }
}
