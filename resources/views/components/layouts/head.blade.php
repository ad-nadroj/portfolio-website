@props([
    'title' => config('app.name', 'Portfolio'),
    'description' => 'AI-Augmented Portfolio',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $description }}">
        <meta name="color-scheme" content="light dark">

        <title>{{ $title }}</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">

        @fluxAppearance
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('meta')
        @stack('styles')
        @stack('head')
    </head>
    <body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-900 dark:text-zinc-100">
        {{ $slot }}

        @fluxScripts
        @stack('scripts')
    </body>
</html>
