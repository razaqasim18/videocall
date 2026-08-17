<div>

    <div class="space-y-8">
        <!-- Header Section -->
        <x-header-section headerwprimary="Coin" headerwsecondary="List"
            tagline="Review and manage your coin efficiently." />
    </div>

    <!-- Toolbar Section -->
    <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">
        <div class="relative w-full max-w-md group">
            <div
                class="absolute inset-y-0 left-0 flex items-center pl-4 transition-colors pointer-events-none text-dark/40 group-focus-within:text-primary">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </div>
            <input type="text" wire:model.live="search" placeholder="Search by name..."
                class="w-full py-3 pr-4 transition-all border shadow-sm outline-none pl-11 bg-surface border-primary/10 rounded-2xl text-dark focus:border-primary focus:ring-4 focus:ring-primary/10 placeholder:text-dark/30" />
        </div>
        <div id="successdiv" class="flex-shrink-0">
            @if (session()->has('success'))
                <x-alert :message="session()->get('success')" status="1"></x-alert>
            @endif
        </div>
    </div>

    <!-- Responsive Table Section -->
    <div class="relative overflow-hidden border shadow-sm bg-surface rounded-3xl border-primary/10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="text-xs tracking-wider uppercase text-dark/40 bg-primary/[0.02] border-b border-primary/10">
                        <th class="px-6 py-4 font-semibold">Name</th>
                        <th class="px-6 py-4 font-semibold">Coins</th>
                        <th class="px-6 py-4 font-semibold">Price</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary/5">
                    @forelse ($coins as $coin)
                        <tr class="transition-all hover:bg-primary/[0.03] group">
                            <td class="px-6 py-4">
                                {{ $coin->name }}
                            </td>

                            <!-- Coins -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-sm font-medium text-dark/70">
                                    <span
                                        class="w-5 h-5 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600 text-[10px] font-bold">C</span>
                                    {{ number_format($coin->coins) }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                ${{ $coin->price }}
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $coin->is_active ? 'text-indigo-700 bg-indigo-100/50 border border-indigo-200' : 'text-red-700 bg-red-100/50 border border-red-200' }}">
                                    {{ $coin->is_active ? 'Active' : 'In-active' }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.coin.edit', ['id' => $coin->id]) }}" wire:navigate
                                        class="p-2 transition-all rounded-lg text-primary bg-primary/10 hover:bg-primary hover:text-white group/btn"
                                        title="View Details">
                                        <x-heroicon-s-pencil-square class="w-4 h-4" />
                                    </a>

                                    <!-- Table row loop -->
                                    <button onclick="openDeleteModal({{ $coin->id }})"
                                        class="p-2 text-red-500 transition-all rounded-lg cursor-pointer bg-red-100/50 hover:bg-red-500 hover:text-white group/btn">
                                        <x-heroicon-o-trash class="w-4 h-4" />
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div
                                        class="flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 text-dark/10">
                                        <x-heroicon-o-user-group class="w-10 h-10" />
                                    </div>
                                    <h3 class="text-lg font-bold text-dark">No Coins Found</h3>
                                    <p class="max-w-xs mx-auto text-dark/50">We couldn't find any cpins matching your
                                        search
                                        criteria.</p>
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
        {{ $coins->links() }}
    </div>

    <div wire:ignore>
        <x-delete-modal id="deleteModal" title="Delete Coin" message="Are you sure you want to delete this coin?"
            confirmAction="delete" closeAction="closeDeleteModal" />
    </div>

    <script>
        function openDeleteModal(coinId) {
            // 1. Tell Livewire which coin is being deleted
            @this.set('coinIdToDelete', coinId);

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
            @this.set('coinIdToDelete', null);
        }

        window.addEventListener('close-delete-modal', event => {
            closeDeleteModal();
        });
    </script>


</div>
