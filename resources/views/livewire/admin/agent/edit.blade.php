<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="flex items-center justify-center w-12 h-12 bg-primary/10 rounded-2xl text-primary">
                <x-heroicon-o-pencil-square class="w-6 h-6" />
            </div>
            <div>
                <h1 class="text-3xl font-bold text-dark">Edit <span class="text-primary">Agent</span></h1>
                <p class="text-dark/60">Update agent credentials and wallet balance.</p>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="updateAgent" class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- LEFT: Basic Information -->
        <div class="space-y-6 lg:col-span-2">
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary/10 rounded-xl text-primary">
                        <x-heroicon-o-user class="w-6 h-6" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Personal Details</h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-medium text-dark/70">Full Name</label>
                        <input type="text" wire:model="name"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                        @error('name')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Email Address</label>
                        <input type="email" wire:model="email"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                        @error('email')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Password </label>
                        <input type="password" wire:model="password"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                        @error('password')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-medium text-dark/70">Update Profile Image (Optional)</label>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="flex flex-col items-center justify-center p-2 border rounded-xl bg-gray-50">
                                <span class="text-[10px] font-bold text-dark/40 uppercase mb-2">Current Image</span>
                                <img src="{{ asset('storage/' . $existing_image) }}"
                                    class="object-cover w-24 h-24 rounded-lg shadow-sm">
                            </div>
                            <div class="flex flex-col justify-center">
                                <input type="file" wire:model="profile_image"
                                    class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                @if ($profile_image)
                                    <div class="p-1 mt-2 bg-white border rounded-lg w-fit">
                                        <img src="{{ $profile_image->temporaryUrl() }}"
                                            class="object-cover w-16 h-16 rounded-md">
                                    </div>
                                @endif
                            </div>
                        </div>
                        @error('profile_image')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Account Settings -->
        <div class="space-y-6">
            <div class="sticky space-y-6 top-24">
                <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                    <h2 class="mb-6 text-lg font-bold text-dark">Account Settings</h2>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-dark/70">Wallet Balance</label>
                            <div class="relative">
                                <span class="absolute text-sm -translate-y-1/2 left-4 top-1/2 text-dark/40">Rs</span>
                                <input type="number" wire:model="wallet" step="0.01"
                                    class="w-full py-3 pl-8 pr-4 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                            </div>
                            @error('wallet')
                                <span class="block text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="flex items-center justify-between p-4 border bg-background rounded-2xl border-primary/10">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center w-8 h-8 text-red-600 bg-red-100 rounded-lg">
                                    <x-heroicon-o-no-symbol class="w-5 h-5" />
                                </div>
                                <div class="text-sm font-bold text-dark">Block Agent</div>
                            </div>
                            <input type="checkbox" wire:model="is_blocked"
                                class="w-5 h-5 rounded text-primary focus:ring-primary">
                        </div>
                    </div>
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="flex items-center justify-center w-full gap-2 py-4 font-bold text-white transition-all transform bg-gradient-to-r from-primary to-secondary rounded-2xl hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-1 disabled:opacity-70">
                    <span wire:loading.remove wire:target="updateAgent">Update Agent</span>
                    <span wire:loading wire:target="updateAgent">Updating...</span>
                </button>
            </div>
        </div>
    </form>
</div>
