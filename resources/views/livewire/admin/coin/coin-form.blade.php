<div>
    <div class="space-y-8">
        <!-- Header Section -->
        <x-header-section :headerwprimary="$isEdit ? 'Edit' : 'Create'" headerwsecondary="Coin"
            tagline="Manage the coin denominations and pricing for your platform." />
    </div>
    <div id="successdiv">
        @if (session()->has('success'))
            <x-alert :message="session()->get('success')" status="1"></x-alert>
        @endif
        @if (session()->has('error'))
            <x-alert :message="session()->get('error')" status="0"></x-alert>
        @endif
    </div>
    <form wire:submit.prevent="saveCoin" class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- LEFT: Package Details -->
        <div class="space-y-6 lg:col-span-2">
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary/10 rounded-xl text-primary">
                        <x-heroicon-o-cog class="w-6 h-6" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Package Details</h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-medium text-dark/70">Package Name</label>
                        <input type="text" wire:model="name"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="e.g. Starter Pack, Gold Pack">
                        @error('name')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Coin Amount</label>
                        <input type="number" wire:model="coins"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="100">
                        @error('coins')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Price ($)</label>
                        <input type="number" step="1" wire:model="price"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="0.00">
                        @error('price')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Package Status -->
        <div class="space-y-6">
            <div class="sticky space-y-6 top-24">
                <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                    <h2 class="mb-6 text-lg font-bold text-dark">Configuration</h2>

                    <div class="space-y-6">
                        <div
                            class="flex items-center justify-between p-4 border bg-background rounded-2xl border-primary/10">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center w-8 h-8 text-green-600 bg-green-100 rounded-lg">
                                    <x-heroicon-o-check-circle class="w-5 h-5" />
                                </div>
                                <div class="text-sm font-bold text-dark">Active Package</div>
                            </div>
                            <input type="checkbox" wire:model="is_active"
                                class="w-5 h-5 rounded text-primary focus:ring-primary">
                        </div>
                    </div>
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="flex items-center justify-center w-full gap-2 py-4 font-bold text-white transition-all transform bg-gradient-to-r from-primary to-secondary rounded-2xl hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-1 disabled:opacity-70">
                    <span wire:loading.remove wire:target="saveCoin">{{ $isEdit ? 'Update' : 'Create' }} Coin</span>
                    <span wire:loading wire:target="saveCoin">Processing...</span>
                </button>
            </div>
        </div>
    </form>
</div>
