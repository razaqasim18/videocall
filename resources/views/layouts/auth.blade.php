<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    @if (!empty($settings['favicon']))
        <link rel="icon" href="{{ asset('storage') . '/' . $settings['favicon'] }}" type="image/png">
    @endif

    @livewireStyles

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @stack('styles')
</head>

<body class="antialiased bg-background text-dark">
    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>
    @livewireScripts
    @stack('scripts')
</body>

</html>
