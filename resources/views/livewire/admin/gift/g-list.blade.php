<div class="space-y-8">
    <!-- Header Section -->
    <div class="space-y-8">
        <x-header-section headerwprimary="Gift" headerwsecondary="List"
            tagline="Review and manage your virtual gifts, animations, and coin pricing." />
    </div>

    <!-- Toolbar Section -->
    <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">
        <div class="relative w-full max-w-md group">
            <div
                class="absolute inset-y-0 left-0 flex items-center pl-4 transition-colors pointer-events-none text-dark/40 group-focus-within:text-primary">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </div>
            <input type="text" wire:model.live="search" placeholder="Search gifts by name..."
                class="w-full py-3 pr-4 transition-all border shadow-sm outline-none pl-11 bg-surface border-primary/10 rounded-2xl text-dark focus:border-primary focus:ring-4 focus:ring-primary/10 placeholder:text-dark/30" />
        </div>
        <div id="successdiv" class="flex-shrink-0">
            @if (session()->has('success'))
                <x-alert :message="session()->get('success')" status="1"></x-alert>
            @endif
            @if (session()->has('error'))
                <x-alert :message="session()->get('error')" status="0"></x-alert>
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
                        <th class="px-6 py-4 font-semibold">Preview</th>
                        <th class="px-6 py-4 font-semibold">Gift Name</th>
                        <th class="px-6 py-4 font-semibold">Price (Coins)</th>
                        <th class="px-6 py-4 font-semibold">Type/Source</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary/5">
                    @forelse ($gifts as $gift)
                        <tr class="transition-all hover:bg-primary/[0.03] group">
                            <!-- Animation Preview -->
                            <td class="px-6 py-4">
                                <div
                                    class="relative w-12 h-12 overflow-hidden border rounded-xl border-primary/10 bg-background">
                                    @if ($gift->animation_type === 'gif')
                                        {{-- GIF: Use CDN if available, otherwise use local storage --}}
                                        <img src="{{ !empty($gift->cdn_url) ? $gift->cdn_url : asset('storage/' . $gift->animation_path) }}"
                                            class="object-cover w-full h-full" alt="Gift GIF"
                                            onerror="this.src='{{ asset('images/placeholder-gift.png') }}'">
                                    @elseif($gift->animation_type === 'lottie')
                                        {{-- Lottie: Icon based on CDN availability --}}
                                        <div
                                            class="flex items-center justify-center h-full {{ !empty($gift->cdn_url) ? 'bg-green-50 text-green-500' : 'bg-indigo-50 text-indigo-500' }}">
                                            @if (!empty($gift->cdn_url))
                                                <x-heroicon-o-cloud class="w-6 h-6" />
                                            @else
                                                <x-heroicon-o-document-text class="w-6 h-6" />
                                            @endif
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400 bg-gray-50">
                                            <x-heroicon-o-gift class="w-6 h-6" />
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Gift Name -->
                            <td class="px-6 py-4">
                                <span class="font-bold transition-colors text-dark group-hover:text-primary">
                                    {{ $gift->name }}
                                </span>
                            </td>

                            <!-- Coins Price -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-sm font-medium text-dark/70">
                                    <span
                                        class="w-5 h-5 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600 text-[10px] font-bold">C</span>
                                    {{ number_format($gift->coins) }}
                                </div>
                            </td>

                            <!-- Type and Source (Smart Text) -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs font-bold uppercase text-dark/60">
                                        {{ $gift->animation_type }}
                                    </span>
                                    <span
                                        class="text-[10px] px-2 py-0.5 w-fit rounded-md {{ !empty($gift->cdn_url) ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-primary/10 text-primary border border-primary/20' }}">
                                        {{ !empty($gift->cdn_url) ? 'CDN' : 'Local' }}
                                    </span>
                                </div>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $gift->is_active ? 'text-green-700 bg-green-100/50 border border-green-200' : 'text-red-700 bg-red-100/50 border border-red-200' }}">
                                    {{ $gift->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.gift.edit', ['id' => $gift->id]) }}" wire:navigate
                                        class="p-2 transition-all rounded-lg text-primary bg-primary/10 hover:bg-primary hover:text-white group/btn"
                                        title="Edit Gift">
                                        <x-heroicon-s-pencil-square class="w-4 h-4" />
                                    </a>
                                    <button onclick="openDeleteModal({{ $gift->id }})"
                                        class="p-2 text-red-500 transition-all rounded-lg cursor-pointer bg-red-100/50 hover:bg-red-500 hover:text-white group/btn"
                                        title="Delete Gift">
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
                                        <x-heroicon-o-gift class="w-10 h-10" />
                                    </div>
                                    <h3 class="text-lg font-bold text-dark">No Gifts Found</h3>
                                    <p class="max-w-xs mx-auto text-dark/50">No results found matching your criteria.
                                    </p>
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
        {{ $gifts->links() }}
    </div>

    <!-- Delete Modal -->
    <div wire:ignore>
        <x-delete-modal id="deleteModal" title="Delete Gift"
            message="Are you sure you want to delete this virtual gift? This action cannot be undone."
            confirmAction="delete" closeAction="closeDeleteModal" />
    </div>

    <script>
        function openDeleteModal(giftId) {
            @this.set('giftIdToDelete', giftId);
            const modal = document.getElementById('deleteModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) modal.classList.add('hidden');
            @this.set('giftIdToDelete', null);
        }
        window.addEventListener('close-delete-modal', event => {
            closeDeleteModal();
        });
    </script>
</div>
