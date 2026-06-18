@props([
    'title',
    'borderColor' => 'border-[#f43f5e]',
])

<div {{ $attributes->merge(['class' => "border-l-4 {$borderColor} bg-[#2b2d31] rounded-r p-2.5 space-y-1.5 text-[8px] md:text-[10px] lg:text-[11px] text-[#dbdee1] font-light leading-relaxed max-w-full"]) }}>
    <div class="font-semibold text-white text-[9px] md:text-[11px] lg:text-xs">{{ $title }}</div>
    {{ $slot }}
</div>
