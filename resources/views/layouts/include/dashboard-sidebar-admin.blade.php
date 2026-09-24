   @auth('admin')
       <!-- Admin Dashboard -->
       <a href="{{ route('admin.dashboard') }}" wire:navigate
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-primary text-white shadow-md shadow-primary/20'
                    : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
           <x-heroicon-s-home class="w-5 h-5" />
           <span class="font-medium">Dashboard</span>
       </a>

       <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">
           Management
       </p>

       <!-- ================= AGENTS ================= -->
       <!-- FIXED: Use array to prevent overlap with agent.packages -->
       <div x-data="{ open: @js(request()->routeIs(['admin.agent.create', 'admin.agent.list'])) }" class="relative">
           <button type="button" @click="open = !open"
               class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs(['admin.agent.create', 'admin.agent.list'])
                        ? 'bg-primary text-white shadow-md shadow-primary/20'
                        : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
               <div class="flex items-center gap-3">
                   <x-heroicon-s-user-group class="w-5 h-5" />
                   <span class="font-medium">Agents</span>
               </div>
               <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                   <x-heroicon-s-chevron-down class="w-4 h-4" />
               </div>
           </button>

           <div x-show="open" x-cloak x-transition class="pl-4 mt-2 space-y-1">
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

       <!-- ================= USERS ================= -->
       <div x-data="{ open: @js(request()->routeIs('admin.user.*')) }" class="relative">
           <button type="button" @click="open = !open"
               class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs('admin.user.*')
                        ? 'bg-primary text-white shadow-md shadow-primary/20'
                        : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
               <div class="flex items-center gap-3">
                   <x-heroicon-s-user-group class="w-5 h-5" />
                   <span class="font-medium">Users</span>
               </div>
               <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                   <x-heroicon-s-chevron-down class="w-4 h-4" />
               </div>
           </button>

           <div x-show="open" x-cloak x-transition class="pl-4 mt-2 space-y-1">
               <a href="{{ route('admin.user.list') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.user.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.user.list') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   User List
               </a>
           </div>
       </div>

       <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">
           Rewards & Missions
       </p>

       <!-- ================= COINS ================= -->
       <div x-data="{ open: @js(request()->routeIs('admin.coin.*')) }" class="relative">
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
           <div x-show="open" x-cloak x-transition class="pl-4 mt-2 space-y-1">
               <a href="{{ route('admin.coin.create') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.coin.create') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.coin.create') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Create Coin
               </a>
               <a href="{{ route('admin.coin.list') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.coin.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.coin.list') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Coin List
               </a>
           </div>
       </div>


       <!-- =================Dailt REWARDS ================= -->
       <div x-data="{ open: @js(request()->routeIs('admin.daily.reward.*')) }" class="relative">
           <button type="button" @click="open = !open"
               class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs('admin.daily.reward.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
               <div class="flex items-center gap-3">
                   <x-heroicon-s-gift class="w-5 h-5" />
                   <span class="font-medium">Daily Rewards</span>
               </div>
               <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                   <x-heroicon-s-chevron-down class="w-4 h-4" />
               </div>
           </button>
           <div x-show="open" x-cloak x-transition class="pl-4 mt-2 space-y-1">
               <a href="{{ route('admin.daily.reward.form') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.daily.reward.form') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.daily.reward.form') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Create Daily Reward
               </a>
               <a href="{{ route('admin.daily.reward.list') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.daily.reward.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.daily.reward.list') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Daily Reward List
               </a>
           </div>
       </div>

       <!-- ================= REWARDS ================= -->
       <div x-data="{ open: @js(request()->routeIs('admin.reward.*')) }" class="relative">
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
           <div x-show="open" x-cloak x-transition class="pl-4 mt-2 space-y-1">
               <a href="{{ route('admin.reward.create') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.reward.create') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.reward.create') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Create Reward
               </a>
               <a href="{{ route('admin.reward.list') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.reward.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.reward.list') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Reward List
               </a>
           </div>
       </div>

       <!-- ================= GIFTS ================= -->
       <div x-data="{ open: @js(request()->routeIs('admin.gift.*')) }" class="relative">
           <button type="button" @click="open = !open"
               class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs('admin.gift.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
               <div class="flex items-center gap-3">
                   <x-heroicon-s-gift class="w-5 h-5" />
                   <span class="font-medium">Gift</span>
               </div>
               <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                   <x-heroicon-s-chevron-down class="w-4 h-4" />
               </div>
           </button>
           <div x-show="open" x-cloak x-transition class="pl-4 mt-2 space-y-1">
               <a href="{{ route('admin.gift.create') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.gift.create') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.gift.create') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Create Gift
               </a>
               <a href="{{ route('admin.gift.list') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.gift.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.gift.list') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Gift List
               </a>
           </div>
       </div>

       <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">
           Subscription & Features
       </p>

       <!-- ================= SUBSCRIPTION CATEGORY ================= -->
       <a href="{{ route('admin.subscription.category') }}" wire:navigate
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group
                {{ request()->routeIs('admin.subscription.category') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
           <x-heroicon-s-ellipsis-horizontal-circle class="w-5 h-5" />
           <span class="font-medium">Subscription Category</span>
       </a>

       <!-- ================= SUBSCRIPTIONS ================= -->
       <div x-data="{ open: @js(request()->routeIs('admin.subscriptions.*')) }" class="relative">
           <button type="button" @click="open = !open"
               class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs('admin.subscriptions.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
               <div class="flex items-center gap-3">
                   <x-heroicon-s-ellipsis-horizontal-circle class="w-5 h-5" />
                   <span class="font-medium">Subscriptions</span>
               </div>
               <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                   <x-heroicon-s-chevron-down class="w-4 h-4" />
               </div>
           </button>
           <div x-show="open" x-cloak x-transition class="pl-4 mt-2 space-y-1">
               <a href="{{ route('admin.subscriptions.create') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.subscriptions.create') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.subscriptions.create') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Create Subscriptions
               </a>
               <a href="{{ route('admin.subscriptions.list') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.subscriptions.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.subscriptions.list') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Subscriptions List
               </a>
           </div>
       </div>

       <!-- ================= AGENT Packages ================= -->
       <div x-data="{ open: @js(request()->routeIs('admin.agent.packages.*')) }" class="relative">
           <button type="button" @click="open = !open"
               class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs('admin.agent.packages.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
               <div class="flex items-center gap-3">
                   <x-heroicon-s-ellipsis-horizontal-circle class="w-5 h-5" />
                   <span class="font-medium">Agent Packages</span>
               </div>
               <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                   <x-heroicon-s-chevron-down class="w-4 h-4" />
               </div>
           </button>
           <div x-show="open" x-cloak x-transition class="pl-4 mt-2 space-y-1">
               <a href="{{ route('admin.agent.packages.create') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.agent.packages.create') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.agent.packages.create') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Create Agent Packages
               </a>
               <a href="{{ route('admin.agent.packages.list') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.agent.packages.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.agent.packages.list') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Agent Packages List
               </a>
           </div>
       </div>

       <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">
           Customer Support
       </p>

       <!-- ================= TICKET ================= -->
       <div x-data="{ open: @js(request()->routeIs('admin.ticket.*')) }" class="relative">
           <button type="button" @click="open = !open"
               class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs('admin.ticket.*') ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-dark/70 hover:bg-gray-100 hover:text-primary' }}">
               <div class="flex items-center gap-3">
                   <x-heroicon-s-ticket class="w-5 h-5" />
                   <span class="font-medium">Ticket</span>
               </div>
               <div :class="open ? 'rotate-180' : ''" class="transition-transform duration-200">
                   <x-heroicon-s-chevron-down class="w-4 h-4" />
               </div>
           </button>
           <div x-show="open" x-cloak x-transition class="pl-4 mt-2 space-y-1">
               <a href="{{ route('admin.ticket.list') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.ticket.list') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.ticket.list') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Ticket List
               </a>
           </div>
       </div>

       <p class="px-2 mt-8 mb-4 text-xs font-semibold tracking-wider uppercase text-dark/40">
           Website Settings
       </p>

       <!-- ================= SETTINGS ================= -->
       <div x-data="{ open: @js(request()->routeIs('admin.setting.*')) }" class="relative">
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
           <div x-show="open" x-cloak x-transition class="pl-4 mt-2 space-y-1">
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
                   Privacy Policy
               </a>
               <a href="{{ route('admin.setting.term-condition') }}" wire:navigate
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all
                        {{ request()->routeIs('admin.setting.term-condition') ? 'text-primary font-bold bg-primary/10' : 'text-dark/60 hover:text-primary hover:bg-gray-100' }}">
                   <span
                       class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.setting.term-condition') ? 'bg-primary' : 'bg-gray-300' }}"></span>
                   Terms & Conditions
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
