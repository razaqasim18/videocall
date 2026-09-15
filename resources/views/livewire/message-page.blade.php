<div class="relative flex items-center justify-center min-h-screen p-4 overflow-hidden bg-background">
    <!-- Background Decorative Elements (Matching your Contact Page style) -->
    <div class="absolute top-0 rounded-full -left-20 w-96 h-96 bg-primary/10 blur-3xl"></div>
    <div class="absolute bottom-0 rounded-full -right-20 w-96 h-96 bg-secondary/10 blur-3xl"></div>

    <div class="relative z-10 w-full max-w-md">
        <div class="relative p-8 overflow-hidden border border-gray-200 shadow-sm bg-surface md:p-10 rounded-3xl">

            <!-- Top Accent Gradient Line -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary to-secondary"></div>

            @if ($status == 1)
                <h1
                    class="mb-5 text-3xl font-bold text-center text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">
                    Success
                </h1>
                <div
                    class="flex items-center gap-2 p-4 mt-4 text-green-700 bg-green-100 border border-green-500 rounded-xl">
                    <x-heroicon-o-check class="w-6 h-6" />
                    {{ $message }}
                </div>
            @endif

            @if ($status == 0)
                <h1
                    class="mb-5 text-3xl font-bold text-center text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">
                    Error
                </h1>
                <div class="flex items-center gap-2 p-4 text-red-700 bg-red-100 border border-red-500 rounded-xl">
                    <x-heroicon-o-trash class="w-6 h-6" />
                    {{ $message }}
                </div>
            @endif

        </div>

    </div>
</div>
