@props([
    'title' => config('app.name', 'Portfolio'),
    'description' => 'AI-Augmented Portfolio',
])

<x-layouts.head :title="$title" :description="$description">
    <x-layouts.sidebar :app-name="config('app.name', 'Portfolio')">
        {{ $slot }}
    </x-layouts.sidebar>
</x-layouts.head>
