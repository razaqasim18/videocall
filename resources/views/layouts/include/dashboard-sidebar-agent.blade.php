  @auth('agent')
            <!-- Agent Dashboard -->
            <a
                href="{{ route('agent.dashboard') }}"
                wire:navigate
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group
                {{ request()->routeIs('agent.dashboard')
                    ? 'bg-primary text-white shadow-md shadow-primary/20'
                    : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}"
            >
                <x-heroicon-s-home class="w-5 h-5" />
                <span class="font-medium">Dashboard</span>
            </a>

             <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">
                Subscription & Features
            </p>

            <!-- ================= SUBSCRIPTIONS ================= -->
            <div x-data="{ open: @js(request()->routeIs('agent.packages.*')) }" class="relative">
                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs('agent.packages.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
                    <div class="flex items-center gap-3">
                        <x-heroicon-s-ellipsis-horizontal-circle class="w-5 h-5" />
                        <span class="font-medium">Packages</span>
                    </div>
                    <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                        <x-heroicon-s-chevron-down class="w-4 h-4" />
                    </div>
                </button>
                <div x-show="open" x-cloak x-transition class="pl-4 mt-2 space-y-1">
                    <a href="{{ route('agent.packages.view') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('agent.packages.view') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('agent.packages.view') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        View Packages
                    </a>
                    <a href="{{ route('agent.packages.report') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('agent.packages.report') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('agent.packages.report') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                        Report Packages
                    </a>
                </div>
            </div>

            <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">
                Settings
            </p>

            <a
                href="{{ route('agent.profile') }}"
                wire:navigate
                class="flex items-center gap-3 px-4 py-3 transition-all rounded-xl group
                {{ request()->routeIs('agent.profile')
                    ? 'bg-primary text-white shadow-md shadow-primary/20'
                    : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}"
            >
                <x-heroicon-s-user-circle class="w-5 h-5" />
                <span class="font-medium">Profile Settings</span>
            </a>
        @endauth