<div class="space-y-8">
    <!-- Header -->
    <div class="space-y-8">
        <x-header-section headerwprimary="User" headerwsecondary="Detail"
            tagline="Comprehensive management of mobile app users, wallet balances, and account status." />
    </div>

    <div id="successdiv">
        @if (session()->has('success'))
            <x-alert :message="session()->get('success')" status="1"></x-alert>
        @endif
    </div>

    <form wire:submit.prevent="saveAdminSettings" class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- LEFT COLUMN: INFORMATION & WALLET -->
        <div class="space-y-6 lg:col-span-2">

            <!-- CARD 1: Personal Profile (FULLY EDITABLE) -->
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary/10 rounded-xl text-primary">
                        <x-heroicon-c-user class="w-5 h-5" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Personal Profile</h2>
                </div>

                <div class="flex flex-col items-center gap-8 md:flex-row">
                    <!-- Non-Editable Image Section -->
                    <div class="text-center shrink-0">
                        <div
                            class="relative w-40 h-40 overflow-hidden border-4 border-white rounded-full shadow-md ring-4 ring-primary/10">
                            @if ($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}"
                                    class="object-cover w-full h-full">
                            @else
                                <img src="{{ asset('images/user-avatar.png') }}" class="object-cover w-full h-full">
                            @endif
                            <div class="absolute bottom-2 right-2">
                                <span class="flex w-3 h-3">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $user->is_online ? 'bg-green-400' : 'bg-gray-400' }} opacity-75"></span>
                                    <span
                                        class="relative inline-flex rounded-full h-3 w-3 {{ $user->is_online ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                                </span>
                            </div>
                        </div>
                        <span
                            class="inline-block px-3 py-1 mt-3 text-[10px] font-bold uppercase rounded-full {{ $user->is_blocked ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                            {{ $user->is_blocked ? 'Blocked' : 'Active' }}
                        </span>
                    </div>

                    <!-- Editable Fields -->
                    <div class="w-full">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="space-y-1">
                                <label class="block text-xs font-medium uppercase text-dark/40">Full Name</label>
                                <input type="text" wire:model="name"
                                    class="w-full px-4 py-2 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                                @error('name')
                                    <span class="block text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-xs font-medium uppercase text-dark/40">Gender</label>
                                <select wire:model="gender"
                                    class="w-full px-4 py-2 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                                    <option value="1">Male</option>
                                    <option value="0">Female</option>
                                </select>
                                @error('gender')
                                    <span class="block text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-1 sm:col-span-2">
                                <label class="block text-xs font-medium uppercase text-dark/40">Email Address</label>
                                <input type="email" wire:model="email"
                                    class="w-full px-4 py-2 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                                @error('email')
                                    <span class="block text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 2: WALLET & TRANSACTION DETAILS -->
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center w-10 h-10 text-yellow-600 bg-yellow-100 rounded-xl">
                            <x-heroicon-o-wallet class="w-5 h-5" />
                        </div>
                        <h2 class="text-xl font-bold text-dark">Wallet Analytics</h2>
                    </div>
                </div>

                <!-- Wallet Summary Cards -->
                <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-3">
                    <div class="p-4 border rounded-2xl bg-background border-dark/5">
                        <label class="block mb-1 text-xs font-medium uppercase text-dark/40">Current Balance</label>
                        <p class="text-2xl font-bold text-primary">{{ number_format($user->coins) }} <span
                                class="text-sm">Coins</span></p>
                    </div>
                    <div class="p-4 border rounded-2xl bg-background border-dark/5">
                        <label class="block mb-1 text-xs font-medium uppercase text-dark/40">Subscription</label>
                        <p class="font-bold text-dark">{{ $user->subscription->name ?? 'Free Tier' }}</p>
                    </div>
                    <div class="p-4 border rounded-2xl bg-background border-dark/5">
                        <label class="block mb-1 text-xs font-medium uppercase text-dark/40">Account Status</label>
                        <p class="font-bold text-dark">{{ $user->is_verified ? 'Verified' : 'Unverified' }}</p>
                    </div>
                </div>

                <!-- Transaction History Table -->
                <div class="overflow-hidden border rounded-2xl bg-background border-dark/5">
                    <table class="w-full text-left border-collapse">
                        <thead class="text-xs uppercase bg-dark/5 text-dark/60">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Date</th>
                                <th class="px-4 py-3 font-semibold">Type</th>
                                <th class="px-4 py-3 font-semibold">Amount</th>
                                <th class="px-4 py-3 font-semibold text-right">Balance</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-dark/5">
                            @forelse($transactions as $tx)
                                <tr class="transition-all hover:bg-primary/5">
                                    <td class="px-4 py-3 text-dark/70">
                                        {{ $tx->created_at?->format('d M, Y') ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-2 py-1 text-[10px] font-bold uppercase rounded-md {{ $tx->type == 'credit' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                            {{ $tx->type }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-4 py-3 font-bold {{ $tx->type == 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $tx->type == 'credit' ? '+' : '-' }}{{ number_format($tx->amount) }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-right text-dark">
                                        {{ number_format($tx->balance_after) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-dark/40">No transactions found
                                        for this user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: ADMIN CONTROLS -->
        <div class="space-y-6">
            <div class="sticky top-24">
                <div
                    class="flex flex-col p-8 border shadow-sm bg-surface rounded-3xl border-primary/10 ring-4 ring-primary/5">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex items-center justify-center w-10 h-10 text-primary bg-primary/10 rounded-xl">
                            <x-heroicon-o-cog class="w-5 h-5" />
                        </div>
                        <h2 class="text-xl font-bold text-dark">Control Panel</h2>
                    </div>

                    <div class="space-y-5">
                        <!-- Wallet Balance Edit -->
                        {{-- <div class="p-4 border bg-background rounded-2xl border-primary/10">
                            <label class="block mb-2 text-sm font-medium text-dark/70">Update Wallet Balance</label>
                            <div class="relative">
                                <span class="absolute text-sm -translate-y-1/2 left-4 top-1/2 text-dark/40">Coins</span>
                                <input type="number" wire:model="coins"
                                    class="w-full py-2 pl-16 pr-4 border outline-none rounded-xl bg-background focus:ring-1 focus:ring-primary">
                            </div>
                            @error('coins')
                                <span class="block mt-1 text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div> --}}

                        <!-- Account Status Edit -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-dark/70">Account Access</label>
                            <select wire:model="is_blocked"
                                class="w-full px-4 py-2 border outline-none rounded-xl bg-background focus:ring-1 focus:ring-primary">
                                <option value="0">Allow Access (Active)</option>
                                <option value="1">Block Account</option>
                            </select>
                            @error('is_blocked')
                                <span class="block mt-1 text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" wire:loading.attr="disabled"
                            class="flex items-center justify-center w-full gap-2 py-4 font-bold text-white transition-all transform bg-gradient-to-r from-primary to-secondary rounded-2xl hover:shadow-xl hover:-translate-y-1 disabled:opacity-70">
                            <span wire:loading.remove wire:target="saveAdminSettings">Update</span>
                            <span wire:loading wire:target="saveAdminSettings">Processing...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
