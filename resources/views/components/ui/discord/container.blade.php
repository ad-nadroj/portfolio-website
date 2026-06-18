@props([
    'channel' => 'research-swarm',
    'status' => 'ACTIVE',
    'statusColor' => 'emerald', // emerald, purple
    'gap' => 'gap-4',
])

@php
    $dotColors = [
        'emerald' => 'bg-emerald-500 shadow-[0_0_6px_rgba(16,185,129,0.8)]',
        'purple' => 'bg-purple-500 shadow-[0_0_6px_rgba(168,85,247,0.8)]',
    ][$statusColor] ?? 'bg-emerald-500 shadow-[0_0_6px_rgba(16,185,129,0.8)]';

    $textColors = [
        'emerald' => 'text-emerald-400/80',
        'purple' => 'text-purple-400/80',
    ][$statusColor] ?? 'text-emerald-400/80';

    $classString = $attributes->get('class', '');
    $hasPosition = str_contains($classString, 'absolute') || 
                   str_contains($classString, 'relative') || 
                   str_contains($classString, 'fixed') || 
                   str_contains($classString, 'static');
    $positionClass = $hasPosition ? '' : 'relative';
@endphp

<div {{ $attributes->merge(['class' => "$positionClass border border-white/10 rounded-2xl bg-[#313338] shadow-[0_8px_32px_rgba(0,0,0,0.3)] overflow-hidden flex flex-col font-sans transform-gpu"]) }}>
    <!-- Discord Title / Channel Header -->
    <div class="h-10 lg:h-11 border-b border-[#1f2023] bg-[#313338] px-4 flex items-center gap-2 select-none shrink-0">
        <span class="text-slate-400 text-lg">#</span>
        <span class="text-[11px] md:text-xs lg:text-sm font-bold text-white tracking-wide">{{ $channel }}</span>
        <div class="w-1.5 h-1.5 rounded-full {{ $dotColors }} ml-auto"></div>
        <span class="text-[8px] md:text-[9px] lg:text-[10px] font-mono {{ $textColors }} tracking-wider">{{ $status }}</span>
    </div>
    
    <!-- Chat logs -->
    <div class="discord-chat flex-1 p-3 md:p-4 flex flex-col justify-end {{ $gap }} overflow-hidden text-left relative z-10 transform-gpu">
        {{ $slot }}
    </div>
</div>
