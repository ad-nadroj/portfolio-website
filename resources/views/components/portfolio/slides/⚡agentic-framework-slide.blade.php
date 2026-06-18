<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div 
    x-data="agenticFrameworkStory()" 
    @slide-deactivate.window="if ($event.detail.slide === 'agentic-framework') { destroy(); }"
    x-init="$nextTick(() => initAnimation())"
    wire:ignore
    class="w-full h-full flex flex-col items-center justify-start pt-[1.5vh] md:pt-[2vh] pb-24 md:pb-28 relative"
>
        <!-- Narrative Text Wrapper -->
        <div
            class="w-full h-24 flex-none flex items-center justify-center relative z-30 perspective-1000 mt-2">
            <div class="narrative-text absolute text-center opacity-100 translate-y-0">
                <h2
                    class="text-xl md:text-2xl lg:text-3xl font-semibold bg-gradient-to-br from-rose-400 to-rose-600 bg-clip-text text-transparent">
                    The AI Department
                </h2>
                <p class="text-slate-400 mt-2 text-sm md:text-base lg:text-lg font-light">
                    Instead of confusing a single chatbot with a massive project, you tag specialized AI workers directly inside your Discord server.
                </p>
            </div>

            <div class="narrative-text absolute text-center opacity-0 translate-y-8">
                <h2
                    class="text-xl md:text-2xl lg:text-3xl font-semibold bg-gradient-to-br from-purple-400 to-indigo-600 bg-clip-text text-transparent">
                    Background Processing
                </h2>
                <p class="text-slate-400 mt-2 text-sm md:text-base lg:text-lg font-light">
                    The main AI delegates the heavy lifting to a background researcher, keeping your chat fast and responsive while it works.
                </p>
            </div>

            <div class="narrative-text absolute text-center opacity-0 translate-y-8">
                <h2
                    class="text-xl md:text-2xl lg:text-3xl font-semibold bg-gradient-to-br from-cyan-400 to-blue-650 bg-clip-text text-transparent">
                    The Seamless Delivery
                </h2>
                <p class="text-slate-400 mt-2 text-sm md:text-base lg:text-lg font-light">
                    Once the deep research is complete, the main AI taps you on the shoulder and delivers the final, actionable results right back into the chat.
                </p>
            </div>
        </div>

        <!-- Main Visualization Area -->
        <div
            class="relative w-full max-w-6xl h-[420px] md:h-[48vh] lg:h-[50vh] xl:h-[52vh] md:min-h-[380px] md:max-h-[560px] flex flex-col md:flex-row items-center justify-between px-4 md:px-12 gap-8 md:gap-0 mt-4 xl:mt-8">

            <div id="pulse-packet"
                class="absolute w-5 h-5 rounded-full bg-rose-500 flex items-center justify-center shadow-[0_0_10px_rgba(244,63,94,0.8)] opacity-0 z-30 pointer-events-none">
                <span class="text-[5px] md:text-[7px] font-mono text-white font-bold">CMD</span>
            </div>

            <!-- SVG Connective Paths (z-0 backdrop) -->
            <svg class="absolute inset-0 w-full h-full pointer-events-none z-0" viewBox="0 0 100 100"
                preserveAspectRatio="none">
                <!-- Desktop Paths (Horizontal) -->
                <path class="flow-path-1 hidden md:block stroke-slate-700/30" fill="none" stroke-width="1"
                    stroke-dasharray="4 4" style="vector-effect: non-scaling-stroke;" d="M 25 50 Q 37.5 45, 50 50" />
                <path class="flow-path-2 hidden md:block stroke-slate-700/30" fill="none" stroke-width="1"
                    stroke-dasharray="4 4" style="vector-effect: non-scaling-stroke;" d="M 50 50 Q 62.5 55, 75 50" />
                <path class="flow-pulse-1 hidden md:block stroke-rose-500/70" fill="none" stroke-width="1.5"
                    stroke-dasharray="8 20" style="vector-effect: non-scaling-stroke;" d="M 25 50 Q 37.5 45, 50 50" />
                <path class="flow-pulse-2 hidden md:block stroke-cyan-400/70" fill="none" stroke-width="1.5"
                    stroke-dasharray="8 20" style="vector-effect: non-scaling-stroke;" d="M 50 50 Q 62.5 55, 75 50" />

                <!-- Mobile Paths (Vertical) -->
                <path class="flow-path-1-mobile md:hidden stroke-slate-700/30" fill="none" stroke-width="1"
                    stroke-dasharray="4 4" style="vector-effect: non-scaling-stroke;" d="M 50 25 Q 45 37.5, 50 50" />
                <path class="flow-path-2-mobile md:hidden stroke-slate-700/30" fill="none" stroke-width="1"
                    stroke-dasharray="4 4" style="vector-effect: non-scaling-stroke;" d="M 50 50 Q 55 62.5, 50 75" />
                <path class="flow-pulse-1-mobile md:hidden stroke-rose-500/70" fill="none" stroke-width="1.5"
                    stroke-dasharray="8 20" style="vector-effect: non-scaling-stroke;" d="M 50 25 Q 45 37.5, 50 50" />
                <path class="flow-pulse-2-mobile md:hidden stroke-cyan-400/70" fill="none" stroke-width="1.5"
                    stroke-dasharray="8 20" style="vector-effect: non-scaling-stroke;" d="M 50 50 Q 55 62.5, 50 75" />
            </svg>

            <!-- Mock Discord UI (Left) -->
            <x-ui.discord.container
                x-ref="discordContainer"
                class="w-full md:w-[29%] lg:w-1/3 h-52 md:h-full"
                channel="research-swarm"
                status="ACTIVE"
                statusColor="emerald"
            >
                <!-- Auth message / System divider -->
                <x-ui.discord.divider class="discord-msg-auth opacity-0 translate-y-4" color="text-slate-550">
                    [16:47:38] Auth Session Established
                </x-ui.discord.divider>

                <!-- Message 1: User Prompt -->
                <x-ui.discord.message
                    class="discord-msg-1 opacity-0 translate-y-4"
                    author="jordan"
                    avatar="JD"
                    avatarBg="bg-indigo-600"
                    authorColor="text-white"
                    time="16:47:39"
                >
                    !deploy @Research Swarm: Get me 15 potential businesses each with their own dossier in the Cape Town CBD to target for a business expansion.
                </x-ui.discord.message>

                <!-- Message 2: Swarm response -->
                <x-ui.discord.message
                    class="discord-msg-2 opacity-0 translate-y-4"
                    author="openclaw-orchestrator"
                    avatar="OC"
                    avatarBg="bg-rose-600"
                    authorColor="text-rose-450"
                    time="16:47:40"
                    isBot
                >
                    “A-Okay. Request authenticated. Spinning up OpenClaw Swarm and delegating deep-web research to async Hermes node.”
                </x-ui.discord.message>
            </x-ui.discord.container>

            <!-- Swarm Collaborative Neural Web (Center) -->
            <div x-ref="swarmContainer"
                class="relative w-72 md:w-[29%] lg:w-1/3 h-48 md:h-[360px] flex items-center justify-center z-20">
                <!-- Floating Data Packets -->
                <div id="data-packet"
                    class="absolute w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-rose-500 flex items-center justify-center shadow-[0_0_12px_rgba(244,63,94,0.6)] opacity-0 z-30 pointer-events-none">
                    <span class="text-[6px] md:text-[8px] font-mono text-white font-bold">DATA</span>
                </div>

                <div id="controller-ping"
                    class="absolute h-6 px-2.5 rounded-full bg-emerald-500/90 backdrop-blur-sm flex items-center justify-center shadow-[0_0_15px_rgba(16,185,129,0.8)] opacity-0 z-30 pointer-events-none whitespace-nowrap">
                    <span class="text-[6px] md:text-[8px] font-mono text-white font-bold tracking-wider">Event Listener Hook</span>
                </div>

                <!-- SVG Connections Layer -->
                <svg class="swarm-connections absolute inset-0 w-full h-full pointer-events-none z-0"
                    viewBox="0 0 100 100">
                    <!-- OpenClaw Swarm Links -->
                    <line class="agent-link opacity-0 stroke-rose-500/50" x1="50" y1="20" x2="20"
                        y2="40" stroke-width="0.8" stroke-dasharray="4 4" />
                    <line class="agent-link opacity-0 stroke-purple-500/50" x1="50" y1="20" x2="80"
                        y2="40" stroke-width="0.8" stroke-dasharray="4 4" />
                    <line class="agent-link opacity-0 stroke-indigo-500/50" x1="20" y1="40" x2="30"
                        y2="70" stroke-width="0.8" stroke-dasharray="4 4" />
                    <line class="agent-link opacity-0 stroke-rose-500/50" x1="80" y1="40"
                        x2="70" y2="70" stroke-width="0.8" stroke-dasharray="4 4" />
                    <line class="agent-link opacity-0 stroke-purple-500/50" x1="30" y1="70"
                        x2="50" y2="80" stroke-width="0.8" stroke-dasharray="4 4" />
                    <line class="agent-link opacity-0 stroke-indigo-500/50" x1="70" y1="70"
                        x2="50" y2="80" stroke-width="0.8" stroke-dasharray="4 4" />
                    <line class="agent-link opacity-0 stroke-rose-500/50" x1="20" y1="40"
                        x2="50" y2="80" stroke-width="0.8" stroke-dasharray="4 4" />
                    <line class="agent-link opacity-0 stroke-purple-500/50" x1="80" y1="40"
                        x2="50" y2="80" stroke-width="0.8" stroke-dasharray="4 4" />
                    <line class="agent-link opacity-0 stroke-indigo-500/50" x1="30" y1="70"
                        x2="70" y2="70" stroke-width="0.8" stroke-dasharray="4 4" />
                    <line class="agent-link opacity-0 stroke-rose-500/50" x1="50" y1="20"
                        x2="50" y2="80" stroke-width="0.8" stroke-dasharray="4 4" />

                    <!-- Async Handoff & Rewake Links -->
                    <line class="hermes-link opacity-0 stroke-cyan-500/40" x1="50" y1="20"
                        x2="50" y2="50" stroke-width="1" stroke-dasharray="4 4" />
                    <line class="controller-link-1 opacity-0 stroke-emerald-500/40" x1="50" y1="50"
                        x2="78" y2="50" stroke-width="1" stroke-dasharray="4 4" />
                    <line class="controller-link-2 opacity-0 stroke-emerald-500/40" x1="78" y1="50"
                        x2="50" y2="20" stroke-width="1" stroke-dasharray="4 4" />
                </svg>
                <!-- Floating Agent Nodes -->
                <!-- Node 1: Orchestrator (ORCH) -->
                <div
                    class="agent-node orchestrator-node absolute top-[20%] left-[50%] -translate-x-1/2 -translate-y-1/2 w-14 h-14 rounded-full border-2 border-rose-500/40 bg-rose-950/60 flex items-center justify-center shadow-[0_0_20px_rgba(244,63,94,0.4)] z-30 transform-gpu">
                    <span class="text-[9px] md:text-[11px] lg:text-xs font-mono text-rose-300 font-bold uppercase">ORCH</span>
                </div>
                <!-- Orchestrator Context Badge -->
                <div id="orchestrator-badge"
                    class="absolute top-[8%] left-[50%] -translate-x-1/2 z-40 bg-slate-900/80 backdrop-blur-md border border-rose-500/30 text-[7px] md:text-[9px] text-rose-300 px-2.5 py-1 rounded-full shadow-[0_0_15px_rgba(244,63,94,0.2)] font-mono whitespace-nowrap opacity-0 scale-90 pointer-events-none">
                    OpenClaw: Context Mounted & Tools Executed
                </div>
                <!-- Node 2: Worker-1 -->
                <div
                    class="agent-node absolute top-[40%] left-[20%] -translate-x-1/2 -translate-y-1/2 w-11 h-11 rounded-full border border-purple-500/30 bg-purple-950/40 flex items-center justify-center shadow-[0_0_12px_rgba(168,85,247,0.2)] z-20 transform-gpu">
                    <span class="text-[8px] md:text-[9px] lg:text-[10px] font-mono text-purple-300 font-bold uppercase">WRK-1</span>
                </div>
                <!-- Node 3: Worker-2 -->
                <div
                    class="agent-node absolute top-[40%] left-[80%] -translate-x-1/2 -translate-y-1/2 w-11 h-11 rounded-full border border-purple-500/30 bg-purple-950/40 flex items-center justify-center shadow-[0_0_12px_rgba(168,85,247,0.2)] z-20 transform-gpu">
                    <span class="text-[8px] md:text-[9px] lg:text-[10px] font-mono text-purple-300 font-bold uppercase">WRK-2</span>
                </div>
                <!-- Node 4: Worker-3 -->
                <div
                    class="agent-node absolute top-[70%] left-[30%] -translate-x-1/2 -translate-y-1/2 w-11 h-11 rounded-full border border-purple-500/30 bg-purple-950/40 flex items-center justify-center shadow-[0_0_12px_rgba(168,85,247,0.2)] z-20 transform-gpu">
                    <span class="text-[8px] md:text-[9px] lg:text-[10px] font-mono text-purple-300 font-bold uppercase">WRK-3</span>
                </div>
                <!-- Node 5: Worker-4 -->
                <div
                    class="agent-node absolute top-[70%] left-[70%] -translate-x-1/2 -translate-y-1/2 w-11 h-11 rounded-full border border-purple-500/30 bg-purple-950/40 flex items-center justify-center shadow-[0_0_12px_rgba(168,85,247,0.2)] z-20 transform-gpu">
                    <span class="text-[8px] md:text-[9px] lg:text-[10px] font-mono text-purple-300 font-bold uppercase">WRK-4</span>
                </div>
                <!-- Node 6: Parser -->
                <div
                    class="agent-node absolute top-[80%] left-[50%] -translate-x-1/2 -translate-y-1/2 w-11 h-11 rounded-full border border-indigo-500/30 bg-indigo-950/40 flex items-center justify-center shadow-[0_0_12px_rgba(99,102,241,0.2)] z-20 transform-gpu">
                    <span class="text-[8px] md:text-[9px] lg:text-[10px] font-mono text-indigo-300 font-bold uppercase">PARS</span>
                </div>

                <!-- Node 7: Controller (Event Listener / Callback handler) -->
                <div
                    class="controller-node absolute top-[50%] left-[78%] -translate-x-1/2 -translate-y-1/2 w-12 h-12 rounded-full border border-emerald-500/40 bg-emerald-950/40 flex flex-col items-center justify-center shadow-[0_0_15px_rgba(16,185,129,0.2)] z-20 transform-gpu opacity-0">
                    <span class="text-[8px] md:text-[9px] lg:text-[10px] font-mono text-emerald-400 font-bold uppercase leading-none">CTRL</span>
                    <span class="text-[5px] md:text-[6px] lg:text-[7px] font-mono text-emerald-500/70 uppercase scale-90 mt-0.5">Callback</span>
                </div>

                <!-- Node 8: Deep Background Hermes Agent -->
                <div
                    class="hermes-node absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 w-24 h-24 rounded-full border-2 border-cyan-500/10 bg-cyan-950/15 flex flex-col items-center justify-center shadow-[0_0_25px_rgba(34,211,238,0.05)] z-10 transform-gpu opacity-10">
                    <span class="text-[10px] md:text-[12px] lg:text-sm font-mono text-cyan-400 font-bold uppercase">Hermes</span>
                    <span class="text-[6px] md:text-[7px] lg:text-[8px] font-mono text-cyan-500/60 uppercase">Deep Research</span>
                </div>
            </div>

            <!-- Hermes Research Console (Act 2, left column) -->
            <div x-ref="hermesConsole"
                class="absolute left-4 md:left-12 top-1/2 -translate-y-1/2 w-[calc(100%-2rem)] md:w-[27%] lg:w-[28%] h-52 md:h-[75%] border border-cyan-500/20 rounded-2xl bg-[#0c1225]/95 shadow-[0_8px_32px_rgba(0,0,0,0.4),0_0_40px_rgba(34,211,238,0.05)] overflow-hidden flex flex-col font-mono opacity-0 z-15 pointer-events-none">
                <!-- Console Header -->
                <div class="h-10 lg:h-11 border-b border-cyan-500/10 bg-[#0c1225] px-4 flex items-center gap-2 select-none shrink-0">
                    <span class="text-cyan-400 text-sm">⚡</span>
                    <span class="text-[10px] md:text-xs lg:text-sm font-bold text-cyan-300 tracking-wide uppercase">Hermes Deep Research</span>
                    <div class="ml-auto flex items-center gap-1.5">
                        <div class="hermes-status-dot w-1.5 h-1.5 rounded-full bg-cyan-400 shadow-[0_0_6px_rgba(34,211,238,0.8)] animate-pulse"></div>
                        <span class="hermes-status-text text-[8px] md:text-[9px] lg:text-[10px] text-cyan-400/80 tracking-wider uppercase">Active</span>
                    </div>
                </div>

                <!-- Phase 1: Web Crawling -->
                <div class="flex-1 p-3 md:p-4 flex flex-col gap-2 overflow-hidden text-left">
                    <div class="hermes-log-line opacity-0 translate-y-2 flex items-center gap-2">
                        <span class="text-cyan-500/60 text-[9px] md:text-[10px] lg:text-[11px]">▸</span>
                        <span class="text-[9px] md:text-[10px] lg:text-[11px] text-slate-300">DB.read(<span class="text-cyan-400">task_payload</span>)</span>
                        <span class="ml-auto text-[8px] md:text-[9px] lg:text-[10px] text-emerald-400 font-bold">✓</span>
                    </div>

                    <div class="hermes-log-line opacity-0 translate-y-2 flex items-center gap-2">
                        <span class="text-cyan-500/60 text-[9px] md:text-[10px] lg:text-[11px]">▸</span>
                        <span class="text-[9px] md:text-[10px] lg:text-[11px] text-slate-300">Parsing custom .md context sheets...</span>
                        <span class="ml-auto text-[8px] md:text-[9px] lg:text-[10px] text-emerald-400 font-bold">✓</span>
                    </div>

                    <div class="hermes-log-line opacity-0 translate-y-2 flex items-center gap-2">
                        <span class="text-cyan-500/60 text-[9px] md:text-[10px] lg:text-[11px]">▸</span>
                        <span class="text-[9px] md:text-[10px] lg:text-[11px] text-slate-300">Executing background tools...</span>
                        <div class="ml-auto w-16 h-2.5 bg-slate-800 rounded-full overflow-hidden border border-slate-700/50">
                            <div class="hermes-progress-bar h-full bg-gradient-to-r from-cyan-600 to-cyan-400 rounded-full origin-left scale-x-0"></div>
                        </div>
                    </div>

                    <!-- Phase 2: Backend Return -->
                    <div class="hermes-phase2 opacity-0 flex flex-col gap-2 mt-1">
                        <div class="flex items-center gap-2 w-full select-none">
                            <div class="flex-1 h-[1px] bg-cyan-500/15"></div>
                            <span class="text-[7px] md:text-[8px] lg:text-[9px] text-emerald-400/70 uppercase tracking-widest">Backend Write</span>
                            <div class="flex-1 h-[1px] bg-cyan-500/15"></div>
                        </div>

                        <div class="hermes-return-line opacity-0 translate-y-2 flex items-center gap-2">
                            <span class="text-emerald-500/60 text-[9px] md:text-[10px] lg:text-[11px]">▸</span>
                            <span class="text-[9px] md:text-[10px] lg:text-[11px] text-slate-300">DB.write(<span class="text-emerald-400">outputs</span>)</span>
                            <span class="ml-auto text-[8px] md:text-[9px] lg:text-[10px] text-emerald-400 font-bold">✓</span>
                        </div>

                        <div class="flex items-center gap-2 w-full select-none mt-1">
                            <div class="flex-1 h-[1px] bg-emerald-500/15"></div>
                            <span class="text-[7px] md:text-[8px] lg:text-[9px] text-emerald-400/70 uppercase tracking-widest">Event Listener</span>
                            <div class="flex-1 h-[1px] bg-emerald-500/15"></div>
                        </div>

                        <div class="hermes-return-line hermes-event-fire opacity-0 translate-y-2 flex items-center gap-2">
                            <span class="text-amber-400 text-[9px] md:text-[10px] lg:text-[11px]">⚡</span>
                            <span class="text-[9px] md:text-[10px] lg:text-[11px] text-slate-300">FIRE → <span class="text-emerald-400">rewake</span>(WRK-1)</span>
                            <span class="ml-auto text-[8px] md:text-[9px] lg:text-[10px] text-amber-400 font-bold animate-pulse">⚡</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agent-to-Agent Discord Panel (Act 2 overlay, right column) -->
            <x-ui.discord.container
                x-ref="agentChatContainer"
                class="absolute right-4 md:right-12 top-1/2 -translate-y-1/2 w-[calc(100%-2rem)] md:w-[29%] lg:w-[30%] h-52 md:h-[85%] z-15 pointer-events-none opacity-0"
                channel="agent-comms"
                status="DELEGATING"
                statusColor="purple"
                gap="gap-3"
            >
                <!-- Step 1: ORCH → Workers -->
                <x-ui.discord.divider class="agent-chat-msg agent-chat-group-a opacity-0 -translate-y-2" color="text-rose-400/80">
                    Orchestrator → Workers
                </x-ui.discord.divider>

                <x-ui.discord.message
                    class="agent-chat-msg agent-chat-group-a opacity-0 -translate-y-2"
                    author="openclaw-orchestrator"
                    avatar="OR"
                    avatarBg="bg-rose-600"
                    authorColor="text-rose-400"
                    time="16:47:41"
                    isBot
                >
                    @WRK-1 @WRK-2 Splitting zones. WRK-1 take Bree St corridor, WRK-2 handle St Georges Mall. Report findings back to me.
                </x-ui.discord.message>

                <!-- Step 2: Worker → Hermes (offload) -->
                <x-ui.discord.divider class="agent-chat-msg agent-chat-group-b opacity-0 -translate-y-2" color="text-purple-400/80">
                    Workers → Hermes
                </x-ui.discord.divider>

                <x-ui.discord.message
                    class="agent-chat-msg agent-chat-group-b opacity-0 -translate-y-2"
                    author="wrk-1-agent"
                    avatar="W1"
                    avatarBg="bg-purple-600"
                    authorColor="text-purple-400"
                    time="16:47:43"
                    isBot
                >
                    Deep-web directories required. Serializing research task to DB for @Hermes. Entering waiting loop.
                </x-ui.discord.message>

                <!-- Step 3: Hermes processes → returns to Workers -->
                <x-ui.discord.divider class="agent-chat-msg agent-chat-group-c opacity-0 -translate-y-2" color="text-cyan-400/80">
                    Hermes → Workers
                </x-ui.discord.divider>

                <x-ui.discord.message
                    class="agent-chat-msg agent-chat-group-c opacity-0 -translate-y-2"
                    author="hermes-research"
                    avatar="HM"
                    avatarBg="bg-cyan-600"
                    authorColor="text-cyan-400"
                    time="16:48:58"
                    isBot
                >
                    Research complete. 214 directories surveyed. Results posted to backend DB. Event listener fired — rewaking WRK-1.
                </x-ui.discord.message>

                <!-- Step 4: Worker → Orchestrator (report back) -->
                <x-ui.discord.divider class="agent-chat-msg agent-chat-group-d opacity-0 -translate-y-2" color="text-emerald-400/80">
                    Workers → Orchestrator
                </x-ui.discord.divider>

                <x-ui.discord.message
                    class="agent-chat-msg agent-chat-group-d opacity-0 -translate-y-2"
                    author="wrk-1-agent"
                    avatar="W1"
                    avatarBg="bg-purple-600"
                    authorColor="text-purple-400"
                    time="16:49:01"
                    isBot
                >
                    @ORCH Hermes data received. Bree St zone complete — 8 targets identified. Aggregating with WRK-2 payload.
                </x-ui.discord.message>
            </x-ui.discord.container>

            <!-- Shared Workspace / Discord Mimic (Right) -->
            <x-ui.discord.container
                id="output-container"
                x-ref="outputContainer"
                class="w-full md:w-[29%] lg:w-1/3 h-52 md:h-full opacity-0"
                channel="research-swarm"
                status="DELIVERED"
                statusColor="emerald"
                gap="gap-3"
            >
                <!-- Sync Divider -->
                <x-ui.discord.divider class="workspace-file-sync-divider opacity-0 -translate-y-2" color="text-[#23a55a]">
                    Orchestrator → User
                </x-ui.discord.divider>

                <!-- Swarm response -->
                <x-ui.discord.message
                    class="workspace-delivery opacity-0 -translate-y-2"
                    author="openclaw-orchestrator"
                    avatar="OR"
                    avatarBg="bg-rose-600"
                    authorColor="text-rose-450"
                    time="16:49:15"
                    isBot
                >
                    <p class="leading-relaxed font-light">
                        Swarm task complete. We surveyed 214 directories and municipal registers. Identified 15 high-fit commercial targets inside the Cape Town CBD (Bree St. & St. Georges Mall corridors) meeting expansion criteria:
                    </p>

                    <!-- Custom Discord Embed Card for Highlights -->
                    <x-ui.discord.embed title="📍 Executive Target Summary" borderColor="border-[#f43f5e]" class="mt-1.5">
                        <div class="space-y-1">
                            <div>• **Cape Roast Coffee Roasters** (Bree St.) — Retail / Roastery</div>
                            <div>• **CBD Fintech Hubs** (St. Georges Mall) — Professional Services</div>
                            <div>• **Green-Market Artisans** (Long St.) — Import / Export</div>
                        </div>
                    </x-ui.discord.embed>

                    <!-- Attachments Section (Multiple Dossiers) -->
                    <div class="space-y-1.5 mt-1.5">
                        <div class="text-[7px] md:text-[8px] lg:text-[9px] text-slate-500 uppercase font-bold tracking-wider select-none">Attachments (4)</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <x-ui.discord.attachment class="opacity-0 -translate-x-2" filename="CBD_Dossiers.pdf" size="12.4 MB" />
                            <x-ui.discord.attachment class="opacity-0 -translate-x-2" filename="Target_Summary.pdf" size="4.1 MB" />
                            <x-ui.discord.attachment class="opacity-0 -translate-x-2" filename="Sources_Citations.pdf" size="2.8 MB" />
                            <x-ui.discord.attachment class="opacity-0 -translate-x-2" filename="Research_Limits.pdf" size="1.5 MB" />
                        </div>
                    </div>
                </x-ui.discord.message>
            </x-ui.discord.container>



            <!-- Intelligence Panel (Premium Card CTA) -->
            <div x-ref="intelligencePanel"
                class="absolute bottom-16 md:bottom-auto md:top-1/2 md:-translate-y-1/2 right-4 left-4 md:left-auto md:right-8 w-auto md:w-[340px] lg:w-[400px] flex flex-col gap-3 md:gap-4 opacity-0 translate-y-8 md:translate-y-0 md:translate-x-12 z-20 pointer-events-none font-sans">
                <x-ui.intelligence-card title="Multi-Agent Orchestration Grid"
                    description="OpenClaw's Discord module maps bot profiles to LLM agents. Tasks are serialized to the database where Hermes runs research asynchronously, parses .md sheets, and posts outputs back to re-prompt the waiting agent.">
                    <div class="grid grid-cols-2 gap-4">
                        <x-ui.metric-item label="Brokerage" value="OpenClaw Discord" variant="rose" />
                        <x-ui.metric-item label="Research" value="Hermes Async Nodes" variant="cyan" />
                    </div>

                    <div class="mt-4 flex justify-center">
                        <x-ui.glowing-button href="#" variant="rose" class="w-full">
                            Explore the Agent Network
                        </x-ui.glowing-button>
                    </div>
                </x-ui.intelligence-card>
            </div>

    </div>
</div>
