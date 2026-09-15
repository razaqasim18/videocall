<div class="pb-12 mx-auto space-y-8 max-w-7xl">

    <!-- Header --> 
    <div class="relative">
        <x-header-section headerwprimary="Create Agent" headerwsecondary="Subscription"
            tagline="Set up a new agent subscription plan for your facility." />
    </div>
 
    <!-- Alerts Section -->
    <div id="successdiv" class="max-w-3xl mx-auto">
        @if (session()->has('success'))
            <x-alert :message="session()->get('success')" status="1"></x-alert>
        @endif
        @if (session()->has('error'))
            <x-alert :message="session()->get('error')" status="0"></x-alert>
        @endif
    </div>

    <!-- START FORM -->
    <form wire:submit.prevent="saveSubscription" class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        <!-- LEFT COLUMN: Main Subscription Details -->
        <div class="space-y-6 lg:col-span-2">
            <div class="p-1 border shadow-sm bg-white rounded-[2rem] border-gray-100">
                <!-- Inner Card Padding -->
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div
                            class="flex items-center justify-center w-12 h-12 shadow-sm bg-primary/10 rounded-2xl text-primary">
                            <x-heroicon-o-ticket class="w-6 h-6" />
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-dark">Plan Details</h2>
                            <p class="text-sm text-dark/50">Define the core attributes of this subscription</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-6 md:grid-cols-1">

                        <!-- Name -->
                        <div class="space-y-2">
                            <label class="block ml-1 text-sm font-semibold text-dark/70">Subscription Name</label>
                            <input type="text" wire:model="name"
                                class="w-full px-4 py-3 transition-all border border-gray-200 outline-none bg-gray-50 rounded-2xl text-dark focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10"
                                placeholder="e.g. Gold Monthly Plan">
                            @error('name')
                                <span class="block ml-1 text-xs font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="space-y-2">
                            <label class="block ml-1 text-sm font-semibold text-dark/70">Price ($)</label>
                            <div class="relative">

                                <input type="number" step="0.01" wire:model="price"
                                    class="w-full py-3 pl-3 pr-4 transition-all border border-gray-200 outline-none bg-gray-50 rounded-2xl text-dark focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10"
                                    placeholder="0.00">
                            </div>
                            @error('price')
                                <span class="block ml-1 text-xs font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Coins Input -->
                        <div class="space-y-2">
                            <label class="block ml-1 text-sm font-semibold text-dark/70">Coins</label>
                            <div class="relative">
                                <input type="number" wire:model="coins"
                                    class="w-full px-4 py-3 transition-all border border-gray-200 outline-none bg-gray-50 rounded-2xl text-dark focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10"
                                    placeholder="e.g. 30">
                                <div class="absolute inset-y-0 flex items-center text-gray-400 right-4">
                                    <span class="text-sm font-medium">Coins</span>
                                </div>
                            </div>
                            @error('coins')
                                <span class="block ml-1 text-xs font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-8 space-y-2">
                        <label class="block ml-1 text-sm font-semibold text-dark/70">Plan Description</label>
                        <textarea wire:model="description" rows="4"
                            class="w-full px-4 py-3 transition-all border border-gray-200 outline-none bg-gray-50 rounded-2xl text-dark focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10"
                            placeholder="Describe what's included in this plan..."></textarea>
                        <div class="flex items-center gap-2 px-1 text-dark/40">
                            <x-heroicon-o-information-circle class="w-4 h-4" />
                            <p class="text-[11px]">Separate items with commas for better app formatting.</p>
                        </div>
                        @error('description')
                            <span class="block ml-1 text-xs font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Settings & Action -->
        <div class="space-y-6">
            <div class="sticky space-y-6 top-24">

                <!-- Configuration Card -->
                <div class="p-8 border shadow-sm bg-white rounded-[2rem] border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-dark/5 text-dark">
                            <x-heroicon-o-cog class="w-5 h-5" />
                        </div>
                        <h2 class="text-lg font-bold text-dark">Configuration</h2>
                    </div>

                    <div class="space-y-4">
                        <!-- Active Status Toggle -->
                        <div
                            class="flex items-center justify-between p-4 transition-all border border-gray-100 bg-gray-50 rounded-2xl hover:bg-white hover:border-primary/20 group">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center text-green-600 transition-transform bg-green-100 w-9 h-9 rounded-xl group-hover:scale-110">
                                    <x-heroicon-o-check-badge class="w-5 h-5" />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-dark">Active Plan</p>
                                    <p class="text-[11px] text-dark/50">Available for agents</p>
                                </div>
                            </div>
                            <!-- Custom Toggle Switch -->
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="is_active" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                </div>
                            </label>
                        </div>

                    </div>
                </div>

                <!-- Submit Action -->
                <div class="px-2">
                    <button type="submit" wire:loading.attr="disabled"
                        class="group relative flex items-center justify-center w-full gap-3 py-4 font-bold text-white transition-all transform bg-gradient-to-r from-primary to-secondary rounded-2xl hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-1 active:scale-[0.98] disabled:opacity-70">

                        <span wire:loading.remove wire:target="saveSubscription" class="flex items-center gap-2">
                            Create Subscription
                            <x-heroicon-o-arrow-right class="w-5 h-5 transition-transform group-hover:translate-x-1" />
                        </span>

                        <span wire:loading wire:target="saveSubscription" class="flex items-center gap-2">
                            Saving Plan...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
