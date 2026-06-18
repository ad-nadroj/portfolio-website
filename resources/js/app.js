import './bootstrap';

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

import dataPipelineStory from './portfolio/slides/dataPipeline';
import systemArchitectureStory from './portfolio/slides/systemArchitecture';
import agenticFrameworkStory from './portfolio/slides/agenticFramework';

window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

// Register ScrollTrigger globally once
gsap.registerPlugin(ScrollTrigger);

// Make ScrollTrigger use the new scroll container by default
ScrollTrigger.defaults({ 
    scroller: "#scrollytelling-scroll-container"
});

// Normalize scrolling for the custom container to perfectly sync the browser scroll thread 
// with the GSAP main thread. This completely eliminates jittering/snapping on fast scrolls 
// when using pinType: "transform".
ScrollTrigger.normalizeScroll({
    target: "#scrollytelling-scroll-container"
});

document.addEventListener('alpine:init', () => {
    // Register individual slide data functions
    window.Alpine.data('dataPipelineStory', dataPipelineStory);
    window.Alpine.data('systemArchitectureStory', systemArchitectureStory);
    window.Alpine.data('agenticFrameworkStory', agenticFrameworkStory);

    // Register scrollytelling master layout controller
    window.Alpine.data('scrollytellingLayout', () => ({
        activeSlide: 'data-engineering',
        isTransitioning: false,
        progress: 0,
        activeKey: 'ingestion',
        scrollY: 0,
        autoScrollStep: null,
        isAutoPlaying: false,
        lastProgrammaticScroll: undefined,
        showOnboarding: true,

        init() {
            window.addEventListener('keydown', (e) => {
                const activeEl = document.activeElement;
                const isInput = activeEl && (
                    activeEl.tagName === 'INPUT' ||
                    activeEl.tagName === 'TEXTAREA' ||
                    activeEl.tagName === 'SELECT' ||
                    activeEl.isContentEditable
                );

                if (isInput) return;

                if (e.key === ' ' || e.code === 'Space') {
                    e.preventDefault();
                    if (this.showOnboarding) return;
                    this.toggleAutoPlay();
                }
            });

            // Listen for Livewire slide swaps
            window.addEventListener('slide-changed', (e) => {
                const targetSlide = e.detail?.slide || e.detail[0]?.slide || e.detail;
                if (targetSlide) {
                    this.handleSlideChange(targetSlide);
                }
            });

            // Track scroll position dynamically from the container
            const scroller = document.getElementById('scrollytelling-scroll-container');
            if (scroller) {
                scroller.addEventListener('scroll', () => {
                    const currentScroll = Math.round(scroller.scrollTop);
                    this.scrollY = currentScroll;
                    
                    if (this.isAutoPlaying) {
                        if (this.lastProgrammaticScroll === undefined || Math.abs(currentScroll - this.lastProgrammaticScroll) > 2) {
                            this.toggleAutoPlay();
                        }
                    }
                });
            } else {
                window.addEventListener('scroll', () => {
                    const currentScroll = Math.round(window.scrollY);
                    this.scrollY = currentScroll;
                    
                    if (this.isAutoPlaying) {
                        if (this.lastProgrammaticScroll === undefined || Math.abs(currentScroll - this.lastProgrammaticScroll) > 2) {
                            this.toggleAutoPlay();
                        }
                    }
                });
            }
        },

        onStartSlideSwap(detail) {
            const { target, active, wire } = detail;
            if (this.isTransitioning) return;

            // 1. Trigger the loading overlay with contextual text
            this.isTransitioning = true;
            this.loadingText = this.getLoadingText(target);

            // 2. Wait for the overlay transition to fully fade in (300ms)
            setTimeout(() => {
                // 3. Clean up the current slide animations *first* (so scroll reset can happen cleanly)
                window.dispatchEvent(new CustomEvent('slide-deactivate', {
                    detail: { slide: active }
                }));

                // 4. Trigger Livewire component transition to swap the component on the server
                wire.switchTab(target);
            }, 300);
        },

        getLoadingText(slide) {
            switch (slide) {
                case 'data-engineering':
                    return 'Synthesizing CDC Pipeline & dbt Marts...';
                case 'system-architecture':
                    return 'Mapping Local WebDAV & Hybrid Cloud Topologies...';
                case 'agentic-framework':
                    return 'Initializing Multi-Agent Discord Brokerage & Hermes Cycles...';
                default:
                    return 'Syncing System State...';
            }
        },

        handleSlideChange(targetSlide) {
            if (this.activeSlide === targetSlide) return;

            if (this.isAutoPlaying) {
                this.toggleAutoPlay();
            }

            // Dispatch deactivate event to clean up current GSAP animations
            window.dispatchEvent(new CustomEvent('slide-deactivate', {
                detail: { slide: this.activeSlide }
            }));

            this.activeSlide = targetSlide;
            this.progress = 0;
            this.activeKey = targetSlide === 'data-engineering' || targetSlide === 'system-architecture' ? 'ingestion' : 'prompt';

            // Temporarily disable ScrollTrigger to prevent visual scrolls or glitch runs
            if (window.ScrollTrigger) {
                ScrollTrigger.getAll().forEach(st => st.disable(false));
            }

            // Reset page scroll position
            const scroller = document.getElementById('scrollytelling-scroll-container');
            if (scroller) {
                scroller.scrollTop = 0;
            } else {
                window.scrollTo(0, 0);
            }

            this.$nextTick(() => {
                if (window.ScrollTrigger) {
                    ScrollTrigger.getAll().forEach(st => st.enable(false));
                    ScrollTrigger.refresh();
                }

                // Dispatch activate event to initialize GSAP animation for the target slide
                window.dispatchEvent(new CustomEvent('slide-activate', {
                    detail: { slide: targetSlide }
                }));

                setTimeout(() => {
                    if (window.ScrollTrigger) {
                        ScrollTrigger.refresh();
                    }
                    // Hide the transition overlay/loading animation
                    this.isTransitioning = false;
                }, 400); // Wait for transitions to fully settle
            });
        },

        onProgress(detail) {
            this.progress = detail.progress;
            this.activeKey = detail.activeKey;
            
            // update progress bar width directly for smooth UI
            const pb = this.$refs.timelineProgressBar;
            if (pb) {
                pb.style.width = `${(this.progress * 100).toFixed(1)}%`;
            }
        },

        toggleAutoPlay() {
            if (this.isAutoPlaying) {
                if (this.autoScrollStep) {
                    gsap.ticker.remove(this.autoScrollStep);
                    this.autoScrollStep = null;
                }
                this.isAutoPlaying = false;
            } else {
                this.isAutoPlaying = true;
                const scroller = document.getElementById('scrollytelling-scroll-container');
                
                let lastTime = gsap.ticker.time * 1000;
                let exactScroll = scroller ? scroller.scrollTop : window.scrollY;
                this.lastProgrammaticScroll = Math.round(exactScroll);
                const targetDuration = this.activeSlide === 'agentic-framework' ? 30000 : 22000;
                
                this.autoScrollStep = () => {
                    if (!this.isAutoPlaying) return;
                    
                    const currentTime = gsap.ticker.time * 1000;
                    const dt = Math.min(currentTime - lastTime, 50); // cap dt to 50ms to prevent massive jumps
                    lastTime = currentTime;
                    
                    const maxScroll = scroller ? scroller.scrollHeight - scroller.clientHeight : document.documentElement.scrollHeight - window.innerHeight;
                    const speedPerMs = maxScroll / targetDuration;
                    
                    exactScroll += speedPerMs * dt;
                    
                    if (exactScroll >= maxScroll - 2) {
                        this.toggleAutoPlay();
                    } else {
                        if (scroller) {
                            scroller.scrollTop = exactScroll;
                            this.lastProgrammaticScroll = Math.round(scroller.scrollTop);
                        } else {
                            window.scrollTo(0, exactScroll);
                            this.lastProgrammaticScroll = Math.round(window.scrollY);
                        }
                        // Force GSAP ScrollTrigger to update immediately before the next paint
                        // This entirely eliminates the 1-frame pin snapping/jitter issue
                        if (window.ScrollTrigger) {
                            ScrollTrigger.update();
                        }
                    }
                };
                
                gsap.ticker.add(this.autoScrollStep);
            }
        },

        resetScroll() {
            if (this.isAutoPlaying) {
                this.toggleAutoPlay();
            }
            const scroller = document.getElementById('scrollytelling-scroll-container');
            const proxy = { y: scroller ? scroller.scrollTop : window.scrollY };
            gsap.to(proxy, {
                y: 0,
                duration: 0.8,
                ease: 'power2.inOut',
                onUpdate: () => {
                    if (scroller) {
                        scroller.scrollTop = proxy.y;
                    } else {
                        window.scrollTo(0, proxy.y);
                    }
                }
            });
        },

        skipToEnd() {
            if (this.isAutoPlaying) {
                this.toggleAutoPlay();
            }

            const scroller = document.getElementById('scrollytelling-scroll-container');
            const maxScroll = scroller ? scroller.scrollHeight - scroller.clientHeight : document.documentElement.scrollHeight - window.innerHeight;
            const proxy = { y: scroller ? scroller.scrollTop : window.scrollY };
            gsap.to(proxy, {
                y: maxScroll,
                duration: 1.0,
                ease: 'power2.inOut',
                onUpdate: () => {
                    if (scroller) {
                        scroller.scrollTop = proxy.y;
                    } else {
                        window.scrollTo(0, proxy.y);
                    }
                }
            });
        },

        seekToProgress(e) {
            const val = parseFloat(e.target.value);
            this.progress = val;
            window.dispatchEvent(new CustomEvent('scrollytelling-seek', {
                detail: { progress: val }
            }));
        }
    }));

    // Register onboarding overlay controller
    window.Alpine.data('onboardingOverlay', () => ({
        showOverlay: true,
        isDismissing: false,
        entryTimeline: null,
        exitTimeline: null,

        init() {
            // Part A: Play entry animation immediately on DOM ready
            this.$nextTick(() => {
                this.playEntryAnimation();
            });

            // Global listeners for dismissal
            const handleScroll = (e) => {
                if (this.isDismissing) return;
                this.dismiss('scroll');
            };

            const handleKeyDown = (e) => {
                if (this.isDismissing) return;
                if (e.key === ' ' || e.code === 'Space') {
                    e.preventDefault();
                    e.stopPropagation();
                    this.dismiss('space');
                }
            };

            window.addEventListener('wheel', handleScroll, { passive: true });
            window.addEventListener('touchmove', handleScroll, { passive: true });
            window.addEventListener('keydown', handleKeyDown);

            this.cleanup = () => {
                window.removeEventListener('wheel', handleScroll);
                window.removeEventListener('touchmove', handleScroll);
                window.removeEventListener('keydown', handleKeyDown);
            };
        },

        playEntryAnimation() {
            const tl = gsap.timeline();
            this.entryTimeline = tl;

            // Step 1: Fade-in backdrop blur/dark background
            tl.fromTo('#onboarding-overlay', 
                { opacity: 0 }, 
                { opacity: 1, duration: 1.0, ease: 'power2.out' }
            );

            // Step 2: Stagger instructions (Spacebar fades and slides up, Scroll follows 0.5s later)
            tl.fromTo('#onboarding-spacebar-instruction',
                { opacity: 0, y: 15 },
                { opacity: 1, y: 0, duration: 0.8, ease: 'power2.out' },
                '-=0.4'
            );

            tl.fromTo('#onboarding-scroll-instruction',
                { opacity: 0, y: 15 },
                { opacity: 1, y: 0, duration: 0.8, ease: 'power2.out' },
                '-=0.3'
            );

            // Step 3: Fade in down-arrow & start infinite oscillation
            tl.fromTo('#onboarding-down-arrow',
                { opacity: 0, y: -8 },
                { 
                    opacity: 1, 
                    y: 0, 
                    duration: 0.6, 
                    ease: 'power2.out',
                    onComplete: () => {
                        gsap.to('#onboarding-down-arrow', {
                            y: 8,
                            duration: 1.2,
                            repeat: -1,
                            yoyo: true,
                            ease: 'power1.inOut'
                        });
                    }
                },
                '-=0.2'
            );
        },

        dismiss(trigger) {
            this.isDismissing = true;
            this.cleanup();
            this.$dispatch('onboarding-dismissing');

            const tl = gsap.timeline({
                onComplete: () => {
                    this.showOverlay = false;
                    if (trigger === 'space') {
                        // Hand off and start playing
                        this.$dispatch('onboarding-complete-play');
                    } else {
                        // Hand off without starting play
                        this.$dispatch('onboarding-complete-scroll');
                    }
                }
            });
            this.exitTimeline = tl;

            // Step 1: UI dissolve (scale down to 0.95 and fade out instantly)
            tl.to([
                '#onboarding-spacebar-instruction',
                '#onboarding-scroll-instruction',
                '#onboarding-down-arrow'
            ], {
                opacity: 0,
                scale: 0.95,
                duration: 0.2,
                ease: 'power2.in',
                stagger: 0.05
            });

            // Step 2: Curtain lift (translate background upward -100% and fade out)
            tl.to('#onboarding-overlay', {
                y: '-100%',
                opacity: 0,
                duration: 0.6,
                ease: 'power3.inOut'
            }, '-=0.1');
        }
    }));
});
