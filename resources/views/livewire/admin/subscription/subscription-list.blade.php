<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col gap-2 mb-8 md:flex-row md:items-center md:justify-between">
        <div class="flex items-center gap-4">
            <div class="flex items-center justify-center w-12 h-12 bg-primary/10 rounded-2xl text-primary">
                <x-heroicon-o-building-office class="w-6 h-6" />
            </div>
            <div class="">
                <h1 class="text-3xl font-bold text-dark">Subscription <span class="text-primary">List</span></h1>
                <p class="text-dark/60">Review and manage Subscription list.</p>
            </div>
        </div>

        <div id="successdiv">
            @if (session()->has('success'))
                <x-alert :message="session()->get('success')" status="1"></x-alert>
            @endif
        </div>
    </div>

    <!-- Toolbar Section -->
    <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">
        <div class="relative flex-1 max-w-md">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-dark/40">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </div>
            <input type="text" wire:model.live="search" placeholder="Search by name, price or checkins..."
                class="w-full py-3 pr-4 transition-all border shadow-sm outline-none pl-11 bg-surface border-primary/10 rounded-2xl text-dark focus:border-primary focus:ring-1 focus:ring-primary" />
        </div>
        <!-- Add Button -->
        <a href="{{ route('admin.subscriptions.create') }}" wire:navigate
            class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white transition-all shadow-sm rounded-2xl bg-primary hover:bg-primary/90">
            <x-heroicon-o-plus class="w-5 h-5" />
            Add Subscription
        </a>
    </div>

    <!-- Responsive Table Section -->
    <div class="relative overflow-hidden border shadow-sm bg-surface rounded-3xl border-primary/10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-primary/5">
                    <tr class="text-xs tracking-wider uppercase text-dark/40">
                        <th class="px-6 py-4 font-semibold text-center">Name</th>
                        <th class="px-6 py-4 font-semibold text-center">Price</th>
                        <th class="px-6 py-4 font-semibold text-center">Days</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary/5">
                    @forelse ($subscriptions as $subscription)
                        <tr class="transition-colors hover:bg-primary/5 group">
                            <td class="px-6 py-4 text-sm text-center text-dark/70">{{ $subscription->name ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-center text-dark/70">${{ $subscription->price ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-center text-dark/70">
                                {{ $subscription->duration_days ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-3 py-1 text-xs font-medium border rounded-full text-primary bg-primary/10 border-primary/20">
                                    {{ $subscription->is_active ? 'Active' : 'In-active' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.subscriptions.edit', ['id' => $subscription->id]) }}"
                                        wire:navigate>
                                        <button
                                            class="p-2 text-sm font-medium transition-colors rounded-lg text-primary hover:bg-primary/10">
                                            <x-heroicon-o-pencil-square class="w-5 h-5" />
                                        </button>
                                    </a>
                                    <button type="button" onclick="openDeleteModal({{ $subscription->id }})"
                                        class="p-2 text-sm font-medium text-red-500 transition-colors rounded-lg cursor-pointer hover:bg-red-50">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div
                                        class="flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full text-dark/20">
                                        <x-heroicon-o-user-group class="w-8 h-8" />
                                    </div>
                                    <h3 class="text-lg font-bold text-dark">No Subscriptions Found</h3>
                                    <p class="text-dark/60">Search criteria returned no results.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $subscriptions->links() }}
    </div>

    <div wire:ignore>
        <x-delete-modal id="deleteModal" title="Delete Subscription"
            message="Are you sure you want to delete this Subscription?" confirmAction="delete"
            closeAction="closeDeleteModal" />
    </div>
    <script>
        function openDeleteModal(subscriptionIdToDelete) {
            // 1. Tell Livewire which coin is being deleted
            @this.set('subscriptionIdToDelete', subscriptionIdToDelete);

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
            @this.set('subscriptionIdToDelete', null);
        }

        window.addEventListener('close-delete-modal', event => {
            closeDeleteModal();
        });
    </script>
</div>
