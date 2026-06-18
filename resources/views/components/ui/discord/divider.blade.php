@props([
    'color' => 'text-slate-550',
])

<div {{ $attributes->merge(['class' => 'flex items-center gap-2 w-full select-none transform-gpu']) }}>
    <div class="flex-1 h-[1px] bg-white/5"></div>
    <span class="text-[7px] md:text-[9px] lg:text-[10px] font-mono {{ $color }} uppercase tracking-widest">{{ $slot }}</span>
    <div class="flex-1 h-[1px] bg-white/5"></div>
</div>
