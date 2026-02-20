<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FEU-OSDMS | Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full antialiased selection:bg-[#004d32] selection:text-[#FECB02]" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen bg-[#F8FAFB] relative overflow-x-hidden">

        <div x-show="sidebarOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 z-50 w-80 shadow-2xl">
            @include('layouts.navigation')
        </div>

        <main class="transition-all duration-300 ease-in-out min-h-screen"
              :class="sidebarOpen ? 'pl-80' : 'pl-0'">
            {{ $slot }}
        </main>
    </div>
    @stack('scripts')
</body>
</html>
