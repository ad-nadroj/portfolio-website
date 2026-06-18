@props([
    'title',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-3 md:gap-4 bg-slate-900/80 border border-white/10 rounded-2xl p-4 md:p-5 backdrop-blur-xl shadow-2xl transition-all duration-500 hover:border-blue-500/30']) }}>
    <div class="border-b border-white/10 pb-2.5 md:pb-3 text-center">
        <h3 class="text-base lg:text-lg font-semibold text-white tracking-wide bg-gradient-to-r from-white via-slate-100 to-slate-400 bg-clip-text text-transparent">
            {{ $title }}
        </h3>
        @if ($description)
            <p class="text-xs lg:text-sm text-slate-400 mt-1.5 font-light leading-relaxed">
                {{ $description }}
            </p>
        @endif
    </div>

    {{ $slot }}
</div>
