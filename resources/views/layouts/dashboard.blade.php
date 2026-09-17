<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }} | Dashboard</title>
    @if (!empty($settings['favicon']))
        <link rel="icon" href="{{ asset('storage') . '/' . $settings['favicon'] }}" type="image/png">
    @endif
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @stack('styles')

</head>
@php
    $user = auth()->guard('agent')->check() ? auth()->guard('agent')->user() : auth()->guard('admin')->user();
@endphp

<body class="antialiased bg-background text-dark" x-data="{ sidebarOpen: false }">

    <!-- DASHBOARD WRAPPER -->
    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        @include('layouts.include.dashboard-sidebar')
        <!-- MAIN CONTENT AREA -->
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

            <!-- TOP NAVBAR -->
            @include('layouts.include.dashboard-navbar')
            <!-- MAIN CONTENT -->
            <main class="flex-1 p-4 overflow-y-auto lg:p-8">
                {{ $slot }}
                <div class="pt-8 text-sm text-center border-t border-gray-100 text-dark/50">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved. Designed and Developed
                        by
                        <a class="font-bold text-primary"
                            href="{{ config('app.created_by_link') }}">{{ config('app.created_by') }}</a>
                    </p>
                </div>
            </main>



        </div>
    </div>
    @auth('agent')
        <form x-ref="logoutForm" method="POST" action="{{ route('agent.logout') }}" class="hidden">
            @csrf
        </form>
    @endauth
    <div id="sound">
        <audio id="notifyAudio" preload="auto">
            <source src="{{ asset('sounds/notification.mp3') }}" type="audio/mpeg">
        </audio>
    </div>
    @auth('admin')
        <form x-ref="logoutForm" method="POST" action="{{ route('admin.logout') }}" class="hidden">
            @csrf
        </form>
    @endauth

    @livewireScripts
    @stack('scripts')
    <script>
        // Scroll to top on success/error
        Livewire.on('scroll-to-top', () => {
            const el = document.getElementById('successdiv');
            if (el) {
                el.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    </script>
    @auth('admin')
        <script>
            var lastPlayed = 0;

            function playNotification() {
                const now = Date.now();
                if (now - lastPlayed < 1000) return;
                lastPlayed = now;

                const audio = document.getElementById("notifyAudio");
                if (audio) {
                    audio.currentTime = 0;
                    audio.play().catch(() => {});
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Pass only the ID number
                const adminId = {{ auth()->guard('admin')->id() ?? 'null' }};

                if (!adminId || adminId === 'null') {
                    console.error('Admin ID not found');
                    return;
                }

                if (!window.Echo) {
                    console.error('Echo not loaded');
                    return;
                }


                window.Echo.private(`App.Models.Admin.${adminId}`)
                    .notification((notification) => {
                        // console.log('Notification received:', notification);
                        playNotification();
                        Livewire.dispatch('new-notification');
                    });
            });
        </script>
    @endauth
</body>

</html>
