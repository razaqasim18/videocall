<header class="sticky top-0 z-30 flex items-center justify-between h-20 px-4 border-b bg-surface border-primary/10 lg:px-8">
    
    <!-- Mobile Toggle -->
    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-dark/60 hover:bg-gray-100 lg:hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>



    <!-- User Actions -->
    <div class="flex items-center gap-4 ml-auto" x-data="{ profileOpen: false }">

        <!-- NOTIFICATION DROPDOWN -->
     

        <!-- PROFILE DROPDOWN -->
        <div class="relative">
            <button @click="profileOpen = !profileOpen"
                class="flex items-center gap-3 pl-4 border-l border-primary/10 focus:outline-none group">
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-bold leading-none transition-colors text-dark group-hover:text-primary">
                        {{ $user->name }}
                    </p>
                    <p class="mt-1 text-xs text-dark/50">
                        @auth('agent')
                            Agent
                        @else
                            Admin
                        @endauth
                    </p>
                </div>
                <img src="{{ $user->profile ? asset('/storage/' . $user->profile) : asset('images/user-avatar.png') }}"
                    class="w-10 h-10 transition-all border-2 rounded-full border-primary/20 group-hover:border-primary"
                    alt="User">
            </button>

            <!-- Dropdown Panel -->
            <div wire:cloak x-show="profileOpen" @click.away="profileOpen = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="absolute right-0 z-50 w-56 mt-2 overflow-hidden border shadow-xl bg-surface border-primary/10 rounded-2xl">

                <!-- User Detail Header -->
                <div class="p-4 border-b bg-gray-50/50 border-primary/10">
                    <p class="text-sm font-bold text-dark">
                        {{ $user->name }}
                    </p>
                    <p class="text-xs truncate text-dark/50">
                        {{ $user->email }}
                    </p>
                </div>

                @auth('admin')
                    <a href="{{ route('admin.profile') }}" wire:navigate
                        class="flex items-center gap-3 px-3 py-2 text-sm transition-all rounded-lg text-dark/70 hover:bg-primary/10 hover:text-primary">
                        <x-heroicon-o-user-circle class="w-4 h-4" />
                        Profile Settings
                    </a>
                @endauth

            
                <!-- Logout Section -->
                <div class="p-2 border-t border-primary/10">
                    <button @click="$refs.logoutForm.submit()"
                        class="flex items-center w-full gap-3 px-3 py-2 text-sm font-semibold text-red-500 transition-all rounded-lg hover:bg-red-50">
                        <x-heroicon-o-arrow-right-circle class="w-4 h-4" />
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>

  
</header>
