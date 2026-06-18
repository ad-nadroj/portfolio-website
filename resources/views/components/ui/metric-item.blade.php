@props([
    'label',
    'value',
    'variant' => 'cyan', // cyan, blue, rose, slate
])

@php
    $labelClasses = [
        'cyan' => 'text-cyan-400',
        'blue' => 'text-blue-400',
        'rose' => 'text-rose-400',
        'slate' => 'text-slate-400',
    ][$variant] ?? 'text-slate-400';
@endphp

<div {{ $attributes->merge(['class' => 'bg-slate-800/50 border border-slate-700/30 rounded-xl p-2.5 md:p-3 backdrop-blur-md text-center transition-all duration-300 hover:border-white/10 hover:bg-slate-800/70']) }}>
    <div class="text-[9px] md:text-[10px] font-mono uppercase tracking-widest mb-0.5 {{ $labelClasses }}">
        {{ $label }}
    </div>
    <div class="text-white font-medium text-xs md:text-sm">
        {{ $value }}
    </div>
</div>
