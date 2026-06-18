@props([
    'title' => config('app.name', 'Portfolio'),
    'description' => 'AI-Augmented Portfolio',
])

<x-layouts.head :title="$title" :description="$description">
    {{ $slot }}
</x-layouts.head>
