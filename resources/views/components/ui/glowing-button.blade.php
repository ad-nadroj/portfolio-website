@props([
    'href' => null,
    'variant' => 'blue', // blue, cyan, rose
])

@php
    $gradientClasses = [
        'blue' => 'from-blue-600/25 to-indigo-600/25 border-blue-500/30 hover:border-blue-500/60',
        'cyan' => 'from-cyan-600/25 to-blue-600/25 border-cyan-500/30 hover:border-cyan-500/60',
        'rose' => 'from-rose-600/25 to-pink-600/25 border-rose-500/30 hover:border-rose-500/60',
    ][$variant] ?? 'from-blue-600/25 to-indigo-600/25 border-blue-500/30 hover:border-blue-500/60';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "group relative px-4 py-2 bg-white/5 border rounded-lg overflow-hidden transition-all duration-300 pointer-events-auto inline-flex items-center justify-center gap-2 {$gradientClasses}"]) }}>
        <div class="absolute inset-0 bg-gradient-to-r {{ $gradientClasses }} opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <span class="relative text-xs md:text-sm font-medium text-white flex items-center gap-2">
            {{ $slot }}
            <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </span>
    </a>
@else
    <button {{ $attributes->merge(['class' => "group relative px-4 py-2 bg-white/5 border rounded-lg overflow-hidden transition-all duration-300 pointer-events-auto inline-flex items-center justify-center gap-2 {$gradientClasses}"]) }}>
        <div class="absolute inset-0 bg-gradient-to-r {{ $gradientClasses }} opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <span class="relative text-xs md:text-sm font-medium text-white flex items-center gap-2">
            {{ $slot }}
            <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </span>
    </button>
@endif
