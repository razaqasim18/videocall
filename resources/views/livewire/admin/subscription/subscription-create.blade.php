<div class="space-y-8">

    <!-- Header -->
    <div class="space-y-8">
        <!-- Header Section -->
        <x-header-section headerwprimary="Create" headerwsecondary="Subscription"
            tagline="Set up a new subscription plan for your facility." />
    </div>
    <div id="successdiv">
        @if (session()->has('success'))
            <x-alert :message="session()->get('success')" status="1"></x-alert>
        @endif
        @if (session()->has('error'))
            <x-alert :message="session()->get('error')" status="0"></x-alert>
        @endif
    </div>


    <!-- START FORM: Grid contains both columns -->
    <form wire:submit.prevent="saveSubscription" class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        <!-- LEFT COLUMN: Main Subscription Details -->
        <div class="space-y-6 lg:col-span-2">
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary/10 rounded-xl text-primary">
                        <x-heroicon-o-ticket class="w-6 h-6" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Plan Details</h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Subscription Name</label>
                        <input type="text" wire:model="name"
                            class="w-full px-4 py-3 transition-all border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="e.g. Gold Monthly Plan">
                        @error('name')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Price</label>
                        <div class="relative">
                            <span class="absolute text-sm -translate-y-1/2 left-4 top-1/2 text-dark/40">$</span>
                            <input type="number" wire:model="price"
                                class="w-full py-3 pl-8 pr-4 transition-all border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="0.00">
                        </div>
                        @error('price')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Days Input -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Validity Days</label>
                        <div class="relative">
                            <span class="absolute text-sm -translate-y-1/2 right-4 top-1/2 text-dark/40">Days</span>
                            <input type="number" wire:model="days"
                                class="w-full px-4 py-3 transition-all border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="e.g. 30">
                        </div>
                        @error('days')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>





                    <!-- Popular Toggle -->
                    <div class="flex items-end gap-3 pb-3">
                        <input type="checkbox" wire:model="is_feature" id="is_feature" value="1"
                            class="w-5 h-5 border-gray-300 rounded cursor-pointer text-primary focus:ring-primary">
                        <label for="is_feature" class="text-sm font-medium cursor-pointer text-dark/70">
                            Feature
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6 space-y-2">
                    <label class="block text-sm font-medium text-dark/70">Description</label>
                    <textarea wire:model="description" rows="4"
                        class="w-full px-4 py-3 transition-all border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                        placeholder="e.g. Mon, Wed, Fri, Sat"></textarea>
                    <p class="text-[11px] text-dark/40">Please separate each item or day with a comma for proper
                        formatting in the app.</p>
                    @error('description')
                        <span class="block text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>


            </div>
        </div>

        <!-- RIGHT COLUMN: Settings & Action -->
        <div class="space-y-6">
            <div class="sticky space-y-6 top-24">

                <!-- Status Card -->
                <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                    <h2 class="mb-6 text-lg font-bold text-dark">Configuration</h2>

                    <div class="space-y-6">
                        <!-- Active Status -->
                        <div
                            class="flex items-center justify-between p-4 transition-colors border bg-background rounded-2xl border-primary/10 group hover:border-primary/30">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center w-8 h-8 text-green-600 bg-green-100 rounded-lg">
                                    <x-heroicon-o-check-badge class="w-5 h-5" />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-dark">Active Plan</p>
                                    <p class="text-[11px] text-dark/40">Make this plan available</p>
                                </div>
                            </div>
                            <input type="checkbox" wire:model="is_active"
                                class="w-5 h-5 border-gray-300 rounded cursor-pointer text-primary focus:ring-primary">
                        </div>
                    </div>
                </div>

                <!-- Submit Action -->
                <div>
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex items-center justify-center w-full gap-2 py-4 font-bold text-white transition-all transform bg-gradient-to-r from-primary to-secondary rounded-2xl hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-1 disabled:opacity-70">

                        <span wire:loading.remove wire:target="saveSubscription">
                            Create Subscription
                        </span>

                        <span wire:loading wire:target="saveSubscription">
                            Saving Plan...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
