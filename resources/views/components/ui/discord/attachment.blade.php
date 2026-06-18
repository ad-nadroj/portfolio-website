@props([
    'filename',
    'size',
    'icon' => '📕',
])

<div {{ $attributes->merge(['class' => 'workspace-file flex items-center gap-2 bg-[#2b2d31] border border-[#1e1f22] rounded-lg p-2 hover:bg-[#35373c] transition-colors cursor-pointer select-none']) }}>
    <span class="text-rose-500 text-lg">{{ $icon }}</span>
    <div class="flex flex-col min-w-0 flex-1">
        <span class="text-[8px] md:text-[10px] lg:text-[11px] text-slate-200 font-semibold truncate leading-none">{{ $filename }}</span>
        <span class="text-[6px] md:text-[7px] lg:text-[8px] text-slate-400 mt-1">{{ $size }}</span>
    </div>
    <span class="text-slate-400 hover:text-white text-[10px]">📥</span>
</div>
