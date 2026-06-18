@props([
    'variant' => 'slate', // slate, blue, rose, cyan, green, purple
])

@php
    $variantClasses = [
        'slate' => 'bg-white/5 border-white/10 text-slate-300',
        'blue' => 'bg-blue-500/10 border-blue-500/30 text-blue-400',
        'rose' => 'bg-rose-500/10 border-rose-500/30 text-rose-400',
        'cyan' => 'bg-cyan-500/10 border-cyan-500/30 text-cyan-400',
        'green' => 'bg-green-500/10 border-green-500/30 text-green-400',
        'purple' => 'bg-purple-500/10 border-purple-500/30 text-purple-400',
    ][$variant] ?? 'bg-white/5 border-white/10 text-slate-300';
@endphp

<span {{ $attributes->merge(['class' => "px-2 py-1 rounded border text-[10px] lg:text-xs font-mono select-none backdrop-blur-sm transition-all duration-300 hover:scale-105 {$variantClasses}"]) }}>
    {{ $slot }}
</span>
