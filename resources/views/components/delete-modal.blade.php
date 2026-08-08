@props([
    'id' => 'deleteModal',
    'title' => 'Confirm Deletion',
    'message' => 'Are you sure you want to delete this item? This action cannot be undone.',
    'confirmAction' => 'delete',
    'closeAction' => 'closeModal',
])

<!-- Added 'hidden' class here -->
<div id="{{ $id }}"
    class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full p-4 bg-dark/50 backdrop-blur-sm">
    <div class="relative w-full max-w-md p-6 border shadow-xl bg-surface rounded-3xl border-primary/10">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-dark">{{ $title }}</h3>
            <!-- Updated to call JS close function -->
            <button type="button" onclick="closeDeleteModal()"
                class="cursor-pointer text-dark/40 hover:text-dark transition-colors">
                <x-heroicon-o-x-mark class="w-6 h-6" />
            </button>
        </div>

        <!-- Body -->
        <div class="mb-6">
            <p class="text-dark/60 leading-relaxed">{{ $message }}</p>
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeDeleteModal()"
                class="cursor-pointer px-4 py-2 text-sm font-medium text-dark/60 hover:text-dark transition-colors">
                Cancel
            </button>

            <button type="button" wire:click="{{ $confirmAction }}"
                class="px-6 py-2 cursor-pointer text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transition-all">
                <span wire:loading.remove wire:target="{{ $confirmAction }}">
                    Confirm Delete
                </span>
                <span wire:loading wire:target="{{ $confirmAction }}">
                    Deleting...
                </span>
            </button>
        </div>
    </div>
</div>
