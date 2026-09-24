<div wire:cloak class="relative">
    <button @click="notifOpen = !notifOpen"
        class="relative p-2 transition-all rounded-full text-dark/60 hover:bg-gray-100 focus:outline-none">
        @if (count($unreadnotifications))
            <span class="absolute w-2 h-2 border-white rounded-full border-1 top-2 right-2 bg-primary"></span>
        @endif
        <x-heroicon-o-bell class="w-6 h-6" />
    </button>

    <!-- Dropdown Panel -->
    <div x-show="notifOpen" @click.away="notifOpen = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        class="absolute right-0 z-50 mt-2 overflow-hidden border shadow-xl w-80 bg-surface border-primary/10 rounded-2xl">

        <div class="flex items-center justify-between p-4 border-b border-primary/10">
            <h3 class="font-bold text-dark">Notifications</h3>
            <a wire:click.prevent='markAllRead' href="#"
                class="text-xs font-semibold transition-colors text-primary hover:text-secondary">Mark
                all as read</a>
        </div>

        <!-- Notifications List -->
        <div class="overflow-y-auto max-h-80">


            @foreach ($unreadnotifications->concat($readnotifications) as $notification)
                @continue(!$notification)

                @php
                    $type = $notification->data['type'] ?? null;

                    $link = match ($type) {
                        'package_purchase' => route('admin.agent.purchase.packages.detail', [
                            'id' => $notification->data['agent_id'] ?? 0,
                        ]),
                        'corporate_register' => route('admin.corporate.edit', [
                            'id' => $notification->data['corporate_id'] ?? 0,
                        ]),
                        'contact_us' => route('admin.contact.detail', [
                            'id' => $notification->data['contact_id'] ?? 0,
                        ]),
                        default => '#',
                    };
                @endphp

                <a href="{{ $link }}"
                    class="flex gap-3 p-4 transition-colors border-b border-gray-50 hover:bg-gray-50">

                    @switch($type)
                        @case('partner_register')
                            <div
                                class="flex items-center justify-center w-10 h-10 rounded-full bg-primary/10 text-primary shrink-0">
                                <x-heroicon-s-user-group class="w-5 h-5" />
                            </div>
                        @break

                        @case('contact_us')
                            <div
                                class="flex items-center justify-center w-10 h-10 rounded-full bg-primary/10 text-primary shrink-0">
                                <x-heroicon-m-chat-bubble-oval-left class="w-5 h-5" />
                            </div>
                        @break

                        @default
                            <div
                                class="flex items-center justify-center w-10 h-10 text-gray-500 bg-gray-100 rounded-full shrink-0">
                                <x-heroicon-o-bell class="w-5 h-5" />
                            </div>
                    @endswitch

                    <div class="flex-1">
                        <p class="text-sm font-medium text-dark">
                            {{ $notification->data['message'] ?? 'Notification' }}
                        </p>

                        <p class="mt-1 text-xs text-dark/50">
                            {{ $notification->created_at?->diffForHumans() }}
                        </p>
                    </div>

                    @if (is_null($notification->read_at))
                        <span class="w-2 h-2 mt-2 rounded-full bg-primary"></span>
                    @endif
                </a>
            @endforeach

        </div>
        {{-- <div class="overflow-y-auto max-h-80">

            @foreach ($unreadnotifications as $notification)
                @php
                    if ($notification->data['type'] == 'partner_register') {
                        $link = route('admin.partner.detail', [
                            'id' => $notification->data['partner_id'],
                        ]);
                    } else {
                        $link = '#';
                    }
                @endphp
                <a href="{!! $link !!}"
                    class="flex gap-3 p-4 transition-colors border-b hover:bg-gray-50 border-gray-50">

                    @if ($notification->data['type'] == 'partner_register')
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-primary/10 text-primary shrink-0">
                            <x-heroicon-s-user-group class="w-5 h-5" />
                        </div>
                    @endif

                    <div class="flex-1">
                        <p class="text-sm font-medium text-dark">
                            {{ $notification->data['message'] }}
                        </p>

                        <p class="mt-1 text-xs text-dark/50">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                </a>
            @endforeach

            @foreach ($readnotifications as $notification)
                @php
                    if ($notification->data['type'] == 'partner_register') {
                        $link = route('admin.partner.detail', [
                            'id' => $notification->data['partner_id'],
                        ]);
                    } else {
                        $link = '#';
                    }
                @endphp
                <a href="{!! $link !!}"
                    class="flex gap-3 p-4 transition-colors border-b hover:bg-gray-50 border-gray-50">
                    @if ($notification->data['type'] == 'partner_register')
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-primary/10 text-primary shrink-0">
                            <x-heroicon-s-user-group class="w-5 h-5" />
                        </div>
                    @endif
                    <div class="flex-1">
                        <p class="text-sm font-medium text-dark">
                            {{ $notification->data['message'] }}
                        </p>

                        <p class="mt-1 text-xs text-dark/50">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                </a>
            @endforeach --}}

        <!-- Item 1 -->

        <!-- Item 2 -->
        {{-- <a href="#" class="flex gap-3 p-4 transition-colors border-b hover:bg-gray-50 border-gray-50">
                <div
                    class="flex items-center justify-center w-10 h-10 text-green-600 bg-green-100 rounded-full shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-dark">Payment received successfully</p>
                    <p class="mt-1 text-xs text-dark/50">Yesterday</p>
                </div>
            </a> --}}
        <!-- Item 3 -->
        {{-- <a href="#" class="flex gap-3 p-4 transition-colors hover:bg-gray-50">
                <div
                    class="flex items-center justify-center w-10 h-10 text-yellow-600 bg-yellow-100 rounded-full shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 15c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-dark">Subscription expiring soon</p>
                    <p class="mt-1 text-xs text-dark/50">3 days ago</p>
                </div>
            </a> --}}
        {{-- </div> --}}

        <div class="p-3 text-center bg-gray-50">
            <a href="#" class="text-xs font-bold transition-colors text-dark/60 hover:text-primary">View
                All Notifications</a>
        </div>
    </div>
</div>
