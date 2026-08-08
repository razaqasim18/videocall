<div>
    @php
        $classes = $status
            ? 'flex items-center gap-2 p-4 text-green-700 bg-green-100 border border-green-500 rounded-xl animate-bounce'
            : 'flex items-center gap-2 p-4 text-red-700 bg-red-100 border border-red-500 rounded-xl animate-bounce';
    @endphp

    <div {{ $attributes->merge(['class' => $classes]) }} x-data x-init="setTimeout(() => $el.remove(), 5000)">
        @if ($status)
            <x-heroicon-o-check class="w-6 h-6" />
        @else
            <x-heroicon-o-trash class="w-6 h-6" />
        @endif

        {{ $message }}
    </div>
</div>
