<div class="space-y-8">
    <!-- Header -->
    <div class="space-y-8">
        <!-- Header Section -->
        <x-header-section headerwprimary="Subscription" headerwsecondary="Category"
            tagline="Organize and manage your subscription categories." />
    </div>
    <div id="successdiv">
        @if (session()->has('success'))
            <x-alert :message="session()->get('success')" status="1"></x-alert>
        @endif
        @if (session()->has('error'))
            <x-alert :message="session()->get('error')" status="0"></x-alert>
        @endif
    </div>


    <!-- Toolbar Section -->
    <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-center md:justify-between">
        <div class="relative flex-1 max-w-md">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-dark/40">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </div>
            <input type="text" wire:model.live="search" placeholder="Search categories..."
                class="w-full py-3 pr-4 transition-all border shadow-sm outline-none pl-11 bg-surface border-primary/10 rounded-2xl text-dark focus:border-primary focus:ring-1 focus:ring-primary" />
        </div>

        <button wire:click="openAddModal"
            class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white transition-all shadow-sm rounded-2xl bg-primary hover:bg-primary/90">
            <x-heroicon-o-plus class="w-5 h-5" />
            Add Subscription Category
        </button>
    </div>

    <!-- Table Section -->
    <div class="relative overflow-hidden border shadow-sm bg-surface rounded-3xl border-primary/10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-primary/5">
                    <tr class="text-xs tracking-wider uppercase text-dark/40">
                        <th class="px-6 py-4 font-semibold">Category Name</th>
                        <th class="px-6 py-4 font-semibold">Active</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary/5">
                    @forelse ($categories as $category)
                        <tr class="transition-colors hover:bg-primary/5 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary/10 text-primary">
                                        <x-heroicon-o-tag class="w-4 h-4" />
                                    </div>
                                    <span class="font-medium text-dark">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 text-xs font-medium border rounded-full text-primary bg-primary/10 border-primary/20">
                                    {{ $category->is_active ? 'Active' : 'In-active' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="openEditModal({{ $category->id }})"
                                        class="p-2 text-sm font-medium transition-colors rounded-lg text-primary hover:bg-primary/10">
                                        <x-heroicon-o-pencil-square class="w-5 h-5" />
                                    </button>

                                    <button type="button" wire:click="confirmDelete({{ $category->id }})"
                                        class="p-2 text-sm font-medium text-red-500 transition-colors rounded-lg cursor-pointer hover:bg-red-50">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div
                                        class="flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full text-dark/20">
                                        <x-heroicon-o-folder-open class="w-8 h-8" />
                                    </div>
                                    <h3 class="text-lg font-bold text-dark">No Categories Found</h3>
                                    <p class="text-dark/60">Start by adding a new category.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        {{ $categories->links() }}
    </div>

    <!-- Add Category Modal -->
    @if ($showAddModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center w-full h-full p-4 bg-dark/50 backdrop-blur-sm">
            <div class="w-full max-w-md p-6 border shadow-xl bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-dark">Add New Subscription Category</h3>
                    <button wire:click="closeModals" class="text-dark/40 hover:text-dark">
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </button>
                </div>


                <form wire:submit.prevent="saveCategory">
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-dark/60">
                            Subscription Category Name
                        </label>

                        <input type="text" wire:model="categoryName"
                            class="w-full px-4 py-3 border outline-none rounded-2xl bg-surface border-primary/10 text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="e.g. Luxury Hotels">

                        @error('categoryName')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-dark/60">
                            Status
                        </label>

                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="isActive" class="sr-only peer">

                            <div
                                class="relative w-11 h-6 bg-gray-200 rounded-full
                                            peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/30
                                            peer-checked:bg-primary
                                            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                            after:bg-white after:border-gray-300 after:border after:rounded-full
                                            after:h-5 after:w-5 after:transition-all
                                            peer-checked:after:translate-x-full peer-checked:after:border-white">
                            </div>

                            <span class="ml-3 text-sm font-medium text-dark">
                                Active
                            </span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="closeModals"
                            class="px-4 py-2 text-sm font-medium text-dark/60 hover:text-dark">Cancel</button>
                        <button type="submit"
                            class="px-6 py-2 text-sm font-bold text-white rounded-xl bg-primary hover:bg-primary/90">
                            <span wire.targert="saveCategory" wire:loading.remove>Save</span>
                            <span wire.targert="saveCategory" wire:loading wire:loading>Saving...</span>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Edit Category Modal -->
    @if ($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center w-full h-full p-4 bg-dark/50 backdrop-blur-sm">
            <div class="w-full max-w-md p-6 border shadow-xl bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-dark">Edit Subscription Category</h3>
                    <button wire:click="closeModals" class="text-dark/40 hover:text-dark">
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </button>
                </div>
                <form wire:submit.prevent="updateCategory">
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-dark/60">Subscription Category Name</label>
                        <input type="text" wire:model="categoryName"
                            class="w-full px-4 py-3 border outline-none rounded-2xl bg-surface border-primary/10 text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="Category Name">
                        @error('categoryName')
                            <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-dark/60">
                            Status
                        </label>

                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="isActive" class="sr-only peer">

                            <div
                                class="relative w-11 h-6 bg-gray-200 rounded-full
                                            peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/30
                                            peer-checked:bg-primary
                                            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                            after:bg-white after:border-gray-300 after:border after:rounded-full
                                            after:h-5 after:w-5 after:transition-all
                                            peer-checked:after:translate-x-full peer-checked:after:border-white">
                            </div>

                            <span class="ml-3 text-sm font-medium text-dark">
                                Active
                            </span>
                        </label>
                    </div>


                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="closeModals"
                            class="px-4 py-2 text-sm font-medium text-dark/60 hover:text-dark">Cancel</button>
                        <button type="submit"
                            class="px-6 py-2 text-sm font-bold text-white rounded-xl bg-primary hover:bg-primary/90">
                            <span wire.targert="updateCategory" wire:loading.remove>Update</span>
                            <span wire.targert="updateCategory" wire:loading>updating...</span>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- DELETE MODAL: Now consistent with Add/Edit -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center w-full h-full p-4 bg-dark/50 backdrop-blur-sm">
            <div class="relative w-full max-w-md p-6 border shadow-xl bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-dark">Confirm Deletion</h3>
                    <button type="button" wire:click="closeModals" class="text-dark/40 hover:text-dark">
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </button>
                </div>
                <div class="mb-6">
                    <p class="text-dark/60">Are you sure you want to delete this subscription category? This action
                        cannot be undone.</p>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" wire:click="closeModals"
                        class="px-4 py-2 text-sm font-medium text-dark/60 hover:text-dark">Cancel</button>

                    <button type="button" wire:click="deleteCategory" wire:loading.attr="disabled"
                        class="px-6 py-2 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 disabled:opacity-50">
                        <span wire:loading.remove wire:target="deleteCategory">Confirm Delete</span>
                        <span wire:loading wire:target="deleteCategory">Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
