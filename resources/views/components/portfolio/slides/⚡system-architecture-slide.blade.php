<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div 
    x-data="systemArchitectureStory()" 
    @slide-deactivate.window="if ($event.detail.slide === 'system-architecture') { destroy(); }"
    x-init="$nextTick(() => initAnimation())"
    wire:ignore
    class="w-full h-full flex flex-col items-center justify-start pt-[1.5vh] md:pt-[2vh] pb-24 md:pb-28 relative"
>
        <!-- Narrative Text Wrapper -->
        <div class="w-full h-20 flex-none flex items-center justify-center relative z-30 perspective-1000 mt-2">
            <div class="narrative-text absolute text-center opacity-100 translate-y-0">
                <h2 class="text-xl md:text-3xl font-semibold bg-gradient-to-br from-blue-400 to-blue-600 bg-clip-text text-transparent">
                    Edge Capture & Ingestion
                </h2>
                <p class="text-slate-400 mt-2 text-sm md:text-base font-light">
                    Physical slips scanned via Epson into a FastAPI filesystem watchdog over WebDAV.
                </p>
            </div>

            <div class="narrative-text absolute text-center opacity-0 translate-y-8">
                <h2 class="text-xl md:text-3xl font-semibold bg-gradient-to-br from-purple-400 to-indigo-600 bg-clip-text text-transparent">
                    OCR Parsing & Verification
                </h2>
                <p class="text-slate-400 mt-2 text-sm md:text-base font-light">
                    Python OCR extraction with E2E encrypted handshake to Laravel's two-tier idempotency gate.
                </p>
            </div>

            <div class="narrative-text absolute text-center opacity-0 translate-y-8">
                <h2 class="text-xl md:text-3xl font-semibold bg-gradient-to-br from-cyan-400 to-cyan-650 bg-clip-text text-transparent">
                    Cloud Synchronization
                </h2>
                <p class="text-slate-400 mt-2 text-sm md:text-base font-light">
                    Verified ledger entries synced to public cloud dashboards with spend and payment metrics.
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
                <path class="flow-pulse-1 hidden md:block stroke-blue-500/70" fill="none" stroke-width="1.5" stroke-dasharray="8 20" style="vector-effect: non-scaling-stroke;"
                      d="M 25 50 Q 37.5 45, 50 50" />
                <path class="flow-pulse-2 hidden md:block stroke-cyan-400/70" fill="none" stroke-width="1.5" stroke-dasharray="8 20" style="vector-effect: non-scaling-stroke;"
                      d="M 50 50 Q 62.5 55, 75 50" />

                <!-- Mobile Paths (Vertical) -->
                <path class="flow-path-1-mobile md:hidden stroke-slate-700/30" fill="none" stroke-width="1" stroke-dasharray="4 4" style="vector-effect: non-scaling-stroke;"
                      d="M 50 25 Q 45 37.5, 50 50" />
                <path class="flow-path-2-mobile md:hidden stroke-slate-700/30" fill="none" stroke-width="1" stroke-dasharray="4 4" style="vector-effect: non-scaling-stroke;"
                      d="M 50 50 Q 55 62.5, 50 75" />
                <path class="flow-pulse-1-mobile md:hidden stroke-blue-500/70" fill="none" stroke-width="1.5" stroke-dasharray="8 20" style="vector-effect: non-scaling-stroke;"
                      d="M 50 25 Q 45 37.5, 50 50" />
                <path class="flow-pulse-2-mobile md:hidden stroke-cyan-400/70" fill="none" stroke-width="1.5" stroke-dasharray="8 20" style="vector-effect: non-scaling-stroke;"
                      d="M 50 50 Q 55 62.5, 50 75" />
            </svg>
            
            <!-- Edge Ingestion / Scanner Area (Left) -->
            <div x-ref="scannerContainer" class="w-full md:w-[29%] lg:w-1/3 h-44 md:h-full relative border border-white/10 rounded-2xl bg-[#0c1225]/95 p-4 shadow-[0_8px_32px_rgba(0,0,0,0.3)]">
                <div class="absolute top-4 left-6 text-[10px] md:text-xs font-mono text-slate-400 tracking-widest uppercase flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse shadow-[0_0_8px_rgba(59,130,246,0.8)]"></span>
                    Edge Capture (Epson)
                </div>
                
                <!-- Scanner Visual (Centered SVG) -->
                <div class="scanner-device absolute top-[35%] left-[10%] w-20 h-20 text-blue-500/80">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9s2.015-9 4.5-9m0 0a9.003 9.003 0 018.716 6.747M12 3a9.003 9.003 0 00-8.716 6.747" />
                    </svg>
                </div>

                <!-- WebDAV holding area -->
                <div class="absolute right-6 top-[20%] bottom-[20%] w-32 border border-dashed border-slate-700/60 rounded-xl bg-slate-900/50 p-2.5 flex flex-col gap-1.5 justify-center overflow-hidden">
                    <div class="text-[8px] font-mono text-slate-500 text-center uppercase tracking-wider">WebDAV Queue</div>
                    <div class="webdav-queue-slot relative w-full h-24 flex flex-col gap-1 justify-center items-center">
                        <div class="receipt-item w-20 h-4 bg-slate-800 border border-slate-700 rounded text-[7px] font-mono flex items-center justify-center text-slate-400 select-none shadow-sm opacity-0 transform translate-x-4">
                            DOC_#001
                        </div>
                        <div class="receipt-item w-20 h-4 bg-slate-800 border border-slate-700 rounded text-[7px] font-mono flex items-center justify-center text-slate-400 select-none shadow-sm opacity-0 transform translate-x-4">
                            DOC_#002
                        </div>
                        <div class="receipt-item w-20 h-4 bg-slate-800 border border-slate-700 rounded text-[7px] font-mono flex items-center justify-center text-slate-400 select-none shadow-sm opacity-0 transform translate-x-4">
                            DOC_#003
                        </div>
                    </div>
                </div>

                <!-- Tech Badges -->
                <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 flex gap-2 opacity-0 tech-badge-1">
                    <x-ui.tech-badge variant="blue">Epson Scan</x-ui.tech-badge>
                    <x-ui.tech-badge variant="slate">WebDAV</x-ui.tech-badge>
                </div>
            </div>

            <!-- Double Processor Engine / Validation Gate (Center) -->
            <div x-ref="engineContainer" class="relative w-56 md:w-[22%] lg:w-1/4 h-52 md:h-[320px] flex flex-col justify-between gap-4 z-20">
                <!-- Python OCR Block -->
                <div id="ocr-block" class="relative w-full h-[47%] border border-purple-500/20 bg-purple-950/25 rounded-2xl flex flex-col items-center justify-center overflow-hidden shadow-[0_0_20px_rgba(168,85,247,0.1)] transform-gpu">
                    <div class="ocr-scan-line absolute top-0 left-0 w-full h-[2px] bg-purple-400 opacity-0 shadow-[0_0_8px_rgba(168,85,247,1)]"></div>
                    <svg class="w-7 h-7 text-purple-400 mb-2 ocr-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h.01M16 16h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-purple-300 font-mono tracking-widest text-[9px] uppercase font-semibold">Python OCR Engine</span>
                </div>

                <!-- Laravel Verifier Block -->
                <div id="verifier-block" class="relative w-full h-[47%] border border-indigo-500/20 bg-indigo-950/25 rounded-2xl flex flex-col items-center justify-center overflow-hidden shadow-[0_0_20px_rgba(99,102,241,0.15)] transform-gpu">
                    <!-- Green Glow / Verification overlay -->
                    <div class="verifier-glow absolute inset-0 bg-emerald-500/10 opacity-0 transition-opacity"></div>
                    <div class="verifier-border absolute inset-0 border border-emerald-500 rounded-2xl opacity-0 transition-opacity shadow-[0_0_30px_rgba(16,185,129,0.4)]"></div>

                    <svg class="w-7 h-7 text-indigo-400 mb-2 verifier-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span class="verifier-text text-indigo-300 font-mono tracking-widest text-[9px] uppercase font-semibold">Laravel Idempotency Gate</span>
                    <span class="verifier-status-label absolute bottom-2 text-[8px] font-mono text-emerald-400 uppercase tracking-widest opacity-0 font-bold">Verified</span>
                </div>

                <!-- Tech Badges -->
                <div class="absolute -bottom-12 left-1/2 -translate-x-1/2 flex gap-2 opacity-0 tech-badge-2">
                    <x-ui.tech-badge variant="purple">Python</x-ui.tech-badge>
                    <x-ui.tech-badge variant="blue">Laravel</x-ui.tech-badge>
                </div>
            </div>

            <!-- Cloud Destination Dashboard (Right) -->
            <div id="cloud-container" x-ref="cloudContainer" class="w-full md:w-[29%] lg:w-1/3 h-44 md:h-full flex flex-col justify-center border border-white/10 rounded-2xl bg-[#0c1225]/95 p-4 md:p-6 shadow-[0_8px_32px_rgba(0,0,0,0.3)] relative opacity-0">
                <div class="absolute top-4 right-6 text-[10px] md:text-xs font-mono text-slate-400 tracking-widest uppercase flex items-center gap-2">
                    Cloud Synchronized
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_8px_rgba(34,211,238,0.8)]"></span>
                </div>
                
                <!-- Dashboard Chart Visualization -->
                <div class="w-full bg-slate-900/50 border border-slate-800/80 rounded-xl p-3.5 mt-4 space-y-3.5 font-mono text-[10px]">
                    <div class="flex justify-between text-slate-500 border-b border-slate-800 pb-1.5 text-[9px]">
                        <span>LEDGER STATE</span>
                        <span class="text-cyan-400 font-bold uppercase">Sync Done</span>
                    </div>
                    
                    <div class="space-y-3.5">
                        <!-- Spent Bar -->
                        <div class="space-y-1">
                            <div class="flex justify-between text-slate-400 text-[8px]">
                                <span>MONTHLY SPEND</span>
                                <span class="text-indigo-400 font-bold">$12,450.80</span>
                            </div>
                            <div class="w-full h-3 bg-slate-800 rounded overflow-hidden border border-slate-700/50">
                                <div class="spend-bar h-full bg-gradient-to-r from-indigo-600 to-indigo-400 origin-left scale-x-0"></div>
                            </div>
                        </div>

                        <!-- Paid Bar -->
                        <div class="space-y-1">
                            <div class="flex justify-between text-slate-400 text-[8px]">
                                <span>ACCOUNTS PAID</span>
                                <span class="text-cyan-400 font-bold">$9,120.00</span>
                            </div>
                            <div class="w-full h-3 bg-slate-800 rounded overflow-hidden border border-slate-700/50">
                                <div class="paid-bar h-full bg-gradient-to-r from-cyan-600 to-cyan-400 origin-left scale-x-0"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tech Badges -->
                <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 flex gap-2 opacity-0 tech-badge-3">
                    <x-ui.tech-badge variant="cyan">AWS Cloud</x-ui.tech-badge>
                </div>
            </div>

            <!-- Travelling Receipt Card (Floating) -->
            <div id="travelling-receipt" class="absolute w-16 h-20 bg-slate-950 border border-slate-700/80 rounded-lg p-2 shadow-2xl flex flex-col justify-between font-mono text-[5px] text-slate-400 opacity-0 z-30 pointer-events-none">
                <div class="flex justify-between border-b border-slate-850 pb-1 font-bold">
                    <span>DOC</span>
                    <span class="text-blue-400">#99A</span>
                </div>
                <div class="space-y-0.5">
                    <div>TAX: $4.50</div>
                    <div class="font-bold text-white">TOTAL: $45.00</div>
                </div>
                <div class="text-[4px] text-slate-650 text-center">IDEM: FA92C...</div>
            </div>

            <!-- Intelligence Panel (Premium Card CTA) -->
            <div x-ref="intelligencePanel" class="absolute bottom-16 md:bottom-auto md:top-1/2 md:-translate-y-1/2 right-4 left-4 md:left-auto md:right-8 w-auto md:w-[340px] lg:w-[400px] flex flex-col gap-3 md:gap-4 opacity-0 translate-y-8 md:translate-y-0 md:translate-x-12 z-20 pointer-events-none font-sans">
                <x-ui.intelligence-card 
                    title="Two-Tier Idempotency Protocol" 
                    description="Tier 1 blocks duplicates using image hash comparison. Tier 2 matches extracted OCR parameters—vendor, date, and totals. Low-confidence parses flag manual reconciliation before cloud sync."
                >
                    <div class="grid grid-cols-2 gap-4">
                        <x-ui.metric-item label="Tier 1" value="Image Hash Dedup" variant="blue" />
                        <x-ui.metric-item label="Tier 2" value="OCR Param Matching" variant="cyan" />
                    </div>

                    <div class="mt-4 flex justify-center">
                        <x-ui.glowing-button href="#" variant="blue" class="w-full">
                            Explore the OCR Pipeline
                        </x-ui.glowing-button>
                    </div>
                </x-ui.intelligence-card>
            </div>

        </div>
</div>