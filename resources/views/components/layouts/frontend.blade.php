@props([
    'title' => config('app.name', 'Portfolio'),
    'description' => 'AI-Augmented Portfolio',
])

<x-layouts.head :title="$title" :description="$description">
    <div class="relative w-full h-screen bg-[#0a0f1c] text-white selection:bg-blue-500 selection:text-white font-sans overflow-hidden flex flex-col">
        {{ $slot }}
    </div>
</x-layouts.head>
