<div class="min-h-screen p-4 md:p-8 bg-slate-50">
    <div class="mx-auto space-y-8 max-w-7xl">



        <div class="space-y-8">
            <!-- Header Section -->
            <x-header-section headerwprimary="Admin" headerwsecondary="Tickets"
                tagline="Review and manage your facility user base efficiently." />
        </div>

        <!-- FILTERS CONTAINER -->
        <div class="mb-6 space-y-6">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center p-2 bg-primary/10 rounded-xl text-primary">
                    <x-heroicon-o-funnel class="w-5 h-5" />
                </div>
                <h2 class="text-xl font-bold text-dark">Filter Tickets</h2>
            </div>

            <div
                class="grid grid-cols-1 gap-4 p-4 bg-white border shadow-sm sm:grid-cols-2 lg:grid-cols-3 rounded-2xl border-primary/5">
                <!-- Search -->
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] uppercase font-bold text-dark/40 ml-1">Search Subject</label>
                    <div class="relative">
                        <x-heroicon-o-magnifying-glass
                            class="absolute w-4 h-4 -translate-y-1/2 left-3 top-1/2 text-slate-400" />
                        <input type="text" wire:model.live="search"
                            class="w-full py-2 pl-10 pr-3 text-sm border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="Search tickets...">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] uppercase font-bold text-dark/40 ml-1">Filter by Status</label>
                    <select wire:model.live="statusFilter"
                        class="w-full px-3 py-2 text-sm border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                        <option value="">All Statuses</option>
                        <option value="open">Open</option>
                        <option value="pending">Pending</option>
                        <option value="resolved">Resolved</option> <!-- Added -->
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <!-- Reset Button -->
                <div class="flex items-end">
                    <button wire:click="resetMe"
                        class="w-full bg-slate-200 text-slate-600 px-4 py-2 rounded-xl text-sm font-bold hover:bg-slate-300 transition-all h-[38px]">
                        Reset View
                    </button>
                </div>
            </div>

            <!-- TICKET TABLE -->
            <div class="overflow-hidden bg-white border shadow-sm rounded-3xl border-primary/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="text-xs font-bold uppercase bg-slate-50 text-dark/40">
                            <tr class="text-center">
                                <th class="px-6 py-4">Ticket ID</th>
                                <th class="px-6 py-4 text-left">Partner</th>
                                <th class="px-6 py-4 text-left">Subject</th>
                                <th class="px-6 py-4">Priority</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Replies</th>
                                <th class="px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-dark divide-primary/5">
                            @forelse ($tickets as $ticket)
                                <tr class="text-center transition-colors hover:bg-primary/5">
                                    <td class="px-6 py-4 font-medium text-slate-500">#{{ $ticket->ticket_no }}</td>
                                    <td class="px-6 py-4 font-bold text-left text-dark">
                                        {{ $ticket->creator->name ?? 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-left text-dark">{{ $ticket->subject }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 text-[10px] font-bold rounded-full uppercase
                                            {{ $ticket->priority == 'high' ? 'bg-red-100 text-red-600' : ($ticket->priority == 'medium' ? 'bg-blue-100 text-blue-600' : 'bg-slate-100 text-slate-600') }}">
                                            {{ $ticket->priority }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <!-- STATUS CHANGE DROPDOWN -->
                                        <select wire:change="updateStatus({{ $ticket->id }}, $event.target.value)"
                                            class="text-[10px] font-bold uppercase px-2 py-1 rounded-full border-none outline-none cursor-pointer
                                            {{ $ticket->status == 'open'
                                                ? 'bg-emerald-100 text-emerald-600'
                                                : ($ticket->status == 'pending'
                                                    ? 'bg-amber-100 text-amber-600'
                                                    : ($ticket->status == 'resolved'
                                                        ? 'bg-indigo-100 text-indigo-600'
                                                        : 'bg-slate-100 text-slate-400')) }}">
                                            <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>
                                                Open</option>
                                            <option value="pending"
                                                {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="resolved"
                                                {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                            <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>
                                                Closed</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $ticket->replies_count }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.ticket.reply', ['id' => $ticket->id]) }}"
                                                class="inline-flex items-center justify-center p-2 text-xs font-bold transition-all bg-primary/10 text-primary rounded-xl hover:bg-primary hover:text-white"
                                                title="View Conversation">
                                                <x-heroicon-o-chat-bubble-left-right class="w-4 h-4" />
                                            </a>

                                            <button onclick="openDeleteModal({{ $ticket->id }})"
                                                class="inline-flex items-center justify-center p-2 text-xs font-bold text-red-600 transition-all cursor-pointer bg-red-50 rounded-xl hover:bg-red-600 hover:text-white"
                                                title="Delete Ticket">
                                                <x-heroicon-o-trash class="w-4 h-4" />
                                            </button>
                                        </div </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 italic text-center text-slate-400">No support
                                        tickets found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6 border-t border-primary/5">
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore>
        <x-delete-modal id="deleteModal" title="Delete User" message="Are you sure you want to delete this user?"
            confirmAction="delete" closeAction="closeDeleteModal" />
    </div>

    <script>
        function openDeleteModal(ticketIdToDelete) {
            // 1. Tell Livewire which user is being deleted
            @this.set('ticketIdToDelete', ticketIdToDelete);

            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeDeleteModal() {
            // Hide the modal by adding the 'hidden' class back
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.classList.add('hidden');
            }
            @this.set('ticketIdToDelete', null);
        }

        window.addEventListener('close-delete-modal', event => {
            closeDeleteModal();
        });
    </script>
</div>
