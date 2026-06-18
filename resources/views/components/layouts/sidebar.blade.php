@props([
    'appName' => config('app.name', 'Portfolio'),
])

<div 
    x-data="{ isDark: document.documentElement.classList.contains('dark') }"
    class="min-h-dvh bg-zinc-50 dark:bg-zinc-900 lg:flex"
>
    {{-- MOBILE TOP HEADER --}}
    <header class="sticky top-0 z-20 flex items-center justify-between border-b border-zinc-150 bg-white/95 px-4 py-2.5 backdrop-blur dark:border-zinc-900/60 dark:bg-zinc-900/95 lg:hidden">
        <div class="flex items-center gap-2">
            <div class="flex size-7 items-center justify-center rounded-lg bg-zinc-900 text-[10px] font-semibold tracking-wider text-white dark:bg-zinc-100 dark:text-zinc-900">
                P
            </div>
            <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-200">{{ $appName }}</span>
        </div>

        {{-- Mobile Utility Actions --}}
        <div class="flex items-center gap-3">
            {{-- Theme Toggle --}}
            <button 
                type="button"
                @click="Flux.applyAppearance(isDark ? 'light' : 'dark'); isDark = !isDark"
                class="rounded p-1 text-zinc-400 hover:bg-zinc-150 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-indigo-400 cursor-pointer"
                title="Toggle Theme"
            >
                <flux:icon x-show="isDark" name="sun" class="h-4 w-4" />
                <flux:icon x-show="!isDark" name="moon" class="h-4 w-4" />
            </button>
        </div>
    </header>

    {{-- DESKTOP VERTICAL TOOL-DOCK --}}
    <aside class="hidden lg:flex lg:flex-col lg:justify-between lg:items-center lg:w-16 lg:h-screen lg:sticky lg:top-0 lg:border-r lg:border-zinc-150 lg:bg-zinc-50 lg:dark:border-zinc-900/80 lg:dark:bg-zinc-950 lg:py-5 lg:px-2 flex-shrink-0">
        {{-- Top Branding --}}
        <div class="flex flex-col items-center gap-4">
            <div class="flex size-9 items-center justify-center rounded-xl bg-zinc-900 text-xs font-semibold tracking-wider text-white dark:bg-zinc-100 dark:text-zinc-900" title="{{ $appName }}">
                P
            </div>

            {{-- Divider --}}
            <div class="h-px w-6 bg-zinc-200 dark:bg-zinc-800"></div>

            @php
                $isHome = request()->is('/');
            @endphp

            {{-- Home Indicator Link --}}
            <a 
                href="/" 
                class="relative flex size-9 items-center justify-center rounded-lg transition-colors {{ $isHome ? 'bg-zinc-200/50 text-zinc-900 dark:bg-indigo-950/40 dark:text-indigo-400 dark:border dark:border-indigo-900/40' : 'text-zinc-400 hover:bg-zinc-150 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-indigo-400' }}"
                title="Home"
            >
                <flux:icon name="home" class="h-5 w-5" />
            </a>
        </div>

        {{-- Desktop Action Stack --}}
        <div class="flex flex-col items-center gap-3">
            {{-- Theme Switcher Toggle --}}
            <button 
                type="button"
                @click="Flux.applyAppearance(isDark ? 'light' : 'dark'); isDark = !isDark"
                class="flex size-8 items-center justify-center rounded-lg text-zinc-400 hover:bg-zinc-150 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-indigo-400 transition-colors cursor-pointer"
                title="Toggle Theme"
            >
                <flux:icon x-show="isDark" name="sun" class="h-4.5 w-4.5" />
                <flux:icon x-show="!isDark" name="moon" class="h-4.5 w-4.5" />
            </button>
        </div>
    </aside>

    {{-- MAIN CANVAS AREA --}}
    <main class="min-h-dvh min-w-0 flex-1 bg-white dark:bg-zinc-900">
        <div class="flex min-h-dvh w-full max-w-none flex-col px-4 py-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>
</div>
