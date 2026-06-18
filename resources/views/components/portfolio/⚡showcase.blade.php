<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    public string $activeSlide = 'data-engineering';

    public function switchTab(string $tab)
    {
        $this->activeSlide = $tab;
        $this->dispatch('slide-changed', slide: $tab);
    }
};
?>

<div x-data="{ transitioning: false, showOnboarding: true }"
     @start-slide-swap.window="transitioning = true"
     @slide-changed.window="setTimeout(() => transitioning = false, 400)"
     @onboarding-dismissing.window="showOnboarding = false"
     class="flex flex-col w-full h-full relative text-white font-sans overflow-hidden">
    <!-- Top Branded Premium Navigation Header -->
    <header
        :style="showOnboarding ? 'opacity: 0; pointer-events: none;' : 'opacity: 1; transition: opacity 0.6s ease-out;'"
        style="opacity: 0;"
        class="shrink-0 relative z-[1000] h-16 bg-slate-950/70 border-b border-white/5 backdrop-blur-md px-6 flex items-center justify-between font-sans select-none">
        <div class="flex items-center gap-3">
            <span class="text-white font-semibold tracking-wider text-sm uppercase">Portfolio</span>
        </div>
        <nav class="flex items-center gap-4 md:gap-8 transition-opacity duration-300" :class="{ 'pointer-events-none opacity-60': transitioning }">
            <button @click="if ('{{ $activeSlide }}' !== 'data-engineering') { $dispatch('start-slide-swap', { target: 'data-engineering', active: '{{ $activeSlide }}', wire: $wire }); }"
                class="text-[10px] md:text-xs font-mono tracking-widest uppercase transition-colors cursor-pointer focus:outline-none"
                @class([
                    'text-blue-400 font-bold' => $activeSlide === 'data-engineering',
                    'text-slate-400 hover:text-white' => $activeSlide !== 'data-engineering',
                ])>
                Data Engineering
            </button>
            <button @click="if ('{{ $activeSlide }}' !== 'system-architecture') { $dispatch('start-slide-swap', { target: 'system-architecture', active: '{{ $activeSlide }}', wire: $wire }); }"
                class="text-[10px] md:text-xs font-mono tracking-widest uppercase transition-colors cursor-pointer focus:outline-none"
                @class([
                    'text-indigo-400 font-bold' => $activeSlide === 'system-architecture',
                    'text-slate-400 hover:text-white' => $activeSlide !== 'system-architecture',
                ])>
                Architecture
            </button>
            <button @click="if ('{{ $activeSlide }}' !== 'agentic-framework') { $dispatch('start-slide-swap', { target: 'agentic-framework', active: '{{ $activeSlide }}', wire: $wire }); }"
                class="text-[10px] md:text-xs font-mono tracking-widest uppercase transition-colors cursor-pointer focus:outline-none"
                @class([
                    'text-rose-400 font-bold' => $activeSlide === 'agentic-framework',
                    'text-slate-400 hover:text-white' => $activeSlide !== 'agentic-framework',
                ])>
                Agentic Systems
            </button>
        </nav>
        <div class="flex items-center gap-4">
        </div>
    </header>

    <!-- Content area swaps out slides based on active tab -->
    <div class="flex-1 relative min-h-0">
        <x-scrollytelling-layout>
            <x-slot:timeline>
                @if ($activeSlide === 'data-engineering')
                    <div class="contents">
                        <!-- Segment 1: Ingestion -->
                        <button class="timeline-segment is-active" data-segment="ingestion"
                            @click="$dispatch('scrollytelling-seek-segment', { segment: 'ingestion' })"
                            id="timeline-seg-ingestion" aria-label="Jump to Real-time Ingestion phase">
                            <div class="timeline-segment-fill"></div>
                            <span class="timeline-dot"></span>
                            <span class="timeline-label">Ingestion</span>
                        </button>
                        <div class="timeline-divider"></div>
                        <!-- Segment 2: Transformation -->
                        <button class="timeline-segment" data-segment="transformation"
                            @click="$dispatch('scrollytelling-seek-segment', { segment: 'transformation' })"
                            id="timeline-seg-transformation" aria-label="Jump to Streaming Transformation phase">
                            <div class="timeline-segment-fill"></div>
                            <span class="timeline-dot"></span>
                            <span class="timeline-label">Transform</span>
                        </button>
                        <div class="timeline-divider"></div>
                        <!-- Segment 3: Output -->
                        <button class="timeline-segment" data-segment="output"
                            @click="$dispatch('scrollytelling-seek-segment', { segment: 'output' })"
                            id="timeline-seg-output" aria-label="Jump to Structured Output phase">
                            <div class="timeline-segment-fill"></div>
                            <span class="timeline-dot"></span>
                            <span class="timeline-label">Output</span>
                        </button>
                    </div>
                @elseif ($activeSlide === 'system-architecture')
                    <div class="contents">
                        <!-- Segment 1: Ingestion -->
                        <button class="timeline-segment is-active" data-segment="ingestion"
                            @click="$dispatch('scrollytelling-seek-segment', { segment: 'ingestion' })"
                            id="timeline-seg-sa-ingestion" aria-label="Jump to Edge Capture phase">
                            <div class="timeline-segment-fill"></div>
                            <span class="timeline-dot"></span>
                            <span class="timeline-label">Ingestion</span>
                        </button>
                        <div class="timeline-divider"></div>
                        <!-- Segment 2: Verification -->
                        <button class="timeline-segment" data-segment="verification"
                            @click="$dispatch('scrollytelling-seek-segment', { segment: 'verification' })"
                            id="timeline-seg-sa-verification" aria-label="Jump to OCR & Verification phase">
                            <div class="timeline-segment-fill"></div>
                            <span class="timeline-dot"></span>
                            <span class="timeline-label">Verification</span>
                        </button>
                        <div class="timeline-divider"></div>
                        <!-- Segment 3: Sync -->
                        <button class="timeline-segment" data-segment="sync"
                            @click="$dispatch('scrollytelling-seek-segment', { segment: 'sync' })"
                            id="timeline-seg-sa-sync" aria-label="Jump to Cloud Synchronization phase">
                            <div class="timeline-segment-fill"></div>
                            <span class="timeline-dot"></span>
                            <span class="timeline-label">Sync</span>
                        </button>
                    </div>
                @elseif ($activeSlide === 'agentic-framework')
                    <div class="contents">
                        <!-- Segment 1: Prompt -->
                        <button class="timeline-segment is-active" data-segment="prompt"
                            @click="$dispatch('scrollytelling-seek-segment', { segment: 'prompt' })"
                            id="timeline-seg-af-prompt" aria-label="Jump to Discord Gateway Brokerage phase">
                            <div class="timeline-segment-fill"></div>
                            <span class="timeline-dot"></span>
                            <span class="timeline-label">Brokerage</span>
                        </button>
                        <div class="timeline-divider"></div>
                        <!-- Segment 2: Reason -->
                        <button class="timeline-segment" data-segment="reason"
                            @click="$dispatch('scrollytelling-seek-segment', { segment: 'reason' })"
                            id="timeline-seg-af-reason" aria-label="Jump to Async Task Offloading phase">
                            <div class="timeline-segment-fill"></div>
                            <span class="timeline-dot"></span>
                            <span class="timeline-label">Offloading</span>
                        </button>
                        <div class="timeline-divider"></div>
                        <!-- Segment 3: Action -->
                        <button class="timeline-segment" data-segment="action"
                            @click="$dispatch('scrollytelling-seek-segment', { segment: 'action' })"
                            id="timeline-seg-af-action" aria-label="Jump to Hermes Callback Cycle phase">
                            <div class="timeline-segment-fill"></div>
                            <span class="timeline-dot"></span>
                            <span class="timeline-label">Callback</span>
                        </button>
                    </div>
                @endif
            </x-slot:timeline>

            <div wire:key="slide-{{ $activeSlide }}" class="w-full h-full">
                @if ($activeSlide === 'data-engineering')
                    <livewire:portfolio.slides.data-engineering-slide />
                @elseif ($activeSlide === 'system-architecture')
                    <livewire:portfolio.slides.system-architecture-slide />
                @elseif ($activeSlide === 'agentic-framework')
                    <livewire:portfolio.slides.agentic-framework-slide />
                @endif
            </div>
        </x-scrollytelling-layout>
    </div>
</div>