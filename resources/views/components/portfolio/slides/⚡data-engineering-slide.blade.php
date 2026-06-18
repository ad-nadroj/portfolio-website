<?php

use Livewire\Component;

new class extends Component
{
    // Livewire state/analytics can be added here
};
?>

<div 
    x-data="dataPipelineStory()" 
    @slide-deactivate.window="if ($event.detail.slide === 'data-engineering') { destroy(); }"
    x-init="$nextTick(() => initAnimation())"
    wire:ignore
    class="w-full h-full flex flex-col items-center justify-start pt-[1.5vh] md:pt-[2vh] pb-24 md:pb-28 relative"
>
        <!-- Narrative Text Wrapper -->
        <div class="w-full h-20 flex-none flex items-center justify-center relative z-30 perspective-1000 mt-2">
            <div class="narrative-text absolute text-center opacity-100 translate-y-0">
                <h2 class="text-xl md:text-3xl font-semibold bg-gradient-to-br from-rose-400 to-rose-600 bg-clip-text text-transparent">
                    Real-time Ingestion
                </h2>
                <p class="text-slate-400 mt-2 text-sm md:text-base font-light">
                    Debezium monitors MySQL binary logs, streaming row-level mutations via Kafka Connect.
                </p>
            </div>

            <div class="narrative-text absolute text-center opacity-0 translate-y-8">
                <h2 class="text-xl md:text-3xl font-semibold bg-gradient-to-br from-blue-400 to-blue-600 bg-clip-text text-transparent">
                    Streaming Transformation
                </h2>
                <p class="text-slate-400 mt-2 text-sm md:text-base font-light">
                    dbt orchestrates staging views, SCD2 dimensional tracking, and materialized fact tables.
                </p>
            </div>

            <div class="narrative-text absolute text-center opacity-0 translate-y-8">
                <h2 class="text-xl md:text-3xl font-semibold bg-gradient-to-br from-cyan-400 to-cyan-600 bg-clip-text text-transparent">
                    Structured Intelligence
                </h2>
                <p class="text-slate-400 mt-2 text-sm md:text-base font-light">
                    Statistical data marts delivering real-time risk rankings and time-to-pay analytics.
                </p>
            </div>
        </div>

        <!-- Main Visualization Area -->
        <div class="relative w-full max-w-6xl h-[420px] md:h-[48vh] lg:h-[50vh] xl:h-[52vh] md:min-h-[380px] md:max-h-[560px] flex flex-col md:flex-row items-center justify-between px-4 md:px-12 gap-8 md:gap-0 mt-4 xl:mt-8">
            
            <!-- SVG Connective Paths (z-0 backdrop) -->
            <svg class="absolute inset-0 w-full h-full pointer-events-none z-0" viewBox="0 0 100 100" preserveAspectRatio="none">
                <!-- Desktop Paths (Horizontal) -->
                <path class="flow-path-1 hidden md:block stroke-slate-700/30" fill="none" stroke-width="1" stroke-dasharray="4 4" style="vector-effect: non-scaling-stroke;"
                      d="M 25 50 Q 37.5 45, 50 50" />
                <path class="flow-path-2 hidden md:block stroke-slate-700/30" fill="none" stroke-width="1" stroke-dasharray="4 4" style="vector-effect: non-scaling-stroke;"
                      d="M 50 50 Q 62.5 55, 75 50" />
                <path class="flow-pulse-1 hidden md:block stroke-rose-500/70" fill="none" stroke-width="1.5" stroke-dasharray="8 20" style="vector-effect: non-scaling-stroke;"
                      d="M 25 50 Q 37.5 45, 50 50" />
                <path class="flow-pulse-2 hidden md:block stroke-cyan-400/70" fill="none" stroke-width="1.5" stroke-dasharray="8 20" style="vector-effect: non-scaling-stroke;"
                      d="M 50 50 Q 62.5 55, 75 50" />

                <!-- Mobile Paths (Vertical) -->
                <path class="flow-path-1-mobile md:hidden stroke-slate-700/30" fill="none" stroke-width="1" stroke-dasharray="4 4" style="vector-effect: non-scaling-stroke;"
                      d="M 50 25 Q 45 37.5, 50 50" />
                <path class="flow-path-2-mobile md:hidden stroke-slate-700/30" fill="none" stroke-width="1" stroke-dasharray="4 4" style="vector-effect: non-scaling-stroke;"
                      d="M 50 50 Q 55 62.5, 50 75" />
                <path class="flow-pulse-1-mobile md:hidden stroke-rose-500/70" fill="none" stroke-width="1.5" stroke-dasharray="8 20" style="vector-effect: non-scaling-stroke;"
                      d="M 50 25 Q 45 37.5, 50 50" />
                <path class="flow-pulse-2-mobile md:hidden stroke-cyan-400/70" fill="none" stroke-width="1.5" stroke-dasharray="8 20" style="vector-effect: non-scaling-stroke;"
                      d="M 50 50 Q 55 62.5, 50 75" />
            </svg>
            
            <!-- OLTP Source Area (Chaos) -->
            <div x-ref="oltpContainer" class="w-full md:w-[29%] lg:w-1/3 h-44 md:h-full relative border border-white/10 rounded-2xl bg-[#0c1225]/95 p-4 shadow-[0_8px_32px_rgba(0,0,0,0.3)] will-change-transform-gpu">
                <div class="absolute top-4 left-6 text-[10px] md:text-xs font-mono text-slate-400 tracking-widest uppercase flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse shadow-[0_0_8px_rgba(244,63,94,0.8)]"></span>
                    Raw OLTP Sources
                </div>
                <template x-for="i in 35" :key="i">
                    <!-- Outer wrapper for ScrollTrigger to avoid transform conflicts -->
                    <div class="oltp-node-wrapper absolute"
                         :style="`top: ${Math.random() * 70 + 20}%; left: ${Math.random() * 80 + 10}%;`">
                        <div class="oltp-node w-2 h-2 md:w-3 md:h-3 bg-rose-500 rounded-full shadow-[0_0_6px_rgba(244,63,94,0.7)]">
                        </div>
                    </div>
                </template>

                <!-- Tech Badges -->
                <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 flex gap-2 opacity-0 tech-badge-1">
                    <x-ui.tech-badge variant="slate">MySQL</x-ui.tech-badge>
                    <x-ui.tech-badge variant="slate">Debezium</x-ui.tech-badge>
                </div>
            </div>

            <!-- Pipeline / Processor Wrapper -->
            <div x-ref="pipelineWrapper" class="relative w-48 md:w-[22%] lg:w-1/4 h-24 md:h-40 flex flex-col items-center justify-center shrink-0 z-20">
                <!-- Pipeline / Processor (Order) -->
                <div id="pipeline-processor" x-ref="pipeline" class="relative w-full h-full border border-slate-700/60 bg-slate-900/95 rounded-2xl flex flex-col items-center justify-center overflow-hidden transform-gpu shadow-[0_0_40px_rgba(0,0,0,0.6)]">
                    <!-- Performant Glow Overlay -->
                    <div class="pipeline-glow absolute inset-0 bg-slate-800/90 opacity-0 transition-none pointer-events-none"></div>
                    <div class="pipeline-border absolute inset-0 border-2 border-blue-400/80 rounded-2xl opacity-0 transition-none pointer-events-none shadow-[0_0_50px_rgba(59,130,246,0.6)]"></div>

                    <!-- Scanning line effect -->
                    <div class="pipeline-scan absolute top-0 left-0 w-full h-[2px] bg-blue-400 shadow-[0_0_15px_rgba(96,165,250,1)] opacity-0"></div>
                    
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-blue-400 mb-3 pipeline-icon drop-shadow-[0_0_10px_rgba(96,165,250,0.5)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span class="text-slate-300 font-mono tracking-widest text-[10px] md:text-xs uppercase z-10 font-semibold">Kafka / dbt</span>
                </div>

                <!-- Output connection line (placed outside overflow-hidden) -->
                <div id="output-line" x-ref="outputLine" class="hidden md:block absolute -right-12 top-1/2 w-12 h-0.5 bg-gradient-to-r from-blue-500 to-transparent origin-left scale-x-0 opacity-0 z-0"></div>

                <!-- Tech Badges -->
                <div class="absolute -bottom-12 left-1/2 -translate-x-1/2 flex gap-2 opacity-0 tech-badge-2">
                    <x-ui.tech-badge variant="blue">Kafka</x-ui.tech-badge>
                    <x-ui.tech-badge variant="rose">dbt</x-ui.tech-badge>
                </div>
            </div>

            <!-- OLAP Destination (Structure) -->
            <div id="olap-container" x-ref="olapContainer" class="w-full md:w-[29%] lg:w-1/3 h-44 md:h-full flex flex-col justify-center gap-3 md:gap-4 opacity-0 md:pl-8 border border-white/10 rounded-2xl bg-[#0c1225]/95 p-4 md:p-6 shadow-[0_8px_32px_rgba(0,0,0,0.3)] relative">
                <div class="absolute top-4 right-6 text-[10px] md:text-xs font-mono text-slate-400 tracking-widest uppercase flex items-center gap-2">
                    Structured Marts
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_8px_rgba(34,211,238,0.8)]"></span>
                </div>
                <!-- Data bars -->
                <div class="relative w-full h-8 md:h-10 bg-slate-800/60 rounded-lg overflow-hidden border border-slate-700/50 group">
                    <div class="olap-mart absolute top-0 left-0 h-full w-full bg-gradient-to-r from-blue-600 to-blue-400 origin-left scale-x-0 group-hover:brightness-110 transition-[filter] duration-200"></div>
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] md:text-xs font-mono font-medium text-white/90 z-10 opacity-0 olap-label drop-shadow-md">risk_ranking_mart</span>
                </div>
                <div class="relative w-full h-8 md:h-10 bg-slate-800/60 rounded-lg overflow-hidden border border-slate-700/50 group">
                    <div class="olap-mart absolute top-0 left-0 h-full w-5/6 bg-gradient-to-r from-indigo-600 to-indigo-400 origin-left scale-x-0 group-hover:brightness-110 transition-[filter] duration-200"></div>
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] md:text-xs font-mono font-medium text-white/90 z-10 opacity-0 olap-label drop-shadow-md">time_to_pay_fct</span>
                </div>
                <div class="relative w-full h-8 md:h-10 bg-slate-800/60 rounded-lg overflow-hidden border border-slate-700/50 group">
                    <div class="olap-mart absolute top-0 left-0 h-full w-4/6 bg-gradient-to-r from-cyan-600 to-cyan-400 origin-left scale-x-0 group-hover:brightness-110 transition-[filter] duration-200"></div>
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] md:text-xs font-mono font-medium text-white/90 z-10 opacity-0 olap-label drop-shadow-md">customer_scd2_dim</span>
                </div>
                <div class="relative w-full h-8 md:h-10 bg-slate-800/60 rounded-lg overflow-hidden border border-slate-700/50 group">
                    <div class="olap-mart absolute top-0 left-0 h-full w-full bg-gradient-to-r from-sky-600 to-sky-400 origin-left scale-x-0 group-hover:brightness-110 transition-[filter] duration-200"></div>
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] md:text-xs font-mono font-medium text-white/90 z-10 opacity-0 olap-label drop-shadow-md">invoice_events_fct</span>
                </div>

                <!-- Tech Badges -->
                <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 flex gap-2 opacity-0 tech-badge-3">
                    <x-ui.tech-badge variant="cyan">PostgreSQL</x-ui.tech-badge>
                </div>
            </div>

            <!-- Debezium Live CDC Stream Log Container -->
            <div x-ref="cdcLogContainer" class="absolute right-4 md:right-12 top-1/2 -translate-y-1/2 w-auto left-4 md:left-auto md:w-[29%] lg:w-1/3 h-44 md:h-full flex flex-col justify-start opacity-30 md:opacity-100 z-10 pointer-events-none overflow-hidden">
                <div class="text-[10px] md:text-xs font-mono text-slate-500 tracking-widest uppercase mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M4 18h16a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Debezium Event Stream
                </div>

                <div class="relative w-full flex-1 mask-linear-fade">
                    <div class="cdc-log-track absolute top-0 left-0 w-full flex flex-col gap-2 font-mono text-[10px] md:text-xs text-slate-400/70">
                        <!-- Will be dynamically populated via startCDCStream in app.js -->
                    </div>
                </div>
            </div>

            <!-- Intelligence Panel (Premium Card CTA) -->
            <div x-ref="intelligencePanel" class="absolute bottom-16 md:bottom-auto md:top-1/2 md:-translate-y-1/2 right-4 left-4 md:left-auto md:right-8 w-auto md:w-[340px] lg:w-[400px] flex flex-col gap-3 md:gap-4 opacity-0 translate-y-8 md:translate-y-0 md:translate-x-12 z-20 pointer-events-none font-sans">
                <x-ui.intelligence-card 
                    title="CDC-Driven Analytics Warehouse" 
                    description="Real-time CDC streams mutations from MySQL OLTP to PostgreSQL OLAP. dbt manages SCD2 change tracking across dimensional models, materializing facts and metrics marts."
                >
                    <div class="grid grid-cols-2 gap-4">
                        <x-ui.metric-item label="Tracked" value="Weighted Risk Rankings" variant="cyan" />
                        <x-ui.metric-item label="Computed" value="Time-to-Pay Deltas" variant="blue" />
                    </div>

                    <div class="mt-4 flex justify-center">
                        <x-ui.glowing-button href="#" variant="blue" class="w-full">
                            Explore the Data Pipeline
                        </x-ui.glowing-button>
                    </div>
                </x-ui.intelligence-card>
            </div>

        </div>
</div>