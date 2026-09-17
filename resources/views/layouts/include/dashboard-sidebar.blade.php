<!-- Mobile Overlay -->
<div
    x-show="sidebarOpen"
    x-transition:enter="transition opacity-ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition opacity-ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="sidebarOpen = false"
    class="fixed inset-0 z-40 bg-dark/30 backdrop-blur-sm lg:hidden"
></div>

<!-- Sidebar Panel -->
<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 flex flex-col w-[300px] transition-transform duration-300 ease-in-out border-r bg-surface border-primary/10 lg:relative lg:translate-x-0"
>

    <!-- Logo Area -->
    <div class="p-6">
        <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center gap-3">
            @if (!empty($settings['logo']))
                <img
                    class="object-contain w-10 h-10 rounded-lg"
                    src="{{ asset('storage/' . $settings['logo']) }}"
                    alt="{{ $settings['site_name'] ?? config('app.name') }}"
                />
            @endif

            <span class="text-lg font-bold text-transparent truncate bg-gradient-to-br from-primary to-secondary bg-clip-text">
                {{ $settings['site_name'] ?? config('app.name') }}
            </span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-4 space-y-2 overflow-y-auto">

        <p class="px-2 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">
            Main Menu
        </p>

        <!-- ========================================================= -->
        <!-- AGENT AUTH -->
        <!-- ========================================================= -->
        @include('layouts.include.dashboard-sidebar-agent')  

        <!-- ========================================================= -->
        <!-- ADMIN AUTH -->
        <!-- ========================================================= -->
        @include('layouts.include.dashboard-sidebar-admin')
    </nav>

    <!-- Bottom User Section -->
    <div class="p-4 border-t border-primary/10">
        <button @click="$refs.logoutForm.submit()"
            class="flex items-center w-full gap-3 px-4 py-3 font-medium text-red-500 transition-all rounded-xl hover:bg-red-50"
        >
            <x-heroicon-s-arrow-right-on-rectangle class="w-5 h-5" />
            Logout
        </button>
    </div>
</aside>
