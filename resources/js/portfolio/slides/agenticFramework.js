import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

export default function agenticFrameworkStory() {
    let masterTimeline = null;
    let initialized = false;
    let mm = null;
    let segments = null;
    const SEGMENT_KEYS = ['prompt', 'reason', 'action'];
    let navElements = null;
    let ambientNodes = null;
    let deactivateHandler = null;
    let pulseTweens = [];

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

        if (navElements.progressBar) {
            navElements.progressBar.style.width = `${(progress * 100).toFixed(1)}%`;
        }

        let activeKey = 'prompt';
        if (segments.action && progress >= segments.action.start) {
            activeKey = 'action';
        } else if (segments.reason && progress >= segments.reason.start) {
            activeKey = 'reason';
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

                const msgAuth = slideRoot.querySelector('.discord-msg-auth');
                const msg1 = slideRoot.querySelector('.discord-msg-1');
                const msg2 = slideRoot.querySelector('.discord-msg-2');
                
                const agentNodes = gsap.utils.toArray('.agent-node', slideRoot);
                const orchestratorNode = slideRoot.querySelector('.orchestrator-node');
                const orchestratorBadge = slideRoot.querySelector('#orchestrator-badge');
                const workerNodes = agentNodes.filter(node => !node.classList.contains('orchestrator-node'));
                const agentLinks = gsap.utils.toArray('.agent-link', slideRoot);
                const hermesLink = slideRoot.querySelector('.hermes-link');
                const hermesNode = slideRoot.querySelector('.hermes-node');
                const controllerNode = slideRoot.querySelector('.controller-node');
                const controllerLink1 = slideRoot.querySelector('.controller-link-1');
                const controllerLink2 = slideRoot.querySelector('.controller-link-2');
                
                const outputContainer = slideRoot.querySelector('#output-container');
                const workspaceFiles = gsap.utils.toArray('.workspace-file', slideRoot);
                const workspaceDelivery = slideRoot.querySelector('.workspace-delivery');
                const workspaceSyncDivider = slideRoot.querySelector('.workspace-file-sync-divider');
                
                const dataPacket = slideRoot.querySelector('#data-packet');
                const pulsePacket = slideRoot.querySelector('#pulse-packet');
                const controllerPing = slideRoot.querySelector('#controller-ping');

                const agentChatContainer = slideRoot.querySelector('[x-ref="agentChatContainer"]');
                const chatGroupA = gsap.utils.toArray('.agent-chat-group-a', agentChatContainer);
                const chatGroupB = gsap.utils.toArray('.agent-chat-group-b', agentChatContainer);
                const chatGroupC = gsap.utils.toArray('.agent-chat-group-c', agentChatContainer);
                const chatGroupD = gsap.utils.toArray('.agent-chat-group-d', agentChatContainer);

                const hermesConsole = slideRoot.querySelector('[x-ref="hermesConsole"]');
                const hermesLogLines = gsap.utils.toArray('.hermes-log-line', hermesConsole);
                const hermesProgressBar = hermesConsole?.querySelector('.hermes-progress-bar');
                const hermesPhase2 = hermesConsole?.querySelector('.hermes-phase2');
                const hermesReturnLines = gsap.utils.toArray('.hermes-return-line', hermesConsole);
                const hermesEventFire = hermesConsole?.querySelector('.hermes-event-fire');
                const hermesStatusText = hermesConsole?.querySelector('.hermes-status-text');
                const hermesStatusDot = hermesConsole?.querySelector('.hermes-status-dot');
                
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

                // Swarm nodes float
                ambientNodes = gsap.to(agentNodes, {
                    y: "random(-10, 10)",
                    x: "random(-10, 10)",
                    duration: "random(3, 5)",
                    repeat: -1,
                    yoyo: true,
                    ease: "sine.inOut",
                    stagger: { each: 0.1, from: "random" }
                });

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
                            end: () => "+=" + (window.innerHeight * 4.5),
                            scrub: 0.8,
                            markers: false,
                            fastScrollEnd: true,
                            invalidateOnRefresh: true,
                            onToggle: (self) => {
                                if (self.isActive) {
                                    ambientNodes.resume();
                                } else {
                                    ambientNodes.pause();
                                }
                            },
                            onUpdate: (self) => {
                                updateTimelineNav(self.progress);
                            }
                        }
                    });

                    timeline.addLabel('prompt', 0);
                    timeline.addLabel('reason', 3.0);
                    timeline.addLabel('action', 11.0);

                    // Act 1: Console operations and user trigger
                    timeline.to(msgAuth, {
                        opacity: 1,
                        y: 0,
                        duration: reduceMotion ? 0 : 0.5,
                        ease: "power2.out"
                    }, 0.1)
                    .to(msg1, {
                        opacity: 1,
                        y: 0,
                        duration: reduceMotion ? 0 : 0.6,
                        ease: "power2.out"
                    }, 0.4)
                    .to(msg2, {
                        opacity: 1,
                        y: 0,
                        duration: reduceMotion ? 0 : 0.6,
                        ease: "power2.out"
                    }, 0.9);


                    // Act 1 Pulse to Orchestrator
                    gsap.set(pulsePacket, { left: "16%", top: "50%", xPercent: -50, yPercent: -50 });
                    timeline.to(pulsePacket, {
                        opacity: 1,
                        scale: 1,
                        duration: reduceMotion ? 0 : 0.2
                    }, 1.2)
                    .to(pulsePacket, {
                        left: "50%",
                        top: "35%",
                        duration: reduceMotion ? 0 : 0.8,
                        ease: "power2.inOut"
                    }, 1.4)
                    .to(pulsePacket, {
                        opacity: 0,
                        scale: 0.5,
                        duration: reduceMotion ? 0 : 0.2
                    }, 2.2);

                    timeline.to(orchestratorNode, {
                        scale: 1.3,
                        borderColor: "rgba(244, 63, 94, 0.9)",
                        duration: reduceMotion ? 0 : 0.3,
                        yoyo: true,
                        repeat: 1
                    }, 2.2)
                    .to(orchestratorBadge, {
                        opacity: 1,
                        scale: 1,
                        duration: reduceMotion ? 0 : 0.3,
                        ease: "power2.out"
                    }, 2.2)
                    .to(orchestratorBadge, {
                        opacity: 0,
                        scale: 0.9,
                        duration: reduceMotion ? 0 : 0.3,
                        ease: "power2.in"
                    }, 2.8);

                    // ========================================
                    // Act 2: Async Task Offloading (3.0 → 11.0)
                    // ========================================
                    timeline.to(narrativeTexts[0], { opacity: 0, y: -20, duration: reduceMotion ? 0 : 0.5 }, 2.5)
                            .to(narrativeTexts[1], { opacity: 1, y: 0, duration: reduceMotion ? 0 : 0.5 }, 3.0);

                    // Slide out the left Discord panel to make room
                    if (isDesktop) {
                        timeline.to(slideRoot.querySelector('[x-ref="discordContainer"]'), {
                            x: -120,
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.6,
                            ease: "power2.inOut"
                        }, 2.5)
                        .to(flowGroup1, {
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.4
                        }, 2.5);
                    } else if (isMobile) {
                        timeline.to(slideRoot.querySelector('[x-ref="discordContainer"]'), {
                            y: -80,
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.6,
                            ease: "power2.inOut"
                        }, 2.5)
                        .to(flowGroup1Mobile, {
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.4
                        }, 2.5);
                    }

                    // Step 1: ORCH → Workers — Orchestrator flares, links to workers appear
                    timeline.to(orchestratorNode, {
                        scale: 1.25,
                        borderColor: "rgba(244, 63, 94, 0.9)",
                        boxShadow: "0 0 30px rgba(244, 63, 94, 0.6)",
                        duration: reduceMotion ? 0 : 0.4,
                    }, 3.0);

                    timeline.to(agentLinks, {
                        opacity: 1,
                        duration: reduceMotion ? 0 : 0.5
                    }, 3.0);

                    timeline.to(agentNodes, {
                        scale: 1.15,
                        duration: reduceMotion ? 0 : 0.5,
                        stagger: reduceMotion ? 0 : 0.08
                    }, 3.5);

                    // Step 2: Workers activate — worker nodes pulse
                    timeline.to(workerNodes, {
                        borderColor: "rgba(168, 85, 247, 0.8)",
                        boxShadow: "0 0 20px rgba(168, 85, 247, 0.4)",
                        duration: reduceMotion ? 0 : 0.4,
                        stagger: reduceMotion ? 0 : 0.08
                    }, 4.2);

                    // Step 3: Workers → Hermes — hermes link activates
                    timeline.to(hermesLink, {
                        opacity: 0.7,
                        duration: reduceMotion ? 0 : 0.4
                    }, 5.2);

                    timeline.to(hermesNode, {
                        opacity: 0.6,
                        scale: 1.1,
                        borderColor: "rgba(34, 211, 238, 0.5)",
                        duration: reduceMotion ? 0 : 0.5,
                    }, 5.2);

                    // Step 4: Hermes processes — hermes glows strongly
                    timeline.to(hermesNode, {
                        opacity: 1,
                        scale: 1.2,
                        borderColor: "rgba(34, 211, 238, 0.8)",
                        backgroundColor: "rgba(8, 47, 73, 0.7)",
                        duration: reduceMotion ? 0 : 0.5,
                    }, 6.2);

                    // Step 5: Hermes → Workers — hermes dims, workers brighten
                    timeline.to(hermesNode, {
                        scale: 1.0,
                        borderColor: "rgba(34, 211, 238, 0.3)",
                        opacity: 0.3,
                        duration: reduceMotion ? 0 : 0.4,
                    }, 7.6);

                    timeline.to(workerNodes, {
                        borderColor: "rgba(16, 185, 129, 0.7)",
                        boxShadow: "0 0 20px rgba(16, 185, 129, 0.4)",
                        duration: reduceMotion ? 0 : 0.4,
                        stagger: reduceMotion ? 0 : 0.06
                    }, 7.6);

                    // Step 6: Workers → Orchestrator — ORCH gets green rewake
                    timeline.to(orchestratorNode, {
                        scale: 1.35,
                        borderColor: "rgba(16, 185, 129, 1)",
                        boxShadow: "0 0 35px rgba(16, 185, 129, 0.6)",
                        duration: reduceMotion ? 0 : 0.5,
                        yoyo: true,
                        repeat: 1
                    }, 8.8);

                    // Scrub dynamic motion of links throughout Act 2
                    timeline.to(agentLinks, {
                        strokeDashoffset: -60,
                        duration: reduceMotion ? 0 : 7.0,
                        ease: "none"
                    }, 3.0);

                    // Agent-to-Agent chat panel (fades in during Act 2)
                    if (agentChatContainer) {
                        timeline.to(agentChatContainer, {
                            opacity: 1,
                            duration: reduceMotion ? 0 : 0.5
                        }, 3.0);

                        timeline.to(chatGroupA, {
                            opacity: 1,
                            y: 0,
                            duration: reduceMotion ? 0 : 0.35,
                            stagger: reduceMotion ? 0 : 0.15,
                            ease: "power2.out"
                        }, 3.5);

                        timeline.to(chatGroupB, {
                            opacity: 1,
                            y: 0,
                            duration: reduceMotion ? 0 : 0.35,
                            stagger: reduceMotion ? 0 : 0.15,
                            ease: "power2.out"
                        }, 4.6);

                        timeline.to(chatGroupC, {
                            opacity: 1,
                            y: 0,
                            duration: reduceMotion ? 0 : 0.35,
                            stagger: reduceMotion ? 0 : 0.15,
                            ease: "power2.out"
                        }, 8.0);

                        timeline.to(chatGroupD, {
                            opacity: 1,
                            y: 0,
                            duration: reduceMotion ? 0 : 0.35,
                            stagger: reduceMotion ? 0 : 0.15,
                            ease: "power2.out"
                        }, 9.2);

                        // Fade out before Act 3
                        timeline.to(agentChatContainer, {
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.4
                        }, 10.2);
                    }

                    // Hermes Research Console (fades in when Hermes activates)
                    if (hermesConsole) {
                        // Phase 1: Console appears, crawl lines stagger
                        timeline.to(hermesConsole, {
                            opacity: 1,
                            duration: reduceMotion ? 0 : 0.5
                        }, 5.2);

                        timeline.to(hermesLogLines, {
                            opacity: 1,
                            y: 0,
                            duration: reduceMotion ? 0 : 0.3,
                            stagger: reduceMotion ? 0 : 0.15,
                            ease: "power2.out"
                        }, 5.4);

                        // Progress bar fills during crawl
                        if (hermesProgressBar) {
                            timeline.to(hermesProgressBar, {
                                scaleX: 1,
                                duration: reduceMotion ? 0 : 2.0,
                                ease: "power1.inOut"
                            }, 5.6);
                        }

                        // Phase 2: Backend return — syncs with Hermes→Workers
                        if (hermesPhase2) {
                            timeline.to(hermesPhase2, {
                                opacity: 1,
                                duration: reduceMotion ? 0 : 0.3
                            }, 7.6);

                            timeline.to(hermesReturnLines, {
                                opacity: 1,
                                y: 0,
                                duration: reduceMotion ? 0 : 0.25,
                                stagger: reduceMotion ? 0 : 0.15,
                                ease: "power2.out"
                            }, 7.8);
                        }

                        // Event fire pulse syncs with ORCH rewake
                        if (hermesEventFire) {
                            timeline.to(hermesEventFire, {
                                scale: 1.05,
                                duration: reduceMotion ? 0 : 0.2,
                                yoyo: true,
                                repeat: 2
                            }, 8.8);
                        }

                        // Status change: ACTIVE → COMPLETE
                        if (hermesStatusText) {
                            timeline.to(hermesStatusText, {
                                color: "rgba(16, 185, 129, 0.8)",
                                textContent: "Complete",
                                duration: reduceMotion ? 0 : 0.01
                            }, 7.6);
                        }
                        if (hermesStatusDot) {
                            timeline.to(hermesStatusDot, {
                                backgroundColor: "rgba(16, 185, 129, 1)",
                                boxShadow: "0 0 6px rgba(16, 185, 129, 0.8)",
                                duration: reduceMotion ? 0 : 0.3
                            }, 7.6);
                        }

                        // Fade out before Act 3
                        timeline.to(hermesConsole, {
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.4
                        }, 10.2);
                    }

                    // ========================================
                    // Act 3: Hermes Callback Cycle (11.0 → 14.0)
                    // ========================================
                    timeline.to(narrativeTexts[1], { opacity: 0, y: -20, duration: reduceMotion ? 0 : 0.5 }, 10.5)
                            .to(narrativeTexts[2], { opacity: 1, y: 0, duration: reduceMotion ? 0 : 0.5 }, 11.0);

                    // Reset swarm to neutral state for Act 3
                    timeline.to([workerNodes, orchestratorNode, agentLinks], {
                        opacity: 0.25,
                        boxShadow: "none",
                        duration: reduceMotion ? 0 : 0.4
                    }, 10.8);

                    // Data packet: Hermes → Controller → Orchestrator
                    gsap.set(dataPacket, { left: "50%", top: "50%", xPercent: -50, yPercent: -50 });
                    timeline.to(dataPacket, {
                        opacity: 1,
                        scale: 1.2,
                        duration: reduceMotion ? 0 : 0.2
                    }, 11.0)
                    .to(dataPacket, {
                        left: "78%",
                        top: "50%",
                        duration: reduceMotion ? 0 : 0.5,
                        ease: "power2.in"
                    }, 11.2)
                    .to(dataPacket, {
                        opacity: 0,
                        scale: 0.5,
                        duration: reduceMotion ? 0 : 0.2
                    }, 11.7);

                    // Controller fades in for callback
                    timeline.to([controllerNode, controllerLink1, controllerLink2], {
                        opacity: 1,
                        duration: reduceMotion ? 0 : 0.4
                    }, 11.0);

                    // Controller Ping → Orchestrator
                    gsap.set(controllerPing, { left: "78%", top: "50%", xPercent: -50, yPercent: -50 });
                    timeline.to(controllerPing, {
                        opacity: 1,
                        scale: 1.1,
                        duration: reduceMotion ? 0 : 0.1
                    }, 11.6)
                    .to(controllerPing, {
                        left: "50%",
                        top: "20%",
                        duration: reduceMotion ? 0 : 0.5,
                        ease: "power2.out"
                    }, 11.7)
                    .to(controllerPing, {
                        opacity: 0,
                        duration: reduceMotion ? 0 : 0.1
                    }, 12.2);

                    // Rewake strikes Orchestrator
                    timeline.to([workerNodes, agentLinks], {
                        opacity: 1,
                        duration: reduceMotion ? 0 : 0.3
                    }, 12.0);

                    timeline.to(orchestratorNode, {
                        opacity: 1,
                        scale: 1.35,
                        borderColor: "rgba(16, 185, 129, 1)",
                        backgroundColor: "rgba(6, 78, 59, 0.8)",
                        boxShadow: "0 0 35px rgba(16, 185, 129, 0.5)",
                        duration: reduceMotion ? 0 : 0.4,
                        yoyo: true,
                        repeat: 1
                    }, 12.0);

                    // Hermes and Controller return to background
                    timeline.to(hermesNode, {
                        scale: 1.0,
                        borderColor: "rgba(34, 211, 238, 0.1)",
                        backgroundColor: "rgba(8, 47, 73, 0.15)",
                        opacity: 0.15,
                        duration: reduceMotion ? 0 : 0.5
                    }, 12.2);

                    timeline.to([controllerNode, controllerLink1, controllerLink2], {
                        opacity: 0,
                        duration: reduceMotion ? 0 : 0.4
                    }, 12.2);

                    // The Reveal: Workspace & Metrics Panel (discord already gone from Act 2)
                    if (isDesktop) {
                        const act3ShiftDistance = () => -(canvas.clientWidth * 0.28);

                        timeline.to(flowGroup2, {
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.4
                        }, 12.4)
                        .to([slideRoot.querySelector('[x-ref="swarmContainer"]'), outputContainer], {
                            x: act3ShiftDistance,
                            duration: reduceMotion ? 0 : 1.0,
                            ease: "power3.inOut"
                        }, 12.4);

                        // Position & fade in intelligence panel (slide from right)
                        gsap.set(intelligencePanel, { x: 48, y: 0, yPercent: -50, opacity: 0 });
                        timeline.to(intelligencePanel, {
                            opacity: 1,
                            x: 0,
                            yPercent: -50,
                            duration: reduceMotion ? 0 : 0.8,
                            ease: "power2.out"
                        }, 13.2);

                    } else if (isMobile) {
                        timeline.to(flowGroup2Mobile, {
                            opacity: 0,
                            duration: reduceMotion ? 0 : 0.4
                        }, 12.4)
                        .to([slideRoot.querySelector('[x-ref="swarmContainer"]'), outputContainer], {
                            y: () => -(canvas.clientHeight * 0.18),
                            duration: reduceMotion ? 0 : 1.0,
                            ease: "power3.inOut"
                        }, 12.4);

                        // Position & fade in intelligence panel (slide from bottom)
                        gsap.set(intelligencePanel, { x: 0, y: 32, yPercent: 0, opacity: 0 });
                        timeline.to(intelligencePanel, {
                            opacity: 1,
                            y: 0,
                            yPercent: 0,
                            duration: reduceMotion ? 0 : 0.8,
                            ease: "power2.out"
                        }, 13.2);
                    }

                    // Reveal Workspace output container
                    timeline.to(outputContainer, { opacity: 1, duration: reduceMotion ? 0 : 0.5 }, 12.4);

                    if (workspaceSyncDivider) {
                        timeline.to(workspaceSyncDivider, {
                            opacity: 1,
                            y: 0,
                            duration: reduceMotion ? 0 : 0.4,
                            ease: "power2.out"
                        }, 12.6);
                    }

                    // Animate directory files cascading down
                    timeline.to(workspaceFiles, {
                        opacity: 1,
                        x: 0,
                        duration: reduceMotion ? 0 : 0.4,
                        stagger: reduceMotion ? 0 : 0.12,
                        ease: "power1.out"
                    }, 12.7);

                    // Animate orchestrator discord response delivery to user
                    timeline.to(workspaceDelivery, {
                        opacity: 1,
                        y: 0,
                        duration: reduceMotion ? 0 : 0.5,
                        ease: "power2.out"
                    }, 13.3);


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
                if (targetSlide === 'agentic-framework') {
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
            if (segmentKey === 'prompt') {
                targetProgress = bounds.start;
            } else if (segmentKey === 'reason') {
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
            if (ambientNodes) {
                ambientNodes.kill();
                ambientNodes = null;
            }
            pulseTweens.forEach(t => t.kill());
            pulseTweens = [];
            initialized = false;
        }
    };
}
