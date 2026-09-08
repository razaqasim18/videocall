<div class="space-y-8">
    <!-- Header Section -->
    <div class="space-y-8">
        <x-header-section headerwprimary="Edit" headerwsecondary="Agent"
            tagline="Update agent credentials, wallet balance, and account status." />
    </div>

    <!-- Alerts -->
    <div id="successdiv">
        @if (session()->has('success'))
            <x-alert :message="session()->get('success')" status="1"></x-alert>
        @endif
        @if (session()->has('error'))
            <x-alert :message="session()->get('error')" status="0"></x-alert>
        @endif
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
                    <!-- Full Name -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-medium text-dark/70">Full Name</label>
                        <input type="text" wire:model="name"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                        @error('name')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Email Address</label>
                        <input type="email" wire:model="email"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                        @error('email')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">New Password</label>
                        <input type="password" wire:model="password"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="Leave blank to keep current">
                        @error('password')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Profile Image Update Section -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-medium text-dark/70">Profile Image</label>

                        <div
                            class="grid grid-cols-1 gap-6 p-6 border bg-background rounded-2xl border-primary/10 sm:grid-cols-2">
                            <!-- Current Image -->
                            <div class="flex flex-col items-center gap-3">
                                <span class="text-[10px] font-bold text-dark/40 uppercase tracking-wider">Current
                                    Image</span>
                                <div class="relative group">
                                    <div class="w-24 h-24 overflow-hidden border-2 rounded-full border-primary/20">
                                        <img src="{{ asset('storage/' . $existing_image) }}"
                                            class="object-cover w-full h-full"
                                            onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                    </div>
                                </div>
                            </div>

                            <!-- New Image Upload -->
                            <div class="flex flex-col gap-3">
                                <span class="text-[10px] font-bold text-dark/40 uppercase tracking-wider">Change
                                    Image</span>
                                <div
                                    class="relative flex flex-col items-center justify-center p-4 text-center transition border-2 border-dashed bg-surface rounded-2xl border-primary/20 hover:border-primary/50 group">
                                    <x-heroicon-o-camera
                                        class="w-6 h-6 mb-1 transition-transform text-primary group-hover:scale-110" />
                                    <p class="text-xs font-semibold text-dark">Upload New Photo</p>
                                    <input type="file" wire:model="profile_image"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                </div>

                                <!-- Temporary Preview -->
                                @if ($profile_image)
                                    <div
                                        class="flex items-center gap-2 p-2 bg-white border rounded-xl w-fit animate-pulse">
                                        <img src="{{ $profile_image->temporaryUrl() }}"
                                            class="object-cover w-8 h-8 rounded-full">
                                        <span class="text-xs font-medium text-primary">New image selected</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @error('profile_image')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                        <div wire:loading wire:target="profile_image" class="text-xs text-primary">Uploading image...
                        </div>
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
                        <!-- Wallet Balance -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-dark/70">Wallet Balance</label>

                            <input type="number" wire:model="wallet" step="0.01"
                                class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">

                            @error('wallet')
                                <span class="block text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Block Agent Toggle -->
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

                <!-- Action Button -->
                <button type="submit" wire:loading.attr="disabled"
                    class="flex items-center justify-center w-full gap-2 py-4 font-bold text-white transition-all transform bg-gradient-to-r from-primary to-secondary rounded-2xl hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-1 disabled:opacity-70">
                    <span wire:loading.remove wire:target="updateAgent">Update Agent</span>
                    <span wire:loading wire:target="updateAgent">Updating...</span>
                </button>
            </div>
        </div>
    </form>
</div>
