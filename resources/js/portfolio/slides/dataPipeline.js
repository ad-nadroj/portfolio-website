import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

export default function dataPipelineStory() {
    // Closure variables - completely hidden from Alpine's reactivity/Proxy system
    // Storing GSAP timelines on reactive component properties causes RangeErrors.
    let masterTimeline = null;
    let initialized = false;
    let cdcInterval = null;
    let mm = null;
    let ambientTween = null;
    let deactivateHandler = null;
    let pulseTweens = [];

    // Timeline nav segment boundaries (computed dynamically from labels)
    let segments = null;
    const SEGMENT_KEYS = ['ingestion', 'transformation', 'output'];

    // Timeline nav DOM cache (resolved once in initAnimation)
    let navElements = null;

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

        // Update global progress bar
        if (navElements.progressBar) {
            navElements.progressBar.style.width = `${(progress * 100).toFixed(1)}%`;
        }

        // Determine which segment is active
        let activeKey = 'ingestion';
        if (segments.output && progress >= segments.output.start) {
            activeKey = 'output';
        } else if (segments.transformation && progress >= segments.transformation.start) {
            activeKey = 'transformation';
        }

        // Dispatch progress to window for the Debug HUD
        const scroller = document.getElementById('scrollytelling-scroll-container');
        window.dispatchEvent(new CustomEvent('scrollytelling-progress', {
            detail: {
                progress: progress,
                activeKey: activeKey,
                scrollY: Math.round(scroller ? scroller.scrollTop : window.scrollY)
            }
        }));

        // Update each segment's active state and fill
        navElements.segments.forEach((seg, i) => {
            const key = seg.dataset.segment;
            const bounds = segments[key];
            if (!bounds) return;
            const isActive = key === activeKey;

            // Toggle active class
            seg.classList.toggle('is-active', isActive);

            // Calculate fill: 0 if before segment, 1 if past, proportional if inside
            let fill = 0;
            if (progress >= bounds.end) {
                fill = 1;
            } else if (progress > bounds.start) {
                fill = (progress - bounds.start) / (bounds.end - bounds.start);
            }

            // Apply fill via GSAP set for perf (no layout thrash)
            if (navElements.fills[i]) {
                gsap.set(navElements.fills[i], { scaleX: fill });
            }
        });
    }

    function startCDCStream(container) {
        if (!container) return;
        const track = container.querySelector('.cdc-log-track');
        if (!track) return;

        // Clear static items
        track.innerHTML = '';

        const templates = [
            () => `{"ts_ms": ${Date.now()}, "op": "c", "after": {"id": ${gsap.utils.random(100, 999, 1)}, "amount": ${gsap.utils.random(5, 500, 0.01).toFixed(2)}}}`,
            () => `{"ts_ms": ${Date.now()}, "op": "u", "after": {"id": ${gsap.utils.random(100, 999, 1)}, "status": "${gsap.utils.random(['paid', 'shipped', 'completed'])}"}}`,
            () => `{"ts_ms": ${Date.now()}, "op": "d", "before": {"id": ${gsap.utils.random(100, 999, 1)}, "tier": "${gsap.utils.random(['free', 'pro'])}"}}`,
            () => `{"ts_ms": ${Date.now()}, "op": "c", "after": {"id": ${gsap.utils.random(100, 999, 1)}, "user_id": ${gsap.utils.random(1000, 9999, 1)}}}`,
        ];

        const addLog = () => {
            const el = document.createElement('div');
            el.className = 'truncate';
            const isDelete = Math.random() > 0.75;
            el.textContent = templates[Math.floor(Math.random() * templates.length)]();
            if (isDelete) {
                el.className += ' text-rose-400/70';
            }
            track.appendChild(el);

            // Fade in
            gsap.fromTo(el, { opacity: 0, y: 8 }, { opacity: 0.7, y: 0, duration: 0.3 });

            // Keep items list short
            if (track.childNodes.length > 8) {
                const first = track.firstChild;
                gsap.to(first, {
                    opacity: 0,
                    height: 0,
                    marginTop: -8,
                    duration: 0.3,
                    onComplete: () => first.remove()
                });
            }
        };

        // Seed initial logs
        for (let i = 0; i < 5; i++) {
            addLog();
        }

        cdcInterval = setInterval(addLog, 1200);
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

                const pipeline = slideRoot.querySelector('#pipeline-processor');
                const pipelineWrapper = slideRoot.querySelector('[x-ref="pipelineWrapper"]');
                const olapContainer = slideRoot.querySelector('#olap-container');
                const outputLine = slideRoot.querySelector('#output-line');
                
                if (!pipeline || !olapContainer) return;

                const oltpNodes = gsap.utils.toArray('.oltp-node', slideRoot);
                const oltpNodeWrappers = gsap.utils.toArray('.oltp-node-wrapper', slideRoot);
                const olapMarts = gsap.utils.toArray('.olap-mart', slideRoot);
                const olapLabels = gsap.utils.toArray('.olap-label', slideRoot);
                const narrativeTexts = gsap.utils.toArray('.narrative-text', slideRoot);
                const techBadge1 = slideRoot.querySelector('.tech-badge-1');
                const techBadge2 = slideRoot.querySelector('.tech-badge-2');
                const techBadge3 = slideRoot.querySelector('.tech-badge-3');
                const intelligencePanel = slideRoot.querySelector('[x-ref="intelligencePanel"]');
                const cdcLogContainer = slideRoot.querySelector('[x-ref="cdcLogContainer"]');
                const flowGroup1 = slideRoot.querySelectorAll('.flow-path-1, .flow-pulse-1');
                const flowGroup2 = gsap.utils.toArray('.flow-path-2, .flow-pulse-2', slideRoot);
                const flowGroup1Mobile = slideRoot.querySelectorAll('.flow-path-1-mobile, .flow-pulse-1-mobile');
                const flowGroup2Mobile = gsap.utils.toArray('.flow-path-2-mobile, .flow-pulse-2-mobile', slideRoot);
                const pulse1 = slideRoot.querySelector('.flow-pulse-1');
                const pulse2 = slideRoot.querySelector('.flow-pulse-2');
                const pulse1Mobile = slideRoot.querySelector('.flow-pulse-1-mobile');
                const pulse2Mobile = slideRoot.querySelector('.flow-pulse-2-mobile');

                // Ambient animations
                ambientTween = gsap.to(oltpNodes, {
                    y: "random(-20, 20)",
                    x: "random(-20, 20)",
                    duration: "random(2.5, 4.5)",
                    repeat: -1,
                    yoyo: true,
                    ease: "sine.inOut",
                    stagger: { each: 0.1, from: "random" }
                });

                startCDCStream(cdcLogContainer);
 
                if (pulse1) { pulseTweens.push(gsap.to(pulse1, { strokeDashoffset: -100, duration: 3, repeat: -1, ease: "none" })); }
                if (pulse2) { pulseTweens.push(gsap.to(pulse2, { strokeDashoffset: -100, duration: 3, repeat: -1, ease: "none" })); }
                if (pulse1Mobile) { pulseTweens.push(gsap.to(pulse1Mobile, { strokeDashoffset: -100, duration: 3, repeat: -1, ease: "none" })); }
                if (pulse2Mobile) { pulseTweens.push(gsap.to(pulse2Mobile, { strokeDashoffset: -100, duration: 3, repeat: -1, ease: "none" })); }

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
                            onToggle: (self) => {
                                if (self.isActive) {
                                    ambientTween.resume();
                                } else {
                                    ambientTween.pause();
                                }
                            },
                            onUpdate: (self) => {
                                updateTimelineNav(self.progress);
                            }
                        }
                    });

                    timeline.addLabel('ingestion', 0);
                    timeline.addLabel('transformation', 1.5);
                    timeline.addLabel('output', 2.5);

                    let pRect;
                    const onRefreshInit = () => { pRect = null; };
                    ScrollTrigger.addEventListener("refreshInit", onRefreshInit);

                    // Act 1
                    timeline.to(oltpNodeWrappers, {
                        x: (index, target) => {
                            if (reduceMotion) return 0;
                            if (!pRect) pRect = pipeline.getBoundingClientRect();
                            const tRect = target.getBoundingClientRect();
                            return (pRect.left + pRect.width / 2) - (tRect.left + tRect.width / 2);
                        },
                        y: (index, target) => {
                            if (reduceMotion) return 0;
                            if (!pRect) pRect = pipeline.getBoundingClientRect();
                            const tRect = target.getBoundingClientRect();
                            return (pRect.top + pRect.height / 2) - (tRect.top + tRect.height / 2);
                        },
                        scale: 0,
                        opacity: 0,
                        duration: reduceMotion ? 0 : 1.0,
                        stagger: reduceMotion ? 0 : { amount: 0.5, from: "random" },
                        ease: "power2.in"
                    }, 0);

                    if (techBadge1) {
                        timeline.to(techBadge1, { opacity: 1, y: -5, duration: reduceMotion ? 0 : 0.5 }, 0.2);
                    }

                    if (isDesktop) {
                        const shiftDistance = () => -(canvas.clientWidth * 0.28);

                        timeline.to(slideRoot.querySelector('[x-ref="oltpContainer"]'), { 
                            x: -100, 
                            opacity: 0, 
                            duration: reduceMotion ? 0 : 0.8, 
                            ease: "power2.inOut" 
                        }, 1.6)
                        .to(flowGroup1, {
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.5,
                            ease: "power2.inOut"
                        }, 1.6)
                        .to([pipelineWrapper, slideRoot.querySelector('[x-ref="olapContainer"]'), ...flowGroup2], {
                            x: shiftDistance,
                            duration: reduceMotion ? 0 : 1.2,
                            ease: "power3.inOut"
                        }, 1.6);

                        gsap.set(intelligencePanel, { x: 48, y: 0, yPercent: -50, opacity: 0 });
                        timeline.to(intelligencePanel, {
                            opacity: 1,
                            x: 0,
                            yPercent: -50,
                            duration: reduceMotion ? 0 : 1,
                            ease: "power2.out"
                        }, 2.5);

                    } else if (isMobile) {
                        timeline.to(slideRoot.querySelector('[x-ref="oltpContainer"]'), { 
                            y: -80, 
                            opacity: 0, 
                            duration: reduceMotion ? 0 : 0.8, 
                            ease: "power2.inOut" 
                        }, 1.6)
                        .to(flowGroup1Mobile, {
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.5,
                            ease: "power2.inOut"
                        }, 1.6)
                        .to([pipelineWrapper, slideRoot.querySelector('[x-ref="olapContainer"]'), ...flowGroup2Mobile], {
                            y: () => -(canvas.clientHeight * 0.18),
                            duration: reduceMotion ? 0 : 1.2,
                            ease: "power3.inOut"
                        }, 1.6);

                        gsap.set(intelligencePanel, { x: 0, y: 32, yPercent: 0, opacity: 0 });
                        timeline.to(intelligencePanel, {
                            opacity: 1,
                            y: 0,
                            yPercent: 0,
                            duration: reduceMotion ? 0 : 1,
                            ease: "power2.out"
                        }, 2.5);
                    }

                    // Act 2
                    timeline.to(narrativeTexts[0], { opacity: 0, y: -20, duration: reduceMotion ? 0 : 0.5 }, 0.8)
                            .to(narrativeTexts[1], { opacity: 1, y: 0, duration: reduceMotion ? 0 : 0.5 }, 1);

                    timeline.to(pipeline, { scale: 1.05, duration: reduceMotion ? 0 : 0.5 }, 1)
                           .to(slideRoot.querySelectorAll('.pipeline-glow'), { opacity: 1, duration: reduceMotion ? 0 : 0.5 }, 1)
                           .to(slideRoot.querySelectorAll('.pipeline-border'), { opacity: 1, duration: reduceMotion ? 0 : 0.5 }, 1)
                           .to(slideRoot.querySelectorAll('.pipeline-scan'), {
                               opacity: 1,
                               y: pipeline.offsetHeight,
                               duration: reduceMotion ? 0 : 0.5,
                               repeat: reduceMotion ? 0 : 3,
                               yoyo: true,
                               ease: "none"
                           }, 1)
                           .to(slideRoot.querySelectorAll('.pipeline-icon'), {
                               rotation: reduceMotion ? 0 : 360,
                               duration: reduceMotion ? 0 : 1.5,
                               ease: "power3.inOut"
                           }, 1);

                    if (techBadge2) {
                        timeline.to(techBadge2, { opacity: 1, y: -5, duration: reduceMotion ? 0 : 0.5 }, 1);
                    }

                    // Act 3
                    timeline.to(narrativeTexts[1], { opacity: 0, y: -20, duration: reduceMotion ? 0 : 0.5 }, 2)
                            .to(narrativeTexts[2], { opacity: 1, y: 0, duration: reduceMotion ? 0 : 0.5 }, 2.2);

                    if (cdcLogContainer) {
                        timeline.to(cdcLogContainer, { 
                            opacity: 0, 
                            x: isDesktop ? 20 : 0, 
                            y: isMobile ? -20 : 0,
                            duration: reduceMotion ? 0 : 0.5, 
                            ease: "power2.inOut" 
                        }, 1.3);
                    }

                    if (outputLine) {
                        timeline.to(outputLine, { scaleX: 1, opacity: 1, duration: reduceMotion ? 0 : 0.5, ease: "power2.out" }, 1.5);
                    }

                    timeline.to(olapContainer, { opacity: 1, duration: reduceMotion ? 0 : 0.5 }, 1.5)
                           .to(olapMarts, { scaleX: 1, stagger: reduceMotion ? 0 : 0.15, duration: reduceMotion ? 0 : 1.5, ease: "expo.out" }, 1.8)
                           .to(olapLabels, { opacity: 1, x: 5, stagger: reduceMotion ? 0 : 0.15, duration: reduceMotion ? 0 : 1, ease: "power2.out" }, 2);

                    if (techBadge3) {
                        timeline.to(techBadge3, { opacity: 1, y: -5, duration: reduceMotion ? 0 : 0.5 }, 1.8);
                    }

                    timeline.to(pipeline, { scale: 1, duration: reduceMotion ? 0 : 1, ease: "power2.out" }, 3)
                           .to(slideRoot.querySelectorAll('.pipeline-glow'), { opacity: 0, duration: reduceMotion ? 0 : 1, ease: "power2.out" }, 3)
                           .to(slideRoot.querySelectorAll('.pipeline-border'), { opacity: 0, duration: reduceMotion ? 0 : 1, ease: "power2.out" }, 3)
                           .to(slideRoot.querySelectorAll('.pipeline-scan'), { opacity: 0, duration: reduceMotion ? 0 : 0.5 }, 3);

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

                    return () => {
                        ScrollTrigger.removeEventListener("refreshInit", onRefreshInit);
                    };
                });
            });

            // Listen for scrub events from the Debug HUD
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
                if (targetSlide === 'data-engineering') {
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
            } else if (segmentKey === 'transformation') {
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
            if (ambientTween) {
                ambientTween.kill();
                ambientTween = null;
            }
            pulseTweens.forEach(t => t.kill());
            pulseTweens = [];
            if (cdcInterval) {
                clearInterval(cdcInterval);
                cdcInterval = null;
            }
            initialized = false;
        }
    };
}
