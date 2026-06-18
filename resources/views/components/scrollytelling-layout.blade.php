<div x-data="scrollytellingLayout()" 
    @scrollytelling-progress.window="onProgress($event.detail)"
    @start-slide-swap.window="onStartSlideSwap($event.detail)"
    @onboarding-complete-play.window="showOnboarding = false; if (!isAutoPlaying) { toggleAutoPlay(); }"
    @onboarding-complete-scroll.window="showOnboarding = false"
    class="relative w-full h-full bg-[#0a0f1c] text-white selection:bg-blue-500 selection:text-white font-sans overflow-hidden flex flex-col">

    <!-- Slide Fade Transition Overlay & Futuristic Loading Animation -->
    <div x-show="isTransitioning" 
        x-transition:enter="transition-opacity duration-300 ease-out"
        x-transition:enter-start="opacity-0" 
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-300 ease-in" 
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" 
        class="fixed inset-0 bg-[#0a0f1c] z-[990] flex flex-col items-center justify-center select-none"
        style="display: none;">
        
        <div class="flex flex-col items-center gap-6">
            <!-- Loader Graphic -->
            <div class="relative w-20 h-20 flex items-center justify-center">
                <!-- Pulsing Outer Glow ring -->
                <div class="absolute inset-0 rounded-full bg-blue-500/10 blur-xl animate-pulse"></div>
                
                <!-- Spinning Core Segment -->
                <div class="w-16 h-16 rounded-full border-2 border-slate-800 border-t-blue-500 animate-spin"></div>
                
                <!-- Reverse Spinning Dash Ring -->
                <div class="absolute w-12 h-12 rounded-full border border-dashed border-indigo-400/40 animate-reverse-spin"></div>
                
                <!-- Pulsing Center Core -->
                <div class="absolute w-4 h-4 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_12px_rgba(34,211,238,0.8)]"></div>
            </div>
        </div>
    </div>

    <div id="scrollytelling-scroll-container" 
        :class="showOnboarding ? 'overflow-y-hidden pointer-events-none' : 'overflow-y-auto'"
        :style="showOnboarding ? 'opacity: 0;' : 'opacity: 1; transition: opacity 0.6s ease-out;'"
        style="opacity: 0;"
        class="flex-1 min-h-0 overflow-x-hidden relative w-full">

        <!-- Background Grid / Glow -->
        <div class="fixed inset-0 z-0 pointer-events-none"
            style="background-image: radial-gradient(circle at 50% 50%, rgba(30, 58, 138, 0.15) 0%, transparent 60%);">
            <div
                class="fixed inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAwIDEwIEwgNDAgMTAgTSAxMCAwIEwgMTAgNDAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] [mask-image:linear-gradient(to_bottom,transparent,black,transparent)]">
            </div>
        </div>

        <!-- Main Content Container -->
        <div id="scrollytelling-canvas" x-ref="canvas"
            class="relative z-10 min-h-full w-full flex flex-col items-center justify-start overflow-hidden">
            {{ $slot }}

            <!-- Timeline Navigator -->
            <div class="timeline-container">
                <!-- Downward Skip Button -->
                <button @click="skipToEnd()" class="timeline-skip-down-btn" title="Skip to End of Story"
                    aria-label="Skip to End of Story">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z" />
                    </svg>
                </button>

                <nav class="timeline-nav" x-ref="timelineNav" aria-label="Animation timeline">
                    <div class="timeline-progress-track">
                        <div class="timeline-progress-bar" x-ref="timelineProgressBar"></div>
                    </div>
                    <div class="timeline-nav-inner">
                        <div @click="toggleAutoPlay()" class="timeline-play-pause-btn"
                            :class="{ 'is-playing': isAutoPlaying }"
                            :title="isAutoPlaying ? 'Pause Auto-Scroll' : 'Play Auto-Scroll'"
                            :aria-label="isAutoPlaying ? 'Pause Auto-Scroll' : 'Play Auto-Scroll'" role="button"
                            tabindex="0">
                            <svg x-show="!isAutoPlaying" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                            <svg x-show="isAutoPlaying" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
                            </svg>
                        </div>
                        <div class="timeline-divider"></div>

                        {{ $timeline ?? '' }}
                    </div>
                </nav>
            </div>
        </div>

    </div>

    <!-- Onboarding Overlay -->
    <div x-data="onboardingOverlay()" 
         x-show="showOverlay"
         id="onboarding-overlay"
         class="fixed inset-0 z-[1000] flex flex-col items-center justify-center bg-[#070b13]/90 backdrop-blur-xl select-none"
         style="opacity: 0;">
         
         <div class="flex flex-col items-center gap-12 md:gap-16 text-center max-w-3xl px-6">
             <!-- Instructions Container -->
             <div class="flex flex-col md:flex-row gap-12 md:gap-20 items-center justify-center">
                 <!-- Instruction 1: Playback -->
                 <div id="onboarding-spacebar-instruction" style="opacity: 0;" class="flex items-center gap-5 group text-left">
                     <div class="flex-shrink-0 flex items-center justify-center w-24 h-10 rounded-lg border border-white/10 bg-white/5 backdrop-blur-md group-hover:border-cyan-400/50 group-hover:bg-cyan-500/10 transition-all duration-300 shadow-[0_0_15px_rgba(0,0,0,0.2)]">
                         <span class="text-[10px] font-mono tracking-widest text-slate-400 group-hover:text-cyan-400 transition-colors uppercase font-bold">Space</span>
                     </div>
                     <div>
                         <span class="text-[9px] uppercase tracking-widest text-slate-500 font-mono block">Control</span>
                         <p class="text-sm md:text-base font-light text-slate-300 group-hover:text-white transition-colors duration-300">
                             Press <span class="font-semibold text-cyan-400">Space</span> to play or pause the experience.
                         </p>
                     </div>
                 </div>

                 <!-- Instruction 2: Navigation -->
                 <div id="onboarding-scroll-instruction" style="opacity: 0;" class="flex items-center gap-5 group text-left">
                     <div class="flex-shrink-0 flex items-center justify-center w-24 h-10 rounded-lg border border-white/10 bg-white/5 backdrop-blur-md group-hover:border-cyan-400/50 group-hover:bg-cyan-500/10 transition-all duration-300 shadow-[0_0_15px_rgba(0,0,0,0.2)]">
                         <svg class="w-4 h-6" viewBox="0 0 24 36" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
                             <rect x="2" y="2" width="20" height="32" rx="10" class="stroke-slate-400 group-hover:stroke-cyan-400 transition-colors" />
                             <line x1="12" y1="8" x2="12" y2="14" class="stroke-slate-400 group-hover:stroke-cyan-400" stroke-linecap="round" stroke-width="2" />
                         </svg>
                     </div>
                     <div>
                         <span class="text-[9px] uppercase tracking-widest text-slate-500 font-mono block">Navigation</span>
                         <p class="text-sm md:text-base font-light text-slate-300 group-hover:text-white transition-colors duration-300">
                             Scroll to advance or rewind the timeline.
                         </p>
                     </div>
                 </div>
             </div>

             <!-- Subtle Chevron Prompt -->
             <div id="onboarding-down-arrow" style="opacity: 0;" class="absolute bottom-12 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-slate-500">
                 <span class="text-[9px] uppercase tracking-widest font-mono">Enter Experience</span>
                 <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                 </svg>
             </div>
         </div>
    </div>
</div>
