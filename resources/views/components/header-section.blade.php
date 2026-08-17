@props([
    'headerwprimary' => 'User',
    'headerwsecondary' => 'List',
    'tagline' => 'Review and manage your facility user base efficiently.',
])

<div class="flex flex-col gap-4 mb-8 md:flex-row md:items-center md:justify-between">
    <div class="flex items-center gap-4">


        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-dark">
                {{ $headerwprimary }}
                <span class="gradient-text">
                    {{ $headerwsecondary }}
                </span>
            </h1>

            <p class="mt-1 text-sm text-dark/50">
                {{ $tagline }}
            </p>
        </div>
    </div>
</div>
