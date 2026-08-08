<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-dark">Profile <span class="text-primary">Settings</span></h1>
            <p class="text-dark/60">Update your personal information and facility profile.</p>
        </div>

        <div id="successdiv">
            @if (session()->has('success'))
                <x-alert :message="session()->get('success')" status="1"></x-alert>
            @endif

            @if (session()->has('error'))
                <x-alert :message="session()->get('error')" status="0"></x-alert>
            @endif
        </div>
    </div>

    <form wire:submit.prevent="save" class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        <!-- LEFT COLUMN: Account Details -->
        <div class="space-y-6 lg:col-span-2">

            <!-- Section 1: Personal & Facility Info -->
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary/10 rounded-xl text-primary">
                        <x-heroicon-o-user-circle class="w-6 h-6" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Account Information</h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <!-- Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Full Name</label>
                        <input type="text" wire:model="name"
                            class="w-full px-4 py-3 transition-all border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="Enter your full name">
                        @error('name')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email (DISABLED) -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/40">Email Address</label>
                        <div class="relative">
                            <input type="email" wire:model="email" disabled
                                class="w-full px-4 py-3 font-medium border outline-none cursor-not-allowed bg-gray-100/50 border-primary/5 rounded-xl text-dark/40"
                                value="{{ $email }}">
                            <div class="absolute -translate-y-1/2 right-3 top-1/2 text-dark/20">
                                <x-heroicon-o-lock-closed class="w-4 h-4" />
                            </div>
                        </div>
                        <p class="text-[11px] text-dark/40">Email cannot be changed for security reasons.</p>
                    </div>

                </div>


            </div>

            <!-- Section 2: Security Update -->

            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center justify-center w-10 h-10 text-orange-500 bg-orange-50 rounded-xl">
                        <x-heroicon-o-shield-check class="w-6 h-6" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Security</h2>
                </div>


                <div class="space-y-4 max-w-ful">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-dark/70">New Password</label>
                        <input type="password" wire:model="password"
                            class="w-full px-4 py-3 transition-all border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="••••••••">
                        <p class="mt-2 text-xs text-dark/40">Leave this field blank if you don't want to change your
                            password.</p>
                        @error('password')
                            <span class="block mt-1 text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

        </div>

        <!-- RIGHT COLUMN: Profile Image & Action -->
        <div class="space-y-6">

            <!-- Profile Image Card -->
            <div class="sticky top-24">

                <div class="p-8 mb-4 text-center border shadow-sm bg-surface rounded-3xl border-primary/10">
                    <h2 class="mb-6 text-lg font-bold text-dark">Profile Picture</h2>

                    <div class="relative inline-block group">
                        <!-- Image Container -->
                        <div
                            class="relative w-32 h-32 mx-auto overflow-hidden border-4 border-white rounded-full shadow-lg ring-4 ring-primary/10">
                            @if ($temprofile && is_object($temprofile))
                                <img src="{{ $temprofile->temporaryUrl() }}" class="object-cover w-full h-full">
                            @elseif ($profile)
                                <img src="{{ asset('/storage/' . $profile) }}" class="object-cover w-full h-full">
                            @else
                                <img src="{{ asset('images/user-avatar.png') }}" class="object-cover w-full h-full">
                            @endif

                            <!-- Hover Overlay -->
                            <div
                                class="absolute inset-0 flex items-center justify-center transition-opacity opacity-0 cursor-pointer bg-black/20 group-hover:opacity-100">
                                <x-heroicon-o-camera class="w-8 h-8 text-white" />
                            </div>
                        </div>

                        <!-- Upload Button -->
                        <label
                            class="absolute bottom-0 right-0 p-2 text-white transition-all border-2 border-white rounded-full shadow-lg cursor-pointer bg-primary hover:bg-primary/90 group-hover:scale-110">
                            <x-heroicon-o-arrow-up-on-square-stack class="w-5 h-5" />
                            <input type="file" accept="image/*" wire:model="temprofile" class="hidden">
                        </label>
                    </div>
                    <div wire:loading wire:target="temprofile" class="mt-4 text-center">
                        <p class="text-xs font-medium text-primary animate-pulse">Uploading images, please wait...</p>
                    </div>
                    <div class="mt-6 space-y-1">
                        @error('temprofile')
                            <p class="text-sm text-danger">{{ $message }}</p>
                        @enderror
                        <p class="text-sm font-medium text-dark">Upload Photo</p>
                        <p class="text-[11px] text-dark/40">JPG, PNG or GIF. Max 2MB.</p>
                    </div>

                    @error('profile')
                        <span class="block mt-2 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Save Action -->
                <div class="p-2">
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex items-center justify-center w-full gap-2 py-4 font-bold text-white transition-all transform bg-gradient-to-r from-primary to-secondary rounded-2xl hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-1 disabled:opacity-70">

                        <span wire:loading.remove wire:target="save">
                            Update Profile
                        </span>

                        <span wire:loading wire:target="save">
                            Updating...
                        </span>
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>
