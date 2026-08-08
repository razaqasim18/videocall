<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="flex flex-col">
                <h1 class="text-3xl font-bold text-dark">User <span class="text-primary">Review</span></h1>
                <p class="text-dark/60">Comprehensive management of user account and system attributes.</p>
            </div>
        </div>
        <div id="successdiv">
            @if (session()->has('success'))
                <x-alert :message="session()->get('success')" status="1"></x-alert>
            @endif
        </div>
    </div>

    <form wire:submit.prevent="saveAdminSettings" class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- LEFT COLUMN: INFORMATION -->
        <div class="space-y-6 lg:col-span-2">

            <!-- CARD 1: Personal & Basic Details -->
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary/10 rounded-xl text-primary">
                        <x-heroicon-c-user class="w-5 h-5" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Personal Profile</h2>
                </div>

                <div class="flex flex-col items-center gap-8 md:flex-row">
                    <div class="text-center shrink-0">
                        <div
                            class="relative overflow-hidden border-4 border-white rounded-full shadow-md w-44 h-44 ring-4 ring-primary/10">
                            @if ($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}"
                                    class="object-cover w-full h-full">
                            @else
                                <img src="{{ asset('images/user-avatar.png') }}" class="object-cover w-full h-full">
                            @endif

                            <!-- Online Status Indicator -->
                            <div class="absolute bottom-2 right-2">
                                <span class="flex w-4 h-4">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $user->is_online ? 'bg-green-400' : 'bg-gray-400' }} opacity-75"></span>
                                    <span
                                        class="relative inline-flex rounded-full h-4 w-4 {{ $user->is_online ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                                </span>
                            </div>
                        </div>

                        <!-- Account Status Badges (Blocked/Active) -->
                        <span
                            class="inline-block px-3 py-1 mt-3 text-[10px] font-bold uppercase rounded-full {{ $user->is_blocked ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                            {{ $user->is_blocked ? 'Blocked Account' : 'Active Account' }}
                        </span>
                    </div>

                    <div class="w-full">
                        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2">

                            <!-- Name with Verification Badge -->
                            <div class="flex flex-col">
                                <label class="block mb-1 text-xs font-medium uppercase text-dark/40">Full Name</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-lg font-medium text-dark">{{ $user->name }}</p>

                                    @if ($user->is_verified)
                                        <span title="Verified User"
                                            class="flex items-center justify-center w-5 h-5 text-white bg-blue-500 rounded-full">
                                            <x-heroicon-s-check class="w-3 h-3" />
                                        </span>
                                    @else
                                        <span title="Unverified User"
                                            class="flex items-center justify-center w-5 h-5 text-white bg-gray-400 rounded-full">
                                            <x-heroicon-s-x-mark class="w-3 h-3" />
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <label class="block mb-1 text-xs font-medium uppercase text-dark/40">Gender</label>
                                <p class="text-lg font-medium text-dark">{{ $user->gender == 1 ? 'Male' : 'Female' }}
                                </p>
                            </div>

                            <div class="flex flex-col sm:col-span-2">
                                <label class="block mb-1 text-xs font-medium uppercase text-dark/40">Email
                                    Address</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-lg font-medium text-dark">{{ $user->email }}</p>
                                    <!-- Small verification text hint -->
                                    <span class="text-xs {{ $user->is_verified ? 'text-green-600' : 'text-gray-400' }}">
                                        ({{ $user->is_verified ? 'Verified' : 'Not Verified' }})
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 2: Subscription & Coins (Same as before) -->
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="flex items-center justify-center w-10 h-10 bg-yellow-100 rounded-xl text-yellow-600">
                        <x-heroicon-o-currency-dollar class="w-5 h-5" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Financials & Subscription</h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="p-4 border rounded-2xl bg-background border-dark/5">
                        <label class="block mb-1 text-xs font-medium uppercase text-dark/40">Total Coins</label>
                        <p class="text-2xl font-bold text-primary">{{ number_format($user->coins) }}</p>
                    </div>
                    <div class="p-4 border rounded-2xl bg-background border-dark/5">
                        <label class="block mb-1 text-xs font-medium uppercase text-dark/40">Status</label>
                        <p class="font-bold text-dark">{{ $user->is_subscribed ? 'Active Member' : 'Free Tier' }}</p>
                    </div>
                    <div class="p-4 border rounded-2xl bg-background border-dark/5">
                        <label class="block mb-1 text-xs font-medium uppercase text-dark/40">Plan Name</label>
                        <p class="font-bold text-dark">{{ $user->subscription->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: ADMIN CONTROLS (Same as before) -->
        <div class="space-y-6">
            <div class="sticky top-24">
                <div
                    class="flex flex-col p-8 border shadow-sm bg-surface rounded-3xl border-primary/10 ring-4 ring-primary/5">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex items-center justify-center w-10 h-10 text-primary bg-primary/10 rounded-xl">
                            <x-heroicon-o-cog class="w-5 h-5" />
                        </div>
                        <h2 class="text-xl font-bold text-dark">Admin Control Panel</h2>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-dark/70">User Coins</label>
                            <input type="number" wire:model="coins"
                                class="w-full px-4 py-2 border rounded-xl bg-background outline-none focus:ring-1 focus:ring-primary">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-dark/70">Account Access</label>
                            <select wire:model="is_blocked"
                                class="w-full px-4 py-2 border rounded-xl bg-background outline-none focus:ring-1 focus:ring-primary">
                                <option value="">Select Access Status</option>
                                <option value="0">Allow Access (Active)</option>
                                <option value="1">Block Account</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" wire:loading.attr="disabled"
                            class="flex items-center justify-center w-full gap-2 py-4 font-bold text-white transition-all transform bg-gradient-to-r from-primary to-secondary rounded-2xl hover:shadow-xl hover:-translate-y-1 disabled:opacity-70">
                            <span wire:loading.remove wire:target="saveAdminSettings">Update User Profile</span>
                            <span wire:loading wire:target="saveAdminSettings">Saving...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
