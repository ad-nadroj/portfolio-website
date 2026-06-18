@props([
    'author',
    'avatar',
    'avatarBg' => 'bg-indigo-600',
    'authorColor' => 'text-white',
    'time',
    'isBot' => false,
])

<div {{ $attributes->merge(['class' => 'flex gap-3 items-start transform-gpu']) }}>
    <!-- Avatar -->
    <div class="w-7 h-7 lg:w-8 lg:h-8 rounded-full {{ $avatarBg }} flex items-center justify-center text-white text-[10px] md:text-xs font-bold shrink-0 shadow-md select-none">
        {{ $avatar }}
    </div>
    <div class="flex flex-col gap-0.5 min-w-0 flex-1">
        <div class="flex items-baseline gap-2">
            <span class="text-[10px] md:text-xs lg:text-sm font-bold {{ $authorColor }} hover:underline cursor-pointer select-none">{{ $author }}</span>
            @if ($isBot)
                <span class="bg-[#5865f2] text-white text-[6px] md:text-[7px] lg:text-[8px] font-extrabold px-1 py-0.5 rounded leading-none select-none">BOT</span>
            @endif
            <span class="text-[7px] md:text-[8px] lg:text-[9px] text-slate-450 select-none">{{ $time }}</span>
        </div>
        <div class="text-[9px] md:text-[11px] lg:text-xs text-[#dbdee1] leading-relaxed break-words font-light">
            {{ $slot }}
        </div>
    </div>
</div>
