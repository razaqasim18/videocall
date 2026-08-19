<!-- Mobile Overlay -->
<div x-show="sidebarOpen" x-transition:enter="transition opacity-ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition opacity-ease-in duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
    class="fixed inset-0 z-40 bg-dark/30 backdrop-blur-sm lg:hidden">
</div>

<!-- Sidebar Panel -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 flex flex-col w-[300px] lg:w-[300px] lg:min-w-[300px] transition-transform duration-300 ease-in-out border-r bg-surface border-primary/10 lg:relative lg:translate-x-0">

    <!-- Logo Area -->
    <div class="p-6">
        <a href="/dashboard" class="flex items-center gap-3">
            @if (!empty($settings['logo']))
                <img class="object-contain w-10 h-10 rounded-lg" src="{{ asset('storage/' . $settings['logo']) }}"
                    alt="{{ $settings['site_name'] ?? config('app.name') }}" />
            @endif

            <span
                class="text-lg font-bold text-transparent truncate bg-gradient-to-br from-primary to-secondary bg-clip-text">
                {{ $settings['site_name'] ?? config('app.name') }}
            </span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
        <p class="px-2 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">Main Menu</p>

        @auth('agent')
            <!-- Dashboard -->
            <a href="{{ route('agent.dashboard') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('agent.dashboard') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
                <x-heroicon-s-home class="w-5 h-5" />
                <span class="font-medium">Dashboard</span>
            </a>

            <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">Settings</p>

            <!-- Profile Settings -->
            <a href="{{ route('agent.profile-setting') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 transition-all rounded-xl group {{ request()->routeIs('agent.profile-setting') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
                <x-heroicon-s-user-circle class="w-5 h-5" />
                <span class="font-medium">Profile Settings</span>
            </a>
        @endauth

        @auth('admin')
            <!-- Admin Dashboard -->
            <a href="{{ route('admin.dashboard') }}" wire:navigate
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
                <x-heroicon-s-home class="w-5 h-5" />
                <span class="font-medium">Dashboard</span>
            </a>

            <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">Management</p>

            <!-- Agent Dropdown -->
            <div x-data="{ open: {{ request()->routeIs('admin.agent.*') ? 'true' : 'false' }} }" class="relative">
                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs('admin.agent.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">

                    <div class="flex items-center gap-3">
                        <x-heroicon-s-user-group class="w-5 h-5" />
                        <span class="font-medium">Agents</span>
                    </div>

                    <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                        <x-heroicon-s-chevron-down class="w-4 h-4" />
                    </div>
                </button>

                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    class="pl-4 mt-2 space-y-1">
                    <a href="{{ route('admin.agent.create') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.agent.create') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.agent.create') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        Create Agent
                    </a>
                    <a href="{{ route('admin.agent.list') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.agent.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.agent.list') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        Agent List
                    </a>

                </div>
            </div>



            <!-- User Dropdown -->
            <div x-data="{ open: {{ request()->routeIs('admin.user.*') ? 'true' : 'false' }} }" class="relative">
                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs('admin.user.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">

                    <div class="flex items-center gap-3">
                        <x-heroicon-s-user-group class="w-5 h-5" />
                        <span class="font-medium">Users</span>
                    </div>

                    <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                        <x-heroicon-s-chevron-down class="w-4 h-4" />
                    </div>
                </button>

                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    class="pl-4 mt-2 space-y-1">
                    <a href="{{ route('admin.user.list') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.user.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.user.list') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        User List
                    </a>
                </div>
            </div>

            <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">Rewards & Missions</p>

            <!-- User Dropdown -->
            <div x-data="{ open: {{ request()->routeIs('admin.coin.*') ? 'true' : 'false' }} }" class="relative">
                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs('admin.coin.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">

                    <div class="flex items-center gap-3">
                        <x-heroicon-s-gift class="w-5 h-5" />
                        <span class="font-medium">Coins</span>
                    </div>

                    <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                        <x-heroicon-s-chevron-down class="w-4 h-4" />
                    </div>
                </button>

                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    class="pl-4 mt-2 space-y-1">
                    <a href="{{ route('admin.coin.create') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.coin.create') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.coin.create') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        Create Coin
                    </a>
                </div>

                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    class="pl-4 mt-2 space-y-1">
                    <a href="{{ route('admin.coin.list') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.coin.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.coin.list') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        Coin List
                    </a>
                </div>
            </div>

            <!-- Reward Dropdown -->
            <div x-data="{ open: {{ request()->routeIs('admin.reward.*') ? 'true' : 'false' }} }" class="relative">
                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs('admin.reward.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">

                    <div class="flex items-center gap-3">
                        <x-heroicon-s-gift class="w-5 h-5" />
                        <span class="font-medium">Rewards</span>
                    </div>

                    <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                        <x-heroicon-s-chevron-down class="w-4 h-4" />
                    </div>
                </button>

                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    class="pl-4 mt-2 space-y-1">
                    <a href="{{ route('admin.reward.create') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.reward.create') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.reward.create') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        Create Reward
                    </a>
                </div>

                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    class="pl-4 mt-2 space-y-1">
                    <a href="{{ route('admin.reward.list') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.reward.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.reward.list') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        Reward List
                    </a>
                </div>
            </div>

            <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">Subscription & Features
            </p>

            <!-- Subscription Dropdown -->
            <div x-data="{ open: {{ request()->routeIs('admin.subscriptions.*') ? 'true' : 'false' }} }" class="relative">

                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('partner.subscriptions.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">

                    <div class="flex items-center gap-3">
                        <x-heroicon-s-ellipsis-horizontal-circle class="w-5 h-5" />
                        <span class="font-medium">Subscriptions</span>
                    </div>

                    <div :class="{ 'rotate-180': open }" class="transition-transform duration-200">
                        <x-heroicon-s-chevron-down class="w-4 h-4" />
                    </div>
                </button>

                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    class="pl-4 mt-2 space-y-1">

                    <a href="{{ route('admin.subscriptions.create') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('admin.subscriptions.create') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">

                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.subscriptions.create') ? 'bg-primary' : 'bg-gray-300' }}">
                        </span>

                        Create Subscriptions
                    </a>

                    <a href="{{ route('admin.subscriptions.list') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('admin.subscriptions.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">

                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.subscriptions.list') ? 'bg-primary' : 'bg-gray-300' }}">
                        </span>

                        Subscriptions List
                    </a>

                </div>
            </div>

            <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">Customer Support</p>

            <!-- Ticket Dropdown -->
            <div x-data="{ open: {{ request()->routeIs('admin.ticket.*') ? 'true' : 'false' }} }" class="relative">

                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('partner.ticket.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">

                    <div class="flex items-center gap-3">
                        <x-heroicon-s-ticket class="w-5 h-5" />
                        <span class="font-medium">Ticket</span>
                    </div>

                    <div :class="{ 'rotate-180': open }" class="transition-transform duration-200">
                        <x-heroicon-s-chevron-down class="w-4 h-4" />
                    </div>
                </button>

                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    class="pl-4 mt-2 space-y-1">




                    <a href="{{ route('admin.ticket.list') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all {{ request()->routeIs('admin.ticket.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">

                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.ticket.list') ? 'bg-primary' : 'bg-gray-300' }}">
                        </span>

                        Ticket List
                    </a>

                </div>
            </div>

            <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">Website Settings</p>

            <!-- Website Settings Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs('admin.setting.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">

                    <div class="flex items-center gap-3">
                        <x-heroicon-c-wrench class="w-5 h-5" />
                        <span class="font-medium">Website Settings</span>
                    </div>

                    <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                        <x-heroicon-s-chevron-down class="w-4 h-4" />
                    </div>
                </button>

                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    class="pl-4 mt-2 space-y-1">

                    <a href="{{ route('admin.setting.general') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.setting.general') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.setting.general') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        General Settings
                    </a>

                    <a href="{{ route('admin.setting.privacy-policy') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.setting.privacy-policy') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.setting.privacy-policy') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        Privacy Policy Settings
                    </a>


                    <a href="{{ route('admin.setting.term-condition') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.setting.term-condition') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.setting.term-condition') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        Terms & Conditions Settings
                    </a>

                    <a href="{{ route('admin.setting.about-application') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.setting.about-application') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.setting.about-application') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        About Application
                    </a>
                </div>
            </div>
        @endauth
    </nav>

    <!-- Bottom User Section -->
    <div class="p-4 border-t border-primary/10">
        <button @click="$refs.logoutForm.submit()"
            class="flex items-center w-full gap-3 px-4 py-3 font-medium text-red-500 transition-all rounded-xl hover:bg-red-50">
            <x-heroicon-s-arrow-right-on-rectangle class="w-5 h-5" />
            Logout
        </button>
    </div>
</aside>
