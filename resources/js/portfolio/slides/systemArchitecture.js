import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

export default function systemArchitectureStory() {
    let masterTimeline = null;
    let initialized = false;
    let mm = null;
    let segments = null;
    const SEGMENT_KEYS = ['ingestion', 'verification', 'sync'];
    let navElements = null;
    let deactivateHandler = null;
    let pulseTweens = [];
    let scannerTween = null;

    function resolveNavElements(canvas) {
        const nav = canvas.closest('[x-data]')?.querySelector('.timeline-nav');
        if (!nav) return null;
        return {
            progressBar: nav.querySelector('.timeline-progress-bar'),
            segments: Array.from(nav.querySelectorAll('.timeline-segment')),
            fills: Array.from(nav.querySelectorAll('.timeline-segment-fill'))
        };
    }

    function updateTimelineNav(progress) {
        if (!navElements || !segments) return;

        let activeKey = 'ingestion';
        if (segments.sync && progress >= segments.sync.start) {
            activeKey = 'sync';
        } else if (segments.verification && progress >= segments.verification.start) {
            activeKey = 'verification';
        }

        // Dispatch progress to window (scrollY layout read removed to prevent layout thrashing)
        window.dispatchEvent(new CustomEvent('scrollytelling-progress', {
            detail: {
                progress: progress,
                activeKey: activeKey
            }
        }));

        navElements.segments.forEach((seg, i) => {
            const key = seg.dataset.segment;
            const bounds = segments[key];
            if (!bounds) return;
            const isActive = key === activeKey;

            seg.classList.toggle('is-active', isActive);

            let fill = 0;
            if (progress >= bounds.end) {
                fill = 1;
            } else if (progress > bounds.start) {
                fill = (progress - bounds.start) / (bounds.end - bounds.start);
            }

            if (navElements.fills[i]) {
                gsap.set(navElements.fills[i], { scaleX: fill });
            }
        });
    }

    return {
        seekHandler: null,

        initAnimation() {
            if (initialized) return;
            initialized = true;

            this.$nextTick(() => {
                const canvas = document.getElementById('scrollytelling-canvas');
                if (!canvas) return;
                const slideRoot = this.$el;

                const scanner = slideRoot.querySelector('.scanner-device');
                const queueItems = gsap.utils.toArray('.receipt-item', slideRoot);
                const travellingReceipt = slideRoot.querySelector('#travelling-receipt');
                
                const ocrBlock = slideRoot.querySelector('#ocr-block');
                const ocrScan = slideRoot.querySelector('.ocr-scan-line');
                const ocrIcon = slideRoot.querySelector('.ocr-icon');
                
                const verifierBlock = slideRoot.querySelector('#verifier-block');
                const verifierGlow = slideRoot.querySelector('.verifier-glow');
                const verifierBorder = slideRoot.querySelector('.verifier-border');
                const verifierStatus = slideRoot.querySelector('.verifier-status-label');
                
                const cloudContainer = slideRoot.querySelector('#cloud-container');
                const spendBar = slideRoot.querySelector('.spend-bar');
                const paidBar = slideRoot.querySelector('.paid-bar');
                
                const techBadge1 = slideRoot.querySelector('.tech-badge-1');
                const techBadge2 = slideRoot.querySelector('.tech-badge-2');
                const techBadge3 = slideRoot.querySelector('.tech-badge-3');
                
                const intelligencePanel = slideRoot.querySelector('[x-ref="intelligencePanel"]');
                const narrativeTexts = gsap.utils.toArray('.narrative-text', slideRoot);
                
                const flowGroup1 = slideRoot.querySelectorAll('.flow-path-1, .flow-pulse-1');
                const flowGroup2 = gsap.utils.toArray('.flow-path-2, .flow-pulse-2', slideRoot);
                const flowGroup1Mobile = slideRoot.querySelectorAll('.flow-path-1-mobile, .flow-pulse-1-mobile');
                const flowGroup2Mobile = gsap.utils.toArray('.flow-path-2-mobile, .flow-pulse-2-mobile', slideRoot);
                const pulse1 = slideRoot.querySelector('.flow-pulse-1');
                const pulse2 = slideRoot.querySelector('.flow-pulse-2');
                const pulse1Mobile = slideRoot.querySelector('.flow-pulse-1-mobile');
                const pulse2Mobile = slideRoot.querySelector('.flow-pulse-2-mobile');

                // Ambient animations
                if (pulse1) { pulseTweens.push(gsap.to(pulse1, { strokeDashoffset: -100, duration: 3, repeat: -1, ease: "none" })); }
                if (pulse2) { pulseTweens.push(gsap.to(pulse2, { strokeDashoffset: -100, duration: 3, repeat: -1, ease: "none" })); }
                if (pulse1Mobile) { pulseTweens.push(gsap.to(pulse1Mobile, { strokeDashoffset: -100, duration: 3, repeat: -1, ease: "none" })); }
                if (pulse2Mobile) { pulseTweens.push(gsap.to(pulse2Mobile, { strokeDashoffset: -100, duration: 3, repeat: -1, ease: "none" })); }

                // Scanner ambient hover
                if (scanner) {
                    scannerTween = gsap.to(scanner, {
                        y: "-=4",
                        duration: 2,
                        repeat: -1,
                        yoyo: true,
                        ease: "sine.inOut"
                    });
                }

                mm = gsap.matchMedia();

                mm.add({
                    isDesktop: "(min-width: 768px)",
                    isMobile: "(max-width: 767px)",
                    reduceMotion: "(prefers-reduced-motion: reduce)"
                }, (context) => {
                    const { isDesktop, isMobile, reduceMotion } = context.conditions;

                    const timeline = gsap.timeline({
                        scrollTrigger: {
                            trigger: canvas,
                            scroller: "#scrollytelling-scroll-container",
                            pin: true,
                            start: "top top",
                            end: () => "+=" + (window.innerHeight * 1.5),
                            scrub: 0.8,
                            markers: false,
                            fastScrollEnd: true,
                            invalidateOnRefresh: true,
                            onUpdate: (self) => {
                                updateTimelineNav(self.progress);
                            }
                        }
                    });

                    timeline.addLabel('ingestion', 0);
                    timeline.addLabel('verification', 1.5);
                    timeline.addLabel('sync', 2.5);

                    // Act 1: edge capture and receipts queueing
                    timeline.to(queueItems, {
                        opacity: 1,
                        x: 0,
                        stagger: reduceMotion ? 0 : 0.25,
                        duration: reduceMotion ? 0 : 0.8,
                        ease: "back.out(1.5)"
                    }, 0);

                    if (techBadge1) {
                        timeline.to(techBadge1, { opacity: 1, y: -5, duration: reduceMotion ? 0 : 0.5 }, 0.3);
                    }

                    // Act 2: Python OCR & Laravel validation hold
                    // Fade in travelling receipt
                    timeline.to(travellingReceipt, {
                        opacity: 1,
                        x: isDesktop ? 220 : 0,
                        y: isDesktop ? 0 : 120,
                        scale: 1,
                        duration: reduceMotion ? 0 : 0.8,
                        ease: "power2.inOut"
                    }, 0.8);

                    // Drop receipt into Python OCR block
                    timeline.to(travellingReceipt, {
                        x: isDesktop ? 350 : 0,
                        y: isDesktop ? -80 : 180,
                        scale: 0.8,
                        duration: reduceMotion ? 0 : 0.5,
                        ease: "power2.in"
                    }, 1.2);

                    // Python OCR scan sweeps
                    timeline.to(ocrScan, {
                        opacity: 1,
                        y: 70,
                        duration: reduceMotion ? 0 : 0.4,
                        repeat: reduceMotion ? 0 : 2,
                        yoyo: true,
                        ease: "none"
                    }, 1.3)
                    .to(ocrIcon, {
                        rotation: reduceMotion ? 0 : 180,
                        scale: 1.15,
                        duration: reduceMotion ? 0 : 0.8,
                        yoyo: true,
                        repeat: 1
                    }, 1.3);

                    // Move receipt to Laravel verifier gate
                    timeline.to(travellingReceipt, {
                        y: isDesktop ? 80 : 280,
                        duration: reduceMotion ? 0 : 0.5,
                        ease: "power2.inOut"
                    }, 1.8);

                    // Verification validation lock
                    timeline.to(verifierGlow, { opacity: 1, duration: reduceMotion ? 0 : 0.4 }, 2.0)
                            .to(verifierBorder, { opacity: 1, duration: reduceMotion ? 0 : 0.4 }, 2.0)
                            .to(verifierStatus, { opacity: 1, scale: 1.1, duration: reduceMotion ? 0 : 0.5 }, 2.0);

                    // Archive receipt (fade out card)
                    timeline.to(travellingReceipt, {
                        opacity: 0,
                        scale: 0.5,
                        x: isDesktop ? 450 : 0,
                        duration: reduceMotion ? 0 : 0.5
                    }, 2.2);

                    if (techBadge2) {
                        timeline.to(techBadge2, { opacity: 1, y: -5, duration: reduceMotion ? 0 : 0.5 }, 1.5);
                    }

                    // Act 2 narrative text transition
                    timeline.to(narrativeTexts[0], { opacity: 0, y: -20, duration: reduceMotion ? 0 : 0.5 }, 0.8)
                            .to(narrativeTexts[1], { opacity: 1, y: 0, duration: reduceMotion ? 0 : 0.5 }, 1);

                    // Act 3: Cloud Synchronization
                    timeline.to(narrativeTexts[1], { opacity: 0, y: -20, duration: reduceMotion ? 0 : 0.5 }, 2.0)
                            .to(narrativeTexts[2], { opacity: 1, y: 0, duration: reduceMotion ? 0 : 0.5 }, 2.2);

                    if (isDesktop) {
                        const shiftDistance = () => -(canvas.clientWidth * 0.28);

                        timeline.to(slideRoot.querySelector('[x-ref="scannerContainer"]'), {
                            x: -100,
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.8,
                            ease: "power2.inOut"
                        }, 1.8)
                        .to(flowGroup1, {
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.5
                        }, 1.8)
                        .to([slideRoot.querySelector('[x-ref="engineContainer"]'), cloudContainer, ...flowGroup2], {
                            x: shiftDistance,
                            duration: reduceMotion ? 0 : 1.2,
                            ease: "power3.inOut"
                        }, 1.8);

                        // Position & fade in intelligence panel (slide from right)
                        gsap.set(intelligencePanel, { x: 48, y: 0, yPercent: -50, opacity: 0 });
                        timeline.to(intelligencePanel, {
                            opacity: 1,
                            x: 0,
                            yPercent: -50,
                            duration: reduceMotion ? 0 : 1,
                            ease: "power2.out"
                        }, 2.5);

                    } else if (isMobile) {
                        timeline.to(slideRoot.querySelector('[x-ref="scannerContainer"]'), {
                            y: -80,
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.8,
                            ease: "power2.inOut"
                        }, 1.8)
                        .to(flowGroup1Mobile, {
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.5
                        }, 1.8)
                        .to([slideRoot.querySelector('[x-ref="engineContainer"]'), cloudContainer, ...flowGroup2Mobile], {
                            y: () => -(canvas.clientHeight * 0.18),
                            duration: reduceMotion ? 0 : 1.2,
                            ease: "power3.inOut"
                        }, 1.8);

                        // Position & fade in intelligence panel (slide from bottom)
                        gsap.set(intelligencePanel, { x: 0, y: 32, yPercent: 0, opacity: 0 });
                        timeline.to(intelligencePanel, {
                            opacity: 1,
                            y: 0,
                            yPercent: 0,
                            duration: reduceMotion ? 0 : 1,
                            ease: "power2.out"
                        }, 2.5);
                    }

                    // Reveal Cloud Sync Dashboard & Bars
                    timeline.to(cloudContainer, { opacity: 1, duration: reduceMotion ? 0 : 0.6 }, 1.8)
                           .to(spendBar, { scaleX: 1, duration: reduceMotion ? 0 : 1.2, ease: "expo.out" }, 2.1)
                           .to(paidBar, { scaleX: 1, duration: reduceMotion ? 0 : 1.2, ease: "expo.out" }, 2.3);

                    if (techBadge3) {
                        timeline.to(techBadge3, { opacity: 1, y: -5, duration: reduceMotion ? 0 : 0.5 }, 2.2);
                    }

                    masterTimeline = timeline;

                    const totalDur = timeline.duration();
                    if (totalDur > 0) {
                        const labelTimes = SEGMENT_KEYS.map(k => {
                            const t = timeline.labels[k];
                            return t !== undefined ? t : 0;
                        });
                        segments = {};
                        for (let i = 0; i < SEGMENT_KEYS.length; i++) {
                            const start = labelTimes[i] / totalDur;
                            const end = i < SEGMENT_KEYS.length - 1 ? labelTimes[i + 1] / totalDur : 1.0;
                            segments[SEGMENT_KEYS[i]] = { start, end };
                        }
                    }

                    navElements = resolveNavElements(canvas);
                    ScrollTrigger.refresh();
                    setTimeout(() => {
                        if (window.ScrollTrigger) {
                            ScrollTrigger.refresh();
                        }
                    }, 400);
                });
            });

            this.seekHandler = (e) => {
                const progress = e.detail.progress;
                if (masterTimeline && masterTimeline.scrollTrigger) {
                    const st = masterTimeline.scrollTrigger;
                    const scrollStart = st.start;
                    const scrollEnd = st.end;
                    const targetScroll = scrollStart + progress * (scrollEnd - scrollStart);
                    const scroller = document.getElementById('scrollytelling-scroll-container');
                    if (scroller) {
                        scroller.scrollTop = targetScroll;
                    } else {
                        window.scrollTo(0, targetScroll);
                    }
                }
            };
            window.addEventListener('scrollytelling-seek', this.seekHandler);

            this.seekSegmentHandler = (e) => {
                if (e.detail && e.detail.segment) {
                    this.seekTo(e.detail.segment);
                }
            };
            window.addEventListener('scrollytelling-seek-segment', this.seekSegmentHandler);

            deactivateHandler = (e) => {
                const targetSlide = e.detail?.slide || e.detail[0]?.slide || e.detail;
                if (targetSlide === 'system-architecture') {
                    this.destroy();
                }
            };
            window.addEventListener('slide-deactivate', deactivateHandler);
        },

        seekTo(segmentKey) {
            if (!masterTimeline || !masterTimeline.scrollTrigger || !segments) return;

            const st = masterTimeline.scrollTrigger;
            const bounds = segments[segmentKey];
            if (!bounds) return;

            let targetProgress;
            if (segmentKey === 'ingestion') {
                targetProgress = bounds.start;
            } else if (segmentKey === 'verification') {
                targetProgress = bounds.start + (bounds.end - bounds.start) * 0.5;
            } else {
                targetProgress = Math.min(bounds.end, 0.99);
            }
            const scrollStart = st.start;
            const scrollEnd = st.end;
            const targetScroll = scrollStart + targetProgress * (scrollEnd - scrollStart);

            const scroller = document.getElementById('scrollytelling-scroll-container');
            const proxy = { y: scroller ? scroller.scrollTop : window.scrollY };
            gsap.to(proxy, {
                y: targetScroll,
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

        destroy() {
            if (deactivateHandler) {
                window.removeEventListener('slide-deactivate', deactivateHandler);
                deactivateHandler = null;
            }
            if (this.seekSegmentHandler) {
                window.removeEventListener('scrollytelling-seek-segment', this.seekSegmentHandler);
            }
            if (this.seekHandler) {
                window.removeEventListener('scrollytelling-seek', this.seekHandler);
            }
            if (mm) {
                mm.revert();
                mm = null;
            }
            if (masterTimeline) {
                if (masterTimeline.scrollTrigger) {
                    masterTimeline.scrollTrigger.kill();
                }
                masterTimeline.kill();
                masterTimeline = null;
            }
            pulseTweens.forEach(t => t.kill());
            pulseTweens = [];
            if (scannerTween) {
                scannerTween.kill();
                scannerTween = null;
            }
            initialized = false;
        }
    };
}
